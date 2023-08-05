<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "chat_process.php";
include_once "info.php";

$queryFetchItems = "SELECT * FROM item WHERE NOW()>(datetime + INTERVAL expire_days DAY)";
$resultFetchItems = @$conn->query($queryFetchItems);
while($rowFetchItems = mysqli_fetch_array($resultFetchItems)){
	$id = $rowFetchItems["id"];
	
	if($rowFetchItems["isactive"]==0){
		//removes all files
		if($rowFetchItems["video"]!="" && !is_null($rowFetchItems["video"]) && file_exists($path."/".$rowFetchItems["video"])) @unlink($path."/".$rowFetchItems["video"]);

		$queryImagesDelete = "SELECT * FROM images WHERE item=".$id;
		$resultImagesDelete = $conn->query($queryImagesDelete);
		while($rowImagesDelete = mysqli_fetch_array($resultImagesDelete)){
			if(file_exists($path."/".$rowImagesDelete["image"])) @unlink($path."/".$rowImagesDelete["image"]);
		}

		//removes all records
		@$conn->query("DELETE FROM item WHERE id=".$id);
		@$conn->query("DELETE FROM chat WHERE (type=2 OR type=0) AND (fromID=".$rowFetchItems["userID"]." OR toID=".$rowFetchItems["userID"].")");
		@$conn->query("DELETE FROM favorite WHERE itemID=".$id);
		@$conn->query("DELETE FROM images WHERE item=".$id);
	}
	else if($rowFetchItems["isactive"]==4){
		$queryInactive = "UPDATE item SET datetime='".date("Y-m-d h:i:s")."', expire_days=".$days_item_remove.", isactive=0, boost=NULL WHERE id=".$id;
		if($conn->query($queryInactive)){
			$message = $rowFetchItems["title"]." (#".$rowFetchItems["id"].")<br/>";		
			$categoryTitles = harvestCategory($rowFetchItems["category"]);
			$message .= "<div style=\"font-size:12px; color:gray; margin-top:2px\">".implode("<i class=\"fas fa-angle-right\" style=\"font-size:10px; margin-left:2px; margin-right:2px\"></i>",$categoryTitles)."</div>";
			$message .= "<div style=\"font-size:12px; color:gray; margin-top:2px\"><b>Идэвхгүй болов</b></div>";
			chat_send($rowFetchItems["userID"], $rowFetchItems["userID"], 0, $message, false);
			
			$toEmail = getEmail($rowFetchItems["userID"]);
			$toPhone = getPhone($rowFetchItems["userID"]);
			$toName = getName($rowFetchItems["userID"]);
			sendEmail($toEmail,$smtp_username,$toName,$domain,$toPhone,$service_phone,"Мэдэгдэл",$message,null);
		}
	}
}
?>