<?php
include "mysql_config.php";
include "chat_process";

if(isset($_REQUEST["tableID"]) && isset($_REQUEST["title"]) && isset($_FILES["iconfile"]) && isset($_REQUEST["parentID"])){
	InsertCategoryEntry($_REQUEST["tableID"], $_COOKIE["userID"], $_REQUEST["title"], $_FILES["iconfile"], $_REQUEST["parentID"], $_REQUEST["words"]);
}
else if(isset($_REQUEST["tableID"]) && isset($_REQUEST["title"]) && !isset($_FILES["iconfile"]) && isset($_REQUEST["parentID"])){
	InsertCategoryEntry($_REQUEST["tableID"], $_COOKIE["userID"], $_REQUEST["title"], null, $_REQUEST["parentID"], $_REQUEST["words"]);
}
else {
	echo "Ангиллыг нэмхэд алдаа гарлаа!";
}

function InsertCategoryEntry($pTableID, $pUID , $pTitle, $pFile, $pParentID, $pWords){
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
					$queryInsert = "INSERT INTO category".$pTableID."(userID, title, words, icon) VALUES('".$pUID."','".$pTitle."','".$pWords."','".$vNewFile."')";
				}
				else {
					$queryInsert = "INSERT INTO category".$pTableID."(userID, title, words, icon, parent) VALUES('".$pUID."','".$pTitle."','".$pWords."', '".$vNewFile."',".$pParentID.")";
				}
				$resultInsert = $conn->query($queryInsert);

				if ($conn->connect_error) {
					die("<InsertCategoryEntry>:".$conn->connect_error);
				}

				if($resultInsert){
					chat_send($pUID, 0, 1, mysqli_insert_id($conn));
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
				echo $queryInsert = "INSERT INTO category".$pTableID."(userID, title, words) VALUES('".$pUID."','".$pTitle."','".$pWords."')";
			}
			else {
				echo $queryInsert = "INSERT INTO category".$pTableID."(userID, title, words, parent) VALUES('".$pUID."','".$pTitle."','".$pWords."',".$pParentID.")";
			}
			$resultInsert = $conn->query($queryInsert);

			if ($conn->connect_error) {
				die("<InsertCategoryEntry>:".$conn->connect_error);
			}

			if($resultInsert){
				chat_send($pUID, 0, 1, mysqli_insert_id($conn));
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