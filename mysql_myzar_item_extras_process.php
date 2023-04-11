<?php
include "mysql_config.php";

if(isset($_GET["category"])){
	$tableID = substr($_GET["category"], 1, strripos($_GET["category"], '_')-1);
	$id = substr($_GET["category"], strripos($_GET["category"], '_')+1);
	$query = "SELECT words FROM category".$tableID." WHERE id=".$id;
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	if($row["words"] != ""){
		echo json_encode(explode(',', $row["words"]));
	}
	else {
		echo "";
	}
}
?>