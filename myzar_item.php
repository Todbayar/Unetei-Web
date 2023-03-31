<?php include "info.php" ?>
<style>
/* For Mobile */
@media screen and (max-width: 540px) {
	.myzar_content_add_item {
		width: 350px;
		margin: 0 auto;
	}
}

/* For Tablets and Desktop */
/*@media screen and (min-width: 540px) and (max-width: 780px) {*/
@media screen and (min-width: 540px) {
	.myzar_content_add_item {
		width: 550px;
		margin: 0 auto;
	}
}
	
label.required::after {
	content: '*';
	position: absolute;
/*
	right: 0;
	top: -7px;
*/
	color: #c00;
	font-family: 'RobotoRegular'
}
</style>

<script>
	var selectedCategory = [];
	var selectedImagesIndex = 0;
	var selectedImagesNames = [];
	var selectedVideoName;
	
	function initMap() {
	  const myLatLng = { lat: 47.919126, lng: 106.917510 };
	  const map = new google.maps.Map(document.getElementById("map"), {
		zoom: 4,
		center: myLatLng,
	  });

	  new google.maps.Marker({
		position: myLatLng,
		map,
		title: "Hello World!",
	  });
	}

	window.initMap = initMap;
	
	$(document).ready(function(){
		if(sessionStorage.getItem("selectedCategoryHier") != null){
			const selectedCategoryHier = JSON.parse(sessionStorage.getItem("selectedCategoryHier"));
			for(let i=0; i<selectedCategoryHier.length; i++){
				selectedCategory[i] = selectedCategoryHier[i].id;
				if(selectedCategoryHier[i].icon != ""){
					$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd; height:18px\"><div style=\"display:flex\"><img src=\"./user_files/"+selectedCategoryHier[i].icon+"\" width=\"20px\" height=\"20px\" style=\"margin-left: 5px\" /><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
				}
				else {
					$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd; height:18px\"><div style=\"display:flex\"><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
				}
			}
			$(".myzar_content_add_item").show();
//			sessionStorage.removeItem("selectedCategoryHier");
		};
	});
	
	function myzar_item_images_browse(){
		$("#myzar_item_images_input").trigger("click");
		$("#myzar_item_images_input").change(function(){
			var vImageExtensions = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
			var vImages = $(this)[0].files;
			for(let i=0; i<vImages.length; i++){
				if($.inArray(vImages[i].type.toLowerCase(), vImageExtensions) > -1){
					var myZarItemAddImageSubmitData = new FormData();
					myZarItemAddImageSubmitData.append("file", vImages[i]);
					myZarItemAddImageSubmitData.append("index", selectedImagesIndex);
					
					const reqMyZarItemImageAddSubmit = new XMLHttpRequest();
					reqMyZarItemImageAddSubmit.onload = function() {
						if(!this.responseText.includes("Fail")){
							var obj = JSON.parse(this.responseText);
							var index = obj.index;
							var name = obj.name;
							var path = obj.path;
							selectedImagesNames[index] = name;
							$("#myzar_item_images div#images" + index + " img").remove();
							$("#myzar_item_images div#images" + index).html("<img name=\""+name+"\" src=\""+path+"/"+name+"\" style=\"width: 100%; height: 100%; border-radius: 5px\" /><i onClick=\"myzar_item_images_remove("+index+")\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i>");
						}
						else {
							$("#myzar_item_images div#images" + index).remove();
						}
					};
					
					$("#myzar_item_images").append("<div id=\"images"+selectedImagesIndex+"\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img src=\"Loading.gif\" width=\"24px\" height=\"24px\" style=\"margin-left: 48px; margin-top: 48px\" /><div>");
					selectedImagesIndex++;
					
					reqMyZarItemImageAddSubmit.open("POST", "file_upload.php", true);
					reqMyZarItemImageAddSubmit.send(myZarItemAddImageSubmitData);
				}
			}
			$("#myzar_item_images_input").val(null);
		});
	}
	
	function myzar_item_images_remove(index){
		var myZarItemAddImageRemoveSubmitData = new FormData();
		myZarItemAddImageRemoveSubmitData.append("file", selectedImagesNames[index]);

		const reqMyZarItemImageRemoveSubmit = new XMLHttpRequest();
		reqMyZarItemImageRemoveSubmit.onload = function() {
			if(!this.responseText.includes("Fail")){
				$("#images"+index).remove();
				selectedImagesNames[index] = "";
			}
		};

		reqMyZarItemImageRemoveSubmit.open("POST", "file_remove.php", true);
		reqMyZarItemImageRemoveSubmit.send(myZarItemAddImageRemoveSubmitData);
	}
	
	function myzar_item_video_browse(){
		$("#myzar_item_video_input").trigger("click");
		$("#myzar_item_video_input").change(function(){
			var vVideoExtensions = ['video/quicktime', 'video/mp4'];
			var vVideo = $(this)[0].files[0];
			if($.inArray(vVideo.type.toLowerCase(), vVideoExtensions) > -1){
				if(vVideo.size <= 500*1024*1024){					
					var myZarItemAddVideoSubmitData = new FormData();
					myZarItemAddVideoSubmitData.append("file", vVideo);
					myZarItemAddVideoSubmitData.append("index", 1);
					
					const reqMyZarItemVideoAddSubmit = new XMLHttpRequest();
					reqMyZarItemVideoAddSubmit.onload = function() {
						console.log("<myzar_item_video_browse>:" + this.responseText);
						if(!this.responseText.includes("Fail")){
							var obj = JSON.parse(this.responseText);
							var index = obj.index;
							var name = obj.name;
							var path = obj.path;
							selectedVideoName = name;
							$("#myzar_item_video div#video1 img").remove();
							$("#myzar_item_video div#video1").html("<video name=\""+name+"\" width=\"100%\" height=\"100%\" controls=\"controls\" preload=\"metadata\" style=\"border-radius: 5px\"><source src=\""+path+"/"+name+"#t=0.5\" type=\""+vVideo.type+"\"></video><i onClick=\"myzar_item_video_remove()\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i>");
						}
						else {
							$("#myzar_item_video div#video1").remove();
							$("#videoBrowseButton").show();
						}
					};
					
					reqMyZarItemVideoAddSubmit.onerror = function(){
						console.log("<myzar_item_video_browse>:" + reqMyZarItemVideoAddSubmit.status + ", " + reqMyZarItemVideoAddSubmit.statusText);
					};
					
					$("#videoBrowseButton").hide();
					$("#myzar_item_video").append("<div id=\"video1\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img src=\"Loading.gif\" width=\"24px\" height=\"24px\" style=\"margin-left: 48px; margin-top: 48px\" /><div>");
					
					reqMyZarItemVideoAddSubmit.open("POST", "file_upload.php", true);
					reqMyZarItemVideoAddSubmit.send(myZarItemAddVideoSubmitData);
				}
				else {
					alert("Файлын хэмжээ 500MB-аас их байна!");
				}
			}
			else {
				alert("mp4, mov файл биш байна!")
			}
			$("#myzar_item_video_input").val(null);
		});
	}
	
	function myzar_item_video_remove(){
		var myZarItemAddVideoRemoveSubmitData = new FormData();
		myZarItemAddVideoRemoveSubmitData.append("file", selectedVideoName);

		const reqMyZarItemVideoRemoveSubmit = new XMLHttpRequest();
		reqMyZarItemVideoRemoveSubmit.onload = function() {
			if(!this.responseText.includes("Fail")){
				selectedVideoName = "";
				$("#video1").remove();
				$("#videoBrowseButton").show();
			}
		};

		reqMyZarItemVideoRemoveSubmit.open("POST", "file_remove.php", true);
		reqMyZarItemVideoRemoveSubmit.send(myZarItemAddVideoRemoveSubmitData);
	}
	
	function myzar_item_add_submit(){
		var vItemAddTitle = $("#myzar_item_title").val();
		var vItemAddQuality = $("#myzar_item_quality").val();
		var vItemAddAddress = $("#myzar_item_address").val();
		var vItemAddPrice = $("#myzar_item_price").val();
		var vItemAddImages = JSON.stringify(selectedImagesNames);
		var vItemAddYoutube = $("#myzar_item_youtube").val();
		var vItemAddVideo = selectedVideoName;
		var vItemAddDescription = $("#myzar_item_description").val();
		var vItemAddCity = $("#myzar_item_city").val();
		var vItemAddName = $("#myzar_item_name").val();
		var vItemAddEmail = $("#myzar_item_email").val();
		
		if(vItemAddTitle === "") $("#myzar_item_title_error").show();
		if(vItemAddQuality == null) $("#myzar_item_quality_error").show();
		if(vItemAddPrice === "") $("#myzar_item_price_error").show();
		if(vItemAddDescription === "") $("#myzar_item_description_error").show();
		if(vItemAddCity == null) $("#myzar_item_city_error").show();
		if(vItemAddName === "") $("#myzar_item_name_error").show();
		
		if(vItemAddTitle !== "" && vItemAddQuality != null && vItemAddPrice !== "" && vItemAddDescription !== "" && vItemAddCity != null && vItemAddName !== ""){
			var myZarItemAddSubmitData = new FormData();
			myZarItemAddSubmitData.append("uid", sessionStorage.getItem("uid"));
			myZarItemAddSubmitData.append("category", "c" + selectedCategory.length + "_" + selectedCategory[selectedCategory.length-1]);
			myZarItemAddSubmitData.append("title", vItemAddTitle);
			myZarItemAddSubmitData.append("quality", vItemAddQuality);
			myZarItemAddSubmitData.append("address", vItemAddAddress);
			myZarItemAddSubmitData.append("price", vItemAddPrice);
			myZarItemAddSubmitData.append("images", vItemAddImages);
			myZarItemAddSubmitData.append("youtube", vItemAddYoutube);
			myZarItemAddSubmitData.append("video", vItemAddVideo);
			myZarItemAddSubmitData.append("description", vItemAddDescription);
			myZarItemAddSubmitData.append("city", vItemAddCity);
			myZarItemAddSubmitData.append("name", vItemAddName);
			myZarItemAddSubmitData.append("email", vItemAddEmail);
			
			const reqMyZarItemAdd = new XMLHttpRequest();
			reqMyZarItemAdd.onload = function() {
				console.log(this.responseText);
			};
			reqMyZarItemAdd.onerror = function(){
				console.log("<error>:" + reqMyZarItemAdd.status);
			};
			reqMyZarItemAdd.open("POST", "mysql_myzar_item_add_process.php", true);
			reqMyZarItemAdd.send(myZarItemAddSubmitData);
		}
	}
