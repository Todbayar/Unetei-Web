var selectedCategory = [];
var selectedCategoryTitles = [];
var selectedVideoName = "";
var selectedPublishOption;
var dataTransferImages;
var dataTransferVideos;
var itemData;

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
	dataTransferImages = new DataTransfer();
	dataTransferVideos = new DataTransfer();
	
	if(sessionStorage.getItem("selectedCategoryHier") != null) {
		myzar_item_categories(JSON.parse(sessionStorage.getItem("selectedCategoryHier")), null);
		sessionStorage.removeItem("selectedCategoryHier");
	}
	
	$(".popup.item_publish_option input[name='publish_option']").change(function(){
		selectedPublishOption = $(this);
		if(itemData!=null) itemData.set("status", selectedPublishOption.val());
		$(".popup.item_publish_option #buttonPublish").attr("disabled", false);
	});
	
	$(".popup.item_publish_option .selection").click(function(){
		if(selectedPublishOption != null) selectedPublishOption.find("input").prop("checked", false);
		selectedPublishOption = $(this);
		const findSelPubOpt = selectedPublishOption.find("input");
		findSelPubOpt.prop("checked", true);
		if(itemData!=null) itemData.set("status", findSelPubOpt.val());
		$(".popup.item_publish_option #buttonPublish").attr("disabled", false);
	});
	
	$("#myzar_item_images_input").change(function(){
		var vImageExtensions = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
		var vImages = $(this)[0].files;
		var vImagesTotalCount = 20-$("#myzar_item_images").children().length;
		var vImagesLimit = vImages.length<=vImagesTotalCount?vImages.length:vImagesTotalCount;
		for(let i=0; i<vImagesLimit; i++){
			if($.inArray(vImages[i].type.toLowerCase(), vImageExtensions) > -1){
				var reader = new FileReader();
				reader.onload = function (e) {
					$("#myzar_item_images").append("<div id=\""+$("#myzar_item_images").children().length+"\" data-action=\"new\" class=\"itemImage\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img name=\""+vImages[i].name+"\" data-type=\""+vImages[i].type+"\" src=\""+e.target.result+"\" style=\"width: 100%; height: 100%; border-radius: 5px; object-fit: cover\" /><i onClick=\"myzar_item_images_remove(this)\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i><div>");
					updateOrderItemImages();
					dataTransferImages.items.add(vImages[i]);
					$("#myzar_item_images_input")[0].files = dataTransferImages.files;
				}
				reader.readAsDataURL(vImages[i]);
			}
		}
	});
	
	$("#myzar_item_videos_input").change(function(){
		var vVideoExtensions = ['video/quicktime', 'video/mp4'];
		var vVideo = $(this)[0].files[0];
		if($.inArray(vVideo.type.toLowerCase(), vVideoExtensions) > -1){
			if(vVideo.size <= 100*1024*1024){	//100MB
				$("#myzar_item_video").append("<div id=\""+$("#myzar_item_video").children().length+"\" data-action=\"new\" class=\"itemVideo\" style=\"float:left; width: 121px; height: 121px; margin: 5px; border-radius: 5px; background-color:#dddddd\"><img src=\"Loading.gif\" width=\"24px\" height=\"24px\" style=\"margin-left: 48px; margin-top: 48px\" /><div>");
				var reader = new FileReader();
				reader.onload = function (e) {
					$("#videoBrowseButton").hide();
					$("#myzar_item_video div.itemVideo[data-action='new'] img").remove();
					$("#myzar_item_video div.itemVideo[data-action='new']").html("<video name=\""+vVideo.name+"\" width=\"100%\" height=\"100%\" controls=\"controls\" preload=\"metadata\" style=\"border-radius: 5px\"><source src=\""+e.target.result+"#t=0.5\" type=\""+vVideo.type+"\"></video><i onClick=\"myzar_item_video_remove(this)\" class=\"fa-solid fa-xmark\" style=\"position: relative; float:right; top:-123px; right:4px; color: #FF4649; cursor: pointer\"></i>");
					dataTransferVideos.items.add(vVideo);
					$("#myzar_item_videos_input")[0].files = dataTransferVideos.files;
				}
				reader.readAsDataURL(vVideo);
			}
			else {
				alert("Файлын хэмжээ 100MB-аас их байна!");
			}
		}
		else {
			alert("mp4, mov файл биш байна!")
		}
	});
	
	const el = document.getElementById('myzar_item_images');
	new Sortable(el, {
		filter: "i.fa-xmark",
	  	animation: 150,
	  	onEnd: (event) => {
			updateOrderItemImages();
	  	}
	});
});

