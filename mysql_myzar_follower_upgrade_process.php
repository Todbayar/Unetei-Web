<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";

if(isset($_COOKIE["userID"]) && isset($_POST["id"]) && isset($_POST["role"])){
	if(getUserRole($_COOKIE["userID"])>=$_POST["role"]){
		$query = "UPDATE user SET role=".$_POST["role"]." WHERE id=".$_POST["id"];
		if($conn->query($query)){
			echo "OK";
		}
		else {
			echo "FAIL";
		}
	}
	else {
		echo "FAIL_ROLE";
	}
}
?>