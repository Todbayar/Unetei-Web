<script src="myzar_item_add.js"></script>
<?php include "myzar_item_form.php"; ?>

<script>
$(document).ready(function(){
	var urlParams = new URLSearchParams(window.location.search);
	var urlMyzarItemListState = urlParams.get('state');
	if(urlMyzarItemListState != null){
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " img").attr("src", "myzar_tab_list_item_" + urlMyzarItemListState + "_white.png");
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " i").css('color', '#ffffff');
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " div").css('color', '#ffffff');
	}
	else {
		myzar_list_item_tab("all");
	}
});
	
function myzar_list_item_tab(state){
	if(!location.href.includes(state)){
		if(location.href.includes("&state=")){
		   location.href = location.href.substring(0, location.href.lastIndexOf("&state=")) + "&state=" + state;
		}
		else {
			location.href += "&state=" + state;
		}
	}
}
</script>

<style>
.myzar_content_list_items {
	float: left;
	width: 100%;
}
	
.myzar_content_list_item .myzar_content_list_item_top {
	padding: 4px;
}
	
.myzar_content_list_item .myzar_content_list_item_top img {
	object-fit: cover; 
	background: #dddddd; 
	border-radius: 5px;
	min-width: 136px;
	min-height: 104px;
}

.myzar_content_list_item .myzar_content_list_item_bottom {
	float:left;
	background: #f3f3f3; 
	width: 100%;
}
	
/* For Mobile */
@media screen and (max-width: 540px) {
	.myzar_content_list_item .myzar_content_list_item_top img {
		width: 136px;
		height: 104px;
	}
}

/* For Tablets and Desktop */
/*@media screen and (min-width: 540px) and (max-width: 780px) {*/
@media screen and (min-width: 540px) {
	.myzar_content_list_item .myzar_content_list_item_top img {
		width: 170px;
		height: 130px;
	}
}
</style>

<div class="myzar_content_list_item_tabs" style="height: 50px; background: #77df42; display:flex; justify-content: space-between">
	<div class="myzar_tab_list_item_all" style="display: flex; align-items: center; margin-left: 20px; cursor: pointer" onClick="myzar_list_item_tab('all')">
		<img src="myzar_tab_list_item_all.png" width="32px" height="32px" />
		<div class="removable" style="margin-left: 5px">Бүгд</div>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_active" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('active')">
		<img src="myzar_tab_list_item_active.png" width="34px" height="34px" />
		<div class="removable" style="margin-left: 5px">Нийтлэгдсэн</div>		
	</div>
	<hr/>
	<div class="myzar_tab_list_item_review" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('review')">
		<img src="myzar_tab_list_item_review.png" width="30px" height="30px" />
		<div class="removable" style="margin-left: 5px">Шалгагдаж байгаа</div>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_archive" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('archive')">
		<i class="fa-solid fa-box-archive" style="font-size: 24px"></i>
		<div class="removable" style="margin-left: 5px">Архивлагдсан</div>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_dismiss" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('dismiss')">
		<i class="fa-solid fa-rotate-left" style="font-size: 24px"></i>
		<div class="removable" style="margin-left: 5px">Буцаагдсан</div>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_inactive" style="display: flex; align-items: center; margin-right: 20px; cursor: pointer" onClick="myzar_list_item_tab('inactive')">
		<img src="myzar_tab_list_item_inactive.png" width="28px" height="28px" />
		<div class="removable" style="margin-left: 5px">Идэвхгүй</div>
	</div>
</div>

<div class="myzar_content_list_items">
	<div class="myzar_content_list_item">
		<table class="myzar_content_list_item_top" style="display: flex">
			<tr>
				<td valign="top" rowspan="2">
					<img src="user_files/20230331024721_20230327_094525.jpg" />
				</td>
				<td valign="top" style="padding-left: 5px">
					<div class="myzar_content_list_item_title" style="font: bold 16px Arial">Dell optiplex 3020 дан процессор (380,000 ₮)</div>
					<div class="myzar_content_list_item_expire" style="font: normal 14px Arial; color: #6ab001">Дуусах огноо: 2023-04-21, 18:00. Шинэчлэхэд 3 өдөр дутуу.</div>
					<div class="myzar_content_list_item_category" style="font: normal 14px Arial; color: #999999">Компьютер сэлбэг хэрэгсэл <i class="fas fa-angle-right" style="font-size: 12px"></i> Суурин компьютер Процессор, сервер</div>
				</td>
			</tr>
			<tr>
				<td style="padding-left: 5px">
					<div class="myzar_content_list_item_more" style="font: normal 13px Arial; color: #666666">Нийтэлсэн: 2023-02-09, <i class="fa-solid fa-hashtag"></i>6931181, Үзсэн : <i class="fa-solid fa-eye"></i> 48 <i class="fa-solid fa-phone"></i> 1</div>
				</td>
			</tr>
			<div class="myzar_content_list_item_detail" style="margin-left: 10px"></div>
		</table>
		<div class="myzar_content_list_item_bottom">
			<div class="button_yellow" style="float: left; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px">Онцгой зар болгох</div>
			</div>
			<div class="button_yellow" style="float: left; background: #a0cf0a; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: white">Шинэчлэх</div>
			</div>
			<div class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: #0086bf">Зараа засах</div>
			</div>
			<div class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: #0086bf">Архивлах</div>
			</div>
			<div class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: #0086bf">Устгах</div>
			</div>
		</div>
	</div>
</div>