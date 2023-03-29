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
</style>

<script>
	var selectedCategory = [];
	var selectedImagesIndex = 0;
	
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
					var readerImages = new FileReader();
					readerImages.onload = function(event) {
						$("#myzar_item_images").append("<div id=\"images"+selectedImagesIndex+"\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img src=\""+event.target.result+"\" style=\"width: 100%; height: 100%; border-radius: 5px\" /><i onClick=\"myzar_item_images_remove("+selectedImagesIndex+")\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i><div>");
						selectedImagesIndex++;
					};
					readerImages.readAsDataURL(vImages[i]);
				}
			}
			$("#myzar_item_images_input").val(null);
		});
	}
	
	function myzar_item_images_remove(index){
		$("#images"+index).remove();
	}
	
	function myzar_item_video_browse(){
		$("#myzar_item_video_input").trigger("click");
		$("#myzar_item_video_input").change(function(){
			var vVideoExtensions = ['video/quicktime', 'video/mp4'];
			var vVideo = $(this)[0].files[0];
			if($.inArray(vVideo.type.toLowerCase(), vVideoExtensions) > -1){
				if(vVideo.size <= 500*1024*1024){
					var readerVideo = new FileReader();
					readerVideo.onload = function(event) {
						$("#myzar_item_video").append("<div id=\"video1\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><video width=\"100%\" height=\"100%\" controls=\"controls\" preload=\"metadata\" style=\"border-radius: 5px\"><source src=\""+event.target.result+"#t=0.5\" type=\""+vVideo.type+"\"></video><i onClick=\"myzar_item_video_remove(1)\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i></div>");
						$("#videoBrowseButton").hide();
					};
					readerVideo.readAsDataURL(vVideo);
					$("#myzar_item_video_input").val(null);
				}
				else {
					alert("Файлын хэмжээ 500MB-аас их байна!");
				}
			}
			else {
				alert("mp4, mov файл биш байна!")
			}
		});
	}
	
	function myzar_item_video_remove(index){
		$("#video1").remove();
		$("#videoBrowseButton").show();
	}
</script>

<div class="myzar_content_add_item" style="display: none">
	<div class="myzar_content_add_item_selected_categories" style="margin-top: 10px; float: left; width: 100%"></div>
	<div class="myzar_content_add_item_container" style="float: left; width: 100%">
		<table width="100%">
			<tr>
				<td width="115px">Зарын гарчиг:</td>
				<td>
					<input id="myzar_item_title" type="text" maxlength="80" style="width: 95%; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Ижил зар оруулахыг хориглоно. Гарчигт хэрэглэхийг хориглосон үгсийг ашиглахгүй байна уу. Жишээ нь: хямдралтай, яаралтай, түрээслүүлнэ, хямдхан, гэх мэт.</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Шинэ/хуучин:</td>
				<td>
					<select id="myzar_item_condition" style="width: 150px; height: 35px; font: bold 16px Arial">
						<option value="" disabled selected>Сонгох</option>
						<option value="0">Шинэ</option>
						<option value="1">Хуучин</option>
					</select>
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Хаяг байршил:</td>
				<td>
					<input id="myzar_item_address" type="text" maxlength="200" style="width: 95%; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial"></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Үнэ:</td>
				<td>
					<input id="myzar_item_price" placeholder="₮" type="number" maxlength="10" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Үнийн дүнг бүх тэгтэй нь оруулна уу. Жишээ нь: 12 саяыг 12000000 гэж оруулна уу.</td>
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
					<input id="myzar_item_youtube" type="text" maxlength="200" style="width: 95%; height: 25px; padding: 5px; font: bold 16px Arial">
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
				<td width="115px" valign="top">Тайлбар:</td>
				<td>
					<textarea id="myzar_item_description" maxlength="10000" style="width: 95%; height: 100px; padding: 5px; font: bold 14px Arial"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Тайлбар хэсэгт зарлаж буй бараа, үйлчилгээнийхээ тухай товч тайлбар болон нэмэлт мэдээллээ бичнэ. Tайлбарт утасны дугаар оруулахгүй. Гарчиг болон тайлбар нь хоорондоо уялдаатай байна. Том үсэг болон товчлол ашиглахгүй байхыг хүсэе!</td>
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
				<td width="115px">Байрлал:</td>
				<td>
					<select id="myzar_item_city" style="width: 200px; height: 35px; font: bold 16px Arial">
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
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Нэр:</td>
				<td>
					<input id="myzar_item_name" type="text" maxlength="128" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Нэр хэсэгт хориглох зүйлс!: ганцхан үсэг, дан тоо, тэмдэгт, мөн худалдагч, админ, нэр, зарын эзэн, хэрэглэгч, user, apple, samsung, iphone, galaxy, lexus, toyota, г. м. үгсийг оруулхыг хориглоно.</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Имейл хаяг:</td>
				<td>
					<input id="myzar_item_email" type="text" maxlength="128" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Таны зарын тухай ирсэн мессэжний тухай мэдэгдэл очих болно.</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Утас:</td>
				<td>+97699213557</td>
			</tr>
		</table>
		<div class="button_yellow" style="margin-bottom: 10px; margin-top: 10px; height: 30px">
			<div style="margin-left: 5px; width: 100px; margin: 0 auto; text-transform: uppercase">Зар нэмэх</div>
		</div>
		<p style="margin-left: 5px; font: normal 14px Arial; color: #9F9F9F">Техникийн тусламжийг <b><?php echo $phone_service; ?></b> дугаарт холбогдож лавлана уу.<br/>"ЗАР НЭМЭХ" товчлуурыг дарснаар та Unetei.mn сайтын үйлчилгээний нөхцөл болон Монгол улсын холбогдох хууль тогтоомжийг хүлээн зөвшөөрч буй болно. Зар нэмэх Сайтын дүрэм, зар нийтлэх журам болон нууцлалын бодлого.</p>
	</div>
</div>