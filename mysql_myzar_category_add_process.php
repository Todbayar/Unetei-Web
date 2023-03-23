<?php
include "mysql_config.php";

$file = $_FILES["iconfile"];
$uid = $_REQUEST["uid"];
$title = $_REQUEST["title"];
$hier = !empty($_REQUEST["hier"]) ? explode(',', $_REQUEST["hier"]) : array();

if(isset($hier) && isset($uid) && isset($title) && isset($file)){
	if(count($hier) === 0){
		CheckTableCreate(1);
		InsertCategoryEntry(1, $uid, null, $title, $file);
	}
	else {
		for($i=1; $i<=count($hier); $i++){
			if(isset($hier[$i--])){
				CheckTableCreate($i);
				if($i == 1)
				{
					InsertCategoryEntry($i, $uid, null, $title, $file);
				}
				else {
					$vParentID = FetchCategoryIDFromTitle($hier[$i--]);
					InsertCategoryEntry($i, $uid, $vParentID, $title, $file);
				}
			}
		}
	}
}

function CheckTableCreate($pID){
	global $dbname, $conn;
	
	$queryTableExist = "SELECT count(*) as 'total_count' FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$dbname."') AND (TABLE_NAME = 'category".$pID."')";
	$resultTableExist = $conn->query($queryTableExist);
	$rowTableExist = mysqli_fetch_array($resultTableExist);
	
	if($rowTableExist["total_count"] == 0){
		$queryTableCreate = "";
		
		if($pID == 1){
			$queryTableCreate = "CREATE TABLE category".$pID." (id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, uid varchar(255) NOT NULL, title varchar(30) NOT NULL, icon varchar(255) NOT NULL, status int(1) NOT NULL DEFAULT 0, clicked int(10) NOT NULL DEFAULT 0, active tinyint NOT NULL DEFAULT 0)";
			//status 0=normal, 1=special, 2=vip
		}
		else {
			$queryTableCreate = "CREATE TABLE category".$pID." (id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, uid varchar(255) NOT NULL, title varchar(30) NOT NULL, icon varchar(255) NOT NULL, parent int(10) NOT NULL, status int(1) NOT NULL DEFAULT 0, clicked int(10) NOT NULL DEFAULT 0, active tinyint NOT NULL DEFAULT 0)";
		}
		$conn->query($queryTableCreate);
		if ($conn->connect_error) {
		  die("<CheckTableCreate>:".$conn->connect_error);
		}
	}
}

function InsertCategoryEntry($pID, $pUID, $pParentID, $pTitle, $pFile){
	global $conn;
	$vNewFile = date("Ymdhis")."_".$pFile["name"];
	
	$IsInsertCategoryOK = true;
	if(!isset($pParentID)){
		$IsInsertCategoryOK = IsCategoryExist($pID, $pTitle, $pUID, null);
	}
	else {
		$IsInsertCategoryOK = IsCategoryExist($pID, $pTitle, $pUID, $pParentID);
	}
	
	if($IsInsertCategoryOK){
		if (move_uploaded_file($pFile["tmp_name"], "user_files/".$vNewFile)) {
			$queryInsert = "";
			if(!isset($pParentID)){
				$queryInsert = "INSERT INTO category".$pID."(uid, title, icon) VALUES('".$pUID."','".$pTitle."','".$vNewFile."')";
			}
			else {
				$queryInsert = "INSERT INTO category".$pID."(uid, title, icon, parent) VALUES('".$pUID."','".$pTitle."','".$vNewFile."',".$pParentID.")";
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

function IsCategoryExist($pID, $pTitle, $pUID, $pParent){
	global $conn;
	$queryInsertCheckDuplication = "";
	if(!isset($pParentID)){
		$queryInsertCheckDuplication = "SELECT * FROM category".$pID." WHERE title='".$pTitle."' AND uid='".$pUID."'";
	}
	else {
		$queryInsertCheckDuplication = "SELECT * FROM category".$pID." WHERE title='".$pTitle."' AND uid='".$pUID."' AND parent=".$pParentID;
	}
	$resultInsertCheckDuplication = $conn->query($queryInsertCheckDuplication);
	if($resultInsertCheckDuplication){
		$rowsInsertCheckDuplication = mysqli_num_rows($resultInsertCheckDuplication);
		if($rowsInsertCheckDuplication == 0){
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

function FetchCategoryIDFromTitle($pTitle){
	global $conn;
	$queryFetch = "SELECT id FROM category WHERE title='".$pTitle."'";
	$resultFetch = $conn->query($queryFetch);
	if ($conn->connect_error) {
	  die("<FetchCategoryIDFromTitle>:".$conn->connect_error);
	}
	$rowFetch = mysqli_fetch_array($resultFetch);
	return $rowFetch["id"];
}
?>