<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
?>

<style>
.detail {
	float: left;
	width: 100%;
	margin-top: 10px; 
	margin-bottom: 10px; 
	margin-left: 5px;	
	margin-right: 5px;  
	font-family: RobotoRegular;
}

.detail .categories {
	color: #8f8f8f;
    font-size: 16px;
    line-height: 1.5;
	display: flex;
	align-items: center;
	cursor: pointer;
	margin-bottom: 10px;
}

.detail .categories .category {
	margin-left: 10px;
	margin-right: 10px;
}

.detail .categories .category:first-child {
	margin-left: 0px;
}
	
.detail .categories .category:hover {
	color: red;
}

.detail .title {
	font-family: RobotoBold;
    font-size: 36px;
    line-height: 40px;
    word-wrap: break-word;
    color: #000;
	margin-bottom: 15px;
}

.button_yellow.price {
	font-family: RobotoBold;
    font-size: 20px;
}
	
.button_yellow.phone {
	font-family: RobotoBold;
	font-size: 16px;
	color: white;
	margin-top: 10px; 
	background: #e60803;
}

.button_yellow.chatlah {
	font-family: RobotoBold;
	font-size: 16px;
	color: white;
	margin-top: 10px; 
	background: #e60803;
}

.importantLeft {
	margin-top: 10px;
	display: none;
}

.importantLeft .owner {
	margin-left: 10px;
}
	
.owner .name {
	font-size: 20px;
	font-family: RobotoRegular;
}
	
.owner .other_items {
	margin-top: 5px;
	font-size: 16px;
	text-decoration: underline;
	color: blue;
	cursor: pointer;
}
	
.importantRight {
	max-width: 180px;
	position: sticky;
	top: 20px;
}
	
.detailMain {
	display: flex;
}

.detailMain .left {
	width: 100%;
}

.detailMain .left .title {
	align-items: center;
	display: flex;
}
	
.detailMain .left .title .fa-star {
	margin-left: 10px;
	font-size: 28px;
	cursor: pointer;
}
	
.detailMain .left .title .fa-star:not(.nohover):hover {
	opacity: 0.9;
	color: #FFA718;
}
	
.detailMain .left .images {
	margin-top: 10px;
}
	
.detailMain .left .images .big {
	width: 100%;
	height: 450px;
	background: #e0e0e0;
	border-radius: 10px;
}

.detailMain .left .images .big img {
	width: 100%;
	height: 450px;
	border-radius: 10px;
	object-fit: contain;
}
	
.detailMain .left .images .big video {
	width: 100%;
	height: 450px;
	border-radius: 10px;
}

.detailMain .left .images .thumbnails {
	margin-top: 5px;
}
	
.detailMain .left .images .thumbnails img {
	width: 80px;
	height: 80px;
	object-fit:cover;
	border-radius: 5px;
	cursor: pointer;
}
	
.detailMain .left .images .thumbnails iframe {
	width: 80px;
	height: 80px;
	border-radius: 5px;
	cursor: pointer;
}
	
.detailMain .left .images .thumbnails video {
	width: 80px;
	height: 80px;
	border-radius: 5px;
	cursor: pointer;
}

.detailMain .left .words {
	margin-top: 10px;
	display: inline-block;
/*	justify-content: space-around;*/
	font-size: 16px;
	font-family: RobotoRegular;
	column-count: 2;
	width: 100%;
}

.detailMain .left .words div {
	margin-left: 5px;
	margin-right: 5px;
	margin-top: -1px;
	padding: 10px 0;
	border-top: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
	break-inside: avoid;
	width: 100%;
}
	
.detailMain .left .description {
	margin-top: 10px;
	margin-bottom: 10px;
	font-size: 16px;
    line-height: 21px;
}
	
.detailMain .right {
	margin-left: 10px;
	margin-right: 5px;
}
	
.detailMain .left .list .item {
	margin-left: 5px;
	margin-right: 5px;
	margin-top: 5px;
	margin-bottom: 10px;
	cursor: pointer;
	display: inline-block;
	vertical-align: top;
}
	
.detailMain .left .list .item .badge_vip {
	position: absolute;
	top: 0px;
	bottom: 0;
	left: 0;
	right: 0;
	pointer-events: none;
	overflow: hidden;
}
	
