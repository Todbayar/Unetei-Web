$(document).ready(function(){
	var urlParams = new URLSearchParams(window.location.search);
	var urlMyzarItemListState = urlParams.get('state');
	if(urlMyzarItemListState != null){
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " img").attr("src", "myzar_tab_list_item_" + urlMyzarItemListState + "_white.png");
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " i").css('color', '#ffffff');
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " div").css('color', '#ffffff');
	}
	else {
//		myzar_list_item_tab("all");
		$(".myzar_tab_list_item_all img").attr("src", "myzar_tab_list_item_all_white.png");
		$(".myzar_tab_list_item_all i").css('color', '#ffffff');
		$(".myzar_tab_list_item_all div").css('color', '#ffffff');
	}
	
	$(".popup.myzar_item_survey input[name=myzar_item_survey_option]").change(function(){
		if(this.value==0){
			$(".popup.myzar_item_survey button#buttonSubmit").prop("disabled",true);
			$(".popup.myzar_item_survey textarea#myzar_item_survey_reason").prop("disabled",false);
			$(".popup.myzar_item_survey textarea#myzar_item_survey_reason").on("change keyup paste", function(){
				if($(this).val()==""){
					$(".popup.myzar_item_survey button#buttonSubmit").prop("disabled",true);
				}
				else {
					$(".popup.myzar_item_survey button#buttonSubmit").prop("disabled",false);
				}
			});
		}
		else {
			$(".popup.myzar_item_survey button#buttonSubmit").prop("disabled",false);
			$(".popup.myzar_item_survey #myzar_item_survey_reason").prop("disabled",true);
		}
	});
});
	
function myzar_list_item_tab(state){
	if(location.href.includes("&state=")){
	   location.href = location.href.substring(0, location.href.lastIndexOf("&state=")) + "&state=" + state;
	}
	else {
		location.href += "&state=" + state;
	}
}

function myzar_category_selected_item_edit(id){
	window.scrollTo(0, 0);
	
	var myZarItemListReqData = new FormData();
	myZarItemListReqData.append("id", id);

	const reqMyZarItemListData = new XMLHttpRequest();
	reqMyZarItemListData.onload = function() {
		console.log("<myzar_category_selected_item_edit>:"+this.responseText);
		const resultItemData = JSON.parse(this.responseText);
		$(".myzar_item_isNewUser_table").hide();
		$("#myzar_item_extras").empty();
		myzar_item_categories(resultItemData.categories, resultItemData.extras);
		
		$("#myzar_item_id").val(resultItemData.id);
		$("#myzar_item_title").val(resultItemData.title);
		$("#myzar_item_quality").val(resultItemData.quality);
		$("#myzar_item_address").val(resultItemData.address);
		$("#myzar_item_price").val(parseFloat(resultItemData.price));
		$("#myzar_item_youtube").val(resultItemData.youtube);
		$("#myzar_item_description").val(resultItemData.description);
		$("#myzar_item_city").val(resultItemData.city);
		$("#myzar_item_name").val(resultItemData.name);
		$("#myzar_item_email").val(resultItemData.email);
		$("#myzar_item_phone").val(resultItemData.phone.substring(4));
		$("#myzar_item_button div").html("Хадгалах");
		$("#myzar_item_button").attr("onClick", "myzar_item_edit_submit("+id+")");
		
		$("#myzar_item_images").empty();
		$("#myzar_item_images").find(".itemImage").each(function(i, el){
			$(el).remove();
		});

		for(let i=0; i<resultItemData.images.length; i++){
			$("#myzar_item_images").append("<div id=\""+resultItemData.images[i].id+"\" class=\"itemImage\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img name=\""+resultItemData.images[i].name+"\" data-sort=\""+resultItemData.images[i].sort+"\" src=\""+resultItemData.path+"/"+resultItemData.images[i].name+"\" style=\"width: 100%; height: 100%; border-radius: 5px; object-fit: cover\" /><i onClick=\"myzar_item_images_remove(this)\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer; font-size:24px\"></i><div>");
		}
		
		//video
		$("#myzar_item_video").empty();
		$("#myzar_item_video").find(".itemVideo").each(function(i, el){
			$(el).remove();
		});
		
		if(resultItemData.video != ""){
			selectedVideoName = resultItemData.video;
			var selectedVideoType = selectedVideoName.substring(selectedVideoName.lastIndexOf('.')+1);
			if(selectedVideoType == "mp4") selectedVideoType = "video/mp4";
			else if(selectedVideoType == "mov") selectedVideoType = "video/quicktime";
			
			$("#videoBrowseButton").hide();
			$("#myzar_item_video").append("<div id=\""+resultItemData.id+"\" class=\"itemVideo\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><video name=\""+selectedVideoName+"\" width=\"100%\" height=\"100%\" controls=\"controls\" preload=\"metadata\" style=\"border-radius: 5px\"><source src=\""+resultItemData.path+"/"+selectedVideoName+"#t=0.5\" type=\""+selectedVideoType+"\"></video><i onClick=\"myzar_item_video_remove(this)\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i><div>");
		}
	};
	reqMyZarItemListData.onerror = function() {
		console.log("<error>:" + reqMyZarItemListData.status);
	};
	reqMyZarItemListData.open("POST", "mysql_myzar_item_list_process.php", true);
	reqMyZarItemListData.send(myZarItemListReqData);
}
	
