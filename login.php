<style>
.imageLoginCallingOperatorAnim {
	animation: pulse 1s infinite;
	animation-iteration-count: 1;
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
</style>

<script>
var intervalPhoneCallvalid;
	
window.onload = function() {
	<?php
	if($auth_method == AUTH_FIREBASE){
		?>
		firebase.auth().onAuthStateChanged(function(user) {
			if (user) {
				console.log("<user>:",user.phoneNumber,user.uid);
//				firebase.auth().signOut();
//				var uid = user.uid;
//				var email = user.email;
//				var photoURL = user.photoURL;
//				var isAnonymous = user.isAnonymous;
//				var displayName = user.displayName;
//				var providerData = user.providerData;
//				var emailVerified = user.emailVerified;
				const loginSubmit = new XMLHttpRequest();
				loginSubmit.onload = function(){
					console.log("<phone code verifying>:"+this.responseText);
					if(!this.responseText.includes("Fail")){
						analytics.logEvent('login_phone_verified');
						location.href = "./";
					}
					else {
						$("#loginVerificationError").text("Нэвтрэх үед алдаа гарлаа!");
					}
				};

				loginSubmit.onerror = function(){
					$("#loginVerificationError").text(loginSubmit.status);
				};

				loginSubmit.open("POST", "mysql_userLogin.php", true);

				var loginData = new FormData();
				loginData.append("uid", user.uid);
				loginData.append("phone", user.phoneNumber);
//				loginSubmit.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				loginSubmit.send(loginData);
			}
			updateSignInButtonUI();
			updateSignInFormUI();
			updateVerificationCodeFormUI();
		});

		window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('loginButtonFirebase', {
			'size': 'invisible',
			'callback': function(response) {
				phoneAuth();
			}
		});
		<?php
	}
	else if($auth_method == AUTH_CALL){
		?>
		window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('loginButtonCall', {
			'size': 'invisible',
			'callback': function(response) {
				const uPhone = "+976"+getPhoneNumberFromUserInput();
				$.get("phone_validater.php", {phone_validater:"<?php echo $phone_validater_superduperadmin; ?>", phone_user:uPhone, type:0}).done(function(response){
					console.log("<recaptchaVerifier>:",response);
					const objResponse = JSON.parse(response);
					if(objResponse.response == "ok"){
						$("#phoneentry_container").hide();
						$("#phonecallverifier_container").show();
						$("#phoneverifier_number").text(uPhone);
						$("#imageLoginCallingOperator").addClass("imageLoginCallingOperatorAnim");
						intervalPhoneCallvalid = setInterval(function(){phoneAuthCallAccept(uPhone);}, 3000);
					}
					else {
						$("#loginError").val("Та утасны дугаараа зөв оруулна уу!");
					}
				});
			}
		});
		<?php
	}
	?>
	
	recaptchaVerifier.render().then(function(widgetId){
		window.recaptchaWidgetId = widgetId;
		updateSignInButtonUI();
    });
	
	$("#loginPhone").on("input", function(e){
		updateSignInButtonUI();
	});
	
	$("#loginAgree").change(function() {
		updateSignInButtonUI();
	});
	
	$("#phoneverificationcode").on("input", function(e){
		updateVerifyCodeButtonUI();
	});
}

function signInFirebase(){
	
}

function updateSignInButtonUI(){
	Array.from(document.getElementsByClassName("loginButton")).forEach(
    	function(element, index, array) {
			element.disabled = !isPhoneNumberValid() || !!window.signingIn || !$("#loginAgree").prop('checked');
		}
	);
}

function updateVerifyCodeButtonUI(){
	document.getElementById('loginVerify').disabled = !isCodeValid() || !!window.verifyingCode;
}
	
function updateVerificationCodeFormUI(pPhone) {
	if (!firebase.auth().currentUser && window.confirmationResult) {
		$("#phoneverifier_container").show();
		$("#phoneverifier_number").text(pPhone);
	} 
	else {
		$("#phoneverifier_container").hide();
	}
}

function isPhoneNumberValid() {
	var pattern = new RegExp("^[0-9]{8}$");
	var phoneNumber = getPhoneNumberFromUserInput();
	return phoneNumber.search(pattern) !== -1;
}

function isCodeValid() {
	var pattern = new RegExp("^[0-9]{6}$");
	var codeNumber = getCodeFromUserInput();
	return codeNumber.search(pattern) !== -1;
}
	
function getPhoneNumberFromUserInput() {
	return document.getElementById('loginPhone').value;
}
	
function getCodeFromUserInput() {
	return document.getElementById('phoneverificationcode').value;
}
	
function updateSignInFormUI() {
	if (firebase.auth().currentUser || window.confirmationResult) {
		$("#phoneentry_container").hide();
	}
	else {
		resetReCaptcha();
		$("#phoneentry_container").show();
	}
}
	
function resetReCaptcha() {
	if (typeof grecaptcha !== 'undefined' && typeof window.recaptchaWidgetId !== 'undefined') {
		grecaptcha.reset(window.recaptchaWidgetId);
	}
}

function onVerifyCodeSubmit(e) {
//	e.preventDefault();
	if(!!getCodeFromUserInput()) {
		window.verifyingCode = true;
		updateVerifyCodeButtonUI();
		var code = getCodeFromUserInput();
		confirmationResult.confirm(code).then(function(result){
			var user = result.user;
			window.verifyingCode = false;
			window.confirmationResult = null;
			updateVerificationCodeFormUI();
		}).catch(function (error) {
			console.error('Error while checking the verification code:', error, error.message);
			$("#loginVerificationError").text("Оруулсан баталгаажуулах код буруу байна, та дахин оролдоно уу!");
			window.verifyingCode = false;
			updateSignInButtonUI();
			updateVerifyCodeButtonUI();
		});
	}
}

function phoneAuth() {
	analytics.logEvent('login_phone_click');
	const vError = $("#loginError");
	const vValidPhone = "+976"+$("#loginPhone").val();
	console.log("<phoneAuth>:",vValidPhone);
	window.signingIn = true;
	updateSignInButtonUI();
	firebase.auth().signInWithPhoneNumber(vValidPhone, window.recaptchaVerifier)
		.then(function (confirmationResult) {
			window.confirmationResult = confirmationResult;
			window.signingIn = false;
			updateSignInFormUI();
			updateSignInButtonUI();
			updateVerificationCodeFormUI();
			updateVerifyCodeButtonUI();
		}).catch(function (error) {
			vError.val("Та утасны дугаараа зөв оруулна уу!");
			console.error('Error during signInWithPhoneNumber:', error, error.message);
			window.signingIn = false;
			updateSignInFormUI();
			updateSignInButtonUI();
	});
}

function phoneAuthCallAccept(phone){
	$("#imageLoginCallingOperator").removeClass("imageLoginCallingOperatorAnim");
	$.get("phone_validater.php", {phone_validater:"<?php echo $phone_validater_superduperadmin; ?>", phone_user:phone, type:2}).done(function(response){
		console.log("<phoneAuthCallAccept>:", response);
		if(isNumeric(response)){
		   	analytics.logEvent('login_phone_verified');
			location.href = "./";
	   	}
		else {
			const objResponse = JSON.parse(response);
			if(objResponse.response=="waiting"){
			   	$("#imageLoginCallingOperator").addClass("imageLoginCallingOperatorAnim");
		   	}
			else {
				clearInterval(intervalPhoneCallvalid);
				var eventLoginTryAgain = new CustomEvent("loginTryAgain");
				window.addEventListener("loginTryAgain", function(){
					pagenavigation('login');
				});
				confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Алдаа гарлаа та дахин оролдоно уу", eventLoginTryAgain);
			}
		}
	});
}
	
function isNumeric(value) {
    return /^-?\d+$/.test(value);
}
</script>

<div style="padding-left: 20px; padding-right: 20px; padding-top: 0px; width: 100%">
	<p style="font: bold 24px Arial">Нэвтрэх</p>
	<hr/>
	<div id="phoneentry_container">
		<p style="font: bold 18px Arial">Таны утасны дугаар</p>
		<div style="display: flex; align-items: center">
			<div style="font: bold 18px Arial">+976</div>
			<input 
				   type="tel" 
				   id="loginPhone" 
				   placeholder="_ _ _ _ _ _ _ _" 
				   pattern="[0-9]{8}"
				   maxlength="8"
				   style="margin-left: 10px; height: 30px; padding: 5px; font: bold 18px Arial">
		</div>
		<div style="margin-top: 10px; display: flex; align-items: center">
			<input id="loginAgree" type="checkbox" style="border: 2px solid #c1c1c1; width: 15px; height: 15px; border-radius: 5px; transform:scale(2); margin:5px">
			<p style="margin-left: 10px">Би <?php echo $domain; ?> сайтын <a href="policy.php">үйлчилгээний нөхцөл</a>, <a href="rule.php">зар нийтлэх журмыг</a> хүлээн зөвшөөрч, мөн өөрийгөө 18 нас хүрсэн болохыг баталж байна.</p>
		</div>
		<div id="recaptcha-container"></div>
		<div>
			<p id="loginError" style="color: #FF0004">Та үйлчилгээний нөхцөлийг зөвшөөрснөө баталж чагтална уу мөн өөрийгөө хүн гэдгээ батална уу!</p>
			<div style="display: flex">
				<?php
				if($auth_method == AUTH_FIREBASE){
					?>
					<button disabled id="loginButtonFirebase" class="button_yellow loginButton" type="button" style="font: normal 16px Arial; margin-left: 5px; margin-right: 5px">
						<img src="firebase_logo.png" width="24px" height="24px" style="margin-right: 5px; object-fit: contain" />Мессежээр нэвтрэх
					</button>
					<?php
				}
				else if($auth_method == AUTH_CALL){
					?>
					<button disabled id="loginButtonCall" class="button_yellow loginButton" type="button" style="font: normal 16px Arial; margin-left: 5px; margin-right: 5px"> 
						<i class="fa-solid fa-phone-volume" style="margin-right: 5px; font-size: 18px"></i>Дуудлагаар нэвтрэх
					</button>
					<?php
				}
				?>
<!--			<i class="fa-solid fa-comment-sms" style="margin-right: 5px; font-size: 18px"></i>-->
			</div>
		</div>
	</div>
	<div id="phoneverifier_container" style="display: none">
		<div>Таны утасруу баталгаажуулах код бүхий мессеж илгээгдлээ.<p id="phoneverifier_number"></p></div>
		<p>Доорх талбарт код оруулна уу.</p>
		<input type="number" id="phoneverificationcode" maxlength="6" pattern="[0-9]{6}" placeholder=" _ _ _ _ _ _" style="height: 30px; padding: 5px; font: bold 18px Arial">
		<br/>
		<p id="loginVerificationError" style="color: #FF0004"></p>
		<button disabled id="loginVerify" class="button_yellow" type="button" style="font: normal 18px Arial" onClick="onVerifyCodeSubmit(this)">Үргэлжлүүлэх</button>
	</div>
	<div id="phonecallverifier_container" style="text-align: center; display: none">
		<div style="margin-bottom: 10px"><i class="fa-solid fa-phone-volume" style="margin-right: 5px"></i>Та автомат баталгаажуулагч <?php echo substr($phone_validater_superduperadmin,0,4)."<b>".substr($phone_validater_superduperadmin,4)."</b>"; ?> дугаарлуу дуудлага хийж <b id="phoneverifier_number"></b> дугаараа баталгаажуулна уу?<br/> Автомат баталгаажуулагч дуудлага ирэнгүүт салгах болно.</div>
		<img id="imageLoginCallingOperator" src="arduino.gif" width="100px" height="100px" style="object-fit: contain; border-radius: 100%" />
		<div style="margin-top: 10px">Та дуудлага хийнэ үү...</div>
	</div>
</div>