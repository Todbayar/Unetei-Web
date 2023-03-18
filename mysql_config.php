<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unetei";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("MySQL Connection failed: " . $conn->connect_error);
}
?>