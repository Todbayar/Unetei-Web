<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";

if(isset($_REQUEST["action"]) && isset($_REQUEST["type"]) && isset($_REQUEST["id"]) && isset($_REQUEST["chatID"])){
	$type = $_REQUEST["type"];
	$action = $_REQUEST["action"];
	$id = $_REQUEST["id"];
	$chatID = $_REQUEST["chatID"];
	
	if($type == 0){		//category
		@$conn->query("UPDATE chat SET isNotified=0, action=".RESPOND." WHERE id=".$chatID);
		
		$category = explode("_", $id);
		$query = "UPDATE category".$category[0];
		if($action == 0){
			$query .= " SET active=2";
		}
		else if($action == 1){
			$query .= " SET active=1";
		}
		$query .= " WHERE id=".$category[1];
		
		if($conn->query($query)){
			echo "OK";
		}
		else {
			echo "Fail";
		}
	}
	else if($type == 1){	//item
		$rowChat = getChat($chatID);
		if($rowChat["action"]==EDIT){
			@$conn->query("UPDATE chat SET isNotified=0, action=".RESPOND." WHERE id=".$chatID);
		}
		else if($rowChat["action"]==BOOST){
			@$conn->query("UPDATE chat SET isNotified=0, action=".RESPOND." WHERE id=".$chatID);
		}
		else {
			$note = $rowChat["note"];
			if($note==""){
				$note = new stdClass();
				$note->payment = array();
			}
			else {
				$note = json_decode($note);
			}

			$payment = new stdClass();
			$payment->datetime = date("Y-m-d h:i:s");

			if($action == 0){
				$payment->isPaid = true;
			}
			else if($action == 1) {
				$payment->isPaid = false;
			}

			$note->payment[] = $payment;
			@$conn->query("UPDATE chat SET note='".json_encode($note)."', isNotified=0, action=".RESPOND." WHERE id=".$chatID);
		}
		
		$query = "UPDATE";
		if($action == 0){
			$query .= " item SET isactive=4, boost=NULL";
		}
		else if($action == 1) {
			$query .= " item SET isactive=3, boost=NULL";
		}
		else if($action == 2){
			$query .= " item SET boost=DATE_ADD(NOW(), INTERVAL ".BOOST_DAYS." DAY)";
		}
		$query .= " WHERE id=".$id;
		
		if($conn->query($query)){
			echo "OK";
		}
		else {
			echo "Fail";
		}
	}
	else if($type == 2){	//role
		$queryFetchRole = "SELECT fromID, message FROM chat WHERE id=".$id;
		$resultFetchRole = $conn->query($queryFetchRole);
		$rowFetchRole = mysqli_fetch_array($resultFetchRole);

		$requestedRole = 0;
		if(str_contains($rowFetchRole["message"], $role_rank_superadmin)){
			$requestedRole = 4;
		}
		else if(str_contains($rowFetchRole["message"], $role_rank_admin)){
			$requestedRole = 3;
		}
		else if(str_contains($rowFetchRole["message"], $role_rank_manager)){
			$requestedRole = 2;
		}
		else if(str_contains($rowFetchRole["message"], $role_rank_publisher)){
			$requestedRole = 1;
		}
		$queryUpdateRole = "UPDATE user SET role=".$requestedRole." WHERE id=".$rowFetchRole["fromID"];
		
		$note = getChat($chatID)["note"];
		if($note==""){
			$note = new stdClass();
			$note->payment = array();
		}
		else {
			$note = json_decode($note);
		}
		$payment = new stdClass();
		if($action == 0){
			$payment->isPaid = true;
		}
		else if($action == 1){
			$payment->isPaid = false;
		}
		$payment->datetime = date("Y-m-d h:i:s");
		$note->payment[] = $payment;
		$query = "UPDATE chat SET isRead=1, note='".json_encode($note)."', isNotified=0, action=".RESPOND." WHERE id=".$id;
		
		if($action == 0){
			if(intval(getUserRole($_COOKIE["userID"]))>=$requestedRole){
				@$conn->query($queryUpdateRole);

				if($conn->query($query)){
					echo "OK";
				}
				else {
					echo "Fail";
				}
			}
			else {
				echo "FAIL_ROLE";
			}
		}
		else if($action == 1) {
			if($conn->query($query)){
				echo "OK";
			}
			else {
				echo "Fail";
			}
		}
	}
}

function getChat($chatID){
	global $conn;
	return mysqli_fetch_array($conn->query("SELECT * FROM chat WHERE id=".$chatID));
}
?>