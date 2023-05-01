<?php
include "mysql_config.php";
?>
<style>
.notification_number {
	position: absolute; 
	top:6px; right:14.3%; 
	font-size: 10px; 
	background: red; 
	color: white; 
	padding: 3px; 
	border-radius: 5px;
}
</style>
<div onClick="javascript:location.href='./'" style="display: flex; align-items: center; cursor: pointer">
	<img src="icon.png" width="50" height="50" />
	<div class="title">Unetei</div>
</div>
<div class="control">
	<div class="myzar">
		<div style="display: flex; align-items: center; height: 70px; cursor: pointer">
			<i class="fa-regular fa-user" style="font-size: 24px; color: #FFFFFF"></i>
			<div class="removable" style="color:#FFFFFF; margin-left: 5px">Миний зарууд</div>
			<div id="myzar_phone" class="removable" style="color: #174400">Нэвтрэх ба бүртгэл</div>
			<i class="fas fa-angle-down removable" style="margin-left: 2px; font-size: 12px; color: #174400; margin-top: 4px; margin-right: 20px"></i>
			<div class="dropdown" style="top:66px; z-index: 1">
				<div id="myzar_nav" class="button_yellow" align="center" onClick="pagenavigation('login')">Нэвтрэх</div>
				<div id="logoutButton" onClick="logout()" class="button_yellow" style="margin-top: 10px; background:#F05557; display: none">
					<div style="font-size: 14px">Гарах</div>
					<i class="fa-solid fa-right-from-bracket"></i>
				</div>
			</div>
		</div>
	</div>
	<i class="fa-regular fa-star" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer"></i>
	<?php 
	$query = "SELECT * FROM chat WHERE (toID=".$_COOKIE["userID"]." OR toID=0) AND isRead=0";
	$result = $conn->query($query);
	$countChat = mysqli_num_rows($result);
	
	if(!isset($_GET["page"]) || $_GET["page"] != "chat"){
	?>
	<i class="fa-regular fa-comments" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer" onClick="javascript:location.href='?page=chat'"><p class="notification_number"><?php echo $countChat; ?></p></i>
	<?php
	}
	else {
	?>
	<i class="fa-solid fa-comments" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer" onClick="javascript:location.href='?page=chat'"><p class="notification_number"><?php echo $countChat; ?></p></i>
	<?php
	}
	?>
	<div class="button_yellow" style="margin-left: 10px" onClick="javascript:location.href='?page=myzar&myzar=category'">
		<i class="fa-solid fa-plus"></i>
		<div class="removable" style="margin-left: 5px">Зар нэмэх</div>
	</div>
</div>