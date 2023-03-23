<?php
include "mysql_config.php";

$uid = $_REQUEST["uid"];
$tableID = $_REQUEST["tableID"];
$parentID = $_REQUEST["parentID"];

$query = "";

if($tableID == 1){ 
	$query = "SELECT *, (SELECT COUNT(*) FROM category2 WHERE parent=category1.id) AS count_category_children  FROM category1";
}
else if($tableID == 4){
	$query = "SELECT *, 0 AS count_category_children  FROM category".$tableID." WHERE parent=".$parentID;
}
else {
	$query = "SELECT *, (SELECT COUNT(*) FROM category".($tableID+1)." WHERE parent=category".$tableID.".id) AS count_category_children  FROM category".$tableID." WHERE parent=".$parentID;
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