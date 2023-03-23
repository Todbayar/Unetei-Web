<?php
include "mysql_config.php";

$uid = $_REQUEST["uid"];
$tableID = $_REQUEST["tableID"];
$parentID = $_REQUEST["parentID"];

$query = "";

if($tableID == 1){
	$query = "SELECT * FROM category1 WHERE uid='".$uid."'";
}
else {
	$query = "SELECT * FROM category".$tableID." where uid='".$uid."' AND parent=".$parentID;
}

$arr_list = array();
$result = $conn->query($query);

if($result){
	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0){
		while($row = mysqli_fetch_assoc($result)){
			$arr_list[] = $row;
		}
	}
}

echo json_encode($arr_list);

mysqli_close($conn);
?>