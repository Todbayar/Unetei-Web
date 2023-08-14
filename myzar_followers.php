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
	width: 108px;
	display: inline-block;
	vertical-align: top;
	font-size: 14px;
}

.myzar_followers .container .followers_list_container .followers_list .user {
	cursor: pointer;
}
	
.myzar_followers .container .followers_list_container .followers_list .user .image {
	width: 60px;
	height: 60px;
	border-radius: 100%;
}
	
.myzar_followers .container .followers_list_container .followers_list .user:hover .text {
	color: blue;
}

.myzar_followers .container .followers_list_container .followers_list .button_yellow {
	margin-top: 5px;
	width: 80px; 
	height: 10px; 
	margin-left: auto; 
	margin-right: auto;
}

.followersPage {
	float: left;
	width: 100%;
	display: flex;
	margin-top: 20px;
	margin-bottom: 20px;
	font: bold 18px Arial;
	cursor: pointer;
	justify-content: center;
	color: #0086bf;
}

.followersPage .page {
	margin-left: 3px;
	margin-right: 3px;
	padding-top: 5px;
	padding-bottom: 5px;
	padding-left: 8px;
	padding-right: 8px;
}
	
.followersPage .page:not(.nohover):hover {
	padding-top: 5px;
	padding-bottom: 5px;
	padding-left: 8px;
	padding-right: 8px;
	background: #ddf0ff;
	border-radius: 100%;
	text-decoration: underline;
	text-decoration-thickness: 3px;
}
	
.myzar_follower_detail {
	width: 100%;
	padding-top: 40px;
	padding-bottom: 40px;
}

.myzar_follower_detail .container {
	margin: 0 auto;
	max-width: 400px;
	padding-left: 10px;
	padding-right: 10px;
}

.myzar_follower_detail .container .divimage {
	text-align: center;
}
	
.myzar_follower_detail .container .divimage img {
	width: 80px;
	height: 80px;
	border-radius: 100%;
	background: #ccc;
	cursor: pointer;
}

.myzar_follower_detail .container .divcontainer {
	margin-top: 10px;
	font: normal 18px Arial;
}
	
.myzar_follower_detail .container .divcontainer input {
	width: 97%;
	height: 25px;
	border-radius: 10px;
	font: normal 16px Arial;
	margin-top: 5px;
}
</style>

<script>
var followersPage = 0;
var followersPageLast = 0;
var followersPageRangeCount = 2;
var lastSelectionFollowerRoleUpgradeOption;

$(document).ready(function() {
	fetchFollowersList();
	
	$("#pagePrev").click(function(){
		if(followersPage>0){
			followersPage--;
			fetchFollowersList();
		}
	});
	
	$("#pageNext").click(function(){
		if(followersPage<followersPageLast){
			followersPage++;
			fetchFollowersList();
		}
	});
	
	$(".popup.myzar_user_upgrade input[name='role']").change(function(){
		lastSelectionFollowerRoleUpgradeOption = $(this);
	});
	
	$(".popup.myzar_user_upgrade .selection").click(function(){
		if($(this).find("input").prop("disabled")==false){
			if(lastSelectionFollowerRoleUpgradeOption != null) lastSelectionFollowerRoleUpgradeOption.find("input").prop("checked", false);
			lastSelectionFollowerRoleUpgradeOption = $(this);
			lastSelectionFollowerRoleUpgradeOption.find("input").prop("checked", true);
			$(".popup.myzar_user_upgrade #buttonSubmit").attr("disabled", false);
		}
	});
});

function pageAt(offset){
	followersPage = offset;
	fetchFollowersList();
}
	
