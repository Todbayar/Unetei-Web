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
</script>

<div class="chat">
	<div class="left">
		<div class="user">
			<div class="container">
				<div class="box">
					<div class="profile">
						<img src="user.png">
					</div>
					<div>
						<div class="name">Todbayar</div>
						<div class="role">Admin</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Bibi</div>
						<div class="role">Manager</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Zizi</div>
						<div class="role">Publisher</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Puntsagdulam</div>
						<div class="role">User</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Todbayar</div>
						<div class="role">Admin</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Bibi</div>
						<div class="role">Manager</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Zizi</div>
						<div class="role">Publisher</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Puntsagdulam</div>
						<div class="role">User</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Todbayar</div>
						<div class="role">Admin</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Bibi</div>
						<div class="role">Manager</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Zizi</div>
						<div class="role">Publisher</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Puntsagdulam</div>
						<div class="role">User</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Todbayar</div>
						<div class="role">Admin</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Bibi</div>
						<div class="role">Manager</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Zizi</div>
						<div class="role">Publisher</div>
					</div>
				</div>
			</div>
		</div>
		<div class="user">
			<div class="container">
				<div class="box">
					<div>
						<img src="user.png">
					</div>
					<div>
						<div class="name">Puntsagdulam</div>
						<div class="role">User</div>
					</div>
				</div>
			</div>
		</div>
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