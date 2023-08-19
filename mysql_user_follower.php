<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
include_once "chat_process.php";

if(isset($_POST["phone"])){
	
	$patternPhone = "/^[0-9]{8}$/i";
	
	$phone = str_contains($_POST["phone"], "+976") ? substr($_POST["phone"],4) : $_POST["phone"];
	
	$affiliate = ($phone!="" && getPhone($_COOKIE["userID"])!="+976".$phone && preg_match($patternPhone, $phone)>0 && getUserIDFromPhone("+976".$phone)>-1) ? "+976".$phone : "";
	
	if($conn->query("UPDATE user SET affiliate='".$affiliate."' WHERE id=".$_COOKIE["userID"])){
		$affiliateUserProfile = getProfileByPhone($affiliate);
		$followerPhone = getPhone($_COOKIE["userID"]);
		$followerName = getName($_COOKIE["userID"]);
		$followerRole = convertRoleInString(getUserRole($_COOKIE["userID"]));
		
		$message = "Сайн байна уу? ".$affiliateUserProfile->name."<br/>";
		$message .= "Хэрэглэгч ".$followerRole." ".$followerName." (".$followerPhone.") таны дагагч боллоо.";
		chat_send($_COOKIE["userID"], $affiliateUserProfile->id, 0, $message, false);
		
		echo "OK";
	}
	else {
		echo "FAIL";
	}
}
?>