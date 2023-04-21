<?php
include "mysql_config.php";

function chat_remove($type, $message){
	global $conn;
	$query = "DELETE FROM chat WHERE type=".$type." AND message='".$message."'";
	if($conn->query($query)){
		return true;
	}
	else {
		return false;
	}
}
?>