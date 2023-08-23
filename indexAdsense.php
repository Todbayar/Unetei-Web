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

	<link rel="shortcut icon" type="image/icon" href="android-chrome-512x512.png"/>
	<link rel="icon" type="image/x-icon" href="android-chrome-512x512.png">

	<script src="jquery-3.6.4.min.js"></script>
	<script src="jquery-ui.js"></script>
	<script src="latest_sortable.min.js"></script>
	<script src="jquery.Jcrop.min.js"></script>
	<script src="jquery.watermark.min.js" type="text/javascript"></script>

	<script src="kit.fontawesome.com_64e3bec699.js"></script>

	<link rel="stylesheet" href="jquery.Jcrop.min.css" type="text/css"/>
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="topbar.css">
	<link rel="stylesheet" href="buttons.css">
	<link rel="stylesheet" href="dropdowns.css">
	<link rel="stylesheet" href="animation.css">
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

	<!--Google Adsense-->
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1072207883073754" crossorigin="anonymous"></script>
</head>

<body>
	<div class="topbar">
		<div class="wrap">
			<div style="display: flex; align-items: center; cursor: pointer">
				<img src="icon.png" width="40" height="40" style="object-fit: contain">
				<div class="title">ZARCHI.MN</div>
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
				<i class="fa-regular fa-star" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer"></i>
				<i class="fa-regular fa-comments" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer; position: relative"></i>
			
				<div class="button_yellow" style="margin-left: 10px">
					<i class="fa-solid fa-plus"></i>
					<div class="removable" style="margin-left: 5px">Add an ad</div>
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
					column-gap: 12px;
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
				
				.searchResult .list .item:hover> div:nth-child(2) {
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
					-webkit-line-clamp: 2;
					/* number of lines to show */
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
					<div class="button_yellow" style="margin-left: 10px; background: #42c200">
						<i class="fa-solid fa-circle-chevron-down" style="color: white"></i>
					</div>
					<div id="searchSubmit" class="button_yellow" style="margin-left: 10px; background: #42c200">
						<i class="fa-solid fa-magnifying-glass" style="color: white"></i>
						<div class="removable" style="margin-left: 5px; color: white">Search</div>
					</div>
				</div>
				<div class="searchCategoryList">
					<div id="searchCategoryListSelected" class="searchCategoryListSelected"></div>
					<div id="searchCategoryListAvailable" class="searchCategoryListAvailable">
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage1" src="user_files/20230630102928_clotheshanger2.png" width="32px" height="32px">
							<div style="margin-left: 5px">Clothing</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage2" src="user_files/20230630103204_realestate.png" width="32px" height="32px">
							<div style="margin-left: 5px">Real-Estate</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage3" src="user_files/20230630103621_car2.png" width="32px" height="32px">
							<div style="margin-left: 5px">Car</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage4" src="user_files/20230630103801_Double-J-Design-Diagram-Free-Suitcase.128.png" width="32px" height="32px">
							<div style="margin-left: 5px">Job</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage5" src="user_files/20230630103906_kidcloth.png" width="32px" height="32px">
							<div style="margin-left: 5px">Children's goods</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage6" src="user_files/20230630104021_Icons-Land-Vista-Hardware-Devices-Portable-Computer.256.png" width="32px" height="32px">
							<div style="margin-left: 5px">Computer spare parts</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage7" src="user_files/20230630104131_Designcontest-Ecommerce-Business-Iphone.256.png" width="32px" height="32px">
							<div style="margin-left: 5px">Phone number</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage8" src="user_files/20230630104222_Julie-Henriksen-Kitchen-Rotating-Stand-Mixer.512.png" width="32px" height="32px">
							<div style="margin-left: 5px">Electronics</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage9" src="user_files/20230630104257_red-sofa-furniture-icon-png-4.png" width="32px" height="32px">
							<div style="margin-left: 5px">Household items</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage10" src="user_files/20230630104351_Treetog-Junior-Tool-box.256.png" width="32px" height="32px">
							<div style="margin-left: 5px">Equipment, materials, fuel</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage11" src="user_files/20230630104437_Kevin-Andersson-Sportset-Basketball.128.png" width="32px" height="32px">
							<div style="margin-left: 5px">Leisure sport hobby</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage12" src="user_files/20230630104518_4773193.png" width="32px" height="32px">
							<div style="margin-left: 5px">Health and beauty food</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage13" src="user_files/20230630104604_Google-Noto-Emoji-Animals-Nature-22215-dog.512.png" width="32px" height="32px">
							<div style="margin-left: 5px">Animals and plants</div>
						</div>
						<div class="button_yellow" style="float:left; margin:5px; height:18px; background: #f3f3f3">
							<img id="categoryImage14" src="user_files/20230630104647_6568544.png" width="32px" height="32px">
							<div style="margin-left: 5px">Service</div>
						</div>
					</div>
				</div>
				<div class="searchResult">
					<div id="typeVip" class="type" style="">Vip
						<div id="moreVip" class="button_yellow" style="margin-left: 10px; background: #42c200">
							<i class="fa-solid fa-eye" style="color: white"></i>
							<div style="margin-left: 5px; color: white">All</div>
						</div>
					</div>
					<div id="listVip" class="list">
						<div id="2" class="item">
							<div class="image">
								<div class="badge_vip" data-top="VIP"></div>
								<i class="count">
									<i class="fa-solid fa-camera"></i> 6
								</i>
								<i id="itemStar2" class="fa-solid fa-star"></i>
								<img src="user_files/20230710105145_349873272_277006198047880_4718706195623877596_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price"></div>
								<div class="title">Mercedes-Benz E300</div>
							</div>
						</div>
						<div id="1" class="item">
							<div class="image">
								<div class="badge_vip" data-top="VIP"></div>
								<i class="count">
									<i class="fa-solid fa-camera"></i> 9
								</i>
								<i id="itemStar1" class="fa-solid fa-star"></i>
								<img src="user_files/20230710104432_358116018_981795713065179_2453300629079806830_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price"></div>
								<div class="title">Mercedes-Benz C class </div>
							</div>
						</div>
						<div id="47" class="item">
							<div class="image">
								<div class="badge_vip" data-top="VIP"></div>
								<i class="count">
									<i class="fa-solid fa-camera"></i> 4
								</i>
								<i id="itemStar47" class="fa-solid fa-star"></i>
								<img src="user_files/20230819023835_FB_IMG_1690814326887.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">70,000</div>
								<div class="title">"HORSE JOURNEY" with khorho and aira</div>
							</div>
						</div>
						<div id="48" class="item">
							<div class="image">
								<div class="badge_vip" data-top="VIP"></div>
								<i class="count">
									<i class="fa-solid fa-camera"></i> 1
								</i>
								<i id="itemStar48" class="fa-solid fa-star"></i>
								<img src="user_files/20230819045810_20230819457 (3).jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">20,000</div>
								<div class="title">On-call driver service</div>
							</div>
						</div>
						<div id="29" class="item">
							<div class="image">
								<div class="badge_vip" data-top="VIP"></div>
								<i class="count">
									<i class="fa-solid fa-camera"></i> 10
								</i>
								<i id="itemStar29" class="fa-solid fa-star"></i>
								<img src="user_files/20230716070403_Mercedes-Benz GLB250 2.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">195 million</div>
								<div class="title">Mercedes Benz GLB250</div>
							</div>
						</div>
						<div id="25" class="item">
							<div class="image">
								<div class="badge_vip" data-top="VIP"></div><i class="count"><i class="fa-solid fa-camera"></i> 4</i><i id="itemStar25" class="fa-solid fa-star nohover" style="color: rgb(255, 167, 24)"></i><img src="user_files/20230716053720_FB_IMG_1689500204083.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">26 million</div>
								<div class="title">Mercedes-Benz B class</div>
							</div>
						</div>
					</div>
					<div id="typeSpecial" class="type" style="">Special offer
						<div id="moreSpecial" class="button_yellow" style="margin-left: 10px; background: #42c200">
							<i class="fa-solid fa-eye" style="color: white"></i>
							<div style="margin-left: 5px; color: white">All</div>
						</div>
					</div>
					<div id="listSpecial" class="list">
						<div id="20" class="item">
							<div class="image">
								<div class="badge_special" data-top="Special"></div>
								<i class="count">
									<i class="fa-solid fa-camera"></i> 6
								</i>
								<i id="itemStar20" class="fa-solid fa-star"></i>
								<img src="user_files/20230713042745_356237760_588283586765884_8624007535869539234_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">130 million</div>
								<div class="title">Happy town of 18 families</div>
							</div>
						</div>
						<div id="4" class="item">
							<div class="image">
								<div class="badge_special" data-top="Special"></div>
								<i id="itemStar4" class="fa-solid fa-star"></i>
								<video controls="controls" preload="metadata">
									<source src="user_files/20230711022559_Abu auto.mp4#t=0.5" type="video/mp4">
								</video>
							</div>
							<div>
								<div class="price"></div>
								<div class="title">Land 70/77</div>
							</div>
						</div>
						<div id="5" class="item">
							<div class="image">
								<div class="badge_special" data-top="Special"></div><i class="count"><i class="fa-solid fa-camera"></i> 15</i><i id="itemStar5" class="fa-solid fa-star"></i><img src="user_files/20230711032118_347261234_681584420649468_4914411282495982885_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">1.5 million</div>
								<div class="title">Four Seasons Amin Apartment</div>
							</div>
						</div>
						<div id="24" class="item">
							<div class="image">
								<div class="badge_special" data-top="Special"></div>
								<i class="count">
									<i class="fa-solid fa-camera"></i> 14</i>
								<i id="itemStar24" class="fa-solid fa-star"></i>
								<img src="user_files/20230716104349_FB_IMG_1689475353361.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">99 million</div>
								<div class="title">OSHAN Changan Z6</div>
							</div>
						</div>
						<div id="32" class="item">
							<div class="image">
								<div class="badge_special" data-top="Special"></div>
								<i class="count">
									<i class="fa-solid fa-camera"></i> 6
								</i>
								<i id="itemStar32" class="fa-solid fa-star"></i>
								<img src="user_files/20230718074929_FB_IMG_1689680765628.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price"></div>
								<div class="title">HP laptops</div>
							</div>
						</div>
						<div id="28" class="item">
							<div class="image">
								<div class="badge_special" data-top="Special"></div>
								<i id="itemStar28" class="fa-solid fa-star"></i>
								<video controls="controls" preload="metadata">
									<source src="user_files/20230716065604_10000000_6285391601580141_3070439283012735741_n.mp4#t=0.5" type="video/mp4">
								</video>
							</div>
							<div>
								<div class="price"></div>
								<div class="title">10 inch Android music for PRIUS 30</div>
							</div>
						</div>
					</div>
					<div id="typeRegular" class="type" style="">Regular ad
						<div id="moreRegular" class="button_yellow" style="margin-left: 10px; background: #42c200">
							<i class="fa-solid fa-eye" style="color: white"></i>
							<div style="margin-left: 5px; color: white">All</div>
						</div>
					</div>
					<div id="listRegular" class="list">
						<div id="26" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 6
								</i>
								<i id="itemStar26" class="fa-solid fa-star"></i>
								<img src="user_files/20230716055335_FB_IMG_1689500876454.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">25 million</div>
								<div class="title">Subaru XV CROSSTREK</div>
							</div>
						</div>
						<div id="46" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 2
								</i>
								<i id="itemStar46" class="fa-solid fa-star"></i>
								<img src="user_files/20230817073545_inbound3798095694114920141.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">2.4 million</div>
								<div class="title">alphard for sale, nothing to do</div>
							</div>
						</div>
						<div id="3" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 21</i>
								<i id="itemStar3" class="fa-solid fa-star"></i>
								<img src="user_files/20230710105816_356239541_645553930935572_1571876809064612152_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price"></div>
								<div class="title">GLE 350 </div>
							</div>
						</div>
						<div id="15" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 4
								</i>
								<i id="itemStar15" class="fa-solid fa-star"></i>
								<img src="user_files/20230711064744_340873292_598022128932585_7280145555943844603_n (1).jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">2.4 million</div>
								<div class="title">ELECTRIC SCOOTER</div>
							</div>
						</div>
						<div id="13" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 5
								</i>
								<i id="itemStar13" class="fa-solid fa-star"></i>
								<img src="user_files/20230711063625_355112997_634104872082098_6344473355094465961_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">3 million</div>
								<div class="title">197-house township G Villa</div>
							</div>
						</div>
						<div id="44" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 7
								</i>
								<i id="itemStar44" class="fa-solid fa-star"></i>
								<img src="user_files/20230816125959_received_968288987929922.jpeg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">170,000</div>
								<div class="title">A chair with a box underneath</div>
							</div>
						</div>
						<div id="14" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 18
								</i>
								<i id="itemStar14" class="fa-solid fa-star"></i>
								<img src="user_files/20230711064226_358033599_734163695383807_6822809836896517225_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price"></div>
								<div class="title">AUDI A6 QUATTRO</div>
							</div>
						</div>
						<div id="22" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 2</i>
								<i id="itemStar22" class="fa-solid fa-star"></i>
								<img src="user_files/20230716101712_FB_IMG_1689473745751.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">31.9 million</div>
								<div class="title">Mobile home</div>
							</div>
						</div>
						<div id="21" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 14
								</i>
								<i id="itemStar21" class="fa-solid fa-star"></i>
								<img src="user_files/20230716094207_FB_IMG_1689471469033.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">1.4 million</div>
								<div class="title">Argunt Tsagaan Khushkhan town</div>
							</div>
						</div>
						<div id="7" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 6
								</i>
								<i id="itemStar7" class="fa-solid fa-star"></i>
								<img src="user_files/20230711060400_350492757_777856830646422_2532586513060264074_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">99 million</div>
								<div class="title">FJ CRUISER (GSJ15L)</div>
							</div>
						</div>
						<div id="11" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 5
								</i>
								<i id="itemStar11" class="fa-solid fa-star"></i>
								<img src="user_files/20230711062519_347265375_581502247437480_524457547611890596_n.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">260 million</div>
								<div class="title">CENTENNIAL TOWN</div>
							</div>
						</div>
						<div id="23" class="item">
							<div class="image">
								<i class="count">
									<i class="fa-solid fa-camera"></i> 1
								</i>
								<i id="itemStar23" class="fa-solid fa-star"></i>
								<img src="user_files/20230716102958_FB_IMG_1689474541339.jpg" onerror="this.onerror=null; this.src='notfound.png'">
							</div>
							<div>
								<div class="price">79 million</div>
								<div class="title">Geely Coolray</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer">
		<div class="wrap">
			<div style="display: flex; align-items: center; margin-left:10px; margin-top:5px">
				<img src="icon.png" width="35" height="35" style="object-fit: contain">
				<img src="facebook_logo.png" width="32" height="32" style="object-fit: contain">
			</div>
			<div class="left" style="margin-left:10px; margin-top:5px">
				<div class="service" style="color: white">Technical support: +97699213557</div>
				<div class="contact" style="color: white">Contact: +97699213557</div>
			</div>
			<div class="center" style="font-size: 14px; margin-left: 10px">
				<div>Terms of Service</div>
				<div>Procedure for publishing advertisements</div>
				<div>Safe operation</div>
			</div>
		</div>
	</div>
</body>
</html>