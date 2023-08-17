<?php
include "mysql_config.php";
include_once "mysql_misc.php";
include_once "info.php";
include_once "chat_process.php";

if(isset($_GET["superduperadminphone"]) && $_GET["superduperadminphone"]==$superduperadmin){
	$query = "SELECT *, u.id AS userID FROM user AS u LEFT JOIN chat AS c ON u.id=c.toID WHERE u.signed=u.lastactive AND SUBSTRING(u.signed,1,10)=DATE_FORMAT(NOW(),'%Y-%m-%d') AND u.role=0 AND u.affiliate IS NULL AND c.toID IS NULL";
	$result = $conn->query($query);
	while($row = mysqli_fetch_array($result)){
		$queryLastActiveUser = "SELECT * FROM user WHERE email IS NOT NULL AND role>1 ORDER BY lastactive DESC LIMIT 3";
		$resultLastActiveUser = $conn->query($queryLastActiveUser);
		
		$message = "Та ".$domain."-нд тавтай морил.<br/>";
		$message .= "Таньтай удахгүй (Менежер/Админ/Сүпер админ) холбоо барих болно.<br/>";
		$message .= "Та тэдний хэн нэгнийх нь дагагч болох боломжтой.<br/>";
		$message .= "Дагагч болсоноор таньд давуу тал бий болхыг анхаарна уу.<br/>";
		
		chat_send(getUserIDFromPhone($superduperadmin), $row["userID"], 0, $message, false);
		
		while($rowLastActiveUser = mysqli_fetch_array($resultLastActiveUser)){
			$message = "Сайн байна уу? ";
			if(!is_null($rowLastActiveUser["name"]) && $rowLastActiveUser["name"]!=""){
				$message .= $rowLastActiveUser["name"]."<br/>";
			}
			else {
				$message .= $rowLastActiveUser["phone"]."<br/>";
			}
			$message .= "Шинээр энгийн (".$row["phone"].") хэрэглэгч боллоо.<br/>";
			$message .= "Та өөртөө дагагч болгож элсүүлэх үү?<br/>";
			$message .= "Хэрэв тийм бол <b>Дагагчид</b> хэсэгт шинэ хэрэглэгчтэй холбоо барьж болно.<br/>";
			$message .= "Амжилт хүсье!";
			chat_send(getUserIDFromPhone($superduperadmin), $rowLastActiveUser["id"], 0, $message, false);
		}
	}
}
?>