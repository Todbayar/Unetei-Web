<?php
include_once "info.php";
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Permissions-Policy" content="interest-cohort=()">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="facebook-domain-verification" content="qizqpj55lnc4ms6rcojpn16hp079ax">
		<meta property="fb:app_id" content="941510830473804"> 
		<meta property="og:site_name" content="zarchi.mn">
		
		<title>Zarchi</title>
		
		<link rel="shortcut icon" type="image/icon" href="<?php echo str_contains($_SERVER['REQUEST_URI'],"detail")?"../android-chrome-512x512.png":"android-chrome-512x512.png"; ?>" />
		<link rel="icon" type="image/x-icon" href="<?php echo str_contains($_SERVER['REQUEST_URI'],"detail")?"../android-chrome-512x512.png":"android-chrome-512x512.png"; ?>">
		
		<script src="<?php echo  str_contains($_SERVER['REQUEST_URI'],"detail")?"../":""; ?>kit.fontawesome.com_64e3bec699.js"></script>
		
		<script src="<?php echo  str_contains($_SERVER['REQUEST_URI'],"detail")?"../":""; ?>jquery.Jcrop.min.js"></script>
		<link rel="stylesheet" href="<?php echo  str_contains($_SERVER['REQUEST_URI'],"detail")?"../":""; ?>jquery.Jcrop.min.css" type="text/css" />
		
		<link rel="stylesheet" href="<?php echo  str_contains($_SERVER['REQUEST_URI'],"detail")?"../":""; ?>main.css">
		<link rel="stylesheet" href="<?php echo  str_contains($_SERVER['REQUEST_URI'],"detail")?"../":""; ?>topbar.css">
		<link rel="stylesheet" href="<?php echo  str_contains($_SERVER['REQUEST_URI'],"detail")?"../":""; ?>buttons.css">
		<link rel="stylesheet" href="<?php echo  str_contains($_SERVER['REQUEST_URI'],"detail")?"../":""; ?>dropdowns.css">
		<link rel="stylesheet" href="<?php echo  str_contains($_SERVER['REQUEST_URI'],"detail")?"../":""; ?>animation.css">
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
		
		<!--Google Adsense-->
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1072207883073754" crossorigin="anonymous"></script>
	</head>
	
	<body>
		<div class="topbar">
			<div class="wrap">
				<div style="display: flex; align-items: center; cursor: pointer">
					<img src="icon.png" width="40" height="40" style="object-fit: contain">
					<div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">ZARCHI.MN</font></font></div>
				</div>
				<div class="control">
					<div class="myzar">
						<div id="myzar_button" style="display: flex; align-items: center; height: 70px; cursor: pointer; position: relative">
							<i class="fa-regular fa-user" style="font-size: 24px; color: #FFFFFF"></i>
							<div class="removable" style="color:#FFFFFF; margin-left: 5px">My ads</div>
							<div id="myzar_phone" class="removable" style="color: #174400">+97699213557</div>
							<i class="fas fa-angle-down removable" style="margin-left: 2px; font-size: 12px; color: #174400; margin-top: 4px; margin-right: 20px"></i>
						</div>
					</div>
					<i onclick="pagenavigation('favorite')" class="fa-regular fa-star" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer"></i>
					<i class="fa-regular fa-comments" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer; position: relative" onclick="pagenavigation('chat')">
					</i>
				<div class="button_yellow" style="margin-left: 10px">
					<i class="fa-solid fa-plus"></i>
					<div class="removable" style="margin-left: 5px"><font style="vertical-align: inherit;">Add an ad</div>
				</div>
			</div>			
		</div>
		<!--Waves Container-->
		<div class="animation_waves">
			<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
				<defs>
					<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
				</defs>
				<g class="parallax">
					<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(55,163,0,0.7"></use>
					<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(55,163,0,0.5)"></use>
					<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(55,163,0,0.3)"></use>
					<use xlink:href="#gentle-wave" x="48" y="7" fill="#fff"></use>
				</g>
			</svg>
		</div>
		<!--Waves end-->
	</div>
	<div class="mid">
		<div class="wrap">
		<style>
		.searchInput {
			width: 80%;
			height: 34px;
			border-radius: 10px;
			line-height: 18px;
			font-size: 18px;
			font-family: 'Arial';
		}

		.searchCategoryList {
			float: left;
			width: 100%;
			margin-top: 10px;
			display: inline-block;
		}

		.searchCategoryList .searchCategoryListSelected {
			float: left;
			width: 100%;
		}

		.searchCategoryList .searchCategoryListAvailable {
			float: left;
			width: 100%;
			max-height: 240px;
			overflow-y: auto;
		}

		/* For Mobile */
		@media screen and (max-width: 540px) {
			.searchCategoryList .searchCategoryListAvailable {
				max-height: 145px;
			}
		}

		.searchCategoryList .searchCategoryListAvailable::-webkit-scrollbar {
			width: 1px;
		}

		.searchCategoryList .searchCategoryListAvailable::-webkit-scrollbar-track {
			box-shadow: inset 0 0 1px rgba(0, 0, 0, 0);
		}

		.searchCategoryList .searchCategoryListAvailable::-webkit-scrollbar-thumb {
			background-color: #FFA718;
			outline: 2px solid #FFA718;
			border-radius: 10px;
		}

		.searchResult {
			margin-top: 10px;
			float: left;
			width: 100%;
		}

		.searchResult .type {
			font: bold 20px Arial;
			padding-left: 5px;
			margin-bottom: 10px;
			margin-top: 10px;
			display: flex;
		}

		.searchResult .type .button_yellow {
			font: normal 12px Arial;
			width: 45px;
			height: 18px;
			padding: 2px;
			text-align: center;
		}

		.searchResult .list {
			column-count: 4;
			column-gap:12px;
			margin-left: 5px;
			margin-right: 5px;
		}

		/* For Mobile */
		@media screen and (max-width: 540px) {
			.searchResult .list {
				column-count: 2;
			}	
		}

		.searchResult .list .item {
			cursor: pointer;
			display: inline-block;
			vertical-align: top;
			margin-bottom: 10px;
			margin-top: 5px;
		}

		/* For Mobile */
		@media screen and (max-width: 540px) {
			.searchResult .list .item {
				width: 100%;
				height: 220px;

			}
		}

		/* For Tablets and Desktop */
		@media screen and (min-width: 540px) {
			.searchResult .list .item {
				width: 100%;
				height: 249px;
			}
		}

		.searchResult .list .item .badge_vip {
			position: absolute;
			top: 0px;
			bottom: 0;
			left: 0;
			right: 0;
			pointer-events: none;
			overflow: hidden;
		}

		.searchResult .list .item .badge_vip::after {
			position: absolute;
			background-color: #f00;
			content: attr(data-top);
			left: -33px;
			top: 13px;
			height: 25px;
			width: 115px;
			-ms-transform: rotate(-45deg);
			transform: rotate(-45deg);
			font-size: 14px;
			color: #fff;
			font-family: 'Arial';
			line-height: 26px;
			text-align: center;
			box-shadow: 2px 2px 5px #888888;
		}

		.searchResult .list .item .badge_special {
			position: absolute;
			top: 0px;
			bottom: 0;
			left: 0;
			right: 0;
			pointer-events: none;
			overflow: hidden;
		}

		.searchResult .list .item .badge_special::after {
			position: absolute;
			background-color: #00d300;
			content: attr(data-top);
			left: -33px;
			top: 13px;
			height: 25px;
			width: 115px;
			-ms-transform: rotate(-45deg);
			transform: rotate(-45deg);
			font-size: 14px;
			color: #fff;
			font-family: 'Arial';
			line-height: 26px;
			text-align: center;
			box-shadow: 2px 2px 5px #888888;
		}

		.searchResult .list .item:hover {
			background: #f3f3f3;
			border-radius: 10px;
			box-shadow: 2px 2px 10px #888888;
		}

		.searchResult .list .item:hover > div:nth-child(2){
		/*	color: #3DB300;*/
			color: #007DC5;
		}

		.searchResult .list .item .image {
			width: 100%;
			position: relative;
		}

		/* For Mobile */
		@media screen and (max-width: 540px) {
			.searchResult .list .item .image {
				height: 145px;
			}
		}

		/* For Tablets and Desktop */
		@media screen and (min-width: 540px) {
			.searchResult .list .item .image {
				height: 173px;
			}
		}

		.searchResult .list .item .image img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			border-radius: 10px;
		}

		.searchResult .list .item .image iframe {
			width: 100%;
			height: 100%;
			border-radius: 10px;
		}

		.searchResult .list .item .image video {
			width: 100%;
			height: 100%;
			border-radius: 10px;
		}

		.searchResult .list .item .image .count {
			color: white; 
			background: gray;
			opacity: 0.73; 
			font-size: 13px;
			padding: 5px;
			position: absolute;
			right: 0;
			border-bottom-left-radius: 5px;
			border-top-right-radius: 10px;
		}

		.searchResult .list .item .image .fa-star {
			position: absolute;
			right: 5px;
			bottom: 5px;
			font-size: 22px;
			opacity: 0.9;
			color: gray;
			z-index: 1;
		}

		.searchResult .list .item .image .fa-star:not(.nohover):hover {
			opacity: 0.9;
			color: #FFA718;
		}

		.searchResult .list .item .price {
			font: bold 18px Arial;
			margin-top: 5px;
			padding-left: 5px;
			padding-right: 5px;
		}

		.searchResult .list .item .title {
			font: normal 18px Arial;
			margin-top: 5px;
			padding-left: 5px;
			padding-right: 5px;
			padding-bottom: 3px !important;
		/*
			text-overflow: ellipsis;
			white-space: nowrap;
			overflow: hidden;
			-webkit-line-clamp: 2;

		*/
			overflow: hidden;
			display: -webkit-box;
			-webkit-line-clamp: 2; /* number of lines to show */
				   line-clamp: 2; 
			-webkit-box-orient: vertical;
		}

		.searchPage {
			float: left;
			width: 100%;
			display: flex;
			margin-top: 20px;
			margin-bottom: 20px;
			font: bold 18px Arial;
			cursor: pointer;
			justify-content: center;
			color: #0086bf;
		}

		.searchPage .page {
			margin-left: 3px;
			margin-right: 3px;
			padding-top: 5px;
			padding-bottom: 5px;
			padding-left: 8px;
			padding-right: 8px;
		}

		.searchPage .page:not(.nohover):hover {
			padding-top: 5px;
			padding-bottom: 5px;
			padding-left: 8px;
			padding-right: 8px;
			background: #ddf0ff;
			border-radius: 100%;
			text-decoration: underline;
			text-decoration-thickness: 3px;
		}
		</style>

		<div class="mid" style="margin-top: 10px; margin-left: 5px;	margin-right: 5px; float: left; width: 100%">
			<div style="display: flex">
				<input id="searchInput" class="searchInput" type="text" placeholder="Search ads">
				<div onclick="showSearch()" class="button_yellow" style="margin-left: 10px; background: #42c200">
				<i class="fa-solid fa-circle-chevron-down" style="color: white"></i>
			</div>
			<div id="searchSubmit" class="button_yellow" style="margin-left: 10px; background: #42c200">
				<i class="fa-solid fa-magnifying-glass" style="color: white"></i>
				<div class="removable" style="margin-left: 5px; color: white">Search</div>
			</div>
		</div>
		<div class="searchCategoryList">
			<div id="searchCategoryListSelected" class="searchCategoryListSelected"></div>
			<div id="searchCategoryListAvailable" class="searchCategoryListAvailable"><div onclick="recursiveFetchCategory(2,1,'Хувцас хэрэглэл','20230630102928_clotheshanger2.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage1" src="user_files/20230630102928_clotheshanger2.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Clothing</font></font></div></div><div onclick="recursiveFetchCategory(2,2,'Үл хөдлөх','20230630103204_realestate.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage2" src="user_files/20230630103204_realestate.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Immovable</font></font></div></div><div onclick="recursiveFetchCategory(2,3,'Автомашин','20230630103621_car2.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage3" src="user_files/20230630103621_car2.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Car</font></font></div></div><div onclick="recursiveFetchCategory(2,4,'Ажлын зар','20230630103801_Double-J-Design-Diagram-Free-Suitcase.128.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage4" src="user_files/20230630103801_Double-J-Design-Diagram-Free-Suitcase.128.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Job ad</font></font></div></div><div onclick="recursiveFetchCategory(2,5,'Хүүхдийн бараа','20230630103906_kidcloth.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage5" src="user_files/20230630103906_kidcloth.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Children's goods</font></font></div></div><div onclick="recursiveFetchCategory(2,6,'Компьютер сэлбэг хэрэгсэл','20230630104021_Icons-Land-Vista-Hardware-Devices-Portable-Computer.256.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage6" src="user_files/20230630104021_Icons-Land-Vista-Hardware-Devices-Portable-Computer.256.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Computer spare parts</font></font></div></div><div onclick="recursiveFetchCategory(2,7,'Утас дугаар','20230630104131_Designcontest-Ecommerce-Business-Iphone.256.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage7" src="user_files/20230630104131_Designcontest-Ecommerce-Business-Iphone.256.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Phone number</font></font></div></div><div onclick="recursiveFetchCategory(2,8,'Цахилгаан бараа','20230630104222_Julie-Henriksen-Kitchen-Rotating-Stand-Mixer.512.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage8" src="user_files/20230630104222_Julie-Henriksen-Kitchen-Rotating-Stand-Mixer.512.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Electronics</font></font></div></div><div onclick="recursiveFetchCategory(2,9,'Гэр ахуйн бараа','20230630104257_red-sofa-furniture-icon-png-4.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage9" src="user_files/20230630104257_red-sofa-furniture-icon-png-4.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Household items</font></font></div></div><div onclick="recursiveFetchCategory(2,10,'Төхөөрөмж материал түлш','20230630104351_Treetog-Junior-Tool-box.256.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage10" src="user_files/20230630104351_Treetog-Junior-Tool-box.256.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Equipment, materials, fuel</font></font></div></div><div onclick="recursiveFetchCategory(2,11,'Амралт спорт хобби','20230630104437_Kevin-Andersson-Sportset-Basketball.128.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage11" src="user_files/20230630104437_Kevin-Andersson-Sportset-Basketball.128.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Leisure sport hobby</font></font></div></div><div onclick="recursiveFetchCategory(2,12,'Эрүүл мэнд гоо сайхан хүнс','20230630104518_4773193.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage12" src="user_files/20230630104518_4773193.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Health and beauty food</font></font></div></div><div onclick="recursiveFetchCategory(2,13,'Мал амьтан ургамал','20230630104604_Google-Noto-Emoji-Animals-Nature-22215-dog.512.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage13" src="user_files/20230630104604_Google-Noto-Emoji-Animals-Nature-22215-dog.512.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Animals and plants</font></font></div></div><div onclick="recursiveFetchCategory(2,14,'Үйлчилгээ','20230630104647_6568544.png')" class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3"><img id="categoryImage14" src="user_files/20230630104647_6568544.png" width="32px" height="32px"><div style="margin-left: 5px"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Service</font></font></div></div></div>
	</div>
	<div class="searchResult">
		<div id="typeVip" class="type" style=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Vip sale 
			</font></font><div id="moreVip" class="button_yellow" style="margin-left: 10px; background: #42c200">
				<i class="fa-solid fa-eye" style="color: white"></i>
				<div style="margin-left: 5px; color: white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">All</font></font></div>
			</div>
		</div>
		<div id="listVip" class="list"><div id="2" class="item"><div class="image"><div class="badge_vip" data-top="VIP"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">6</font></font></i><i id="itemStar2" onclick="toggleFavorite(false,2)" class="fa-solid fa-star"></i><img src="user_files/20230710105145_349873272_277006198047880_4718706195623877596_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Mercedes-Benz E300</font></font></div></div></div><div id="1" class="item"><div class="image"><div class="badge_vip" data-top="VIP"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">9</font></font></i><i id="itemStar1" onclick="toggleFavorite(false,1)" class="fa-solid fa-star"></i><img src="user_files/20230710104432_358116018_981795713065179_2453300629079806830_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Mercedes-Benz C class</font></font></div></div></div><div id="29" class="item"><div class="image"><div class="badge_vip" data-top="VIP"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">10</font></font></i><i id="itemStar29" onclick="toggleFavorite(false,29)" class="fa-solid fa-star"></i><img src="user_files/20230716070403_Mercedes-Benz GLB250 2.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">195 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Mercedes Benz GLB250</font></font></div></div></div><div id="25" class="item"><div class="image"><div class="badge_vip" data-top="VIP"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4</font></font></i><i id="itemStar25" onclick="toggleFavorite(false,25)" class="fa-solid fa-star"></i><img src="user_files/20230716053720_FB_IMG_1689500204083.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">26 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Mercedes-Benz B class</font></font></div></div></div><div id="16" class="item"><div class="image"><div class="badge_vip" data-top="VIP"></div><i id="itemStar16" onclick="toggleFavorite(false,16)" class="fa-solid fa-star"></i><video controls="controls" preload="metadata"><source src="user_files/20230711065520_li mongolia.mp4#t=0.5" type="video/mp4"></video></div><div><div class="price"></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Li Mongolia Electric car</font></font></div></div></div><div id="27" class="item"><div class="image"><div class="badge_vip" data-top="VIP"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">7</font></font></i><i id="itemStar27" onclick="toggleFavorite(false,27)" class="fa-solid fa-star"></i><img src="user_files/20230716061539_FB_IMG_1689502505418.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">61 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Family Eco Town</font></font></div></div></div><div id="18" class="item"><div class="image"><div class="badge_vip" data-top="VIP"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1</font></font></i><i id="itemStar18" onclick="toggleFavorite(false,18)" class="fa-solid fa-star"></i><img src="user_files/20230713041529_348561109_147348098322616_8464039697706458299_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">25,000 ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">TECHWAREZ</font></font></div></div></div></div>
		<div id="typeSpecial" class="type" style=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Special offer
			</font></font><div id="moreSpecial" class="button_yellow" style="margin-left: 10px; background: #42c200">
				<i class="fa-solid fa-eye" style="color: white"></i>
				<div style="margin-left: 5px; color: white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">All</font></font></div>
			</div>
		</div>
		<div id="listSpecial" class="list"><div id="4" class="item"><div class="image"><div class="badge_special" data-top="Онцгой"></div><i id="itemStar4" onclick="toggleFavorite(false,4)" class="fa-solid fa-star"></i><video controls="controls" preload="metadata"><source src="user_files/20230711022559_Abu auto.mp4#t=0.5" type="video/mp4"></video></div><div><div class="price"></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Land 70/77</font></font></div></div></div><div id="5" class="item"><div class="image"><div class="badge_special" data-top="Онцгой"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">15</font></font></i><i id="itemStar5" onclick="toggleFavorite(false,5)" class="fa-solid fa-star"></i><img src="user_files/20230711032118_347261234_681584420649468_4914411282495982885_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1.5 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Four Seasons Amin Apartment</font></font></div></div></div><div id="20" class="item"><div class="image"><div class="badge_special" data-top="Онцгой"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">6</font></font></i><i id="itemStar20" onclick="toggleFavorite(true,20)" class="fa-solid fa-star nohover" style="color: rgb(255, 167, 24)"></i><img src="user_files/20230713042745_356237760_588283586765884_8624007535869539234_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">130 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Happy town of 18 families</font></font></div></div></div><div id="32" class="item"><div class="image"><div class="badge_special" data-top="Онцгой"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">6</font></font></i><i id="itemStar32" onclick="toggleFavorite(false,32)" class="fa-solid fa-star"></i><img src="user_files/20230718074929_FB_IMG_1689680765628.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">HP laptops</font></font></div></div></div><div id="24" class="item"><div class="image"><div class="badge_special" data-top="Онцгой"></div><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">14</font></font></i><i id="itemStar24" onclick="toggleFavorite(false,24)" class="fa-solid fa-star"></i><img src="user_files/20230716104349_FB_IMG_1689475353361.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">99 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">OSHAN Changan Z6</font></font></div></div></div><div id="28" class="item"><div class="image"><div class="badge_special" data-top="Онцгой"></div><i id="itemStar28" onclick="toggleFavorite(false,28)" class="fa-solid fa-star"></i><video controls="controls" preload="metadata"><source src="user_files/20230716065604_10000000_6285391601580141_3070439283012735741_n.mp4#t=0.5" type="video/mp4"></video></div><div><div class="price"></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">10 inch Android music for PRIUS 30</font></font></div></div></div></div>
		<div id="typeRegular" class="type" style=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Simple ad
			</font></font><div id="moreRegular" class="button_yellow" style="margin-left: 10px; background: #42c200">
				<i class="fa-solid fa-eye" style="color: white"></i>
				<div style="margin-left: 5px; color: white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">All</font></font></div>
			</div>
		</div>
		<div id="listRegular" class="list"><div id="26" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">6</font></font></i><i id="itemStar26" onclick="toggleFavorite(false,26)" class="fa-solid fa-star"></i><img src="user_files/20230716055335_FB_IMG_1689500876454.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">25 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Subaru XV CROSSTREK</font></font></div></div></div><div id="3" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">21</font></font></i><i id="itemStar3" onclick="toggleFavorite(true,3)" class="fa-solid fa-star nohover" style="color: rgb(255, 167, 24)"></i><img src="user_files/20230710105816_356239541_645553930935572_1571876809064612152_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">GLE 350</font></font></div></div></div><div id="15" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4</font></font></i><i id="itemStar15" onclick="toggleFavorite(false,15)" class="fa-solid fa-star"></i><img src="user_files/20230711064744_340873292_598022128932585_7280145555943844603_n (1).jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">2.4 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">ELECTRIC SCOOTER</font></font></div></div></div><div id="22" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">2</font></font></i><i id="itemStar22" onclick="toggleFavorite(false,22)" class="fa-solid fa-star"></i><img src="user_files/20230716101712_FB_IMG_1689473745751.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">31.9 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Mobile home</font></font></div></div></div><div id="14" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">18</font></font></i><i id="itemStar14" onclick="toggleFavorite(false,14)" class="fa-solid fa-star"></i><img src="user_files/20230711064226_358033599_734163695383807_6822809836896517225_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">AUDI A6 QUATTRO</font></font></div></div></div><div id="44" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">7</font></font></i><i id="itemStar44" onclick="toggleFavorite(false,44)" class="fa-solid fa-star"></i><img src="user_files/20230816125959_received_968288987929922.jpeg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">170,000 ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">A chair with a box underneath</font></font></div></div></div><div id="13" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">5</font></font></i><i id="itemStar13" onclick="toggleFavorite(false,13)" class="fa-solid fa-star"></i><img src="user_files/20230711063625_355112997_634104872082098_6344473355094465961_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">3 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">197-house township G Villa</font></font></div></div></div><div id="21" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">14</font></font></i><i id="itemStar21" onclick="toggleFavorite(false,21)" class="fa-solid fa-star"></i><img src="user_files/20230716094207_FB_IMG_1689471469033.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1.4 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Argunt Tsagaan Khushkhan town</font></font></div></div></div><div id="7" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">6</font></font></i><i id="itemStar7" onclick="toggleFavorite(false,7)" class="fa-solid fa-star"></i><img src="user_files/20230711060400_350492757_777856830646422_2532586513060264074_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">99 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">FJ CRUISER (GSJ15L)</font></font></div></div></div><div id="23" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1</font></font></i><i id="itemStar23" onclick="toggleFavorite(false,23)" class="fa-solid fa-star"></i><img src="user_files/20230716102958_FB_IMG_1689474541339.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">79 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Geely Coolray</font></font></div></div></div><div id="8" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">5</font></font></i><i id="itemStar8" onclick="toggleFavorite(false,8)" class="fa-solid fa-star"></i><img src="user_files/20230711061235_357790736_593062059481492_1299718517628621602_n.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">2.4 billion ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Luxury space at GRAND PLAZA</font></font></div></div></div><div id="30" class="item"><div class="image"><i class="count"><i class="fa-solid fa-camera"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">4</font></font></i><i id="itemStar30" onclick="toggleFavorite(false,30)" class="fa-solid fa-star"></i><img src="user_files/20230717095835_FB_IMG_1689601509915.jpg" onerror="this.onerror=null; this.src='notfound.png'"></div><div><div class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">260 million ₮</font></font></div><div class="title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tesla</font></font></div></div></div>				</div>
					</div>
				</div>	
			</div>
		</div>
		<div class="footer">
			<div class="wrap">
				<div style="display: flex; align-items: center; margin-left:10px; margin-top:5px">
					<img src="icon.png" width="35" height="35" style="object-fit: contain">
					<a href="https://www.facebook.com/profile.php?id=100094657236167" style="margin-left: 5px; margin-top: 2px">
						<img src="facebook_logo.png" width="32" height="32" style="object-fit: contain">
					</a>
				</div>
				<div class="left" style="margin-left:10px; margin-top:5px">
					<div class="service" style="color: white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Technical support: +97699213557</font></font></div>
					<div class="contact" style="color: white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Contact: +97699213557</font></font></div>
				</div>
				<div class="center" style="font-size: 14px; margin-left: 10px">
					<div><a style="text-decoration: none; color: white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Terms of Service</font></font></a></div>
					<div><a style="text-decoration: none; color: white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Procedure for publishing advertisements</font></font></a></div>
					<div><a style="text-decoration: none; color: white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Safe operation</font></font></a></div>
				</div>
			</div>
		</div>
	</body>
</html>