<?php
include "mysql_config.php";

if(isset($_GET["toID"])){
	$query = "SELECT *, (SELECT name FROM user WHERE id=fromID) AS sender_name, (SELECT image FROM user WHERE id=fromID) AS sender_image FROM chat WHERE fromID=".$_COOKIE["userID"]." AND toID=".$_GET["toID"]." OR fromID=".$_GET["toID"]." AND toID=".$_COOKIE["userID"]." ORDER BY datetime ASC";
	$result = $conn->query($query);
	$objArr = array();
	while($row = mysqli_fetch_array($result)){
		@$conn->query("UPDATE chat SET isRead=1 WHERE id=".$row["id"]." NOT type=3");
		
		$message = new stdClass();
		$message->type = $row["type"];
		$message->datetime = $row["datetime"];
		$message->isEdit = ($_COOKIE["role"]>=3 && $_COOKIE["userID"]==$row["toID"]) ? true : false;

		$sender = new stdClass();
		$sender->id = $row["fromID"];
		$sender->name = $row["sender_name"];
		$sender->image = $row["sender_image"];
		
		$message->sender = $sender;
		
		if($row["type"] == 0){
//			$message->body = stripslashes(htmlspecialchars_decode($row["message"]));
			$message->body = $row["message"];
		}
		else if($row["type"] == 1){
			$message->body = fetchCategory($row["message"]);
		}
		else if($row["type"] == 2){
			$message->body = fetchItem($row["message"]);
		}
		else if($row["type"] == 3){
			$body = new stdClass();
			$body->id = $row["id"];
			$body->isActive = $row["isRead"];
			$body->message = $row["message"];
			$message->body = $body;
		}
		
		$objArr[] = $message;
	}
	echo json_encode($objArr);
}

function fetchItem($id){
	global $conn;
	$query = "SELECT * FROM item WHERE id=".$id;
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	$body = new stdClass();
	if(mysqli_num_rows($result) > 0){
		$body->id = $row["id"];
		$body->title = $row["title"];
		$body->isActive = $row["isactive"];
		$body->category = harvestCategory($row["category"]);
	}
	else {
		$body = null;
	}
	return $body;
}

function fetchCategory($id){
	global $conn;
	$category = explode("_", $id);
	$iteration = substr($category[0], 1, strlen($category[0]));
	$query = "SELECT * FROM category".$iteration." WHERE id=".$category[1];
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	$body = new stdClass();
	if(mysqli_num_rows($result) > 0){
		$body->id = $row["id"];
		$body->title = $row["title"];
		$body->isActive = $row["active"];
		$body->words = $row["words"];
		$body->category = harvestCategory($id);
	}
	else {
		$body = null;
	}
	return $body;
}

function harvestCategory($categoryID){
	global $conn;
	$arrCategories = array();
	$category = explode("_", $categoryID);
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

		$arrCategories[] = $rowCategory["title"];
	}
	return array_reverse($arrCategories);
}
?>