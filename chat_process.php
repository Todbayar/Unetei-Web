<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";

if(isset($_REQUEST["fromID"]) && isset($_REQUEST["toID"]) && isset($_REQUEST["type"]) && isset($_REQUEST["message"])){
	chat_send($_REQUEST["fromID"], $_REQUEST["toID"], $_REQUEST["type"], htmlspecialchars(addslashes($_REQUEST["message"])), true, false);
}

function chat_send($from, $to, $type, $message, $isPrint = true, $isEdit = false){
	global $conn, $smtp_host, $smtp_port, $smtp_username, $smtp_password;
	if($message != ""){
		$type_a = $type!==4?$type:2;
		if(!isChatExist($from, $to, $type_a, $message)){
			$query = "INSERT INTO chat (fromID, toID, type, message, isRead, datetime) VALUES (".$from.", ".$to.", ".$type_a.", '".$message."', 0, '".date("Y-m-d H:i:s")."')";
			if($type==4) $query = "INSERT INTO chat (fromID, toID, type, message, isRead, datetime, action) VALUES (".$from.", ".$to.", ".$type_a.", '".$message."', 0, '".date("Y-m-d H:i:s")."', ".BOOST.")";
			if($conn->query($query)){
//				sendNotification("?page=chat&toID=".$to, $from);				
				if($isPrint) echo "OK";
			}
			else {
				if($isPrint) echo "Fail";
			}
		}
		else {
			$query = "UPDATE chat SET isRead=0, isNotified=0, datetime='".date("Y-m-d H:i:s")."'";
			if($isEdit) $query .= ", action=".EDIT;
			if($type==4) $query .= ", action=".BOOST;
			$query .= " WHERE fromID=".$from." AND toID=".$to." AND type=".$type_a." AND message='".$message."'";
			if($conn->query($query)){
//				sendNotification("?page=chat&toID=".$to, $from);
				if($isPrint) echo "OK";
			}
			else {
				if($isPrint) echo "Fail";
			}
		}
	}	
}

function isChatExist($from, $to, $type, $message){
	global $conn;
	$query = "SELECT * FROM chat WHERE fromID=".$from." AND toID=".$to." AND type=".$type." AND message='".$message."'";
	$result = $conn->query($query);
	if(mysqli_num_rows($result) > 0){
		return true;
	}
	else {
		return false;
	}
}
?>