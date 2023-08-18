<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
?>

<script src="misc.js"></script>

<style>	
.team {
	position: relative;
	width: 100%;
}
	
.team .container_users {
	margin: 10px;
	z-index: 10;
	display: flex;
	overflow-x: auto;
	padding-bottom: 5px;
}
	
.team .container_users::-webkit-scrollbar {
	height: 1px;
}
 
.team .container_users::-webkit-scrollbar-track {
  	box-shadow: inset 0 0 1px rgba(0, 0, 0, 0);
}
 
.team .container_users::-webkit-scrollbar-thumb {
  	background-color: #FFA718;
  	outline: 2px solid #FFA718;
	border-radius: 10px;
}
	
.team .container_users .user {
	text-align: center;
	font-size: 14px;
	width: 110px;
	margin: 5px;
}

.team .container_users .user .image {
	width: 60px;
	height: 60px;
	border-radius: 100%;
	object-fit: cover;
}
	
.team .container_users .user .button_yellow {
	margin-top: 5px
}
	
.team .wallpaper {
	max-width: 100%;
	object-fit: contain;
}
</style>

<script>
function startChat(toID, message){
	<?php
	if(isset($_COOKIE["userID"])){
		?>
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
		<?php
	}
	else {
		?>
		pagenavigation('login');
		<?php
	}
	?>
}
</script>

<div class="team">
	<div class="container_users">
		<?php
		$query = "SELECT * FROM user WHERE name IS NOT NULL AND name!='' AND image IS NOT NULL AND image!='' AND email IS NOT NULL AND email!='' AND bank_owner IS NOT NULL AND bank_owner!='' AND bank_account IS NOT NULL AND bank_account!='' AND ((affiliate IS NOT NULL AND affiliate!='') OR ((affiliate IS NULL OR affiliate='') AND phone='".$superduperadmin."')) AND affiliate!=phone AND role>1 AND DATE_FORMAT(lastactive, '%Y-%m-%d')=DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY lastactive DESC";
		$result = $conn->query($query);
		while($row = mysqli_fetch_array($result)){
			?>
			<div class="user">
				<div>
					<img class="image" src="<?php echo $path."/".$row["image"]; ?>" onerror="this.onerror=null; this.src='user.png'">
					<div class="name text"><?php echo $row["name"]; ?></div>
					<div class="role text" style="color: #9F9F9F"><?php echo convertRoleInString($row["role"]); ?></div>
				</div>
				<div class="button_yellow">
					<i class="fa-solid fa-phone"></i>
					<div style="margin-left: 5px"><?php echo substr($row["phone"],4); ?></div>
				</div>
				<div onclick="startChat(<?php echo $row["id"]; ?>,'Сайн байна уу?')" class="button_yellow">
					<i class="fa-solid fa-comments"></i>
					<div style="margin-left: 5px">Чатлах</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	
	<div>
		<img class="wallpaper" src="team1.jpg" />
	</div>
</div>