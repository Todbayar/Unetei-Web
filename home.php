<?php 
include "mysql_config.php"; 
include "info.php";
?>

<meta charset="utf-8">

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
}

.searchResult {
	margin-top: 10px;
	float: left;
	width: 100%;
}
	
.searchResult .type {
	font: bold 20px Arial;
	padding-left: 5px;
	margin-bottom: 5px;
}

.searchResult .list {
	float: left;
	width: 100%;
}

.searchResult .list .item {
/*	max-height: 230px;*/
	float: left;
	margin-left: 5px;
	margin-right: 5px;
	margin-top: 5px;
	margin-bottom: 10px;
	cursor: pointer;
	position: relative;
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

.searchResult .list .item .image {
	width: 100%;
	height: 152px;
	background: #f3f3f3;
	border-radius: 10px;
	position: relative;
}
	
.searchResult .list .item .image img {
	width: 100%;
	height: 100%;
	object-fit: contain;
}

/* For Mobile */
@media screen and (max-width: 540px) {
	.searchResult .list .item {
		width: 165px;
	}
	.searchResult .list .item .image img {
		border-radius: 10px;
	}
}

/* For Tablets and Desktop */
@media screen and (min-width: 540px) {
	.searchResult .list .item {
		width: 190px;	
	}
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
	opacity: 0.73;
	color: gray;
}

.searchResult .list .item .image .fa-star:hover {
	opacity: 0.73;
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
	padding-bottom: 5px;
}

.searchPage {
	float: left;
	width: 100%;
	display: flex;
	margin-bottom: 20px;
	font: bold 18px Arial;
	cursor: pointer;
	justify-content: center;
	color: #0086bf;
}

.searchPage .page {
	margin-left: 10px;
	margin-right: 10px;
}
</style>

<script>
var categoryTableID, categoryParentID, selectedCategories;
	
$(document).ready(function() {
	recursiveFetchCategory(1, 0);
	fetchItems();
	selectedCategories = [];
});
				
function fetchItems(){
	$.post("mysql_item_list_process.php", function(data){
//		console.log("<fetchItems>:" + data);
	});
}
	
function recursiveFetchCategory(tableID, parentID, title, icon){
	//removes hierarchical depth after current selected category
	if(tableID < categoryTableID){
		for(let i=tableID; i<=4; i++){
			selectedCategories.splice(tableID-1, 1);
			if($("#selectedCategory" + i).length) $("#selectedCategory" + i).remove();
		}
	}
	
	//showing selected categories
	if(tableID > 1 && tableID > categoryTableID){
		const selectedCategory = {tableID:categoryTableID, id:parentID, title:title, icon:icon};
		selectedCategories[tableID-2] = selectedCategory;
		console.log("<recursiveFetchCategory>:"+JSON.stringify(selectedCategories)+", " + icon);
		var html = "<div id=\"selectedCategory"+categoryTableID+"\"";
		html += " onClick=\"recursiveFetchCategory("+categoryTableID+","+categoryParentID+")\"";
		html += " class=\"button_yellow\" style=\"float:left; margin:5px; height:18px; background: #ddf0ff\">";
		if(icon != "null") html += "<img src=\"./<?php echo $path; ?>/"+icon+"\" width=\"32px\" height=\"32px\">";
		html += "<div style=\"margin-left: 5px\">"+title+"</div><i class=\"fa-solid fa-xmark\" style=\"margin-left: 5px; color:#adcfea\"></i></div>";
		$(".searchCategoryListSelected").append(html);
	}
	
	//showing all categories recursively
	$(".searchCategoryListAvailable").empty();
	categoryTableID = tableID;
	categoryParentID = parentID;
	var myZarCategoryListData = new FormData();
	myZarCategoryListData.append("tableID", tableID);
	myZarCategoryListData.append("parentID", parentID);
	const reqMyZarCategoryListData = new XMLHttpRequest();
	reqMyZarCategoryListData.onload = function(){
		const objCategoryList = JSON.parse(this.responseText);
		if(objCategoryList.length > 0){
		   	for(let i=0; i<objCategoryList.length; i++){
			   	if(parseInt(objCategoryList[i].active) == 2 && (objCategoryList[i].count_category_children > 0 || objCategoryList[i].count_item_children > 0)){
				   	var html = "<div";
				   	html += " onClick=\"recursiveFetchCategory("+(tableID+1)+","+objCategoryList[i].id+",'"+objCategoryList[i].title+"','"+objCategoryList[i].icon+"')\"";
				   	html += " class=\"button_yellow\" style=\"float:left; margin:5px; height:18px; background: #f3f3f3\">";
				   	if(objCategoryList[i].icon != null) html += "<img src=\"./<?php echo $path; ?>/"+objCategoryList[i].icon+"\" width=\"32px\" height=\"32px\">";
				   	html += "<div style=\"margin-left: 5px\">"+objCategoryList[i].title+"</div></div>";
				   	$(".searchCategoryListAvailable").append(html);
			   	}
		   	}
	   	}
	}
	reqMyZarCategoryListData.open("POST", "mysql_myzar_category_list_process.php", true);
	reqMyZarCategoryListData.send(myZarCategoryListData);
}

function showSearch(){
	window.scrollTo(0, 0);
	$("body").css("overflow-y", "hidden");
	$(".popup.search").show();
}
</script>

<div class="mid" style="margin-top: 10px; margin-left: 5px;	margin-right: 5px; float: left; width: 100%">
	<div style="display: flex">
		<?php
		$queryCountItems = "SELECT * FROM item WHERE isactive=4";
		$resultCountItems = $conn->query($queryCountItems);
		?>
		<input id="searchInput" class="searchInput" type="text" placeholder="<?php echo mysqli_num_rows($resultCountItems); ?> зар байна" />
		<div onClick="showSearch()" class="button_yellow" style="margin-left: 10px; background: #42c200">
			<i class="fa-solid fa-circle-chevron-down" style="color: white"></i>
		</div>
		<div class="button_yellow" style="margin-left: 10px; background: #42c200">
			<i class="fa-solid fa-magnifying-glass" style="color: white"></i>
			<div class="removable" style="margin-left: 5px; color: white">Хайх</div>
		</div>
	</div>
	<div class="searchCategoryList">
		<div id="searchCategoryListSelected" class="searchCategoryListSelected"></div>
		<div id="searchCategoryListAvailable" class="searchCategoryListAvailable"></div>
	</div>
	<div class="searchResult">
		<div class="type">Vip зар</div>
		<div class="list">
			<div class="item">
				<div class="image">
					<div class="badge_vip" data-top="VIP"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
			<div class="item">
				<div class="image">
					<div class="badge_vip" data-top="VIP"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
			<div class="item">
				<div class="image">
					<div class="badge_vip" data-top="VIP"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
			<div class="item">
				<div class="image">
					<div class="badge_vip" data-top="VIP"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
			<div class="item">
				<div class="image">
					<div class="badge_vip" data-top="VIP"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
		</div>
		<div class="type">Онцгой зар</div>
		<div class="list">
			<div class="item">
				<div class="image">
					<div class="badge_special" data-top="Онцгой"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
			<div class="item">
				<div class="image">
					<div class="badge_special" data-top="Онцгой"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
			<div class="item">
				<div class="image">
					<div class="badge_special" data-top="Онцгой"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
			<div class="item">
				<div class="image">
					<div class="badge_special" data-top="Онцгой"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
			<div class="item">
				<div class="image">
					<div class="badge_special" data-top="Онцгой"></div>
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
		</div>
		<div class="type">Энгийн зар</div>
		<div class="list">
			<div class="item">
				<div class="image">
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
		</div>
	</div>
	<div class="searchPage">
		<div class="page">Өмнөх</div>
		<div class="page">1</div>
		<div class="page">2</div>
		<div class="page">...</div>
		<div class="page">15</div>
		<div class="page">Дараах</div>
	</div>
</div>