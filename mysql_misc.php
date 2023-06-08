<?php
include "mysql_config.php";
include "info.php";

function update_profile($name, $email, $city, $userID, $image = null){
	global $conn;
	$query = "UPDATE user SET name='".$name."', email='".$email."', city='".$city."' WHERE id=".$userID;
	if(!is_null($image)) $query = "UPDATE user SET name='".$name."', email='".$email."', city='".$city."', image='".$image."' WHERE id=".$userID;
	$conn->query($query);
}

function getAffiliateID($id){
	global $superduperadmin, $conn;
	$resultAffiliate = $conn->query("SELECT (SELECT id FROM user WHERE phone=u.affiliate) AS affiliate_id FROM user AS u WHERE id=".$id);
	$rowAffiliate = mysqli_fetch_array($resultAffiliate);
	$resultSuperDuper = $conn->query("SELECT id FROM user WHERE phone=".$superduperadmin);
	$rowSuperDuper = mysqli_fetch_array($resultSuperDuper);
	return ($rowAffiliate["affiliate_id"] != null && $rowAffiliate["affiliate_id"] != "") ? $rowAffiliate["affiliate_id"] : $rowSuperDuper["id"];
}

function getCountListCategory(){
	global $conn;
	$count = 0;
	for($i=1; $i<=4; $i++){
		$count += mysqli_num_rows($conn->query("SELECT * FROM category".$i." WHERE userID=".$_COOKIE["userID"]));
	}
	return $count;
}

function convertPriceToText($price){
	$digits = explode(',', number_format($price));
	switch(count($digits)-1){
		case 4:
			return $digits[0]." ихнаяд";
		case 3:
			return $digits[0]." тэрбум";
		case 2:
			return $digits[0]." сая";
		case 1:
			return $digits[0].",000";
		case 0:
			return number_format($price);
	}
}

function convertPriceToNumber($price){
	$digits = explode(',', number_format($price));
	switch(count($digits)-1){
		case 4:
			return intval($digits[0]."000000000000");
		case 3:
			return intval($digits[0]."000000000");
		case 2:
			return intval($digits[0]."000000");
		case 1:
			return intval($digits[0]."000");
		case 0:
			return intval($price);
	}
}

function fetchRecursiveCategories($categories, $isDone){
	global $conn;
	if($categories != "" && $isDone === false){
		$tableID = 0;
		$id = 0;
		if(strpos($categories,",")!==false){
			$split = explode(",", $categories);
			$splita = explode("_", trim($split[count($split)-1],"'"));
			$tableID = intval(substr($splita[0], 1));
			$id = intval($splita[1]);
		}
		else {
			$splita = explode("_", trim($categories,"'"));
			$tableID = intval(substr($splita[0], 1));
			$id = intval($splita[1]);
		}
		
		if($tableID == 4){
			return $categories;
		}
		else {
			$query = "SELECT id FROM category".($tableID+1)." WHERE parent=".$id." AND active=2";
			$result = $conn->query($query);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					return fetchRecursiveCategories($categories.",'c".($tableID+1)."_".$row["id"]."'", false);
				}
			}
			else {
				return fetchRecursiveCategories($categories, true);
			}
		}
	}
	else {
		return $categories;
	}
}

function fetchRecursiveCategoriesDebug($categories, $isDone){
	global $conn;
	if($categories != "" && $isDone === false){
		$tableID = 0;
		$id = 0;
		if(strpos($categories,",")!==false){
			$split = explode(",", $categories);
			$splita = explode("_", trim($split[count($split)-1],"'"));
			$tableID = intval(substr($splita[0], 1));
			$id = intval($splita[1]);
		}
		else {
			$splita = explode("_", trim($categories,"'"));
			$tableID = intval(substr($splita[0], 1));
			$id = intval($splita[1]);
		}
		
		if($tableID == 4){
			return $categories;
		}
		else {
			$query = "SELECT id FROM category".($tableID+1)." WHERE parent=".$id." AND active=2";
			$result = $conn->query($query);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					return fetchRecursiveCategories($categories.",'c".($tableID+1)."_".$row["id"]."'", false);
				}
			}
			else {
				return fetchRecursiveCategories($categories, true);
			}
		}
	}
	else {
		return $categories;
	}
}

function findTypeOfVideo($name){
	$type = substr($name, strrpos($name,'.')+1);
	if($type == "mp4"){
		return "video/mp4";
   	}
	else if($type == "mov"){
		return "video/quicktime";
	}
}
?>