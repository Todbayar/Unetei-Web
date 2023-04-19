<?php
include "mysql_config.php";

function update_profile($name, $email, $city, $userID, $image = null){
	global $conn;
	$query = "UPDATE user SET name='".$name."', email='".$email."', city='".$city."' WHERE id=".$userID;
	if(!is_null($image)) $query = "UPDATE user SET name='".$name."', email='".$email."', city='".$city."', image='".$image."' WHERE id=".$userID;
	$conn->query($query);
}

mysqli_close($conn);
?>