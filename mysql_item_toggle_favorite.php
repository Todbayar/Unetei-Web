<?php
include "mysql_config.php";

if(isset($_POST["id"])){
	$queryExist = "SELECT * FROM favorite WHERE itemID=".$_POST["id"]." AND userID=".$_COOKIE["userID"];
	$resultExist = $conn->query($queryExist);
	if(mysqli_num_rows($resultExist)>0){
		$queryDelete = "DELETE FROM favorite WHERE itemID=".$_POST["id"]." AND userID=".$_COOKIE["userID"];
		$conn->query($queryDelete);
	}
	else {
		$queryInsert = "INSERT INTO favorite (itemID, userID) VALUES(".$_POST["id"].",".$_COOKIE["userID"].")";
		$conn->query($queryInsert);
	}
}
?>