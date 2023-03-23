<?php
include "mysql_config.php";
?>
<script>
	var isMyZarCategoryAddIconValid = false;
	var isMyZarCategoryAddTitleValid = false;
	var myZarCategorySelectedHier = [];
	
	$(document).ready(function(){
		$("#myzar_category_add_icon").change(function(){
			vIconType = $("#myzar_category_add_icon")[0].files[0].type;
			vIconName = $("#myzar_category_add_icon")[0].files[0].name;
			if(vIconType == "image/svg+xml" || vIconType == "image/png"){
				$("#myzar_category_add_msg").text("Файл:" + vIconName);
				document.getElementById("myzar_category_add_icon_image").src = URL.createObjectURL($("#myzar_category_add_icon")[0].files[0]);
				isMyZarCategoryAddIconValid = true;
			}
			else {
				$("#myzar_category_add_icon").val(null);
				$("#myzar_category_add_msg").text('');
				document.getElementById("myzar_category_add_icon_image").src = "image-solid.svg";
				isMyZarCategoryAddIconValid = false;
			}
			myzar_category_add_button_update();
		});
		
		$("#myzar_category_add_icon_title").on('input',function(e){
			var tmpMyZarCategoryAddTitle = $("#myzar_category_add_icon_title").val().trim();
			if(tmpMyZarCategoryAddTitle.length > 0){
				if(tmpMyZarCategoryAddTitle != null){
					isMyZarCategoryAddTitleValid = true;
				}
				else {
					isMyZarCategoryAddTitleValid = false;	
				}
			}
			else {
				isMyZarCategoryAddTitleValid = false;
			}
			myzar_category_add_button_update();
		});
		
		myzar_category_fetch_list(1, null, null);
	});
	
	function myzar_category_add_button_update(){
		document.getElementById('myzar_category_add_submit').disabled = !isMyZarCategoryAddIconValid || !isMyZarCategoryAddTitleValid;
	}
	
	function myzar_category_add_show(){
		$("#myzar_category_add_popup").show();
	}
	
	function myzar_category_add_close(){
		$("#myzar_category_add_popup").hide();
	}
	
	function myzar_category_add_icon_button(){
		$("#myzar_category_add_icon").trigger("click"); 
	}
	
	function myzar_category_add_submit_button(){
		var myZarCategoryAddSubmitData = new FormData();
		myZarCategoryAddSubmitData.append("uid", sessionStorage.getItem("uid"));
		myZarCategoryAddSubmitData.append("hier", myZarCategorySelectedHier);
		myZarCategoryAddSubmitData.append("iconfile", $("#myzar_category_add_icon")[0].files[0]);
		myZarCategoryAddSubmitData.append("title", $("#myzar_category_add_icon_title").val().trim());
		
		console.log("<hier_send>:" + myZarCategorySelectedHier);
		
		const reqMyZarCategoryAddSubmit = new XMLHttpRequest();
		reqMyZarCategoryAddSubmit.onload = function() {
			if(this.responseText.includes("OK")){
				console.log(this.responseText);
			}
			else {
				$("#myzar_category_add_error").text(this.responseText);
			}
		};
		reqMyZarCategoryAddSubmit.onerror = function(){
			$("#myzar_category_add_error").text(reqMyZarCategoryAddSubmit.status);
		};
		reqMyZarCategoryAddSubmit.open("POST", "mysql_myzar_category_add_process.php", true);
		reqMyZarCategoryAddSubmit.send(myZarCategoryAddSubmitData);
	}
	
	function myzar_category_fetch_list(tableID, parentID, pTitle){
		console.log("<myzar_category_fetch_list>:" + tableID + ", " + parentID + ", " + pTitle);
		
		if(tableID > 1){
			myZarCategorySelectedHier[tableID-1] = pTitle;
			$(".myzar_category_container_selected").append("<div id=\"myzar_category_selected_button\" class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #58d518\"><i class=\"fa-solid fa-angle-left\" style=\"color: white\"></i><div style=\"margin-left: 5px; color: white\">"+pTitle+"</div><i id=\"myzar_category_selected_add_item_button\" class=\"fa-solid fa-circle-plus\" style=\"margin-left: 5px; color: white\"></i></div>");
		}
		else if(tableID == 4){
			$("#myzar_category_add_button").hide();
		}
		
		$("#myzar_content_category_list").empty();
		
		myZarCategorySelectedHier[tableID-1] = pTitle;
		
		var myZarCategoryListData = new FormData();
		myZarCategoryListData.append("uid", sessionStorage.getItem("uid"));
		myZarCategoryListData.append("tableID", tableID);
		myZarCategoryListData.append("parentID", parentID);
		
		const reqMyZarCategoryListData = new XMLHttpRequest();
		reqMyZarCategoryListData.onload = function() {
			console.log(this.responseText);
			const objMyZarCategoryList = JSON.parse(this.responseText);
			if(objMyZarCategoryList.length > 0){
				for(let i=0; i<objMyZarCategoryList.length; i++){
					if(tableID < 4){
						if(objMyZarCategoryList[i].uid == sessionStorage.getItem("uid")){
							if(objMyZarCategoryList[i].count_category_children > 0){
								$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"')\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div><i class=\"fa-regular fa-angle-right\" style=\"color:#FF4649; margin-left: 10px; font-size: 20px\"></i></div>");
							}
							else {
								$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"')\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div><i class=\"fa-solid fa-circle-minus\" style=\"color:#FF4649; margin-left: 10px; font-size: 20px\"></i></div>");
							}
						}				
						else {
							if(objMyZarCategoryList[i].count_category_children > 0){
								$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"')\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div><i class=\"fa-regular fa-angle-right\" style=\"color:#FF4649; margin-left: 10px; font-size: 20px\"></i></div>");
							}
							else {
								$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"')\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div></div>");
							}
						}
					}
					else {
						if(objMyZarCategoryList[i].uid == sessionStorage.getItem("uid")){
							$("#myzar_content_category_list").append("<div class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div><i class=\"fa-solid fa-circle-minus\" style=\"color:#FF4649; margin-left: 10px; font-size: 20px\"></i></div>");
						}		
						else {
							$("#myzar_content_category_list").append("<div class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div></div>");
						}
					}
				}
			}
		};
		reqMyZarCategoryListData.onerror = function(){
			console.log("<error>" + reqMyZarCategoryListData.status);
		};
		reqMyZarCategoryListData.open("POST", "mysql_myzar_category_list_process.php", true);
		reqMyZarCategoryListData.send(myZarCategoryListData);
	}
