<style>
	.popup {
		background:#E8E8E8;
		position:relative;
		border-radius: 10px;
		padding-bottom: 10px;
		top: 50px;
		box-shadow: 5px 5px 5px lightblue;
	}
	
	.popup .header {
		border-top-left-radius: 10px;
		border-top-right-radius: 10px;
		background: #42c200;
		text-align: center;
		height: 30px;
		position:relative;
		
	}
</style>

<script>
	function myzar_category_add_show(){
		
	}
</script>

<div class="myzar_content_category" style="background: #F14346; max-width: 930px">
	<div onClick="myzar_category_add_show()" class="button_yellow" style="float: left; margin:10px">
		<i class="fa-solid fa-plus"></i>
		<div style="margin-left: 5px">Нэмэх</div>
	</div>
	<div onClick="myzar_category_add_show()" class="button_yellow" style="float: left; margin:10px; background: #C4F1FF">
		<img src="tugrug.png" width="18px" height="18px" />
		<div style="margin-left: 5px">Нэмэх</div>
		<i class="fa-solid fa-circle-minus" style="color:#FF4649; margin-left: 10px; font-size: 20px"></i>
	</div>
</div>

<div class="popup" style="margin: auto; width: 240px">
	<div class="header">Ангилал</div>
	<div style="display: flex; align-items: center; margin: 10px; height: 50px">
		<img src="image-solid.svg" width="24" height="24" />
		<input type="text" maxlength="20" placeholder="Бичих..." style="margin-left: 5px" />
	</div>
	<button class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">Илгээх</button>
</div>