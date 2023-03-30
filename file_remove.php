<?php
if(isset($_REQUEST["file"])){
	if(unlink("user_files".DIRECTORY_SEPARATOR.$_REQUEST["file"])){
		echo "OK";
	}
	else {
		echo "Fail";
	}
}
?>