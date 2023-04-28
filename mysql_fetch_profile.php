<?php
include "mysql_config.php";
include "info.php";

$phone = $_POST["affiliate"] != "" ? $_POST["affiliate"] : $superduperadmin;
$query = "SELECT * FROM user WHERE phone='+976".$superduperadmin."'";
$result = $conn->query($query);
$row = mysqli_fetch_array($result);

$obj = new stdClass;
$obj->role = $row["role"];
$obj->name = $row["name"];
$obj->phone = $row["phone"];

echo json_encode($obj);
?>