<?php
include "mysql_config.php";
include_once "info.php";
?>

<script src="misc.js"></script>

<script>
$(document).ready(function(){
	$(".chat .right .bottom #chatMessage").keydown( function( event ) {
		if(event.which === 13){
			event.preventDefault();
			$(".chat .right .bottom .button_yellow").trigger("click");
		}
	});
	
	if(sessionStorage.getItem("startChatToID")!=null){
		chat_select(sessionStorage.getItem("startChatToID"));
		sessionStorage.removeItem("startChatToID");
	}
	
	$(".footer").hide();
});
	
function chat_send(toID){
	var chatSubmitData = new FormData();
	chatSubmitData.append("fromID", <?php echo $_COOKIE["userID"]; ?>);
	chatSubmitData.append("toID", toID);
	chatSubmitData.append("type", 0);
	chatSubmitData.append("message", $("#chatMessage").val());
	
	const reqChatSubmit = new XMLHttpRequest();
	reqChatSubmit.onload = function() {
//		console.log("<chat_send>:"+this.responseText);
		$("#chatMessage").val("");
		chat_select(toID);
	};
	reqChatSubmit.onerror = function(){
		console.log("<chat_send>:" + reqChatSubmit.status);
	};

	reqChatSubmit.open("POST", "chat_process.php", true);
	reqChatSubmit.send(chatSubmitData);
}
	
function chat_select(toID){
	$(".left .user").css("background-color", "transparent");
	$(".left #chatSelect"+toID).css("background-color", "#d7edf7");
	
	$(".chat .right .bottom").show();
	$(".chat .right .bottom .button_yellow").attr("onclick", "chat_send("+toID+")");
	
	const reqChatFetchSubmit = new XMLHttpRequest();
	reqChatFetchSubmit.onload = function() {
		if(this.responseText != ""){
			$(".chat .right .top").empty();
			const responseChatFetch = JSON.parse(this.responseText);
			responseChatFetch.forEach(function(chatRow){
				if(parseInt(chatRow.type) == 1){
					chat_list_category(chatRow.id, chatRow.sender, chatRow.body, chatRow.datetime, chatRow.isEdit);
				}
				else if(parseInt(chatRow.type) == 2){
					chat_list_item(chatRow.id, chatRow.sender, chatRow.body, chatRow.datetime, chatRow.isEdit, chatRow.note);
				}
				else if(parseInt(chatRow.type) == 3){
					chat_list_role(chatRow.id, chatRow.sender, chatRow.body, chatRow.datetime, chatRow.isEdit, chatRow.note);
				}
				else {
					chat_list_message(chatRow.sender, chatRow.body, chatRow.datetime, chatRow.isEdit);
				}
//				$(".chat .right .top").scrollTop($(".chat .right .top").innerHeight()*2);
				$(".chat .right .top").scrollTop(0);
			});
			$("div.message:last-child").css("margin-bottom","35px");
		}
	};
	reqChatFetchSubmit.onerror = function(){
		console.log("<chat_select>:" + reqChatFetchSubmit.status);
	};
	
	reqChatFetchSubmit.open("GET", "chat_fetch.php?toID="+toID, true);
	reqChatFetchSubmit.send();
}

