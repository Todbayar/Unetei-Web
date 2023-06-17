<style>
.favorite .container .item {
	display: flex;
	border: solid 1px #ccc;
	padding-top: 5px;
	padding-bottom: 5px;
}
	
.favorite .container .item .favorite_right div {
	margin-bottom: 5px;
}
	
.favorite .container .item .image {
	position: relative;
	margin-left: 10px;
	margin-right: 10px;
	float: left;
}
	
.favorite .container .item .image img {
	object-fit: cover; 
	background: #dddddd; 
	border-radius: 5px;
	width: 170px;
	height: 130px;
	min-width: 136px;
	min-height: 104px;
}
	
.favorite .container .item .image div {
	position: absolute;
	right: 3px;
	top: 3px;
	color: white; 
	opacity: 0.73; 
	font-size: 13px;
}
</style>

<div class="favorite">
	<div class="container">
		<div class="item">
			<div class="image">
				<img src="user_files/20230609103856_32bc968f343fe21b451944d0daa8cb38.jpg">
				<div><i class="fa-solid fa-camera"></i> 2</div>
			</div>
			<div class="favorite_right">
				<div class="title" style="font: bold 16px Arial">Солонгос нэхмэл цамц <i id="itemStar" onClick="toggleFavorite(false)" class="fa-solid fa-star"></i></div>
				<div class="price">110 сая</div>
				<div class="description" style="font: normal 14px Arial">БЗД 16-р хороо Апартмент 5 хотхонд 12/1 давхрт үйлчилгээний зориулалттай 50мкв талбай зарна. Бүх төрлийн үйлчилгээ явуулах боломжтой. Цонхны төмөр хаалттай, тусдаа 00 болон цэвэр устай. Гэрчилгээ бэлэн байгаа. Бартерт байр, жижиг машин оролцуулна солино</div>
				<div class="category" style="font: normal 14px Arial; color: #999999">
					Хувцас хэрэглэл <i class="fas fa-angle-right" style="font-size: 12px" aria-hidden="true"></i> Эрэгтэй хувцас <i class="fas fa-angle-right" style="font-size: 12px" aria-hidden="true"></i> Цамц
				</div>
				<div class="address" style="font: normal 14px Arial">УБ — Баянзүрх, 16-р хороолол</div>
				<div class="statistics" style="font: normal 13px Arial; color: #666666">
					Нийтэлсэн: 2023-06-09 04:20:21, <i class="fa-solid fa-hashtag"></i>17, Үзсэн : <i class="fa-solid fa-eye"></i> 11 <i class="fa-solid fa-phone"></i> 0
				</div>
			</div>
		</div>
	</div>
</div>