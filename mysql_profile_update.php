<?php
include "mysql_config.php";
include "info.php";

if(isset($_REQUEST["userID"]) && isset($_REQUEST["name"]) && isset($_REQUEST["email"]) && isset($_REQUEST["city"])){
	$vNewFile = isset($_FILES["image"]) ? date("Ymdhis")."_".$_FILES["image"]["name"] : "";
	$vSocialPay = (isset($_FILES["socialpay"])) ? date("Ymdhis")."_".$_FILES["socialpay"]["name"] : "";
	
	$query = "UPDATE user SET name='".$_REQUEST["name"]."', email='".$_REQUEST["email"]."', city='".$_REQUEST["city"]."', affiliate='+976".$_REQUEST["affiliate"]."', bank_name='".$_REQUEST["bank_name"]."', bank_owner='".$_REQUEST["bank_owner"]."', bank_account='".$_REQUEST["bank_account"]."'";
	
	if($vNewFile != ""){
		$query .= ", image='".$vNewFile."'";
		move_uploaded_file($_FILES["image"]["tmp_name"], $path.DIRECTORY_SEPARATOR.$vNewFile);
	}
	
	if($vSocialPay != ""){
		$query .= ", socialpay='".$vSocialPay."'";
		move_uploaded_file($_FILES["socialpay"]["tmp_name"], $path.DIRECTORY_SEPARATOR.$vSocialPay);
	}
	
	$query .= " WHERE id=".$_REQUEST["userID"];
	
	if($conn->query($query)){
		echo "OK";
	}
	else {
		echo "Fail";
	}
}
?>