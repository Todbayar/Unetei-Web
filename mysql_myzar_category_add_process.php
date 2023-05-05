<?php
include "mysql_config.php";
include "chat_process.php";
include "mysql_misc.php";
include "info.php";

if(isset($_REQUEST["tableID"]) && isset($_REQUEST["title"]) && isset($_FILES["iconfile"]) && isset($_REQUEST["parentID"])){
	if(isset($_REQUEST["type"])){
		InsertCategoryEntry($_REQUEST["tableID"], $_COOKIE["userID"], htmlspecialchars(addslashes($_REQUEST["title"])), $_FILES["iconfile"], $_REQUEST["parentID"], htmlspecialchars(addslashes($_REQUEST["words"])), $_REQUEST["type"]);
	}
	else {
		InsertCategoryEntry($_REQUEST["tableID"], $_COOKIE["userID"], htmlspecialchars(addslashes($_REQUEST["title"])), $_FILES["iconfile"], $_REQUEST["parentID"], htmlspecialchars(addslashes($_REQUEST["words"])), 0);
	}
}
else if(isset($_REQUEST["tableID"]) && isset($_REQUEST["title"]) && !isset($_FILES["iconfile"]) && isset($_REQUEST["parentID"])){
	if(isset($_REQUEST["type"])){
		InsertCategoryEntry($_REQUEST["tableID"], $_COOKIE["userID"], htmlspecialchars(addslashes($_REQUEST["title"])), null, $_REQUEST["parentID"], htmlspecialchars(addslashes($_REQUEST["words"])), $_REQUEST["type"]);
	}
	else {
		InsertCategoryEntry($_REQUEST["tableID"], $_COOKIE["userID"], htmlspecialchars(addslashes($_REQUEST["title"])), null, $_REQUEST["parentID"], htmlspecialchars(addslashes($_REQUEST["words"])), 0);
	}
}
else {
	echo "Ангиллыг нэмхэд алдаа гарлаа!";
}

function InsertCategoryEntry($pTableID, $pUID , $pTitle, $pFile, $pParentID, $pWords, $type){
	global $conn, $category_count_limit_publisher_manager;
	$vType = $type != "undefined" ? $type : 0;
	
	$IsInsertCategoryOK = true;
	if($pParentID == 0){
		$IsInsertCategoryOK = IsCategoryExist($pTableID, $pTitle, null);
	}
	else {
		$IsInsertCategoryOK = IsCategoryExist($pTableID, $pTitle, $pParentID);
	}
	
	if($IsInsertCategoryOK){
		$IsInsertCategoryCountLimitOK = true;
		if(($_COOKIE["role"]==1 || $_COOKIE["role"]==2) && getCountListCategory()>=$category_count_limit_publisher_manager){
			$IsInsertCategoryCountLimitOK = false;
		}
		else if($_COOKIE["role"]==0){
			$IsInsertCategoryCountLimitOK = false;
		}
		
		if($IsInsertCategoryCountLimitOK){
			if(!is_null($pFile)){
				$vNewFile = date("Ymdhis")."_".$pFile["name"];
				if (move_uploaded_file($pFile["tmp_name"], "user_files/".$vNewFile)) {
					$queryInsert = "";
					if($pParentID == 0){
						$queryInsert = "INSERT INTO category".$pTableID."(userID, title, words, icon, status) VALUES('".$pUID."','".$pTitle."','".$pWords."','".$vNewFile."',".$vType.")";
					}
					else {
						$queryInsert = "INSERT INTO category".$pTableID."(userID, title, words, icon, parent, status) VALUES('".$pUID."','".$pTitle."','".$pWords."', '".$vNewFile."',".$pParentID.",".$vType.")";
					}
					$resultInsert = $conn->query($queryInsert);

					if ($conn->connect_error) {
						die("<InsertCategoryEntry>:".$conn->connect_error);
					}

					$lastInsertID = mysqli_insert_id($conn);

					if($resultInsert){
						chat_send($pUID, getAffiliateID($pUID), 1, "c".$pTableID."_".$lastInsertID);
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
					$queryInsert = "INSERT INTO category".$pTableID."(userID, title, words, status) VALUES('".$pUID."','".$pTitle."','".$pWords."',".$vType.")";
				}
				else {
					$queryInsert = "INSERT INTO category".$pTableID."(userID, title, words, parent, status) VALUES('".$pUID."','".$pTitle."','".$pWords."',".$pParentID.",".$vType.")";
				}
				echo $queryInsert;
				$resultInsert = $conn->query($queryInsert);

				if ($conn->connect_error) {
					die("<InsertCategoryEntry>:".$conn->connect_error);
				}

				$lastInsertID = mysqli_insert_id($conn);

				if($resultInsert){
					chat_send($pUID, getAffiliateID($pUID), 1, "c".$pTableID."_".$lastInsertID);
					echo "OK";
				}
				else {
					echo "<InsertCategoryEntry>:insert is failed!";
				}
			}
		}
		else {
			echo "Таны хэрэглэгчийн эрхийн хүрээнд ".$category_count_limit_publisher_manager." ангилал оруулах эрх дууссан байна, та хэрэглэгчийн эрхээ дээшлүүлж болно! Тохиргоо хэсэгт харна уу.";	
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