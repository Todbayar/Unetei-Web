<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";

if(isset($_POST["email"])){
	$cookieTime = time() + (86400 * 30);	//30 day, 86400=1
	setcookie("tmpEmail".$_COOKIE["userID"], $_POST["email"], $cookieTime, "/");
	$url = $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST']);
	$link = $url."/?emailverificationid=".$_COOKIE["userID"];
	$body = "Сайн байна уу? Энэ өдрийн мэнд хүргье.<br/>";
	$body .= "Та <a href='".$link."'>энд дарж<a> имэйлээ баталгаажуулна уу.";
	sendEmailVerification($_POST["email"], "Имэйл баталгаажуулалт", $body, "CONSOLE");
}

if(isset($_POST["emailverificationid"])){
	if(isset($_COOKIE["tmpEmail".$_POST["emailverificationid"]])){
		$query = "UPDATE user SET email='".$_COOKIE["tmpEmail".$_POST["emailverificationid"]]."' WHERE id=".$_POST["emailverificationid"];
		if($conn->query($query)){
			unset($_COOKIE["tmpEmail".$_POST["emailverificationid"]]);
			$cookieTime = time() - (86400 * 30);	//30 day, 86400=1
			setcookie("tmpEmail".$_POST["emailverificationid"], "", $cookieTime, "/");
			echo "OK";
		}
		else {
			echo "<FAIL>:".$query;
		}
	}
	else {
		echo "<FAIL>:no email cookie (tmpEmail".$_POST["emailverificationid"].")";
	}
}
?>