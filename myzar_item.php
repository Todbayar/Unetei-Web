<script>
	var selectedCategory = [];
	
	$(document).ready(function(){
		if(sessionStorage.getItem("selectedCategoryHier") != null){
			const selectedCategoryHier = JSON.parse(sessionStorage.getItem("selectedCategoryHier"));
			for(let i=0; i<selectedCategoryHier.length; i++){
				console.log("<Selected>:" + i);
				if(selectedCategoryHier[i].icon != ""){
					$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd\"><div style=\"display:flex\"><img src=\"./user_files/"+selectedCategoryHier[i].icon+"\" width=\"20px\" height=\"20px\" style=\"margin-left: 5px\" /><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
				}
				else {
					$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd\"><div style=\"display:flex\"><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
				}
			}
		}
	});
</script>

<div class="myzar_content_add_item">
	<div class="myzar_content_add_item_selected_categories" style="margin-top: 10px; float: left; width: 100%"></div>
	<div class="myzar_content_add_item_container" style="float: left; width: 100%">
		<p style="margin-left: 10px">Зарын гарчиг:
			<input id="myzar_item_title" type="text" maxlength="30" style="margin-left: 10px; width: 300px; height: 25px; padding: 5px; font: bold 16px Arial">
			<p>80 тэмдэгт</p>
		</p>
		<p style="margin-left: 10px">Зарын гарчиг:<input id="myzar_item_title" placeholder="30 тэмдэгт" type="text" maxlength="30"></p>
	</div>
</div>