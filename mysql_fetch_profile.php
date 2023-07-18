<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";

$phone = ($_POST["affiliate"] != "" && "+976".$_POST["affiliate"] != getPhone($_COOKIE["userID"])) ? "+976".$_POST["affiliate"] : $superduperadmin;
$query = "SELECT * FROM user WHERE phone IN ('".$phone."', '".$superduperadmin."') LIMIT 1";
$result = $conn->query($query);
$row = mysqli_fetch_array($result);

$obj = new stdClass;
$obj->id = $row["id"];
$obj->role = $row["role"];
$obj->name = $row["name"];
$obj->phone = $row["phone"];

echo json_encode($obj);	
?>