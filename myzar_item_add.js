var selectedCategory = [];
var selectedImagesIndex = 0;
var selectedImagesNames = [];
var selectedVideoName = "";

function initMap() {
  const myLatLng = { lat: 47.919126, lng: 106.917510 };
  const map = new google.maps.Map(document.getElementById("map"), {
	zoom: 4,
	center: myLatLng,
  });

  new google.maps.Marker({
	position: myLatLng,
	map,
	title: "Hello World!",
  });
}

window.initMap = initMap;

$(document).ready(function(){
	selectedImagesIndex = 0;
	if(sessionStorage.getItem("selectedCategoryHier") != null) {
		myzar_item_categories(JSON.parse(sessionStorage.getItem("selectedCategoryHier")));
		sessionStorage.removeItem("selectedCategoryHier");
	}
});

function myzar_item_categories(hierCategories){
	$(".myzar_content_add_item_selected_categories").empty();
	const selectedCategoryHier = hierCategories;
	for(let i=0; i<selectedCategoryHier.length; i++){
		selectedCategory[i] = selectedCategoryHier[i].id;
		if(selectedCategoryHier[i].icon != ""){
			$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd; height:18px\"><div style=\"display:flex\"><img src=\"./user_files/"+selectedCategoryHier[i].icon+"\" width=\"20px\" height=\"20px\" style=\"margin-left: 5px\" /><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
		}
		else {
			$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #dddddd; height:18px\"><div style=\"display:flex\"><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
		}
	}
	$(".myzar_content_add_item").show();
//		sessionStorage.removeItem("selectedCategoryHier");
}

function myzar_item_images_browse(){
	$("#myzar_item_images_input").trigger("click");
	$("#myzar_item_images_input").change(function(){
		var vImageExtensions = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
		var vImages = $(this)[0].files;
		for(let i=0; i<vImages.length; i++){
			if($.inArray(vImages[i].type.toLowerCase(), vImageExtensions) > -1){
				var myZarItemAddImageSubmitData = new FormData();
				myZarItemAddImageSubmitData.append("file", vImages[i]);
				myZarItemAddImageSubmitData.append("index", selectedImagesIndex);

				const reqMyZarItemImageAddSubmit = new XMLHttpRequest();
				reqMyZarItemImageAddSubmit.onload = function() {
					if(!this.responseText.includes("Fail")){
						var obj = JSON.parse(this.responseText);
						var index = obj.index;
						var name = obj.name;
						var path = obj.path;
						selectedImagesNames[index] = name;
						$("#myzar_item_images div#images" + index + " img").remove();
						$("#myzar_item_images div#images" + index).html("<img name=\""+name+"\" src=\""+path+"/"+name+"\" style=\"width: 100%; height: 100%; border-radius: 5px; object-fit: cover\" /><i onClick=\"myzar_item_images_remove("+index+")\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i>");
					}
					else {
						$("#myzar_item_images div#images" + index).remove();
					}
				};

				$("#myzar_item_images").append("<div id=\"images"+selectedImagesIndex+"\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img src=\"Loading.gif\" width=\"24px\" height=\"24px\" style=\"margin-left: 48px; margin-top: 48px\" /><div>");
				selectedImagesIndex++;

				reqMyZarItemImageAddSubmit.open("POST", "file_upload.php", true);
				reqMyZarItemImageAddSubmit.send(myZarItemAddImageSubmitData);
			}
		}
		$("#myzar_item_images_input").val(null);
	});
}

function myzar_item_images_remove(index){
	var myZarItemAddImageRemoveSubmitData = new FormData();
	myZarItemAddImageRemoveSubmitData.append("file", selectedImagesNames[index]);

	const reqMyZarItemImageRemoveSubmit = new XMLHttpRequest();
	reqMyZarItemImageRemoveSubmit.onload = function() {
		if(!this.responseText.includes("Fail")){
			$("#images"+index).remove();
			selectedImagesNames[index] = "";
			selectedImagesNames.splice(index, 1);
		}
	};

	reqMyZarItemImageRemoveSubmit.open("POST", "file_remove.php", true);
	reqMyZarItemImageRemoveSubmit.send(myZarItemAddImageRemoveSubmitData);
}

