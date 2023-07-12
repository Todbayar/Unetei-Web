<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";
?>
<style>
.favorite {
	width: 100%;
	margin-left: 10px;
	margin-right: 10px;
}
	
.favorite .container .item {
	display: flex;
	border: solid 1px #ccc;
	padding-top: 5px;
	padding-bottom: 5px;
	padding: 10px;
	cursor: pointer;
}

.favorite .container .item:hover {
	background: #f3f3f3;
}
	
.favorite .container .item .favorite_right div {
	margin-bottom: 5px;
}
	
.favorite .container .item .image {
	position: relative;
	width: 165px;
	height: 152px;
	margin-right: 10px;
}
	
.favorite .container .item .image img {
	object-fit: cover; 
	background: #dddddd; 
	border-radius: 5px;
	width: 100%;
	height: 100%;
}
	
.favorite .container .item .image iframe {
	width: 100%;
	height: 100%;
	border-radius: 10px;
}
	
.favorite .container .item .image video {
	width: 100%;
	height: 100%;
	border-radius: 10px;
}

/* For Mobile */
@media screen and (max-width: 540px) {
	.favorite .container .item .image {
		min-width: 165px;
	}
	.favorite .container .item .image.right {
		display: block;
	}
	.favorite .container .item .image.left {
		display: none;
	}
}

/* For Tablets and Desktop */
@media screen and (min-width: 540px) {
	.favorite .container .item .image {
		min-width: 190px;	
	}
	.favorite .container .item .image.right {
		display: none;
	}
	.favorite .container .item .image.left {
		display: block;
	}
}
	
.favorite .container .item .image div {
	position: absolute;
	right: 3px;
	top: 3px;
	color: white; 
	opacity: 0.73; 
	font-size: 13px;
}
</style>

<script src="misc.js"></script>

<script>
$(document).ready(function(){
	$(".favorite .container .item").click(function(e){
		if(!$(e.target).is(".fa-star")){
			pagenavigation('detail/'+$(this).attr("id"));
	   	}
	});
});
</script>

<div class="favorite">
	<div class="container">
		<?php
		$queryList = "SELECT *, item.id AS item_id, (SELECT IF(COUNT(*)>0, 1, 0) FROM favorite WHERE itemID=item.id AND userID=".$_COOKIE["userID"].") AS isFavorite, (SELECT COUNT(*) FROM images WHERE item=item.id) AS count_images, (SELECT image FROM images WHERE item=item.id LIMIT 1) AS image FROM item RIGHT JOIN favorite ON item.id=favorite.itemID WHERE favorite.userID=".$_COOKIE["userID"]." AND item.isactive=4 ORDER BY favorite.id DESC";
		$resultList = $conn->query($queryList);
		while($rowList = mysqli_fetch_array($resultList)){
		?>
		<div class="item" id="<?php echo $rowList["item_id"]; ?>">
			<div class="image left">
				<?php
				if($rowList["image"]!=""){
				?>
				<img src="<?php echo $path."/".$rowList["image"]; ?>" onerror="this.onerror=null; this.src='notfound.png'">
				<div><i class="fa-solid fa-camera"></i> <?php echo $rowList["count_images"]; ?></div>
				<?php
				}
				else if($rowList["video"] != ""){
					$vVideoType = substr($rowList["video"], strrpos($rowList["video"], ".")+1);
					if($vVideoType == "mp4") $vVideoType = "video/mp4";
					else if($vVideoType == "mov") $vVideoType = "video/quicktime";
					?>
					<video controls="controls" preload="metadata" style="border-radius: 5px"><source src="<?php echo $path."/".$rowList["video"]; ?>#t=0.5" type="<?php echo $vVideoType; ?>"></video>
					<?php
				}
				else if($rowList["youtube"] != ""){
					?>
					<iframe src="<?php echo $rowList["youtube"]; ?>" allowfullscreen></iframe>
					<?php
				}
				else {
					?>
					<img src="notfound.png" onerror="this.onerror=null; this.src='image-solid.svg'">
					<?php
				}
				?>
			</div>
			<div class="favorite_right">
				<div class="image right">
					<?php
					if($rowList["image"]!=""){
					?>
					<img src="<?php echo $path."/".$rowList["image"]; ?>" onerror="this.onerror=null; this.src='notfound.png'">
					<div><i class="fa-solid fa-camera"></i> <?php echo $rowList["count_images"]; ?></div>
					<?php
					}
					else if($rowList["video"] != ""){
						$vVideoType = substr($rowList["video"], strrpos($rowList["video"], ".")+1);
						if($vVideoType == "mp4") $vVideoType = "video/mp4";
						else if($vVideoType == "mov") $vVideoType = "video/quicktime";
						?>
						<video controls="controls" preload="metadata" style="border-radius: 5px"><source src="<?php echo $path."/".$rowList["video"]; ?>#t=0.5" type="<?php echo $vVideoType; ?>"></video>
						<?php
					}
					else if($rowList["youtube"] != ""){
						?>
						<iframe src="<?php echo $rowList["youtube"]; ?>" allowfullscreen></iframe>
						<?php
					}
					else {
						?>
						<img src="notfound.png" onerror="this.onerror=null; this.src='image-solid.svg'">
						<?php
					}
					?>
				</div>
				<div class="title" style="font: bold 16px Arial">
					<?php echo $rowList["title"];
					if($rowList["isFavorite"]==0){
						?>
						<i id="itemStar<?php echo $rowList["item_id"]; ?>" onClick="toggleFavorite(false,<?php echo $rowList["item_id"]; ?>)" class="fa-solid fa-star"></i>
						<?php
					}
					else if($rowList["isFavorite"]==1){
						?>
						<i id="itemStar<?php echo $rowList["item_id"]; ?>" onClick="toggleFavorite(true,<?php echo $rowList["item_id"]; ?>)" class="fa-solid fa-star nohover" style="color: rgb(255, 167, 24)"></i>
						<?php
					}
					?>
				</div>
				<div class="price"><?php echo convertPriceToText($rowList["price"])." ₮"; ?></div>
				<div class="category" style="font: normal 14px Arial; color: #999999">
					<?php
					$category = explode("_", $rowList["category"]);
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
				<div class="description" style="font: normal 14px Arial"><?php echo $rowList["description"]; ?></div>
				<div class="address" style="font: normal 14px Arial"><?php echo $rowList["city"].", ".$rowList["address"]; ?></div>
				<div class="statistics" style="font: normal 13px Arial; color: #666666">
					Нийтэлсэн: <?php echo $rowList["datetime"]; ?>, <i class="fa-solid fa-hashtag"></i><?php echo $rowList["item_id"]; ?>, Үзсэн : <i class="fa-solid fa-eye"></i> <?php echo $rowList["item_viewer"]; ?> <i class="fa-solid fa-phone"></i> <?php echo $rowList["phone_viewer"]; ?>
				</div>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</div>