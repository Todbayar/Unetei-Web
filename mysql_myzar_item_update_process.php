<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "chat_process.php";

if(isset($_POST["id"]) && isset($_POST["status"])){
	$days = 30;
	if($_POST["status"] == 2){
		$days = 10;
	}
	else if($_POST["status"] == 1) {
		$days = 20;
	}
	
	$itemID = $_POST["id"];
	$userID = getUserIDFromItem($itemID);
	$payAmount = getPayAmount($_POST["status"], $userID);
	
	$query = "UPDATE item SET datetime='".date("Y-m-d h:i:s")."', isactive=1, expire_days=".$days.", status=".$_POST["status"]." WHERE id=".$itemID;
	if($conn->query($query)){
		chat_send($userID, getAffiliateID($userID), 2, $itemID, false);
		echo json_encode(array("id"=>$itemID, "pay_amount"=>$payAmount));
	}
	else {
		echo "FAIL";
	}
}
?>