<?php
include "mysql_config.php";

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
		$limit = " LIMIT 10";
		//fetch first vip
		echo $queryVip = "SELECT * FROM item WHERE status=2 AND".substr($search, 0, strrpos($search, "AND")).$order.$limit;
		$resultVip = $conn->query($queryVip);
		while($rowVip = mysqli_fetch_object($resultVip)){
			$arr[] = $rowVip;
		}
		//fetch first special
		$querySpecial = "SELECT * FROM item WHERE status=1 AND".substr($search, 0, strrpos($search, "AND")).$order.$limit;
		$resultSpecial = $conn->query($querySpecial);
		while($rowSpecial = mysqli_fetch_object($resultSpecial)){
			$arr[] = $rowSpecial;
		}
		//fetch first regular
		$queryRegular = "SELECT * FROM item WHERE status=0 AND".substr($search, 0, strrpos($search, "AND")).$order.$limit;
		$resultRegular = $conn->query($queryRegular);
		while($rowRegular = mysqli_fetch_object($resultRegular)){
			$arr[] = $rowRegular;
		}
		echo json_encode($arr);
	}
	else {
		$limit = " LIMIT 60";
		echo $query = "SELECT * FROM item WHERE status=".$_POST["type"]." AND ".substr($search, 0, strrpos($search, "AND")).$order.$limit;
		$result = $conn->query($query);
		while($rowRegular = mysqli_fetch_object($result)){
			$arr[] = $row;
		}
		echo json_encode($arr);
	}
}
?>