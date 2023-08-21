<?php
session_start();

include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
include_once "chat_process.php";
//include_once "mysql_myzar_item_remove_process.php";	//for auto removal of expired item

//setcookie('googtrans', '/mn/en');

if($protocol=="http" && $_SERVER['HTTP_HOST']!="localhost") header("Location:https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!doctype html>
<html lang="mn-MN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Permissions-Policy" content="interest-cohort=()">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="facebook-domain-verification" content="qizqpj55lnc4ms6rcojpn16hp079ax" />
		<meta property="fb:app_id" content="941510830473804" /> 
		<meta property="og:site_name" content="<?php echo $domain; ?>" />
		
		<!--Google Translate-->
<!--		<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
		<script type="text/javascript">
		function googleTranslateElementInit() {
			console.log("<timezone>:"+Intl.DateTimeFormat().resolvedOptions().timeZone);
			//if(Intl.DateTimeFormat().resolvedOptions().timeZone!="Asia/Ulaanbaatar"){
				new google.translate.TranslateElement({pageLanguage: 'mn'}, 'google_translate_element');
			//}
		}
		</script>
		
		<?php
		//LOGGING LAST ACTIVE DATETIME OF USER
		if(!isset($_SESSION['lastactive']) && isset($_COOKIE["userID"])){
			$lastactiveDateTime = date("Y-m-d h:i:s");
			$_SESSION['lastactive'] = $lastactiveDateTime;
			$queryLastActive = "UPDATE user SET lastactive='".$lastactiveDateTime."' WHERE id=".$_COOKIE["userID"];
			@$conn->query($queryLastActive);
		}
		
		if(isset($queryURL["page"]) && $queryURL["page"]=="detail"){
			/* MAKING FOLLOWER */
			if(isset($queryURL["action"]) && $queryURL["action"]=="share"){
				if(isset($_COOKIE["userID"])){
					makingFollowerFromShare($queryURL["id"], $_COOKIE["userID"]);
				}
				else {
					$_SESSION["share"] = $queryURL["id"];
				}
			}
			
			/* OPEN GRAPH FOR SHARING WEB */
			$ogDetailID = $queryURL["id"];
			$queryOG = "SELECT *, (SELECT image FROM images WHERE item=item.id LIMIT 1) AS image FROM item RIGHT JOIN user ON user.id=item.userID WHERE item.id=".$ogDetailID;
			$resultOG = $conn->query($queryOG);
			$rowOG = mysqli_fetch_array($resultOG);

			//category
			$splitaOG = explode("_", $rowOG["category"]);
			$ogTableID = intval(substr($splitaOG[0], 1));
			$ogID = intval($splitaOG[1]);
			$arrCategoriesOG = array();
			for($i=$ogTableID; $i>=1; $i--){
				$queryCategoryOG = "SELECT * FROM category".$i." WHERE id=".$ogID;
				$resultCategoryOG = $conn->query($queryCategoryOG);
				$rowCategoryOG = mysqli_fetch_array($resultCategoryOG);
				$arrCategoriesOG["text"][] = $rowCategoryOG["title"];
				if($i>1) $ogID = $rowCategoryOG["parent"];
			}
			$arrCategoriesOG["text"] = array_reverse($arrCategoriesOG["text"]);
			$price = $rowOG["price"]!=0?" (".convertPriceToText($rowOG["price"])." ₮)":"";
			?>
			<title><?php echo $rowOG["title"]; ?></title>
			<meta property="og:title" content="<?php echo $rowOG["title"].$price; ?>" />
			<meta property="og:description" content="<?php echo implode(' > ', $arrCategoriesOG["text"]); ?>" />
			<meta property="og:image:alt" content="<?php echo stripslashes(strip_tags(htmlspecialchars_decode(html_entity_decode($rowOG["description"])))); ?>" />
			<meta name="description" content="<?php echo stripslashes(strip_tags(htmlspecialchars_decode(html_entity_decode($rowOG["description"])))); ?>">
		  	<meta name="keywords" content="<?php echo $website_keywords.", ".$rowOG["title"]; ?>">
		  	<meta name="author" content="<?php echo $rowOG["title"]; ?>">
			<?php
			if($rowOG["image"]!=""){
				$ogImage = $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST'])."/".$path."/".$rowOG["image"];
				?>
				<meta property="og:type" content="website" />
				<meta property="og:image" content="<?php echo $ogImage; ?>" />
				<meta property="og:image:secure_url" content="<?php echo $ogImage; ?>" />
				<?php
			}
			else if($rowOG["youtube"]!=""){
				$ogImage = $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST'])."/watermark.png";
				?>
				<meta property="og:type" content="video.movie" />
				<meta property="og:video" content="<?php echo $rowOG["youtube"]; ?>" />
				<meta property="og:image" content="<?php echo $ogImage; ?>" />
				<meta property="og:image:secure_url" content="<?php echo $ogImage; ?>" />
				<?php
			}
			else if($rowOG["video"]!=""){
				$ogVideo = $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST'])."/".$path."/".$rowOG["video"];
				$ogImage = $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST'])."/watermark.png";
				?>
				<meta property="og:type" content="video.movie" />
				<meta property="og:video" content="<?php echo $ogVideo; ?>" />
				<meta property="og:video:secure_url" content="<?php echo $ogVideo; ?>" />
				<meta property="og:video:type" content="<?php echo findTypeOfVideo($rowOG["video"]); ?>" />
				<meta property="og:image" content="<?php echo $ogImage; ?>" />
				<meta property="og:image:secure_url" content="<?php echo $ogImage; ?>" />
				<?php
			}
			else {
				?>
				<meta property="og:type" content="website" />
				<meta property="og:image" content="<?php echo $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST'])."/notfound.png"; ?>" />
				<?php
			}
		}
		
		if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']==""){
			//MAKING FOLLOWER
			if(isset($_SESSION["share"]) && isset($_COOKIE["userID"])){
				makingFollowerFromShare($_SESSION["share"], $_COOKIE["userID"]);
			}
			
			//OPEN GRAPH
			$ogImage = $protocol."://".($_SERVER['HTTP_HOST']=="localhost"?($_SERVER['HTTP_HOST']."/".strtolower($domain_title)):$_SERVER['HTTP_HOST'])."/logo_200.jpg";
			?>
			<meta property="og:type" content="website" />
			<meta property="og:title" content="<?php echo $domain_title; ?>" />
			<meta property="og:description" content="Зараа оруул, Брэндээ үүсгэ, Дэлгүүрээ нээ, Түгээ, Орлого ол, Удирд" />
			<meta property="og:image" content="<?php echo $ogImage; ?>" />
			<meta property="og:image:secure_url" content="<?php echo $ogImage; ?>" />
			<meta property="og:image:width" content="158" />
			<meta property="og:image:height" content="47" />
			<meta name="description" content="<?php echo $website_description; ?>">
		  	<meta name="keywords" content="<?php echo $website_keywords; ?>">
		  	<meta name="author" content="<?php echo $domain_title; ?>">
			<title><?php echo $domain_title; ?></title>
			<?php
		}
		else if(isset($_SERVER['QUERY_STRING']) && isset($queryURL["page"]) && !str_contains($queryURL["page"],"detail")) {
			if($queryURL["page"]=="myzar"){
				$varTitle = "Миний зар - ";
				switch($queryURL["myzar"]){
					case "item":
						$varTitle .= "Зар";
						break;
					case "category":
						$varTitle .= "Ангилал";
						break;
					case "followers":
						$varTitle .= "Дагагчид";
						break;
					case "profile":
						$varTitle .= "Тохиргоо";
						break;
				}
				?>
				<title><?php echo $varTitle; ?></title>
				<?php
			}
			else {
				?>
				<title><?php echo $queryURL["page"]; ?></title>
				<?php
			}
		}
		?>
		
		<meta name="robots" content="index, follow" />
		
		<link rel="shortcut icon" type="image/icon" href="<?php echo $urlDepth; ?>android-chrome-512x512.png" />
		<link rel="icon" type="image/x-icon" href="<?php echo $urlDepth; ?>android-chrome-512x512.png">
		
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-app-compat.js"></script>
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-auth-compat.js"></script>
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-messaging-compat.js"></script>
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-analytics-compat.js"></script>
		
		<script src="<?php echo $urlDepth; ?>jquery-3.6.4.min.js"></script>
		<script src="<?php echo $urlDepth; ?>jquery-ui.js"></script>
		<script src="<?php echo $urlDepth; ?>latest_sortable.min.js"></script>
		<script src="<?php echo $urlDepth; ?>kit.fontawesome.com_64e3bec699.js"></script>
		<script src="<?php echo $urlDepth; ?>misc.js"></script>
		
		<script src="<?php echo $urlDepth; ?>jquery.Jcrop.min.js"></script>
		<link rel="stylesheet" href="<?php echo $urlDepth; ?>jquery.Jcrop.min.css" type="text/css" />
		
		<script src="<?php echo $urlDepth; ?>jquery.watermark.min.js" type="text/javascript"></script>
		
		<link rel="stylesheet" href="<?php echo $urlDepth; ?>main.css">
		<link rel="stylesheet" href="<?php echo $urlDepth; ?>topbar.css">
		<link rel="stylesheet" href="<?php echo $urlDepth; ?>buttons.css">
		<link rel="stylesheet" href="<?php echo $urlDepth; ?>dropdowns.css">
		<link rel="stylesheet" href="<?php echo $urlDepth; ?>animation.css">
		
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
		
		<!--Google Adsense-->
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1072207883073754" crossorigin="anonymous"></script>
<!--
		<script async src="https://fundingchoicesmessages.google.com/i/pub-1072207883073754?ers=1" nonce="PO6kR1zJogD8YhBe921qUQ">
		</script>
		<script nonce="PO6kR1zJogD8YhBe921qUQ">(function(){function signalGooglefcPresent() {if (!window.frames['googlefcPresent']) {if (document.body) {const iframe = document.createElement('iframe'); iframe.style = 'width: 0; height: 0; border: none; z-index: -1000; left: -1000px; top: -1000px;'; iframe.style.display = 'none'; iframe.name = 'googlefcPresent'; document.body.appendChild(iframe);} else {setTimeout(signalGooglefcPresent, 0);}}}signalGooglefcPresent();})();</script>