function chat_list_role(chatID, sender, body, datetime, isEdit, note){
	var payment = "<i class=\"fa-regular fa-clock\" style=\"margin-left:5px\"></i>";
	var paymentHistory = "<div class=\"paymentHistory\">";
	if(note != ""){
		const noteObj = JSON.parse(note);
		noteObj.payment.reverse().forEach(function(obj, i, arr){
			if(arr[i].isPaid){
				if(i==0) payment = "<i class=\"fa-solid fa-check\" style=\"margin-left:5px\"></i>";
				paymentHistory += "<div><i class=\"fa-solid fa-check\" style=\"margin-left:5px\"></i> "+arr[i].datetime+"</div>";
			}
			else {
				if(i==0) payment = "<i class=\"fa-solid fa-xmark\" style=\"margin-left:5px\"></i>";
				paymentHistory += "<div><i class=\"fa-solid fa-xmark\" style=\"margin-left:5px\"></i> "+arr[i].datetime+"</div>";
			}
		});
	}
	else {
		paymentHistory += "<div>Төлбөрийн түүх алга</div>";
	}
	paymentHistory += "</div>";
	
	if(sender.id == <?php echo $_COOKIE["userID"]; ?>){
	   	var htmlRole = "<div class=\"message me\"><div class=\"container\"><div class=\"text\"><i class=\"fa-solid fa-user\" style=\"position:absolute; top:0; left:-15px; padding:5px; border-radius:10px; background: #fff4d0; color:#878787\"></i>";
	   	htmlRole += body.message+payment+paymentHistory;
		htmlRole += "</div><div class=\"datetime\">"+datetime+"</div>";
	    if(isEdit) htmlRole += chat_list_role_action_show(chatID, body.isActive, body.id, true);
		htmlRole += "</div>"+chat_profile_image_show(sender.image)+"</div>";
		$(".chat .right .top").append(htmlRole);
    }
	else {
	   	var htmlRole = "<div class=\"message\">"+chat_profile_image_show(sender.image)+"<div class=\"container\"><div class=\"text\"><i class=\"fa-solid fa-user\" style=\"position:absolute; top:0; right:-15px; padding:5px; border-radius:10px; background: #e7e7e7; color:#878787\"></i>";
		htmlRole += body.message+payment+paymentHistory;
		htmlRole += "</div><div class=\"datetime\">"+datetime+"</div>";
		if(isEdit) htmlRole += chat_list_role_action_show(chatID, body.isActive, body.id, false);
		htmlRole += "</div></div>";
		$(".chat .right .top").append(htmlRole);
    }
}

function chat_list_role_action_show(chatID, isactive, id, isMe){
	if(isactive == 0){	//review
		if(!isMe){
			return "<div id=\"2"+chatID+"\" class=\"action\"><div onClick=\"chat_action("+chatID+",0,2,"+id+")\" class=\"button_yellow\" style=\"float: left\"><i class=\"fa-solid fa-check\"></i></div></div>";
	   	}
		else {
			return "<div id=\"2"+chatID+"\" class=\"action\" style=\"display:flex; justify-content: flex-end\"><div onClick=\"chat_action("+chatID+",0,2,"+id+")\" class=\"button_yellow\" style=\"float: left\"><i class=\"fa-solid fa-check\"></i></div></div>";
		}
	}
	else {
		return "";
	}
}

