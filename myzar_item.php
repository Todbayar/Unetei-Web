<script>
	var selectedCategory = [];
	
	$(document).ready(function(){
		if(sessionStorage.getItem("selectedCategoryHier") != null){
			const selectedCategoryHier = JSON.parse(sessionStorage.getItem("selectedCategoryHier"));
			for(let i=0; i<selectedCategoryHier.length; i++){
				console.log("<Selected>:" + i);
				if(selectedCategoryHier[i].icon != ""){
					$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd; height:18px\"><div style=\"display:flex\"><img src=\"./user_files/"+selectedCategoryHier[i].icon+"\" width=\"20px\" height=\"20px\" style=\"margin-left: 5px\" /><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
				}
				else {
					$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd; height:18px\"><div style=\"display:flex\"><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
				}
			}
		}
	});
</script>

<div class="myzar_content_add_item" style="width: 350px; margin: 0 auto">
	<div class="myzar_content_add_item_selected_categories" style="margin-top: 10px; float: left; width: 100%"></div>
	<div class="myzar_content_add_item_container" style="float: left; width: 100%">
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Зарын гарчиг:</td>
				<td width="65%">
					<input id="myzar_item_title" placeholder="80 тэмдэгт..." type="text" maxlength="80" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Гарчигт хэрэглэхийг хориглосон үгсийг ашиглахгүй байна уу. Жишээ нь: хямдралтай, яаралтай, түрээслүүлнэ, хямдхан, гэх мэт.</td>
			</tr>
		</table>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Шинэ/хуучин:</td>
				<td width="65%">
					<select id="myzar_item_condition" style="width: 150px; height: 35px; font: bold 16px Arial">
						<option value="" disabled selected>Сонгох</option>
						<option value="new">Шинэ</option>
						<option value="old">Хуучин</option>
					</select>
				</td>
			</tr>
		</table>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Хаяг байршил:</td>
				<td width="65%">
					<input id="myzar_item_address" type="text" maxlength="200" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial"></td>
			</tr>
		</table>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Үнэ:</td>
				<td width="65%">
					<input id="myzar_item_price" placeholder="₮" type="number" maxlength="20" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Үнийн дүнг бүх тэгтэй нь оруулна уу. Жишээ нь: 12 саяыг 12000000 гэж оруулна уу.</td>
			</tr>
		</table>
		<div style="margin-left: 10px; display: flex">
			<div style="margin-right: 10px">Зураг:</div>
			<div id="myzar_item_images">
				<div class="button_yellow" style="width: 50px; height: 50px; align-items: center; align-content: center; text-align: center; float: left; margin: 5px">
					<i class="fa-solid fa-plus"></i>
				</div>
				<div class="button_yellow" style="width: 50px; height: 50px; align-items: center; align-content: center; text-align: center; float: left; margin: 5px">
					<i class="fa-solid fa-plus"></i>
				</div>
				<div class="button_yellow" style="width: 50px; height: 50px; align-items: center; align-content: center; text-align: center; float: left; margin: 5px">
					<i class="fa-solid fa-plus"></i>
				</div>
			</div>
		</div>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Youtube URL:</td>
				<td width="65%">
					<input id="myzar_item_youtube" type="text" maxlength="200" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial"></td>
			</tr>
		</table>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%" valign="top">Тайлбар:</td>
				<td width="65%">
					<textarea id="myzar_item_description" maxlength="10000" style="width: 200px; height: 100px; padding: 5px; font: bold 14px Arial"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Тайлбар хэсэгт зарлаж буй бараа, үйлчилгээнийхээ тухай товч тайлбар болон нэмэлт мэдээллээ бичнэ. Tайлбарт утасны дугаар оруулахгүй. Гарчиг болон тайлбар нь хоорондоо уялдаатай байна. Том үсэг болон товчлол ашиглахгүй байхыг хүсэе!</td>
			</tr>
		</table>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Байрлал:</td>
				<td width="65%">
					<select id="myzar_item_city" style="width: 150px; height: 35px; font: bold 16px Arial">
						<option value="" disabled selected>Сонгох</option>
						<option value="Улаанбаатар">Улаанбаатар</option>
						<option value="Архангай">Архангай</option>
						<option value="Баян-өлгий">Баян-өлгий</option>
					</select>
				</td>
			</tr>
		</table>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Нэр:</td>
				<td width="65%">
					<input id="myzar_item_name" type="text" maxlength="128" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Нэр хэсэгт хориглох зүйлс!: ганцхан үсэг, дан тоо, тэмдэгт, мөн худалдагч, админ, нэр, зарын эзэн, хэрэглэгч, user, apple, samsung, iphone, galaxy, lexus, toyota, г. м. үгсийг оруулхыг хориглоно.</td>
			</tr>
		</table>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Имейл хаяг:</td>
				<td width="65%">
					<input id="myzar_item_email" type="text" maxlength="128" style="width: 200px; height: 25px; padding: 5px; font: bold 16px Arial">
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="color: #9F9F9F; font: normal 14px Arial">Таны зарын тухай ирсэн мессэжний тухай мэдэгдэл очих болно.</td>
			</tr>
		</table>
		<table style="margin-left: 10px" width="340px">
			<tr>
				<td width="35%">Утас:</td>
				<td width="65%">+97699213557</td>
			</tr>
		</table>
		<div class="button_yellow" style="margin-left: 10px">
			<i class="fa-solid fa-plus"></i>
			<div class="removable" style="margin-left: 5px">Зар нэмэх</div>
		</div>
	</div>
</div>