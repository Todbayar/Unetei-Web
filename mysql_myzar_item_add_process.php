<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "chat_process.php";
include_once "info.php";

$isNewUser = (boolean)json_decode(strtolower($_REQUEST["isNewUser"]));
$phone = (isset($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";
$userID = $_COOKIE["userID"];
if($isNewUser && $phone!="") $userID = userNewAdd($phone);
$category = $_REQUEST["category"];
$title = htmlspecialchars(addslashes($_REQUEST["title"]));
$quality = $_REQUEST["quality"];
$address = htmlspecialchars(addslashes($_REQUEST["address"]));
$price = $_REQUEST["price"];
$youtube = $_REQUEST["youtube"];
$extras = htmlspecialchars(addslashes($_REQUEST["extras"]));
$description = htmlspecialchars(addslashes($_REQUEST["description"]));
$city = $_REQUEST["city"];
$name = $_REQUEST["name"];
$email = (isset($_REQUEST["email"]) && filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) ? $_REQUEST["email"] : "";
$status = $_REQUEST["status"];

//uploading image files with limited count and disk space on server
$imagesDatas = (isset($_REQUEST["imagesDatas"]) && $_REQUEST["imagesDatas"] != "[]") ? json_decode($_REQUEST["imagesDatas"]) : null;
if(!is_null($imagesDatas)){
	$totalCountImagesLimit = 1;
	for($i=0; $i<count($imagesDatas); $i++){
		if(isset($imagesDatas[$i]->action) && $imagesDatas[$i]->action=="new" && $totalCountImagesLimit<=COUNT_ITEM_IMAGES){
			for($l=0; $l<count($_FILES["imagesFiles"]["name"]); $l++){
				if($_FILES["imagesFiles"]["name"][$l]==$imagesDatas[$i]->name){
					$vImageNewName = date("Ymdhis")."_".$_FILES["imagesFiles"]["name"][$l];
					if(move_uploaded_file($_FILES["imagesFiles"]["tmp_name"][$l], $path.DIRECTORY_SEPARATOR.$vImageNewName)){
						$imagesDatas[$i]->name = $vImageNewName;
					}
				}
			}
			$totalCountImagesLimit++;
		}
	}
}

//uploading video files with limited count and disk space on server
$videosDatas = (isset($_REQUEST["videosDatas"]) && $_REQUEST["videosDatas"] != "[]") ? json_decode($_REQUEST["videosDatas"]) : null;
if(!is_null($videosDatas)){
	$totalCountVideosLimit = 1;
	for($i=0; $i<count($videosDatas); $i++){
		if(isset($videosDatas[$i]->action) && $videosDatas[$i]->action=="new" && $totalCountVideosLimit<=COUNT_ITEM_VIDEOS){
			for($l=0; $l<count($_FILES["videosFiles"]["name"]); $l++){
				if($_FILES["videosFiles"]["name"][$l]==$videosDatas[$i]->name){
					$vVideoNewName = date("Ymdhis")."_".$_FILES["videosFiles"]["name"][$l];
					if(move_uploaded_file($_FILES["videosFiles"]["tmp_name"][$l], $path.DIRECTORY_SEPARATOR.$vVideoNewName)){
						$videosDatas[$i]->name = $vVideoNewName;
					}
				}
			}
			$totalCountVideosLimit++;
		}
	}
}

$userRole = getUserRole($userID);
if($userRole == 0 && !$isNewUser){
	$phone = getPhone($_COOKIE["userID"]);
}

$days = 30;
if($status == 2){
	$days = 10;
}
else if($status == 1) {
	$days = 20;
}

$payAmount = getPayAmount($status, $userID);

$videoName = $videosDatas!=null?$videosDatas[0]->name:null;
$queryItem = "INSERT INTO item (title, quality, address, price, youtube, video, extras, description, city, name, phone, email, userID, category, item_viewer, phone_viewer, datetime, expire_days, status, isactive) VALUES ('".$title."', ".$quality.", '".$address."', ".$price.", '".$youtube."', '".$videoName."', '".$extras."', '".$description."', '".$city."', '".$name."', '".$phone."', '".$email."', ".$userID.", '".$category."', 0, 0, '".date("Y-m-d h:i:s")."', ".$days.", ".$status.", 1)";

if($conn->query($queryItem)){
	$itemID = mysqli_insert_id($conn);
	if(!is_null($imagesDatas)){
		for($i=0; $i<count($imagesDatas); $i++){
			$queryImages = "INSERT INTO images (userID, item, image, sort) VALUES (".$userID.", ".$itemID.", '".$imagesDatas[$i]->name."',".$imagesDatas[$i]->sort.")";
			@$conn->query($queryImages);
		}
	}
	
	chat_send($userID, getAffiliateID($userID), 2, $itemID, false);
	update_profile($name, $email, $city, $userID);
	echo json_encode(array("id"=>$itemID, "pay_amount"=>$payAmount));
}
else {
	echo "Fail 54";
}

mysqli_close($conn);
?>