</script>

<div class="myzar_content_category">
	<div class="myzar_category_container_selected" style="float: left; padding-top: 10px; width: 100%;"></div>
	<hr/>
	<div>
		<div id="myzar_category_add_button" onClick="myzar_category_add_show()" class="button_yellow" style="margin-left:10px; margin-bottom: 10px; width: 70px; float: left">
			<i class="fa-solid fa-plus"></i>
			<div style="margin-left: 5px">Нэмэх</div>
		</div>
		<div id="myzar_content_category_list"></div>
	</div>	
</div>

<div id="myzar_category_add_popup" class="popup" style="width: 240px; display: none">
	<i class="fa-solid fa-xmark close" onClick="myzar_category_add_close()"></i>
	<div class="header">Ангилал</div>
	<div style="display: flex; align-items: center; margin-left: 10px; height: 50px">
		<img id="myzar_category_add_icon_image" src="image-solid.svg" width="24" height="24" onClick="myzar_category_add_icon_button()" />
		<input id="myzar_category_add_icon_title" type="text" maxlength="30" placeholder="Бичих..." style="margin-left: 5px" />
	</div>
	<div id="myzar_category_add_msg" class="msg"></div>
	<div id="myzar_category_add_error" class="error"></div>
	<input type="file" name="myzar_category_add_icon" id="myzar_category_add_icon" required="true" accept="image/png, .svg" style="display: none" />
	<button id="myzar_category_add_submit" onClick="myzar_category_add_submit_button()" disabled class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">Илгээх</button>
</div>