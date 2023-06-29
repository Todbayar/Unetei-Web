<?php
include "mysql_config.php";

date_default_timezone_set("Asia/Ulaanbaatar");

$uID = $_REQUEST["uid"];
$uPhone = $_REQUEST["phone"];
$userID = 0;
$uRole = 0;

if(isset($uID) && isset($uPhone)){
	$query = "SELECT * FROM user WHERE phone='".$uPhone."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_array($result);
		$userID = $row["id"];
		$uRole = $row["role"];
		SaveCookie();
		
		@$conn->query("UPDATE user SET uid='".$uID."', lastlogged='".date("Y-m-d h:i:s")."' WHERE phone='".$uPhone."'");
		
		echo $_COOKIE["userID"];
	}
	else {
		$query = "INSERT INTO user (uid, phone, role, status, signed, lastlogged) values ('".$uID."','".$uPhone."', 0, 1, '".date("Y-m-d")."','".date("Y-m-d h:i:s")."')";
		$result = $conn->query($query);
		if ($result) {
			$userID = mysqli_insert_id($conn);
			SaveCookie();
			echo $_COOKIE["userID"];
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
	global $uID, $uPhone, $userID, $uRole;
	$cookieTime = time() + (86400 * 30);	//30 day, 86400=1
	setcookie("userID", $userID, $cookieTime, "/");
	setcookie("uid", $uID, $cookieTime, "/");
	setcookie("phone", $uPhone, $cookieTime, "/");
	setcookie("role", $uRole, $cookieTime, "/");
}

$conn->close();
?>