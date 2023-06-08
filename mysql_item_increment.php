<?php
include "mysql_config.php";

if(isset($_POST["type"]) && isset($_POST["id"])){
	$type = "item_viewer";
	if($_POST["type"] == "phone") $type = "phone_viewer";
	$query = "UPDATE item SET ".$type."=".$type."+1 WHERE id=".$_POST["id"];
	@$conn->query($query);
}
?>