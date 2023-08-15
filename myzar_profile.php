<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
?>

<style>
.profile {
	width: 100%;
	padding-top: 30px;
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
	
.buttonUpgradeUserRole {
	animation: pulse 1s infinite;
	animation-iteration-count: 3;
}
	
@keyframes pulse {
	0% {
		transform: scale(0.95);
		box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
	}

	70% {
		transform: scale(1);
		box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
	}

	100% {
		transform: scale(0.95);
		box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
	}
}
	
#affiliateSearchResult {
	overflow-x: auto;
	margin-top: 10px;
	display: flex;
	padding-bottom: 10px;
}
	
#affiliateSearchResult::-webkit-scrollbar {
	height: 1px;
}
 
#affiliateSearchResult::-webkit-scrollbar-track {
  	box-shadow: inset 0 0 1px rgba(0, 0, 0, 0);
}
 
#affiliateSearchResult::-webkit-scrollbar-thumb {
  	background-color: #FFA718;
  	outline: 2px solid #FFA718;
	border-radius: 10px;
}

#affiliateSearchResult .user {
	width: 80px;
	text-align: center;
	margin-left: 2px;
	margin-right: 2px;
	cursor: pointer;
}
	
#affiliateSearchResult .user img {
	width: 70px;
	height: 70px;
	object-fit: contain;
	border-radius: 100%;
}
	
#affiliateSearchResult .user .text {
	font-size: 12px;
}
	
#affiliateSearchResult .user .text .role {
	color: #9F9F9F;	
}

#affiliateSearchResult .user .text .phone {
	color: #9F9F9F;	
}
</style>

<script src="misc.js"></script>

