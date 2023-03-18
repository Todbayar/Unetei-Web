<?php
include "mysql_config.php";

$file = $_FILES["iconfile"];
$uid = $_REQUEST["uid"];
$title = $_REQUEST["title"];
$hier = !empty($_REQUEST["hier"]) ? explode(',', $_REQUEST["hier"]) : array();

if(isset($hier) && isset($uid) && isset($title) && isset($file)){
	if(count($hier) === 0){
		CheckTableCreate(1);
		
	}
	else {
		for($i=1; $i<=count($hier); $i++){
			CheckTableCreate($i);
			//is it the table that this entry is going to be inserted
			if($i == count($hier)){
				$queryInsert = "INSERT INTO category";
			}
			else {
				
			}
		}
	}
}

function CheckTableCreate($pID){
	global $dbname, $conn;
	
	$queryTableExist = "SELECT count(*) as 'total_count' FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$dbname."') AND (TABLE_NAME = 'category".$pID."')";
	$resultTableExist = $conn->query($queryTableExist);
	$rowTableExist = mysqli_fetch_array($resultTableExist);
	echo "OK, exist:".$rowTableExist["total_count"].", ".$pID;
	if($rowTableExist["total_count"] == 0){
		$queryTableCreate = "CREATE TABLE category".$pID." (id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, uid varchar(255) NOT NULL, title varchar(30) NOT NULL, icon varchar(255) NOT NULL, status int(1) NOT NULL, active tinyint NOT NULL)";
		echo $queryTableCreate;
		$conn->query($queryTableCreate);
	}
}

function InsertCategoryEntry($pID, $pUID, $pTitle, $pFile){
	
	$queryInsert = "INSERT INTO category".$pID."(uid, title, icon) VALUES('','','')";
}
?>