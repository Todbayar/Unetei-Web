<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "chat_process.php";
include_once "info.php";

$userID = $_COOKIE["userID"];
$category = $_REQUEST["category"];
$title = htmlspecialchars(addslashes($_REQUEST["title"]));
$quality = $_REQUEST["quality"];
$address = htmlspecialchars(addslashes($_REQUEST["address"]));
$price = $_REQUEST["price"];
$images = (isset($_REQUEST["images"]) && $_REQUEST["images"] != "[]") ? json_decode($_REQUEST["images"]) : null;
$youtube = $_REQUEST["youtube"];
$video = (isset($_REQUEST["video"]) && $_REQUEST["video"] !== "" && $_REQUEST["video"] !== "undefined") ? $_REQUEST["video"] : "";
$extras = htmlspecialchars(addslashes($_REQUEST["extras"]));
$description = htmlspecialchars(addslashes($_REQUEST["description"]));
$city = $_REQUEST["city"];
$name = $_REQUEST["name"];
$email = (isset($_REQUEST["email"]) && filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) ? $_REQUEST["email"] : "";
$phone = (isset($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";
$status = $_REQUEST["status"];

$queryDuplication = "SELECT * FROM item WHERE title='".$title."' AND userID=".$userID." AND category='".$category."'";
$resultDuplication = $conn->query($queryDuplication);
$isDuplication = mysqli_num_rows($resultDuplication);
if($isDuplication == 0){
	$userRole = getUserRole($userID);
	if($userRole == 0){
		$phone = $_COOKIE["phone"];
	}
	
	$days = 30;
	if($status == 2){
		$days = 10;
	}
	else if($status == 1) {
		$days = 20;
	}
	
	$payAmount = 0;
	$countItem = getCountItem($userID);
	switch($userRole){
		case 4:
			$payAmount = 0;
		case 3:
			if($countItem["total"]>$item_vipspecial_count_limit_admin){
				if($status==2) $payAmount = $item_publish_price_vip;
				else if($status==1) $payAmount = $item_publish_price_special;
			}
			break;
		default:
			if($status==2) $payAmount = $item_publish_price_vip;
			else if($status==1) $payAmount = $item_publish_price_special;
			break;
	}
	
	$queryItem = "INSERT INTO item (title, quality, address, price, youtube, video, extras, description, city, name, phone, email, userID, category, item_viewer, phone_viewer, datetime, expire_days, status, isactive) VALUES ('".$title."', ".$quality.", '".$address."', ".$price.", '".$youtube."', '".$video."', '".$extras."', '".$description."', '".$city."', '".$name."', '".$phone."', '".$email."', ".$userID.", '".$category."', 0, 0, '".date("Y-m-d h:i:s")."', ".$days.", ".$status.", 1)";
	
	$resultItem = $conn->query($queryItem);
	if($resultItem){
		$itemID = mysqli_insert_id($conn);
		if($images != null){
			$isImagesInsert = false;
			foreach($images as $image){
				$queryImages = "INSERT INTO images (userID, item, image) VALUES (".$userID.", ".$itemID.", '".$image."')";
				if($conn->query($queryImages)){
					$isImagesInsert = true;
				}
				else {
					$isImagesInsert = false;
				}
			}
			if($isImagesInsert){
				chat_send($userID, getAffiliateID($userID), 2, $itemID, false);
				update_profile($name, $email, $city, $userID);
				echo json_encode(array("id"=>$itemID, "pay_amount"=>$payAmount));
			}
			else {
				echo "Fail 46";
			}
		}
		else {
			chat_send($userID, getAffiliateID($userID), 2, $itemID, false);
			update_profile($name, $email, $city, $userID);
			echo json_encode(array("id"=>$itemID, "pay_amount"=>$payAmount));
		}
	}
	else {
		echo "Fail 54";
	}
}
else {
	echo "Fail 58";
}

mysqli_close($conn);
?>