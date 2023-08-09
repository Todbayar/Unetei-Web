<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";

if(isset($_COOKIE["userID"])){
	$users = new stdClass();
	
	$pageCount = $pageCountFollowers;
	$pageOffset = $_POST["page"]*$pageCount;
	$limit = " LIMIT ".$pageOffset.",".$pageCount;
	
	$queryDirect = "SELECT * FROM user WHERE affiliate=(SELECT phone FROM user WHERE id=".$_COOKIE["userID"].") ORDER BY id DESC ".$limit;
	$resultDirect = $conn->query($queryDirect);
	$users->followers = new stdClass();
	$rowCountFollowers = mysqli_num_rows($resultDirect);
	$totalCountItems = $rowCountFollowers;
	$users->followers->direct = array();
	while($rowDirect = mysqli_fetch_array($resultDirect)){
		$userDirect = new stdClass();
		$userDirect->id = $rowDirect["id"];
		$userDirect->image = $rowDirect["image"];
		$userDirect->name = $rowDirect["name"];
		$userDirect->role = $rowDirect["role"];
		$userDirect->phone = $rowDirect["phone"];
		$users->followers->direct[] = $userDirect;
	}
	
	if(getPhone($_COOKIE["userID"])==$superduperadmin){
		$queryIndirect = "SELECT * FROM user WHERE affiliate='' AND phone!='".$superduperadmin."' ORDER BY id DESC ".$limit;
		$resultIndirect = $conn->query($queryIndirect);
		$rowCountFollowersIndirect = mysqli_num_rows($resultIndirect);
		$totalCountItems += $rowCountFollowersIndirect;
		if($rowCountFollowers<$rowCountFollowersIndirect) $rowCountFollowers=$rowCountFollowersIndirect;
		$users->followers->indirect = array();
		while($rowIndirect = mysqli_fetch_array($resultIndirect)){
			$userIndirect = new stdClass();
			$userIndirect->id = $rowIndirect["id"];
			$userIndirect->image = $rowIndirect["image"];
			$userIndirect->name = $rowIndirect["name"];
			$userIndirect->role = $rowIndirect["role"];
			$userIndirect->phone = $rowIndirect["phone"];
			$users->followers->indirect[] = $userIndirect;
		}
		
		$queryOther = "SELECT * FROM user WHERE affiliate!='' AND affiliate!='".$superduperadmin."' AND phone!='".$superduperadmin."' ORDER BY id DESC ".$limit;
		$resultOther = $conn->query($queryOther);
		$rowCountOther = mysqli_num_rows($resultIndirect);
		$totalCountItems += $rowCountOther;
		if($rowCountFollowers<$rowCountOther) $rowCountFollowers=$rowCountOther;
		$users->users = array();
		while($rowOther = mysqli_fetch_array($resultOther)){
			$userOther = new stdClass();
			$userOther->id = $rowOther["id"];
			$userOther->image = $rowOther["image"];
			$userOther->name = $rowOther["name"];
			$userOther->role = $rowOther["role"];
			$userOther->phone = $rowOther["phone"];
			$users->users[] = $userOther;
		}
	}
	
	$page = new stdClass();
	$page->offset = $_POST["page"];	//index
	$page->perpage = $pageCount;
	$page->countItems = $totalCountItems;
	$page->countPages = ceil($rowCountFollowers/$pageCount);
	$users->page = $page;
	
	echo json_encode($users);
}
?>