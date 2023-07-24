<?php
include_once "mysql_config.php";
include_once "info.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "./include/PHPMailer/src/Exception.php";
require_once "./include/PHPMailer/src/PHPMailer.php";
require_once "./include/PHPMailer/src/SMTP.php";

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

function getEmail($id){
	global $conn;
	$query = "SELECT email FROM user WHERE id=".$id;
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	return $row["email"];
}

function getName($id){
	global $conn;
	$query = "SELECT name FROM user WHERE id=".$id;
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	return $row["name"];
}

function getPayAmount($status, $userID){
	global $item_vipspecial_count_limit_admin, $item_publish_price_vip, $item_publish_price_special;
	$payAmount = 0;
	$userID = $_COOKIE["userID"]!=$userID?$_COOKIE["userID"]:$userID;	//only for adding item to different user
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

function GUID(){
    if(function_exists('com_create_guid')===true){
        return trim(com_create_guid(), '{}');
    }
    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function sendNotification($link, $userID){
	global $domain, $protocol, $firebase_app, $firebase_auth2_token;
	
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
//    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');	
	echo $jsonData = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
    $headers = [
		"Authorization: Bearer ".$firebase_auth2_token,
		"Content-Type: application/json",
	];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
	$curl_error = curl_error($ch);
	$curl_error_number = curl_errno($ch);
	$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
	echo $result.", ".$curl_error.", ".$curl_error_number.", ".$http_code;
}

function sendEmail($emailReceiver, $emailSender, $nameReceiver, $nameSender, $phoneReceiver, $phoneSender, $title, $body, $isDebug=null){
	global $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smpt_secure_type, $domain, $domain_title, $protocol;
	
	$mail = new PHPMailer(true);
	try {
		//Server settings
//		$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP(); 
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		//Send using SMTP
		$mail->Host       = $smtp_host;                     		//Set the SMTP server to send through
		$mail->Port       = $smtp_port;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->SMTPSecure = $smpt_secure_type;						//ssl/tls
		
		$mail->Username   = $smtp_username;                     	//SMTP username
		$mail->Password   = $smtp_password;                         //SMTP password
		
		//Recipients
		$mail->setFrom($smtp_username, $domain);
		$mail->addAddress($emailReceiver, $nameReceiver);      //Add a recipient
//		$mail->addAddress('ellen@example.com');               		//Name is optional
//		$mail->addReplyTo('info@example.com', 'Information');
//		$mail->addCC('cc@example.com');
//		$mail->addBCC('bcc@example.com');

		//Attachments
//		$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->CharSet = "UTF-8";
		$mail->Subject = $title;
		
		$url = $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST']);
		
		$fromMsg = "";
		if($nameSender!="" && $emailSender!="" && $nameReceiver!="" && $emailReceiver!=""){
			$fromMsg = $nameReceiver." таньд <a href='".$url."'>".$domain."</a>-ны хэрэглэгч ".$nameSender."-ээс мэдэгдэл ирлээ.<br/>";
		}
		else {
			$fromMsg = $phoneReceiver." дугаартай хэрэглэгч таньд <a href='".$url."'>".$domain."</a>-ны хэрэглэгч (".$phoneSender.")-ээс мэдэгдэл ирлээ.<br/>";
		}
		
		$bodyFooter = "<br/>Та <a href='".$url."'>".$domain."</a>-руу орж чат хэсгээс мэдэгдлийн талаар илүү дэлгэрэнгүйг харна уу.";
		
		$mail->Body    = $fromMsg.$body.$bodyFooter;
//		$mail->AltBody = 'HTML биш хэрэглэгчдэд';

		$mail->send();
		
		if($isDebug=="CONSOLE"){
			?>
			<script>console.log("Message has been sent to:<?php echo $emailReceiver; ?>, from:<?php echo $emailSender; ?>");</script>
			<?php
		}
		else if($isDebug=="ECHO"){
			echo "Message has been sent to:{$emailReceiver}, from:{$emailSender}<br/>";
		}
		else {
			return true;	
		}
	}
	catch(Exception $e){
		if($isDebug=="CONSOLE"){
			?>
			<script>console.log("<?php echo "Message could not be sent. Mailer Error:{$mail->ErrorInfo}"; ?>");</script>
			<?php
		}
		else if($isDebug=="ECHO"){
			"Message could not be sent. Mailer Error:{$mail->ErrorInfo}<br/>";
		}
		else {
			return false;
		}
	}
}

function sendEmailVerification($emailReceiver, $title, $body, $isDebug=null){
	global $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smpt_secure_type, $domain, $domain_title, $protocol;
	
	$mail = new PHPMailer(true);
	try {
		//Server settings
//		$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP(); 
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		//Send using SMTP
		$mail->Host       = $smtp_host;                     		//Set the SMTP server to send through
		$mail->Port       = $smtp_port;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->SMTPSecure = $smpt_secure_type;						//ssl/tls
		
		$mail->Username   = $smtp_username;                     	//SMTP username
		$mail->Password   = $smtp_password;                         //SMTP password
		
		//Recipients
		$mail->setFrom($smtp_username, $domain);
		$mail->addAddress($emailReceiver, $nameReceiver);      //Add a recipient

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->CharSet = "UTF-8";
		$mail->Subject = $title;
		
		$mail->Body    = $body;
		$mail->send();
		
		if($isDebug=="CONSOLE"){
			?>
			<script>console.log("Message has been sent to:<?php echo $emailReceiver; ?>");</script>
			<?php
		}
		else if($isDebug=="ECHO"){
			echo "Message has been sent to:{$emailReceiver}<br/>";
		}
		else {
			return true;	
		}
	}
	catch(Exception $e){
		if($isDebug=="CONSOLE"){
			?>
			<script>console.log("<?php echo "Message could not be sent. Mailer Error:{$mail->ErrorInfo}"; ?>");</script>
			<?php
		}
		else if($isDebug=="ECHO"){
			"Message could not be sent. Mailer Error:{$mail->ErrorInfo}<br/>";
		}
		else {
			return false;
		}
	}
}
?>