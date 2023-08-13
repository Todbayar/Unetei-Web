function pagenavigation(page, type){
	var type = typeof type!=="undefined"?type:null;
	console.log("<pagenavigation>:"+page+", type:"+type);
	switch(type){
		case "slash":
			location.href = page;
			break;
		case "id":
			location.href = page;
			break;
		default:
			location.href = "../?page=" + page;
			break;
	}
//	if(Number.isInteger(page)){
//		location.href = page;
//	}
//	else if(page.includes('/')){
//	   	location.href = page;
//   	}
//	else {
//		location.href = "../?page=" + page;
//	}
}

function logout(){
	const reqLogout = new XMLHttpRequest();
	reqLogout.onload = function() {
		firebase.auth().signOut().then(()=>{
			location.href = "./";
		}).catch((error) => {
			console.log("<logout>:",error);
			location.href = "./";
		});
	};
	reqLogout.open("POST", "logout.php", true);
	reqLogout.send();
}

function information(type, icon, message, timer, event){
	$("#information").css("display", "flex");
	
	switch(type){
		case "info":
			$("#information #type").attr("class", "fa-solid fa-circle-info");
			$("#information #type").css("color", "#FFA718");
			break;
		case "success":
			$("#information #type").attr("class", "fa-solid fa-circle-check");
			$("#information #type").css("color", "#58d518");
			break;
	}
	
	if(icon != ""){
		$("#information #icon").attr("class", icon);
		$("#information #icon").show();
	}
	
	$("#information #message").html(message);
	
	if(timer > 0){
		$("#information #timer").html(timer);
		var intervalTimer = setInterval(function() {
			timer = timer - 1;
			$("#information #timer").html("Түр хүлээнэ үү... (" + timer + "сек)");
			if(timer == 1){
				clearInterval(intervalTimer);
				if(event != null) window.dispatchEvent(event);
			}
		}, 1000);
	}
	else {
		if(event != null) window.dispatchEvent(event);
	}
}

function confirmation_yesno(message, eventyes, eventno){
	$("body").css("overflow-y", "hidden");
	window.scrollTo(0, 0);
	$(".popup.yesno").show();
	$(".popup.yesno .container .message").html(message);
	
	$(".popup.yesno .container .action #yes").click(function(){
		$(".popup.yesno").hide();
		$("body").css("overflow-y", "auto");
		if(event != null) window.dispatchEvent(eventyes);
	});
	
	$(".popup.yesno .container .action #no").click(function(){
		$(".popup.yesno").hide();
		$("body").css("overflow-y", "auto");
		if(event != null) window.dispatchEvent(eventno);
	});
}

function confirmation_ok(message, event){
	$("body").css("overflow-y", "hidden");
	window.scrollTo(0, 0);
//	$("html, body").animate({ scrollTop: 0 }, "fast");
	$(".popup.ok").show();
	$(".popup.ok .container .message").html(message);
	$(".popup.ok .container .action .button_yellow").click(function(){
		$(".popup.ok").hide();
		$("body").css("overflow-y", "auto");
		if(event != null) window.dispatchEvent(event);
	});
}

function youtubeUrlEmbed(url){
	if(url !== ""){
		var tmp = url;
		if(url.lastIndexOf('=')>-1){
			tmp = url.substring(url.lastIndexOf('=')+1);
		}
		else {
			tmp = url.substring(url.lastIndexOf('/')+1);
		}
		return "https://www.youtube.com/embed/"+tmp;
	}
	else {
		return url;
	}
}

