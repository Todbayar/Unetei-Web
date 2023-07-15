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
	for($indexImageData=0; $indexImageData<count($imagesDatas); $indexImageData++){
		if($indexImageData<COUNT_ITEM_IMAGES){
			$imageNameNew = date("Ymdhis")."_".$imagesDatas[$indexImageData]->name;
			$imagesDatas[$indexImageData]->id = $indexImageData;
			$imagesDatas[$indexImageData]->name = $imageNameNew;
			$imageTypeReplace = "data:".$imagesDatas[$indexImageData]->type.";base64,";
			$imageFileData = str_replace($imageTypeReplace, "", $imagesDatas[$indexImageData]->data);
    		$imageDecodedData = base64_decode($imageFileData);
			$fp = fopen($path.DIRECTORY_SEPARATOR.$imageNameNew, "w");
			fwrite($fp, $imageDecodedData);
			fclose($fp);
		}
		else {
			array_splice($imagesDatas, $indexImageData);
			break;
		}
	}
}

$video = null;
if(isset($_FILES["video"])){
	$videoNameNew = date("Ymdhis")."_".$_FILES["video"]["name"];
	if(move_uploaded_file($_FILES["video"]["tmp_name"], $path.DIRECTORY_SEPARATOR.$videoNameNew)) {
		$video = $videoNameNew;
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

$queryItem = "INSERT INTO item (title, quality, address, price, youtube, video, extras, description, city, name, phone, email, userID, category, item_viewer, phone_viewer, datetime, expire_days, status, isactive) VALUES ('".$title."', ".$quality.", '".$address."', ".$price.", '".$youtube."', '".$video."', '".$extras."', '".$description."', '".$city."', '".$name."', '".$phone."', '".$email."', ".$userID.", '".$category."', 0, 0, '".date("Y-m-d h:i:s")."', ".$days.", ".$status.", 1)";

$resultItem = $conn->query($queryItem);
if($resultItem){
	$itemID = mysqli_insert_id($conn);
	if(!is_null($imagesDatas)){
		for($i=0; $i<count($imagesDatas); $i++){
			$queryImages = "INSERT INTO images (userID, item, image, sort) VALUES (".$userID.", ".$itemID.", '".$imagesDatas[$i]->name."',".$imagesDatas[$i]->id.")";
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