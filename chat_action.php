<?php
include "mysql_config.php";

if(isset($_REQUEST["action"]) && isset($_REQUEST["type"]) && isset($_REQUEST["id"])){
	$type = $_REQUEST["type"];
	$action = $_REQUEST["action"];
	$id = $_REQUEST["id"];
	
	$query = "UPDATE ";
	
	if($type == 0){		//category
		$category = explode("_", $id);
		$query .= " category".$category[0];
		if($action == 0){
			$query .= " SET active=2";
		}
		else if($action == 1){
			$query .= " SET active=1";
		}
		$query .= " WHERE id=".$category[1];
	}
	else if($type == 1){	//item
		if($action == 0){
			$query .= " item SET isactive=4";
		}
		else if($action == 1) {
			$query .= " item SET isactive=3";
		}
		$query .= " WHERE id=".$id;
	}
	else if($type == 2){
		if($action == 0){
			$query = "UPDATE chat SET isRead=1 WHERE id=".$id;
		}
	}
	
	if($conn->query($query)){
		echo "OK";
	}
	else {
		echo "Fail";
	}
}
?>