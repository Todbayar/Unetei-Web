<?php
//config
date_default_timezone_set("Asia/Ulaanbaatar");

//info
$service_phone = "(+976)99213557";
$domain_title = "Zarchi";
$domain = "zarchi.mn";
$contact_phone = "(+976)99213557";

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

//item publish option prices
$item_publish_price_vip = number_format("20000");
$item_publish_price_special = number_format("10000");

$superduperadmin = "+97699213557";

//pages
$pageCountHome = 12;
$pageCountList = 60;

//firebase
$firebase_public_vapid_key = "BKLrbPXG-cbXjadrRFHrKIvJX10ZHwXnlOuBZqMiYIIYVMdihRH_X8KV-FGD1e5xbqt30DMDBXdlqLemx_G3dfg";
?>