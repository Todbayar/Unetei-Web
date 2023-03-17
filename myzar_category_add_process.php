<?php
$content = file_get_contents('php://input');
echo "OK, ".$content["file"]["name"];
?>