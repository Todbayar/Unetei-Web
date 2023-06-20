<?php 
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
include_once "mysql_myzar_item_remove_process.php";	//for auto removal of expired item
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Permissions-Policy" content="interest-cohort=()">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title><?php echo $domain_title; ?></title>
		<link rel="icon" type="image/x-icon" href="android-chrome-512x512.png">
		
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-app-compat.js"></script>
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-auth-compat.js"></script>
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-messaging-compat.js"></script>
		<script src="jquery-3.6.4.min.js"></script>
		<script src="jquery-ui.js"></script>
		<script src="kit.fontawesome.com_64e3bec699.js"></script>
		<script src="misc.js"></script>
		
		<link rel="stylesheet" href="main.css">
		<link rel="stylesheet" href="topbar.css">
		<link rel="stylesheet" href="buttons.css">
		<link rel="stylesheet" href="dropdowns.css">
		<link rel="stylesheet" href="animation.css">
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
		
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
		
// 		const messaging = firebase.messaging();
			
		var timerDropDownMenu;
			
		$(document).ready(function(){
//			if('serviceWorker' in navigator){				
//				navigator.serviceWorker.register('firebase-messaging-sw.js');
//			} else {
//				console.log('Service Worker not supported');
//				alert("Service Worker not supported");
//			}
//			
//			Notification.requestPermission().then((permission) => {
//				if (permission === 'granted') {
//					console.log('Notification permission granted.');
//					alert("Notification permission granted.");
//					messaging.getToken({vapidKey: "<?php echo $firebase_public_vapid_key; ?>"}).then((currentToken) => {
//						if (currentToken) {
//							alert("token received.");
//							$.post("mysql_user_fcm.php", {token:currentToken});
//						} 
//						else {
//							alert("<fcm>:permission required");
//							console.log("<fcm>:permission required");
//						}
//					}).catch((err) => {
//						alert("<fcm>:An error occurred while retrieving token."+err);
//						console.log('<fcm>:An error occurred while retrieving token.', err);
//					});
//				}
//			});
			
			<?php
			if(isset($_COOKIE["uid"]) && isset($_COOKIE["phone"])){
				?>
				$("#myzar_phone").text("+"<?php echo $_COOKIE["phone"]; ?>);
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
		});
		
		function clearSearch(){
			$("#searchQuality option").eq(0).prop("selected", true);
			$("#searchOrder option").eq(0).prop("selected", true);
			$("#searchPriceLimitLowest option").eq(0).prop("selected", true);
			$("#searchPriceLimitHighest option").eq(0).prop("selected", true);
			$("#searchCity option").eq(0).prop("selected", true);
			$("#searchRate option").eq(0).prop("selected", true);
		}
		</script>
	</head>
	
	<body>
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
				<img src="icon.png" width="40" height="40" style="object-fit: contain" />
				<div class="left">
					<div class="service" style="color: white">Техникийн тусламж: <?php echo $service_phone; ?></div>
					<div class="contact" style="color: white">Холбоо барих: <?php echo $contact_phone; ?></div>
				</div>
				<div class="center" style="font-size: 14px">
					<div><a href="policy.php" style="text-decoration: none; color: white">Үйлчилгээний нөхцөл</a></div>
					<div><a href="rule.php" style="text-decoration: none; color: white">Зар нийтлэх журам</a></div>
					<div><a href="agreement.php" style="text-decoration: none; color: white">Аюулгүй ажиллагаа</a></div>
				</div>
			</div>
		</div>
		
		<!--here comes popups-->
		<?php
		if(isset($_COOKIE["userID"])) $rowPopupUser = mysqli_fetch_array($conn->query("SELECT * FROM user WHERE id=".$_COOKIE["userID"]));
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
				<div style="display: flex; align-items: center; margin-left: 10px; height: 50px">
					<img id="myzar_category_enter_icon_image" class="icon_button" src="image-solid.svg" width="32" height="32" onClick="myzar_category_enter_icon_button()" style="cursor: pointer" />
					<input id="myzar_category_enter_icon_file" class="icon_file" type="file" required="true" accept="image/png, .svg" style="display: none" />
					<input id="myzar_category_enter_title" type="text" maxlength="128" placeholder="Гарчиг" style="margin-left: 10px; margin-right: 10px; width: 95%; height: 20px; padding: 5px; font: normal 14px Arial; border-radius:10px" />
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
							<input type="radio" id="myzar_category_enter_type" name="myzar_category_enter_type" value="1"><label for="myzar_category_enter_type">Брэнд</label>
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
			<div class="container" style="width: 320px; top: 5vh">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('popup myzar_user_upgrade')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
				<div class="header">Хэрэглэгчийн эрх</div>
				<div style="display:block">
					<div style="font-size: 14px; margin-bottom: 5px; margin-top: 10px; margin-left: 10px; margin-right: 10px"><a id="affiliate"></a><br/><a style="font-size: 12px; color: red">Өөрчлөхийг хүсвэл уг цонхыг хаагаад Миний зар->Тохиргоо-ны "Дагагч болох"-ын доор утасны дугаарыг нь оруулаад дахин энэ цонхыг нээнэ үү.</a></div>
					<div class="selection">
						<div style="font: bold 16px Arial"><input type="radio" id="role" name="role" value="4"> Сүпер админ</div>
						<div style="margin-left: 25px"><?php echo $role_price_superadmin; ?> ₮</div>
						<ul style="font-size: 14px">
							<li>Өөрийн дагагчдаас <i>орлого</i> хүлээн авах</li>
							<li>Хязгааргүй ангилал нэмэх эсвэл брэнд үүсгэх</li>
							<li>Хязгааргүй VIP, Онцгой, Энгийн зар нэмэх</li>
							<li>Удирдах <i>бүрэн эрх</i>, хүсэлтүүдийг хянах</li>
							<li>Бизнесийн хөгжүүлэлтэнд саналаа хэлэх</li>
						</ul>
					</div>
					<div class="selection">
						<div style="font: bold 16px Arial"><input type="radio" id="role" name="role" value="3"> Админ</div>
						<div style="margin-left: 25px"><?php echo $role_price_admin; ?> ₮</div>
						<ul style="font-size: 14px">
							<li>Өөрийн дагагчдаас <i>орлого</i> хүлээн авах</li>
							<li>Хязгааргүй ангилал нэмэх эсвэл брэнд үүсгэх</li>
							<li>Хязгааргүй VIP, Онцгой, Энгийн зар нэмэх</li>
							<li>Удирдах <i>хязгаарлагдмал эрх</i>, хүсэлтүүдийг хянах</li>
						</ul>
					</div>
					<div class="selection">
						<div style="font: bold 16px Arial"><input type="radio" id="role" name="role" value="2"> Менежер</div>
						<div style="margin-left: 25px"><?php echo $role_price_manager; ?> ₮</div>
						<ul style="font-size: 14px">
							<li>Өөрийн дагагчдаас <i>орлого</i> хүлээн авах</li>
							<li>10 ангилал нэмэх</li>
							<li>Хязгааргүй Энгийн зар нэмэх</li>
						</ul>
					</div>
					<div class="selection">
						<div style="font: bold 16px Arial"><input type="radio" id="role" name="role" value="1"> Нийтлэгч</div>
						<div style="margin-left: 25px"><?php echo $role_price_publisher; ?> ₮</div>
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
						Дараах данс руу илгээнэ үү.<br/>
						<a id="name" style="font-size: 16px"><b></b></a>ны данс: <a id="account" style="font-size: 16px"><b></b></a><br/>
						Хүлээн авагч: <a id="owner" style="font-size: 16px"><b></b></a>
					</div>
					<div style="margin-left: 10px; margin-top: 10px">Socialpay-аар төлөх:</div>
					<div id="billing_socialpay" style="font-size: 14px; margin-left: 10px; margin-top: 10px; text-align: center">
						<img style="width: 200px; height: 200px" />
					</div>
					<div style="font-size: 14px">
						<ul>
							<li><a style="text-decoration: underline">Гүйлгээний утга</a> дээр заавал: <b style="color: red">УТАСНЫ ДУГААР</b> оруулна уу.</li>
							<li>Таны захиалсан үйлчилгээ (онцгой зар, зар шинэчлэх, ангилал, хэрэглэгч гэх мэт) мөнгө шилжсэний дараа идэвхжинэ.</li>
							<li>Хэрвээ та заасан төлбөрөөс илүүг шилжүүлбэл хариулт мөнгө тань таны сайтны дансанд орох болно.</li>
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
						<option value="0" selected>Огноогоор шинэ</option>
						<option value="1">Огноогоор хуучин</option>
						<option value="2">Хямд нь эхэндээ</option>
						<option value="3">Үнэтэй нь эхэндээ</option>
					</select>
				</div>
				<div style="margin: 10px">
					<label for="searchPriceLimit">Үнэ:</label>
					<?php
					$rowPriceRange = mysqli_fetch_array($conn->query("SELECT MAX(price) AS max, MIN(price) as min, (MAX(price)-MIN(price))/10 AS step FROM item"));
					?>
					<select id="searchPriceLimitLowest" style="width: 120px; height: 30px; font: normal 15px Arial; border-radius: 10px">
						<option value="0" disabled selected>Доод</option>
						<?php
						if($rowPriceRange["max"]!=null){
							for($price=$rowPriceRange["max"]; $price>=0; $price -= $rowPriceRange["step"]){
								?>
								<option value="<?php echo convertPriceToNumber($price); ?>"><?php echo convertPriceToText($price); ?></option>
								<?php
							}
						}
						?>
					</select>
					<select id="searchPriceLimitHighest" style="width: 120px; height: 30px; font: normal 15px Arial; border-radius: 10px">
						<option value="0" disabled selected>Дээд</option>
						<?php
						if($rowPriceRange["max"]!=null){
							for($price=$rowPriceRange["max"]; $price>=0; $price -= $rowPriceRange["step"]){
								?>
								<option value="<?php echo convertPriceToNumber($price); ?>"><?php echo convertPriceToText($price); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
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
				<div style="margin: 10px">
					<label for="searchRate">Эрэлт:</label>
					<select id="searchRate" style="width: 120px; height: 30px; font: normal 15px Arial; border-radius: 10px">
						<option value="" disabled selected>Сонгох</option>
						<option value="0">Их</option>
						<option value="1">Бага</option>
					</select>
				</div>
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
						<div style="margin-left: 25px"><?php echo isset($rowPopupUser) && $rowPopupUser["role"]>=3 ? "Үнэгүй" : $item_publish_price_vip; ?> ₮</div>
						<ul style="font-size: 14px">
							<li>Facebook ads хийх хүсэлт</li>
							<li>Онцгой заруудын дээр</li>
							<li>10 хоног нийтлэгдэнэ</li>
						</ul>
					</div>
					<div class="selection">
						<div style="font: bold 16px Arial"><input type="radio" id="publish_option" name="publish_option" value="1"> Онцгой</div>
						<div style="margin-left: 25px"><?php echo isset($rowPopupUser) && $rowPopupUser["role"]>=3 ? "Үнэгүй" : $item_publish_price_special; ?> ₮</div>
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
	</body>
</html>