<?php
include "mysql_config.php";

if(isset($_REQUEST["tableID"]) && isset($_REQUEST["parentID"])){
	$tableID = $_REQUEST["tableID"];
	$parentID = $_REQUEST["parentID"];
	$query = "";

	if($tableID == 1){
		$query = "SELECT *, (SELECT COUNT(*) FROM category2 WHERE parent=category1.id) AS count_category_children, (SELECT COUNT(*) FROM item WHERE category=CONCAT('c1_', category1.id)) AS count_item_children FROM category1";
	}
	else if($tableID == 4){
		$query = "SELECT *, 0 AS count_category_children, (SELECT COUNT(*) FROM item WHERE category=CONCAT('c4_', category4.id)) AS count_item_children  FROM category".$tableID." WHERE parent=".$parentID;
	}
	else {
		$query = "SELECT *, (SELECT COUNT(*) FROM category".($tableID+1)." WHERE parent=category".$tableID.".id) AS count_category_children, (SELECT COUNT(*) FROM item WHERE category=CONCAT('c".$tableID."_', category".$tableID.".id)) AS count_item_children FROM category".$tableID." WHERE parent=".$parentID;
	}
	
	if(isset($_COOKIE["userID"])) $query .= " ORDER BY FIELD(userID, ".$_COOKIE["userID"].") DESC, status DESC";
	else $query .= " ORDER BY status DESC";
	
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
	
	foreach($arr_list as $key => $value){
		if($key == "title") $arr_list[$key] = stripslashes(htmlspecialchars_decode($value));
	}
	
	echo json_encode($arr_list);

	mysqli_close($conn);	
}
else {
	echo "Ангиллын жагсаалтыг харуулах үед алдаа гарлаа!";
}
?>