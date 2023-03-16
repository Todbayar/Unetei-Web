<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Unetei</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-app-compat.js"></script>
		<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-auth-compat.js"></script>
		<script src="jquery-3.6.4.min.js"></script>
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
				font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";;
			}
		</style>
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
				firebase.auth().onAuthStateChanged(function(user) {
					if (user) {						
						var uid = user.uid;
						var email = user.email;
						var photoURL = user.photoURL;
						var phoneNumber = user.phoneNumber;
						var isAnonymous = user.isAnonymous;
						var displayName = user.displayName;
						var providerData = user.providerData;
						var emailVerified = user.emailVerified;

						$("#myzar_phone").text(phoneNumber);
						$("#myzar_nav").attr("onclick","pagenavigation('myzar')");
					}
				});
												   
				$(".myzar").hover(function(){
					$(".dropdown").show();
				}, function(){
					$(".dropdown").hide();
				});
			});
		</script>
	</head>

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
				}
			}
			else {
				include "home.php";
			}
			?>
			</div>
		</div>
	</body>
</html>