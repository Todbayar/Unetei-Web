<?php
include "mysql_config.php";

if(isset($_GET["id"])){
	echo $query = "SELECT *, (SELECT name FROM user WHERE id=fromID) AS sender_name, (SELECT image FROM user WHERE id=fromID) AS sender_image, (SELECT name FROM user WHERE id=toID) AS receiver_name, (SELECT image FROM user WHERE id=toID) AS receiver_image FROM chat WHERE toID=".$_GET["id"]." ORDER BY datetime ASC";
	$result = $conn->query($query);
	$objArr = array();
	while($row = mysqli_fetch_array($result)){
		
	}
}
?>