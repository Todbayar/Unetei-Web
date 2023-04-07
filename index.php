<?php include "info.php"; ?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Unetei</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-app-compat.js"></script>
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-auth-compat.js"></script>
		<script src="jquery-3.6.4.min.js"></script>
		<script src="jquery-ui.js"></script>
		<script src="https://kit.fontawesome.com/64e3bec699.js" crossorigin="anonymous"></script>
		<script src="misc.js"></script>
		
		<link rel="stylesheet" href="main.css">
		<link rel="stylesheet" href="topbar.css">
		<link rel="stylesheet" href="buttons.css">
		<link rel="stylesheet" href="dropdowns.css">

		<style>
			body {
				border: 0;
				padding: 0;
				margin: 0;
				font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";
/*				overflow-y: hidden;*/
			}
		</style>
		
	</head>

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
		
		$(document).ready(function(){
			<?php
			if(isset($_COOKIE["uid"]) && isset($_COOKIE["phone"])){
				?>
				$("#myzar_phone").text("+"<?php echo $_COOKIE["phone"]; ?>);
				$("#myzar_nav").text("Миний зар");
				$("#myzar_nav").attr("onclick","pagenavigation('myzar')");
				$("#logoutButton").css("display", "flex");
				<?php
			}
			?>

			$(".myzar").hover(function(){
				$(".dropdown").show();
			}, function(){
				$(".dropdown").hide();
			});
		});
	</script>
	
	<body>
		<div class="topbar">
			<div class="wrap">
			<?php include "topbar.php"; ?>
			</div>
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
				}
			}
			else {
				include "home.php";
			}
			?>
			</div>
		</div>
		<!--here comes footer-->
		<div class="popup yesno" style="display: none">
			<div class="container">
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('confirmation yesno')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
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
				<i class="fa-solid fa-xmark close" onClick="javascript:document.getElementsByClassName('confirmation ok')[0].style.display='none'; javascript:document.body.style.overflowY='auto'"></i>
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
				<div id="myzar_category_enter_words" style="margin-left: 5px; margin-right: 5px"></div>
				<input id="myzar_category_enter_words_input" class="words" type="text" maxlength="128" placeholder="Үгнүүд (заавал биш)" style="margin-top:5px; margin-left: 10px; margin-right: 10px; width: 90%; height: 20px; padding: 5px; font: normal 14px Arial; border-radius:10px" onkeypress="return myzar_category_enter_words(event)" />
				<div style="margin-top:5px; margin-left: 10px; margin-right: 10px; font-size: 14px">
					<i class="fa-solid fa-circle-info" style="color: #FFA718; margin-right: 5px"></i>Ангилалтай холбоотой үгсийг бичнэ үү. Жишээ нь: Шал, тагт, граж, г.м...
				</div>
				<button id="myzar_category_enter_submit" onClick="myzar_category_enter_submit()" disabled class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">Илгээх</button>
			</div>
		</div>
	</body>
</html>