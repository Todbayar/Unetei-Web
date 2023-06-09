<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";

$search = " isactive=4 AND";
$order = "";
$priceLowest = 0;
$priceHighest = 0;

if(isset($_POST["quality"]) && $_POST["quality"] != ""){
	$search .= " quality=".$_POST["quality"]." AND";
}

if(isset($_POST["priceLowest"]) && $_POST["priceLowest"]>0){
	$priceLowest = $_POST["priceLowest"];
}

if(isset($_POST["priceHighest"]) && $_POST["priceHighest"]>0){
	$priceHighest = $_POST["priceHighest"];
}

if(isset($_POST["city"]) && $_POST["city"] != ""){
	$search .= " city='".$_POST["city"]."' AND";
}

if(isset($_POST["search"]) && $_POST["search"] != ""){
	$search .= " title LIKE '%".$_POST["search"]."%' AND";
}

if(isset($_POST["category"]) && $_POST["category"] != ""){
	$search .= " category IN (".implode(",",fetchRecursiveCategories($_POST["category"], $conn, true)).") AND";
}

if(isset($_POST["order"]) && $_POST["order"] != ""){
	switch($_POST["order"]){
		case 0:
			$order .= " ORDER BY datetime DESC";
			break;
		case 1:
			$order .= " ORDER BY datetime ASC";
			break;
		case 2:
			$order .= " ORDER BY price ASC";
			break;
		case 3:
			$order .= " ORDER BY price DESC";
			break;
	}
}

if(isset($_POST["rate"]) && $_POST["rate"] != ""){
	if($_POST["rate"] == 0){
		$order .= ",((item_viewer+phone_viewer)/2) DESC";
	}
	else if($_POST["rate"] == 1){
		$order .= ",((item_viewer+phone_viewer)/2) ASC";
	}
}

if(isset($_POST["type"])){
	switch($_POST["type"]){
		case 0:
			$search .= " status=0 AND";
			break;
		case 1:
			$search .= " status=1 AND";
			break;
		case 2:
			$search .= " status=2 AND";
			break;
	}
}

if(isset($_POST["type"])){
	if($priceLowest === $priceHighest && $priceLowest>0){
		$search = " price ".$priceLowest." AND";
	}
	else if($priceLowest < $priceHighest && $priceLowest==0){
		$search = " price<=".$priceHighest." AND";
	}
	else if($priceLowest > $priceHighest && $priceHighest==0){
		$search = " price>=".$priceLowest." AND";
	}
	else if($priceLowest < $priceHighest && $priceLowest>0 && $priceHighest>0){
		$search = " price BETWEEN ".$priceLowest." AND ".$priceHighest." AND";
	}
	else if($priceLowest > $priceHighest && $priceLowest>0 && $priceHighest>0){
		$search = " price BETWEEN ".$priceHighest." AND ".$priceLowest." AND";
	}
	
	if($_POST["type"] == -1){
		$arr = array();
		$pageCount = $pageCountHome;
		$pageOffset = $_POST["page"]*$pageCount;
		$limit = " LIMIT ".$pageOffset.",".$pageCount;
		
		//fetch first vip
		$queryCountItems = "SELECT * FROM item WHERE status=2 AND".substr($search, 0, strrpos($search, "AND"));
		$rowCountItems = mysqli_num_rows($conn->query($queryCountItems));
		$totalCountItems = $rowCountItems;
		
		$queryVip = "SELECT *, (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id LIMIT 1) AS image FROM item WHERE status=2 AND".substr($search, 0, strrpos($search, "AND")).$order.$limit;
		$resultVip = $conn->query($queryVip);
		while($rowVip = mysqli_fetch_object($resultVip)){
			$arr["data"][] = $rowVip;
		}
		
		//fetch first special
		$queryCountItems = "SELECT * FROM item WHERE status=1 AND".substr($search, 0, strrpos($search, "AND"));
		$rowCountItemsSpecial = mysqli_num_rows($conn->query($queryCountItems));
		$totalCountItems += $rowCountItemsSpecial;
		if($rowCountItems<$rowCountItemsSpecial) $rowCountItems=$rowCountItemsSpecial;
		
		$querySpecial = "SELECT *, (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id LIMIT 1) AS image FROM item WHERE status=1 AND".substr($search, 0, strrpos($search, "AND")).$order.$limit;
		$resultSpecial = $conn->query($querySpecial);
		while($rowSpecial = mysqli_fetch_object($resultSpecial)){
			$arr["data"][] = $rowSpecial;
		}
		
		//fetch first regular
		$queryCountItems = "SELECT * FROM item WHERE status=0 AND".substr($search, 0, strrpos($search, "AND"));
		$rowCountItemsRegular = mysqli_num_rows($conn->query($queryCountItems));
		$totalCountItems += $rowCountItemsRegular;
		if($rowCountItems<$rowCountItemsRegular) $rowCountItems=$rowCountItemsRegular;
		
		$queryRegular = "SELECT *, (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id LIMIT 1) AS image FROM item WHERE status=0 AND".substr($search, 0, strrpos($search, "AND")).$order.$limit;
		$resultRegular = $conn->query($queryRegular);
		while($rowRegular = mysqli_fetch_object($resultRegular)){
			$arr["data"][] = $rowRegular;
		}
		
		$arr["page"]["offset"] = $_POST["page"];	//index
		$arr["page"]["perpage"] = $pageCount;
		$arr["page"]["countItems"] = $totalCountItems;
		$arr["page"]["countPages"] = ceil($rowCountItems/$pageCount);
//		$arr["queryPage"] = $queryCountItems;
		
		echo json_encode($arr);
	}
	else {
		$arr = array();
		$pageCount = $pageCountList;
		$pageOffset = $_POST["page"]*$pageCount;
		$limit = " LIMIT ".$pageOffset.",".$pageCount;
		
		$query = "SELECT *, (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id LIMIT 1) AS image FROM item WHERE ".substr($search, 0, strrpos($search, "AND"));
		
		$queryCountItems = "SELECT * FROM item WHERE ".substr($search, 0, strrpos($search, "AND"));
		$rowCountItems = mysqli_num_rows($conn->query($queryCountItems));
		
		$arr["page"]["offset"] = $_POST["page"];	//index
		$arr["page"]["perpage"] = $pageCount;
		$arr["page"]["countItems"] = $rowCountItems;
		$arr["page"]["countPages"] = ceil($rowCountItems/$pageCount);
		$arr["query"] = $query;
		$arr["queryPage"] = $queryCountItems;
		
		$result = $conn->query($query.$order.$limit);
		while($row = mysqli_fetch_object($result)){
			$arr["data"][] = $row;
		}
		echo json_encode($arr);
	}
}
?>