function fetchFollowersList(){
	$(".myzar_followers .container.direct .followers_list_container.direct").empty();
	$(".myzar_followers .container.indirect .followers_list_container.indirect").empty();
	$(".myzar_followers .container.users .followers_list_container.users").empty();
	
	$(".myzar_followers .container.direct").hide();
	$(".myzar_followers .container.indirect").hide();
	$(".myzar_followers .container.users").hide();
	
	$.post("mysql_myzar_followers_list_process.php",{page:followersPage}).done(function(response){
//		console.log("<fetchFollowersList>:"+response);
		if(response!="{}"){
			const usersObj = JSON.parse(response);
			
			followersPageLast = usersObj.page.countPages-1;
			
			if(followersPage==0){
				$("#pagePrev").hide();
			}
			else {
				$("#pagePrev").show();
			}

			if(followersPage==followersPageLast){
				$("#pageNext").hide();
			}
			else {
				$("#pageNext").show();
			}
			
			if(usersObj.page.countPages>0){
				if(usersObj.page.countPages>1) $(".followersPage").show();
				$(".followersPage #pageNumbers").empty();
				for(var offset=0; offset<usersObj.page.countPages; offset++){
					const beforeRange = Math.sign(followersPage-followersPageRangeCount)>-1?followersPage-followersPageRangeCount:0;
					const afterRange = (followersPage+followersPageRangeCount)<usersObj.page.countPages?followersPage+followersPageRangeCount:usersObj.page.countPages;
					if(offset>=beforeRange && offset<=afterRange){
						if(offset==followersPage){
							$(".followersPage #pageNumbers").append("<div onClick=\"pageAt("+offset+")\" class=\"page\" style=\"text-decoration: underline; text-decoration-thickness:3px\">"+(offset+1)+"</div>");
						}
						else {
							$(".followersPage #pageNumbers").append("<div onClick=\"pageAt("+offset+")\" class=\"page\">"+(offset+1)+"</div>");
						}
					}
					else {
						if($(".followersPage #pageNumbers .page.nohover.before").length==0 && offset>=beforeRange){
							$(".searchPage #pageNumbers").append("<div class=\"page nohover before\">&hellip;</div>");
						}
						if($(".followersPage #pageNumbers .page.nohover.after").length==0 && offset<=afterRange){
							$(".followersPage #pageNumbers").append("<div class=\"page nohover after\">&hellip;</div>");
						}
					}
				}
			}
			else {
				$(".followersPage").hide();
			}
			
			if(typeof usersObj.followers.direct !== "undefined" && usersObj.followers.direct.length>0){
				$(".myzar_followers .container.direct").show();
				usersObj.followers.direct.forEach(function(obj){
					var html = "<div class=\"followers_list\">";
					html += "<div class=\"user\" onClick=\"showFollowerDetail("+obj.id+")\">";
					html += "<img class=\"image\" src=\"<?php echo $path."/"; ?>"+obj.image+"\" onerror=\"this.onerror=null; this.src='user.png'\" />";
					html += "<div class=\"name text\">"+(obj.name!=null?obj.name:"")+"</div>";
					html += "<div class=\"role text\">"+convertRoleInString(obj.role)+"</div>";
					var lastLoggedInMethod = "";
					const patternUID = new RegExp("^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$");
					if(patternUID.test(obj.uid)){
						lastLoggedInMethod = "<i class=\"fa-solid fa-phone-volume\" style=\"margin-right:2px\"></i>";
					}
					else if(obj.uid!="" && obj.uid!=null){
						lastLoggedInMethod = "<i class=\"fa-solid fa-comment-sms\" style=\"margin-right:2px\"></i>";
					}
					var lastLoggedInDatetime = "";
					if(obj.lastactive!=null && obj.lastactive!=""){
						lastLoggedInDatetime = obj.lastactive;
					}
					else if(obj.lastlogged!=null && obj.lastlogged!=""){
						lastLoggedInDatetime = obj.lastlogged;
					}
					html += "<div class=\"lastactive text\" style=\"font-size:10px; color:#9F9F9F\">"+lastLoggedInMethod+lastLoggedInDatetime+"</div>";
					html += "</div>";
					html += "<div class=\"button_yellow\"><i class=\"fa-solid fa-phone\"></i><div style=\"margin-left: 5px\">"+obj.phone.substr(4)+"</div></div>";
					html += "<div onclick=\"startChat("+obj.id+",'Сайн байна уу?')\" class=\"button_yellow\"><i class=\"fa-solid fa-comments\"></i><div style=\"margin-left: 5px\">Чатлах</div></div>";
					html += "<div onClick=\"showOtherItems("+obj.id+")\" class=\"button_yellow\"><i class=\"fa-solid fa-cart-shopping\"></i><div style=\"margin-left: 5px\">Зарууд</div></div>";
					html += "</div>";
					$(".myzar_followers .container.direct .followers_list_container.direct").append(html);
				});
			}
			if(typeof usersObj.followers.indirect !== "undefined" && usersObj.followers.indirect.length>0){
				$(".myzar_followers .container.indirect").show();
				usersObj.followers.indirect.forEach(function(obj){
					var showDetailEl = "";
					if(<?php echo getUserRole($_COOKIE["userID"]); ?>>=3){
					   showDetailEl = "onClick=\"showFollowerDetail("+obj.id+")\"";
				   	}
					var html = "<div class=\"followers_list\">";
					html += "<div class=\"user\">";
					html += "<img class=\"image\" src=\"<?php echo $path."/"; ?>"+obj.image+"\" onerror=\"this.onerror=null; this.src='user.png'\" />";
					html += "<div class=\"name\">"+(obj.name!=null?obj.name:"")+"</div>";
					html += "<div class=\"role\">"+convertRoleInString(obj.role)+"</div>";
					var lastLoggedInMethod = "";
					const patternUID = new RegExp("^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$");
					if(patternUID.test(obj.uid)){
						lastLoggedInMethod = "<i class=\"fa-solid fa-phone-volume\" style=\"margin-right:2px\"></i>";
					}
					else if(obj.uid!="" && obj.uid!=null){
						lastLoggedInMethod = "<i class=\"fa-solid fa-comment-sms\" style=\"margin-right:2px\"></i>";
					}
					var lastLoggedInDatetime = "";
					if(obj.lastactive!=null && obj.lastactive!=""){
						lastLoggedInDatetime = obj.lastactive;
					}
					else if(obj.lastlogged!=null && obj.lastlogged!=""){
						lastLoggedInDatetime = obj.lastlogged;
					}
					if(obj.lastactive!=null) html += "<div class=\"lastactive text\" style=\"font-size:10px; color:#9F9F9F\">"+lastLoggedInMethod+lastLoggedInDatetime+"</div>";
					html += "</div>";
					html += "<div class=\"button_yellow\"><i class=\"fa-solid fa-phone\"></i><div style=\"margin-left: 5px\">"+obj.phone.substr(4)+"</div></div>";
					html += "<div onclick=\"startChat("+obj.id+",'Сайн байна уу?')\" class=\"button_yellow\"><i class=\"fa-solid fa-comments\"></i><div style=\"margin-left: 5px\">Чатлах</div></div>";
					html += "<div onClick=\"showOtherItems("+obj.id+")\" class=\"button_yellow\"><i class=\"fa-solid fa-cart-shopping\"></i><div style=\"margin-left: 5px\">Зарууд</div></div>";
					
					html += "</div>";
					
					$(".myzar_followers .container.indirect .followers_list_container.indirect").append(html);
				});
			}
//			if(typeof usersObj.users !== "undefined" && usersObj.users.length>0){
//				$(".myzar_followers .container.users").show();
//				usersObj.users.forEach(function(obj){
//					var html = "<div class=\"followers_list\">";
//					html += "<div class=\"user\" onClick=\"showFollowerDetail("+obj.id+")\">";
//					html += "<img class=\"image\" src=\"<?php echo $path."/"; ?>"+obj.image+"\" onerror=\"this.onerror=null; this.src='user.png'\" />";
//					html += "<div class=\"name text\">"+(obj.name!=null?obj.name:"")+"</div>";
//					html += "<div class=\"role text\">"+convertRoleInString(obj.role)+"</div>";
//					html += "<div class=\"phone text\">"+obj.phone.substr(4)+"</div>";
//					html += "</div>";
//					html += "<div onclick=\"startChat("+obj.id+",'Сайн байна уу?')\" class=\"button_yellow\"><i class=\"fa-solid fa-comments\"></i><div style=\"margin-left: 5px\">Чатлах</div></div>";
//					html += "<div onClick=\"showOtherItems("+obj.id+")\" class=\"button_yellow\"><i class=\"fa-solid fa-cart-shopping\"></i><div style=\"margin-left: 5px\">Зарууд</div></div>";
//					html += "</div>";
//					$(".myzar_followers .container.users .followers_list_container.users").append(html);
//				});
//			}
		}
	});
}

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
	
