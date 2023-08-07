<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";
?>

<style>
.myzar_followers {
	padding-top: 10px;
	padding-bottom: 10px;
	width: 100%;
	float: left;
}

.myzar_followers .container {
	width: 100%;
	float: left;
	display:block;
}

.myzar_followers .container .followers_list_container {
	margin-left: 5px;
	margin-right: 5px;
}
	
.myzar_followers .container .followers_list_container .followers_list {
	text-align: center;
	margin: 5px;
	cursor: pointer;
	width: 108px;
	display: inline-block;
	vertical-align: top;
	font-size: 14px;
}
	
.myzar_followers .container .followers_list_container .followers_list .image {
	width: 60px;
	height: 60px;
	border-radius: 100%;
}

.myzar_followers .container .followers_list_container .followers_list .button_yellow {
	margin-top: 5px;
	width: 80px; 
	height: 10px; 
	margin-left: auto; 
	margin-right: auto;
}
</style>

<script>
$(document).ready(function() {
	fetchUsersList();
});
	
function startChat(toID, message){
	var chatSubmitData = new FormData();
	chatSubmitData.append("fromID", <?php echo $_COOKIE["userID"]; ?>);
	chatSubmitData.append("toID", toID);
	chatSubmitData.append("type", 0);
	chatSubmitData.append("message", message);
	
	const reqChatSubmit = new XMLHttpRequest();
	reqChatSubmit.onload = function() {
		if(this.responseText=="OK"){
			sessionStorage.setItem("startChatToID", toID);
			pagenavigation("chat");
		}
	};
	reqChatSubmit.onerror = function(){
		console.log("<chat_send>:" + reqChatSubmit.status);
	};

	reqChatSubmit.open("POST", "chat_process.php", true);
	reqChatSubmit.send(chatSubmitData);		
}
	
function showOtherItems(userID){
	sessionStorage.setItem("searchUserID", userID);
	location.href = "./";
}
	
function fetchUsersList(){
	$.post("mysql_myzar_followers_list_process.php").done(function(response){
		const usersObj = JSON.parse(response);
		if(usersObj.followers.direct.length>0){
		   	$(".myzar_followers .container.direct").show();
			$(".myzar_followers .container.direct .followers_list_container.direct").empty();
			usersObj.followers.direct.forEach(function(obj){
				var html = "<div class=\"followers_list\">";
				html += "<img class=\"image\" src=\"<?php echo $path."/"; ?>"+obj.image+"\" onerror=\"this.onerror=null; this.src='user.png'\" />";
				html += "<div class=\"name\">"+(obj.name!=null?obj.name:"")+"</div>";
				html += "<div class=\"role\">"+convertRoleInString(obj.role)+"</div>";
				html += "<div class=\"phone\">"+obj.phone.substr(4)+"</div>";
				html += "<div onclick=\"startChat("+obj.id+",'Сайн байна уу?')\" class=\"button_yellow\"><i class=\"fa-solid fa-comments\"></i><div style=\"margin-left: 5px\">Чатлах</div></div>";
				html += "<div onClick=\"showOtherItems("+obj.id+")\" class=\"button_yellow\"><i class=\"fa-solid fa-cart-shopping\"></i><div style=\"margin-left: 5px\">Зарууд</div></div>";
				html += "</div>";
				$(".myzar_followers .container.direct .followers_list_container.direct").append(html);
			});
	   	}
		if(usersObj.followers.indirect.length>0){
		   	$(".myzar_followers .container.indirect").show();
			$(".myzar_followers .container.indirect .followers_list_container.indirect").empty();
			usersObj.followers.indirect.forEach(function(obj){
				var html = "<div class=\"followers_list\">";
				html += "<img class=\"image\" src=\"<?php echo $path."/"; ?>"+obj.image+"\" onerror=\"this.onerror=null; this.src='user.png'\" />";
				html += "<div class=\"name\">"+(obj.name!=null?obj.name:"")+"</div>";
				html += "<div class=\"role\">"+convertRoleInString(obj.role)+"</div>";
				html += "<div class=\"phone\">"+obj.phone.substr(4)+"</div>";
				html += "<div onclick=\"startChat("+obj.id+",'Сайн байна уу?')\" class=\"button_yellow\"><i class=\"fa-solid fa-comments\"></i><div style=\"margin-left: 5px\">Чатлах</div></div>";
				html += "<div onClick=\"showOtherItems("+obj.id+")\" class=\"button_yellow\"><i class=\"fa-solid fa-cart-shopping\"></i><div style=\"margin-left: 5px\">Зарууд</div></div>";
				html += "</div>";
				$(".myzar_followers .container.indirect .followers_list_container.indirect").append(html);
			});
	   	}
		if(usersObj.users.length>0){
		   	$(".myzar_followers .container.users").show();
			$(".myzar_followers .container.users .followers_list_container.users").empty();
			usersObj.users.forEach(function(obj){
				var html = "<div class=\"followers_list\">";
				html += "<img class=\"image\" src=\"<?php echo $path."/"; ?>"+obj.image+"\" onerror=\"this.onerror=null; this.src='user.png'\" />";
				html += "<div class=\"name\">"+(obj.name!=null?obj.name:"")+"</div>";
				html += "<div class=\"role\">"+convertRoleInString(obj.role)+"</div>";
				html += "<div class=\"phone\">"+obj.phone.substr(4)+"</div>";
				html += "<div onclick=\"startChat("+obj.id+",'Сайн байна уу?')\" class=\"button_yellow\"><i class=\"fa-solid fa-comments\"></i><div style=\"margin-left: 5px\">Чатлах</div></div>";
				html += "<div onClick=\"showOtherItems("+obj.id+")\" class=\"button_yellow\"><i class=\"fa-solid fa-cart-shopping\"></i><div style=\"margin-left: 5px\">Зарууд</div></div>";
				html += "</div>";
				$(".myzar_followers .container.users .followers_list_container.users").append(html);
			});
	   	}
	});
}
</script>

<div class="myzar_followers">
	<div class="container direct" style="display:none">
		<div style="font-family: RobotoBold; margin-left:10px">
			Дагагчид 
			<a style="color: gray; font-family: RobotoRegular; font-size: 14px">(Таны утасны дугаараар дагагч болсон хүмүүс)</a>
		</div>
		<hr/>
		<div class="followers_list_container direct"></div>
	</div>
	<div class="container indirect" style="display:none; margin-top:10px">
		<div style="font-family: RobotoBold; margin-left: 10px">
			Шууд бус дагагчид 
			<a style="color: gray; font-family: RobotoRegular; font-size: 14px">(Дагагч болох утасны дугаар хоосон)</a>
		</div>
		<hr/>
		<div class="followers_list_container indirect"></div>
	</div>
	<div class="container users" style="display:none; margin-top:10px">
		<div style="font-family: RobotoBold; margin-left: 10px">Хэрэглэгчид</div>
		<hr/>
		<div class="followers_list_container users"></div>
	</div>
</div>