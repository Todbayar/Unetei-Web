<?php
include "mysql_config.php";
$uID = $_REQUEST["uid"];
$uPhone = $_REQUEST["phone"];
if(isset($uID) && isset($uPhone)){
	$query = "SELECT id FROM user WHERE uid='".$uID."'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		echo "OK";
	}
	else {
		$query = "INSERT INTO user (uid, phone, role, status) values ('".$uID."','".$uPhone."', 0, 1)";
		if ($conn->query($query) === TRUE) {
			echo "OK";
		} 
		else {
			echo "<userLogin.php>:error-18:".$conn->error;
		}
	}
}
else {
	echo "<userLogin.php>:error-23";
}

$conn->close();
?>