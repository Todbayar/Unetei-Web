<?php
session_start();

include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
include_once "chat_process.php";
//include_once "mysql_myzar_item_remove_process.php";	//for auto removal of expired item

//setcookie('googtrans', '/mn/en');

if($protocol=="http" && $_SERVER['HTTP_HOST']!="localhost") header("Location:https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

update_client_ip();

//include "indexAdsense.php";
include "indexRegular.php";
?>