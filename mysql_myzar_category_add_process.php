<?php
include "mysql_config.php";

if(isset($_REQUEST["tableID"]) && isset($_REQUEST["uid"]) && isset($_REQUEST["title"]) && isset($_FILES["iconfile"]) && isset($_REQUEST["parentID"])){
	InsertCategoryEntry($_REQUEST["tableID"], $_REQUEST["uid"], $_REQUEST["title"], $_FILES["iconfile"], $_REQUEST["parentID"]);
}
if(isset($_REQUEST["tableID"]) && isset($_REQUEST["uid"]) && isset($_REQUEST["title"]) && !isset($_FILES["iconfile"]) && isset($_REQUEST["parentID"])){
	InsertCategoryEntry($_REQUEST["tableID"], $_REQUEST["uid"], $_REQUEST["title"], null, $_REQUEST["parentID"]);
}
else {
	echo "Ангиллыг нэмхэд алдаа гарлаа!";
}

function InsertCategoryEntry($pTableID, $pUID , $pTitle, $pFile, $pParentID){
	global $conn;
	
	$IsInsertCategoryOK = true;
	if($pParentID == 0){
		$IsInsertCategoryOK = IsCategoryExist($pTableID, $pTitle, null);
	}
	else {
		$IsInsertCategoryOK = IsCategoryExist($pTableID, $pTitle, $pParentID);
	}
	
	if($IsInsertCategoryOK){
		if(!is_null($pFile)){
			$vNewFile = date("Ymdhis")."_".$pFile["name"];
			if (move_uploaded_file($pFile["tmp_name"], "user_files/".$vNewFile)) {
				$queryInsert = "";
				if($pParentID == 0){
					$queryInsert = "INSERT INTO category".$pTableID."(uid, title, icon) VALUES('".$pUID."','".$pTitle."','".$vNewFile."')";
				}
				else {
					$queryInsert = "INSERT INTO category".$pTableID."(uid, title, icon, parent) VALUES('".$pUID."','".$pTitle."','".$vNewFile."',".$pParentID.")";
				}
				$resultInsert = $conn->query($queryInsert);

				if ($conn->connect_error) {
					die("<InsertCategoryEntry>:".$conn->connect_error);
				}

				if($resultInsert){
					echo "OK";
				}
				else {
					echo "<InsertCategoryEntry>:insert is failed!";
				}
			} else {
				echo "<InsertCategoryEntry>:image file is failed to be uploaded!";
			}
		}
		else {
			$queryInsert = "";
			if($pParentID == 0){
				echo $queryInsert = "INSERT INTO category".$pTableID."(uid, title) VALUES('".$pUID."','".$pTitle."')";
			}
			else {
				echo $queryInsert = "INSERT INTO category".$pTableID."(uid, title, parent) VALUES('".$pUID."','".$pTitle."',".$pParentID.")";
			}
			$resultInsert = $conn->query($queryInsert);

			if ($conn->connect_error) {
				die("<InsertCategoryEntry>:".$conn->connect_error);
			}

			if($resultInsert){
				echo "OK";
			}
			else {
				echo "<InsertCategoryEntry>:insert is failed!";
			}
		}
	}
	else {
		echo "Таны оруулсан ангилал жагсаалтанд байсан байна!";
	}
}

function IsCategoryExist($pTableID, $pTitle, $pParentID){
	global $conn;
	$queryCategoryExist = "";
	if(!isset($pParentID)){
		$queryCategoryExist = "SELECT * FROM category".$pTableID." WHERE title='".$pTitle."'";
	}
	else {
		$queryCategoryExist = "SELECT * FROM category".$pTableID." WHERE title='".$pTitle."' AND parent=".$pParentID;
	}
	$resultCategoryExist = $conn->query($queryCategoryExist);
	if($resultCategoryExist){
		$rowsCategoryExist = mysqli_num_rows($resultCategoryExist);
		if($rowsCategoryExist == 0){
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
}

mysqli_close($conn);
?>