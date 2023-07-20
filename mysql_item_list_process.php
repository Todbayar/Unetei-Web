<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";

$search = " isactive=4 AND";
$order = "";
$orderPlus = "ORDER BY count_images DESC";
$favorite = "";
$priceLowest = 0;
$priceHighest = 0;

if(isset($_COOKIE["userID"])){
	$favorite = "(SELECT IF(COUNT(*)>0, 1, 0) FROM favorite WHERE itemID=item.id AND userID=".$_COOKIE["userID"].") AS isFavorite,";
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

if(isset($_POST["quality"]) && $_POST["quality"] != ""){
	if($_POST["quality"]==0){
		if($order!="") $order .= ",quality DESC";
		else $order .= "ORDER BY quality DESC";
	}
	else if($_POST["quality"]==1){
		if($order!="") $order .= ",quality ASC";
		else $order .= "ORDER BY quality ASC";
	}
}

if(isset($_POST["rate"]) && $_POST["rate"] != ""){
	if($_POST["rate"] == 0){
		if($order!="") $order .= ",((item_viewer+phone_viewer)/2) DESC";
		else $order = "ORDER BY ((item_viewer+phone_viewer)/2) DESC";
	}
	else if($_POST["rate"] == 1){
		if($order!="") $order .= ",((item_viewer+phone_viewer)/2) ASC";
		else $order = "ORDER BY ((item_viewer+phone_viewer)/2) ASC";
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

if(isset($_POST["userID"]) && $_POST["userID"]!=-1){
	$search .= " userID=".$_POST["userID"]." AND";
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
		
		if($order!="") $orderPlus = ",count_images DESC";
		
		//fetch first vip
		$queryCountItems = "SELECT * FROM item WHERE status=2 AND".substr($search, 0, strrpos($search, "AND"));
		$rowCountItems = mysqli_num_rows($conn->query($queryCountItems));
		$totalCountItems = $rowCountItems;
		
		$queryVip = "SELECT *, ".$favorite." (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id ORDER BY sort ASC LIMIT 1) AS image FROM item WHERE status=2 AND".substr($search, 0, strrpos($search, "AND")).$order.$orderPlus.$limit;
		$resultVip = $conn->query($queryVip);
		while($rowVip = mysqli_fetch_object($resultVip)){
			$arr["data"][] = $rowVip;
		}
		
		//fetch first special
		$queryCountItems = "SELECT * FROM item WHERE status=1 AND".substr($search, 0, strrpos($search, "AND"));
		$rowCountItemsSpecial = mysqli_num_rows($conn->query($queryCountItems));
		$totalCountItems += $rowCountItemsSpecial;
		if($rowCountItems<$rowCountItemsSpecial) $rowCountItems=$rowCountItemsSpecial;
		
		$querySpecial = "SELECT *, ".$favorite." (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id ORDER BY sort ASC LIMIT 1) AS image FROM item WHERE status=1 AND".substr($search, 0, strrpos($search, "AND")).$order.$orderPlus.$limit;
		$resultSpecial = $conn->query($querySpecial);
		while($rowSpecial = mysqli_fetch_object($resultSpecial)){
			$arr["data"][] = $rowSpecial;
		}
		
		//fetch first regular
		$queryCountItems = "SELECT * FROM item WHERE status=0 AND".substr($search, 0, strrpos($search, "AND"));
		$rowCountItemsRegular = mysqli_num_rows($conn->query($queryCountItems));
		$totalCountItems += $rowCountItemsRegular;
		if($rowCountItems<$rowCountItemsRegular) $rowCountItems=$rowCountItemsRegular;
		
		$queryRegular = "SELECT *, ".$favorite." (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id ORDER BY sort ASC LIMIT 1) AS image FROM item WHERE status=0 AND".substr($search, 0, strrpos($search, "AND")).$order.$orderPlus.$limit;
		$resultRegular = $conn->query($queryRegular);
		while($rowRegular = mysqli_fetch_object($resultRegular)){
			$arr["data"][] = $rowRegular;
		}
		
		$arr["page"]["offset"] = $_POST["page"];	//index
		$arr["page"]["perpage"] = $pageCount;
		$arr["page"]["countItems"] = $totalCountItems;
		$arr["page"]["countPages"] = ceil($rowCountItems/$pageCount);
//		$arr["query"] = $queryRegular;
		
		echo json_encode($arr);
	}
	else {
		$arr = array();
		$pageCount = $pageCountList;
		$pageOffset = $_POST["page"]*$pageCount;
		$limit = " LIMIT ".$pageOffset.",".$pageCount;
		
		$queryCountItems = "SELECT * FROM item WHERE ".substr($search, 0, strrpos($search, "AND"));
		$rowCountItems = mysqli_num_rows($conn->query($queryCountItems));
		
		$arr["page"]["offset"] = $_POST["page"];	//index
		$arr["page"]["perpage"] = $pageCount;
		$arr["page"]["countItems"] = $rowCountItems;
		$arr["page"]["countPages"] = ceil($rowCountItems/$pageCount);
//		$arr["queryPage"] = $queryCountItems;
		
		if($order!="") $orderPlus = ",count_images DESC";
		
		$query = "SELECT *, ".$favorite." (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id ORDER BY sort ASC LIMIT 1) AS image FROM item WHERE ".substr($search, 0, strrpos($search, "AND")).$order.$orderPlus.$limit;
//		$arr["query"] = $query;
		$result = $conn->query($query);
		while($row = mysqli_fetch_object($result)){
			$arr["data"][] = $row;
		}
		echo json_encode($arr);
	}
}
?>