<script>
var lastSelectionRoleUpgradeOption, qrSize;

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
	
	$("#socialpay_file").change(function(){
		const vIconType = $(this)[0].files[0].type;
//		const vIconName = $(this)[0].files[0].name;
		if(vIconType == "image/png" || vIconType == "image/jpeg"){
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#socialpay").attr("src", e.target.result);
				//image crop but doesn't get coordinate properly
//				window.scrollTo(0, 0);
//				$("body").css("overflow-y", "hidden");
//				$(".popup.profile_qrcrop").show();
//				$(".cropbox.img").attr("src", e.target.result);				
//				$('#cropbox').Jcrop({
//					aspectRatio: 1,
//					onSelect:function(c){
//						qrSize = {x:c.x,y:c.y,w:c.w,h:c.h};
//						$("#crop").prop('disabled', false);
//					}
//				});
			}
			reader.onerror = function(){
				$("#socialpay").attr("src", "image-solid.svg");
				console.log("<image_file>:error");
			}
			reader.readAsDataURL($(this)[0].files[0]);
		}
		else {
			$("#socialpay_file").val(null);
		}
	});
	
	if(<?php echo getUserRole($_COOKIE["userID"]); ?><4){
		$("#buttonUpgradeUserRole").click(function(){
			$("body").css("overflow-y", "hidden");
			window.scrollTo(0, 0);
			$(".popup.myzar_user_upgrade").show();
			$.post("mysql_fetch_profile.php", {affiliate:$("#affiliate_number").val()}).done(function (response){
				const res = JSON.parse(response);
				$(".popup.myzar_user_upgrade #affiliate").html("Та "+res.phone+" ("+res.name+", "+convertRoleInString(res.role)+")-ын дагагч болох гэж байна.");
				$(".popup.myzar_user_upgrade #buttonSubmit").attr("onclick", "submitRoleUpgrade('"+res.phone+"')");
			});
		});
	}
	else {
		$("#buttonUpgradeUserRole").removeClass("buttonUpgradeUserRole");
		$("#buttonUpgradeUserRole").css("background-color","#ccc");
		$("#buttonUpgradeUserRole i").hide();
	}
	
	$(".popup.myzar_user_upgrade input[name='role']").change(function(){
		lastSelectionRoleUpgradeOption = $(this);
	});
	
	$(".popup.myzar_user_upgrade .selection").click(function(){
		if(lastSelectionRoleUpgradeOption != null) lastSelectionRoleUpgradeOption.find("input").prop("checked", false);
		lastSelectionRoleUpgradeOption = $(this);
		lastSelectionRoleUpgradeOption.find("input").prop("checked", true);
		$(".popup.myzar_user_upgrade #buttonSubmit").attr("disabled", false);
	});

	$("#crop").click(function(){
		$(".popup.profile_qrcrop").hide();
		document.body.style.overflowY='auto';

		var imageCropData = new FormData();
		imageCropData.append("x", qrSize.x);
		imageCropData.append("y", qrSize.y);
		imageCropData.append("w", qrSize.w);
		imageCropData.append("h", qrSize.h);
		imageCropData.append("img", $("#socialpay_file")[0].files[0]);

		const reqCropImageSubmit = new XMLHttpRequest();
		reqCropImageSubmit.onload = function(){
			$("#socialpay").attr("src", this.response);
		};
		reqCropImageSubmit.onerror = function(){
			console.log("<reqCropImageSubmit_error>:" + reqCropImageSubmit.status);
		};

		reqCropImageSubmit.open("POST", "image-crop.php", true);		
		reqCropImageSubmit.send(imageCropData);
	});
	
	$("#affiliate_number").keyup(function(){
		$("#affiliateSearchResult").empty();
		if($(this).val()=="") $("#affiliateSearchResult").hide(100);
		$.post("mysql_fetch_profile_search_by_phone.php",{phone:("+976"+$(this).val())}).done(function(response){
//			console.log("<mysql_fetch_profile_search_by_phone>:"+response);
			if(response!="[]"){
				$("#affiliateSearchResult").show(100);
				JSON.parse(response).users.forEach(function(searchResultUser){
					var html = "<div class=\"user\" onClick=\"fillAffiliatePhone('"+searchResultUser.phone.substr(4)+"')\">";
					html += "<img src=\"<?php echo $path."/"; ?>"+searchResultUser.image+"\" onerror=\"this.src='user.png'\">";
					html += "<div class=\"text\">";
					if(searchResultUser.name!=null && searchResultUser.name!="") html += "<div class=\"name\">"+searchResultUser.name+"</div>";
					html += "<div class=\"role\">"+convertRoleInString(searchResultUser.role)+"</div>";
					html += "<div class=\"phone\">"+searchResultUser.phone.substr(4)+"</div>";
					html += "</div>";
					html += "</div>";
					$("#affiliateSearchResult").append(html);
				});
			}
		});
	});
});
	
function fillAffiliatePhone(phone){
	$("#affiliate_number").val(phone);
	$("#affiliateSearchResult").empty();
	$("#affiliateSearchResult").hide(100);
}
	
function submitRoleUpgrade(affiliatePhone){
	$(".popup.myzar_user_upgrade").hide();
	const selRole = $("input[name='role']:checked").val();
	$.post("mysql_billing.php", {type:"role", affiliate:affiliatePhone, role:selRole}).done(function (response){
		console.log("<submitRoleUpgrade>:"+response);
		$(".popup.billing").show();
		const res = JSON.parse(response);
		$(".popup.billing .container #billing_type").html(res.type);
		$(".popup.billing .container #billing_number").html(convertRoleInString(selRole));
		$(".popup.billing .container #billing_title").html(res.title);
		$(".popup.billing .container #billing_price").html(res.price + " ₮");
		
		if(res.bank_account!="" && res.bank_account!=null){
			$(".popup.billing .container #billing_bank #name").html("<b>" + res.bank_name + "</b>");
			$(".popup.billing .container #billing_bank #account").html("<b>" + res.bank_account + "</b>");
			$(".popup.billing .container #billing_bank #owner").html("<b>" + res.bank_owner + "</b>");
		}
		else {
			$(".popup.billing .container #billing_bank").hide();
		}
		
		if(res.socialpay!="" && res.socialpay!=null){
			$(".popup.billing .container #billing_socialpay img").attr("src", "user_files/"+res.socialpay);
		}
		else {
			$(".popup.billing .container #billing_qr").hide();
		}
	});
}
	
