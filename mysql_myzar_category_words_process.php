<?php
include "mysql_config.php";

if(isset($_GET["id"])){
	$words = "";
	wordsHarvester(1, $_GET["id"]);
	echo json_encode(array_unique(explode(',', trim($words, ','))));
}

function wordsHarvester($tableID, $id){
	global $conn, $words;
	if($tableID <= 4){
		$query = "SELECT id, words FROM category".$tableID;
		
		if($tableID == 1){
			$query .= " WHERE id=".$id;
		}
		else {
			$query .= " WHERE parent=".$id;
		}
		
		$result = $conn->query($query);
		while($row = mysqli_fetch_array($result)){
			$words .= ",".$row["words"];	
			wordsHarvester($tableID+1, $row["id"]);
		}
	}
}
?>