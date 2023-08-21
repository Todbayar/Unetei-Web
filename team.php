<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
?>

<script src="misc.js"></script>

<style>	
.team {
	width: 100%;
	height: 72vh;
	background-image:url('team1_bw.jpg');
	background-repeat:no-repeat;
	background-size:contain;
	background-position:center bottom;
	padding-top: 20px;
}
	
@media screen and (max-width: 540px) {
	.team {
		height: 72vh;
	}
}

	
.team .container_users {
	margin: 10px;
	display: flex;
	overflow-x: auto;
	padding-bottom: 5px;
	height: stretch;
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
	
function teamBecomeFollower(affiliate){
	$.post("mysql_user_follower.php", {phone:affiliate}).done(function(response){
		console.log("<teamBecomeFollower>:"+response);
		if(response=="OK"){
			$(".button_yellow.teamBecomeFollower").hide();
			confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #FFA718'></i>Та амжилттай дагагч боллоо");
		}
		else {
			confirmation_ok("<i class='fa-solid fa-circle-exclamation' style='margin-right: 5px; color: red'></i>Дагагч болход алдаа гарлаа!");
		}
	});
}
</script>

<div class="team">
	<div style="margin-left: 10px; margin-right: 10px; color: #9F9F9F; font-size: 14px">
		Таньд асуух зүйл байвал доорх хүмүүстэй холбоо барина уу. Бид таньд хариулхад бэлэн байна.<br/>
		<?php if(isset($_COOKIE["userID"])) echo "Мөн доорх хүмүүсийн аль нэгийг нь дагаснаар таньд давуу тал бий болно.<br/><a href=\"javascript:confirmation_ok('Дараах шаардлагуудыг хангасан байх<br/><i class=\'fa-solid fa-gear\'></i> Тохиргоо хэсэгт мэдээллээ бүрэн бөгөлсөн байх<br/>1. Өөрийн зургаа оруулсан байх<br/>2. Нэрээ бичих<br/>3. Имейлээ зөв бичсэн байх<br/>4. Банкны дансны нэрээ бичих<br/>5. Банкны дансны дугаараа бичих<br/>6. Санал болгосон хүний дугаарыг оруулсан байх<br/>Мөн өдөрт нэг удаа ".$domain."-рүү зочилсон байх буюу идэвхтэй байх.',null)\" style=\"color:#FFA718\">Энд хэрхэн мөр зэрэгцэх вэ <i class='fa-solid fa-question'></i></a>"; ?>
	</div>
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
				<?php
				if(isset($_COOKIE["userID"])){
					$phone = getPhone($_COOKIE["userID"]);
					if($row["phone"]!=$phone && $phone!=$superduperadmin){
						$myaffiliate = getAffiliatePhone($_COOKIE["userID"]);
						if(is_null($myaffiliate) || $myaffiliate==""){
							?>
							<div onclick="teamBecomeFollower('<?php echo $row["phone"]; ?>')" class="button_yellow teamBecomeFollower">
								<i class="fa-solid fa-user-plus"></i>
								<div style="margin-left: 5px">Дагах</div>
							</div>
							<?php
						}
					}
				}
				?>
			</div>
			<?php
		}
		?>
	</div>
</div>