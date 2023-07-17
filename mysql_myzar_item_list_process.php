<?php
include "mysql_config.php";
include "info.php";

$query = "SELECT * FROM item WHERE id=".$_REQUEST["id"];
$result = $conn->query($query);
$row = mysqli_fetch_array($result);

//$queryUser = "SELECT * FROM user WHERE id=".$row["userID"];
//$resultUser = $conn->query($queryUser);
//$rowUser = mysqli_fetch_array($resultUser);

$arrImages = array();
$queryImages = "SELECT * FROM images WHERE item=".$_REQUEST["id"]." ORDER BY sort ASC";
$resultImages = $conn->query($queryImages);
while($rowImages = mysqli_fetch_array($resultImages)){
	$responseImage = new stdClass;
	$responseImage->id = $rowImages["id"];
	$responseImage->sort = $rowImages["sort"];
	$responseImage->name = $rowImages["image"];
//	$responseImage->type = image_type_to_mime_type(exif_imagetype($path."/".$rowImages["image"]));	
//	$responseImage->data = "data:".$responseImage->type.";base64,".base64_encode(file_get_contents($path."/".$rowImages["image"]));
	$arrImages[] = $responseImage;
}

$arrCategories = array();
$category = explode("_", $row["category"]);
$iteration = substr($category[0], 1, strlen($category[0]));
$parent = 0;
for($i=$iteration; $i>=1; $i--){
	if($parent == 0){
		$queryCategory = "SELECT * FROM category".$i." WHERE id=".$category[1];
	}
	else {
		$queryCategory = "SELECT * FROM category".$i." WHERE id=".$parent;
	}

	$resultCategory = $conn->query($queryCategory);
	$rowCategory = mysqli_fetch_array($resultCategory);
	if($i>1) $parent = $rowCategory["parent"];
	
	$objCategory = new stdClass;
	$objCategory->id = $rowCategory["id"];
	$objCategory->tableID = $i;
	$objCategory->icon = $rowCategory["icon"] != null ? $rowCategory["icon"] : "";
	$objCategory->title = $rowCategory["title"];
	
	$arrCategories[] = $objCategory;
}

$response = new stdClass;
$response->id = $_REQUEST["id"];
$response->categories = array_reverse($arrCategories);
$response->title = stripslashes(htmlspecialchars_decode($row["title"]));
$response->quality = $row["quality"];
$response->address = stripslashes(htmlspecialchars_decode($row["address"]));
$response->price = $row["price"];
$response->youtube = $row["youtube"];
$response->extras = stripslashes(htmlspecialchars_decode($row["extras"]));
$response->description = stripslashes(htmlspecialchars_decode($row["description"]));
$response->city = $row["city"];
$response->name = $row["name"];
$response->email = $row["email"];
$response->phone = $row["phone"];
$response->images = $arrImages;
$response->video = $row["video"];
$response->path = $path;

echo json_encode($response);
?>