function myzar_item_video_browse(){
	$("#myzar_item_video_input").trigger("click");
	$("#myzar_item_video_input").change(function(){
		var vVideoExtensions = ['video/quicktime', 'video/mp4'];
		var vVideo = $(this)[0].files[0];
		if($.inArray(vVideo.type.toLowerCase(), vVideoExtensions) > -1){
			if(vVideo.size <= 500*1024*1024){					
				var myZarItemAddVideoSubmitData = new FormData();
				myZarItemAddVideoSubmitData.append("file", vVideo);
				myZarItemAddVideoSubmitData.append("index", 1);

				const reqMyZarItemVideoAddSubmit = new XMLHttpRequest();
				reqMyZarItemVideoAddSubmit.onload = function() {
					if(!this.responseText.includes("Fail")){
						var obj = JSON.parse(this.responseText);
						var index = obj.index;
						var name = obj.name;
						var path = obj.path;
						selectedVideoName = name;
						$("#myzar_item_video div#video1 img").remove();
						$("#myzar_item_video div#video1").html("<video name=\""+name+"\" width=\"100%\" height=\"100%\" controls=\"controls\" preload=\"metadata\" style=\"border-radius: 5px\"><source src=\""+path+"/"+name+"#t=0.5\" type=\""+vVideo.type+"\"></video><i onClick=\"myzar_item_video_remove()\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i>");
					}
					else {
						$("#myzar_item_video div#video1").remove();
						$("#videoBrowseButton").show();
					}
				};

				reqMyZarItemVideoAddSubmit.onerror = function(){
					console.log("<myzar_item_video_browse>:" + reqMyZarItemVideoAddSubmit.status + ", " + reqMyZarItemVideoAddSubmit.statusText);
				};

				$("#videoBrowseButton").hide();
				$("#myzar_item_video").append("<div id=\"video1\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img src=\"Loading.gif\" width=\"24px\" height=\"24px\" style=\"margin-left: 48px; margin-top: 48px\" /><div>");

				reqMyZarItemVideoAddSubmit.open("POST", "file_upload.php", true);
				reqMyZarItemVideoAddSubmit.send(myZarItemAddVideoSubmitData);
			}
			else {
				alert("Файлын хэмжээ 500MB-аас их байна!");
			}
		}
		else {
			alert("mp4, mov файл биш байна!")
		}
		$("#myzar_item_video_input").val(null);
	});
}

function myzar_item_video_remove(){
	var myZarItemAddVideoRemoveSubmitData = new FormData();
	myZarItemAddVideoRemoveSubmitData.append("file", selectedVideoName);

	const reqMyZarItemVideoRemoveSubmit = new XMLHttpRequest();
	reqMyZarItemVideoRemoveSubmit.onload = function() {
		if(!this.responseText.includes("Fail")){
			selectedVideoName = "";
			$("#video1").remove();
			$("#videoBrowseButton").show();
		}
	};

	reqMyZarItemVideoRemoveSubmit.open("POST", "file_remove.php", true);
	reqMyZarItemVideoRemoveSubmit.send(myZarItemAddVideoRemoveSubmitData);
}

function myzar_item_add_submit(){
	const reqMyZarItemAdd = new XMLHttpRequest();
	reqMyZarItemAdd.onload = function() {
		if(this.responseText == "Fail 60"){
			alert("Уг гарчиг бүхий зар таны зарын жагсаалтанд байна!");
		}
		else if(this.responseText == "Fail 56"){
			alert("Зарыг нэмэх боломжгүй байна!");
		}
		else if(this.responseText == "Fail 48"){
			alert("Зарын зургийг оруулах боломжгүй байна!");
		}
		else {
			$(".myzar_content_add_item").hide();
			var eventOk = new CustomEvent("itemAddDone");
			window.addEventListener("itemAddDone", function(){
				location.reload();
			});
//				information("success", "fa-solid fa-file-pen", "Зар амжилттай <b>нэмэгдэж</b>, шалгагдаж байна.", 6, eventInfo);
			confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Зар амжилттай <b>нэмэгдэж</b>, шалгагдаж байна.", eventOk);
		}
	};
	reqMyZarItemAdd.onerror = function(){
		console.log("<error>:" + reqMyZarItemAdd.status);
	};
	reqMyZarItemAdd.open("POST", "mysql_myzar_item_add_process.php", true);
	
	var myZarItemAddSubmitData = getItemDataForm();
	if(myZarItemAddSubmitData !== "") reqMyZarItemAdd.send(myZarItemAddSubmitData);
}