<?php
include "mysql_config.php"; 
include_once "info.php";
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
	max-height: 145px;
	overflow-y: auto;
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

<script src="misc.js"></script>

<script>
var categoryTableID, categoryParentID, selectedCategories;
var searchType = -1;
var searchUserID = -1;
var searchPage = 0;
var searchPageRangeCount = 2;
var searchPageLast = 0;

$(document).ready(function() {		
	if(sessionStorage.getItem("searchUserID")!=null){
		searchUserID = sessionStorage.getItem("searchUserID");
		sessionStorage.removeItem("searchUserID");
	}
	
	selectedCategories = [];
	recursiveFetchCategory(1, 0);
	fetchItems();

	$("#searchSubmit").click(fetchItems);
	
	$("#moreVip").click(function(){
		searchType = 2;
		searchPage = 0;
		fetchItems();
	});
	
	$("#moreSpecial").click(function(){
		searchType = 1;
		searchPage = 0;
		fetchItems();
	});
	
	$("#moreRegular").click(function(){
		searchType = 0;
		searchPage = 0;
		fetchItems();
	});
	
	$("#searchInput").keyup(function(){
		searchPage = 0;
		fetchItems();
	});
	
	$("#searchQuality").change(function(){
		searchPage = 0;
//		console.log("<searchQuality>:"+searchPage);
	});
	
	$("#searchPriceLimitLowest").change(function(){
		searchPage = 0;
//		console.log("<searchPriceLimitLowest>:"+searchPage);
	});
	
	$("#searchPriceLimitHighest").change(function(){
		searchPage = 0;
//		console.log("<searchPriceLimitHighest>:"+searchPage);
	});
	
	$("#searchCity").change(function(){
		searchPage = 0;
//		console.log("<searchCity>:"+searchPage);
	});
	
	$("#pagePrev").click(function(){
		if(searchPage>0){
			searchPage--;
			fetchItems();
		}
	});
	
	$("#pageNext").click(function(){
		if(searchPage<searchPageLast){
			searchPage++;
			fetchItems();
		}
	});
});
	
function recursiveFetchCategory(tableID, parentID, title, icon){
	//removes hierarchical depth after current selected category
	if(tableID < categoryTableID){
		for(let i=tableID; i<=4; i++){
			selectedCategories.splice(tableID-1, 1);
			if($("#selectedCategory" + i).length) $("#selectedCategory" + i).remove();
		}
		searchPage = 0;
		fetchItems();
	}
	
	//showing selected categories
	if(tableID > 1 && tableID > categoryTableID){
		const selectedCategory = {tableID:categoryTableID, id:parentID, title:title, icon:icon};
		selectedCategories[tableID-2] = selectedCategory;
		var html = "<div id=\"selectedCategory"+categoryTableID+"\"";
		html += " onClick=\"recursiveFetchCategory("+categoryTableID+","+categoryParentID+")\"";
		html += " class=\"button_yellow\" style=\"float:left; margin:5px; height:18px; background: #ddf0ff\">";
		if(icon != "null") html += "<img src=\"./<?php echo $path; ?>/"+icon+"\" width=\"32px\" height=\"32px\">";
		html += "<div style=\"margin-left: 5px\">"+title+"</div><i class=\"fa-solid fa-xmark\" style=\"margin-left: 5px; color:#adcfea\"></i></div>";
		$(".searchCategoryListSelected").append(html);
		searchPage = 0;
		fetchItems();
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
				   	if(objCategoryList[i].icon != null){
//						var img = new Image();
//						img.progressload("./<?php echo $path; ?>/"+objCategoryList[i].icon, function (percent) {
////							console.log("<download>:"+objCategoryList[i].icon+" ("+Math.round(percent)+"/100%)")
//						}, function (image) {
//							$("#categoryImage"+objCategoryList[i].id).attr("src", image);
//						});
//						html += "<img id=\"categoryImage"+objCategoryList[i].id+"\" src=\"Loading.gif\" width=\"32px\" height=\"32px\">";
						html += "<img id=\"categoryImage"+objCategoryList[i].id+"\" src=\"<?php echo $path."/"; ?>"+objCategoryList[i].icon+"\" width=\"32px\" height=\"32px\">";
					}
				   	html += "<div style=\"margin-left: 5px\">"+objCategoryList[i].title+"</div></div>";
				   	$(".searchCategoryListAvailable").append(html);
			   	}
		   	}
	   	}
	}
	reqMyZarCategoryListData.open("POST", "mysql_myzar_category_list_process.php", true);
	reqMyZarCategoryListData.send(myZarCategoryListData);
}

