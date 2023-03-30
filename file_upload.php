<?php
date_default_timezone_set("Asia/Ulaanbaatar");

if(isset($_FILES["file"])){
	$path = "user_files";
	$vNewFile = date("Ymdhis")."_".$_FILES["file"]["name"];
	if(move_uploaded_file($_FILES["file"]["tmp_name"], $path.DIRECTORY_SEPARATOR.$vNewFile)) {
		$res = new stdClass();
		$res->path = $path;
		$res->name = $vNewFile;
		$res->index = $_REQUEST["index"];
		echo json_encode($res);
	}
	else {
		echo "Fail";
	}
}
?>