/* ----------------------------------------------
            MAJOR LEAGUE MINING 2012
             Credits on /humans.txt
-------------------------------------------------*/

MLM = {
	common: {
		init: function () {
		// Parallax body background
		(function () {
			var a = document.body,
			e = document.documentElement;
			$(window).unbind("scroll").scroll(function () {
			a.style.backgroundPosition = "0px " + -(Math.max(e.scrollTop, a.scrollTop) / 10) + "px" })
		})();
		// MultiBG
			$("#multibg [data-mbg]").click(function() {
				var newBg = $(this).data("mbg")
				if($("body").hasClass(newBg)) {
					return true;
				}
				$("body").removeClass().addClass(newBg);
				$.cookie("multibg", newBg, {expires: 365})
			});
		// Responsive menu toggle
			$("#shownav").click(function () {
				$("#menu").slideToggle().show();
			});	
		// Cool actionbox 
			$('#actionbox').hide().fadeIn(1000);
		// Activate Bootstrap Dropdowns
			$('.dropdown-toggle').dropdown();
		// Search bar
			$("#main-search").val("Search...");
			$("#main-search").focus(function(){
				if($(this).val() == "Search...") { $(this).val(""); }
			});
			$("#main-search").blur(function(){
				if($(this).val() == "") { $(this).val("Search...");	}
			});
		// Lazyload images
			$(".post img").lazyload({
     			effect:"fadeIn"
			});
		// User WYSIWYG Editor
			$("textarea[data-wysiwyg-user]").cleditor({
				controls: 'bold italic strikethrough | bullets numbering | link unlink | removeformat',
				docType: '<!DOCTYPE html>'
			});
		// Show/Hide Markdown Live Preview
			$("#prevb").click(function () {
				$("#comment").fadeToggle(300);
				return false;
			});
		// Markdown Live Preview
			$('#mrk').wysiwym(Wysiwym.Markdown, {});
				var showdown = new Showdown.converter();
				var previousValue = null;
				var previewTextarea = $('#mrk');
				var previewOutput = $('#preview');
				var updateLivePreview = function() {
				var newValue = previewTextarea.val();
					if (newValue != previousValue) {
					previousValue = newValue;
				var newHtml = $("<div>"+ showdown.makeHtml(newValue) +"</div>");
				previewOutput.html(newHtml);
			}
			}
        	setInterval(updateLivePreview, 100);
		}
	},
	home: {
		init: function () {
			$('#slider').nivoSlider({
        		effect: 'sliceDown',
        		slices: 15,
        		boxCols: 8,
        		boxRows: 4,
        		animSpeed: 600,
        		pauseTime: 6000,
        		startSlide: 0,
        		directionNav: true,
        		controlNav: false,
        		controlNavThumbs: false,
        		pauseOnHover: true,
        		manualAdvance: false,
        		prevText: 'Prev',
        		nextText: 'Next',
        		randomStart: false
			});
		}
	},
	maps: {
		list: function() {
			UTIL.exec("multiview");
		},
		view: function () {
		// Maps slideshow
			$("#maps-slider").nivoSlider({
				effect: 'fade',
				animSpeed: 800,
				pauseTime: 5000,
				startSlide: 0,
				directionNav: true,
				controlNav: true,
				controlNavThumbs: false,
				pauseOnHover: true,
				manualAdvance: false,
				prevText: 'Prev',
				nextText: 'Next',
				randomStart: false
			});
			$(".autosubmit > form").change(function() {
     			$(this).submit();
   			});
		},
		edit: function() {
		}
	},
	profile: {
		home: function() {
		$('#vcard .stats a').click(function (e) {
  			e.preventDefault();
  		$(this).tab('show');
		});
		},
		messages: function() {
			// Show/Hide Message actions
			$("#mess-ac-open").click(function () {
				$("#mess-actions").fadeToggle(300);
				return false;
			});
		}
	},
	admin: {
		init: function () {
			// Admin menu toggle
			$("#show-adminmenu").click(function () {
				$("#adminmenu").fadeToggle(300);
				return false;
			});
			$("#adminmenu").mouseleave(function(){
				$(this).fadeOut(300);
				return false;
			});
			// Make tables sortable
			$("#sortable").tablesorter();
			// Admin WYSIWYG Editor
			$("textarea[data-wysiwyg]").cleditor({
				docType: '<!DOCTYPE html>'
			});
		},
		edit: function() {
			
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
		load: function(url, request) {
			if(!url) {
				url = BASE_URL+'imgmgr'
			}
			$("#imagemanager .modal-body").html("<img src=\""+ASSET_URL+"images/static/ajax-loader.gif\">").load(url, request, function() {
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

				// Catch all imgmgr links
				$("a[href^='"+BASE_URL+"imgmgr']").click(MLM.images.linkcatcher);

			});
		},
		linkcatcher: function(event) {
			MLM.images.load(event.target.href);
			return false;
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
			$(".openid-form, .globalid").openid().on("submit", function() {
				$(this).after('<div class="progress progress-inverse progress-striped active" style="width:310px;margin:0 auto;"><div class="bar" style="width: 100%;"></div></div>')
			});
		}
	},
	multiview: {
		init: function() {
			$("#multiview-controller [data-multiview]").click(function() {
				var newView = $(this).data("multiview")
				if($("#multiview>ul").hasClass(newView)) {
					return true;
				}
				$("#multiview>ul").hide().removeClass().fadeIn(300).addClass(newView)
				$.cookie("multiview", newView, {expires: 365, path: '/'})
			});
			// Lazyload images
			$("#multiview img").lazyload({
     			effect:"fadeIn"
			});
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