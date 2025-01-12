<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
?>
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
function selectCity(city){
	$("#myzar_item_city").val(city);
}

var tmpUserPhone, tmpUserName, tmpUserEmail;
$(document).ready(function(){
	$("#myzar_item_isNewUser").change(function(){
		if($("#myzar_item_isNewUser").is(':checked')){
			tmpUserPhone = $("#myzar_item_phone").val();
			$("#myzar_item_phone").val("");
			$("#myzar_item_phone").prop("disabled",false);
			
			tmpUserName = $("#myzar_item_name").val();
			$("#myzar_item_name").val("");
			$("#myzar_item_name").prop("disabled",false);
			
			tmpUserEmail = $("#myzar_item_email").val();
			$("#myzar_item_email").val("");
			$("#myzar_item_email").prop("disabled",false);
			
			$(".myzar_item_phone_label.required").show();
			$(".myzar_item_phone_label.notrequired").hide();
	   	}
		else {
			$("#myzar_item_phone").val(tmpUserPhone);
			$("#myzar_item_phone").prop("disabled",true);
			
			$("#myzar_item_name").val(tmpUserName);
			$("#myzar_item_name").prop("disabled",true);
			
			$("#myzar_item_email").val(tmpUserEmail);
			$("#myzar_item_email").prop("disabled",true);
			
			$(".myzar_item_phone_label.required").hide();
			$(".myzar_item_phone_label.notrequired").show();
		}
	});
});
</script>

<div id="information" style="display: none; margin: 10px auto; font-size: 16px; align-content: center; width: 100%"><div class="removable">Мэдээлэл</div><i id="type" class="fa-solid fa-circle-info" style="margin-left: 5px"></i><div style="margin-left: 5px">:</div><i id="icon" class="fa-solid fa-circle-plus" style="margin-left: 5px; color: #878787; display: none"></i><div id="message" style="color: #878787; margin-left: 5px"></div><div id="timer" style="color: #878787; margin-left: 5px"></div></div>

