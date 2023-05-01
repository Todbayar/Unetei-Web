<?php
include "mysql_config.php";
include "chat_process.php";
include "info.php";

if(isset($_POST["type"])){
	if($_POST["type"] == "role"){
		$phone = ($_POST["affiliate"] != "" && $_POST["affiliate"] != $_COOKIE["phone"]) ? $_POST["affiliate"] : $superduperadmin;
		$query = "SELECT * FROM user WHERE phone=".$phone;
		$result = $conn->query($query);
		$affiliate = mysqli_fetch_array($result);
		
		$query = "SELECT * FROM user WHERE phone=".$_COOKIE["phone"];
		$result = $conn->query($query);
		$requester = mysqli_fetch_array($result);
		
		$shortMessage = "";
		$price = 0;
		switch($_POST["role"]){
			case 1:
				$price = 50000;
				$shortMessage = "Нийтлэгч, ".number_format($price)." ₮";
				break;
			case 2:
				$price = 100000;
				$shortMessage = "Менежер, ".number_format($price)." ₮";
				break;
			case 3:
				$price = 300000;
				$shortMessage = "Админ, ".number_format($price)." ₮";
				break;
			case 4:
				$price = 1000000;
				$shortMessage = "Сүпер админ, ".number_format($price)." ₮";
				break;
		}
		
		$message = $requester["name"]." (#".$requester["id"].", ".$requester["phone"].") хэрэглэгч ".$shortMessage." болох хүсэлт илгээлээ.";
		chat_send($requester["id"], $affiliate["id"], 3, $message, false);
		
		$billing = new stdClass();
		$billing->type = "Хэрэглэгчийн эрхээ дээшлүүлэх";
		$billing->number = $requester["phone"];
		$billing->title = $requester["name"];
		$billing->price = $price;
		$billing->bank_name = $affiliate["bank_name"];
		$billing->bank_owner = $affiliate["bank_owner"];
		$billing->bank_account = $affiliate["bank_account"];
		$billing->socialpay = $affiliate["socialpay"];
		echo json_encode($billing);
	}
}
?>