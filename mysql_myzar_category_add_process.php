<?php
$file = $_FILES["iconfile"];
$uid = $_REQUEST["uid"];
$title = $_REQUEST["title"];
$hier = $_REQUEST["hier"];

if(isset($hier) && isset($uid) && isset($title) && isset($file)){
	for($i=1; $i<count($hier); $i++){
		$query = "";
	}
}
?>