<div class="myzar_content_add_item" style="display: none">
	<input id="myzar_item_id" type="number" maxlength="255" style="display: none">
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
					<div id="myzar_item_title_error" style="display: none; color: #FF4649">Хоосон байж болохгүй эсвэл тоо байж болохгүй!</div>
					Ижил зар оруулахыг хориглоно. Гарчигт хэрэглэхийг хориглосон үгсийг ашиглахгүй байна уу. Жишээ нь: хямдралтай, яаралтай, түрээслүүлнэ, хямдхан, гэх мэт.
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px"><label>Шинэ/хуучин:</label></td>
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
		<div style="display: flex">
			<div style="margin-right: 5px">
				<div id="imagesBrowseButton" onClick="myzar_item_images_browse()" class="button_yellow">					
					<i class="fa-regular fa-image"></i>
					<div style="margin-left: 5px">Зураг</div>
				</div>
				<input type="file" id="myzar_item_images_input" name="myzar_item_images_input[]" required="true" accept="image/png, image/gif, image/jpeg, .svg" multiple style="display: none" />
			</div>
			<div id="myzar_item_images"></div>
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
				<td style="color: #9F9F9F; font: normal 14px Arial">
					<div id="myzar_item_youtube_error" style="display: none; color: #FF4649">youtube хаяг (url) буруу байна!</div>
				</td>
			</tr>
		</table>
		<div style="display: flex">
			<div style="margin-right: 10px">
				<?php
				if(getUserRole($_COOKIE["userID"])>=3){
				?>
				<div id="videoBrowseButton" onClick="myzar_item_video_browse()" class="button_yellow">
					<i class="fa-solid fa-video"></i>
					<div style="margin-left: 5px">Видео</div>
				</div>
				<?php
				}
				else {
				?>
				<div id="videoBrowseButton" onClick="javascript:confirmation_ok('Та хэрэглэгчийн эрхээ дээшлүүлнэ үү. <b>Тохиргоо</b> хэсэгт хэрэглэгчийн эрхээ дээшлүүлэх тохиргоо байгаа. (<?php echo $role_rank_superadmin.", ".$role_rank_admin; ?>)')" class="button_yellow">
					<i class="fa-solid fa-video"></i>
<!--					<i class="fa-solid fa-circle-plus"></i>-->
					<div style="margin-left: 5px">Видео</div>
				</div>
				<?php
				}
				?>
				<input type="file" id="myzar_item_videos_input" name="myzar_item_videos_input[]" required="true" accept="video/quicktime, video/mp4" style="display: none" />
			</div>
			<div id="myzar_item_video"></div>
		</div>
		<div id="myzar_item_extras"></div>
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
		<?php
		$queryFetchProfile = "SELECT * FROM user WHERE id=".$_COOKIE["userID"];
		$resultFetchProfile = $conn->query($queryFetchProfile);
		$rowFetchProfile = mysqli_fetch_array($resultFetchProfile);
		?>
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
					<?php
					if($rowFetchProfile["city"] != ""){
					?>
					<script>selectCity('<?php echo $rowFetchProfile["city"]; ?>')</script>
					<?php
					}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="font: normal 14px Arial"><div id="myzar_item_city_error" style="display: none; color: #FF4649">Сонголт хийнэ үү!</div></td>
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
		<hr/>
		<table class="myzar_item_isNewUser_table" width="100%">
			<tr>
				<td width="115px">Хэрэглэгч:</td>
				<td valign="middle" align="left">
					<div style="align-content: center; align-items: center">
						<?php
						if(getUserRole($_COOKIE["userID"])>=3){
							?>
							<input id="myzar_item_isNewUser" type="checkbox" style="border: 2px solid #c1c1c1; width: 10px; height: 10px; border-radius: 5px; transform:scale(2); margin:5px"></input>
							<label style="margin-left: 5px; font: normal 16px Arial">Өөр хүний нэр (шинэ хэрэглэгч/дагагч) дээр зарыг нэмэх</label>
							<?php
						}
						else {
							?>
							<input id="myzar_item_isNewUser" type="checkbox" style="border: 2px solid #c1c1c1; width: 10px; height: 10px; border-radius: 5px; transform:scale(2); margin:5px" disabled></input>
							<label style="margin-left: 5px; font: normal 16px Arial">Өөр хүний нэр (шинэ хэрэглэгч/дагагч) дээр зарыг нэмэх <i onClick="javascript:confirmation_ok('Та энэ үйлдэлийг хийхийн тулд хэрэглэгчийн эрх мэдлээ дээшлүүлнэ үү. <b>Тохиргоо</b> хэсэгт хэрэглэгчийн эрх мэдлээ дээшлүүлэх тохиргоо байгаа. <small>(<?php echo $role_rank_superadmin.", ".$role_rank_admin; ?>)</small>')" class="fa-solid fa-circle-info" style="color: #FFA718; margin-left: 5px"></i></label>
							<?php
						}
						?>
					</div>
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px"><label class="required">Нэр:</label></td>
				<td>
					<input id="myzar_item_name" type="text" maxlength="128" value="<?php if($rowFetchProfile["name"]!="") echo $rowFetchProfile["name"]; ?>" style="width: 85%; height: 25px; padding: 5px; font: normal 16px Arial" disabled>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">
					<div id="myzar_item_name_error" style="display: none; color: #FF4649">Хоосон байж болохгүй эсвэл тоо байж болохгүй!</div>
					Нэр хэсэгт хориглох зүйлс!: ганцхан үсэг, дан тоо, тэмдэгт, мөн худалдагч, админ, нэр, зарын эзэн, хэрэглэгч, user, apple, samsung, iphone, galaxy, lexus, toyota, г. м. үгсийг оруулхыг хориглоно.
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">
					<label class="myzar_item_phone_label required" style="display: none">Утас:</label>
					<label class="myzar_item_phone_label notrequired">Утас:</label>
				</td>
				<td valign="middle" align="left">
					<div style="align-content: center; align-items: center">
						<label style="margin-right: 5px; font: bold 16px Arial">+976</label>
						<?php
						if(getUserRole($_COOKIE["userID"]) == 0){
						?>
						<input id="myzar_item_phone" type="number" maxlength="12" style="width:60%; height: 25px; padding: 5px; font: normal 16px Arial" disabled value="<?php echo substr(getPhone($_COOKIE["userID"]), 4); ?>">
						<?php
						}
						else {
						?>
						<input id="myzar_item_phone" type="number" maxlength="12" style="width:60%; height: 25px; padding: 5px; font: normal 16px Arial" value="<?php echo substr(getPhone($_COOKIE["userID"]), 4); ?>" disabled>
						<?php
						}
						?>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">
					<div id="myzar_item_phone_error" style="display: none; color: #FF4649">Хоосон байж болохгүй эсвэл алдаатай утасны дугаар байна!</div>
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="115px">Имейл хаяг:</td>
				<td>
					<input id="myzar_item_email" type="email" maxlength="128" value="<?php if($rowFetchProfile["email"]!="") echo $rowFetchProfile["email"]; ?>" style="width: 85%; height: 25px; padding: 5px; font: normal 16px Arial" disabled>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">
					<div id="myzar_item_email_error" style="display: none; color: #FF4649">Таны оруулсан имейл буруу байна!</div>
					Таны зарын тухай мэдэгдэл имэйл хүлээн авах болно.
				</td>
			</tr>
		</table>
		<div id="myzar_item_button" onClick="myzar_item_add_submit()" class="button_yellow" style="margin-bottom: 10px; margin-top: 10px; height: 30px; font: bold 16px Arial">
			<div style="margin-left: 5px; width: 100px; margin: 0 auto; text-transform: uppercase">Зар нэмэх</div>
		</div>
		<p style="margin-left: 5px; font: normal 14px Arial; color: #9F9F9F">Техникийн тусламжийг <b><?php echo $service_phone; ?></b> дугаарт холбогдож лавлана уу.<br/>Товчлуурыг дарснаар та <?php echo $domain; ?> сайтын үйлчилгээний нөхцөл болон Монгол улсын холбогдох хууль тогтоомжийг хүлээн зөвшөөрч буй болно. Зар нэмэх Сайтын дүрэм, зар нийтлэх журам болон нууцлалын бодлого.</p>
	</div>
	<hr/>
</div>