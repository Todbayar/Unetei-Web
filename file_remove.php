<?php
include "mysql_config.php";
include_once "info.php";

if(isset($_REQUEST["file"])){
	$query = "DELETE FROM images WHERE image='".$_REQUEST["file"]."' AND userID=".$_COOKIE["userID"];
	@$conn->query($query);
	if(file_exists($path.DIRECTORY_SEPARATOR.$_REQUEST["file"])) @unlink("user_files".DIRECTORY_SEPARATOR.$_REQUEST["file"]);
	echo "OK";
}
?>