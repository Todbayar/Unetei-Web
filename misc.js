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
	$(".confirmation.yesno").show();
	$(".confirmation.yesno .popup .message").html(message);
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
	$(".confirmation.ok").show();
	$(".confirmation.ok .popup .message").html(message);
	$(".confirmation.ok .popup .action .button_yellow").click(function(){
		if(event != null) {
			window.dispatchEvent(event);
		}
		else {
			$(".confirmation.ok").hide();
		}
	});
}