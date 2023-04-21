<?php
include "mysql_config.php";

if(isset($_GET["id"])){
	$query = "UPDATE item SET datetime='".date("Y-m-d h:i:s")."', isactive=0 WHERE id=".$_GET["id"];
	if($conn->query($query)){
		echo "OK";
	}
	else {
		echo "Fail";
	}
}

?>