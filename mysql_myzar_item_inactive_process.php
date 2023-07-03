<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";
include_once "chat_process.php";

if(isset($_POST["id"]) && isset($_POST["survey"])){
	$query = "UPDATE item SET datetime='".date("Y-m-d h:i:s")."', isactive=0 WHERE id=".$_POST["id"];
	if($conn->query($query)){
		$queryItem = "SELECT * FROM item WHERE id=".$_POST["id"];
		$resultItem = $conn->query($queryItem);
		$rowItem = mysqli_fetch_array($resultItem);
		$message = $rowItem["title"]." #".$rowItem["id"]."<br/>";
		$message .= convertPriceToText($rowItem["price"])." ₮<br/>";
		$categoryTitles = harvestCategory($rowItem["category"]);
		for($i=0; $i<count($categoryTitles); $i++){
			if($i<count($categoryTitles)-1){
				$message .= $categoryTitles[$i]."<i class=\"fas fa-angle-right\" style=\"font-size:10px; margin-left:2px; margin-right:2px\"></i>";
			}
			else {
				$message .= $categoryTitles[$i]."<br/>";
			}
		}
		$message .= "Идэвхгүй<br/>";
		$message .= $_POST["survey"];
		chat_send(getUserIDFromItem($_POST["id"]), getUserIDFromPhone($superduperadmin), 0, $message, false);
		echo "OK";
	}
	else {
		echo "Fail";
	}
}

?>