<?php
include "mysql_config.php";

$file = $_FILES["iconfile"];
$uid = $_REQUEST["uid"];
$title = $_REQUEST["title"];
$tableID = $_REQUEST["tableID"];
$parentID = $_REQUEST["parentID"];

if(isset($uid) && isset($title) && isset($file) && isset($tableID) && !isset($parentID)){
	InsertCategoryEntry(1, $uid, null, $title, $file);
}
else if(isset($uid) && isset($title) && isset($file) && isset($tableID) && isset($parentID)){
	InsertCategoryEntry($tableID, $uid, $parentID, $title, $file);
}

function InsertCategoryEntry($pTableID, $pUID, $pParentID, $pTitle, $pFile){
	global $conn;
	$vNewFile = date("Ymdhis")."_".$pFile["name"];
	
	$IsInsertCategoryOK = true;
	if(!isset($pParentID)){
		$IsInsertCategoryOK = IsCategoryExist($pTableID, $pTitle, $pUID, null);
	}
	else {
		$IsInsertCategoryOK = IsCategoryExist($pTableID, $pTitle, $pUID, $pParentID);
	}
	
	if($IsInsertCategoryOK){
		if (move_uploaded_file($pFile["tmp_name"], "user_files/".$vNewFile)) {
			$queryInsert = "";
			if(!isset($pParentID)){
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
		echo "Таны оруулсан ангилал жагсаалтанд байсан байна!";
	}
}

function IsCategoryExist($pTableID, $pTitle, $pUID, $pParentID){
	global $conn;
	$queryCategoryExist = "";
	if(!isset($pParentID)){
		$queryCategoryExist = "SELECT * FROM category".$pTableID." WHERE title='".$pTitle."' AND uid='".$pUID."'";
	}
	else {
		$queryCategoryExist = "SELECT * FROM category".$pTableID." WHERE title='".$pTitle."' AND uid='".$pUID."' AND parent=".$pParentID;
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

function FetchCategoryIDFromTitle($pTableID, $pUID, $pTitle){
	global $conn;
	$queryFetch = "SELECT id FROM category".$pTableID." WHERE uid='".$pUID."' AND title='".$pTitle."'";
	$resultFetch = $conn->query($queryFetch);
	if ($conn->connect_error) {
	  die("<FetchCategoryIDFromTitle>:".$conn->connect_error);
	}
	$rowFetch = mysqli_fetch_array($resultFetch);
	return $rowFetch["id"];
}
?>