function chat_list_category(chatID, sender, body, datetime, isEdit){
	if(sender.id == <?php echo $_COOKIE["userID"]; ?>){
	   	var typeColor = "#878787";
	   	if(body.status==1) typeColor = "#39a600";
		
		var htmlCategory = "<div class=\"message me\"><div class=\"container\"><div class=\"text\"><i class=\"fa-solid fa-sitemap\" style=\"position:absolute; top:0; left:-15px; padding:5px; border-radius:10px; background: #fff4d0; color:"+typeColor+"\"></i>";
	   	if(body.isActive == 1){
			htmlCategory += "<i class=\"fa-solid fa-arrow-rotate-left\" style=\"position:absolute; top:20px; left:-15px; padding:5px; border-radius:10px; background: #fff4d0; color:#878787\"></i>";
		}
		else if(body.isActive == 2){
			htmlCategory += "<i class=\"fa-solid fa-check\" style=\"position:absolute; top:20px; left:-15px; padding:5px; border-radius:10px; background: #fff4d0; color:#878787\"></i>";
		}
	   	htmlCategory += body.title;
	   	htmlCategory += chat_list_category_show(body.category, body.title);
		htmlCategory += chat_list_category_words_show(body.words);
		htmlCategory += "</div><div class=\"datetime\">"+datetime+"</div>";
		if(isEdit) htmlCategory += chat_list_category_action_show(chatID, body.isActive, body.category.length+"_"+body.id, true);
		htmlCategory += "</div>"+chat_profile_image_show(sender.image)+"</div>";
		$(".chat .right .top").append(htmlCategory);
	}
	else {
		var htmlCategory = "<div class=\"message\">"+chat_profile_image_show(sender.image)+"<div class=\"container\"><div class=\"text\"><i class=\"fa-solid fa-sitemap\" style=\"position:absolute; top:0; right:-15px; padding:5px; border-radius:10px; background: #e7e7e7; color:#878787\"></i>";
		if(body.isActive == 1){
			htmlCategory += "<i class=\"fa-solid fa-arrow-rotate-left\" style=\"position:absolute; top:20px; right:-15px; padding:5px; border-radius:10px; background: #e7e7e7; color:#878787\"></i>";
		}
		else if(body.isActive == 2){
			htmlCategory += "<i class=\"fa-solid fa-check\" style=\"position:absolute; top:20px; right:-15px; padding:5px; border-radius:10px; background: #e7e7e7; color:#878787\"></i>";
		}
		htmlCategory += body.title;
		htmlCategory += chat_list_category_show(body.category, body.title);
		htmlCategory += chat_list_category_words_show(body.words);
		htmlCategory += "</div><div class=\"datetime\">"+datetime+"</div>";
		if(isEdit) htmlCategory += chat_list_category_action_show(chatID, body.isActive, body.category.length+"_"+body.id);
		htmlCategory += "</div></div>";
		$(".chat .right .top").append(htmlCategory);
	}
}

function chat_list_item(chatID, sender, body, datetime, isEdit, note){
	var statusColor = "#878787";
	if(body.status == 2) statusColor = "#f00";
	else if(body.status == 1) statusColor = "#00d300";
	
	var payment = "<i class=\"fa-regular fa-clock\" style=\"margin-left:5px\"></i>";
	var paymentHistory = "<div class=\"paymentHistory\">";
	if(note != ""){
		const noteObj = JSON.parse(note);
		noteObj.payment.reverse().forEach(function(obj, i, arr){
			if(arr[i].isPaid){
				if(i==0) payment = "<i class=\"fa-solid fa-check\" style=\"margin-left:5px\"></i>";
				paymentHistory += "<div><i class=\"fa-solid fa-check\" style=\"margin-left:5px\"></i> "+arr[i].datetime+"</div>";
			}
			else {
				if(i==0) payment = "<i class=\"fa-solid fa-xmark\" style=\"margin-left:5px\"></i>";
				paymentHistory += "<div><i class=\"fa-solid fa-xmark\" style=\"margin-left:5px\"></i> "+arr[i].datetime+"</div>";
			}
		});
	}
	else {
		paymentHistory += "<div>Төлбөрийн түүх алга</div>";
	}
	paymentHistory += "</div>";
	
	if(sender.id == <?php echo $_COOKIE["userID"]; ?>){
	   	var htmlItem = "<div class=\"message me\"><div class=\"container\"><div onClick=\"pagenavigation('detail&id="+body.id+"')\" class=\"text\"><i class=\"fa-solid fa-cart-shopping\" style=\"position:absolute; top:0; left:-15px; padding:5px; border-radius:10px; background: #fff4d0; color:"+statusColor+"\"></i>";
	   	if(body.isActive == 3){
			htmlItem += "<i class=\"fa-solid fa-arrow-rotate-left\" style=\"position:absolute; top:20px; left:-15px; padding:5px; border-radius:10px; background: #fff4d0; color:#878787\"></i>";
		}
		else if(body.isActive == 4){
			htmlItem += "<i class=\"fa-solid fa-check\" style=\"position:absolute; top:20px; left:-15px; padding:5px; border-radius:10px; background: #fff4d0; color:#878787\"></i>";
		}
	   	htmlItem += body.title+" (#"+body.id+")";
	   	htmlItem += chat_list_category_show(body.category, "");
		htmlItem += "<div style=\"font-size:12px; color:gray; margin-top:2px\">Төлөх:"+(body.pay==0?"Үнэгүй":(body.pay+"₮"+payment))+"</div>";
		htmlItem += paymentHistory+"</div><div class=\"datetime\">"+datetime+"</div>";
		if(isEdit) htmlItem += chat_list_item_action_show(chatID, body.isActive, body.id, true);
		htmlItem += "</div>"+chat_profile_image_show(sender.image)+"</div>";
		$(".chat .right .top").append(htmlItem);
	}
	else {
		var htmlItem = "<div class=\"message\">"+chat_profile_image_show(sender.image)+"<div class=\"container\"><div onClick=\"pagenavigation('detail&id="+body.id+"')\" class=\"text\"><i class=\"fa-solid fa-cart-shopping\" style=\"position:absolute; top:0; right:-15px; padding:5px; border-radius:10px; background: #e7e7e7; color:"+statusColor+"\"></i>";
		if(body.isActive == 3){
			htmlItem += "<i class=\"fa-solid fa-arrow-rotate-left\" style=\"position:absolute; top:20px; right:-15px; padding:5px; border-radius:10px; background: #e7e7e7; color:#878787\"></i>";
		}
		else if(body.isActive == 4){
			htmlItem += "<i class=\"fa-solid fa-check\" style=\"position:absolute; top:20px; right:-15px; padding:5px; border-radius:10px; background: #e7e7e7; color:#878787\"></i>";
		}
		htmlItem += body.title+" (#"+body.id+")";
		htmlItem += chat_list_category_show(body.category, "");
		htmlItem += "<div style=\"font-size:12px; color:gray; margin-top:2px\">Төлөх:"+(body.pay==0?"Үнэгүй":(body.pay+"₮"+payment))+"</div>";
		htmlItem += paymentHistory+"</div><div class=\"datetime\">"+datetime+"</div>";
		if(isEdit) htmlItem += chat_list_item_action_show(chatID, body.isActive, body.id);
		htmlItem += "</div></div>";
		$(".chat .right .top").append(htmlItem);
	}
}

