<script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
var intervalPhoneCallvalid, phoneCallValidTimeout;

window.onload = function() {
	window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('loginButtonCall', {
		'size': 'invisible',
		'callback': function(response) {
			const uPhone = "+976"+getPhoneNumberFromUserInput();
			analytics.logEvent('login_phone_call_verifier_click');
			$.get("phone_validater.php", {phone_validater:"<?php echo $phone_validater_superduperadmin; ?>", phone_user:uPhone, state:0}).done(function(response){
				analytics.logEvent('login_phone_call_verifying');
				console.log("<recaptchaVerifier>:",response);
				const objResponse = JSON.parse(response);
				if(objResponse.response == "ok"){
					$("#phoneentry_container").hide();
					$("#phonecallverifier_container").show();
					$("#phoneverifier_number").text(uPhone);
					$("#imageLoginCallingOperator").addClass("imageLoginCallingOperatorAnim");
					phoneCallValidTimeout = 30;
					intervalPhoneCallvalid = setInterval(function(){phoneAuthCallAccept(uPhone);}, 1500);
				}
				else {
					$("#loginError").val("Та утасны дугаараа зөв оруулна уу!");
				}
			});
		}
	});
	
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
	
	$("#loginButtonFirebase").click(jumpLoginSmsMethod);
}

function updateSignInButtonUI(){
	Array.from(document.getElementsByClassName("loginButton")).forEach(
    	function(element, index, array) {
			element.disabled = !isPhoneNumberValid() || !!window.signingIn || !$("#loginAgree").prop('checked');
		}
	);
}

function isPhoneNumberValid() {
	var pattern = new RegExp("^[0-9]{8}$");
	var phoneNumber = getPhoneNumberFromUserInput();
	return phoneNumber.search(pattern) !== -1;
}
	
function getPhoneNumberFromUserInput() {
	return document.getElementById('loginPhone').value;
}
	
function getCodeFromUserInput() {
	return document.getElementById('phoneverificationcode').value;
}
	
function resetReCaptcha() {
	if (typeof grecaptcha !== 'undefined' && typeof window.recaptchaWidgetId !== 'undefined') {
		grecaptcha.reset(window.recaptchaWidgetId);
	}
}

function phoneAuthCallAccept(phone){
	$("#imageLoginCallingOperator").removeClass("imageLoginCallingOperatorAnim");
	if(phoneCallValidTimeout>0){
	 	$.get("phone_validater.php", {phone_validater:"<?php echo $phone_validater_superduperadmin; ?>", phone_user:phone, state:2}).done(function(response){
			console.log("<phoneAuthCallAccept>:", response);
			if(isNumeric(response)){
				analytics.logEvent('login_phone_call_verified');
				location.href = "./";
			}
			else {
				const objResponse = JSON.parse(response);
				if(objResponse.response=="waiting"){
					$("#imageLoginCallingOperator").addClass("imageLoginCallingOperatorAnim");
				}
				else {
					analytics.logEvent('login_phone_call_verifying_failed');
					clearInterval(intervalPhoneCallvalid);
					showLoginTryAgainOnCall();
				}
			}
		});
    }
	else {
		analytics.logEvent('login_phone_call_verifying_failed');
		clearInterval(intervalPhoneCallvalid);
		showLoginTryAgainOnCall();
	}
	
	$("#phonecallverifier_container #error").text("Та дуудлага хийнэ үү... ("+phoneCallValidTimeout+")");
	phoneCallValidTimeout--;
}
	
function showLoginTryAgainOnCall(){
	var eventLoginTryAgainWithSMS = new CustomEvent("loginTryAgainWithSMS");
	window.addEventListener("loginTryAgainWithSMS", function(){
		$("#phonecallverifier_container").hide();
		jumpLoginSmsMethod();
	});
	var eventLoginTryAgain = new CustomEvent("loginTryAgain");
	window.addEventListener("loginTryAgain", function(){
		pagenavigation('login');
	});
	confirmation_yesno("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Алдаа гарлаа!<br/>Та <i class='fa-solid fa-comment-sms' style='margin-right: 5px; font-size: 18px; color:#9F9F9F'></i>мессежээр нэвтрэх үү?", eventLoginTryAgainWithSMS, eventLoginTryAgain);
//	var eventLoginTryAgain = new CustomEvent("loginTryAgain");
//	window.addEventListener("loginTryAgain", function(){
//		pagenavigation('login');
//	});
//	confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Алдаа гарлаа! Та дахин оролдоно уу.", eventLoginTryAgain);
}
	
function isNumeric(value) {
    return /^-?\d+$/.test(value);
}
	
function jumpLoginSmsMethod(){
	sessionStorage.setItem("jumpLoginSmsMethod",getPhoneNumberFromUserInput());
	pagenavigation('loginsms');
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
				<button id="loginButtonCall" type="button" class="button_yellow loginButton" style="font: normal 16px Arial; margin-left: 5px; margin-right: 5px" disabled>
					<i class="fa-solid fa-phone-volume" style="margin-right: 5px; font-size: 18px"></i>Дуудлагаар нэвтрэх
				</button>
				<button id="loginButtonFirebase" type="button" class="button_yellow loginButton" style="font: normal 16px Arial; margin-left: 5px; margin-right: 5px" disabled>
					<i class="fa-solid fa-comment-sms" style="margin-right: 5px; font-size: 18px"></i>Мессежээр нэвтрэх
				</button>
<!--			<img src="firebase_logo.png" width="24px" height="24px" style="margin-right: 5px; object-fit: contain" />-->
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
		<div id="error" style="margin-top: 10px">Та дуудлага хийнэ үү...</div>
		<div style="margin-top: 20px">Эсвэл та <i class="fa-solid fa-comment-sms" style="font-size: 18px; color:#9F9F9F"></i> мессежээр нэвтрэх бол <a href="javascript:jumpLoginSmsMethod()">энд</a> дарна уу.</div>
	</div>
</div>