<?php
include "mysql_config.php";
include "info.php";
?>
<script>
$(document).ready(function(){
	Notification.requestPermission().then((permission) => {
		if (permission === 'granted') {
		  console.log('Notification permission granted.');
		}
	});
});
	
function chat_send(toID){
	var chatSubmitData = new FormData();
	chatSubmitData.append("fromID", <?php echo $_COOKIE["userID"]; ?>);
	chatSubmitData.append("toID", toID);
	chatSubmitData.append("type", 0);
	chatSubmitData.append("message", $("#chatMessage").val());

	const reqChatSubmit = new XMLHttpRequest();
	reqChatSubmit.onload = function() {
		console.log("<chat_send>:" + this.responseText);
	};
	reqChatSubmit.onerror = function(){
		console.log("<chat_send>:" + reqChatSubmit.status);
	};

	reqChatSubmit.open("POST", "chat_process.php", true);
	reqChatSubmit.send(chatSubmitData);
}
	
function chat_select(groupID){
	$(".left .user").css("background-color", "transparent");
	$(".left #chatSelect"+groupID).css("background-color", "#d7edf7");

	const reqChatFetchSubmit = new XMLHttpRequest();
	reqChatFetchSubmit.onload = function() {
		console.log("<chat_select>:" + this.responseText);
	};
	reqChatFetchSubmit.onerror = function(){
		console.log("<chat_select>:" + reqChatFetchSubmit.status);
	};

	reqChatFetchSubmit.open("GET", "chat_fetch.php?id="+groupID, true);
	reqChatFetchSubmit.send();
}
</script>

<div class="chat">
	<div class="left">
		<?php
		$queryFetchSender = "SELECT *, (SELECT name FROM user WHERE id=chat.fromID) AS name, (SELECT image FROM user WHERE id=chat.fromID) AS image, (SELECT role FROM user WHERE id=chat.fromID) AS role FROM chat WHERE toID=".$_COOKIE["userID"];
		if($_COOKIE["role"]>0) $queryFetchSender .= " OR toID=0";
		$queryFetchSender .= " GROUP BY toID ORDER BY datetime DESC";
		$resultFetchSender = $conn->query($queryFetchSender);
		while($rowFetchSender = mysqli_fetch_array($resultFetchSender)){
		?>
		<div id="chatSelect<?php echo $rowFetchSender["toID"]; ?>" class="user" onClick="chat_select(<?php echo $rowFetchSender["toID"]; ?>)">
			<div class="container">
				<div class="box">
					<div class="profile">
						<?php
						if($rowFetchSender["image"] != ""){
						?>
						<img src="<?php echo $path.DIRECTORY_SEPARATOR.$rowFetchSender["image"]; ?>">
						<?php
						}
						else {
						?>
						<img src="user.png">
						<?php
						}
						?>
					</div>
					<div>
						<div class="name"><?php echo $rowFetchSender["name"]; ?></div>
						<div class="role">
							<?php
							switch($rowFetchSender["role"]){
								case 0:
									echo "Хэрэглэгч";
									break;
								case 1:
									echo "Нийтлэгч";
									break;
								case 2:
									echo "Менежер";
									break;
								case 3:
									echo "Админ";
									break;
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
	</div>
	<div class="right">
		<div class="top">
			<div class="message">
				<img src="user.png">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг барин залилан хийх оролдлогууд гарсан байна.

	Бид одоогоор хүргэлт хийдэггүй бөгөөд хэрэглэгч хоорондын худалдан авалт хийх үед оролцдоггүй болно.

	Тиймээс та мэдэхгүй хүнд болон мэдэхгүй сайт дээрээ банкны картын дугаараа өгөхгүй байна уу.

	Хүндэтгэсэн,
	Unegui.mn хамт олон</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
			</div>
			<div class="message me">
				<div class="container">
					<div class="text">Todbayar</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
				<img src="user.png">
			</div>
			<div class="message">
				<img src="user.png">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
			</div>
			<div class="message me">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг барин залилан хийх оролдлогууд гарсан байна.

	Бид одоогоор хүргэлт хийдэггүй бөгөөд хэрэглэгч хоорондын худалдан авалт хийх үед оролцдоггүй болно.</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
				<img src="user.png">
			</div>
			<div class="message">
				<img src="user.png">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг барин залилан хийх оролдлогууд гарсан байна.

	Бид одоогоор хүргэлт хийдэггүй бөгөөд хэрэглэгч хоорондын худалдан авалт хийх үед оролцдоггүй болно.

	Тиймээс та мэдэхгүй хүнд болон мэдэхгүй сайт дээрээ банкны картын дугаараа өгөхгүй байна уу.

	Хүндэтгэсэн,
	Unegui.mn хамт олон</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
			</div>
			<div class="message me">
				<div class="container">
					<div class="text">Todbayar</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
				<img src="user.png">
			</div>
			<div class="message">
				<img src="user.png">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
			</div>
			<div class="message me">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг барин залилан хийх оролдлогууд гарсан байна.

	Бид одоогоор хүргэлт хийдэггүй бөгөөд хэрэглэгч хоорондын худалдан авалт хийх үед оролцдоггүй болно.</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
				<img src="user.png">
			</div>
			<div class="message">
				<img src="user.png">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг барин залилан хийх оролдлогууд гарсан байна.

	Бид одоогоор хүргэлт хийдэггүй бөгөөд хэрэглэгч хоорондын худалдан авалт хийх үед оролцдоггүй болно.

	Тиймээс та мэдэхгүй хүнд болон мэдэхгүй сайт дээрээ банкны картын дугаараа өгөхгүй байна уу.

	Хүндэтгэсэн,
	Unegui.mn хамт олон</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
			</div>
			<div class="message me">
				<div class="container">
					<div class="text">Todbayar</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
				<img src="user.png">
			</div>
			<div class="message">
				<img src="user.png">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
			</div>
			<div class="message me">
				<div class="container">
					<div class="text">Сайн байна уу?

	Манай сайтын нэрийг барин залилан хийх оролдлогууд гарсан байна.

	Бид одоогоор хүргэлт хийдэггүй бөгөөд хэрэглэгч хоорондын худалдан авалт хийх үед оролцдоггүй болно.</div>
					<div class="datetime">2023.4.14 1:14</div>
				</div>
				<img src="user.png">
			</div>
		</div>
		<div class="bottom">
			<input id="chatMessage" type="text" placeholder="Энд бичнэ үү" />
			<div onClick="chat_send(0)" class="button_yellow" style="float: right; height: 16px">
				<i class="fa-solid fa-paper-plane"></i>
			</div>
		</div>
	</div>
</div>