function myzar_item_images_browse(){
	$("#myzar_item_images_input").val(null);
	$("#myzar_item_images_input").trigger("click");
}

function myzar_item_video_browse(){
	$("#myzar_item_videos_input").val(null);
	$("#myzar_item_videos_input").trigger("click");
}

function updateOrderItemImages() {
	var selectedImagesIndex = 0;
	$("#myzar_item_images > div.itemImage").each(function(){
		if($(this).attr("data-action")!="delete"){
			$(this).children("img").attr("data-sort",selectedImagesIndex);
			selectedImagesIndex++;
		}
	});
	
	if($("#myzar_item_images").children().length<20){
		$("#imagesBrowseButton").show();
	}
	else {
		$("#imagesBrowseButton").hide();
	}
}

function myzar_item_images_remove(el){
	const parent = $(el).parent();
	const imageID = parent.attr("id");
	const action = parent.attr("data-action");
	
	dataTransferImages.items.remove(imageID);
  	$("#myzar_item_images_input")[0].files = dataTransferImages.files;
	
	if(action!="new"){
		parent.attr("data-action","delete");
		parent.hide();
   	}
	else {
		parent.remove();
	}
	
  	updateOrderItemImages();
	
	console.log($("#myzar_item_images_input")[0].files.length);
}

function myzar_item_video_remove(el){
	const parent = $(el).parent();
	const videoID = parent.attr("id");
	const action = parent.attr("data-action");
	
	$("#videoBrowseButton").show();
	dataTransferVideos.items.remove(videoID);
	$("#myzar_item_videos_input")[0].files = dataTransferVideos.files;
	
	if(action!="new"){
		parent.attr("data-action","delete");
		parent.hide();
   	}
	else {
		parent.remove();
	}
	
	console.log($("#myzar_item_videos_input")[0].files.length);
}

function myzar_item_categories(hierCategories, words){
	$(".myzar_content_add_item_selected_categories").empty();
	const selectedCategoryHier = hierCategories;
	for(let i=0; i<selectedCategoryHier.length; i++){
		selectedCategory[i] = selectedCategoryHier[i].id;
		selectedCategoryTitles[i] = selectedCategoryHier[i].title;
		if(selectedCategoryHier[i].icon != ""){
			$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #e1e5e8; height:18px\"><div style=\"display:flex; align-items: center\"><img src=\"./user_files/"+selectedCategoryHier[i].icon+"\" width=\"32px\" height=\"32px\" style=\"margin-left: 5px\" /><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
		}
		else {
			$(".myzar_content_add_item_selected_categories").append("<div class=\"button_yellow\" style=\"margin-left:10px; margin-bottom: 10px; float: left; background: #e1e5e8; height:18px\"><div style=\"display:flex; align-items: center\"><div style=\"margin-left: 5px\">"+selectedCategoryHier[i].title+"</div></div></div>");
		}
	}
	$(".myzar_content_add_item").show();
	
	//listing word extras
	if(words != "" && words != undefined && words != null){
		const extras = JSON.parse(words);
		for(var i=0; i<extras.length; i++){
			for(const [key, value] of Object.entries(extras[i])){
				$("#myzar_item_extras").append("<table width=\"100%\"><tr><td width=\"115px\">"+key+"</td><td><input list=\""+key+"\" name=\""+key+"\" id=\"myzar_item_extra"+(i+1)+"\" value=\""+value+"\" type=\"text\" maxlength=\"200\" style=\"width: 95%; height: 25px; padding: 5px; font: normal 16px Arial\"></td></tr></table>");
				getItemExtraDataList(key, "c"+selectedCategoryHier.length+"_"+selectedCategoryHier[selectedCategoryHier.length-1].id, i);
			}
		}
	}
	else {
		const reqMyZarItemExtrasSubmit = new XMLHttpRequest();
		reqMyZarItemExtrasSubmit.onload = function() {
			if(this.responseText != ""){
				const vExtras = JSON.parse(this.responseText);
				var extraID = 1;
				vExtras.forEach(function(vExtra){
					$("#myzar_item_extras").append("<table width=\"100%\"><tr><td width=\"115px\">"+vExtra+"</td><td><input name=\""+vExtra+"\" id=\"myzar_item_extra"+extraID+"\" type=\"text\" maxlength=\"200\" style=\"width: 95%; height: 25px; padding: 5px; font: normal 16px Arial\"></td></tr></table>");
					getItemExtraDataList(vExtra, "c"+selectedCategoryHier.length+"_"+selectedCategoryHier[selectedCategoryHier.length-1].id, (extraID-1));
					extraID++;
				});
			}
		};

		reqMyZarItemExtrasSubmit.onerror = function(){
			console.log("<myzar_item_categories>:" + reqMyZarItemExtrasSubmit.status + ", " + reqMyZarItemExtrasSubmit.statusText);
		};

		const lastCategory = "c"+selectedCategoryHier.length+"_"+selectedCategoryHier[selectedCategoryHier.length-1].id;
		reqMyZarItemExtrasSubmit.open("GET", "mysql_myzar_item_extras_process.php?category="+lastCategory, true);
		reqMyZarItemExtrasSubmit.send();
	}
}