function chat_list_message(sender, body, datetime){
	if(sender.id == <?php echo $_COOKIE["userID"]; ?>){
		$(".chat .right .top").append("<div class=\"message me\"><div class=\"container\"><div class=\"text\">"+body+"</div><div class=\"datetime\">"+datetime+"</div></div>"+chat_profile_image_show(sender.image)+"</div>");
	}
	else {
		$(".chat .right .top").append("<div class=\"message\">"+chat_profile_image_show(sender.image)+"<div class=\"container\"><div class=\"text\">"+body+"</div><div class=\"datetime\">"+datetime+"</div></div></div>");
	}
}

function chat_list_category_show(categories, title){
	var vCategory = "<div style=\"font-size:12px; color:gray; margin-top:2px\">";
	for(let i=0; i<categories.length; i++){		
		if(i<categories.length-1){
			if(i<categories.length-2) vCategory += categories[i]+"<i class=\"fas fa-angle-right\" style=\"font-size:10px; margin-left:2px; margin-right:2px\"></i>";
			else vCategory += categories[i];
		}
		else {
			if(title=="") vCategory += "<i class=\"fas fa-angle-right\" style=\"font-size:10px; margin-left:2px; margin-right:2px\"></i>"+categories[i];
		}
	}
	return "<br/>"+vCategory+"</div>";
}
	
function chat_list_category_words_show(words){
	var vWords = "";
	words.split(',').forEach(function(word, i, arr){
		if(i<arr.length-1){
			vWords += word+", ";
		}
		else {
			vWords += word;
		}
	});
	return "<div style=\"font-size:12px; color:gray; margin-top:2px\">"+vWords+"</div>";
}

