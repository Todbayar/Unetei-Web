<?php
//config
date_default_timezone_set("Asia/Ulaanbaatar");

//info
$service_phone = "(+976)99213557";
$domain_title = "Zarchi";
$domain = "zarchi.mn";
$contact_phone = "(+976)99213557";
$superduperadmin = "+97699213557";

//files
$path = "user_files";

//variables
$days_item_remove = 7;
$category_count_limit_publisher_manager = 10;	//check before remove

//email
$smtp_host = "smtp.gmail.com";
$smtp_port = 465;
$smtp_username = "atodko0513@gmail.com";
$smtp_password = "Newpass@sd2022";

//role
$role_rank_superadmin = "Сүпер админ";
$role_rank_admin = "Админ";
$role_rank_manager = "Менежер";
$role_rank_publisher = "Нийтлэгч";
$role_rank_user = "Хэрэглэгч";

$role_price_superadmin = 1000000;
$role_price_admin = 300000;
$role_price_manager = 100000;
$role_price_publisher = 50000;

//category limit
//-1 (not accepted), 0 (unlimited), 0<n (accepted but limited)
$category_regular_count_limit_superadmin = 0;
$category_brand_count_limit_superadmin = 0;
$category_regular_count_limit_admin = 0;
$category_brand_count_limit_admin = 10;
$category_regular_count_limit_manager = 10;
$category_brand_count_limit_manager = -1;
$category_regular_count_limit_publisher = 10;
$category_brand_count_limit_publisher = -1;

//item limit
//-1 (not accepted), 0 (unlimited), 0<n (accepted but limited)
$item_regular_count_limit_superadmin = 0;
$item_vipspecial_count_limit_superadmin = 0;
$item_regular_count_limit_admin = 0;
$item_vipspecial_count_limit_admin = 10;
$item_regular_count_limit_manager = 0;
$item_vipspecial_count_limit_manager = -1;
$item_regular_count_limit_publisher = 0;
$item_vipspecial_count_limit_publisher = -1;

//item publish option prices
$item_publish_price_vip = number_format("20000");
$item_publish_price_special = number_format("10000");

//item facebook boost request counts
$item_boost_total = 10;
$item_boost_admin = 4;
$item_boost_superadmin = 6;

//pages
$pageCountHome = 12;
$pageCountList = 60;

//firebase
$firebase_app = "unetei-bc717";
$firebase_public_vapid_key = "BKLrbPXG-cbXjadrRFHrKIvJX10ZHwXnlOuBZqMiYIIYVMdihRH_X8KV-FGD1e5xbqt30DMDBXdlqLemx_G3dfg";
$firebase_auth = "AAAAwjhSlmk:APA91bGU-XYE_yp2023YXoxQA1GFWir8-9t_omVjNAQ5dDxQnSE2L7OIpkB0b8Vbj3Bla_wtYudRc3fjI5QwmPh0j_LbRVhq2xEWKLAOi1_PjZYxl1cDjBMcsssLXW571Ykgjat31Sfr";

define("ADD",0);
define("EDIT",1);
define("BOOST",2);
define("UPDATE",3);

define("BOOST_DAYS", 7);

//host
$protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") ? "https" : "http";

define("COUNT_ITEM_IMAGES",20);
define("COUNT_ITEM_VIDEOS",1);
?>