Image.prototype.progressload = function (image_url, progress_callback, done_callback) {
	var this_img, xhr = new XMLHttpRequest();

	xhr.open("get", image_url, true);
	xhr.responseType = "arraybuffer";

	xhr.onload = function () {

		var blob = new Blob([this.response]);
		this_img = URL.createObjectURL(blob);

		if (typeof done_callback == "function") {
			done_callback(this_img);
		}
		setTimeout(function () { URL.revokeObjectURL(this_img); }, 5000); // NOTE: this frees the resource after it has presumably been used
	};

	xhr.onprogress = function (ev) {
		if (ev.lengthComputable && typeof progress_callback == "function") {
			progress_callback((ev.loaded / ev.total) * 100);
		}
	};

	xhr.onloadstart = function () {
		if (typeof progress_callback == "function") {
			progress_callback(0);
		}
	};

	xhr.onloadend = function () {
		if (typeof progress_callback == "function") {
			progress_callback(100);
		}
	}

	xhr.send();
};
	
function showSearch(){
	$("body").css("overflow-y", "hidden");
	window.scrollTo(0, 0);
	$(".popup.search").show();
}

function pageAt(offset){
	searchPage = offset;
	fetchItems();
}

function fetchItems(){
	$("#listVip").empty();
	$("#listSpecial").empty();
	$("#listRegular").empty();
	
	$("#typeVip").hide();
	$("#typeSpecial").hide();
	$("#typeRegular").hide();
	
	const vCategory = typeof selectedCategories !== "undefined" && selectedCategories.length > 0 ? "'c"+selectedCategories[selectedCategories.length-1].tableID+"_"+selectedCategories[selectedCategories.length-1].id+"'" : "";	
	
	$.post("mysql_item_list_process.php", {userID:searchUserID, type:searchType, page:searchPage, category:vCategory, search:$("#searchInput").val(), quality:$("#searchQuality option:selected").val(), order:$("#searchOrder option:selected").val(), priceLowest:$("#searchPriceLimitLowest option:selected").val(), priceHighest:$("#searchPriceLimitHighest option:selected").val(), city:$("#searchCity option:selected").val()}).done(function(responseText){
//		console.log("<mysql_item_list_process>:"+responseText);
		const vObj = JSON.parse(responseText);
//		console.log("<mysql_item_list_process1>:"+vObj.query);
//		$("#searchInput").prop("placeholder",vObj.page.countItems+" зар байна");
		searchPageLast = vObj.page.countPages-1;
		
		if(searchPage==0){
			$("#pagePrev").hide();
		}
		else {
			$("#pagePrev").show();
		}
		
		if(searchPage==searchPageLast){
			$("#pageNext").hide();
		}
		else {
			$("#pageNext").show();
		}
		
		if(vObj.page.countPages>1){
			$(".searchPage").show();
			$(".searchPage #pageNumbers").empty();
			for(var offset=0; offset<vObj.page.countPages; offset++){
				const beforeRange = Math.sign(searchPage-searchPageRangeCount)>-1?searchPage-searchPageRangeCount:0;
				const afterRange = (searchPage+searchPageRangeCount)<vObj.page.countPages?searchPage+searchPageRangeCount:vObj.page.countPages;
				if(offset>=beforeRange && offset<=afterRange){
					if(offset==searchPage){
						$(".searchPage #pageNumbers").append("<div onClick=\"pageAt("+offset+")\" class=\"page\" style=\"text-decoration: underline; text-decoration-thickness:3px\">"+(offset+1)+"</div>");
					}
					else {
						$(".searchPage #pageNumbers").append("<div onClick=\"pageAt("+offset+")\" class=\"page\">"+(offset+1)+"</div>");
					}
				}
				else {
					if($(".searchPage #pageNumbers .page.nohover.before").length==0 && offset>=beforeRange){
						$(".searchPage #pageNumbers").append("<div class=\"page nohover before\">&hellip;</div>");
					}
					if($(".searchPage #pageNumbers .page.nohover.after").length==0 && offset<=afterRange){
						$(".searchPage #pageNumbers").append("<div class=\"page nohover after\">&hellip;</div>");
					}
				}
			}
	   	}
		else {
			$(".searchPage").hide();
		}
		
		if(vObj.data != null){
			for(var i=0; i<vObj.data.length; i++){
				var star = "<i id=\"itemStar"+vObj.data[i].id+"\" onClick=\"toggleFavorite(false,"+vObj.data[i].id+")\" class=\"fa-solid fa-star\"></i>";
				if(vObj.data[i].isFavorite==1) var star = "<i id=\"itemStar"+vObj.data[i].id+"\" onClick=\"toggleFavorite(true,"+vObj.data[i].id+")\" class=\"fa-solid fa-star nohover\" style=\"color: rgb(255, 167, 24)\"></i>";
				
				var media = "";
				if(vObj.data[i].image != null){
					if(vObj.data[i].status == 2){
						media = "<div class=\"image\"><div class=\"badge_vip\" data-top=\"VIP\"></div><i class=\"count\"><i class=\"fa-solid fa-camera\"></i> "+vObj.data[i].count_images+"</i>"+star+"<img src=\"<?php echo $path."/"; ?>"+vObj.data[i].image+"\" onerror=\"this.onerror=null; this.src='notfound.png'\" /></div>";
					}
					else if(vObj.data[i].status == 1){
						media = "<div class=\"image\"><div class=\"badge_special\" data-top=\"Онцгой\"></div><i class=\"count\"><i class=\"fa-solid fa-camera\"></i> "+vObj.data[i].count_images+"</i>"+star+"<img src=\"<?php echo $path."/"; ?>"+vObj.data[i].image+"\" onerror=\"this.onerror=null; this.src='notfound.png'\" /></div>";
					}
					else if(vObj.data[i].status == 0){
						media = "<div class=\"image\"><i class=\"count\"><i class=\"fa-solid fa-camera\"></i> "+vObj.data[i].count_images+"</i>"+star+"<img src=\"<?php echo $path."/"; ?>"+vObj.data[i].image+"\" onerror=\"this.onerror=null; this.src='notfound.png'\" /></div>";
					}
				}
				else if(vObj.data[i].youtube != ""){
					if(vObj.data[i].status == 2){
						media = "<div class=\"image\"><div class=\"badge_vip\" data-top=\"VIP\"></div>"+star+"<iframe src=\""+vObj.data[i].youtube+"\" allowfullscreen></iframe></div>";
					}
					else if(vObj.data[i].status == 1){
						media = "<div class=\"image\"><div class=\"badge_special\" data-top=\"Онцгой\"></div>"+star+"<iframe src=\""+vObj.data[i].youtube+"\" allowfullscreen></iframe></div>";
					}
					else if(vObj.data[i].status == 0){
						media = "<div class=\"image\">"+star+"<iframe src=\""+vObj.data[i].youtube+"\" allowfullscreen></iframe></div>";
					}
				}
				else if(vObj.data[i].video != ""){
					if(vObj.data[i].status == 2){
						media = "<div class=\"image\"><div class=\"badge_vip\" data-top=\"VIP\"></div>"+star+"<video controls=\"controls\" preload=\"metadata\"><source src=\"<?php echo $path."/"; ?>"+vObj.data[i].video+"#t=0.5\" type=\""+findTypeOfVideo(vObj.data[i].video)+"\"></video></div>";
					}
					else if(vObj.data[i].status == 1){
						media = "<div class=\"image\"><div class=\"badge_special\" data-top=\"Онцгой\"></div>"+star+"<video controls=\"controls\" preload=\"metadata\"><source src=\"<?php echo $path."/"; ?>"+vObj.data[i].video+"#t=0.5\" type=\""+findTypeOfVideo(vObj.data[i].video)+"\"></video></div>";
					}
					else if(vObj.data[i].status == 0){
						media = "<div class=\"image\">"+star+"<video controls=\"controls\" preload=\"metadata\"><source src=\"<?php echo $path."/"; ?>"+vObj.data[i].video+"#t=0.5\" type=\""+findTypeOfVideo(vObj.data[i].video)+"\"></video></div>";
					}
				}
				else {
					if(vObj.data[i].status == 2){
						media = "<div class=\"image\"><div class=\"badge_vip\" data-top=\"VIP\"></div><i class=\"count\"><i class=\"fa-solid fa-camera\"></i> "+vObj.data[i].count_images+"</i>"+star+"<img src=\"notfound.png\" onerror=\"this.onerror=null; this.src='image-solid.svg'\" /></div>";
					}
					else if(vObj.data[i].status == 1){
						media = "<div class=\"image\"><div class=\"badge_special\" data-top=\"Онцгой\"></div><i class=\"count\"><i class=\"fa-solid fa-camera\"></i> "+vObj.data[i].count_images+"</i>"+star+"<img src=\"notfound.png\" onerror=\"this.onerror=null; this.src='image-solid.svg'\" /></div>";
					}
					else if(vObj.data[i].status == 0){
						media = "<div class=\"image\"><i class=\"count\"><i class=\"fa-solid fa-camera\"></i> "+vObj.data[i].count_images+"</i>"+star+"<img src=\"notfound.png\" onerror=\"this.onerror=null; this.src='image-solid.svg'\" /></div>";
					}
				}
				var html = "<div id=\""+vObj.data[i].id+"\" class=\"item\">"+media+"<div><div class=\"price\">"+(vObj.data[i].price!=0?(convertPriceToTextJS(vObj.data[i].price)+" ₮"):"")+"</div><div class=\"title\">"+vObj.data[i].title+"</div></div></div>";

				if(searchType == -1){
					if(vObj.data[i].status==2){
						$("#typeVip").show();
						$("#listVip").append(html);
					}
					else if(vObj.data[i].status==1){
						$("#typeSpecial").show();
						$("#listSpecial").append(html);
					}
					else if(vObj.data[i].status==0){
						$("#typeRegular").show();
						$("#listRegular").append(html);
					}
				}
				else if(searchType == 2){
					$("#typeVip").show();
					$("#moreVip").hide();
					$("#listVip").append(html);
				}
				else if(searchType == 1){
					$("#typeSpecial").show();
					$("#moreSpecial").hide();
					$("#listSpecial").append(html);
				}
				else if(searchType == 0){
					$("#typeRegular").show();
					$("#moreRegular").hide();
					$("#listRegular").append(html);
				}
			}
			
			$(".searchResult .list .item").click(function(e){
				console.log("<test_click>");
				if(!$(e.target).is(".fa-star")){
					pagenavigation("detail/"+$(this).attr("id"),"slash");
				}
			});
		}
	});
}
</script>

