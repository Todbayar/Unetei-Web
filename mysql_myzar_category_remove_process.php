<?php
include "mysql_config.php";
include "chat_remove.php";

if(isset($_REQUEST["tableID"]) && isset($_REQUEST["rowID"])){
	$queryFetchIcon = "SELECT icon FROM category".$_REQUEST["tableID"]." WHERE id=".$_REQUEST["rowID"];
	$resultFetchIcon = $conn->query($queryFetchIcon);
	$rowFetchIcon = mysqli_fetch_array($resultFetchIcon);
	unlink("./user_files/".$rowFetchIcon["icon"]);
	
	$queryRemove = "DELETE FROM category".$_REQUEST["tableID"]." WHERE id=".$_REQUEST["rowID"];
	if($conn->query($queryRemove)){
		if(chat_remove(1, "c".$_REQUEST["tableID"]."_".$_REQUEST["rowID"])){
			echo "OK";
		}
		else {
			echo "Ангиллыг устгах явцад алдаа гарлаа!";
		}
	}
	else {
		echo "Ангиллыг устгах явцад алдаа гарлаа!";
	}
}

mysqli_close($conn);
?>