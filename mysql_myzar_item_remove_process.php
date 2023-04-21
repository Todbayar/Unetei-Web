<?php
include "mysql_config.php";
include "info.php";

$queryFetchItems = "SELECT * FROM item WHERE isactive=0 AND NOW()>(datetime+INTERVAL ".$days_item_remove." DAY)";
$resultFetchItems = @$conn->query($queryFetchItems);
while($rowFetchItems = mysqli_fetch_array($resultFetchItems)){
	$id = $rowFetchItems["id"];
	$queryRemoveItem = "DELETE FROM item WHERE id=".$id;
	if(@$conn->query($queryRemoveItem)){
		$queryChatItemRemove = "DELETE FROM chat WHERE type=2 AND message='".$id."'";
		@$conn->query($queryChatItemRemove);
	}
}
?>