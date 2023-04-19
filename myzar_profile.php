<?php
include "mysql_config.php";
?>
<style>
.profile {
	width: 100%;
	padding-top: 40px;
	padding-bottom: 40px;
}

.profile .container {
	margin: 0 auto;
	max-width: 400px;
	padding-left: 10px;
	padding-right: 10px;
}

.profile .container .divimage {
	text-align: center;
}
	
.profile .container .divimage img {
	width: 80px;
	height: 80px;
	border-radius: 100%;
	background: #ccc;
}

.profile .container .divcontainer {
	margin-top: 10px;
	font: normal 18px Arial;
	display: flex;
	align-content: center;
	align-items: center;
	justify-content: center;
}
	
.profile .container .divcontainer input {
	width: 60%;
	height: 25px;
	border-radius: 10px;
	margin-left: 10px;
	font: normal 16px Arial;
}
</style>

<?php
$query = "SELECT * FROM user WHERE id=".$_COOKIE["userID"];
$result = $conn->query($query);
$row = mysqli_fetch_array($result);
?>
<div class="profile">
	<div class="container">
		<div class="divimage">
			<?php
			if($row["image"] != ""){
			?>
			<img src="<?php echo $row["image"]; ?>" />
			<?php
			}
			else {
			?>
			<img src="user.png" />
			<?php
			}
			?>
			<input type="file" id="image" style="display: none">
		</div>
		<div class="divcontainer">
			<div>Нэр:</div>
			<input id="name" class="name" maxlength="128" value="<?php echo $row["name"]; ?>">
		</div>
		<div class="divcontainer">
			<div>Имейл:</div>
			<input id="email" class="email" maxlength="128" value="<?php echo $row["email"]; ?>">
		</div>
		<div class="divcontainer">
			<div>Утас:</div>
			<input id="phone" class="phone" maxlength="12" value="<?php echo $row["phone"]; ?>" disabled>
		</div>
		<div style="width: 100%; float: left; margin-top: 10px; justify-content: center; display: flex">
			<div class="button_yellow button" style="float: left">
				<i class="fa-solid fa-floppy-disk"></i>
				<div style="margin-left: 5px">Хадгалах</div>
			</div>
		</div>
	</div>
</div>