-->
		
		<!--Firebase-->
		<script>
		const firebaseConfig = {
			apiKey: "AIzaSyAJxCfAZKgG4vy_nd6UVX3UKhZAF0iyKl4",
			authDomain: "unetei-bc717.firebaseapp.com",
			projectId: "unetei-bc717",
			storageBucket: "unetei-bc717.appspot.com",
			messagingSenderId: "834168591977",
			appId: "1:834168591977:web:ee2f1d66da1dcd0e33b4f8",
			measurementId: "G-Q1YLJDB3KC"
		};
		firebase.initializeApp(firebaseConfig);
		const analytics = firebase.analytics();
		
		var timerDropDownMenu;
		
		$(document).ready(function(){
			//this firebase cloud messaging works but not perfect
			//sendNotification("?page=chat&toID=2", 1);	//php
//			if('serviceWorker' in navigator){
//				navigator.serviceWorker.register('<?php echo $urlDepth; ?>firebase-messaging-sw.js');
//				const messaging = firebase.messaging();	//not working bcz of service not supported on mobile android
//				var eventNotification = new CustomEvent("notificationDone");
//				window.addEventListener("notificationDone", function(){
//					Notification.requestPermission().then((permission) => {
//						if(permission === 'granted'){
//							console.log('<notification>:Permission granted');
//							messaging.getToken({vapidKey: "<?php echo $firebase_public_vapid_key; ?>"}).then((currentToken) => {
//								if (currentToken) {
//									console.log('<notification>:token received:', currentToken);
//									$.post("mysql_user_fcm.php", {token:currentToken}).done(function(){
//										console.log("Saved token");
//									});
//									localStorage.setItem("isNotificationGranted", true);
//								}
//								else {
//									console.log("<notification>:Permission required!");
//								}
//							}).catch((err) => {
//								console.log('<notification>:An error occurred while retrieving token. ', err);
//							});
//						}
//						else {
//							localStorage.setItem("isNotificationGranted", false);
//						}
//					});
//				});
//				<?php
//				if(isset($_COOKIE["userID"])){
//					?>
//					if(localStorage.getItem("isNotificationGranted")==null){	
//						confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i> Та мэдэгдэл хүлээж авхыг зөвшөөрнө үү, ингэснээр цаг алдалгүй таньд ирэх <b>гүйлгээ</b>, <b>хүсэлтүүд</b>, <b>баталгаажуулалт</b> зэрэг чухал мэдээллийн мэдэгдэл хүлээн авах боломжтой болж та <?php echo $domain; ?>-ыг бүрэн удирдах эрхтэй болно.", eventNotification);
//					}
//					<?php
//				}
//				?>
//			}
//			else {
//				console.log('Service Worker not supported');
//			}
			
			<?php
			if(isset($_COOKIE["userID"])){
				?>
				$("#myzar_phone").text("<?php echo getPhone($_COOKIE["userID"]); ?>");
				$("#myzar_nav").text("Миний зар");
				$("#myzar_button").attr("onclick","pagenavigation('myzar')");
				$("#logoutButton").css("display", "flex");
				<?php
			}
			?>

			$(".myzar").hover(function(){
				$(".dropdown").show();
			}, function(){
				timerDropDownMenu = setTimeout(function(){
					$(".myzar .dropdown").hide();
					clearTimeout(timerDropDownMenu);
				}, 3000);
			});
			
			$(".myzar .dropdown").hover(function(){
				clearTimeout(timerDropDownMenu);
				$(".dropdown").show();
			}, function(){
				$(".dropdown").hide();
			});
			
			$('.watermark').watermark({
				text: '<?php echo strtoupper($domain); ?>',
				textWidth: 100,
				gravity: 'w',
				opacity: 1,
				margin: 12
			});

			$('.watermark2').watermark({
				path: 'watermark.png',
				margin: 0,
				gravity: 'nw',
				opacity: 0.73,
				outputWidth: 400
			});
			
			//becoming follower
			$(".popup.become_follower input#phone").on('input',function(){
				var phone = $(this).val();
				if(phone.length==8){
				   	$(".popup.become_follower button#yes").prop("disabled",false);
			    }
				else {
					$(".popup.become_follower button#yes").prop("disabled",true);
				}
			});
			
//			if(localStorage.getItem("isBecameFollower")==null){
//				<?php
//				if(isset($_COOKIE["userID"]) && getPhone($_COOKIE["userID"])!=$superduperadmin){
//					?>
//					$(".popup.become_follower").show();
//					$("body").css("overflow-y", "hidden");
//					window.scrollTo(0, 0);
//					<?php
//				}
//				?>
//			}
			
			//verifying email
			$(".popup.verify_email input#email").on('input',function(){
				var email = $(this).val();
				const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				if(emailPattern.test(email)){
				   	$(".popup.verify_email button#yes").prop("disabled",false);
			    }
				else {
					$(".popup.verify_email button#yes").prop("disabled",true);
				}
			});
			
			<?php
			if(isset($_GET["emailverificationid"])){
				?>
				$.post("mysql_user_email_verification.php",{emailverificationid:<?php echo $_GET["emailverificationid"]; ?>}).done(function(response){
					console.log("<isVerfication:>:"+response);
					if(response=="OK"){
						var eventOk = new CustomEvent("emailVerificationDone");
						window.addEventListener("emailVerificationDone", function(){
							location = location.pathname;
						});
						confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Таны имэйл <b>амжилттай</b> баталгаажлаа.", eventOk);
					}
			  	});
				<?php
			}
			else {
				?>
				if(sessionStorage.getItem("isEmailVerified")==null){
					<?php
					if(isset($_COOKIE["userID"])){
						$vUserEmail = getEmail($_COOKIE["userID"]);
						if(is_null($vUserEmail) || $vUserEmail==""){
							?>
							$(".popup.verify_email").show();
							$("body").css("overflow-y", "hidden");
							window.scrollTo(0, 0);
							<?php
						}
					}
					?>
				}
				<?php
			}
			?>
		});
		
		function clearSearch(){
			$("#searchQuality option").eq(0).prop("selected", true);
			$("#searchOrder option").eq(0).prop("selected", true);
			$("#searchPriceLimitLowest option").eq(0).prop("selected", true);
			$("#searchPriceLimitHighest option").eq(0).prop("selected", true);
			$("#searchCity option").eq(0).prop("selected", true);
			$("#searchRate option").eq(0).prop("selected", true);
		}
			
		function become_follower(isBecame){
			if(typeof isBecame === "boolean"){
				const affiliate = $(".popup.become_follower input#phone").val();
	//			console.log("<become_follower>:"+affiliate);
				if(isBecame){
					$.post("mysql_user_follower.php", {phone:affiliate}).done(function(response){
						if(response=="OK"){
							localStorage.setItem("isBecameFollower",true);
							$("body").css("overflow-y", "auto");
							$(".popup.become_follower").hide();
						}
						else {
							localStorage.setItem("isBecameFollower",false);
							$(".popup.become_follower div#error").text("Дагагч болход алдаа гарлаа!");
						}
					});
				}
				else {
					localStorage.setItem("isBecameFollower",false);
					$("body").css("overflow-y", "auto");
					$(".popup.become_follower").hide();
				}
			}
			else if(typeof isBecame === "string") {
				localStorage.setItem("isBecameFollower",false);
				pagenavigation(isBecame);
			}
		}
			
		function verify_email(isValid){
			if(isValid){
				$.post("mysql_user_email_verification.php",{email:$(".popup.verify_email input#email").val()}).done(function(response){
					console.log("<verify_email>:"+response);
					if(response=="OK"){
						confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Таны имэйлрүү <b>баталгаажуулах</b> линк илгээлээ, та имэйлээ шалгана уу!", null);
						//console.log("Updated user email");
					}
					else {
						console.log("Updateding user email is failed!");
					}
				});
				sessionStorage.setItem("isEmailVerified",true);
				$(".popup.verify_email").hide();
				$("body").css("overflow-y", "auto");
		    }
			else {
				sessionStorage.setItem("isEmailVerified",false);
				$(".popup.verify_email").hide();
				$("body").css("overflow-y", "auto");
			}
		}
		</script>
		
		<style>
		#google_translate_element {
			display: none;
		}
		.goog-te-gadget img{
			display:none !important;
		}
		body > .skiptranslate {
			display: none;
		}
		body {
			top: 0px !important;
		}
		</style>
	</head>
	
	<body>
		<div id="google_translate_element"></div>
		<div class="topbar">
			<div class="wrap">
			<?php include "topbar.php"; ?>
			</div>
			<!--Waves Container-->
			<div class="animation_waves">
				<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
				viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
					<defs>
						<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
					</defs>
					<g class="parallax">
						<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(55,163,0,0.7" />
						<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(55,163,0,0.5)" />
						<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(55,163,0,0.3)" />
						<use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
					</g>
				</svg>
			</div>
			<!--Waves end-->
		</div>
		<div class="mid">
			<div class="wrap">
			<?php
			if(isset($_GET["page"])){
				switch($_GET["page"]){
					case "login":
						include "login.php";
						break;
					case "loginsms":
						include "loginsms.php";
						break;
					case "myzar":
						include "myzar.php";
						break;
					case "chat":
						include "chat.php";
						break;
					case "detail":
						include "detail.php";
						break;
					case "favorite":
						include "favorite.php";
						break;
					case "team":
						include "team.php";
						break;
				}
			}
			else {
				include "home.php";
			}
			?>
			</div>
		</div>
		<div class="footer">
			<div class="wrap">
				<div style="display: flex; align-items: center; margin-left:10px; margin-top:5px">
					<img src="<?php echo $urlDepth; ?>icon.png" width="35" height="35" style="object-fit: contain" />
<!--
					<a href="https://www.hipay.mn/"><img src="<?php echo $urlDepth; ?>hipay.png" width="40" height="40" style="object-fit: contain" /></a>
					<a href="https://www.arduino.cc/"><img src="<?php echo $urlDepth; ?>arduino.gif" width="35" height="35" style="object-fit: contain" /></a>
-->
					<a href="https://www.facebook.com/profile.php?id=100094657236167" style="margin-left: 5px; margin-top: 2px">
						<img src="<?php echo $urlDepth; ?>facebook_logo.png" width="32" height="32" style="object-fit: contain" />
					</a>
				</div>
				<div class="left" style="margin-left:10px; margin-top:5px">
					<div class="service" style="color: white">Техникийн тусламж: <?php echo $service_phone; ?></div>
					<div class="contact" style="color: white">Холбоо барих: <?php echo $contact_phone; ?></div>
				</div>
				<div class="center" style="font-size: 14px; margin-left: 10px">
					<div><a href="policy.php" style="text-decoration: none; color: white">Үйлчилгээний нөхцөл</a></div>
					<div><a href="rule.php" style="text-decoration: none; color: white">Зар нийтлэх журам</a></div>
					<div><a href="agreement.php" style="text-decoration: none; color: white">Аюулгүй ажиллагаа</a></div>
				</div>
			</div>
		</div>
		
		<!--here comes popups-->
		<?php
		if(isset($_COOKIE["userID"])){ 
			$rowPopupUser = mysqli_fetch_array($conn->query("SELECT * FROM user WHERE id=".$_COOKIE["userID"]));
			$rowPopupUser["item_publish_option"] = getCountItem($_COOKIE["userID"]);
		}
		?>
		
		<div class="popup yesno" style="display: none">
			<div class="container">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup yesno')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Мэдэгдэл</div>
				<div class="message"></div>
				<div class="action">
					<button id="yes" class="button_yellow"><i class="fa-solid fa-check"></i>Тийм</button>
					<button id="no" class="button_yellow"><i class="fa-solid fa-xmark"></i>Үгүй</button>
				</div>
			</div>
		</div>
		
		<div class="popup ok" style="display: none">
			<div class="container">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup ok')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Мэдэгдэл</div>
				<div class="message"></div>
				<div class="action">
					<button id="ok" class="button_yellow"><i class="fa-solid fa-check"></i>За</button>
				</div>
			</div>
		</div>
		
		<div class="popup myzar_category_enter" style="display: none">
			<div class="container" style="width: 320px">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup myzar_category_enter')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Ангилал нэмэх</div>
				<div style="display: flex; margin-left: 5px; margin-right: 5px; margin-top: 5px; min-height: 50px">
					<img id="myzar_category_enter_icon_image" class="icon_button" src="<?php echo $urlDepth; ?>image-solid.svg" width="32" height="32" onClick="myzar_category_enter_icon_button()" style="cursor: pointer; display: inline-block;
	vertical-align: top" />
					<input id="myzar_category_enter_icon_file" class="icon_file" type="file" required="true" accept="image/png, .svg" style="display: none" />
					<div class="myzar_category_enter_title_container" style="margin-left: 5px; margin-right: 5px; margin-bottom: 5px; width: 95%; display: none">
						<textarea id="myzar_category_enter_title" placeholder="Гарчигууд" style="font: normal 14px Arial; border-radius:10px; padding: 5px; min-height: 95px; width: 95%"></textarea>
						<div style="color: gray; font-size: 12px">Олон гарчигыг дунд нь ; (цэг таслал) таслан бичнэ үү, жишээ нь: Audi;Nissan;Mercedes Benz</div>
					</div>
					<input id="myzar_category_enter_title" type="text" maxlength="128" placeholder="Гарчиг" style="margin-left: 5px; margin-right: 5px; width: 95%; height: 20px; padding: 5px; font: normal 14px Arial; border-radius:10px" />
					<i class="fa-solid fa-square-plus myzar_category_enter_title_toggle_multi" onClick="toggleCategoryEntryLines()" style="font-size: 32px; color: #FFA718; cursor: pointer"></i>
					<i class="fa-solid fa-square-minus myzar_category_enter_title_toggle_single" onClick="toggleCategoryEntryLines()" style="font-size: 32px; color: #FFA718; cursor: pointer; display: none"></i>
				</div>
				<div id="myzar_category_enter_msg" class="msg"></div>
				<div id="myzar_category_enter_error" class="error"></div>
				<?php
				if(isset($rowPopupUser) && $rowPopupUser["role"]>=3){
				?>
				<div style="margin-left: 10px">
					<div>Ангиллын төрөл</div>
					<div>
						<div>
							<input type="radio" id="myzar_category_enter_type" name="myzar_category_enter_type" value="0" checked="checked"><label for="myzar_category_enter_type">Энгийн</label>
						</div>
						<div>
							<input type="radio" id="myzar_category_enter_type" name="myzar_category_enter_type" value="1"><label for="myzar_category_enter_type">Брэнд/Дэлгүүр</label>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<div id="myzar_category_enter_words" style="margin-left: 5px; margin-right: 5px"></div>
				<input id="myzar_category_enter_words_input" class="words" type="text" maxlength="128" placeholder="Үгнүүд (заавал биш)" style="margin-top:5px; margin-left: 10px; margin-right: 10px; width: 90%; height: 20px; padding: 5px; font: normal 14px Arial; border-radius:10px" onkeypress="return myzar_category_enter_words(event)" />
				<div style="margin-top:5px; margin-left: 10px; margin-right: 10px; font-size: 14px">
					<div id="myzar_category_enter_word_error" class="error"></div>
					<i class="fa-solid fa-circle-info" style="color: #FFA718; margin-right: 5px"></i>Ангилалтай холбоотой үгсийг бичнэ үү. Жишээ нь: Шал, тагт, граж, г.м...
				</div>
				<button id="myzar_category_enter_submit" onClick="myzar_category_enter_submit()" disabled class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">Илгээх</button>
			</div>
		</div>
		
		<div class="popup myzar_user_upgrade" style="display: none">
			<div class="container" style="width: 320px; top: 3.5vh; height:600px">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup myzar_user_upgrade')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Хэрэглэгчийн эрх</div>
				<div style="height:520px; overflow-y: scroll">
					<div class="affiliate" style="font-size: 14px; margin-bottom: 5px; margin-top: 10px; margin-left: 10px; margin-right: 10px; display: none"><a id="affiliate"></a><br/><a style="font-size: 12px; color: red">Өөрчлөхийг хүсвэл уг цонхыг хаагаад (Миний зар <i class="fas fa-angle-right"></i> Тохиргоо)-ны "Дагагч болох"-ын доор утасны дугаарыг нь оруулаад дахин энэ цонхыг нээнэ үү.</a></div>
					<div class="selection superadmin">
						<div style="font: bold 16px Arial"><input type="radio" id="role" name="role" value="4"> Сүпер админ</div>
						<div class="price" style="margin-left: 25px"><?php echo number_format($role_price_superadmin); ?> ₮</div>
						<ul style="font-size: 14px">
							<li>Сүпер дүпер админд <?php echo $item_boost_superadmin; ?> удаа Facebook Boost хийх хүсэлт илгээх</li>
							<li>Өөрийн дагагчдаас <i>орлого</i> хүлээн авах</li>
							<li>Хязгааргүй ангилал нэмэх эсвэл брэнд үүсгэх</li>
							<li>Хязгааргүй VIP, Онцгой, Энгийн зар нэмэх</li>
							<li>Удирдах <i>бүрэн эрх</i>, хүсэлтүүдийг хянах</li>
						</ul>
					</div>
					<div class="selection admin">
						<div style="font: bold 16px Arial"><input type="radio" id="role" name="role" value="3"> Админ</div>
						<div class="price" style="margin-left: 25px"><?php echo number_format($role_price_admin); ?> ₮</div>
						<ul style="font-size: 14px">
							<li>Сүпер дүпер админд <?php echo $item_boost_admin; ?> удаа Facebook Boost хийх хүсэлт илгээх</li>
							<li>Өөрийн дагагчдаас <i>орлого</i> хүлээн авах</li>
							<li>Хязгааргүй ангилал нэмэх эсвэл 10 брэнд үүсгэх</li>
							<li>Хязгааргүй Энгийн зар нэмэх болон 10 VIP/Онцгой зар нэмэх </li>
							<li>Удирдах <i>хязгаарлагдмал эрх</i>, хүсэлтүүдийг хянах</li>
						</ul>
					</div>
					<div class="selection manager">
						<div style="font: bold 16px Arial"><input type="radio" id="role" name="role" value="2"> Менежер</div>
						<div class="price" style="margin-left: 25px"><?php echo number_format($role_price_manager); ?> ₮</div>
						<ul style="font-size: 14px">
							<li>Өөрийн дагагчдаас <i>орлого</i> хүлээн авах</li>
							<li>10 ангилал нэмэх</li>
							<li>Хязгааргүй Энгийн зар нэмэх</li>
						</ul>
					</div>
					<div class="selection publisher" style="display: none">
						<div style="font: bold 16px Arial"><input type="radio" id="role" name="role" value="1"> Нийтлэгч</div>
						<div style="margin-left: 25px"><?php echo number_format($role_price_publisher); ?> ₮</div>
						<ul style="font-size: 14px">
							<li>10 ангилал нэмэх</li>
							<li>Хязгааргүй Энгийн зар нэмэх</li>
						</ul>
					</div>
				</div>
				<button id="buttonSubmit" disabled class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">Илгээх</button>
			</div>
		</div>
		
		<div class="popup billing" style="display: none">
			<div class="container" style="width: 320px; top: 5vh">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup billing')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Төлбөр төлөх</div>
				<div style="display:block; margin:10px; font-size: 14px">
					<div id="billing_type"></div>
					<div id="billing_number"></div>
					<div id="billing_title"></div>
					<div id="billing_price" style="font: bold 16px Arial; margin-top: 10px"></div>
				</div>
				<div>
					<div id="billing_bank" style="font-size: 14px; margin-left: 10px">
						<div style="margin-bottom: 5px">Дараах данс руу илгээнэ үү.</div>
						<div style="margin-bottom: 5px"><a id="name" style="font-size: 16px"></a>-ны данс:</div>
						<div style="margin-bottom: 5px">
							<a id="account" style="font-size: 16px"></a>
							<i id="copyToClipboard" onclick="copyToClipboardBankAccountNumber()" class="fa-solid fa-copy" style="margin-left: 5px; font-size: 16px; cursor: pointer"></i>
						</div>
						<div>Хүлээн авагч: <a id="owner" style="font-size: 16px"></a></div>
					</div>
					<div id="billing_qr">
						<div style="margin-left: 10px; margin-top: 10px; display: flex; align-items: center">
							<img src="<?php echo $urlDepth; ?>hipay.png" width="40px" height="40px" style="margin-right: 5px" />HiPay-аар төлөх:
						</div>
						<div id="billing_socialpay" style="font-size: 14px; margin-left: 10px; margin-top: 10px; text-align: center">
							<img style="width: 150px; height: 150px" />
						</div>
					</div>
					<div style="font-size: 14px">
						<ul>
							<li><a style="text-decoration: underline">Гүйлгээний утга</a> дээр заавал: <b style="color: red">УТАСНЫ ДУГААР</b> оруулна уу.</li>
							<li>Таны захиалсан үйлчилгээ (онцгой зар, зар шинэчлэх, хэрэглэгчийн эрхээ дээшлүүлэх гэх мэт) мөнгө шилжсэний дараа идэвхжинэ.</li>
<!--							<li>Хэрвээ та заасан төлбөрөөс илүүг шилжүүлбэл хариулт мөнгө тань таны сайтны дансанд орох болно.</li>-->
						</ul>
					</div>
				</div>
				<button onClick="javascript:document.getElementsByClassName('popup billing')[0].style.display='none'; javascript:document.body.style.overflowY='auto'" class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">За</button>
			</div>
		</div>
		
		<div class="popup search" style="display: none">
			<div class="container" style="width: 320px; top: 5vh">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup search')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Нарийвчлан хайх</div>
				<div style="margin: 10px">
					<label for="searchQuality">Шинэ/хуучин:</label>
					<select id="searchQuality" style="width: 120px; height: 30px; font: normal 15px Arial; border-radius: 10px">
						<option value="" selected>Бүгд</option>
						<option value="0">Шинэ</option>
						<option value="1">Хуучин</option>
					</select>
				</div>
				<div style="margin: 10px">
					<label for="searchOrder">Эрэбмэ:</label>
					<select id="searchOrder" style="width: 180px; height: 30px; font: normal 15px Arial; border-radius: 10px">
						<option value="0" selected>Эрэлтээр их</option>
						<option value="1">Эрэлтээр бага</option>
						<option value="2">Огноогоор шинэ</option>
						<option value="3">Огноогоор хуучин</option>
						<option value="4">Хямд нь эхэндээ</option>
						<option value="5">Үнэтэй нь эхэндээ</option>
					</select>
				</div>
				<?php
				$queryPriceRange = "SELECT MAX(price) AS max, MIN(price) as min, (MAX(price)-MIN(price))/10 AS step FROM item WHERE isactive=4 LIMIT 1";
				$resultPriceRange = $conn->query($queryPriceRange);
				if(mysqli_num_rows($resultPriceRange)>0){
					$rowPriceRange = mysqli_fetch_array($resultPriceRange);
					?>
					<div style="margin: 10px">
						<label for="searchPriceLimit">Үнэ:</label>
						<select id="searchPriceLimitLowest" style="width: 120px; height: 30px; font: normal 15px Arial; border-radius: 10px">
							<option value="0" disabled selected>Доод</option>
							<?php
							if($rowPriceRange["max"]!=null){
								for($price=$rowPriceRange["max"]; $price>$rowPriceRange["min"]; $price -= $rowPriceRange["step"]){
									?>
									<option value="<?php echo convertPriceToNumber($price); ?>"><?php echo convertPriceToText($price); ?></option>
									<?php
								}
								?>
								<option value="<?php echo convertPriceToNumber($rowPriceRange["min"]); ?>"><?php echo convertPriceToText($rowPriceRange["min"]); ?></option>
								<?php
							}
							?>
						</select>
						<select id="searchPriceLimitHighest" style="width: 120px; height: 30px; font: normal 15px Arial; border-radius: 10px">
							<option value="0" disabled selected>Дээд</option>
							<?php
							if($rowPriceRange["max"]!=null){
								for($price=$rowPriceRange["max"]; $price>$rowPriceRange["min"]; $price -= $rowPriceRange["step"]){
									?>
									<option value="<?php echo convertPriceToNumber($price); ?>"><?php echo convertPriceToText($price); ?></option>
									<?php
								}
								?>
								<option value="<?php echo convertPriceToNumber($rowPriceRange["min"]); ?>"><?php echo convertPriceToText($rowPriceRange["min"]); ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<?php
				}
				?>
				<div style="margin: 10px">
					<label for="searchCity">Байршил:</label>
					<select id="searchCity" style="width: 203px; height: 30px; font: normal 15px Arial; border-radius: 10px">
						<option value="" disabled selected>Сонгох</option>
						<option value="Улаанбаатар">Улаанбаатар</option>
						<option value="Архангай">Архангай</option>
						<option value="Баян-Өлгий">Баян-Өлгий</option>
						<option value="Баянхонгор">Баянхонгор</option>
						<option value="Булган">Булган</option>
						<option value="Говь-Алтай">Говь-Алтай</option>
						<option value="Говьсүмбэр">Говьсүмбэр</option>
						<option value="Дархан-Уул">Дархан-Уул</option>
						<option value="Дорноговь">Дорноговь</option>
						<option value="Дорнод">Дорнод</option>
						<option value="Дундговь">Дундговь</option>
						<option value="Завхан">Завхан</option>
						<option value="Орхон">Орхон</option>
						<option value="Өвөрхангай">Өвөрхангай</option>
						<option value="Өмнөговь">Өмнөговь</option>
						<option value="Сүхбаатар">Сүхбаатар</option>
						<option value="Сэлэнгэ">Сэлэнгэ</option>
						<option value="Төв">Төв</option>
						<option value="Увс">Увс</option>
						<option value="Ховд">Ховд</option>
						<option value="Хөвсгөл">Хөвсгөл</option>
						<option value="Хэнтий">Хэнтий</option>
					</select>
				</div>
<!--
				<div style="margin: 10px">
					<label for="searchRate">Эрэлт:</label>
					<select id="searchRate" style="width: 120px; height: 30px; font: normal 15px Arial; border-radius: 10px">
						<option value="" disabled selected>Сонгох</option>
						<option value="0">Их</option>
						<option value="1">Бага</option>
					</select>
				</div>
-->
				<div style="display: flex; margin-top: 10px; justify-content: center">
					<button onClick="javascript:document.getElementsByClassName('popup search')[0].style.display='none'; javascript:document.body.style.overflowY='auto'; fetchItems()" class="button_yellow">За</button>
					<button onClick="clearSearch()" class="button_yellow" style="margin-left: 10px; background:rgb(240,85,87)">Арилгах</button>
				</div>
			</div>
		</div>
		
		<div class="popup item_publish_option" style="display: none">
			<div class="container" style="width: 320px; top: 5vh">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup item_publish_option')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Нийтлэх нөхцөл</div>
				<div id="category" class="category"><i class="fas fa-angle-right"></i></div>
				<div id="title" class="title"></div>
				
				<div class="options">
					<div class="selection">
						<div style="font: bold 16px Arial"><input type="radio" id="publish_option" name="publish_option" value="2"> VIP</div>
						<div style="margin-left: 25px">
							<?php
							$price_vip = $item_publish_price_vip." ₮";
							if(isset($rowPopupUser)){
								switch($rowPopupUser["role"]){
									case 4:
										$price_vip = "Үнэгүй";
										break;
									case 3:
										if($rowPopupUser["item_publish_option"]["total"]<$item_vipspecial_count_limit_admin){
											$price_vip = "Үнэгүй";	
										}
										break;
								}
							}
							echo $price_vip;
							?>
						</div>
						<ul style="font-size: 14px">
							<li>Facebook ads хийх хүсэлт</li>
							<li>Онцгой заруудын дээр</li>
							<li>10 хоног нийтлэгдэнэ</li>
						</ul>
					</div>
					<div class="selection">
						<div style="font: bold 16px Arial"><input type="radio" id="publish_option" name="publish_option" value="1"> Онцгой</div>
						<div style="margin-left: 25px">
							<?php
							$price_vip = $item_publish_price_special." ₮";
							if(isset($rowPopupUser)){
								switch($rowPopupUser["role"]){
									case 4:
										$price_vip = "Үнэгүй";
										break;
									case 3:
										if($rowPopupUser["item_publish_option"]["total"]<$item_vipspecial_count_limit_admin){
											$price_vip = "Үнэгүй";	
										}
										break;
								}
							}
							echo $price_vip;
							?>
						</div>
						<ul style="font-size: 14px">
							<li>Энгийн заруудын дээр</li>
							<li>20 хоног нийтлэгдэнэ</li>
						</ul>
					</div>
					<div class="selection">
						<div style="font: bold 16px Arial"><input type="radio" id="publish_option" name="publish_option" value="0"> Энгийн</div>
						<div style="margin-left: 25px">Үнэгүй</div>
						<ul style="font-size: 14px">
							<li>30 хоног нийтлэгдэнэ</li>
							<li>Онцгой заруудын доор байрлана</li>
							<li>Бусад зараас тодорч харагдахгүй</li>
						</ul>
					</div>
				</div>
				<button onClick="publishItemSubmit(<?php echo isset($rowPopupUser)?$rowPopupUser["role"]:0; ?>)" id="buttonPublish" class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto" disabled>Нийтлэх</button>
			</div>
		</div>
		
		<div class="popup profile_qrcrop" style="display: none">
			<div class="container" style="width: 320px; top: 5vh">
				<img id="cropbox" class="cropbox img" src="<?php echo $urlDepth; ?>cropBackground.png" style="width: 320px; height: 320px; object-fit: contain">
				<button id="crop" class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto" disabled>Тайрах</button>
			</div>
		</div>
		
		<div class="popup myzar_item_survey" style="display: none">
			<div class="container" style="width: 320px; top: 5vh">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup myzar_item_survey')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Хэрэглэгчийн туршлага</div>
				<div style="margin: 5px">
					<div id="type" style="margin-bottom: 5px; font-family: RobotoBold; font-size: 18px"></div>
					<div id="title" style="font-size: 16px; color: #888"></div>
					<hr/>
					<div style="text-align: justify; text-justify: inter-word">Зараа архивлах болон устгах болсон шалтгаанаа бичнэ үү. Ингэснээр <?php echo $domain; ?> сайтыг улам сайжруулахад бидэнд туслана.</div>
					<div style="margin-top: 10px">
						<label for="myzar_item_survey_option1" style="cursor: pointer; display: block">
							<input type="radio" id="myzar_item_survey_option1" name="myzar_item_survey_option" value="<?php echo $domain; ?> сайтаар зарсан">
							<?php echo strtoupper($domain); ?> сайтаар зарсан
						</label>
						<label for="myzar_item_survey_option2" style="cursor: pointer; display: block; margin-top: 10px">
							<input type="radio" id="myzar_item_survey_option2" name="myzar_item_survey_option" value="Бусад аргаар зарсан">
							Бусад аргаар зарсан
						</label>
						<label for="myzar_item_survey_option3" style="cursor: pointer; display: block; margin-top: 10px">
							<input type="radio" id="myzar_item_survey_option3" name="myzar_item_survey_option" value="Зарахаа больсон">
							Зарахаа больсон
						</label>
						<label for="myzar_item_survey_option4" style="cursor: pointer; display: block; margin-top: 10px">
							<input type="radio" id="myzar_item_survey_option4" name="myzar_item_survey_option" value="0">
							Бусад шалтгаанаар
						</label>
						<textarea id="myzar_item_survey_reason" name="myzar_item_survey_reason" disabled style="width: 98%; height: 100px; margin-top: 10px"></textarea>
					</div>
				</div>
				<button id="buttonSubmit" disabled class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">Батлах</button>
			</div>
		</div>
		
		<div class="popup become_follower" style="display: none">
			<div class="container">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup become_follower')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Дагагч болох</div>
				<div class="message">
					Таньд <?php echo $domain; ?>-ыг санал болгосон хүний <small>(<?php echo $role_rank_superadmin.", ".$role_rank_admin.", ".$role_rank_manager; ?>)</small> утасны дугаарыг доор оруулна уу.<br/>
					Илүү дэлгэрэнгүйг <a href="javascript:become_follower('myzar&myzar=profile')">эндээс</a>
					<div style="margin-top: 5px; margin-bottom: 5px">
						<label>+976</label>
						<input id="phone" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" pattern="\d*" maxlength="8" placeholder="Заавал биш" style="width: 140px; height: 25px; border-radius: 10px; font: normal 16px Arial; margin-top: 5px" />
						<div id="error" style="font-size: 14px; color: red; margin-top: 2px; display: none">Утасны дугаар буруу байна!</div>
					</div>
				</div>
				<div class="action">
					<button onClick="become_follower(true)" id="yes" class="button_yellow" style="background:#42c200" disabled>
						<i class="fa-solid fa-check"></i>Тийм
					</button>
					<button onClick="become_follower(false)" id="no" class="button_yellow">
						<i class="fa-solid fa-xmark"></i>Алгасах
					</button>
				</div>
			</div>
		</div>
		
		<div class="popup verify_email" style="display: none">
			<div class="container">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup verify_email')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Имэйлээ баталгаажуулах</div>
				<div class="message">
					<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i> Та имэйлээ бичиж мэдэгдэл хүлээж авхыг зөвшөөрнө үү, ингэснээр цаг алдалгүй таньд ирэх <b>гүйлгээ</b>, <b>хүсэлтүүд</b>, <b>баталгаажуулалт</b> зэрэг чухал мэдээллийн мэдэгдэл хүлээн авах боломжтой болно.<br/>
					Илүү дэлгэрэнгүйг <a href="javascript:pagenavigation('myzar&myzar=profile')">эндээс</a>
					<div style="margin-top: 5px; margin-bottom: 5px">
						<label>Имэйл:</label>
						<input id="email" type="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" style="width: 160px; height: 25px; border-radius: 10px; font: normal 16px Arial; margin-top: 5px" />
						<div id="error" style="font-size: 14px; color: red; margin-top: 2px; display: none">Имэйл буруу байна!</div>
					</div>
				</div>
				<div class="action">
					<button onClick="verify_email(true)" id="yes" class="button_yellow" style="background:#42c200" disabled>
						<i class="fa-solid fa-check"></i>Тийм
					</button>
					<button onClick="verify_email(false)" id="no" class="button_yellow">
						<i class="fa-solid fa-xmark"></i>Алгасах
					</button>
				</div>
			</div>
		</div>
		
		<div class="bottomsheet share" style="display: none">
			<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('bottomsheet share')[0].style.display='none'"></i>
			<div class="title">Таны зарыг шууд холбоосоор үзэх боломжтой боллоо.</div>
			<div class="url">
				<input id="shareUrl" type="url" onclick="this.focus();this.select()" readonly="readonly"/>
				<div onClick="copyToClipboard()" class="button_yellow" style="margin-left: 5px">
					<i class="fa-solid fa-copy" style="float:left"></i>
					<div class="removable" style="margin-left: 5px">Хуулах</div>
				</div>
			</div>
			<div class="info" style="display:none">Хуулагдсан</div>
		</div>
	</body>
</html>