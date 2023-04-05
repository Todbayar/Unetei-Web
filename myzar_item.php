<script src="myzar_item_add.js"></script>
<?php include "myzar_item_form.php"; ?>

<?php include "mysql_config.php"; ?>

<style>
.myzar_content_list_items {
	float: left;
	width: 100%;
}
	
.myzar_content_list_item .myzar_content_list_item_top {
	padding: 4px;
}
	
.myzar_content_list_item .myzar_content_list_item_top img {
	object-fit: cover; 
	background: #dddddd; 
	border-radius: 5px;
	min-width: 136px;
	min-height: 104px;
}

.myzar_content_list_item .myzar_content_list_item_bottom {
	float:left;
	background: #f3f3f3; 
	width: 100%;
}
	
/* For Mobile */
@media screen and (max-width: 540px) {
	.myzar_content_list_item .myzar_content_list_item_top img {
		width: 136px;
		height: 104px;
	}
}

/* For Tablets and Desktop */
/*@media screen and (min-width: 540px) and (max-width: 780px) {*/
@media screen and (min-width: 540px) {
	.myzar_content_list_item .myzar_content_list_item_top img {
		width: 170px;
		height: 130px;
	}
}
</style>

<script>
var tmpItem = new Object();

$(document).ready(function(){
	var urlParams = new URLSearchParams(window.location.search);
	var urlMyzarItemListState = urlParams.get('state');
	if(urlMyzarItemListState != null){
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " img").attr("src", "myzar_tab_list_item_" + urlMyzarItemListState + "_white.png");
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " i").css('color', '#ffffff');
		$(".myzar_tab_list_item_" + urlMyzarItemListState + " div").css('color', '#ffffff');
	}
	else {
		myzar_list_item_tab("all");
	}
});
	
function myzar_list_item_tab(state){
	if(location.href.includes("&state=")){
	   location.href = location.href.substring(0, location.href.lastIndexOf("&state=")) + "&state=" + state;
	}
	else {
		location.href += "&state=" + state;
	}
}
	
function myzar_category_selected_item_edit(id){
	var myZarItemListReqData = new FormData();
	myZarItemListReqData.append("id", id);

	const reqMyZarItemListData = new XMLHttpRequest();
	reqMyZarItemListData.onload = function() {
		const resultItemData = JSON.parse(this.responseText);
		myzar_item_categories(resultItemData.categories);
		$("#myzar_item_id").val(resultItemData.id)
		$("#myzar_item_title").val(resultItemData.title);
		$("#myzar_item_quality").val(resultItemData.quality);
		$("#myzar_item_address").val(resultItemData.address);
		$("#myzar_item_price").val(parseFloat(resultItemData.price));
		$("#myzar_item_youtube").val(resultItemData.youtube);
		$("#myzar_item_description").val(resultItemData.description);
		$("#myzar_item_city").val(resultItemData.city);
		$("#myzar_item_name").val(resultItemData.name);
		$("#myzar_item_email").val(resultItemData.email);
		$("#myzar_item_button div").html("Хадгалах");
		$("#myzar_item_button").attr("onClick", "myzar_item_edit_submit("+id+")");
		
		$("#myzar_item_images").find(".selectedimage").each(function(i, el){
			$(el).remove();
		});
		for(let i=0; i<resultItemData.images.length; i++){
			selectedImagesNames[selectedImagesIndex] = resultItemData.images[i].image;
			$("#myzar_item_images").append("<div class=\"selectedimage\" id=\"images"+selectedImagesIndex+"\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img src=\"Loading.gif\" width=\"24px\" height=\"24px\" style=\"margin-left: 48px; margin-top: 48px\" /><div>");
			$("#myzar_item_images div#images" + selectedImagesIndex + " img").remove();
			$("#myzar_item_images div#images" + selectedImagesIndex).html("<img name=\""+resultItemData.images[i].image+"\" src=\"user_files/"+resultItemData.images[i].image+"\" style=\"width: 100%; height: 100%; border-radius: 5px; object-fit: cover\" /><i onClick=\"myzar_item_images_remove("+selectedImagesIndex+")\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i>");
			selectedImagesIndex++;
		}
		
		$("#myzar_item_video").find("#video1").each(function(i, el){
			$(el).remove();
		});
		if(resultItemData.video != ""){
			selectedVideoName = resultItemData.video;
			var selectedVideoType = selectedVideoName.substring(selectedVideoName.lastIndexOf('.')+1);
			if(selectedVideoType == "mp4") selectedVideoType = "video/mp4";
			else if(selectedVideoType == "mov") selectedVideoType = "video/quicktime";
			$("#videoBrowseButton").hide();
			$("#myzar_item_video").append("<div id=\"video1\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img src=\"Loading.gif\" width=\"24px\" height=\"24px\" style=\"margin-left: 48px; margin-top: 48px\" /><div>");
			$("#myzar_item_video div#video1 img").remove();
			$("#myzar_item_video div#video1").html("<video name=\""+selectedVideoName+"\" width=\"100%\" height=\"100%\" controls=\"controls\" preload=\"metadata\" style=\"border-radius: 5px\"><source src=\"user_files/"+selectedVideoName+"#t=0.5\" type=\""+selectedVideoType+"\"></video><i onClick=\"myzar_item_video_remove()\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i>");
		}
	};
	reqMyZarItemListData.onerror = function() {
		console.log("<error>:" + reqMyZarItemListData.status);
	};
	reqMyZarItemListData.open("POST", "mysql_myzar_item_list_process.php", true);
	reqMyZarItemListData.send(myZarItemListReqData);
}
	
