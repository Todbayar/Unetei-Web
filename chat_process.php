<?php
include "mysql_config.php";

function chat_send($from, $to, $type, $message){
	$query = "INSERT INTO chat (fromID, toID, type, message, isRead, datetime) VALUES (".$from.", ".$to.", ".$type.", '".$message."', 0, '".date("Y-m-d H:i:s")."')";
	$conn->query($query);
}
?>