<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";
include_once "chat_process.php";

if(isset($_POST["id"]) && isset($_POST["survey"])){
	$query = "UPDATE item SET isactive=2, boost=NULL WHERE id=".$_POST["id"];
	if($conn->query($query)){
		$queryItem = "SELECT * FROM item WHERE id=".$_POST["id"];
		$resultItem = $conn->query($queryItem);
		$rowItem = mysqli_fetch_array($resultItem);
		$message = $rowItem["title"]." (#".$rowItem["id"].")<br/>";
		$categoryTitles = harvestCategory($rowItem["category"]);
		$message .= "<div style=\"font-size:12px; color:gray; margin-top:2px\">".implode("<i class=\"fas fa-angle-right\" style=\"font-size:10px; margin-left:2px; margin-right:2px\"></i>",$categoryTitles)."</div>";
		$message .= "<div style=\"font-size:12px; color:gray; margin-top:2px\"><b>Архивлагдав</b></div>";
		$message .= "<div style=\"font-size:12px; color:gray; margin-top:2px\">".$_POST["survey"]."</div>";
		chat_send(getUserIDFromItem($_POST["id"]), getUserIDFromPhone($superduperadmin), 0, $message, false);
		echo "OK";
	}
	else {
		echo "Fail";
	}
}
?>