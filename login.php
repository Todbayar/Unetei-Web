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
			<input id="loginAgree" type="checkbox">
			<p style="margin-left: 10px">Би Unetei.mn сайтын үйлчилгээний нөхцөл, зар нийтлэх журмыг хүлээн зөвшөөрч, мөн өөрийгөө 18 нас хүрсэн болохыг баталж байна.</p>
		</div>
		<div id="recaptcha-container"></div>
		<div>
			<p id="loginError" style="color: #FF0004">Та үйлчилгээний нөхцөлийг зөвшөөрснөө баталж чагтална уу!</p>
			<button id="loginButton" class="button_yellow" type="button" style="font: normal 18px Arial" onClick="phoneAuth()">Мессежээр нэвтрэх</button>
		</div>
	</div>
	<div id="phoneverifier_container" style="display: none">
		<div>Таны утасруу баталгаажуулах код бүхий мессеж илгээгдлээ.<p id="phoneverifier_number"></p></div>
		<p>Доорх талбарт код оруулна уу.</p>
		<input type="text" id="phoneverificationcode" maxlength="6" pattern="[0-9]{6}" placeholder=" _ _ _ _ _ _" style="height: 30px; padding: 5px; font: bold 18px Arial">
		<br/>
		<p id="loginVerificationError" style="color: #FF0004"></p>
		<input type="button" id="verify" value="Үргэлжлүүлэх"  class="button_yellow" style="font: normal 18px Arial" onClick="phoneCodeVerify()">
	</div>
</div>

<script>
	render();
	function render() {
		window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
		recaptchaVerifier.render();
	}
	
	function phoneAuth() {
		var vPhoneRegex = new RegExp("^[0-9]{8}$");
		const vPhone = $("#loginPhone").val();
		const vAgree = $("#loginAgree").prop('checked');
		const vError = $("#loginError");

		if(vPhoneRegex.test(vPhone) && vAgree){
			const vValidPhone = "+976" + vPhone;
			firebase.auth().signInWithPhoneNumber(vValidPhone, window.recaptchaVerifier).then(function (confirmationResult) {
				window.confirmationResult = confirmationResult;
				coderesult = confirmationResult;
				$("#phoneentry_container").hide();
				$("#phoneverifier_container").show();
				$("#phoneverifier_number").text(vValidPhone);
			}).catch(function (error) {
				vError.text(error.message);
			});
		}
		else if(!vAgree && !vPhoneRegex.test(vPhone)) {
			vError.text("Та утасны дугаараа оруулаад үйлчилгээний нөхцөлийг чагталж зөвшөөрнө үү!");
		}
		else if(!vPhoneRegex.test(vPhone)) {
			vError.text("Та утасны дугаараа зөв оруулна уу!");
		}
		else {
			vError.text("Та үйлчилгээний нөхцөлийг зөвшөөрснөө баталж чагтална уу!");
		}
	}
	
	function phoneCodeVerify(){
		var code = document.getElementById('phoneverificationcode').value;
		coderesult.confirm(code).then(function(){
			firebase.auth().onAuthStateChanged(function(user) {
				if (user) {
//					var email = user.email;
//					var photoURL = user.photoURL;
//					var isAnonymous = user.isAnonymous;
//					var displayName = user.displayName;
//					var providerData = user.providerData;
//					var emailVerified = user.emailVerified;

					const loginSubmit = new XMLHttpRequest();
					
					loginSubmit.onload = function() {
						if(this.responseText.includes("OK")){
							location.href = "index.php";
						}
						else {
							$("#loginVerificationError").text(this.responseText);
						}
					};
					
					loginSubmit.onerror = function(){
						$("#loginVerificationError").text(loginSubmit.status);
					};
					
					loginSubmit.open("POST", "userLogin.php", true);
					
					var loginData = new FormData();
					loginData.append("uid", user.uid);
					loginData.append("phone", user.phoneNumber);

//					loginSubmit.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					loginSubmit.send(loginData);
				}
			});
		}).catch(function(){
			$("#loginVerificationError").text("Оруулсан баталгаажуулах код буруу байна, та дахин оролдоно уу!");			
		});
	}
</script>