function getItemDataForm(id = null){
	var vItemTitle = $("#myzar_item_title").val();
	var vItemQuality = $("#myzar_item_quality").val();
	var vItemAddress = $("#myzar_item_address").val();
	var vItemPrice = $("#myzar_item_price").val();
	var vItemYoutube = $("#myzar_item_youtube").val();
	var vItemDescription = $("#myzar_item_description").val();
	var vItemCity = $("#myzar_item_city").val();
	var vItemName = $("#myzar_item_name").val();
	var vItemEmail = $("#myzar_item_email").val();
	var vItemPhone = $("#myzar_item_phone").val();
	var vItemIsNewUser = $("#myzar_item_isNewUser").prop("checked");
	
	var selectedImages = new Array();
	$("#myzar_item_images > div.itemImage").each(function(){
		selectedImages.push({
			id:$(this).attr("id"),
			action:$(this).attr("data-action"),
			name:$(this).children("img").attr("name"),
			sort:$(this).children("img").attr("data-sort"),
		});
	});
	var vItemImagesDatas = JSON.stringify(selectedImages);
	
	console.log(vItemImagesDatas);
	
	var selectedVideos = new Array();
	$("#myzar_item_video > div.itemVideo").each(function(){
		selectedVideos.push({
			action:$(this).attr("data-action"),
			name:$(this).children("video").attr("name"),
		});
	});
	var vItemVideosDatas = JSON.stringify(selectedVideos);
	
	console.log(vItemVideosDatas);
	
	const patternOnlyText = /^[а-яА-Яa-zA-ZөӨүҮ\s]+$/i;
	const patternEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/i;
	const patternYoutube = /^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/i;
	
	//required
	if(vItemTitle === "") $("#myzar_item_title_error").show();
	if(vItemPrice === "") $("#myzar_item_price_error").show();
	if(vItemDescription === "") $("#myzar_item_description_error").show();
	if(vItemCity == null) $("#myzar_item_city_error").show();
	if(vItemName === "" || !patternOnlyText.test(vItemName)) $("#myzar_item_name_error").show();
	if(vItemIsNewUser && vItemPhone=="") $("#myzar_item_phone_error").show();
	
	//no require
	if(vItemEmail !== "" && !patternEmail.test(vItemEmail)) $("#myzar_item_email_error").show();
	if(vItemYoutube !== "" && !patternYoutube.test(vItemYoutube)) $("#myzar_item_youtube_error").show();
	
	if(vItemTitle !== "" && vItemPrice !== "" && vItemDescription !== "" && vItemCity != null && (vItemName !== "" && patternOnlyText.test(vItemName)) && (vItemEmail === "" || patternEmail.test(vItemEmail)) && (vItemYoutube === "" || patternYoutube.test(vItemYoutube)) && ((vItemIsNewUser && vItemPhone!="") || !vItemIsNewUser)){
		var itemSubmitData = new FormData();
		itemSubmitData.append("category", "c" + selectedCategory.length + "_" + selectedCategory[selectedCategory.length-1]);
		itemSubmitData.append("title", vItemTitle);
		itemSubmitData.append("quality", vItemQuality);
		itemSubmitData.append("address", vItemAddress);
		itemSubmitData.append("price", vItemPrice);
		itemSubmitData.append("youtube", youtubeUrlEmbed(vItemYoutube));
		itemSubmitData.append("extras", JSON.stringify(getItemExtrasForm()));
		itemSubmitData.append("description", vItemDescription);
		itemSubmitData.append("city", vItemCity);
		itemSubmitData.append("name", vItemName);
		itemSubmitData.append("email", vItemEmail);
		itemSubmitData.append("phone", "+976"+vItemPhone);
		itemSubmitData.append("isNewUser", vItemIsNewUser);
		
		itemSubmitData.append("imagesDatas", vItemImagesDatas);
		$.each($("#myzar_item_images_input")[0].files, function(i, file) {
			console.log(file.name);
			itemSubmitData.append("imagesFiles[]", file);
		});

		itemSubmitData.append("videosDatas", vItemVideosDatas);
		$.each($("#myzar_item_videos_input")[0].files, function(i, file) {
			console.log(file.name);
			itemSubmitData.append("videosFiles[]", file);
		});
		
		if(id != null) itemSubmitData.append("itemID", id);
		
		return itemSubmitData;
	}
	else {
		return "";
	}
}

