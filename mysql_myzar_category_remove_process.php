<?php
include "mysql_config.php";

if(isset($_REQUEST["tableID"]) && isset($_REQUEST["rowID"])){
	$queryFetchIcon = "SELECT icon FROM category".$_REQUEST["tableID"]." WHERE id=".$_REQUEST["rowID"];
	$resultFetchIcon = $conn->query($queryFetchIcon);
	$rowFetchIcon = mysqli_fetch_array($resultFetchIcon);
	unlink("./user_files/".$rowFetchIcon["icon"]);
	
	$queryRemove = "DELETE FROM category".$_REQUEST["tableID"]." WHERE id=".$_REQUEST["rowID"];
	if($conn->query($queryRemove)){
		echo "OK";
	}
	else {
		echo "Ангиллыг устгах явцад алдаа гарлаа!";
	}
}

mysqli_close($conn);
?>