function pagenavigation(page){
	location.href = "?page=" + page;
}

function logout(){
	firebase.auth().signOut();
	sessionStorage.removeItem("uid");
	sessionStorage.removeItem("phone");
//	sessionStorage.clear();
	location.href = "index.php";
}