<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";
?>

<style>
.myzar_followers {
	padding-top: 10px;
	padding-bottom: 10px;
}

.follower {
	text-align: center;
	float: left;
	margin: 10px;
	cursor: pointer;
}
	
.follower .image {
	width: 82px;
	height: 82px;
	border-radius: 100%;
}
</style>

<script>
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
</script>

<div class="myzar_followers">
	<?php
	$queryFollowers = "SELECT * FROM user WHERE affiliate=(SELECT phone FROM user WHERE id=".$_COOKIE["userID"].")";
	$resultFollowers = $conn->query($queryFollowers);
	while($rowFollowers = mysqli_fetch_array($resultFollowers)){
	?>
	<div class="follower">
		<img class="image" src="<?php echo $path."/".$rowFollowers["image"]; ?>" onerror="this.onerror=null; this.src='user.png'" />
		<div class="name"><?php echo $rowFollowers["name"]; ?></div>
		<div class="role"><?php echo convertRoleInString($rowFollowers["role"]); ?></div>
		<div class="phone"><?php echo substr($rowFollowers["phone"],4); ?></div>
		<div onclick="startChat(<?php echo $rowFollowers["id"]; ?>,'Сайн байна уу?')" class="button_yellow" style="margin-top: 5px">
			<i class="fa-solid fa-comments"></i>
			<div style="margin-left: 5px">Чатлах</div>
		</div>
		<div onClick="showOtherItems(<?php echo $rowFollowers["id"]; ?>)" class="button_yellow" style="margin-top: 5px">
			<i class="fa-solid fa-cart-shopping"></i>
			<div style="margin-left: 5px">Зарууд</div>
		</div>
	</div>
	<?php
	}
	?>
</div>