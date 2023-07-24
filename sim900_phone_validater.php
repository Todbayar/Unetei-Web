<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
include_once "mysql_userLogin.php";

if(isset($_GET["phone_validater"]) && $_GET["phone_validater"]==$phone_validater_superduperadmin && isset($_GET["phone_user"])){
	$phone_user = $_GET["phone_user"];
	$query = "SELECT * FROM validater WHERE value='".$phone_user."' AND type=0";
	$result = $conn->query($query);
	if(mysqli_num_rows($result)>0){
		$queryDelete = "DELETE FROM validater WHERE value='".$phone_user."'";
		if($conn->query($queryDelete)){
			echo UserLogin($uPhone, GUID());
		}
	}
	else {
		echo "{'response':'not_found'}";
	}
}
else {
	echo "{'response':'no_authorization'}";
}
?>