function showFollowerDetail(userID){
	$(".myzar_followers").hide();
	$(".myzar_follower_detail .container #number").val("");
	$(".myzar_follower_detail .container #image").attr("src","user.png");
	$(".myzar_follower_detail .container #name").val("");
	$(".myzar_follower_detail .container #email").val("");
	$(".myzar_follower_detail .container #city").val("");
	$(".myzar_follower_detail .container #phone").val("");
	$(".myzar_follower_detail .container #role").text("");
	$(".myzar_follower_detail .container #buttonUpgradeFollowerRole i").show();
	$(".myzar_follower_detail .container #affiliate_number").val("");
	$(".myzar_follower_detail .container #bank_name").val("");
	$(".myzar_follower_detail .container #bank_owner").val("");
	$(".myzar_follower_detail .container #bank_account").val("");
	$(".myzar_follower_detail .container #socialpay").attr("src","image-solid.svg");
	
	$.post("mysql_myzar_follower_detail_process.php",{id:userID}).done(function(response){
		const followerObj = JSON.parse(response);
		$(".myzar_follower_detail").show();
		$(".myzar_follower_detail .container #number").val(followerObj.id);
		var followerImage = (followerObj.image!=null && followerObj.image!="")?("<?php echo $path; ?>/"+followerObj.image):"user.png";
		$(".myzar_follower_detail .container #image").attr("src", followerImage);
		$(".myzar_follower_detail .container #name").val(followerObj.name);
		$(".myzar_follower_detail .container #email").val(followerObj.email);
		$(".myzar_follower_detail .container #city").val(followerObj.city);
		$(".myzar_follower_detail .container #phone").val(followerObj.phone.substr(4));
		$(".myzar_follower_detail .container #role").text(convertRoleInString(followerObj.role));
		if(followerObj.affiliate!=null) $(".myzar_follower_detail .container #affiliate_number").val(followerObj.affiliate.substr(4));
		$(".myzar_follower_detail .container #bank_name").val(followerObj.bank_name);
		$(".myzar_follower_detail .container #bank_owner").val(followerObj.bank_owner);
		$(".myzar_follower_detail .container #bank_account").val(followerObj.bank_account);
		var followerQR = (followerObj.socialpay!=null && followerObj.socialpay!="")?("<?php echo $path; ?>/"+followerObj.socialpay):"image-solid.svg";
		$(".myzar_follower_detail .container #socialpay").attr("src",followerQR);
		$(".myzar_follower_detail .container #buttonUpgradeFollowerRole").unbind('click');
		
		if(parseInt(followerObj.role)<4){
			if(<?php echo getUserRole($_COOKIE["userID"]); ?>>parseInt(followerObj.role)){
				$(".myzar_follower_detail .container #buttonUpgradeFollowerRole").css("background-color","#FFA718");
				$(".myzar_follower_detail .container #buttonUpgradeFollowerRole").click(function(){
					$(".popup.myzar_user_upgrade .container .affiliate").hide();
					$(".popup.myzar_user_upgrade .container .price").hide();
					$("body").css("overflow-y", "hidden");
					window.scrollTo(0, 0);
					$(".popup.myzar_user_upgrade").show();
					$(".popup.myzar_user_upgrade .container .selection.superadmin").show();
					$(".popup.myzar_user_upgrade .container .selection.admin").show();
					$(".popup.myzar_user_upgrade .container .selection.manager").show();
					$(".popup.myzar_user_upgrade .container .selection.publisher").hide();
					switch(parseInt(followerObj.role)){
						case 3:
							$(".popup.myzar_user_upgrade .container .selection.admin").hide();
							$(".popup.myzar_user_upgrade .container .selection.manager").hide();
							$(".popup.myzar_user_upgrade .container .selection.publisher").hide();
							break;
						case 2:
							$(".popup.myzar_user_upgrade .container .selection.manager").hide();
							$(".popup.myzar_user_upgrade .container .selection.publisher").hide();
							break;
						case 1:
							$(".popup.myzar_user_upgrade .container .selection.publisher").hide();
							break;
					}
					switch(<?php echo getUserRole($_COOKIE["userID"]); ?>){
						case 3:
							$(".popup.myzar_user_upgrade .container .selection.superadmin #role").prop("disabled",true);
							$(".popup.myzar_user_upgrade .container .selection.superadmin").css("color","#9F9F9F");
							break;
						case 2:
							$(".popup.myzar_user_upgrade .container .selection.superadmin #role").prop("disabled",true);
							$(".popup.myzar_user_upgrade .container .selection.superadmin").css("color","#9F9F9F");
							$(".popup.myzar_user_upgrade .container .selection.admin #role").prop("disabled",true);
							$(".popup.myzar_user_upgrade .container .selection.admin").css("color","#9F9F9F");
							break;
						case 1:
							$(".popup.myzar_user_upgrade .container .selection.superadmin #role").prop("disabled",true);
							$(".popup.myzar_user_upgrade .container .selection.superadmin").css("color","#9F9F9F");
							$(".popup.myzar_user_upgrade .container .selection.admin #role").prop("disabled",true);
							$(".popup.myzar_user_upgrade .container .selection.admin").css("color","#9F9F9F");
							$(".popup.myzar_user_upgrade .container .selection.manager #role").prop("disabled",true);
							$(".popup.myzar_user_upgrade .container .selection.manager").css("color","#9F9F9F");
							break;
					}

					$(".popup.myzar_user_upgrade #buttonSubmit").text("Батлах");
					$(".popup.myzar_user_upgrade #buttonSubmit").attr("onclick", "submitFollowerRoleUpgrade("+followerObj.id+")");
				});
			}
			else {
				$(".myzar_follower_detail .container #buttonUpgradeFollowerRole").css("background-color","#ccc");
				$(".myzar_follower_detail .container #buttonUpgradeFollowerRole").click(function(){
					confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Та энэ үйлдэлийг хийхийн тулд тохиргооруу орж хэрэглэгчийн эрх мэдлээ дээшлүүлнэ үү!", null);
				});
			}
		}
		else {
			$(".myzar_follower_detail .container #buttonUpgradeFollowerRole").css("background-color","#ccc");
			$(".myzar_follower_detail .container #buttonUpgradeFollowerRole i").hide();
		}
	});
}

