<?php
include "mysql_config.php";

function update_profile($name, $email, $userID){
	global $conn;
	$query = "UPDATE user SET name='".$name."', email='".$email."' WHERE id=".$userID;
	$conn->query($query);
}

function update_profile($name, $email, $image, $userID){
	global $conn;
	$query = "UPDATE user SET name='".$name."', email='".$email."', image='".$image."' WHERE id=".$userID;
	$conn->query($query);
}

mysqli_close($conn);
?>