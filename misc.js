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
			$("#information #timer").html(timer);
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