function getItemExtrasForm(){
	var tableID = 1;
	var inputArray = [];
	$("#myzar_item_extras table").each(function(){
		const vKey = $("#myzar_item_extra"+tableID).attr("name");
		const vValue = $("#myzar_item_extra"+tableID).val();
		const vObj = {};
		vObj[vKey] = vValue;
		inputArray[tableID-1] = vObj;
		tableID++;
	});
	return inputArray;
}

function getItemExtraDataList(key, category, elID){
	const reqMyZarItemExtraDataListSubmit = new XMLHttpRequest();
	reqMyZarItemExtraDataListSubmit.onload = function() {
		if(this.responseText != ""){
			const vDataList = JSON.parse(this.responseText);
			var vDataListEl = "<datalist id=\""+key+"\">";
			for(var i=0; i<vDataList.length; i++){
				vDataListEl += "<option>"+vDataList[i]+"</option>";
			}
			vDataListEl += "</datalist>";
			$("#myzar_item_extras table:eq('"+elID+"') tr td:nth-child(2)").append(vDataListEl);
		}
	};

	reqMyZarItemExtraDataListSubmit.onerror = function(){
		console.log("<getItemExtraDataList>:" + reqMyZarItemExtraDataListSubmit.status + ", " + reqMyZarItemExtraDataListSubmit.statusText);
	};

	reqMyZarItemExtraDataListSubmit.open("GET", "mysql_myzar_item_extra_datalist_process.php?key="+key+"&category="+category, true);
	reqMyZarItemExtraDataListSubmit.send();
}

function convertRoleInString(role){
	var vRole;
	switch(parseInt(role)){
		case 0:
			vRole = "Энгийн";
			break;
		case 1:
			vRole = "Нийтлэгч";
			break;
		case 2:
			vRole = "Менежер";
			break;
		case 3:
			vRole = "Админ";
			break;
		case 4:
			vRole = "Сүпер админ";
			break;
    }
	return vRole;
}

function findTypeOfVideo(name){
	const type = name.substr(name.lastIndexOf(".")+1);
	if(type == "mp4"){
		return "video/mp4";
   	}
	else if(type == "mov"){
		return "video/quicktime";
	}
}

function convertPriceToTextJS(number){
	var vNumber = parseFloat(number).toLocaleString("en-US").toString().split(",");
	switch(vNumber.length-1){
		case 4:
			return vNumber[0]+(parseInt(vNumber[1].substr(0,1))!=0?("."+vNumber[1].substr(0,1)):"")+" ихнаяд";
		case 3:
			return vNumber[0]+(parseInt(vNumber[1].substr(0,1))!=0?("."+vNumber[1].substr(0,1)):"")+" тэрбум";
		case 2:
			return vNumber[0]+(parseInt(vNumber[1].substr(0,1))!=0?("."+vNumber[1].substr(0,1)):"")+" сая";
		case 1:
			return vNumber[0]+","+vNumber[1];
		case 0:
			return parseFloat(number).toLocaleString("en-US");
	}
}

function toggleFavorite(isFav, id){
	if(!isFav){
		$("#itemStar"+id).addClass("nohover");
		$("#itemStar"+id).css("color", "#FFA718");
		$("#itemStar"+id).attr("onclick", "toggleFavorite(true, "+id+")");
	}
	else {
		$("#itemStar"+id).removeClass("nohover");
		$("#itemStar"+id).css("color", "gray");
		$("#itemStar"+id).attr("onclick", "toggleFavorite(false, "+id+")");
	}
	$.post("mysql_item_toggle_favorite.php", {id:id});
}

function copyToClipboardBankAccountNumber(){
	$(".popup.billing #copyToClipboard").css("color","#FFA718");
	var copyText = document.getElementById("account");
	console.log("<copyToClipboardBankAccountNumber>:"+copyText.text);
	navigator.clipboard.writeText(copyText.text);
}