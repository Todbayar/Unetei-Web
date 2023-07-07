<?php
include "mysql_config.php";

if(isset($_POST["phone"])){
	if($conn->query("UPDATE user SET affiliate='+976".$_POST["phone"]."' WHERE id=".$_COOKIE["userID"])){
		echo "OK";
	}
	else {
		echo "FAIL";
	}
}
?>