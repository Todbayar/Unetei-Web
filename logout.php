<?php
unset($_COOKIE["userID"]);
$cookieTime = time() - (86400 * 30);	//30 day, 86400=1
setcookie("userID", "", $cookieTime, "/");
?>