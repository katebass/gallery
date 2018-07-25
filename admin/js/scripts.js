$(document).ready(function() {
	var user_href,
		user_href_splitted,
		user_id,
		image_src,
		image_href_splitted,
		image_name,
		photo_id;

	$(".modal_thumbnails").click(function(){

		$("#set_user_image").prop('disabled', false);
		user_href = $("#user-id").prop('href');
		user_href_splitted = user_href.split("=");
		user_id = user_href_splitted[user_href_splitted.length - 1];


		image_src = $(this).prop("src");
		image_href_splitted = image_src.split("/");
		image_name = image_href_splitted[image_href_splitted.length - 1];

		photo_id = $(this).attr("data");

		$.ajax({
			url: "includes/ajax_code.php",
			data: { photo_id: photo_id },
			type: "POST",
			success:function(data){
				if (!data.error) {
					$("#modal_sidebar").html(data);
					//location.reload(true);
				}
			}
		});

	});


	$("#set_user_image").click(function(){
		$.ajax({
			url: "includes/ajax_code.php",
			data: {
					image_name: image_name, 
					user_id: user_id
				  },
			type: "POST",
			success:function(data){
				if (!data.error) {

					$(".user_image_box a img").prop('src', data);
					//location.reload(true);
				}
			}
		});
	});

	$(".modal_thumbnails").dblclick(function(){
		$.ajax({
			url: "includes/ajax_code.php",
			data: {
					image_name: image_name, 
					user_id: user_id
				  },
			type: "POST",
			success:function(data){
				if (!data.error) {
					$(".user_image_box a img").prop('src', data);
					$('#photo-library').modal('hide');
					//location.reload(true);
				}
			}
		});
	});

/* Edit photo side bar */
	$(".info-box-header").click(function(){
		$("#toggle").toggleClass("glyphicon-menu-up , glyphicon-menu-down");
		//$("#toggle").toggleClass("glyphicon-menu-down");
		$(".inside").slideToggle("fast");
	});

/* Delete function */
	$(".delete_link").click(function(){

		return confirm("Are you sure you want to delete this item?");

	});

	tinymce.init({ selector:'textarea' });



});
