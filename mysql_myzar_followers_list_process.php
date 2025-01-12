<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";

if(isset($_COOKIE["userID"])){
	$users = new stdClass();
	
	$pageCount = $pageCountFollowers;
	$pageOffset = $_POST["page"]*$pageCount;
	$limit = " LIMIT ".$pageOffset.",".$pageCount;
	
	$queryCountDirect = "SELECT * FROM user WHERE affiliate=(SELECT phone FROM user WHERE id=".$_COOKIE["userID"].") AND phone!=(SELECT phone FROM user WHERE id=".$_COOKIE["userID"].")";
	$resultCountDirect = $conn->query($queryCountDirect);
	$rowCountFollowers = mysqli_num_rows($resultCountDirect);
	$totalCountItems = $rowCountFollowers;
	
	$queryDirect = "SELECT * FROM user WHERE affiliate=(SELECT phone FROM user WHERE id=".$_COOKIE["userID"].") AND phone!=(SELECT phone FROM user WHERE id=".$_COOKIE["userID"].") ORDER BY id DESC ".$limit;
	$resultDirect = $conn->query($queryDirect);
	$users->followers = new stdClass();
	$users->followers->direct = array();
	while($rowDirect = mysqli_fetch_array($resultDirect)){
		$userDirect = new stdClass();
		$userDirect->id = $rowDirect["id"];
		$userDirect->uid = $rowDirect["uid"];
		$userDirect->image = $rowDirect["image"];
		$userDirect->name = $rowDirect["name"];
		$userDirect->role = $rowDirect["role"];
		$userDirect->phone = $rowDirect["phone"];
		$userDirect->lastactive = $rowDirect["lastactive"];
		$userDirect->lastlogged = $rowDirect["lastlogged"];
		$users->followers->direct[] = $userDirect;
	}
	
	$queryCountIndirect = "SELECT * FROM user WHERE (affiliate='' OR affiliate IS NULL OR affiliate=phone) AND phone!='".$superduperadmin."'";
	$resultCountIndirect = $conn->query($queryCountIndirect);
	$rowCountFollowersIndirect = mysqli_num_rows($resultCountIndirect);
	$totalCountItems += $rowCountFollowersIndirect;
	if($rowCountFollowers<$rowCountFollowersIndirect) $rowCountFollowers=$rowCountFollowersIndirect;
	
	$queryIndirect = "SELECT * FROM user WHERE (affiliate='' OR affiliate IS NULL OR affiliate=phone) AND phone!='".$superduperadmin."' ORDER BY id DESC ".$limit;
	$resultIndirect = $conn->query($queryIndirect);
	$users->followers->indirect = array();
	while($rowIndirect = mysqli_fetch_array($resultIndirect)){
		$userIndirect = new stdClass();
		$userIndirect->id = $rowIndirect["id"];
		$userIndirect->uid = $rowIndirect["uid"];
		$userIndirect->image = $rowIndirect["image"];
		$userIndirect->name = $rowIndirect["name"];
		$userIndirect->role = $rowIndirect["role"];
		$userIndirect->phone = $rowIndirect["phone"];
		$userIndirect->lastactive = $rowIndirect["lastactive"];
		$userIndirect->lastlogged = $rowIndirect["lastlogged"];
		$users->followers->indirect[] = $userIndirect;
	}
	
//	if(getPhone($_COOKIE["userID"])==$superduperadmin){		
//		
//		$queryOther = "SELECT * FROM user WHERE (affiliate!='' AND affiliate IS NOT NULL) AND affiliate!='".$superduperadmin."' AND phone!='".$superduperadmin."' ORDER BY id DESC ".$limit;
//		$resultOther = $conn->query($queryOther);
//		$rowCountOther = mysqli_num_rows($resultIndirect);
//		$totalCountItems += $rowCountOther;
//		if($rowCountFollowers<$rowCountOther) $rowCountFollowers=$rowCountOther;
//		$users->users = array();
//		while($rowOther = mysqli_fetch_array($resultOther)){
//			$userOther = new stdClass();
//			$userOther->id = $rowOther["id"];
//			$userOther->image = $rowOther["image"];
//			$userOther->name = $rowOther["name"];
//			$userOther->role = $rowOther["role"];
//			$userOther->phone = $rowOther["phone"];
//			$users->users[] = $userOther;
//		}
//	}
	
	$page = new stdClass();
	$page->offset = $_POST["page"];	//index
	$page->perpage = $pageCount;
	$page->countItems = $totalCountItems;
	$page->maxCount = $rowCountFollowers;
	$page->countPages = ceil($rowCountFollowers/$pageCount);
	$users->page = $page;
	
	echo json_encode($users);
}
?>