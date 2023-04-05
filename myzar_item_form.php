<?php include "info.php"; ?>

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
				<td valign="middle" align="left">
					<div style="align-content: center; align-items: center">
						<label style="margin-right: 5px; font: bold 16px Arial">+976</label>
						<?php
						if($_COOKIE["role"] == 0){
						?>
						<input id="myzar_item_phone" type="number" maxlength="12" style="width:60%; height: 25px; padding: 5px; font: normal 16px Arial" disabled value="<?php echo substr($_COOKIE["phone"], 4); ?>">
						<?php
						}
						else {
						?>
						<input id="myzar_item_phone" type="number" maxlength="12" style="width:60%; height: 25px; padding: 5px; font: normal 16px Arial" value="<?php echo substr($_COOKIE["phone"], 4); ?>">
						<?php
						}
						?>
					</div>
				</td>
			</tr>
		</table>
		<div id="myzar_item_button" onClick="myzar_item_add_submit()" class="button_yellow" style="margin-bottom: 10px; margin-top: 10px; height: 30px; font: bold 16px Arial">
			<div style="margin-left: 5px; width: 100px; margin: 0 auto; text-transform: uppercase">Зар нэмэх</div>
		</div>
		<p style="margin-left: 5px; font: normal 14px Arial; color: #9F9F9F">Техникийн тусламжийг <b><?php echo $phone_service; ?></b> дугаарт холбогдож лавлана уу.<br/>"ЗАР НЭМЭХ" товчлуурыг дарснаар та Unetei.mn сайтын үйлчилгээний нөхцөл болон Монгол улсын холбогдох хууль тогтоомжийг хүлээн зөвшөөрч буй болно. Зар нэмэх Сайтын дүрэм, зар нийтлэх журам болон нууцлалын бодлого.</p>
	</div>
	<hr/>
</div>