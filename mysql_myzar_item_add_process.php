<?php
include "mysql_config.php";

$userID = $_COOKIE["userID"];
$category = $_REQUEST["category"];
$title = $_REQUEST["title"];
$quality = $_REQUEST["quality"];
$address = $_REQUEST["address"];
$price = $_REQUEST["price"];
$images = (isset($_REQUEST["images"]) && $_REQUEST["images"] != "[]") ? json_decode($_REQUEST["images"]) : null;
$youtube = $_REQUEST["youtube"];
$video = (isset($_REQUEST["video"]) && $_REQUEST["video"] !== "" && $_REQUEST["video"] !== "undefined") ? $_REQUEST["video"] : "";
$description = $_REQUEST["description"];
$city = $_REQUEST["city"];
$name = (isset($_REQUEST["name"]) && preg_match("/^[a-zA-Z-' ]*$/",$_REQUEST["name"])) ? $_REQUEST["name"] : "";
$email = (isset($_REQUEST["email"]) && filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) ? $_REQUEST["email"] : "";

$queryUpdateUser = "UPDATE user SET name='".$name."', email='".$email."', city='' WHERE id=".$userID;
$conn->query($queryUpdateUser);

$queryDuplication = "SELECT * FROM item WHERE title='".$title."' AND userID=".$userID." AND category='".$category."'";
$resultDuplication = $conn->query($queryDuplication);
$isDuplication = mysqli_num_rows($resultDuplication);
if($isDuplication == 0){
	$queryItem = "INSERT INTO item (title, quality, address, price, youtube, video, description, city, userID, category, item_viewer, phone_viewer, datetime, expire_days, isactive) VALUES ('".$title."', ".$quality.", '".$address."', ".$price.", '".$youtube."', '".$video."', '".$description."', '".$city."', ".$userID.", '".$category."', 0, 0, '".date("Y-m-d h:i:s")."', 7, 0)";
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
				echo $itemID;
			}
			else {
				echo "Fail 44";
			}
		}
		else {
			echo $itemID;
		}
	}
	else {
		echo "Fail 52";
	}
}
else {
	echo "Fail 56";
}

mysqli_close($conn);
?>