function myzar_item_update(itemID, title, categories, role){
	$("body").css("overflow-y", "hidden");
	window.scrollTo(0, 0);
	$(".popup.item_publish_option").show();
	$(".popup.item_publish_option .title").html(title);
	$(".popup.item_publish_option .category").empty();
	$(".popup.item_publish_option button").attr("onclick", "publishItemUpdate("+itemID+",'"+title+"',"+role+")");
	const arrCategories = categories.split(",");
	arrCategories.forEach(function(title, index, arr){
		if(arrCategories.length-1>index){
			$(".popup.item_publish_option .category").append(title+"<i class=\"fas fa-angle-right\" style=\"font-size:12px; margin-left:2px; margin-right:2px\"></i>");
		}
		else {
			$(".popup.item_publish_option .category").append(title);
		}
	});
}

function myzar_item_add_submit(){
	itemData = getItemDataForm();
	if(itemData != ""){
		itemData.set("status", $(".popup.item_publish_option input[name='publish_option']:checked").val());
		$("body").css("overflow-y", "hidden");
		window.scrollTo(0, 0);
		$(".popup.item_publish_option").show();
		$(".popup.item_publish_option .title").html(itemData.get("title"));
		$(".popup.item_publish_option .category").empty();
		selectedCategoryTitles.forEach(function(title, index, arr){
			if(selectedCategoryTitles.length-1>index){
		   		$(".popup.item_publish_option .category").append(title+"<i class=\"fas fa-angle-right\" style=\"font-size:12px; margin-left:2px; margin-right:2px\"></i>");
			}
			else {
				$(".popup.item_publish_option .category").append(title);
			}
		});
	}
}

function publishItemUpdate(itemID, title, role){
	const selPriceOpt = $(".popup.item_publish_option input[name='publish_option']:checked").val();
	$.post("mysql_myzar_item_update_process.php", {id:itemID,status:selPriceOpt}).done(function(responseText){
	   if(responseText!="FAIL"){
			$(".popup.item_publish_option").hide();
		   	const itemResponse = JSON.parse(responseText);
			if(itemResponse.pay_amount == 0){
				var eventOk = new CustomEvent("itemUpdateDone");
				window.addEventListener("itemUpdateDone", function(){
					location.reload();
				});
				confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Зар амжилттай <b>шинэчлэгдэж</b>, шалгагдаж байна.", eventOk);
			}
			else {
				$.post("mysql_billing.php", {type:"item"}).done(function (response){
					$(".popup.billing").show();
					const res = JSON.parse(response);
					$(".popup.billing .container #billing_type").html("Зар нэмэх");
					$(".popup.billing .container #billing_number").html("#" + itemResponse.id);
					$(".popup.billing .container #billing_title").html(title);
					$(".popup.billing .container #billing_price").html(itemResponse.pay_amount + " ₮");
					
					if(res.bank_account!="" && res.bank_account!=null){
						$(".popup.billing .container #billing_bank #name").html("<b>" + res.bank_name + "</b>");
						$(".popup.billing .container #billing_bank #account").html("<b>" + res.bank_account + "</b>");
						$(".popup.billing .container #billing_bank #owner").html("<b>" + res.bank_owner + "</b>");
					}
					else {
						$(".popup.billing .container #billing_bank").hide();
					}
					
					if(res.socialpay!="" && res.socialpay!=null){
						$(".popup.billing .container #billing_socialpay img").attr("src", "user_files/"+res.socialpay);
					}
					else {
						$(".popup.billing .container #billing_qr").hide();
					}
					
					$(".popup.billing .container .button_yellow").click(function(){
						$(".popup.billing").hide();
						var eventOk = new CustomEvent("itemUpdateDone");
						window.addEventListener("itemUpdateDone", function(){
							location.reload();
						});
						confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Зар амжилттай <b>шинэчлэгдэж</b>, шалгагдаж байна.", eventOk);
					});
				});
			}
	   }
	   else {
			alert("Алдаа гарлаа:publishItemUpdate");
	   }
   });
}