function myzar_item_edit_submit(id){
	var vItemEditTitle = $("#myzar_item_title").val();
	var vItemEditQuality = $("#myzar_item_quality").val();
	var vItemEditAddress = $("#myzar_item_address").val();
	var vItemEditPrice = $("#myzar_item_price").val();
	var vItemEditImages = JSON.stringify(selectedImagesNames);
	var vItemEditYoutube = $("#myzar_item_youtube").val();
	var vItemEditVideo = selectedVideoName;
	var vItemEditDescription = $("#myzar_item_description").val();
	var vItemEditCity = $("#myzar_item_city").val();
	var vItemEditName = $("#myzar_item_name").val();
	var vItemEditEmail = $("#myzar_item_email").val();

	if(vItemEditTitle === "") $("#myzar_item_title_error").show();
	if(vItemEditQuality == null) $("#myzar_item_quality_error").show();
	if(vItemEditPrice === "") $("#myzar_item_price_error").show();
	if(vItemEditDescription === "") $("#myzar_item_description_error").show();
	if(vItemEditCity == null) $("#myzar_item_city_error").show();
	if(vItemEditName === "") $("#myzar_item_name_error").show();

	if(vItemEditTitle !== "" && vItemEditQuality != null && vItemEditPrice !== "" && vItemEditDescription !== "" && vItemEditCity != null && vItemEditName !== ""){
		var myZarItemEditSubmitData = new FormData();
		myZarItemEditSubmitData.append("itemID", id);
		myZarItemEditSubmitData.append("category", "c" + selectedCategory.length + "_" + selectedCategory[selectedCategory.length-1]);
		myZarItemEditSubmitData.append("title", vItemEditTitle);
		myZarItemEditSubmitData.append("quality", vItemEditQuality);
		myZarItemEditSubmitData.append("address", vItemEditAddress);
		myZarItemEditSubmitData.append("price", vItemEditPrice);
		myZarItemEditSubmitData.append("images", vItemEditImages);
		myZarItemEditSubmitData.append("youtube", vItemEditYoutube);
		myZarItemEditSubmitData.append("video", vItemEditVideo);
		myZarItemEditSubmitData.append("description", vItemEditDescription);
		myZarItemEditSubmitData.append("city", vItemEditCity);
		myZarItemEditSubmitData.append("name", vItemEditName);
		myZarItemEditSubmitData.append("email", vItemEditEmail);

		const reqMyZarItemEdit = new XMLHttpRequest();
		reqMyZarItemEdit.onload = function() {
			if(this.responseText == "Fail"){
				alert("Зарыг нэмэх боломжгүй байна!");
			}
			else {
				location.reload();
			}
		};
		reqMyZarItemEdit.onerror = function(){
			console.log("<error>:" + reqMyZarItemEdit.status);
		};
		reqMyZarItemEdit.open("POST", "mysql_myzar_item_edit_process.php", true);
		reqMyZarItemEdit.send(myZarItemEditSubmitData);
	}
}
</script>

<?php
$queryFetchListItemsStateCountAll = "SELECT * FROM item WHERE userID=".$_COOKIE["userID"];
$resultFetchListItemsStateCountAll = $conn->query($queryFetchListItemsStateCountAll);
$countFetchListItemsStateCountAll = mysqli_num_rows($resultFetchListItemsStateCountAll);
mysqli_free_result($resultFetchListItemsStateCountAll);

$queryFetchListItemsStateCountActive = "SELECT * FROM item WHERE userID=".$_COOKIE["userID"]." AND isactive=4";
$resultFetchListItemsStateCountActive = $conn->query($queryFetchListItemsStateCountActive);
$countFetchListItemsStateCountActive = mysqli_num_rows($resultFetchListItemsStateCountActive);
mysqli_free_result($resultFetchListItemsStateCountActive);

