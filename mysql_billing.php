<?php
include "mysql_config.php";
include_once "chat_process.php";
include_once "info.php";

if(isset($_POST["type"])){
	if($_POST["type"] == "role"){
		$phone = ($_POST["affiliate"] != "" && $_POST["affiliate"] != $_COOKIE["phone"]) ? $_POST["affiliate"] : $superduperadmin;
		$query = "SELECT * FROM user WHERE phone='".$phone."'";
		$result = $conn->query($query);
		$affiliate = mysqli_fetch_array($result);
		
		if((is_null($affiliate["bank_account"]) || $affiliate["bank_account"]=="") && (is_null($affiliate["socialpay"]) || $affiliate["socialpay"]=="")){
			$affiliate = mysqli_fetch_array($conn->query("SELECT * FROM user WHERE phone='".$superduperadmin."'"));
		}
		
		$query = "SELECT * FROM user WHERE phone='".$_COOKIE["phone"]."'";
		$result = $conn->query($query);
		$requester = mysqli_fetch_array($result);
		
		$shortMessage = "";
		$price = 0;
		switch($_POST["role"]){
			case 1:
				$price = $role_price_publisher;
				$shortMessage = $role_rank_publisher.", ".number_format($role_price_publisher)." ₮";
				break;
			case 2:
				$price = $role_price_manager;
				$shortMessage = $role_rank_manager.", ".number_format($role_price_manager)." ₮";
				break;
			case 3:
				$price = $role_price_admin;
				$shortMessage = $role_rank_admin.", ".number_format($role_price_admin)." ₮";
				break;
			case 4:
				$price = $role_price_superadmin;
				$shortMessage = $role_rank_superadmin.", ".number_format($role_price_superadmin)." ₮";
				break;
		}
		
		$message = $requester["name"]." (#".$requester["id"].", ".$requester["phone"].") хэрэглэгч ".$shortMessage." болох хүсэлт илгээлээ.";
		chat_send($requester["id"], $affiliate["id"], 3, $message, false);
		
		$billing = new stdClass();
		$billing->type = "Хэрэглэгчийн эрхээ дээшлүүлэх";
		$billing->number = $requester["phone"];
		$billing->title = $requester["name"];
		$billing->price = number_format($price);
		$billing->bank_name = $affiliate["bank_name"];
		$billing->bank_owner = $affiliate["bank_owner"];
		$billing->bank_account = $affiliate["bank_account"];
		$billing->socialpay = $affiliate["socialpay"];
		echo json_encode($billing);
	}
	else if($_POST["type"] == "item"){
		$query = "SELECT * FROM user WHERE phone=".$_COOKIE["phone"];
		$result = $conn->query($query);
		$requester = mysqli_fetch_array($result);
		$phone = ($requester["affiliate"]!="" && $requester["affiliate"] != $_COOKIE["phone"]) ? $requester["affiliate"] : $superduperadmin;
		
		$queryAffiliate = "SELECT * FROM user WHERE phone='".$phone."'";
		$resultAffiliate = $conn->query($queryAffiliate);
		$affiliate = mysqli_fetch_array($resultAffiliate);
		
		if((is_null($affiliate["bank_account"]) || $affiliate["bank_account"]=="") && (is_null($affiliate["socialpay"]) || $affiliate["socialpay"]=="")){
			$affiliate = mysqli_fetch_array($conn->query("SELECT * FROM user WHERE phone='".$superduperadmin."'"));
		}
		
		$billing = new stdClass();
		$billing->type = "Зар нэмэх";
		$billing->number = $_COOKIE["phone"];
		$billing->title = $requester["name"];
		$billing->price = 0;
		$billing->bank_name = $affiliate["bank_name"];
		$billing->bank_owner = $affiliate["bank_owner"];
		$billing->bank_account = $affiliate["bank_account"];
		$billing->socialpay = $affiliate["socialpay"];
		echo json_encode($billing);
	}
}
?>