<div class="mid" style="margin-top: 10px; margin-left: 5px;	margin-right: 5px; float: left; width: 100%">
	<div style="display: flex">
		<?php
		$queryCountItems = "SELECT * FROM item WHERE isactive=4";
		$resultCountItems = $conn->query($queryCountItems);
		//mysqli_num_rows($resultCountItems) зар байна
		?>
		<input id="searchInput" class="searchInput" type="text" placeholder="Зар хайх" />
		<div onClick="showSearch()" class="button_yellow" style="margin-left: 10px; background: #42c200">
			<i class="fa-solid fa-circle-chevron-down" style="color: white"></i>
		</div>
		<div id="searchSubmit" class="button_yellow" style="margin-left: 10px; background: #42c200">
			<i class="fa-solid fa-magnifying-glass" style="color: white"></i>
			<div class="removable" style="margin-left: 5px; color: white">Хайх</div>
		</div>
	</div>
	<div class="searchCategoryList">
		<div id="searchCategoryListSelected" class="searchCategoryListSelected"></div>
		<div id="searchCategoryListAvailable" class="searchCategoryListAvailable"></div>
	</div>
	<div class="searchResult">
		<div id="typeVip" class="type" style="display: none">Vip зар 
			<div id="moreVip" class="button_yellow" style="margin-left: 10px; background: #42c200">
				<i class="fa-solid fa-eye" style="color: white"></i>
				<div style="margin-left: 5px; color: white">Бүгд</div>
			</div>
		</div>
		<div id="listVip" class="list">
