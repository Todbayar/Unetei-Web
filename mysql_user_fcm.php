<?php
include "mysql_config.php";

if(isset($_POST["token"])){
	$updateQuery = "UPDATE user SET token='".$_POST["token"]."' WHERE id=".$_COOKIE["userID"];
	$conn->query($updateQuery);
}
?>