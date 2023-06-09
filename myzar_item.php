<script src="myzar_item_add.js"></script>
<script src="myzar_item_edit.js"></script>

<?php 
include "mysql_config.php";
include "myzar_item_form.php"; 
include_once "mysql_misc.php";
?>

<style>
.myzar_content_list_items {
	float: left;
	width: 100%;
}

.myzar_content_list_item {
	margin-bottom: 60px;
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
	
.myzar_content_list_item .myzar_content_list_item_top video {
	background: #dddddd; 
	border-radius: 5px;
	min-width: 136px;
	min-height: 104px;
}
	
.myzar_content_list_item .myzar_content_list_item_top iframe {
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
	.myzar_content_list_item .myzar_content_list_item_top video {
		width: 136px;
		height: 104px;
	}
	.myzar_content_list_item .myzar_content_list_item_top iframe {
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
	.myzar_content_list_item .myzar_content_list_item_top video {
		width: 170px;
		height: 130px;
	}
	.myzar_content_list_item .myzar_content_list_item_top iframe {
		width: 170px;
		height: 130px;
	}
}
</style>

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
	$queryFetchListItems = "SELECT *, (SELECT role FROM user WHERE id=item.userID) AS role, (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id LIMIT 1) AS image FROM item WHERE userID=".$_COOKIE["userID"];
	
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
	
	$queryFetchListItems .= " ORDER BY datetime DESC";
	
	$resultFetchListItems = $conn->query($queryFetchListItems);
	while($rowFetchListItems = mysqli_fetch_array($resultFetchListItems)){
		$expire_datetime = date("Y-m-d H:i:s", strtotime("+".$rowFetchListItems["expire_days"]." day", strtotime($rowFetchListItems["datetime"])));
		$days_remain = (new DateTime($expire_datetime))->diff(new DateTime("now"))->format("%a");
	?>
	<div class="myzar_content_list_item">
		<table class="myzar_content_list_item_top" style="display: flex">
			<tr>
				<?php
				if($rowFetchListItems["image"] != "" || $rowFetchListItems["youtube"] != "" || $rowFetchListItems["video"]) {
				?>
				<td valign="top" rowspan="2">
					<div class="myzar_item_list_image">
						<?php
						if($rowFetchListItems["image"] != ""){
						?>
							<img src="user_files/<?php echo $rowFetchListItems["image"]; ?>" />
							<i style="position: absolute; left: 12px; color: white; opacity: 0.73; font-size: 13px"><i class="fa-solid fa-camera"></i> <?php echo $rowFetchListItems["count_images"]; ?></i>
						<?php
						}
						else if($rowFetchListItems["video"] != ""){
							$vVideoType = substr($rowFetchListItems["video"], strrpos($rowFetchListItems["video"], ".")+1);
							if($vVideoType == "mp4") $vVideoType = "video/mp4";
							else if($vVideoType == "mov") $vVideoType = "video/quicktime";
							?>
							<video controls="controls" preload="metadata" style="border-radius: 5px"><source src="<?php echo $path."/".$rowFetchListItems["video"]; ?>#t=0.5" type="<?php echo $vVideoType; ?>"></video>
							<?php
						}
						else if($rowFetchListItems["youtube"] != ""){
							?>
							<iframe src="<?php echo $rowFetchListItems["youtube"]; ?>" allowfullscreen></iframe>
							<?php
						}
						?>
					</div>
				</td>
				<?php
				}
				?>
				<td valign="top" style="padding-left: 5px">
					<div class="myzar_content_list_item_title" style="font: bold 16px Arial"><?php echo $rowFetchListItems["title"]." (".convertPriceToText($rowFetchListItems["price"])." ₮)"; ?></div>
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
			<?php
			$splita = explode("_", $rowFetchListItems["category"]);
			$tableID = intval(substr($splita[0], 1));
			$id = intval($splita[1]);
			$categories = array();
			for($i=$tableID; $i>=1; $i--){
				$queryCategory = "SELECT * FROM category".$i." WHERE id=".$id;
				$resultCategory = $conn->query($queryCategory);
				$rowCategory = mysqli_fetch_array($resultCategory);
				$categories[] = $rowCategory["title"];
				if($i>1) $id = $rowCategory["parent"];
			}
			$categories = array_reverse($categories);
			?>
			<div onClick="myzar_item_update(<?php echo $rowFetchListItems["id"]; ?>,'<?php echo $rowFetchListItems["title"]; ?>','<?php echo implode(",",$categories); ?>',<?php echo $rowFetchListItems["role"]; ?>)" class="button_yellow" style="float: left; background: #a0cf0a; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: white">Шинэчлэх</div>
			</div>
			<div onClick="myzar_category_selected_item_edit(<?php echo $rowFetchListItems["id"]; ?>)" class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
				<div style="margin-left: 5px; color: #0086bf">Зараа засах</div>
			</div>
			<?php
			if(!isset($_GET["state"]) || (isset($_GET["state"]) && $_GET["state"] != "archive")){
			?>
				<div onClick="myzar_category_selected_item_archive(<?php echo $rowFetchListItems["id"]; ?>)" class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
					<div style="margin-left: 5px; color: #0086bf">Архивлах</div>
				</div>
			<?php
			}
			if(!isset($_GET["state"]) || (isset($_GET["state"]) && $_GET["state"] != "inactive")){
			?>
				<div onClick="myzar_category_selected_item_inactive(<?php echo $rowFetchListItems["id"]; ?>)" class="button_yellow" style="float: left; background: transparent; font-size: 14px; margin: 5px">
					<div style="margin-left: 5px; color: #0086bf">Устгах</div>
				</div>
			<?php
			}
			?>
		</div>
	</div>
	<?php
	}
	?>
</div>