<!--
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
-->
		</div>
		<div id="typeSpecial" class="type" style="display: none">Онцгой зар
			<div id="moreSpecial" class="button_yellow" style="margin-left: 10px; background: #42c200">
				<i class="fa-solid fa-eye" style="color: white"></i>
				<div style="margin-left: 5px; color: white">Бүгд</div>
			</div>
		</div>
		<div id="listSpecial" class="list">
<!--
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
-->
		</div>
		<div id="typeRegular" class="type" style="display: none">Энгийн зар
			<div id="moreRegular" class="button_yellow" style="margin-left: 10px; background: #42c200">
				<i class="fa-solid fa-eye" style="color: white"></i>
				<div style="margin-left: 5px; color: white">Бүгд</div>
			</div>
		</div>
		<div id="listRegular" class="list">
<!--
			<div class="item">
				<div class="image">
					<i class="count"><i class="fa-solid fa-camera"></i> 3</i>
					<i class="fa-solid fa-star"></i>
					<img src="https://cdn1.unegui.mn/media/cache2/f0/7a/f07a79ef67097299821b90f8d17e82f1.jpg" />
				</div>
				<div class="price">180,000 ₮</div>
				<div class="title">Uniqlo брэндийн үслэг цамц</div>
			</div>
-->
		</div>
	</div>
	<div class="searchPage" style="display: none">
		<div id="pagePrev" class="page">Өмнөх</div>
		<div id="pageNumbers" style="display: flex">
			<div class="page">1</div>
			<div class="page">2</div>
	<!--	<div id="page" class="page">...</div>-->
			<div class="page">15</div>
		</div>
		<div id="pageNext" class="page">Дараах</div>
	</div>
</div>