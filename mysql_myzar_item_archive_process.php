<?php
include "mysql_config.php";

if(isset($_GET["id"])){
	$query = "UPDATE item SET isactive=2 WHERE id=".$_GET["id"];
	if($conn->query($query)){
		echo "OK";
	}
	else {
		echo "Fail";
	}
}
?>