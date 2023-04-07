<?php
include "mysql_config.php";

if(isset($_REQUEST["categories"])){
	$categories = json_decode($_REQUEST["categories"]);
	$tableID = 1;
	$tmpWords = "";
	$tmpID = -1;
	
	if(count($categories) > 0){
		foreach($categories as $category){
			$query = "SELECT id, words FROM category".$tableID." WHERE title='".$category->title."'";
			$result = $conn->query($query);
			while($row = mysqli_fetch_array($result)){
				if($row["words"] != ""){
					$tmpWords .= ",".$row["words"];
				}
				$tmpID = $row["id"];
			}
			$tableID++;
		}
		for($i=$tableID; $i<=4; $i++){
			$query = "SELECT id, words FROM category".$i." WHERE parent=".$tmpID;
			$result = $conn->query($query);
			while($row = mysqli_fetch_array($result)){
				if($row["words"] != ""){
					$tmpWords .= ",".$row["words"];
				}
				$tmpID = $row["id"];
			}
		}
	}
	
	$vWords = explode(',', substr($tmpWords, 1, strlen($tmpWords)));
	echo json_encode(array_unique($vWords));
}
?>