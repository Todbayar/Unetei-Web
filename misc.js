function pagenavigation(page){
	location.href = "?page=" + page;
}

function logout(){
	const reqLogout = new XMLHttpRequest();
	reqLogout.onload = function() {
		firebase.auth().signOut();
		location.href = "./";
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
	$(".popup.yesno").show();
	$(".popup.yesno .container .message").html(message);
	if(eventyes != null){
		if(eventyes != null) window.dispatchEvent(eventyes);
	}
	if(eventno != null){
		if(eventno != null) window.dispatchEvent(eventno);
	}
}

function confirmation_ok(message, event){
	window.scrollTo(0, 0);
	$("body").css("overflow-y", "hidden");
//	$("html, body").animate({ scrollTop: 0 }, "fast");
	$(".popup.ok").show();
	$(".popup.ok .container .message").html(message);
	$(".popup.ok .container .action .button_yellow").click(function(){
		if(event != null) {
			window.dispatchEvent(event);
		}
		else {
			$(".confirmation.ok").hide();
		}
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
	var vItemImages = JSON.stringify(selectedImagesNames);
	var vItemYoutube = $("#myzar_item_youtube").val();
	var vItemVideo = selectedVideoName;
	var vItemDescription = $("#myzar_item_description").val();
	var vItemCity = $("#myzar_item_city").val();
	var vItemName = $("#myzar_item_name").val();
	var vItemEmail = $("#myzar_item_email").val();
	var vItemPhone = $("#myzar_item_phone").val();
	
	const patternOnlyText = /^[а-яА-Яa-zA-ZөӨүҮ\s]+$/i;
	const patternEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/i;
	const patternYoutube = /^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/i;
	
	//required
	if(vItemTitle === "") $("#myzar_item_title_error").show();
	if(vItemQuality == null) $("#myzar_item_quality_error").show();
	if(vItemPrice === "") $("#myzar_item_price_error").show();
	if(vItemDescription === "") $("#myzar_item_description_error").show();
	if(vItemCity == null) $("#myzar_item_city_error").show();
	if(vItemName === "" || !patternOnlyText.test(vItemName)) $("#myzar_item_name_error").show();
	
	//no require
	if(vItemEmail !== "" && !patternEmail.test(vItemEmail)) $("#myzar_item_email_error").show();
	if(vItemYoutube !== "" && !patternYoutube.test(vItemYoutube)) $("#myzar_item_youtube_error").show();
	
	if(vItemTitle !== "" && vItemQuality != null && vItemPrice !== "" && vItemDescription !== "" && vItemCity != null && (vItemName !== "" && patternOnlyText.test(vItemName)) && (vItemEmail === "" || patternEmail.test(vItemEmail)) && (vItemYoutube === "" || patternYoutube.test(vItemYoutube))){
		
		var itemSubmitData = new FormData();
		itemSubmitData.append("category", "c" + selectedCategory.length + "_" + selectedCategory[selectedCategory.length-1]);
		itemSubmitData.append("title", vItemTitle);
		itemSubmitData.append("quality", vItemQuality);
		itemSubmitData.append("address", vItemAddress);
		itemSubmitData.append("price", vItemPrice);
		itemSubmitData.append("images", vItemImages);
		itemSubmitData.append("youtube", youtubeUrlEmbed(vItemYoutube));
		itemSubmitData.append("video", vItemVideo);
		itemSubmitData.append("description", vItemDescription);
		itemSubmitData.append("city", vItemCity);
		itemSubmitData.append("name", vItemName);
		itemSubmitData.append("email", vItemEmail);
		itemSubmitData.append("phone", "+976"+vItemPhone);
		
		if(id != null) itemSubmitData.append("itemID", id);
		
		return itemSubmitData;
	}
	else {
		return "";
	}
}