.detailMain .left .list .item .badge_vip::after {
	position: absolute;
    background-color: #f00;
    content: attr(data-top);
    left: -33px;
	top: 13px;
    height: 25px;
    width: 115px;
    -ms-transform: rotate(-45deg);
    transform: rotate(-45deg);
    font-size: 14px;
    color: #fff;
    font-family: 'Arial';
    line-height: 26px;
    text-align: center;
	box-shadow: 2px 2px 5px #888888;
}
	
.detailMain .left .list .item .badge_special {
	position: absolute;
	top: 0px;
	bottom: 0;
	left: 0;
	right: 0;
	pointer-events: none;
	overflow: hidden;
}
	
.detailMain .left .list .item .badge_special::after {
	position: absolute;
    background-color: #00d300;
    content: attr(data-top);
    left: -33px;
	top: 13px;
    height: 25px;
    width: 115px;
    -ms-transform: rotate(-45deg);
    transform: rotate(-45deg);
    font-size: 14px;
    color: #fff;
    font-family: 'Arial';
    line-height: 26px;
    text-align: center;
	box-shadow: 2px 2px 5px #888888;
}

.detailMain .left .list .item:hover {
	background: #f3f3f3;
	border-radius: 10px;
	box-shadow: 2px 2px 10px #888888;
}

.detailMain .left .list .item .image {
	width: 100%;
	height: 152px;
	background: #f3f3f3;
	border-radius: 10px;
	position: relative;
}
	
.detailMain .left .list .item .image img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	border-radius: 10px;
}

.detailMain .left .list .item .image iframe {
	width: 100%;
	height: 100%;
	border-radius: 10px;
}
	
.detailMain .left .list .item .image video {
	width: 100%;
	height: 152px;
	border-radius: 10px;
}

/* For Mobile */
@media screen and (max-width: 540px) {
	.detailMain .left .list .item {
		width: 165px;
	}
	
	.importantLeft {
		display: flex;
	}
	
	.right {
		display: none;
	}
}

/* For Tablets and Desktop */
@media screen and (min-width: 541px) {
	.detailMain .left .list .item {
		width: 190px;	
	}
}
	
.detailMain .left .list .item .image .count {
	color: white; 
	background: gray;
	opacity: 0.73; 
	font-size: 13px;
	padding: 5px;
	position: absolute;
	right: 0;
	border-bottom-left-radius: 5px;
	border-top-right-radius: 10px;
}

.detailMain .left .list .item .image .fa-star {
	position: absolute;
	right: 5px;
	bottom: 5px;
	font-size: 22px;
	opacity: 0.9;
	color: gray;
	z-index: 1;
}

.detailMain .left .list .item .image .fa-star:not(.nohover):hover {
	opacity: 0.9;
	color: #FFA718;
}

.detailMain .left .list .item .price {
	font: bold 18px Arial;
	margin-top: 5px;
	padding-left: 5px;
	padding-right: 5px;
}
	
.detailMain .left .list .item .title {
	font: normal 18px Arial;
	margin-top: 5px;
	padding-left: 5px;
	padding-right: 5px;
	padding-bottom: 3px !important;
	overflow: hidden;
	display: -webkit-box;
	-webkit-line-clamp: 3; /* number of lines to show */
		   line-clamp: 3; 
	-webkit-box-orient: vertical;
}
</style>

<script src="misc.js"></script>

<script>
$(document).ready(function() {
	incrementRate("item");
});

function showBigImage(type,id){
	$("#imageBig").empty();
	if(type == "image"){
		//class=\"watermark2\"
		$("#imageBig").append("<img src=\""+$("#thumbnail"+id).attr("src")+"\" />");
	}
	else if(type == "video"){
		$("#imageBig").append("<video controls=\"controls\" preload=\"metadata\"><source src=\""+id+"#t=0.5\" type=\""+findTypeOfVideo(id)+"\"></video>");
	}
}

function showPhone(){
	if($("div[id='phoneFull']").css('display')=='none'){
		$("div[id='phoneHidden']").hide();
		$("div[id='phoneFull']").show();
		incrementRate("phone");
	}
}
	
function incrementRate(type){
	$.post("mysql_item_increment.php",{type:type,id:<?php echo $_GET["id"]; ?>});
}
		   