function chat_list_category_action_show(chatID, isactive, id, isMe = false){
	if(isactive == 0){	//review
		if(!isMe){
	   		return "<div id=\"0"+chatID+"\" class=\"action\"><div onClick=\"chat_action("+chatID+",0,0,'"+id+"')\" class=\"button_yellow\" style=\"float: left\"><i class=\"fa-solid fa-check\"></i></div><div onClick=\"chat_action("+chatID+",1,0,'"+id+"')\" class=\"button_yellow\" style=\"float: left; margin-left: 5px\"><i class=\"fa-solid fa-arrow-rotate-left\"></i></div></div>";
		}
		else {
			return "<div id=\"0"+chatID+"\" class=\"action\" style=\"display:flex; justify-content: flex-end\"><div onClick=\"chat_action("+chatID+",0,0,'"+id+"')\" class=\"button_yellow\" style=\"float: left\"><i class=\"fa-solid fa-check\"></i></div><div onClick=\"chat_action("+chatID+",1,0,'"+id+"')\" class=\"button_yellow\" style=\"float: left; margin-left: 5px\"><i class=\"fa-solid fa-arrow-rotate-left\"></i></div></div>";
		}
	}
	else {
		return "";
	}
}
	
function chat_list_item_action_show(chatID, isactive, id, isMe = false){
	if(isactive == 1){	//review
		if(!isMe){
			return "<div id=\"1"+chatID+"\" class=\"action\"><div onClick=\"chat_action("+chatID+",0,1,"+id+")\" class=\"button_yellow\" style=\"float: left\"><i class=\"fa-solid fa-check\"></i></div><div onClick=\"chat_action("+chatID+",1,1,"+id+")\" class=\"button_yellow\" style=\"float: left; margin-left: 5px\"><i class=\"fa-solid fa-arrow-rotate-left\"></i></div></div>";   
	   	}
		else {
			return "<div id=\"1"+chatID+"\" class=\"action\" style=\"display:flex; justify-content: flex-end\"><div onClick=\"chat_action("+chatID+",0,1,"+id+")\" class=\"button_yellow\" style=\"float: left\"><i class=\"fa-solid fa-check\"></i></div><div onClick=\"chat_action("+chatID+",1,1,"+id+")\" class=\"button_yellow\" style=\"float: left; margin-left: 5px\"><i class=\"fa-solid fa-arrow-rotate-left\"></i></div></div>";
		}
	}
	else {
		return "";
	}
}

function chat_profile_image_show(image){
	if(image != ""){
		return "<img src=\"<?php echo $path; ?>/"+image+"\" onerror=\"this.src='user.png'\">";
	}
	else {
		return "<img src=\"user.png\">";
	}
}

function chat_action(chatID, action, type, id){
	//chatID chat row id
	//action 0=accept, 1=dismiss
	//type 0=category, 1=item, 2=role
	//id rowid
	
	var chatActionSubmitData = new FormData();
	chatActionSubmitData.append("chatID", chatID);
	chatActionSubmitData.append("action", action);
	chatActionSubmitData.append("type", type);
	chatActionSubmitData.append("id", id);

	const reqChatActionSubmit = new XMLHttpRequest();
	reqChatActionSubmit.onload = function() {
//		console.log("<chat_action>:"+this.responseText);
		if(this.responseText == "OK"){
			$("div#"+type+""+chatID).hide();
		}
	};
	reqChatActionSubmit.onerror = function(){
		console.log("<chat_send>:" + reqChatActionSubmit.status);
	};

	reqChatActionSubmit.open("POST", "chat_action.php", true);
	reqChatActionSubmit.send(chatActionSubmitData);
}

//function chat_input_enter(evt){
//	if(evt.keyCode == 13){
//		$(".chat .right .bottom .button_yellow").trigger("click");
//    }
//}
</script>

