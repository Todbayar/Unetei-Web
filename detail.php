<?php
include "mysql_config.php";
include_once "mysql_misc.php";
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
	margin-top: 10px; 
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
	max-width: 180px;
}
.importantLeft .favorite {
	color: #a4a4a4;
}

.importantRight {
	max-width: 180px;
}
	
.detailMain {
	display: flex;
}

.detailMain .right {
	margin-left: 20px;
}
</style>

<div class="detail">
<?php
if(isset($_GET["id"])){
	$query = "SELECT * FROM item WHERE id=".$_GET["id"];
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
		if($i>1) $id = $rowCategory["parent"];
		$arrCategories["id"][] = "'c".$i."_".$id."'";
		$arrCategories["text"][] = $rowCategory["title"];
	}
	$arrCategories["id"] = array_reverse($arrCategories["id"]);
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
			<div class="title"><?php echo $row["title"]; ?></div>
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
				<i class="favorite fa-regular fa-star"></i>
				<div class="button_yellow price">
					<div><?php echo convertPriceToText($row["price"]); ?> ₮</div>
				</div>
				<div class="button_yellow phone">
					<i class="fa-solid fa-phone"></i>
					<div style="margin-left: 10px">
						<div>Дугаар харах</div>
						<div class="hided" style="display: flex; font-family:RobotoRegular; font-size: 14px"><?php echo substr($row["phone"],4,4); ?>-<div style="color: #FFA718">XXXX</div></div>
					</div>
					<div class="full" style="display: none; margin-left: 10px"><?php echo substr($row["phone"],4); ?></div>
				</div>
				<div class="button_yellow chatlah" style="margin-top: 10px; background: #e60803">
					<i class="fa-solid fa-comments"></i>
					<div style="margin-left: 10px">Чатлах</div>
				</div>
			</div>
		</div>
		<div class="right">
			<div class="importantRight">
				<div class="button_yellow price">
					<div><?php echo convertPriceToText($row["price"]); ?> ₮</div>
				</div>
				<div class="button_yellow phone">
					<i class="fa-solid fa-phone"></i>
					<div style="margin-left: 10px">
						<div>Дугаар харах</div>
						<div class="hided" style="display: flex; font-family:RobotoRegular; font-size: 14px"><?php echo substr($row["phone"],4,4); ?>-<div style="color: #FFA718">XXXX</div></div>
					</div>
					<div class="full" style="display: none; margin-left: 10px"><?php echo substr($row["phone"],4); ?></div>
				</div>
				<div class="button_yellow chatlah" style="margin-top: 10px; background: #e60803">
					<i class="fa-solid fa-comments"></i>
					<div style="margin-left: 10px">Чатлах</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>
</div>