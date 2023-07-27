<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";

if(isset($_POST["email"])){
	$queryEmailVerifying = "INSERT IGNORE INTO validater(value, state, type) VALUES('".$_POST["email"]."',".$_COOKIE["userID"].",1)";
	if($conn->query($queryEmailVerifying)){
		$url = $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST']);
		$link = $url."/?emailverificationid=".$_COOKIE["userID"];
		$body = "Сайн байна уу? Энэ өдрийн мэнд хүргье.<br/>";
		$body .= "Та <a href='".$link."'>энд дарж<a> имэйлээ баталгаажуулна уу.";
		if(sendEmailVerification($_POST["email"], "Имэйл баталгаажуулалт", $body)){
			echo "OK";
		}
		else {
			echo "FAIL";
		}
	}
	else {
		echo "FAIL";
	}
}

if(isset($_POST["emailverificationid"])){
	$queryEmail = "SELECT * FROM validater WHERE state=".$_POST["emailverificationid"]." AND type=1";
	$resultEmail = $conn->query($queryEmail);
	if(mysqli_num_rows($resultEmail)>0){
		$rowEmail = mysqli_fetch_array($resultEmail);
		$query = "UPDATE user SET email='".$rowEmail["value"]."' WHERE id=".$_POST["emailverificationid"];
		if($conn->query($query)){
			$queryDelete = "DELETE FROM validater WHERE state=".$_POST["emailverificationid"]." AND type=1";
			@$conn->query($queryDelete);
			echo "OK";
		}
		else {
			echo "FAIL";
		}
	}
	else {
		echo "FAIL";
	}
}
?>