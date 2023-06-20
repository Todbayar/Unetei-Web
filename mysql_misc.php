<?php
include_once "mysql_config.php";
include_once "info.php";

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

function fetchRecursiveCategories($category, $conn, $isInit){
	$categories = [];
	
	if($isInit) $categories[] = $category;
	
	$splita = explode("_", trim($category,"'"));
	$tableID = intval(substr($splita[0], 1));
	$id = intval($splita[1]);
	
	$query = "SELECT id FROM category".($tableID+1)." WHERE parent=".$id." AND active=2";
	$result = $conn->query($query);
	while($row = mysqli_fetch_array($result)){
		$categories[] = "'c".($tableID+1)."_".$row["id"]."'";
		$categories = array_merge($categories, fetchRecursiveCategories("'c".($tableID+1)."_".$row["id"]."'", $conn, false));
	}
	
	return $categories;
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

//function sendNotification($title, $body, $image, $link, $token, $authKey){
////	$conn = common::createConnection();
//    
//    $data = [
//        "notification" => [
//            "body"  => $body,
//            "title" => $title,
//            "image" => $image
//        ],
//        "priority" =>  "high",
//        "data" => [
//            "click_action"  =>  "FLUTTER_NOTIFICATION_CLICK",
//            "id"            =>  "1",
//            "status"        =>  "done",
//            "info"          =>  [
//                "title"  => $title,
//                "link"   => $link,
//                "image"  => $image
//            ]
//        ],
//		//<YOUR_FIREBASE_TOKEN>
//        "to" => $token
//    ];
//
//    $ch = curl_init();
//
//    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//    curl_setopt($ch, CURLOPT_POST, 1);
//
//    $headers = array();
//    $headers[] = 'Content-Type: application/json';
//    $headers[] = 'Authorization: key='.$authKey;
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//
//    $result = curl_exec($ch);
//    curl_close ($ch);
//    
//    echo "request sent";
//}
?>