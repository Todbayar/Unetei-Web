<?php
include "mysql_config.php";
include_once "info.php";

if(isset($_REQUEST["action"]) && isset($_REQUEST["type"]) && isset($_REQUEST["id"])){
	$type = $_REQUEST["type"];
	$action = $_REQUEST["action"];
	$id = $_REQUEST["id"];
	
	$query = "UPDATE ";
	
	if($type == 0){		//category
		$category = explode("_", $id);
		$query .= " category".$category[0];
		if($action == 0){
			$query .= " SET active=2";
		}
		else if($action == 1){
			$query .= " SET active=1";
		}
		$query .= " WHERE id=".$category[1];
	}
	else if($type == 1){	//item
		if($action == 0){
			$query .= " item SET isactive=4";
		}
		else if($action == 1) {
			$query .= " item SET isactive=3";
		}
		$query .= " WHERE id=".$id;
	}
	else if($type == 2){
		if($action == 0){
			$queryFetchRole = "SELECT fromID, message FROM chat WHERE id=".$id;
			$resultFetchRole = $conn->query($queryFetchRole);
			$rowFetchRole = mysqli_fetch_array($resultFetchRole);
			$queryUpdateRole = "UPDATE user SET";
			if(str_contains($rowFetchRole["message"], $role_rank_superadmin)){
				$queryUpdateRole .= " role=4";
			}
			else if(str_contains($rowFetchRole["message"], $role_rank_admin)){
				$queryUpdateRole .= " role=3";
			}
			else if(str_contains($rowFetchRole["message"], $role_rank_manager)){
				$queryUpdateRole .= " role=2";
			}
			else if(str_contains($rowFetchRole["message"], $role_rank_publisher)){
				$queryUpdateRole .= " role=1";
			}
			$queryUpdateRole .= " WHERE id=".$rowFetchRole["fromID"];
			@$conn->query($queryUpdateRole);
			
			$query = "UPDATE chat SET isRead=1 WHERE id=".$id;
		}
	}
	
	if($conn->query($query)){
		echo "OK";
	}
	else {
		echo "Fail";
	}
}
?>