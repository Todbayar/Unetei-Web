<?php
include "mysql_config.php";

if(isset($_REQUEST["id"]) && isset($_REQUEST["tableID"]) && isset($_REQUEST["title"]) && isset($_FILES["iconfile"]) && isset($_REQUEST["parentID"])){
	EditCategoryEntry($_REQUEST["id"], $_REQUEST["tableID"], $_COOKIE["userID"], $_REQUEST["title"], $_FILES["iconfile"], $_REQUEST["parentID"], $_REQUEST["words"]);
}
else if(isset($_REQUEST["id"]) && isset($_REQUEST["tableID"]) && isset($_REQUEST["title"]) && !isset($_FILES["iconfile"]) && isset($_REQUEST["parentID"])){
	EditCategoryEntry($_REQUEST["id"], $_REQUEST["tableID"], $_COOKIE["userID"], $_REQUEST["title"], null, $_REQUEST["parentID"], $_REQUEST["words"]);
}
else {
	echo "Ангиллыг нэмхэд алдаа гарлаа!";
}

function EditCategoryEntry($pID, $pTableID, $pUID , $pTitle, $pFile, $pParentID, $pWords){
	global $conn;
	
	if(!is_null($pFile)){
		$vNewFile = date("Ymdhis")."_".$pFile["name"];
		if (move_uploaded_file($pFile["tmp_name"], "user_files/".$vNewFile)) {
			$queryUpdate = "";
			if($pParentID == 0){
				$queryUpdate = "UPDATE category".$pTableID." SET userID=".$pUID.", title='".$pTitle."', words='".$pWords."', icon='".$vNewFile."' WHERE id=".$pID;
			}
			else {
				$queryUpdate = "UPDATE category".$pTableID." SET userID=".$pUID.", title='".$pTitle."', words='".$pWords."', icon='".$vNewFile."', parent=".$pParentID." WHERE id=".$pID;
			}
			$resultUpdate = $conn->query($queryUpdate);

			if ($conn->connect_error) {
				die("<InsertCategoryEntry>:".$conn->connect_error);
			}

			if($resultUpdate){
				echo "OK";
			}
			else {
				echo "<InsertCategoryEntry>:update is failed!";
			}
		} 
		else {
			echo "<InsertCategoryEntry>:image file is failed to be uploaded!";
		}
	}
	else {
		$queryUpdate = "";
		if($pParentID == 0){
			$queryUpdate = "UPDATE category".$pTableID." SET userID=".$pUID.", title='".$pTitle."', words='".$pWords."' WHERE id=".$pID;
		}
		else {
			$queryUpdate = "UPDATE category".$pTableID." SET userID=".$pUID.", title='".$pTitle."', words='".$pWords."', parent=".$pParentID." WHERE id=".$pID;
		}
		$resultUpdate = $conn->query($queryUpdate);

		if ($conn->connect_error) {
			die("<InsertCategoryEntry>:".$conn->connect_error);
		}

		if($resultUpdate){
			echo "OK";
		}
		else {
			echo "<InsertCategoryEntry>:update is failed!";
		}
	}
}

mysqli_close($conn);
?>