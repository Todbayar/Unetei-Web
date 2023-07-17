<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
include_once "chat_process.php";

$userID = $_COOKIE["userID"];
$itemID = $_REQUEST["itemID"];
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
$phone = (isset($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";

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

if(!is_null($imagesDatas)){
	$arrDeleteImages = array();
	for($i=0; $i<count($imagesDatas); $i++){
		if(isset($imagesDatas[$i]->action) && $imagesDatas[$i]->action=="delete"){
			array_push($arrDeleteImages,$imagesDatas[$i]->id);
			if(file_exists($path.DIRECTORY_SEPARATOR.$imagesDatas[$i]->name)) @unlink($path.DIRECTORY_SEPARATOR.$imagesDatas[$i]->name);
			array_splice($imagesDatas,$i,0);
		}
	}
	if(count($arrDeleteImages)>0){
		@$conn->query("DELETE FROM images WHERE id IN (".implode(',',$arrDeleteImages).")");
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

if(!is_null($videosDatas)){
	for($i=0; $i<count($videosDatas); $i++){
		if(isset($videosDatas[$i]->action) && $videosDatas[$i]->action=="delete"){
			if(file_exists($path.DIRECTORY_SEPARATOR.$videosDatas[$i]->name)) @unlink($path.DIRECTORY_SEPARATOR.$videosDatas[$i]->name);
			array_splice($videosDatas,$i,1);
		}
	}
}

if(getUserRole($userID) == 0){
	$phone = getPhone($userID);
}

$videoName = $videosDatas!=null?$videosDatas[0]->name:null;
$queryItem = "UPDATE item SET title='".$title."', quality=".$quality.", address='".$address."', price=".$price.", youtube='".$youtube."', video='".$videoName."', extras='".$extras."', description='".$description."', city='".$city."', name='".$name."', phone='".$phone."', email='".$email."', category='".$category."', isactive=1 WHERE id=".$itemID;

if($conn->query($queryItem)){
	if(!is_null($imagesDatas)){
		for($i=0; $i<count($imagesDatas); $i++){
			if(isset($imagesDatas[$i]->action) && $imagesDatas[$i]->action=="new"){
				$queryImages = "INSERT INTO images (userID, item, image, sort) VALUES (".$userID.", ".$itemID.", '".$imagesDatas[$i]->name."',".$imagesDatas[$i]->sort.")";
				@$conn->query($queryImages);
			}
			else if(!isset($imagesDatas[$i]->action)){
				$queryImages = "UPDATE images SET sort=".$imagesDatas[$i]->sort." WHERE id=".$imagesDatas[$i]->id;
				@$conn->query($queryImages);
			}
		}
	}
	
	chat_send($userID, getAffiliateID($userID), 2, $itemID, false, true);
	update_profile($name, $email, $city, $userID);
	echo $itemID;
}
else {
	echo "Fail";
}

mysqli_close($conn);
?>