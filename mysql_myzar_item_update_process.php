<?php
include "mysql_config.php";

if(isset($_POST["id"]) && isset($_POST["status"])){
	$days = 30;
	if($_POST["status"] == 2){
		$days = 10;
	}
	else if($_POST["status"] == 1) {
		$days = 20;
	}
	
	$query = "UPDATE item SET datetime='".date("Y-m-d h:i:s")."', isactive=1, expire_days=".$days.", status=".$_POST["status"]." WHERE id=".$_POST["id"];
	if($conn->query($query)){
		echo "OK";
	}
	else {
		echo "FAIL";
	}
}
?>