</script>

<div class="myzar_content_add_item" style="display: none">
	<div class="myzar_content_add_item_selected_categories" style="margin-top: 10px; float: left; width: 100%"></div>
	<div class="myzar_content_add_item_container" style="float: left; width: 100%">
		<table width="100%">
			<tr>
				<td width="115px"><label class="required">Зарын гарчиг:</label></td>
				<td>
					<input id="myzar_item_title" type="text" maxlength="80" style="width: 95%; height: 25px; padding: 5px; font: normal 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">
					<div id="myzar_item_title_error" style="display: none; color: #FF4649">Хоосон байж болохгүй!</div>
					Ижил зар оруулахыг хориглоно. Гарчигт хэрэглэхийг хориглосон үгсийг ашиглахгүй байна уу. Жишээ нь: хямдралтай, яаралтай, түрээслүүлнэ, хямдхан, гэх мэт.
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px"><label class="required">Шинэ/хуучин:</label></td>
				<td>
					<select id="myzar_item_quality" style="width: 150px; height: 35px; font: normal 16px Arial">
						<option value="" disabled selected>Сонгох</option>
						<option value="0">Шинэ</option>
						<option value="1">Хуучин</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="font: normal 14px Arial"><div id="myzar_item_quality_error" style="display: none; color: #FF4649">Сонголт хийнэ үү!</div></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Хаяг байршил:</td>
				<td>
					<input id="myzar_item_address" type="text" maxlength="200" style="width: 95%; height: 25px; padding: 5px; font: normal 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial"></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px"><label class="required">Үнэ:</label></td>
				<td>
					<input id="myzar_item_price" placeholder="₮" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="20" style="width: 200px; height: 25px; padding: 5px; font: normal 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">
					<div id="myzar_item_price_error" style="display: none; color: #FF4649">Хоосон байж болохгүй!</div>
					Үнийн дүнг бүх тэгтэй нь оруулна уу. Жишээ нь: 12 саяыг 12000000 гэж оруулна уу.
				</td>
			</tr>
		</table>
		<div style="margin-left: 10px; display: flex">
			<div style="margin-right: 10px">Зураг:
				<input type="file" id="myzar_item_images_input" name="myzar_item_images_input[]" required="true" accept="image/png, image/gif, image/jpeg, .svg" multiple style="display: none" />
			</div>
			<div id="myzar_item_images">
				<div onClick="myzar_item_images_browse()" class="button_yellow" style="background-color:#dddddd; width: 100px; height: 100px; align-items: center; align-content: center; text-align: center; float: left; margin: 5px">
					<i class="fa-solid fa-plus" style="width: 10px; margin: 0 auto"></i>
				</div>
			</div>
		</div>
		<table width="100%">
			<tr>
				<td width="115px">Youtube URL:</td>
				<td>
					<input id="myzar_item_youtube" type="text" maxlength="200" style="width: 95%; height: 25px; padding: 5px; font: normal 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial"></td>
			</tr>
		</table>
		<div style="margin-left: 10px; display: flex">
			<div style="margin-right: 10px">Видео:
				<input type="file" id="myzar_item_video_input" name="myzar_item_video_input" required="true" accept="video/quicktime, video/mp4" multiple style="display: none" />
			</div>
			<div id="myzar_item_video">
				<div id="videoBrowseButton" onClick="myzar_item_video_browse()" class="button_yellow" style="background-color:#dddddd; width: 100px; height: 100px; align-items: center; align-content: center; text-align: center; float: left; margin: 5px">
					<i class="fa-solid fa-plus" style="width: 10px; margin: 0 auto"></i>
				</div>
			</div>
		</div>
		<table width="100%">
			<tr>
				<td width="115px" valign="top"><label class="required">Тайлбар:</label></td>
				<td>
					<textarea id="myzar_item_description" maxlength="10000" style="width: 95%; height: 100px; padding: 5px; font: normal 14px Arial"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">
					<div id="myzar_item_description_error" style="display: none; color: #FF4649">Хоосон байж болохгүй!</div>
					Тайлбар хэсэгт зарлаж буй бараа, үйлчилгээнийхээ тухай товч тайлбар болон нэмэлт мэдээллээ бичнэ. Tайлбарт утасны дугаар оруулахгүй. Гарчиг болон тайлбар нь хоорондоо уялдаатай байна. Том үсэг болон товчлол ашиглахгүй байхыг хүсэе!
				</td>
			</tr>
		</table>
		<div style="margin-left: 10px; display: none">
			<div style="margin-right: 10px">Газрын зураг:</div>
			<div id="myzar_item_map">
				<div id="map" style="width: 350px; height: 250px"></div>
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly" defer></script>
			</div>
		</div>
		<table width="100%">
			<tr>
				<td width="115px"><label class="required">Байрлал:</label></td>
				<td>
					<select id="myzar_item_city" style="width: 200px; height: 35px; font: normal 16px Arial">
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
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="font: normal 14px Arial"><div id="myzar_item_city_error" style="display: none; color: #FF4649">Сонголт хийнэ үү!</div></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px"><label class="required">Нэр:</label></td>
				<td>
					<input id="myzar_item_name" type="text" maxlength="128" style="width: 85%; height: 25px; padding: 5px; font: normal 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">
					<div id="myzar_item_name_error" style="display: none; color: #FF4649">Хоосон байж болохгүй!</div>
					Нэр хэсэгт хориглох зүйлс!: ганцхан үсэг, дан тоо, тэмдэгт, мөн худалдагч, админ, нэр, зарын эзэн, хэрэглэгч, user, apple, samsung, iphone, galaxy, lexus, toyota, г. м. үгсийг оруулхыг хориглоно.
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Имейл хаяг:</td>
				<td>
					<input id="myzar_item_email" type="email" maxlength="128" style="width: 85%; height: 25px; padding: 5px; font: normal 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">
					Таны зарын тухай ирсэн мессэжний тухай мэдэгдэл очих болно.
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Утас:</td>
				<td style="font: bold 16px Arial">+97699213557</td>
			</tr>
		</table>
		<div onClick="myzar_item_add_submit()" class="button_yellow" style="margin-bottom: 10px; margin-top: 10px; height: 30px; font: bold 16px Arial">
			<div style="margin-left: 5px; width: 100px; margin: 0 auto; text-transform: uppercase">Зар нэмэх</div>
		</div>
		<p style="margin-left: 5px; font: normal 14px Arial; color: #9F9F9F">Техникийн тусламжийг <b><?php echo $phone_service; ?></b> дугаарт холбогдож лавлана уу.<br/>"ЗАР НЭМЭХ" товчлуурыг дарснаар та Unetei.mn сайтын үйлчилгээний нөхцөл болон Монгол улсын холбогдох хууль тогтоомжийг хүлээн зөвшөөрч буй болно. Зар нэмэх Сайтын дүрэм, зар нийтлэх журам болон нууцлалын бодлого.</p>
	</div>
</div>