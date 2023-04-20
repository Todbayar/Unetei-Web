<?php
include "mysql_config.php";
include "info.php";
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
	cursor: pointer;
}

.profile .container .divcontainer {
	margin-top: 10px;
	font: normal 18px Arial;
}
	
.profile .container .divcontainer input {
	width: 100%;
	height: 25px;
	border-radius: 10px;
	font: normal 16px Arial;
	margin-top: 5px;
}
</style>

<script>
$(document).ready(function(){		
	$("#image_file").change(function(){
		const vIconType = $(this)[0].files[0].type;
//		const vIconName = $(this)[0].files[0].name;
		if(vIconType == "image/svg+xml" || vIconType == "image/png" || vIconType == "image/jpeg"){
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#image").attr("src", e.target.result);
			}
			reader.onerror = function(){
				$("#image").attr("src", "user.png");
				console.log("<image_file>:error");
			}
			reader.readAsDataURL($(this)[0].files[0]);
		}
		else {
			$("#image_file").val(null);
		}
	});
});
	
function selectCity(city){
	$("#city").val(city);
}

function profile_image_button(){
	$("#image_file").trigger("click");
}
	
function submitProfile(){
	const patternOnlyText = /^[а-яА-Яa-zA-ZөӨүҮ\s]+$/i;
	const patternEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/i;
	
	var vName = $("#name").val().trim();
	var vEmail = $("#email").val().trim();
	
	if(vName != "" && !patternOnlyText.test(vName)) $("#name_error").show(); else $("#name_error").hide();
	if(vEmail != "" && !patternEmail.test(vEmail)) $("#email_error").show(); else $("#email_error").hide();
	
	if((vName != "" && patternOnlyText.test(vName)) && (vEmail != "" && patternEmail.test(vEmail))){
		var profileSubmitData = new FormData();
		profileSubmitData.append("userID", <?php echo $_COOKIE["userID"]; ?>);
		profileSubmitData.append("image", $("#image_file")[0].files[0]);
		profileSubmitData.append("name", vName);
		profileSubmitData.append("email", vEmail);
		profileSubmitData.append("city", $("#city").val());

		const reqProfileSubmit = new XMLHttpRequest();
		reqProfileSubmit.onload = function() {
			if(this.responseText == "OK"){
				confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Амжилттай хадгалагдлаа.", null);	
			}
		};
		reqProfileSubmit.onerror = function(){
			console.log("<submitProfile_error>:" + reqProfileSubmit.status);
		};

		reqProfileSubmit.open("POST", "mysql_profile_update.php", true);
		reqProfileSubmit.send(profileSubmitData);
    }
}
</script>

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
			<img id="image" src="<?php echo $path.DIRECTORY_SEPARATOR.$row["image"]; ?>" onClick="profile_image_button()" />
			<?php
			}
			else {
			?>
			<img id="image" src="user.png" onClick="profile_image_button()" />
			<?php
			}
			?>
			<input type="file" id="image_file" accept="image/png, image/gif, image/jpeg, .svg" style="display: none">
		</div>
		<div class="divcontainer">
			<div>Нэр:</div>
			<div>
				<input id="name" class="name" type="text" maxlength="128" value="<?php echo $row["name"]; ?>">
				<div id="name_error" style="color: red; margin-top: 5px; font-size: 14px; display: none">Тоо эсвэл тусгай тэмдэгт оруулж болохгүй!</div>
			</div>
		</div>
		<div class="divcontainer">
			<div>Имейл:</div>
			<input id="email" class="email" type="email" maxlength="128" value="<?php echo $row["email"]; ?>">
			<div id="email_error" style="color: red; margin-top: 5px; font-size: 14px; display: none">Имейл буруу байна!</div>
		</div>
		<div class="divcontainer">
			<div>Байршил:</div>
			<select id="city" style="width: 200px; height: 35px; font: normal 16px Arial; border-radius: 10px; margin-top: 5px">
				<option value="" disabled selected>Сонгох</option>
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
			<?php if($row["city"] != ""){
			?>
			<script>selectCity('<?php echo $row["city"]; ?>')</script>
			<?php
			}
			?>
		</div>
		<div class="divcontainer">
			<div>Утас:</div>
			<input id="phone" class="phone" maxlength="12" value="<?php echo $row["phone"]; ?>" disabled>
		</div>
		<div style="width: 100%; float: left; margin-top: 10px; justify-content: center; display: flex">
			<div class="button_yellow button" style="float: left" onClick="submitProfile()">
				<i class="fa-solid fa-floppy-disk"></i>
				<div style="margin-left: 5px">Хадгалах</div>
			</div>
		</div>
	</div>
</div>