function backToFollowersList(){
	$(".myzar_followers").show();
	$(".myzar_follower_detail").hide();
}
	
function submitFollowerRoleUpgrade(followerID){
	$(".popup.myzar_user_upgrade").hide();
	$("body").css("overflow-y", "auto");
	
	const roleOption = $(".popup.myzar_user_upgrade input[name='role']:checked").val();
	$.post("mysql_myzar_follower_upgrade_process.php",{id:followerID, role:roleOption}).done(function(response){
		if(response == "OK"){
			const roleText = convertRoleInString(roleOption);
			$(".myzar_follower_detail .container #role").text(roleText);
			confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Хэрэглэгчийн эрх амжилттай ("+roleText+") боллоо", null);
	   	}
		else if(response == "FAIL"){
			confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Алдаа гарлаа!", null);
		}
		else if(response == "FAIL_ROLE"){
			confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Та энэ үйлдэлийг хийхийн тулд тохиргооруу орж хэрэглэгчийн эрх мэдлээ дээшлүүлнэ үү!", null);
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
			Хэрэглэгчид
			<a style="color: gray; font-family: RobotoRegular; font-size: 14px">(Дагагч болоогүй хүмүүс)</a>
		</div>
		<hr/>
		<div class="followers_list_container indirect"></div>
	</div>
	<div class="container users" style="display:none; margin-top:10px">
		<div style="font-family: RobotoBold; margin-left: 10px">Хэрэглэгчид</div>
		<hr/>
		<div class="followers_list_container users"></div>
	</div>
	<div class="followersPage" style="display:none">
		<div id="pagePrev" class="page">Өмнөх</div>
		<div id="pageNumbers" style="display: flex">
			<div class="page">1</div>
			<div class="page">2</div>
			<div id="page" class="page">...</div>
			<div class="page">15</div>
		</div>
		<div id="pageNext" class="page">Дараах</div>
	</div>
</div>

<div class="myzar_follower_detail" style="display: none">
	<a href="javascript:backToFollowersList()" style="text-decoration: none; margin-left: 10px">
		<i class="fas fa-angle-left"></i>
		Буцах
	</a>
	<div class="container" style="margin-bottom: 20px">
		<input id="number" type="hidden" />
		<div class="divimage">
			<img id="image" src="user.png" onerror="this.onerror=null; this.src='user.png'">
		</div>
		<div class="divcontainer">
			<div>Нэр:</div>
			<div>
				<input id="name" class="name" type="text" maxlength="128" value="" disabled>
			</div>
		</div>
		<div class="divcontainer">
			<div>Имейл:</div>
			<input id="email" class="email" type="email" maxlength="128" value="" disabled>
		</div>
		<div class="divcontainer">
			<div>Байршил:</div>
			<select id="city" style="width: 200px; height: 35px; font: normal 16px Arial; border-radius: 10px; margin-top: 5px" disabled>
				<option value="" disabled="" selected="">Сонгох</option>
				<option value="Улаанбаатар">Улаанбаатар</option>
				<option value="Архангай">Архангай</option>
				<option value="Баян-Өлгий">Баян-Өлгий</option>
				<option value="Баянхонгор">Баянхонгор</option>
				<option value="Булган">Булган</option>
				<option value="Говь-Алтай">Говь-Алтай</option>
				<option value="Говьсүмбэр">Говьсүмбэр</option>
				<option value="Дархан-Уул">Дархан-Уул</option>
				<option value="Дорноговь">Дорноговь</option>
				<option value="Дорнод">Дорнод</option>
				<option value="Дундговь">Дундговь</option>
				<option value="Завхан">Завхан</option>
				<option value="Орхон">Орхон</option>
				<option value="Өвөрхангай">Өвөрхангай</option>
				<option value="Өмнөговь">Өмнөговь</option>
				<option value="Сүхбаатар">Сүхбаатар</option>
				<option value="Сэлэнгэ">Сэлэнгэ</option>
				<option value="Төв">Төв</option>
				<option value="Увс">Увс</option>
				<option value="Ховд">Ховд</option>
				<option value="Хөвсгөл">Хөвсгөл</option>
				<option value="Хэнтий">Хэнтий</option>
			</select>
		</div>
		<div class="divcontainer" style="width: 60%">
			<div>Утас:</div>
			<div style="display: flex; align-items: center">
				<label for="phone" style="margin-right: 5px">+976</label>
				<input id="phone" class="phone" type="tel" maxlength="12" value="" disabled>
			</div>
		</div>
		<hr>
		<div class="divcontainer">
			<div style="display: flex; align-items: center">Хэрэглэгчийн эрх мэдэл:
				<div class="button_yellow" id="buttonUpgradeFollowerRole" style="height: 10px; margin-left: 5px">
					<div id="role" style="margin-left: 5px; font-size: 16px"></div>
					<i class="fa-solid fa-angle-up" style="font-size: 16px; margin-left: 8px"></i>
				</div>
			</div>
		</div>
		<div class="divcontainer" style="margin-bottom: 20px">
			<div>Утасны дугаар:</div>
			<div style="color: #9F9F9F; font-size: 14px"><?php echo $domain; ?>-ыг санал болгосон хүний утасны дугаар.</div>
			<div style="display: flex; align-items: center">
				<label for="affiliate_number" style="margin-right: 5px">+976</label>
				<input id="affiliate_number" type="number" maxlength="200" value="" disabled style="width:176px">
			</div>
		</div>
		<hr>
		<div class="divcontainer" style="display: flex; align-items: center">
			<img src="income_bw.png" width="30px" height="30px" style="margin-right: 5px">
			Орлого авах
		</div>
		<div class="divcontainer">
			<div>Банкны нэр:</div>
			<div style="color:#9F9F9F; font-size: 14px; margin-top: 2px; margin-bottom: 2px">Орлого хүлээн авах банкны дансны дугаар</div>
			<select id="bank_name" style="width: 60%; height: 35px; font: normal 16px Arial; border-radius: 10px; margin-top: 5px" onchange="javascript:selectBank(this.value, true)" disabled>
				<option value="" disabled="" selected="">Сонгох</option>
				<option value="Худалдаа хөгжлийн банк">Худалдаа хөгжлийн банк</option>
				<option value="ХААН банк">ХААН банк</option>
				<option value="Голомт банк">Голомт банк</option>
				<option value="Төрийн банк">Төрийн банк</option>
				<option value="Тээвэр хөгжлийн банк">Тээвэр хөгжлийн банк</option>
				<option value="Ариг банк">Ариг банк</option>
				<option value="Капитрон банк">Капитрон банк</option>
				<option value="Үндэсний хөрөнгө оруулалтын банк">Үндэсний хөрөнгө оруулалтын банк</option>
				<option value="Хас банк">Хас банк</option>
				<option value="Богд банк">Богд банк</option>
				<option value="Чингис Хаан банк">Чингис Хаан банк</option>
			</select>
		</div>
		<div class="divcontainer bank_owner" style="width: 60%;">
			<div>Данс эзэмшигчийн нэр:</div>
			<input id="bank_owner" type="text" maxlength="200" value="" disabled>
		</div>
		<div class="divcontainer bank_account" style="width: 60%;">
			<div>Дансны дугаар:</div>
			<input id="bank_account" type="number" maxlength="200" value="" disabled>
		</div>
		<div class="divcontainer qrcode">
			<div style="display: flex; align-items: center">
				<img src="hipay.png" width="40px" height="40px" style="margin-right: 5px">HiPay QR:
			</div>
			<div style="width: 200px; height: 200px; margin-left: auto; margin-right: auto">
				<img id="socialpay" src="image-solid.svg" style="cursor: pointer; object-fit:contain; width: 100%; height: 100%" onerror="this.onerror=null; this.src='image-solid.svg'">
			</div>
		</div>
	</div>
</div>