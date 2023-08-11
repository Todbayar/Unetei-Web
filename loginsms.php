<script>
var intervalPhoneCallvalid, phoneCallValidTimeout;

window.onload = function() {
	firebase.auth().onAuthStateChanged(function(user) {
		if(user){
			updateSignInButtonUI();
			updateSignInFormUI();
			updateVerificationCodeFormUI();
			
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
	});
	
	window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
		'size': 'invisible',
		'callback': function(response) {
			updateSignInButtonUI();
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
	
	$("#phoneverificationcode").on("input", function(e){
		updateVerifyCodeButtonUI();
	});
	
	$("#loginButtonFirebase").click(function(){
		$("#phoneverifier_loading").hide();
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
	});
	
	if(sessionStorage.getItem("jumpLoginSmsMethod")!=null){
		console.log("<jumpLoginSmsMethod>:"+sessionStorage.getItem("jumpLoginSmsMethod"));
		$("#loginPhone").val(sessionStorage.getItem("jumpLoginSmsMethod"));
		$("#loginAgree").prop("checked",true);
		sessionStorage.removeItem("jumpLoginSmsMethod");
		$("#loginButtonFirebase").trigger("click");
   	}
	else {
		$("#phoneverifier_loading").hide();
		updateSignInButtonUI();
		updateSignInFormUI();
		updateVerificationCodeFormUI();
	}
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
	
function updateVerificationCodeFormUI() {
	if (!firebase.auth().currentUser && window.confirmationResult) {
		$("#phoneverifier_container").show();
		$("#phoneverifier_number").text("+976"+getPhoneNumberFromUserInput());
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
	
function isNumeric(value) {
    return /^-?\d+$/.test(value);
}
</script>

<div style="padding-left: 20px; padding-right: 20px; padding-top: 0px; width: 100%">
	<p style="font: bold 24px Arial">Нэвтрэх</p>
	<hr/>
	<div id="recaptcha-container"></div>
	<div id="phoneverifier_loading" style="width: 150px; margin-left: auto; margin-right: auto; text-align: center">
		<p>Та түр хүлээнэ үү...</p>
		<img src="Loading.gif" width="35" height="35" />
	</div>
	<div id="phoneentry_container" style="display: none">
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
		<div>
			<p id="loginError" style="color: #FF0004">Та үйлчилгээний нөхцөлийг зөвшөөрснөө баталж чагтална уу мөн өөрийгөө хүн гэдгээ батална уу!</p>
			<div style="display: flex">
				<button id="loginButtonFirebase" type="submit" class="button_yellow loginButton" style="font: normal 16px Arial; margin-left: 5px; margin-right: 5px" disabled>
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
</div>