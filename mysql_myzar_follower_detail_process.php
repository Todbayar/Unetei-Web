<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";

if(isset($_COOKIE["userID"]) && isset($_POST["id"])){
	$query = "SELECT * FROM user WHERE id=".$_POST["id"];
	$result = $conn->query($query);
	$row = mysqli_fetch_object($result);
	echo json_encode($row);
}
?>