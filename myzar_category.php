<script>
	$(document).ready(function(){
		$("#myzar_category_add_icon").change(function(){
			const vIconType = $("#myzar_category_add_icon")[0].files[0].type;
			const vIconName = $("#myzar_category_add_icon")[0].files[0].name;
			console.log($("#myzar_category_add_icon")[0].files[0].name);
			if(vIconType == "image/svg+xml" || vIconType == "image/png"){
				$("#myzar_category_add_icon_file").text("Файл:" + vIconName);
				document.getElementById("myzar_category_add_icon_image").src = URL.createObjectURL($("#myzar_category_add_icon")[0].files[0]);
			}
			else {
				$("#myzar_category_add_icon").val(null);
				$("#myzar_category_add_icon_file").text('');
				document.getElementById("myzar_category_add_icon_image").src = "image-solid.svg";
			}
		});
	});
	
	function myzar_category_add_show(){
		$("#myzar_category_add_popup").show();
	}
	
	function myzar_category_add_close(){
		$("#myzar_category_add_popup").hide();
	}
	
	function myzar_category_add_icon_button(){
		$("#myzar_category_add_icon").trigger("click"); 
	}
	
	function myzar_category_add_submit(){
//		alert($('input[type=file]').val());	
		//image/svg+xml
//		alert("file:" + $("#myzar_category_add_icon")[0].files[0].name + ", " + $("#myzar_category_add_icon")[0].files[0].type);
	}
	
//	window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sign-in-button', {
//      'size': 'invisible',
//      'callback': function(response) {
//        // reCAPTCHA solved, allow signInWithPhoneNumber.
//        onSignInSubmit();
//      }
//    });
//
//    recaptchaVerifier.render().then(function(widgetId) {
//      window.recaptchaWidgetId = widgetId;
//      updateSignInButtonUI();
//    });
</script>

<div class="myzar_content_category">
	<div onClick="myzar_category_add_show()" class="button_yellow" style="margin:10px; width: 70px">
		<i class="fa-solid fa-plus"></i>
		<div style="margin-left: 5px">Нэмэх</div>
	</div>
	<hr/>
	<div onClick="myzar_category_add_show()" class="button_yellow" style="float: left; margin-left:10px; margin-right: 10px; background: #C4F1FF">
		<img src="tugrug.png" width="18px" height="18px" />
		<div style="margin-left: 5px">Нэмэх</div>
		<i class="fa-solid fa-circle-minus" style="color:#FF4649; margin-left: 10px; font-size: 20px"></i>
	</div>
</div>

<div id="myzar_category_add_popup" class="popup" style="width: 240px">
	<i class="fa-solid fa-circle-plus close" onClick="myzar_category_add_close()"></i>
	<div class="header">Ангилал</div>
	<div style="display: flex; align-items: center; margin-left: 10px; height: 50px">
		<img id="myzar_category_add_icon_image" src="image-solid.svg" width="24" height="24" onClick="myzar_category_add_icon_button()" />
		<input type="text" maxlength="30" placeholder="Бичих..." style="margin-left: 5px" />
	</div>
	<div id="myzar_category_add_icon_file" class="msg"></div>
	<div class="error" style="display: none">Error</div>
	<input type="file" name="myzar_category_add_icon" id="myzar_category_add_icon" required="true" accept="image/png, .svg" />
	<button onClick="myzar_category_add_submit()" disabled class="button_yellow" style="margin-top: 10px; margin-left: auto; margin-right: auto">Илгээх</button>
</div>