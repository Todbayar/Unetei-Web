<?php
include "mysql_config.php";
include_once "chat_process.php";
include_once "mysql_misc.php";
include_once "info.php";

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
	global $conn, $category_regular_count_limit_superadmin, $category_brand_count_limit_superadmin, $category_regular_count_limit_admin, $category_brand_count_limit_admin, $category_regular_count_limit_manager, $category_brand_count_limit_manager, $category_regular_count_limit_publisher, $category_brand_count_limit_publisher;
	
	$vType = $type != "undefined" ? $type : 0;
	
	$IsInsertCategoryOK = true;
	if($pParentID == 0){
		$IsInsertCategoryOK = IsCategoryExist($pTableID, $pTitle, null);
	}
	else {
		$IsInsertCategoryOK = IsCategoryExist($pTableID, $pTitle, $pParentID);
	}
	
	if($IsInsertCategoryOK){
		if(!IsCategoryCountLimitReached($vType, $pUID)){
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
			$msg = 'Таны хэрэглэгчийн эрхийн хүрээнд энгийн (%1$d/%2$s), брэнд/дэлгүүр (%3$d/%4$s) ангилал оруулах боломжтой байна, та хэрэглэгчийн эрхээ дээшлүүлж болно! Тохиргоо хэсэгт харна уу.';
			switch(getUserRole($pUID)){
				case 4:
					$categoryRegularCount = ($category_regular_count_limit_superadmin==-1)?0:($category_regular_count_limit_superadmin==0?"&infin;":$category_regular_count_limit_superadmin);
					$categoryBrandCount = ($category_brand_count_limit_superadmin==-1)?0:($category_brand_count_limit_superadmin==0?"&infin;":$category_brand_count_limit_superadmin);
					echo sprintf($msg, getCountCategory(0, $pUID), $categoryRegularCount, getCountCategory(1, $pUID), $categoryBrandCount);
					break;
				case 3:
					$categoryRegularCount = ($category_regular_count_limit_admin==-1)?0:($category_regular_count_limit_admin==0?"&infin;":$category_regular_count_limit_admin);
					$categoryBrandCount = ($category_brand_count_limit_admin==-1)?0:($category_brand_count_limit_admin==0?"&infin;":$category_brand_count_limit_admin);
					echo sprintf($msg, getCountCategory(0, $pUID), $categoryRegularCount, getCountCategory(1, $pUID), $categoryBrandCount);
					break;
				case 2:
					$categoryRegularCount = ($category_regular_count_limit_manager==-1)?0:($category_regular_count_limit_manager==0?"&infin;":$category_regular_count_limit_manager);
					$categoryBrandCount = ($category_brand_count_limit_manager==-1)?0:($category_brand_count_limit_manager==0?"&infin;":$category_brand_count_limit_manager);
					echo sprintf($msg, getCountCategory(0, $pUID), $categoryRegularCount, getCountCategory(1, $pUID), $categoryBrandCount);
					break;
				case 1:
					$categoryRegularCount = ($category_regular_count_limit_publisher==-1)?0:($category_regular_count_limit_publisher==0?"&infin;":$category_regular_count_limit_publisher);
					$categoryBrandCount = ($category_brand_count_limit_publisher==-1)?0:($category_brand_count_limit_publisher==0?"&infin;":$category_brand_count_limit_publisher);
					echo sprintf($msg, getCountCategory(0, $pUID), $categoryRegularCount, getCountCategory(1, $pUID), $categoryBrandCount);
					break;
			}
		}
	}
	else {
		echo "Таны оруулсан ангилал жагсаалтанд байсан байна!";
	}
}

function IsCategoryCountLimitReached($type, $userID){
	global $conn, $category_regular_count_limit_superadmin, $category_brand_count_limit_superadmin, $category_regular_count_limit_admin, $category_brand_count_limit_admin, $category_regular_count_limit_manager, $category_brand_count_limit_manager, $category_regular_count_limit_publisher, $category_brand_count_limit_publisher;
	
	$currentCountCategory = getCountCategory($type, $userID);
	$countCategory = -1;	//not accepted
	
	$queryUser = "SELECT * FROM user WHERE id=".$_COOKIE["userID"];
	$resultUser = $conn->query($queryUser);
	$rowUser = mysqli_fetch_array($resultUser);
	
	switch($rowUser["role"]){
		case 4:
			if($type==0) $countCategory = $category_regular_count_limit_superadmin;
			else if($type==1) $countCategory = $category_brand_count_limit_superadmin;
			break;
		case 3:
			if($type==0) $countCategory = $category_regular_count_limit_admin;
			else if($type==1) $countCategory = $category_brand_count_limit_admin;
			break;
		case 2:
			if($type==0) $countCategory = $category_regular_count_limit_manager;
			else if($type==1) $countCategory = $category_brand_count_limit_manager;
			break;
		case 1:
			if($type==0) $countCategory = $category_regular_count_limit_publisher;
			else if($type==1) $countCategory = $category_brand_count_limit_publisher;
			break;
	}
	
	if($countCategory == -1){
		return true;	//not accepted
	}
	else if($countCategory == 0){
		return false;	//unlimited
	}
	else if($countCategory > 0) {
		if($countCategory > $currentCountCategory){
			return false;	//more available
		}
		else {
			return true;	//not accepted and reached limit
		}
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