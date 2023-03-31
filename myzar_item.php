<script src="myzar_item_add.js"></script>
<?php include "myzar_item_form.php"; ?>

<div class="myzar_content_list_item_tabs" style="height: 70px; background: #77df42; display:flex; justify-content: space-between">
	<div class="myzar_tab_list_item_all" style="display: flex; align-items: center; margin-left: 20px; cursor: pointer" onClick="myzar_list_item_tab('all')">
		<img src="grid_round.png" width="32px" height="32px" />
		<div class="removable" style="margin-left: 5px">Бүгд</div>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_active" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('active')">
		<img src="checked_list.png" width="34px" height="34px" />
		<div class="removable" style="margin-left: 5px">Нийтлэгдсэн</div>		
	</div>
	<hr/>
	<div class="myzar_tab_configuration" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('review')">
		<img src="review.png" width="30px" height="30px" />
		<div class="removable" style="margin-left: 5px">Шалгагдаж байгаа</div>
	</div>
	<hr/>
	<div class="myzar_tab_configuration" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('dismiss')">
		<i class="fa-solid fa-rotate-left" style="font-size: 24px"></i>
		<div class="removable" style="margin-left: 5px">Буцаагдсан</div>
	</div>
	<hr/>
	<div class="myzar_tab_configuration" style="display: flex; align-items: center; margin-right: 20px; cursor: pointer" onClick="myzar_list_item_tab('inactive')">
		<img src="trash_list.png" width="28px" height="28px" />
		<div class="removable" style="margin-left: 5px">Идэвхгүй</div>
	</div>
</div>