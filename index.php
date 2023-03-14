<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Unetei</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="jquery-3.6.4.min.js"></script>
		<script src="misc.js"></script>
		<link rel="stylesheet" href="main.css">
		<link rel="stylesheet" href="topbar.css">
		<link rel="stylesheet" href="buttons.css">
		<link rel="stylesheet" href="dropdowns.css">
		<script src="https://kit.fontawesome.com/64e3bec699.js" crossorigin="anonymous"></script>
		<style>
			body {
				border: 0;
				padding: 0;
				margin: 0;
				font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";;
			}
		</style>
		<script>
			$(document).ready(function(){
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