<div class="chat">
	<div class="left">
		<?php
		$queryFetchSender = "SELECT c.*, (SELECT name FROM user WHERE id=c.fromID) AS sender_name, (SELECT image FROM user WHERE id=c.fromID) AS sender_image, (SELECT role FROM user WHERE id=c.fromID) AS sender_role, (SELECT phone FROM user WHERE id=c.fromID) AS sender_phone, (SELECT name FROM user WHERE id=c.toID) AS receiver_name, (SELECT image FROM user WHERE id=c.toID) AS receiver_image, (SELECT role FROM user WHERE id=c.toID) AS receiver_role, (SELECT phone FROM user WHERE id=c.toID) AS receiver_phone FROM chat c JOIN (SELECT CASE WHEN fromID=".$_COOKIE["userID"]." THEN toID ELSE fromID END AS other, MAX(datetime) AS latest FROM chat WHERE fromID=".$_COOKIE["userID"]." OR toID=".$_COOKIE["userID"]." GROUP BY other) m ON (c.fromID=".$_COOKIE["userID"]." AND c.toID=m.other OR c.toID=".$_COOKIE["userID"]." AND c.fromID=m.other) AND c.datetime = m.latest";
		$resultFetchSender = $conn->query($queryFetchSender);
		while($rowFetchSender = mysqli_fetch_array($resultFetchSender)){
			if($rowFetchSender["toID"]==$_COOKIE["userID"]){
				?>
				<div id="chatSelect<?php echo $rowFetchSender["fromID"]; ?>" class="user" onClick="chat_select(<?php echo $rowFetchSender["fromID"]; ?>)">
					<div class="container">
						<div class="box">
							<div class="profile">
								<?php
								if($rowFetchSender["sender_image"] != ""){
								?>
								<img src="<?php echo $path.DIRECTORY_SEPARATOR.$rowFetchSender["sender_image"]; ?>" onerror="this.src='user.png'">
								<?php
								}
								else {
								?>
								<img src="user.png">
								<?php
								}
								?>
							</div>
							<div>
								<div class="name"><?php echo $rowFetchSender["sender_name"]; ?></div>
								<div class="role">
									<?php
									switch($rowFetchSender["sender_role"]){
										case 0:
											echo $role_rank_user;
											break;
										case 1:
											echo $role_rank_publisher;
											break;
										case 2:
											echo $role_rank_manager;
											break;
										case 3:
											echo $role_rank_admin;
											break;
										case 4:
											echo $role_rank_superadmin;
											break;
									}
									?>
								</div>
								<div class="phone"><?php echo substr($rowFetchSender["sender_phone"],4); ?></div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			else if($rowFetchSender["fromID"]==$_COOKIE["userID"]){
				?>
				<div id="chatSelect<?php echo $rowFetchSender["toID"]; ?>" class="user" onClick="chat_select(<?php echo $rowFetchSender["toID"]; ?>)">
					<div class="container">
						<div class="box">
							<div class="profile">
								<?php
								if($rowFetchSender["receiver_image"] != ""){
								?>
								<img src="<?php echo $path.DIRECTORY_SEPARATOR.$rowFetchSender["receiver_image"]; ?>" onerror="this.src='user.png'">
								<?php
								}
								else {
								?>
								<img src="user.png">
								<?php
								}
								?>
							</div>
							<div>
								<div class="name"><?php echo $rowFetchSender["receiver_name"]; ?></div>
								<div class="role">
									<?php
									switch($rowFetchSender["receiver_role"]){
										case 0:
											echo $role_rank_user;
											break;
										case 1:
											echo $role_rank_publisher;
											break;
										case 2:
											echo $role_rank_manager;
											break;
										case 3:
											echo $role_rank_admin;
											break;
										case 4:
											echo $role_rank_superadmin;
											break;
									}
									?>
								</div>
								<div class="phone"><?php echo substr($rowFetchSender["receiver_phone"],4); ?></div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
	<div class="right">
		<div class="top"></div>
		<div class="bottom" style="display: none">
			<input id="chatMessage" type="text" placeholder="Энд бичнэ үү" />
			<div onClick="chat_send(0)" class="button_yellow" style="float: right; height: 16px">
				<i class="fa-solid fa-paper-plane"></i>
			</div>
		</div>
	</div>
</div>