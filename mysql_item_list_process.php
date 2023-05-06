<?php
include "mysql_config.php";

$query = "SELECT * FROM item";
$result = $conn->query($query);
$arr = array();
while($row = mysqli_fetch_object($result)){
	$arr[] = $row;
}
echo json_encode($arr);
?>