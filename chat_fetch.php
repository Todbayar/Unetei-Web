<?php
include "mysql_config.php";

if(isset($_GET["id"])){
	$query = "SELECT *, (SELECT name FROM user WHERE id=fromID) AS sender_name, (SELECT image FROM user WHERE id=fromID) AS sender_image FROM chat WHERE toID=".$_GET["id"]." ORDER BY datetime ASC";
	$result = $conn->query($query);
	$objArr = array();
	while($row = mysqli_fetch_array($result)){
		$message = new stdClass();
		$message->type = $row["type"];
		$message->datetime = $row["datetime"];
		$sender = new stdClass();
		$sender->name = $row["sender_name"];
		$sender->image = $row["sender_image"];
		$message->sender = $sender;
		if($row["type"] == 0){
			$message->body = $row["message"];
		}
		else if($row["type"] == 1){
			$message->body = fetchCategory($row["message"]);
		}
		else if($row["type"] == 2){
			$message->body = fetchItem($row["message"]);
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
	$body->id = $row["id"];
	$body->title = $row["title"];
	$body->category = harvestCategory($row["category"]);
}

function fetchCategory($id){
	global $conn;
	$category = explode("_", $id);
	$iteration = substr($category[0], 1, strlen($category[0]));
	$query = "SELECT * FROM category".$iteration." WHERE id=".$category[1];
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	$body = new stdClass();
	$body->id = $row["id"];
	$body->title = $row["title"];
	$body->category = harvestCategory($id);
}

function harvestCategory($categoryID){
	echo "<harvestCategory>:".$categoryID." ";
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
	return $arrCategories;
}
?>