function selectCity(city){
	$("#city").val(city);
}

function selectBank(name, isNew = false){
	$(".divcontainer.bank_owner").show();
	$(".divcontainer.bank_account").show();
	$("#bank_name").val(name);
	if(isNew){
	   	$("#bank_owner").val("");
		$("#bank_account").val("");
    }
}

function profile_image_button(){
	$("#image_file").trigger("click");
}

function profile_socialpay_button(){
	$("#socialpay_file").trigger("click");
}
	
function submitProfile(){
	const patternOnlyText = /^[а-яА-Яa-zA-ZөӨүҮ\s]+$/i;
	const patternEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/i;
	const patternOnlyNumbers = /^(0|[1-9][0-9]*)$/i;
	
	var isSubmitOK = true;
	
	var vName = $("#name").val().trim();
	var vEmail = $("#email").val().trim();
	
	if(vName != "" && !patternOnlyText.test(vName)){
		$("#name_error").show(); 
		isSubmitOK = false;
	}
	else {
		$("#name_error").hide();
	}
	
	if(vEmail != "" && !patternEmail.test(vEmail)) {
		$("#email_error").show(); 
		isSubmitOK = false;
	}
	else {
		$("#email_error").hide();
	}
	
	var vBankOwner = patternOnlyText.test($("#bank_owner").val()) ? $("#bank_owner").val() : "";
	var vBankAccount = patternOnlyNumbers.test($("#bank_account").val()) ? $("#bank_account").val() : "";
	
	if(isSubmitOK){
		var profileSubmitData = new FormData();
		profileSubmitData.append("userID", <?php echo $_COOKIE["userID"]; ?>);
		profileSubmitData.append("image", $("#image_file")[0].files[0]);
		profileSubmitData.append("name", vName);
		profileSubmitData.append("email", vEmail);
		profileSubmitData.append("city", $("#city").val());
		profileSubmitData.append("affiliate", $("#affiliate_number").val());
		profileSubmitData.append("bank_name", $("#bank_name").val()!=""?$("#bank_name").val():"");
		profileSubmitData.append("bank_owner", vBankOwner);
		profileSubmitData.append("bank_account", vBankAccount);
		profileSubmitData.append("socialpay", $("#socialpay_file")[0].files[0]);
//		profileSubmitData.append("socialpay", $("#socialpay").attr("src"));

		const reqProfileSubmit = new XMLHttpRequest();
		reqProfileSubmit.onload = function() {
//			console.log("<profileSubmitData>:"+this.response);
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
	
function switchFollower(){
	confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Одоогоор өөрчлөх боломжгүй байна!", null);
}
</script>

<?php
$query = "SELECT * FROM user WHERE id=".$_COOKIE["userID"];
$result = $conn->query($query);
$row = mysqli_fetch_array($result);
if($row["role"] <= 1){
?>
<script>
$(document).ready(function(){
	$("#bank_name").attr("disabled", true);
	$("#socialpay").removeAttr("onclick");
});
</script>
<?php
}
?>
<div class="profile">
	<div class="container" style="margin-bottom: 20px">
		<div class="divimage">
			<div style="width: 80px; height: 80px; margin-left: auto; margin-right: auto; position: relative">
				<?php
				if($row["image"] != ""){
				?>
				<img id="image" src="<?php echo $path.DIRECTORY_SEPARATOR.$row["image"]; ?>" onClick="profile_image_button()" onerror="this.onerror=null; this.src='user.png'" />
				<?php
				}
				else {
				?>
				<img id="image" src="user.png" onClick="profile_image_button()" />
				<?php
				}
				?>
				<i class="fa-solid fa-camera" style="color: #FFA718; position: absolute; bottom: 5px; right: 5px"></i>
			</div>
			<input type="file" id="image_file" accept="image/png, image/gif, image/jpeg, .svg" style="display: none">
		</div>
		<div class="divcontainer">
			<div>Нэр:</div>
			<div>
				<input id="name" class="name" type="text" maxlength="128" value="<?php echo $row["name"]; ?>" style="width: 98%">
				<div id="name_error" style="color: red; margin-top: 5px; font-size: 14px; display: none">Тоо эсвэл тусгай тэмдэгт оруулж болохгүй!</div>
			</div>
		</div>
		<div class="divcontainer">
			<div>Имейл:</div>
			<div style="color: #9F9F9F; font-size: 14px">Та имэйлээ доор бичсэнээр мэдэгдэл хүлээн авах боломжтой болно</div>
			<input id="email" class="email" type="email" maxlength="128" value="<?php echo $row["email"]; ?>" style="width: 98%">
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
		<div class="divcontainer" style="width: 60%">
			<div>Таны утас:</div>
			<div style="display: flex; align-items: center">
				<label for="phone" style="margin-right: 5px">+976</label>
				<input id="phone" class="phone" type="tel" maxlength="12" value="<?php echo substr($row["phone"], 4); ?>" disabled>
			</div>
		</div>
		<div class="divcontainer" style="display: none">
			<div>Дансны үлдэгдэл</div>
			<div style="display: flex; align-items: center">
				<label style="margin-right: 5px"><?php echo $row["topup"] > 0 ? $row["topup"] : 0; ?> ₮</label>
				<div class="button_yellow button" style="float: left">
					<i class="fa-solid fa-bolt"></i>
					<div style="margin-left: 5px">Цэнэглэх</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="divcontainer" style="width: 100%; display: flex; align-items: center">
			
		</div>
		<div class="divcontainer">
			<div style="display: flex; align-items: center">Таны эрх мэдэл:
				<div class="button_yellow buttonUpgradeUserRole" id="buttonUpgradeUserRole" style="margin-left:5px; height: 10px">
					<div style="margin-left: 5px; font-size: 16px"><?php echo convertRoleInString(getUserRole($_COOKIE["userID"])); ?></div>
					<i class="fa-solid fa-angle-up" style="font-size: 16px; margin-left: 8px"></i>
				</div>
			</div>
		</div>
		<div class="divcontainer" style="color: #9F9F9F; font-size: 14px">
			<div>Таньд <?php echo $domain; ?>-ыг санал болгосон хүний утасны дугаар. Хоосон тохиолдолд сүпер дүпер админы дагагч болохыг анхаарна уу.</div>
		</div>
		<div class="divcontainer" style="width: 98%; margin-bottom: 20px">
			<div>Утасны дугаар:</div>
			<div style="display: flex; align-items: center">
				<label for="affiliate_number" style="margin-right: 5px">+976</label>
				<?php
				if($row["affiliate"]!="" && $row["affiliate"]!=null){
					?>
					<input id="affiliate_number" type="tel" pattern="[0-9]{8}" maxlength="8" value="<?php echo substr($row["affiliate"],4); ?>" style="width: 194px" disabled />
					<a href="javascript:switchFollower()" style="margin-left: 5px; color: #FFA718; cursor: pointer"><i class="fa-solid fa-lock"></i></a>
					<?php
				}
				else {
					?>
					<input id="affiliate_number" type="tel" pattern="[0-9]{8}" maxlength="8" value="<?php echo substr($row["affiliate"],4); ?>" style="width: 194px" />
					<?php
				}
				?>
			</div>
			<div id="affiliateSearchResult"></div>
		</div>
		<hr>
		<div class="divcontainer" style="display: flex; align-items: center">
			<img src="income_bw.png" width="30px" height="30px" style="margin-right: 5px" />
			Орлого авах
			<?php
			if(getUserRole($_COOKIE["userID"])<2){
			?>
			<i onclick="javascript:confirmation_ok('Та энэ үйлдэлийг хийхийн тулд хэрэглэгчийн эрх мэдлээ дээшлүүлнэ үү!')" class="fa-solid fa-circle-info" style="color: #FFA718; margin-left: 5px; cursor: pointer"></i>
			<?php
			}
			?>
		</div>
		<div class="divcontainer">
			<div>Банкны нэр:</div>
			<div style="color:#9F9F9F; font-size: 14px; margin-top: 2px; margin-bottom: 2px">Орлого хүлээн авах таны банкны дансны дугаар</div>
			<select id="bank_name" style="width: 60%; height: 35px; font: normal 16px Arial; border-radius: 10px; margin-top: 5px" onchange="javascript:selectBank(this.value, true)">
				<option value="" disabled selected>Сонгох</option>
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
		<div class="divcontainer bank_owner" style="width: 60%; display: none">
			<div>Данс эзэмшигчийн нэр:</div>
			<input id="bank_owner" type="text" maxlength="200" value="<?php echo $row["bank_owner"]; ?>">
		</div>
		<div class="divcontainer bank_account" style="width: 60%; display: none">
			<div>Дансны дугаар:</div>
			<input id="bank_account" type="number" maxlength="200" value="<?php echo $row["bank_account"]>0 ? $row["bank_account"] : ""; ?>">
		</div>
		<?php
		if($row["bank_name"] != "" && $row["bank_name"] != "null"){
		?>
		<script>selectBank("<?php echo $row["bank_name"]; ?>")</script>
		<?php
		}
		?>
		<div class="divcontainer qrcode">
			<div style="display: flex; align-items: center">
				<a href="https://www.hipay.mn"><img src="hipay.png" width="40px" height="40px" style="margin-right: 5px" /></a><a href="https://www.hipay.mn" style="margin-right: 5px">HiPay</a> QR:
			</div>
			<div style="color:#9F9F9F; font-size: 14px">
				HiPay аппнаас өөрийнхөө дансны QR кодыг скрийншот хийгээд тайрч доорх саарал зурган дээр дарж файлаа сонгон оруулсанаар орлого хүлээн авах боломжтой болно.
			</div>
			<div style="width: 200px; height: 200px; margin-left: auto; margin-right: auto; margin-top: 10px">
				<?php
				if($row["socialpay"]!="" && !is_null($row["socialpay"])){
				?>
				<img id="socialpay" src="<?php echo $path.DIRECTORY_SEPARATOR.$row["socialpay"]; ?>" onClick="profile_socialpay_button()" style="cursor: pointer; object-fit:contain; width: 100%; height: 100%" onerror="this.onerror=null; this.src='image-solid.svg'" />
				<?php
				}
				else {
					if($row["role"]>1){
						?>
						<img id="socialpay" src="image-solid_gray.png" onClick="profile_socialpay_button()" style="cursor: pointer; object-fit:contain; width: 100%; height: 100%" />
						<?php
					}
					else {
						?>
						<a href="javascript:confirmation_ok('Та энэ үйлдэлийг хийхийн тулд хэрэглэгчийн эрх мэдлээ дээшлүүлнэ үү!')"><img id="socialpay" src="image-solid_gray.png" style="cursor: pointer; object-fit:contain; width: 100%; height: 100%" /></a>
						<?php
					}
				}
				?>
				<input type="file" id="socialpay_file" accept="image/png, image/jpeg" style="display: none">
			</div>
		</div>
		<div style="width: 100%; float: left; margin-top: 10px; margin-bottom: 20px; justify-content: center; display: flex">
			<div class="button_yellow button" style="float: left" onClick="submitProfile()">
				<i class="fa-solid fa-floppy-disk"></i>
				<div style="margin-left: 5px">Хадгалах</div>
			</div>
		</div>
		<hr/>
		<div style="width: 100%; float: left; margin-top: 10px; justify-content: center; display: flex; margin-bottom:20px">
			<div onClick="logout()" class="button_yellow" style="background: red; color: white">
				<div style="font-size: 16px; margin-right: 10px; font-family: RobotoBold">Гарах</div>
				<i class="fa-solid fa-right-from-bracket"></i>
			</div>
		</div>
	</div>
</div>