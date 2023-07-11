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

function getPhone($id){
	global $conn;
	$query = "SELECT phone FROM user WHERE id=".$id;
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	return $row["phone"];
}

function getPayAmount($status, $userID){
	global $item_vipspecial_count_limit_admin, $item_publish_price_vip, $item_publish_price_special;
	$payAmount = 0;
	switch(getUserRole($userID)){
		case 4:
			$payAmount = 0;
		case 3:
			if(getCountItem($userID)["total"]>$item_vipspecial_count_limit_admin){
				if($status==2) $payAmount = $item_publish_price_vip;
				else if($status==1) $payAmount = $item_publish_price_special;
			}
			break;
		default:
			if($status==2) $payAmount = $item_publish_price_vip;
			else if($status==1) $payAmount = $item_publish_price_special;
			break;
	}
	return $payAmount;
}

function getCountCategory($status, $userID){
	global $conn;
	$count = 0;
	for($i=1; $i<=4; $i++){
		$queryCategory = "SELECT * FROM category".$i." WHERE status=".$status." AND userID=".$userID;
		$resultCategory = $conn->query($queryCategory);
		$count += mysqli_num_rows($resultCategory);
	}
	return $count;
}

function getCountItem($userID){
	global $conn;
	$queryItem = "SELECT (SELECT COUNT(*) FROM item WHERE status=2 AND userID=".$userID." LIMIT 1) AS vip, (SELECT COUNT(*) FROM item WHERE status=1 AND userID=".$userID." LIMIT 1) AS special;";
	$resultItem = $conn->query($queryItem);
	$rowItem = mysqli_fetch_array($resultItem);
	return array("vip"=>$rowItem["vip"], "special"=>$rowItem["special"], "total"=>$rowItem["vip"]+$rowItem["special"]);
}

function getUserRole($userID){
	global $conn;
	$queryRole = "SELECT role FROM user WHERE id=".$userID;
	$resultRole = $conn->query($queryRole);
	$rowRole = mysqli_fetch_array($resultRole);
	return $rowRole["role"];
}

function getUserIDFromItem($itemID){
	global $conn;
	$queryUserIDFromItem = "SELECT userID FROM item WHERE id=".$itemID;
	$resultUserIDFromItem = $conn->query($queryUserIDFromItem);
	$rowUserIDFromItem = mysqli_fetch_array($resultUserIDFromItem);
	return $rowUserIDFromItem["userID"];
}

function getUserIDFromPhone($phone){
	global $conn;
	$query = "SELECT id FROM user WHERE phone='".$phone."'";
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	return $row["id"];
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
		default:
			return "";
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
		default:
			return 0;
	}
}

function fetchRecursiveCategories($category, $conn, $isInit){
	$categories = [];
	
	if($isInit) $categories[] = $category;
	
	$splita = explode("_", trim($category,"'"));
	$tableID = intval(substr($splita[0], 1));
	$id = intval($splita[1]);
	
	if($tableID+1<5){
		$query = "SELECT id FROM category".($tableID+1)." WHERE parent=".$id." AND active=2";
		$result = $conn->query($query);
		if($result){
			while($row = mysqli_fetch_array($result)){
				$categories[] = "'c".($tableID+1)."_".$row["id"]."'";
				$categories = array_merge($categories, fetchRecursiveCategories("'c".($tableID+1)."_".$row["id"]."'", $conn, false));
			}
		}
		else {
			return $categories;	
		}
	}
	
	return $categories;
}

function harvestCategory($categoryID){
	global $conn;
	$arrCategories = array();
	$category = explode("_", $categoryID);
	$iteration = substr($category[0], 1, strlen($category[0]));
	$parent = 0;
	for($i=$iteration; $i>=1; $i--){
		if($parent == 0){
			$queryCategory = "SELECT * FROM category".$i." WHERE id=".$category[1];
		}
		else {
			$queryCategory = "SELECT * FROM category".$i." WHERE id=".$parent;
		}

		$resultCategory = $conn->query($queryCategory);
		$rowCategory = mysqli_fetch_array($resultCategory);
		if($i>1) $parent = $rowCategory["parent"];

		$arrCategories[] = $rowCategory["title"];
	}
	return array_reverse($arrCategories);
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

function convertRoleInString($role){
	global $role_rank_user, $role_rank_publisher, $role_rank_manager, $role_rank_admin, $role_rank_superadmin;
	$vRole = "";
	switch($role){
		case 0:
			$vRole = $role_rank_user;
			break;
		case 1:
			$vRole = $role_rank_publisher;
			break;
		case 2:
			$vRole = $role_rank_manager;
			break;
		case 3:
			$vRole = $role_rank_admin;
			break;
		case 4:
			$vRole = $role_rank_superadmin;
			break;
    }
	return $vRole;
}

function userNewAdd($uPhone){
	global $conn;
	$queryUser = "SELECT * FROM user WHERE phone='".$uPhone."'";
	$resultUser = $conn->query($queryUser);
	$rowUser = mysqli_fetch_array($resultUser);
	if(mysqli_num_rows($resultUser)>0){
		return $rowUser["id"];
	}
	else {
		if($conn->query("INSERT IGNORE INTO user (phone, role, status, affiliate) values ('".$uPhone."', 0, 1, '".getPhone($_COOKIE["userID"])."')")){
			return mysqli_insert_id($conn);	
		}
		else {
			return -1;
		}
	}
}

function getUserToken($userID){
	global $conn;
	$query = "SELECT token FROM user WHERE id=".$userID;
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	return $row["token"];
}

function sendNotification($link, $userID){
	global $domain, $protocol, $firebase_app, $firebase_auth;
	
	$title = $domain;
	$body = "Таны чатанд мэдэгдэл ирлээ.";
	$image = $protocol."//".$_SERVER['SERVER_NAME']."/watermark.png";
	
	$message = new stdClass();
	$message->token = getUserToken($userID);
	$message->notification = new stdClass();
	$message->notification->title = $title;
	$message->notification->body = $body;
	$message->webpush = new stdClass();
	$message->webpush->headers = new stdClass();
	$message->webpush->headers->Urgency = "high";
	$message->webpush->notification = new stdClass();
	$message->webpush->notification->body = $body;
	$message->webpush->notification->requireInteraction = true;
	$message->webpush->notification->badge = $image;
	$data = new stdClass();
	$data->message = $message;
	
    $ch = curl_init();
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_FAILONERROR, false);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/'.$firebase_app.'/messages:send');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = "Authorization: Bearer ".$firebase_auth;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
	$curl_error = curl_error($ch);
	$curl_error_number = curl_errno($ch);
	$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close ($ch);
	return $result.", ".$curl_error.", ".$curl_error_number.", ".$http_code.", ".json_encode($message);
}
?>