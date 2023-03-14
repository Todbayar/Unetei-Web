<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Unetei</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="jquery-3.6.4.min.js"></script>
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
				<img src="icon.png" width="50" height="50" />
				<div class="title">Unetei</div>
				<div class="control">
					<div class="myzar" style="display: flex; align-items: center; height: 70px">
						<i class="fa-regular fa-user" style="font-size: 24px; color: #FFFFFF"></i>
						<div id="removable" style="color:#FFFFFF; margin-left: 5px">Миний зарууд</div>
						<div id="removable" style="color: #339500">Нэвтрэх ба бүртгэл</div>
						<i id="removable" class="fas fa-angle-down" style="margin-left: 2px; font-size: 12px; color: #339500; margin-top: 4px; margin-right: 20px"></i>
						<div class="dropdown" style="margin-top: 177px">
							<div class="button_yellow" align="center">Нэвтрэх</div>
							<a>Миний зарууд</a>
							<a>Сайтын тохиргоо</a>
						</div>
					</div>
					<i class="fa-regular fa-star" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px"></i>
					<i class="fa-regular fa-comments" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px"></i>
					<div class="button_yellow" style="margin-left: 10px">
						<i class="fa-solid fa-plus"></i>
						<div id="removable" style="margin-left: 5px">Зар нэмэх</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mid">
			📞ХУД 120 мянгат JETRO супермаркетийн чанх хойно, тагнуулын 25-р байранд 2 өрөө байр худалдана.

📍 Гэрчилгээ бэлэн

📍 Ипотек,орон сууцны зээлэнд оруулж болно.

📍 7 давхарт

📍47,66мкв

📍Зүүн харсан 3 цонхтой

📍120-н автобусны буудлын хажууд

📍 2009 онд ашиглалтанд орсон

📍53-р цэцэрлэг, 52-р сургуультай харъяа

📍Эргэн тойрондоо тоглоомын талбай, зогсоол сайтай

📍Гал тогооны тавилага үлдээж болно

📍Өглөө нар тусдаг цонхтой. Эйр кондишин суурилуулсан.

📍Давхартаа 4 айлтай. Хөршүүд сайтай.

📍24 цагын 2 лифттэй.

📍Цонх халхлах юм байхгүй.

📍Өрх, хороо, цагдаагын хэлтэс автобусны буудал, дэлгүүр, эмийн сан, үсчин гээд бүх юмандаа ойрхон.
		</div>
	</body>
</html>