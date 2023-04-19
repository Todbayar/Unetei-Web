<?php
include "mysql_config.php";
include "info.php";

if(isset($_REQUEST["userID"]) && isset($_REQUEST["name"]) && isset($_REQUEST["email"]) && isset($_REQUEST["city"])){
	$vNewFile = isset($_FILES["image"]) ? date("Ymdhis")."_".$_FILES["image"]["name"] : "";
	$query = "";
	if($vNewFile != ""){
		$query = "UPDATE user SET name='".$_REQUEST["name"]."', email='".$_REQUEST["email"]."', city='".$_REQUEST["city"]."', image='".$vNewFile."' WHERE id=".$_REQUEST["userID"];
	}
	else {
		$query = "UPDATE user SET name='".$_REQUEST["name"]."', email='".$_REQUEST["email"]."', city='".$_REQUEST["city"]."' WHERE id=".$_REQUEST["userID"];
	}
	if($conn->query($query)){
		if(isset($_FILES["image"])){
			if(move_uploaded_file($_FILES["image"]["tmp_name"], $path.DIRECTORY_SEPARATOR.$vNewFile)) {
				echo "OK";
			}
			else {
				echo "Fail";
			}
		}
		else {
			echo "OK";
		}
	}
	else {
		echo "Fail";
	}
}
?>