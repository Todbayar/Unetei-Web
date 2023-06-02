<?php
include "mysql_config.php";
?>

<style>
.detail {
	float: left;
	width: 100%;
	margin-top: 10px; 
	margin-bottom: 10px; 
	margin-left: 5px;	
	margin-right: 5px;  
}

.detail .categories {
	color: #8f8f8f;
    font-size: 16px;
    line-height: 1.5;
    font-family: RobotoRegular;
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
</style>

<div class="detail">
<?php
if(isset($_GET["id"])){
	$query = "SELECT * FROM item WHERE id=".$_GET["id"];
	$result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	
	$splita = explode("_", $row["category"]);
	$tableID = intval(substr($splita[0], 1));
	$id = intval($splita[1]);
	$arrCategories = array();
	for($i=$tableID; $i>=1; $i--){
		$queryCategory = "SELECT * FROM category".$i." WHERE id=".$id;
		$resultCategory = $conn->query($queryCategory);
		$rowCategory = mysqli_fetch_array($resultCategory);
		if($i>1) $id = $rowCategory["parent"];
		$arrCategories[] = $rowCategory["title"];
	}
	
	$arrCategories = array_reverse($arrCategories);
	?>
	<div class="categories">
		<div class="category">Бүх зар</div> <i class="fas fa-angle-right" style="font-size: 12px" aria-hidden="true"></i>
		<?php
		for($i=0; $i<count($arrCategories); $i++){
			if($i!=count($arrCategories)-1){
				echo "<div class=\"category\">".$arrCategories[$i]."</div> <i class=\"fas fa-angle-right\" style=\"font-size: 12px\" aria-hidden=\"true\"></i> ";
			}
			else {
				echo "<div class=\"category\">".$arrCategories[$i]."</div>";
			}
		}
		?>
	</div>
	<div class="title"><?php echo $row["title"]; ?></div>
	<div><?php echo $row["city"]; ?></div>
	<div><?php echo $row["datetime"]; ?></div>
	<?php
}
?>
</div>