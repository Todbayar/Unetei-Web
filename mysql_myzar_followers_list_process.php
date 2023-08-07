<?php
include "mysql_config.php";
include_once "info.php";
include_once "mysql_misc.php";

if(isset($_COOKIE["userID"])){
	$users = new stdClass();
	$queryDirect = "SELECT * FROM user WHERE affiliate=(SELECT phone FROM user WHERE id=".$_COOKIE["userID"].") ORDER BY id DESC";
	$resultDirect = $conn->query($queryDirect);
	$users->followers = new stdClass();
	if(mysqli_num_rows($resultDirect)>0){
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
	}
	
	if(getPhone($_COOKIE["userID"])==$superduperadmin){
		$queryIndirect = "SELECT * FROM user WHERE affiliate='' AND phone!='".$superduperadmin."' ORDER BY id DESC";
		$resultIndirect = $conn->query($queryIndirect);
		if(mysqli_num_rows($resultIndirect)>0){
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
		}
		
		$queryOther = "SELECT * FROM user WHERE affiliate!='' AND affiliate!='".$superduperadmin."' AND phone!='".$superduperadmin."' ORDER BY id DESC";
		$resultOther = $conn->query($queryOther);
		if(mysqli_num_rows($resultOther)>0){
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
	}
	
	echo json_encode($users);
}
?>