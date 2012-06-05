MLM = {
	common: {
		init: function () {
			// On all pages
		}
	},
	home: {
		init: function () {
			$('#slider').orbit({
				animation: 'horizontal-push',             // fade, horizontal-slide, vertical-slide, horizontal-push
				animationSpeed: 800,                // how fast animtions are
				timer: true, 			 // true or false to have the timer
				advanceSpeed: 5000, 		 // if timer is enabled, time between transitions 
				pauseOnHover: true, 		 // if you hover pauses the slider
				startClockOnMouseOut: true, 	 // if clock should start on MouseOut
				startClockOnMouseOutAfter: 300, 	 // how long after MouseOut should the timer start again
				directionalNav: true, 		 // manual advancing directional navs
				captions: true, 			 // do you want captions?
				captionAnimation: 'slideOpen', 		 // fade, slideOpen, none
				captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
				bullets: false,			 // true or false to activate the bullet navigation
				bulletThumbs: false,		 // thumbnails for the bullets
				bulletThumbLocation: '',		 // location from this file where thumbs will be
				//afterSlideChange: function(){} 	 // empty function 
			});
		}
	},
	admin: {
		init: function () {
			/* Admin pages */
		}
	},
	images: {
		options: {},
		open: function(options) {
			if($("#imagemanager").length == 0) {
				$("<div id=\"imagemanager\" class=\"modal fade hide\">\
					<div class=\"modal-header\">\
						<button class=\"close\" data-dismiss=\"modal\"><i class=\"icon-remove icon-black\"></i></button>\
						<h3>Images</h3>\
					</div>\
					<div class=\"modal-body\"></div>\
					<div class=\"modal-footer\"><a href=\"#\" class=\"btn\" data-dismiss=\"modal\">Close</a></div>\
				</div>").appendTo(document.body)
				$("#imagemanager").modal({show: false})
			}
			if(options) {
				MLM.images.options = options
			} else {
				MLM.images.options = false
			}
			MLM.images.load()
			$("#imagemanager").modal("show")
		},
		load: function() {
			$("#imagemanager .modal-body").html("<img src=\""+ASSET_URL+"images/slider/loading.gif\">").load(BASE_URL+'/imgmgr', function() {
				// Ajax hooks for file uploading
				if($("#imageupload").length > 0) {
					$('#upload-file').change(function(e){
						$('#upload-filename').val($(this).val());
					});
					$('#imageupload').ajaxForm({
						dataType: 'json',
						beforeSubmit: function(array) {
							$('#fileupload-form .error').text()
							valid = true;
							if($('#upload-filename').val() == '') {
								$('#fileupload-form .error').text("Please choose a file to upload")
								return false;
							}
							$.each(array, function(index, values) {
								if(!values.value) {
									valid = false
									if(values.name == "filename") {
										$('#fileupload-form .error').text("Please enter a filename")
									}
								}
							});
							return valid;
						},
						beforeSend: function() {
							$('#fileupload-form').hide()
							$('#uploading-bar').show()
							var percentVal = '0%';
							$('#uploading-bar .bar').width(percentVal)
						},
						uploadProgress: function(event, position, total, percentComplete) {
							var percentVal = percentComplete + '%';
							$('#uploading-bar .bar').width(percentVal)
						},
						success: function(response) {
							if(response.error) {
								$('#fileupload-form .error').html(response.error)
								$('#uploading-bar').hide()
								$('#fileupload-form').show()
							} else {
								$("<li><div class=\"thumbnail\"></div></li>").appendTo("#uploaded-img").find(".thumbnail").data("image", response.file)
										.append("<a href=\"#\" class=\"img_sel\" data-size=\"Original\"><img src=\""+response.file.file_small+"\" /></a>")
										.find(".img_sel").data("image", response.file).click(function() { MLM.images.select($(this).data("image")) });
								$('#fileupload-form .error').text()
								$('#uploaded').val("")
								$('#uploading-bar').hide()
								$('#fileupload-form').show()
							}
						}
					});
				}
			});
		},
		select: function(item) {
			if(MLM.images.options.mode == "id") {
				$(MLM.images.options.field).val(item.id)
				$(MLM.images.options.preview).attr("src", ASSET_URL+item.file_small)
				$("#imagemanager").modal("hide")
			}
			return false;
		}
	},
	login: {
		init: function () {
			$(".openid").openid();
		}
	}
}

UTIL = {
	exec: function (controller, action) {
		var ns = MLM,
			action = (action === undefined) ? "init" : action;

		if (controller !== "" && ns[controller] && typeof ns[controller][action] == "function") {
			ns[controller][action]();
		}
	},

	init: function () {
		var body = document.body,
			controller = body.getAttribute("data-controller"),
			action = body.getAttribute("data-action");

		UTIL.exec("common");
		UTIL.exec(controller);
		UTIL.exec(controller, action);
	}
};

$(document).ready(UTIL.init);