<?php
include "mysql_config.php";
include "info.php";
include "chat_process";

$userID = $_COOKIE["userID"];
$itemID = $_REQUEST["itemID"];
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

if($_COOKIE["role"] == 0){
	$phone = $_COOKIE["phone"];
}

$queryUpdateItem = "UPDATE item SET title='".$title."', quality=".$quality.", address='".$address."', price=".$price.", youtube='".$youtube."', video='".$video."', extras='".$extras."', description='".$description."', city='".$city."', name='".$name."', phone='".$phone."', email='".$email."', category='".$category."', isactive=1 WHERE id=".$itemID;

if($conn->query($queryUpdateItem)){
	if(!is_null($images)){		
		$countImageEditDone = count($images);
		foreach($images as $image){
			if($image != "" && file_exists($path.DIRECTORY_SEPARATOR.$image)){
				$queryImage = "INSERT IGNORE INTO images (userID, item, image) VALUES (".$userID.", ".$itemID.", '".$image."')";
				if($conn->query($queryImage)) $countImageEditDone--;
			}
			else {
				$queryImage = "DELETE FROM images WHERE image='".$image."'";
				if($conn->query($queryImage)) $countImageEditDone--;
			}
		}
		if($countImageEditDone == 0){
			chat_send($userID, 0, 2, $itemID);
			echo "OK";
		}
		else {
			echo "Fail";
		}
	}
	else {
		chat_send($userID, 0, 2, $itemID);
		echo "OK";
	}
}
else {
	echo "Fail";
}

mysqli_close($conn);
?>