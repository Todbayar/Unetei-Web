<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
include_once "mysql_userLogin.php";

if((isset($_GET["phone_validater"]) && $_GET["phone_validater"]==$phone_validater_superduperadmin) && isset($_GET["phone_user"]) && (isset($_GET["type"]) && $_GET["type"]==0)){
	//phone verifying
	$query = "INSERT INTO validater (value, type) VALUES('".$_GET["phone_user"]."',0)";
	$result = $conn->query($query);
	if($result){
		echo '{"response":"ok"}';
	}
	else {
		echo '{"response":"fail"}';
	}
}
else if((isset($_GET["phone_validater"]) && $_GET["phone_validater"]==$phone_validater_superduperadmin) && isset($_GET["phone_user"]) && (isset($_GET["type"]) && $_GET["type"]==1)){
	//from calling of SIM900A
	$phone_user = $_GET["phone_user"];
	$query = "SELECT * FROM validater WHERE value='".$phone_user."' AND type=0";
	$result = $conn->query($query);
	if(mysqli_num_rows($result)>0){
		$queryUpdate = "UPDATE validater SET type=1 WHERE value='".$phone_user."'";
		if($conn->query($queryUpdate)){
			echo '{"response":"ok"}';
		}
		else {
			echo '{"response":"fail"}';	
		}
	}
	else {
		echo '{"response":"not_found"}';
	}
}
else if((isset($_GET["phone_validater"]) && $_GET["phone_validater"]==$phone_validater_superduperadmin) && isset($_GET["phone_user"]) && (isset($_GET["type"]) && $_GET["type"]==2)){
	$phone_user = $_GET["phone_user"];
	$query = "SELECT * FROM validater WHERE value='".$phone_user."'";
	$result = $conn->query($query);
	if(mysqli_num_rows($result)>0){
		$row = mysqli_fetch_array($result);
		if($row["type"]==1){
			$queryDelete = "DELETE FROM validater WHERE value='".$phone_user."' AND type=1";
			if($conn->query($queryDelete)){
				echo UserLogin($phone_user, GUID());
			}
			else {
				echo '{"response":"fail"}';	
			}
		}
		else {
			echo '{"response":"waiting"}';	
		}
	}
	else {
		echo '{"response":"fail"}';
	}
}
else {
	echo '{"response":"no_authorization"}';
}
?>