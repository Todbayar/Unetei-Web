<?php
include "mysql_config.php";
include_once "mysql_misc.php";

if(isset($_GET["toID"])){
	$query = "SELECT *, (SELECT name FROM user WHERE id=fromID) AS sender_name, (SELECT image FROM user WHERE id=fromID) AS sender_image FROM chat WHERE (toID=".$_COOKIE["userID"]." AND fromID=".$_GET["toID"].") OR (toID=".$_GET["toID"]." AND fromID=".$_COOKIE["userID"].") ORDER BY datetime DESC";
	$result = $conn->query($query);
	$objArr = array();
	while($row = mysqli_fetch_array($result)){
		@$conn->query("UPDATE chat SET isRead=1 WHERE id=".$row["id"]." AND toID=".$_COOKIE["userID"]." AND NOT type=3");
		
		$message = new stdClass();
		$message->id = $row["id"];	//chat row id
		$message->note = !is_null($row["note"])?$row["note"]:"";
		$message->type = $row["type"];
		$message->datetime = $row["datetime"];
		$message->isEdit = (getUserRole($_COOKIE["userID"])>=2 && $_COOKIE["userID"]==$row["toID"]) ? true : false;	//receive income from its followers

		$sender = new stdClass();
		$sender->id = $row["fromID"];
		$sender->name = $row["sender_name"];
		$sender->image = $row["sender_image"];
		
		$message->sender = $sender;
		
		if($row["type"] == 0){
			if(strpos($row["message"],"#")!==false){
				$message->body = stripslashes(htmlspecialchars_decode($row["message"]));
			}
			else {
				$message->body = $row["message"];
			}
		}
		else if($row["type"] == 1){
			$message->body = fetchCategory($row["message"]);
		}
		else if($row["type"] == 2){
			$message->body = fetchItem($row["message"], $row["fromID"]);
		}
		else if($row["type"] == 3){
			$body = new stdClass();
			$body->id = $row["id"];
			$body->isActive = $row["isRead"];
			$body->message = $row["message"];
			$message->body = $body;
		}
		else if($row["type"] == 4){
			$message->body = fetchItem($row["message"], $row["fromID"], true);
		}
		
		$objArr[] = $message;
	}
	echo json_encode($objArr);
}

function fetchItem($itemID, $userID, $isBoostRequest = false){
	global $conn;
	$query = "SELECT * FROM item WHERE id=".$itemID;
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	$body = new stdClass();
	if(mysqli_num_rows($result) > 0){
		$body->id = $row["id"];
		$body->title = $row["title"];
		$body->isActive = $row["isactive"];
		$body->category = harvestCategory($row["category"]);
		$body->pay = getPayAmount($row["status"], $userID);
		$body->status = $row["status"];
		if($isBoostRequest) $body->isBoost = true;
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
		$body->status = $row["status"];	//category type: regular, brand/shop
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
?>