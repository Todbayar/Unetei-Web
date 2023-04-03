<?php
unset($_COOKIE["uid"]);
unset($_COOKIE["phone"]);
$cookieTime = time() - (86400 * 30);	//30 day, 86400=1
setcookie("uid", "", $cookieTime, "/");
setcookie("phone", "", $cookieTime, "/");
?>