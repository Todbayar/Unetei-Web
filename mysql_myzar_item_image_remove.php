<?php
include "mysql_config.php";
include "info.php";

if(isset($_POST["id"])){
	$queryImage = "SELECT image FROM images WHERE id=".$_POST["id"];
	$resultImage = $conn->query($queryImage);
	$rowImage = mysqli_fetch_array($resultImage);
	$fileImage = $path.DIRECTORY_SEPARATOR.$rowImage["image"];
	if(file_exists($fileImage)) @unlink($fileImage);
	$query = "DELETE FROM images WHERE id=".$_POST["id"];
	@$conn->query($query);
}
?>