function pagenavigation(page){
	location.href = "?page=" + page;
}

function logout(){
	const reqLogout = new XMLHttpRequest();
	reqLogout.onload = function() {
		firebase.auth().signOut();
		location.href = "./";
	};
	reqLogout.open("POST", "logout.php", true);
	reqLogout.send();
}