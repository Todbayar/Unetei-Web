<?php
include "mysql_config.php";

$images = json_decode($_REQUEST["images"]);
for($i=0; $i<count($images); $i++){
	echo $vNewFile = "user_files/".date("Ymdhis")."_".$images[$i]->name;
}

mysqli_close($conn);
?>