function publishItemSubmit(role){
	const reqMyZarItemAdd = new XMLHttpRequest();
	reqMyZarItemAdd.onload = function() {
		console.log("<publishItemSubmit>:"+this.responseText);
		if(this.responseText == "Fail 58"){
			alert("Уг гарчиг бүхий зар таны зарын жагсаалтанд байна!");
		}
		else if(this.responseText == "Fail 54"){
			alert("Зарыг нэмэх боломжгүй байна! Зарын гарчиг, хаяг байршлийн текст хэт урт байна.");
		}
		else if(this.responseText == "Fail 46"){
			alert("Зарын зургийг оруулах боломжгүй байна!");
		}
		else {
			$(".myzar_content_add_item").hide();
			$(".popup.item_publish_option").hide();
			const itemResponse = JSON.parse(this.responseText);
			if(itemResponse.pay_amount == 0){
				var eventOk = new CustomEvent("itemAddDone");
				window.addEventListener("itemAddDone", function(){
					sessionStorage.setItem("startItemToDetail", true);
					pagenavigation("detail/"+itemResponse.id,"slash");
				});
	//			information("success", "fa-solid fa-file-pen", "Зар амжилттай <b>нэмэгдэж</b>, шалгагдаж байна.", 6, eventInfo);
				confirmation_ok("<i class='fa-solid fa-circle-info' style='margin-right: 5px; color: #58d518'></i>Зар амжилттай <b>нэмэгдэж</b>, шалгагдаж байна.", eventOk);
			}
			else {
				$.post("mysql_billing.php", {type:"item"}).done(function (response){
					$(".popup.billing").show();
					const res = JSON.parse(response);
					$(".popup.billing .container #billing_type").html("Зар нэмэх");
					$(".popup.billing .container #billing_number").html("#" + itemResponse.id);
					$(".popup.billing .container #billing_title").html(itemData.get("title"));
					$(".popup.billing .container #billing_price").html(itemResponse.pay_amount + " ₮");
					
					if(res.bank_account!="" && res.bank_account!=null){
						$(".popup.billing .container #billing_bank #name").html("<b>" + res.bank_name + "</b>");
						$(".popup.billing .container #billing_bank #account").html("<b>" + res.bank_account + "</b>");
						$(".popup.billing .container #billing_bank #owner").html("<b>" + res.bank_owner + "</b>");
					}
					else {
						$(".popup.billing .container #billing_bank").hide();
					}
					
					if(res.socialpay!="" && res.socialpay!=null){
						$(".popup.billing .container #billing_socialpay img").attr("src", "user_files/"+res.socialpay);
					}
					else {
						$(".popup.billing .container #billing_qr").hide();
					}
					
					$(".popup.billing .container .button_yellow").click(function(){
						sessionStorage.setItem("startItemToDetail", true);
						pagenavigation("detail/"+itemResponse.id,"slash");
					});
				});
			}
		}
	};
	reqMyZarItemAdd.onerror = function(){
		console.log("<error>:" + reqMyZarItemAdd.status);
	};
	reqMyZarItemAdd.open("POST", "mysql_myzar_item_add_process.php", true);
	if(itemData !== "") reqMyZarItemAdd.send(itemData);
}