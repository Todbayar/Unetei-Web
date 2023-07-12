<?php
include_once "info.php";
include_once "mysql_misc.php";

if(isset($_COOKIE["userID"]) && getPhone($_COOKIE["userID"])==$superduperadmin){
	phpinfo();
	print_r(apache_get_modules());
}
?>