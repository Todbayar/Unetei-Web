<?php
include "mysql_config.php";
include_once "info.php";
?>

<style>
.notification_number {
	position: absolute; 
	top:-15px;
	right: 0;
	font-size: 10px; 
	background: red; 
	color: white; 
	padding: 3px; 
	border-radius: 5px;
}
</style>

<div onClick="javascript:location.href='<?php echo $urlDepth; ?>'" style="display: flex; align-items: center; cursor: pointer">
	<img src="<?php echo $urlDepth; ?>icon.png" width="40" height="40" style="object-fit: contain" alt="icon" />
	<div class="title"><?php echo strtoupper($domain); ?></div>
</div>
<div class="control">
	<div class="myzar">
		<div id="myzar_button" onClick="javascript:location.href='<?php echo $urlDepth; ?>?page=loginsms'" style="display: flex; align-items: center; height: 70px; cursor: pointer; position: relative">
			<?php
			if(!isset($_GET["page"]) || $_GET["page"] != "myzar"){
			?>
			<i class="fa-regular fa-user" style="font-size: 24px; color: #FFFFFF"></i>
			<?php
			}
			else {
			?>
			<i class="fa-solid fa-user" style="font-size: 24px; color: #FFFFFF"></i>
			<?php
			}
			?>
			<div class="removable" style="color:#FFFFFF; margin-left: 5px">Миний зарууд</div>
			<div id="myzar_phone" class="removable" style="color: #174400">Нэвтрэх ба бүртгэл</div>
			<i class="fas fa-angle-down removable" style="margin-left: 2px; font-size: 12px; color: #174400; margin-top: 4px; margin-right: 20px"></i>
<!--
			<div class="dropdown">
				<div id="myzar_nav" class="button_yellow" align="center" onClick="javascript:location.href='?page=login'">Нэвтрэх</div>
				<div id="logoutButton" onClick="logout()" class="button_yellow" style="margin-top: 10px; background:#F05557; display: none">
					<div style="font-size: 14px">Гарах</div>
					<i class="fa-solid fa-right-from-bracket"></i>
				</div>
			</div>
-->
		</div>
	</div>
	<i onClick="javascript:location.href='<?php echo $urlDepth; ?>?page=team'" class="fa-brands fa-teamspeak" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer"></i>
	<?php
	if(isset($_COOKIE["userID"])){
		if(!isset($_GET["page"]) || $_GET["page"] != "favorite"){
		?>
		<i onClick="javascript:location.href='<?php echo $urlDepth; ?>?page=favorite'" class="fa-regular fa-star" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer"></i>
		<?php
		}
		else {
		?>
		<i onClick="javascript:location.href='<?php echo $urlDepth; ?>?page=favorite'" class="fa-solid fa-star" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer"></i>
		<?php
		}
		
		$query = "SELECT * FROM chat WHERE (toID=".$_COOKIE["userID"]." OR toID=0) AND isRead=0";
		$result = $conn->query($query);
		$countChat = mysqli_num_rows($result);
		
		if(!isset($_GET["page"]) || $_GET["page"] != "chat"){
		?>
		<i class="fa-regular fa-comments" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer; position: relative" onClick="javascript:location.href='<?php echo $urlDepth; ?>?page=chat'">
			<?php
			if($countChat>0){
			?>
			<p class="notification_number"><?php echo $countChat; ?></p>
			<?php
			}
			?>
		</i>
		<?php
		}
		else {
		?>
		<i class="fa-solid fa-comments" style="font-size: 24px; color: #FFFFFF; font: normal; margin-left: 10px; cursor: pointer; position: relative" onClick="javascript:location.href='<?php echo $urlDepth; ?>?page=chat'">
			<?php
			if($countChat>0){
			?>
			<p class="notification_number"><?php echo $countChat; ?></p>
			<?php
			}
			?>
		</i>
		<?php
		}
		?>
		<div id="topbarInsertAdButton" class="button_yellow" style="margin-left: 10px" onClick="javascript:location.href='<?php echo $urlDepth; ?>?page=myzar&myzar=category'">
			<i class="fa-solid fa-plus"></i>
			<div class="removable" style="margin-left: 5px">Зар нэмэх</div>
		</div>
		<?php
	}
	else {
		?>
		<div class="button_yellow" style="margin-left: 10px" onClick="javascript:location.href='<?php echo $urlDepth; ?>?page=loginsms'">
			<i class="fa-solid fa-plus"></i>
			<div class="removable" style="margin-left: 5px">Зар нэмэх</div>
		</div>
		<?php
	}
	?>
</div>