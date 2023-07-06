<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "chat_process.php";
include_once "info.php";

if(isset($_POST["fromID"]) && isset($_POST["itemID"])){
	$queryBoostCount = "SELECT (SELECT COUNT(*) FROM item WHERE isBoost=1) AS boost_total, (SELECT COUNT(*) FROM item WHERE isBoost=1 AND userID=".$_POST["fromID"].") AS boost_user_total";
	$resultBoostCount = $conn->query($queryBoostCount);
	$rowBoostCount = mysqli_fetch_array($resultBoostCount);
	if($rowBoostCount["boost_total"]<$item_boost_total){
		$userRole = getUserRole($_POST["fromID"]);
		$userPhone = getPhone($_POST["fromID"]);
		$superduperadminID = getUserIDFromPhone($superduperadmin);
		if($userPhone!=$superduperadmin){
			if($userRole==3){
				if($rowBoostCount["boost_total"]<$item_boost_admin){
					echo chat_send($_POST["fromID"], $superduperadminID, 4, $_POST["itemID"]);
				}
				else {
					echo "FULL";
				}	
			}
			else if($userRole==4){
				if($rowBoostCount["boost_total"]<$item_boost_admin){
					echo chat_send($_POST["fromID"], $superduperadminID, 4, $_POST["itemID"]);
				}
				else {
					echo "FULL";
				}	
			}
		}
		else {
			echo chat_send($_POST["fromID"], $superduperadminID, 4, $_POST["itemID"]);
		}
	}
	else {
		echo "TOTAL_FULL";
	}
}
?>