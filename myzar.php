<script>
$(document).ready(function(){
	var urlParams = new URLSearchParams(window.location.search);
	var urlMyzarTab = urlParams.get('myzar');
	if(urlMyzarTab != null){
		$(".myzar_tab_" + urlMyzarTab + " i").css('color', '#ffffff');
		$(".myzar_tab_" + urlMyzarTab + " div").css('color', '#ffffff');
	}
	else {
		myzar_tab("item");
	}
});

function myzar_tab(name){
	if(location.href.includes("&myzar=")){
	   location.href = location.href.substring(0, location.href.lastIndexOf("&myzar=")) + "&myzar=" + name;
	}
	else {
		location.href += "&myzar=" + name;
	}
}
</script>

<div style="padding-top: 0px; width: 100%">
	<div style="height: 50px; background: #58d518; display:flex;  justify-content: space-between">
		<div class="myzar_tab_item" style="display: flex; align-items: center; margin-left: 20px; cursor: pointer"  onClick="myzar_tab('item')">
			<i class="fa-solid fa-rectangle-ad" style="font-size: 24px"></i>
			<div class="removable" style="margin-left: 5px">Миний зарууд</div>
		</div>
		<hr/>
		<div class="myzar_tab_category" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_tab('category')">
			<i class="fa-solid fa-list-ol" style="font-size: 24px"></i>
			<div class="removable" style="margin-left: 5px">Ангилалууд</div>
		</div>
		<hr/>
		<div class="myzar_tab_configuration" style="display: flex; align-items: center; cursor: pointer">
			<i class="fa-solid fa-gear" style="font-size: 24px"></i>
			<div class="removable" style="margin-left: 5px">Тохиргоо</div>
		</div>
		<hr/>
		<div class="myzar_tab_credit" style="display: flex; align-items: center; margin-right: 20px">
			<div class="removable" style="margin-right: 5px">Таны дансанд:</div>
			<div class="myzar_tab_credit_amount">0 ₮</div>
			<div class="button_yellow" style="margin-left: 5px">
				<i class="fa-solid fa-wallet" style="font-size: 18px"></i>
				<div class="removable" style="margin-left: 5px">Дансаа цэнэглэх</div>
			</div>
		</div>
	</div>
	<?php
	if(isset($_GET["myzar"])){
		switch($_GET["myzar"]){
			case "category":
				include "myzar_category.php";
				break;
			case "item":
				include "myzar_item.php";
				break;
		}
	}
	?>
</div>