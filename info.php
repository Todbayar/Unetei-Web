<?php
//config
date_default_timezone_set("Asia/Ulaanbaatar");

//info
$service_phone = "+97699213557";
$domain_title = "Zarchi";
$domain = "zarchi.mn";
$contact_phone = "+97699213557";
$superduperadmin = "+97699213557";
$phone_validater_superduperadmin = "+97695525128";

//files
$path = "user_files";

//url path depth
$queryURL = array();
parse_str($_SERVER['QUERY_STRING'], $queryURL);
$urlDepth = "";
if(count($queryURL)>0){
	for($i=1; $i<=count($queryURL); $i++){
		$urlDepth .= "../";
	}
}

//variables
$days_item_remove = 7;
$category_count_limit_publisher_manager = 10;	//check before remove

//email
$smtp_host = "smtp.gmail.com";
$smtp_port = 587;									//tls
$smpt_secure_type = "tls";
$smtp_username = "misheelgamestudio@gmail.com";		//app password is enabled in this gmail account
$smtp_password = "obhztqmdgwlnyaaf";				//this is app password not like regular login password

//role
$role_rank_superadmin = "Сүпер админ";
$role_rank_admin = "Админ";
$role_rank_manager = "Менежер";
$role_rank_publisher = "Нийтлэгч";
$role_rank_user = "Энгийн";

$role_price_superadmin = 50000;
$role_price_admin = 35000;
$role_price_manager = 20000;
$role_price_publisher = 10000;

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
$item_publish_price_vip = number_format("5000");
$item_publish_price_special = number_format("3000");

//item facebook boost request counts
$item_boost_total = 10;
$item_boost_admin = 4;
$item_boost_superadmin = 6;

//pages
$pageCountHome = 12;
$pageCountList = 60;
$pageCountFollowers = 13;

//firebase
$firebase_app = "unetei-bc717";
$firebase_public_vapid_key = "BKLrbPXG-cbXjadrRFHrKIvJX10ZHwXnlOuBZqMiYIIYVMdihRH_X8KV-FGD1e5xbqt30DMDBXdlqLemx_G3dfg";
$firebase_auth = "AAAAwjhSlmk:APA91bGU-XYE_yp2023YXoxQA1GFWir8-9t_omVjNAQ5dDxQnSE2L7OIpkB0b8Vbj3Bla_wtYudRc3fjI5QwmPh0j_LbRVhq2xEWKLAOi1_PjZYxl1cDjBMcsssLXW571Ykgjat31Sfr";
$firebase_auth2_token = "ya29.a0AbVbY6NUK0PiOrqiCV-RHVVsNxIIPtoCthmBPo3TS1Un6WilT4SPQUnZCoMYjwPLi_krxu4ZJO2aefDCUv5xJx1YNZC-2iARxdp5Qmv16Z6IYfxeTRk2zuMENjNg_QpLh6awJefixMqHji863DDoWHt2UEbhaCgYKAZ4SARESFQFWKvPl6qT2lp6DeIcg0SvFimCIZw0163";

define("ADD",0);
define("EDIT",1);
define("BOOST",2);
define("UPDATE",3);
define("RESPOND",4);

define("BOOST_DAYS", 7);

//host
$protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") ? "https" : "http";

define("COUNT_ITEM_IMAGES",20);
define("COUNT_ITEM_VIDEOS",1);

define("GOOGLE_RECAPTCHA_SITE_KEY","6LdW8JgnAAAAAFeoWqGS0wa1hVkCJrdQCvk0Y_aV");

$website_description = "Zarchi.mn гэж юу вэ?
Zarchi.mn нь бүх төрлийн зарын веб сайт юм.
Утасны дугаараараа нэвтэрч хэрэглэгч болсон хүмүүс зараа үнэгүй тавина.
Хэрхэн ажилладаг вэ?
Бүх заруудын эхэнд түрүүлж харагддаг нь VIP, Онцгой зарууд ба өөр өөр үнэ ханштай.
Хэрэглэгч 'менежер / админ / сүпер админ' болсоноор шинэ хэрэглэгч буюу өөрийн дагагчдаас дээр дурдсан үйлчилгээнээс орлого олно.
Хэрэв дагагч тань мөн адил 'менежер / админ / сүпер админ' болбол таньд мөн орлого нь орно.
Ямар онцлогтой вэ?
Маркетингийн онцлог агуулсан.
14 хоног бүр заруудаас facebook дээр boost хийнэ, менежер, админ, сүпер админууд үнэгүйгээр дагагч нарийнхаа эрхийг дээшлүүлж болхоор байгаа.
Маркетингийн тал дээр уян хатан програмчлалын хөгжүүлэлт хийсэн.
Мөн дэлгүүр болон брэндээ үүсгэх боломжтой
Доорх зурган дээр хэрэглэгчээс ирсэн хүсэлт харагдаж байна, хэдэн төгрөгний орлого олох зэрэг мэдээлэл агуулсан бас батлах товчыг яаран бүү дараарай эхлээд орлогоо авах хэрэгтэй.";

$website_keywords = "Зарлал, зар, зарлав, үнэгүй зар, үнэгүй зарлал, онцгой зар, VIP зар, vip зар, зарчи, ".$domain.", ".$domain_title;

$isLoginFirebase = false;
?>