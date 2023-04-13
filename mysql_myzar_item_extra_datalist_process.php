<?php
include "mysql_config.php";

if(isset($_GET["key"]) && isset($_GET["category"])){
	$extraOptions = "";
	$query = "SELECT extras FROM item WHERE category='".$_GET["category"]."'";
	$result = $conn->query($query);
	while($row = mysqli_fetch_array($result)){
		$jsonObjs = json_decode(stripslashes(htmlspecialchars_decode($row["extras"])));
		foreach($jsonObjs as $obj){
			foreach($obj as $key => $value) {
				if($key == $_GET["key"] && $value != "") $extraOptions .= ",".trim($value);
			}
		}
	}
	echo json_encode(array_unique(explode(',', trim($extraOptions, ','))));
}
?>