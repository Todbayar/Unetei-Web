<?php
include "mysql_config.php";

if(isset($_REQUEST["uid"]) && isset($_REQUEST["phone"])){
	echo UserLogin($_REQUEST["phone"], $_REQUEST["uid"]);
}

function UserLogin($phone, $uid){
	global $conn;
	$query = "SELECT * FROM user WHERE phone='".$phone."'";
	$result = $conn->query($query);
	if($result->num_rows > 0){
		$row = mysqli_fetch_array($result);
		$userID = $row["id"];
		SaveCookie($userID);
		@$conn->query("UPDATE user SET uid='".$uid."', lastlogged='".date("Y-m-d h:i:s")."' WHERE phone='".$phone."'");
		echo $userID;
	}
	else {
		$query = "INSERT INTO user (uid, phone, role, status, signed, lastlogged) values ('".$uid."','".$phone."', 0, 1, '".date("Y-m-d h:i:s")."','".date("Y-m-d h:i:s")."')";
		$result = $conn->query($query);
		if ($result) {
			$userID = mysqli_insert_id($conn);
			SaveCookie($userID);
			echo $userID;
		}
		else {
			echo '{"response":"fail"}';
		}
	}
}

function SaveCookie($userID){
	$cookieTime = time() + (86400 * 30);	//30 day, 86400=1
	setcookie("userID", $userID, $cookieTime, "/");
}
?>