<?php
include "mysql_config.php";

if(isset($_REQUEST["action"]) && isset($_REQUEST["type"]) && isset($_REQUEST["id"])){
	$type = $_REQUEST["type"];
	$action = $_REQUEST["action"];
	$id = $_REQUEST["id"];
	
	$query = "UPDATE ";
	
	if($type == 0){
		$query .= " "	
	}
}
?>