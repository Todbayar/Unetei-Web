<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";

if(isset($_GET["superduperadminphone"]) && $_GET["superduperadminphone"]==$superduperadmin){
	$query = "SELECT * FROM chat WHERE isNotified=0";
	$result = $conn->query($query);
	while($row = mysqli_fetch_array($result)){
		$fromID = $row["fromID"];
		$toID = $row["toID"];
		$isSend = $row["isRead"]==0?true:false;
		if(!is_null($row["action"]) && intval($row["action"])==RESPOND){
			$fromID = $row["toID"];
			$toID = $row["fromID"];
			$isSend = true;
		}
		
		if($isSend){
			$fromEmail = getEmail($fromID);
			$toEmail = getEmail($toID);
			$fromPhone = getPhone($fromID);
			$toPhone = getPhone($toID);
			$fromName = getName($fromID);
			$toName = getName($toID);
			if($toEmail!="" && !is_null($toEmail) && $fromID!=$toID){
				if(sendEmail($toEmail,$fromEmail,$toName,$fromName,$toPhone,$fromPhone,"Мэдэгдэл","")){
					@$conn->query("UPDATE chat SET isNotified=1, action=null WHERE id=".$row["id"]);
				}
				else {
					echo "Sending email notification is failed";
				}
			}
		}
	}
}
else {
	echo "Error";
}
?>