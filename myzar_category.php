<?php
include "mysql_config.php";
?>
<script>
	var isMyZarCategoryAddIconValid = false;
	var isMyZarCategoryAddTitleValid = false;
	
	var categoryTableID, categoryParentID, categoryTitle, selectedCategories;
	
	$(document).ready(function(){
//		$("#myzar_category_add_popup").draggable();
		
		$("#myzar_category_add_icon").change(function(){
			const vIconType = $("#myzar_category_add_icon")[0].files[0].type;
			const vIconName = $("#myzar_category_add_icon")[0].files[0].name;
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
		
		myzar_category_fetch_list(1, 0, null);
		
		selectedCategories = [];
		sessionStorage.removeItem("selectedCategoryHier");
	});
	
	function myzar_category_add_button_update(){
//		document.getElementById('myzar_category_add_submit').disabled = !isMyZarCategoryAddIconValid || !isMyZarCategoryAddTitleValid;
		document.getElementById('myzar_category_add_submit').disabled = !isMyZarCategoryAddTitleValid;
		if($("#myzar_category_add_icon_title").val().trim().length == 0){
		   document.getElementById('myzar_category_add_submit').disabled = true;
		}
	}
	
	function myzar_category_add_show(){
		$("#myzar_category_add_msg").text("");
		$("#myzar_category_add_error").text("");
		$("#myzar_category_add_popup").show();
	}
	
	function myzar_category_add_close(){
		$("#myzar_category_add_popup").hide();
	}
	
	function myzar_category_add_icon_button(){
		$("#myzar_category_add_icon").trigger("click");
	}
	
	function myzar_category_selected_add_item(){
		sessionStorage.setItem("selectedCategoryHier", JSON.stringify(selectedCategories));
		myzar_tab("item");
	}
	
	function myzar_category_add_submit_button(){
		var myZarCategoryAddSubmitData = new FormData();
		myZarCategoryAddSubmitData.append("tableID", categoryTableID);
		myZarCategoryAddSubmitData.append("title", $("#myzar_category_add_icon_title").val().trim());
		myZarCategoryAddSubmitData.append("iconfile", $("#myzar_category_add_icon")[0].files[0]);
		myZarCategoryAddSubmitData.append("parentID", categoryParentID);
		
		const reqMyZarCategoryAddSubmit = new XMLHttpRequest();
		reqMyZarCategoryAddSubmit.onload = function() {
			if(this.responseText.includes("OK")){
				myzar_category_fetch_list(categoryTableID, categoryParentID, categoryTitle, true);
				$("#myzar_category_add_msg").text("Ангилал амжилттай нэмэгдлээ");
				$("#myzar_category_add_error").text("");
				$("#myzar_category_add_icon_title").val("");
				$("#myzar_category_add_icon").val(null);
				document.getElementById("myzar_category_add_icon_image").src = "image-solid.svg";
				myzar_category_add_button_update();
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
	
	function myzar_category_remove(tableID, rowID){
		var myZarCategoryRemoveData = new FormData();
		myZarCategoryRemoveData.append("tableID", tableID);
		myZarCategoryRemoveData.append("rowID", rowID);
		
		const reqMyZarCategoryRemove = new XMLHttpRequest();
		reqMyZarCategoryRemove.onload = function() {
			if(this.responseText.includes("OK")){
				myzar_category_fetch_list(categoryTableID, categoryParentID, categoryTitle, true);
			}
			else {
				console.log("<myzar_category_remove>:" + this.responseText);
			}
		};
		reqMyZarCategoryRemove.onerror = function(){
			console.log("<myzar_category_remove>:" + reqMyZarCategoryRemove.status);
		};
		reqMyZarCategoryRemove.open("POST", "mysql_myzar_category_remove_process.php", true);
		reqMyZarCategoryRemove.send(myZarCategoryRemoveData);
	}
	
	function myzar_category_fetch_list(tableID, parentID, title, icon, hasChildren, isNewCategoryEntry){
		if(tableID > 4){
			$("#myzar_category_add_button").hide();
		}
		else if (tableID >= 1 && tableID <= 4) {
			$("#myzar_category_add_button").show();
		}
		
		if(tableID < categoryTableID){
			for(let i=tableID; i<=4; i++){
				selectedCategories.splice(tableID-1, 1);
				if($("#myZarSelectCategory" + i).length) $("#myZarSelectCategory" + i).remove();
			}
		}
		
		if(tableID > 1 && !isNewCategoryEntry && tableID > categoryTableID){
			const selectedCategory = {id:parentID, tableID:tableID, title:title, icon:icon};
			selectedCategories[tableID-2] = selectedCategory;
			
			$("#myZarSelectCategory"+(categoryTableID-1)+" #myzar_category_selected_add_item_button").hide();	//removing item add button from previos selected category
			
			if(icon != ''){
				if(hasChildren){
					$(".myzar_category_container_selected").append("<div id=\"myZarSelectCategory"+(tableID-1)+"\" class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd\"><div onClick=\"myzar_category_fetch_list("+(tableID-1)+", "+categoryParentID+", '"+title+"', false)\" style=\"display:flex\"><i class=\"fa-solid fa-angle-left\" style=\"color:#aeaeae\"></i><img src=\"./user_files/"+icon+"\" width=\"20px\" height=\"20px\" style=\"margin-left: 5px\" /><div style=\"margin-left: 5px\">"+title+"</div></div></div>");
				}
				else {
					$(".myzar_category_container_selected").append("<div id=\"myZarSelectCategory"+(tableID-1)+"\" class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd\"><div onClick=\"myzar_category_fetch_list("+(tableID-1)+", "+categoryParentID+", '"+title+"', false)\" style=\"display:flex\"><i class=\"fa-solid fa-angle-left\" style=\"color:#aeaeae\"></i><img src=\"./user_files/"+icon+"\" width=\"20px\" height=\"20px\" style=\"margin-left: 5px\" /><div style=\"margin-left: 5px\">"+title+"</div></div><i onClick=\"myzar_category_selected_add_item()\" id=\"myzar_category_selected_add_item_button\" class=\"fa-solid fa-circle-plus\" style=\"margin-left: 5px; color:#878787\"></i></div>");
				}
			}
			else {
				if(hasChildren){
					$(".myzar_category_container_selected").append("<div id=\"myZarSelectCategory"+(tableID-1)+"\" class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd\"><div onClick=\"myzar_category_fetch_list("+(tableID-1)+", "+categoryParentID+", '"+title+"', false)\" style=\"display:flex\"><i class=\"fa-solid fa-angle-left\" style=\"color:#aeaeae\"></i><div style=\"margin-left: 5px\">"+title+"</div></div></div>");
				}
				else {
					$(".myzar_category_container_selected").append("<div id=\"myZarSelectCategory"+(tableID-1)+"\" class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd\"><div onClick=\"myzar_category_fetch_list("+(tableID-1)+", "+categoryParentID+", '"+title+"', false)\" style=\"display:flex\"><i class=\"fa-solid fa-angle-left\" style=\"color:#aeaeae\"></i><div style=\"margin-left: 5px\">"+title+"</div></div><i onClick=\"myzar_category_selected_add_item()\" id=\"myzar_category_selected_add_item_button\" class=\"fa-solid fa-circle-plus\" style=\"margin-left: 5px; color:#878787\"></i></div>");
				}
			}
		}
		
		categoryTableID = tableID;
		categoryParentID = parentID;
		categoryTitle = title;
		
		$("#myzar_content_category_list").empty();
		
		var myZarCategoryListData = new FormData();
		myZarCategoryListData.append("tableID", tableID);
		myZarCategoryListData.append("parentID", parentID);
		
		const reqMyZarCategoryListData = new XMLHttpRequest();
		reqMyZarCategoryListData.onload = function() {
			const objMyZarCategoryList = JSON.parse(this.responseText);
			if(objMyZarCategoryList.length > 0){
				for(let i=0; i<objMyZarCategoryList.length; i++){
					if(tableID <= 4){
						if(objMyZarCategoryList[i].userID == <?php echo $_COOKIE["userID"] ?>){
							if(objMyZarCategoryList[i].count_category_children > 0){
								if(objMyZarCategoryList[i].icon != null){
									$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"', '"+objMyZarCategoryList[i].icon+"', true, false)\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF; height:18px\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div><i class=\"fa-solid fa-ellipsis-vertical\" style=\"color:#68ceee; margin-left: 10px; font-size: 20px\"></i></div>");
								}
								else {
									$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"', '', true, false)\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF; height:18px\"><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div><i class=\"fa-solid fa-ellipsis-vertical\" style=\"color:#68ceee; margin-left: 10px; font-size: 20px\"></i></div>");
								}
							}
							else {
								if(objMyZarCategoryList[i].icon != null){
									//Don't forget to count its item adv because of preventing to be deleted
									$("#myzar_content_category_list").append("<div class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF; height:18px\"><div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"', '"+objMyZarCategoryList[i].icon+"', false, false)\" style=\"display:flex\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div></div><i onClick=\"myzar_category_remove("+tableID+","+objMyZarCategoryList[i].id+")\" class=\"fa-solid fa-circle-minus\" style=\"color:#FF4649; margin-left: 10px; font-size: 20px\"></i></div>");
								}
								else {
									$("#myzar_content_category_list").append("<div class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF; height:18px\"><div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"', '', false, false)\" style=\"display:flex\"><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div></div><i onClick=\"myzar_category_remove("+tableID+","+objMyZarCategoryList[i].id+")\" class=\"fa-solid fa-circle-minus\" style=\"color:#FF4649; margin-left: 10px; font-size: 20px\"></i></div>");
								}
							}
						}				
						else {
							if(objMyZarCategoryList[i].count_category_children > 0){
								if(objMyZarCategoryList[i].icon != null){
									$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"', '"+objMyZarCategoryList[i].icon+"', true, false)\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF; height:18px\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div><i class=\"fa-solid fa-ellipsis-vertical\" style=\"color:#68ceee; margin-left: 10px; font-size: 20px\"></i></div>");
								}
								else {
									$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"', '', true, false)\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF; height:18px\"><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div><i class=\"fa-solid fa-ellipsis-vertical\" style=\"color:#68ceee; margin-left: 10px; font-size: 20px\"></i></div>");
								}
							}
							else {
								if(objMyZarCategoryList[i].icon != null){
									$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"', '"+objMyZarCategoryList[i].icon+"', false, false)\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF; height:18px\"><img src=\"./user_files/"+objMyZarCategoryList[i].icon+"\" width=\"20px\" height=\"20px\" /><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div></div>");
								}
								else {
									$("#myzar_content_category_list").append("<div onClick=\"myzar_category_fetch_list("+(tableID+1)+", "+objMyZarCategoryList[i].id+", '"+objMyZarCategoryList[i].title+"', '', false, false)\" class=\"button_yellow\" style=\"float: left; margin-left: 10px; margin-bottom: 10px; background: #C4F1FF; height:18px\"><div style=\"margin-left: 5px\">"+objMyZarCategoryList[i].title+"</div></div>");
								}
							}
						}
					}
				}
			}
		};
		reqMyZarCategoryListData.onerror = function(){
			console.log("<error>:" + reqMyZarCategoryListData.status);
		};
		reqMyZarCategoryListData.open("POST", "mysql_myzar_category_list_process.php", true);
		reqMyZarCategoryListData.send(myZarCategoryListData);
	}
</script>

<div class="myzar_content_category">
	<div id="information" style="margin-top: 10px; margin-left: 10px; display: flex; font-size: 16px; align-content: center"><div class="removable">Мэдээлэл</div><i class="fa-solid fa-circle-info" style="color: #FFA718; margin-left: 5px"></i><div style="margin-left: 5px">:</div><i class="fa-solid fa-circle-plus" style="margin-left: 5px; color: #878787"></i><div style="color: #878787; margin-left: 5px">Ангиллаа сонгож нэмэх тэмдэг дээр даран зараа оруулна уу.</div></div>
	<div class="myzar_category_container_selected" style="float: left; padding-top: 10px; width: 100%;"></div>
	<hr/>
	<div>
		<div id="myzar_category_add_button" onClick="myzar_category_add_show()" class="button_yellow" style="margin-left:10px; margin-bottom: 10px; width: 70px; float: left; height: 18px">
			<i class="fa-solid fa-plus"></i>
			<div style="margin-left: 5px">Нэмэх</div>
		</div>
		<div id="myzar_content_category_list"></div>
	</div>	
</div>

<div id="myzar_category_add_popup" class="popup" style="width: 240px; display: none">
	<i class="fa-solid fa-xmark close" onClick="myzar_category_add_close()"></i>
	<div class="header">Ангилал нэмэх</div>
	<div style="display: flex; align-items: center; margin-left: 10px; height: 50px">
		<img id="myzar_category_add_icon_image" src="image-solid.svg" width="24" height="24" onClick="myzar_category_add_icon_button()" />
		<input id="myzar_category_add_icon_title" type="text" maxlength="30" placeholder="Бичих..." style="margin-left: 5px" />
	</div>
	<div id="myzar_category_add_msg" class="msg"></div>
	<div id="myzar_category_add_error" class="error"></div>
	<input type="file" name="myzar_category_add_icon" id="myzar_category_add_icon" required="true" accept="image/png, .svg" style="display: none" />
	<button id="myzar_category_add_submit" onClick="myzar_category_add_submit_button()" disabled class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">Илгээх</button>
</div>