$queryFetchListItemsStateCountReview = "SELECT * FROM item WHERE userID=".$_COOKIE["userID"]." AND isactive=1";
$resultFetchListItemsStateCountReview = $conn->query($queryFetchListItemsStateCountReview);
$countFetchListItemsStateCountReview = mysqli_num_rows($resultFetchListItemsStateCountReview);
mysqli_free_result($resultFetchListItemsStateCountReview);

$queryFetchListItemsStateCountArchive = "SELECT * FROM item WHERE userID=".$_COOKIE["userID"]." AND isactive=2";
$resultFetchListItemsStateCountArchive = $conn->query($queryFetchListItemsStateCountArchive);
$countFetchListItemsStateCountArchive = mysqli_num_rows($resultFetchListItemsStateCountArchive);
mysqli_free_result($resultFetchListItemsStateCountArchive);

$queryFetchListItemsStateCountDismiss = "SELECT * FROM item WHERE userID=".$_COOKIE["userID"]." AND isactive=3";
$resultFetchListItemsStateCountDismiss = $conn->query($queryFetchListItemsStateCountDismiss);
$countFetchListItemsStateCountDismiss = mysqli_num_rows($resultFetchListItemsStateCountDismiss);
mysqli_free_result($resultFetchListItemsStateCountDismiss);

$queryFetchListItemsStateCountInActive = "SELECT * FROM item WHERE userID=".$_COOKIE["userID"]." AND isactive=0";
$resultFetchListItemsStateCountInActive = $conn->query($queryFetchListItemsStateCountInActive);
$countFetchListItemsStateCountInActive = mysqli_num_rows($resultFetchListItemsStateCountInActive);
mysqli_free_result($resultFetchListItemsStateCountInActive);
?>

<div class="myzar_content_list_item_tabs" style="height: 50px; background: #77df42; display:flex; justify-content: space-between">
	<div class="myzar_tab_list_item_all" style="display: flex; align-items: center; margin-left: 20px; cursor: pointer" onClick="myzar_list_item_tab('all')">
		<img src="myzar_tab_list_item_all.png" width="32px" height="32px" />
		<div class="removable" style="margin-left: 5px">Бүгд</div>
		<?php if($countFetchListItemsStateCountAll > 0) {?><p style="margin-left: 5px"><?php echo $countFetchListItemsStateCountAll; ?></p><?php } ?>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_active" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('active')">
		<img src="myzar_tab_list_item_active.png" width="34px" height="34px" />
		<div class="removable" style="margin-left: 5px">Нийтлэгдсэн</div>
		<?php if($countFetchListItemsStateCountActive > 0) {?><p style="margin-left: 5px"><?php echo $countFetchListItemsStateCountActive; ?></p><?php } ?>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_review" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('review')">
		<img src="myzar_tab_list_item_review.png" width="30px" height="30px" />
		<div class="removable" style="margin-left: 5px">Шалгагдаж байгаа</div>
		<?php if($countFetchListItemsStateCountReview > 0) {?><p style="margin-left: 5px"><?php echo $countFetchListItemsStateCountReview; ?></p><?php } ?>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_archive" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('archive')">
		<i class="fa-solid fa-box-archive" style="font-size: 24px"></i>
		<div class="removable" style="margin-left: 5px">Архивлагдсан</div>
		<?php if($countFetchListItemsStateCountArchive > 0) {?><p style="margin-left: 5px"><?php echo $countFetchListItemsStateCountArchive; ?></p><?php } ?>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_dismiss" style="display: flex; align-items: center; cursor: pointer" onClick="myzar_list_item_tab('dismiss')">
		<i class="fa-solid fa-rotate-left" style="font-size: 24px"></i>
		<div class="removable" style="margin-left: 5px">Буцаагдсан</div>
		<?php if($countFetchListItemsStateCountDismiss > 0) {?><p style="margin-left: 5px"><?php echo $countFetchListItemsStateCountDismiss; ?></p><?php } ?>
	</div>
	<hr/>
	<div class="myzar_tab_list_item_inactive" style="display: flex; align-items: center; margin-right: 20px; cursor: pointer" onClick="myzar_list_item_tab('inactive')">
		<img src="myzar_tab_list_item_inactive.png" width="28px" height="28px" />
		<div class="removable" style="margin-left: 5px">Идэвхгүй</div>
		<?php if($countFetchListItemsStateCountInActive > 0) {?><p style="margin-left: 5px"><?php echo $countFetchListItemsStateCountInActive; ?></p><?php } ?>
	</div>
</div>