function myzar_item_edit_submit(id){
	const reqMyZarItemEdit = new XMLHttpRequest();
	reqMyZarItemEdit.onload = function() {
		const itemResponseID = this.responseText;
		console.log("<myzar_item_edit_submit>:"+itemResponseID);
		if(this.responseText == "Fail"){
			alert("Зарыг нэмэх боломжгүй байна!");
		}
		else {
			$(".myzar_content_add_item").hide();

			var eventEditDone = new CustomEvent("itemEditDone");
			window.addEventListener("itemEditDone", function(){
//				location.reload();
				sessionStorage.setItem("startItemToDetail", true);
				pagenavigation("detail/"+itemResponseID,"slash");
			});

			confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Зар амжилттай <b>засагдаж</b>, шалгагдаж байна.", eventEditDone);
		}
	};
	reqMyZarItemEdit.onerror = function(){
		console.log("<error>:" + reqMyZarItemEdit.status);
	};
	reqMyZarItemEdit.open("POST", "mysql_myzar_item_edit_process.php", true);
	
	var myZarItemEditSubmitData = getItemDataForm(id);
	if(myZarItemEditSubmitData !== "") reqMyZarItemEdit.send(myZarItemEditSubmitData);
}
	
function myzar_category_selected_item_action(id, type, title, price){
	$("body").css("overflow-y", "hidden");
	window.scrollTo(0, 0);
	$(".popup.myzar_item_survey").show();
	$(".popup.myzar_item_survey #type").text("Та зараа "+(type=="inactive"?"устгах":"архивлах")+" уу?");
	$(".popup.myzar_item_survey #title").text(title+" ("+convertPriceToTextJS(price)+" ₮)");
	$(".popup.myzar_item_survey button#buttonSubmit").attr("onclick","myzar_category_selected_item_action_submit("+id+",'"+type+"')");
}

function myzar_category_selected_item_action_submit(id, type){
	const surveyOption = $(".popup.myzar_item_survey input[name=myzar_item_survey_option]:checked").val();
	const surveyValue = surveyOption==0?$(".popup.myzar_item_survey textarea#myzar_item_survey_reason").val():surveyOption;
	
	var myZarItemActionData = new FormData();
	myZarItemActionData.append("id", id);
	myZarItemActionData.append("survey", surveyValue);
	
	const reqMyZarItemActionData = new XMLHttpRequest();
	reqMyZarItemActionData.onload = function() {
		console.log("<myzar_category_selected_item_action_submit>:"+this.responseText+", "+surveyValue);
		if(this.responseText == "OK"){
			$("body").css("overflow-y", "auto");
			$(".popup.myzar_item_survey").hide();
			var eventDone = new CustomEvent("itemActionDone");
			window.addEventListener("itemActionDone", function(){
				location.reload();
			});
			
			if(type=="inactive") confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Зар <b>идэвхгүй</b> болж 7 хоногийн дараа устaхыг анхаарна уу.", eventDone);
			else if(type=="archive") confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Зар <b>архивлагдлаа</b>.", eventDone);
		}
		else {
			if(type=="inactive") alert("Зарыг идэвхгүй болгоход алдаа гарлаа!");
			else if(type=="archive") alert("Зарыг архивлахад алдаа гарлаа!");
		}
	};
	
	reqMyZarItemActionData.onerror = function() {
		console.log("<error>:" + reqMyZarItemActionData.status);
	};
	
	if(type=="inactive") reqMyZarItemActionData.open("POST", "mysql_myzar_item_inactive_process.php", true);
	else if(type=="archive") reqMyZarItemActionData.open("POST", "mysql_myzar_item_archive_process.php", true);
	
	reqMyZarItemActionData.send(myZarItemActionData);
}