function startChat(toID, message){
	var chatSubmitData = new FormData();
	chatSubmitData.append("fromID", <?php echo $_COOKIE["userID"]; ?>);
	chatSubmitData.append("toID", toID);
	chatSubmitData.append("type", 0);
	chatSubmitData.append("message", message);
	
	const reqChatSubmit = new XMLHttpRequest();
	reqChatSubmit.onload = function() {
		if(this.responseText=="OK"){
			sessionStorage.setItem("startChatToID", toID);
			pagenavigation("chat");
		}
	};
	reqChatSubmit.onerror = function(){
		console.log("<chat_send>:" + reqChatSubmit.status);
	};

	reqChatSubmit.open("POST", "chat_process.php", true);
	reqChatSubmit.send(chatSubmitData);		
}
	
function showOtherItems(userID){
	sessionStorage.setItem("searchUserID", userID);
	location.href = "./";
}
</script>

<div class="detail">
<?php
if(isset($_GET["id"])){
	$query = "SELECT *, (SELECT IF(COUNT(*)>0, 1, 0) FROM favorite WHERE itemID=item.id AND userID=".$_COOKIE["userID"].") AS isFavorite, item.phone AS item_phone FROM item RIGHT JOIN user ON user.id=item.userID WHERE item.id=".$_GET["id"];
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	
	//category
	$splita = explode("_", $row["category"]);
	$tableID = intval(substr($splita[0], 1));
	$id = intval($splita[1]);
	$arrCategories = array();
	for($i=$tableID; $i>=1; $i--){
		$queryCategory = "SELECT * FROM category".$i." WHERE id=".$id;
		$resultCategory = $conn->query($queryCategory);
		$rowCategory = mysqli_fetch_array($resultCategory);
//		$arrCategories["id"][] = "'c".$i."_".$id."'";
		$arrCategories["text"][] = $rowCategory["title"];
		if($i>1) $id = $rowCategory["parent"];
	}
//	$arrCategories["id"] = array_reverse($arrCategories["id"]);
	$arrCategories["id"] = fetchRecursiveCategories("'".$row["category"]."'", $conn, true);
	$arrCategories["text"] = array_reverse($arrCategories["text"]);
	
	//rate calculate
	$joinedCategories = implode(",",$arrCategories["id"]);
	$queryRateList = "SELECT *, (SELECT COUNT(*) FROM item WHERE category IN (".$joinedCategories.")) AS count_category, (SELECT COUNT(*) FROM item) AS count_global, ((item_viewer+phone_viewer)/2) AS average, (((item_viewer+phone_viewer)/2)/(SELECT COUNT(*) FROM item WHERE category IN (".$joinedCategories."))) AS rate_category, (((item_viewer+phone_viewer)/2)/(SELECT COUNT(*) FROM item)) AS rate_global FROM item WHERE category IN (".$joinedCategories.") AND id=".$_GET["id"]." ORDER BY rate_category DESC, rate_global DESC";
	$resultRateList = $conn->query($queryRateList);
	$rowRateList = mysqli_fetch_array($resultRateList);
	?>
	<div class="categories">
		<div class="category">Бүх зар</div> <i class="fas fa-angle-right" style="font-size: 12px" aria-hidden="true"></i>
		<?php
		for($i=0; $i<count($arrCategories["text"]); $i++){
			if($i!=count($arrCategories["text"])-1){
				echo "<div class=\"category\">".$arrCategories["text"][$i]."</div> <i class=\"fas fa-angle-right\" style=\"font-size: 12px\" aria-hidden=\"true\"></i> ";
			}
			else {
				echo "<div class=\"category\">".$arrCategories["text"][$i]."</div>";
			}
		}
		?>
	</div>
	<div class="detailMain">
		<div class="left">
			<div class="title">
				<?php 
				echo $row["title"]; 
				
				if($row["isFavorite"]==0){
					?>
					<i id="itemStar<?php echo $_GET["id"]; ?>" onClick="toggleFavorite(false,<?php echo $_GET["id"]; ?>)" class="fa-solid fa-star"></i>
					<?php
				}
				else if($row["isFavorite"]==1){
					?>
					<i id="itemStar<?php echo $_GET["id"]; ?>" onClick="toggleFavorite(true,<?php echo $_GET["id"]; ?>)" class="fa-solid fa-star nohover" style="color: rgb(255, 167, 24)"></i>
					<?php
				}
				?>
			</div>
			<div><?php echo $row["city"]; ?></div>
			<div class="data1" style="margin-top: 5px; display: flex">
				<div>Нийтэлсэн: <?php echo $row["datetime"]; ?></div>
				<div style="color: #a4a4a4; margin-left: 10px">Зарын дугаар: #<?php echo $row["id"]; ?></div>
			</div>
			<div class="data2" style="margin-top: 5px; display: flex; color: #a4a4a4">
				<div>Үзсэн: <i class="fa-solid fa-eye"></i> <?php echo $row["item_viewer"]; ?> <i class="fa-solid fa-phone"></i> <?php echo $row["phone_viewer"]; ?>,</div>
				<div style="margin-left: 5px">Эрэлт: <i class="fa-solid fa-star"></i> <?php echo number_format($rowRateList["rate_category"],1).", ".number_format($rowRateList["rate_global"],1); ?></div>
			</div>
			<div class="importantLeft">
				<div>
					<div class="button_yellow price">
						<div><?php echo convertPriceToText($row["price"]); ?> ₮</div>
					</div>
					<div onClick="showPhone()" class="button_yellow phone">
						<i class="fa-solid fa-phone"></i>
						<div id="phoneHidden" style="margin-left: 10px">
							<div>Дугаар харах</div>
							<div class="hided" style="display: flex; font-family:RobotoRegular; font-size: 14px"><?php echo substr($row["item_phone"],4,4); ?>-<div style="color: #FFA718">XXXX</div></div>
						</div>
						<div id="phoneFull" class="full" style="display: none; margin-left: 10px"><?php echo substr($row["item_phone"],4); ?></div>
					</div>
					<?php
					$message = "<b>".$row["title"]."</b><br/>";
					$message .= convertPriceToText($row["price"])." ₮<br/>";
					$message .= "#".$row["id"]."<br/>";
					$message .= implode(" > ",$arrCategories["text"]);
					?>
					<div onClick="startChat(<?php echo $row["userID"]; ?>,'<?php echo $message; ?>')" class="button_yellow chatlah" style="margin-top: 10px; background: #e60803">
						<i class="fa-solid fa-comments"></i>
						<div style="margin-left: 10px">Чатлах</div>
					</div>
				</div>
				<div class="owner">
					<div class="name"><?php echo $row["name"]; ?></div>
					<div onClick="showOtherItems(<?php echo $row["userID"]; ?>)" class="other_items">Зарын эзний бусад зарууд</div>
				</div>
			</div>
			<?php
			$queryImages = "SELECT * FROM images WHERE item=".$_GET["id"];
			$resultImages = $conn->query($queryImages);
			if(mysqli_num_rows($resultImages)>0 || $row["youtube"]!="" || $row["video"]!=""){
			?>
			<div class="images">
				<div id="imageBig" class="big"></div>
				<div class="thumbnails">
				<?php
				$i = 1;
				while($rowImages = mysqli_fetch_array($resultImages)){
					?>
					<img id="thumbnail<?php echo $i; ?>" onClick="showBigImage('image',<?php echo $i; ?>)" src="<?php echo $path; ?>/<?php echo $rowImages["image"]; ?>" />
					<?php
					$i++;
				}
				
				if($row["youtube"]!=""){
					echo "<iframe src=\"".$row["youtube"]."?controls=1\" frameborder=\"0\" allowfullscreen></iframe>";
				}
				
				if($row["video"]!=""){
					echo "<video onClick=\"showBigImage('video','".$path."/".$row["video"]."')\" preload=\"metadata\"><source src=\"".$path."/".$row["video"]."#t=0.5\" type=\"".findTypeOfVideo($row["video"])."\"></video>";
				}
				
				if(mysqli_num_rows($resultImages)>0){
					?>
					<script>showBigImage('image',1);</script>
					<?php
				}
				else if($row["video"]!="") {
					?>
					<script>showBigImage('video','<?php echo $path."/".$row["video"]; ?>');</script>
					<?php
				}
				?>
				</div>
			</div>
			<?php
			}
	
			?>
			<div class="words">
				<?php
				if($row["extras"]!="" && $row["extras"]!="[]"){
					$words = json_decode(stripslashes(strip_tags(htmlspecialchars_decode(html_entity_decode($row["extras"])))));
					foreach($words[0] as $key => $word){
						if($word!=""){
						?>
						<div><?php echo $key.": <b>".$word."</b>"; ?></div>
						<?php
						}
					}
				}
				if($row["address"]!=""){
				?>
				<div>Хаяг байршил: <?php echo "<b>".$row["address"]."</b>"; ?></div>
				<?php
				}
				$quality = $row["quality"]==0 ? "Шинэ" : "Хуучин";
				?>
				<div>Шинэ/хуучин: <?php echo "<b>".$quality."</b>"; ?></div>
			</div>
			<div class="description"><?php echo stripslashes(strip_tags(htmlspecialchars_decode(html_entity_decode($row["description"])))); ?></div>
			<hr/>
			<h3>Ижил зарууд</h3>
			<div class="list">
			<?php
			$queryOthers = "SELECT *, (SELECT IF(COUNT(*)>0, 1, 0) FROM favorite WHERE itemID=item.id AND userID=".$_COOKIE["userID"].") AS isFavorite, (SELECT image FROM images WHERE item.id=images.item LIMIT 1) AS image, (SELECT COUNT(*) FROM images WHERE item.id=images.item) AS count_images FROM item WHERE category IN (".$joinedCategories.") AND id NOT IN (".$_GET["id"].") AND isactive=4 ORDER BY datetime DESC LIMIT 12";
			$resultOthers = $conn->query($queryOthers);
			while($rowOthers = mysqli_fetch_array($resultOthers)){
				?>
				<div class="item">
					<div class="image">
						<?php
						if($rowOthers["status"]==2){
						?>
						<div class="badge_vip" data-top="VIP"></div>
						<?php
						}
						else if($rowOthers["status"]==1){
						?>
						<div class="badge_special" data-top="Онцгой"></div>
						<?php
						}
						if($rowOthers["count_images"]>0){
						?>
						<i class="count"><i class="fa-solid fa-camera"></i> <?php echo $rowOthers["count_images"]; ?></i>
						<?php
						}
						if($rowOthers["isFavorite"]==0){
						?>
						<i id="itemStar<?php echo $rowOthers["id"]; ?>" onClick="toggleFavorite(false,<?php echo $rowOthers["id"]; ?>)" class="fa-solid fa-star"></i>
						<?php
						}
						else if($rowOthers["isFavorite"]==1){
						?>
						<i id="itemStar<?php echo $rowOthers["id"]; ?>" onClick="toggleFavorite(true,<?php echo $rowOthers["id"]; ?>)" class="fa-solid fa-star nohover" style="color: rgb(255, 167, 24)"></i>
						<?php
						}
						?>
						<img src="<?php echo $path."/".$rowOthers["image"]; ?>" onerror="this.onerror=null; this.src='notfound.png'" />
					</div>
					<div onClick="javascript:pagenavigation('detail&id=<?php echo $rowOthers["id"]; ?>')">
						<div class="price"><?php echo convertPriceToText($rowOthers["price"]); ?> ₮</div>
						<div class="title"><?php echo $rowOthers["title"]; ?></div>
					</div>
				</div>
				<?php
			}
			?>
			</div>
		</div>
		<div class="right">
			<div class="importantRight">
				<div class="button_yellow price">
					<div><?php echo convertPriceToText($row["price"]); ?> ₮</div>
				</div>
				<div onClick="showPhone()" class="button_yellow phone">
					<i class="fa-solid fa-phone"></i>
					<div id="phoneHidden" style="margin-left: 10px">
						<div>Дугаар харах</div>
						<div class="hided" style="display: flex; font-family:RobotoRegular; font-size: 14px"><?php echo substr($row["item_phone"],4,4); ?>-<div style="color: #FFA718">XXXX</div></div>
					</div>
					<div id="phoneFull" class="full" style="display: none; margin-left: 10px"><?php echo substr($row["item_phone"],4); ?></div>
				</div>
				<div onClick="startChat(<?php echo $row["userID"]; ?>,'<?php echo $message; ?>')" class="button_yellow chatlah" style="margin-top: 10px; background: #e60803">
					<i class="fa-solid fa-comments"></i>
					<div style="margin-left: 10px">Чатлах</div>
				</div>
				<div class="owner" style="margin-top: 10px">
					<div class="name"><?php echo $row["name"]; ?></div>
					<div onClick="showOtherItems(<?php echo $row["userID"]; ?>)" class="other_items">Зарын эзний бусад зарууд</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>
</div>