<div class="myzar_content_list_items">
	<?php
	$queryFetchListItems = "SELECT *, (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id LIMIT 1) AS image FROM item WHERE userID=".$_COOKIE["userID"];
	if((isset($_GET["myzar"]) && $_GET["myzar"] == "item") && (isset($_GET["state"]) && $_GET["state"] == "active")){
		$queryFetchListItems .= " AND isactive=4";
	}
	else if((isset($_GET["myzar"]) && $_GET["myzar"] == "item") && (isset($_GET["state"]) && $_GET["state"] == "review")){
		$queryFetchListItems .= " AND isactive=1";
	}
	else if((isset($_GET["myzar"]) && $_GET["myzar"] == "item") && (isset($_GET["state"]) && $_GET["state"] == "archive")){
		$queryFetchListItems .= " AND isactive=2";
	}
	else if((isset($_GET["myzar"]) && $_GET["myzar"] == "item") && (isset($_GET["state"]) && $_GET["state"] == "dismiss")){
		$queryFetchListItems .= " AND isactive=3";
	}
	else if((isset($_GET["myzar"]) && $_GET["myzar"] == "item") && (isset($_GET["state"]) && $_GET["state"] == "inactive")){
		$queryFetchListItems .= " AND isactive=0";
	}
	
	$resultFetchListItems = $conn->query($queryFetchListItems);
	while($rowFetchListItems = mysqli_fetch_array($resultFetchListItems)){
		$expire_datetime = date("Y-m-d H:i:s", strtotime("+".$rowFetchListItems["expire_days"]." day", strtotime($rowFetchListItems["datetime"])));
		$days_remain = (new DateTime($expire_datetime))->diff(new DateTime("now"))->format("%a");
	?>
	<div class="myzar_content_list_item">
		<table class="myzar_content_list_item_top" style="display: flex">
			<tr>
				<td valign="top" rowspan="2">
					<div class="myzar_item_list_image">						
						<img src="user_files/<?php echo $rowFetchListItems["image"]; ?>" />
						<i style="position: absolute; left: 12px; color: white; opacity: 0.73; font-size: 13px"><i class="fa-solid fa-camera"></i> <?php echo $rowFetchListItems["count_images"]; ?></i>
					</div>
				</td>
				<td valign="top" style="padding-left: 5px">
					<div class="myzar_content_list_item_title" style="font: bold 16px Arial"><?php echo $rowFetchListItems["title"]." (".number_format($rowFetchListItems["price"])." ₮)"; ?></div>
					<div class="myzar_content_list_item_expire" style="font: normal 14px Arial; color: #6ab001">Дуусах огноо: <?php echo $expire_datetime; ?>. Шинэчлэхэд <?php echo $days_remain; ?> өдөр дутуу.</div>
					<div class="myzar_content_list_item_category" style="font: normal 14px Arial; color: #999999">
						<?php
						$category = explode("_", $rowFetchListItems["category"]);
						$iteration = substr($category[0], 1, strlen($category[0]));
						$parent = 0;
						$hierCategory = array();
						for($i=$iteration; $i>=1; $i--){
							if($parent == 0){
								$queryFetchListItemCategory = "SELECT * FROM category".$i." WHERE id=".$category[1];
							}
							else {
								$queryFetchListItemCategory = "SELECT * FROM category".$i." WHERE id=".$parent;
							}
							
							$resultFetchListItemCategory = $conn->query($queryFetchListItemCategory);
							$rowFetchListItemCategory = mysqli_fetch_array($resultFetchListItemCategory);
							if($i>1) $parent = $rowFetchListItemCategory["parent"];
							$hierCategory[$i-1] = $rowFetchListItemCategory["title"];
						}
						for($i=0; $i<count($hierCategory); $i++){
							if($i<count($hierCategory)-1) echo $hierCategory[$i]." <i class=\"fas fa-angle-right\" style=\"font-size: 12px\"></i> ";
							else echo $hierCategory[$i];
						}
						?>
					</div>
				</td>
			</tr>
			<tr>
				<td style="padding-left: 5px">
					<div class="myzar_content_list_item_more" style="font: normal 13px Arial; color: #666666">Нийтэлсэн: <?php echo $rowFetchListItems["datetime"]; ?>, <i class="fa-solid fa-hashtag"></i><?php echo $rowFetchListItems["id"]; ?>, Үзсэн : <i class="fa-solid fa-eye"></i> <?php echo $rowFetchListItems["item_viewer"]; ?> <i class="fa-solid fa-phone"></i> <?php echo $rowFetchListItems["phone_viewer"]; ?></div>
				</td>
			</tr>
			<div class="myzar_content_list_item_detail" style="margin-left: 10px"></div>
		</table>
		<div class="myzar_content_list_item_bottom">
			<div class="button_yellow" style="float: left; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px">Онцгой зар болгох</div>
			</div>
			<div class="button_yellow" style="float: left; background: #a0cf0a; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: white">Шинэчлэх</div>
			</div>
			<div onClick="myzar_category_selected_item_edit(<?php echo $rowFetchListItems["id"]; ?>)" class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: #0086bf">Зараа засах</div>
			</div>
			<div class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: #0086bf">Архивлах</div>
			</div>
			<div class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: #0086bf">Устгах</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>