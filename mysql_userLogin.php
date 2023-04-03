<?php
include "mysql_config.php";

date_default_timezone_set("Asia/Ulaanbaatar");

$uID = $_REQUEST["uid"];
$uPhone = $_REQUEST["phone"];

if(isset($uID) && isset($uPhone)){
	$query = "SELECT * FROM user WHERE uid='".$uID."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		SaveCookie();
		echo $_COOKIE["uid"];
	}
	else {
		$query = "INSERT INTO user (uid, phone, role, status) values ('".$uID."','".$uPhone."', 0, 1)";
		if ($conn->query($query) === TRUE) {
			Cookie();
			echo $_COOKIE["uid"];
		}
		else {
			echo "Fail";
		}
	}
}
else {
	echo "Fail";
}

function SaveCookie(){
	global $uID, $uPhone;
	$cookieTime = time() + (86400 * 30);	//30 day, 86400=1
	setcookie("uid", $uID, $cookieTime, "/");
	setcookie("phone", $uPhone, $cookieTime, "/");
}

$conn->close();
?>