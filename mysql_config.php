<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unetei";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("<MySQL Connection>:".$conn->connect_error);
}

$conn->set_charset("utf8");
?>