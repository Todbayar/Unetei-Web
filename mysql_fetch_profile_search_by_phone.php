<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";

if(isset($_POST["phone"]) && $_POST["phone"]!="+976"){
	$query = "SELECT * FROM user WHERE phone LIKE '".$_POST["phone"]."%' AND phone!='+976' AND role>0 AND status=1 ORDER BY lastlogged DESC LIMIT 10";
	$result = $conn->query($query);
	$users = array();
	while($row = mysqli_fetch_array($result)){
		if($row["id"]!=$_COOKIE["userID"]){
			$user = new stdClass();
			$user->id = $row["id"];
			$user->name = $row["name"];
			$user->image = $row["image"];
			$user->phone = $row["phone"];
			$user->role = $row["role"];
			$users["users"][] = $user;
		}
	};
//	$users["query"] = $query;
	echo json_encode($users);
}
else {
	echo "[]";
}
?>