jQuery(document).ready(function($) {
	// Toggle mobile menu
	$(".nav-toggle").on("click", function() {
		$(this).toggleClass("active");
		$(".primary-menu").slideToggle();
		if ($(".search-toggle").hasClass("active")) {
			$(".search-toggle").removeClass("active");
			$(".search-container").slideToggle();
		}
		return false;
	});
	// Toggle search container
	$(".search-toggle").on("click", function() {
		$(this).toggleClass("active");
		$(".search-container").slideToggle();
		if ($(".nav-toggle").hasClass("active")) {
			$(".nav-toggle").removeClass("active");
			$(".primary-menu").slideToggle();
		}
		return false;
	});
	// Hide mobile menu/search container at resize
	$(window).resize(function() {
		if ($(window).width() >= 850) {
			$(".nav-toggle").removeClass("active");
		}
		if ($(window).width() <= 850) {
			$(".search-toggle").removeClass("active");
			$('.search-container').hide();
		}
	});
	// Dropdown menus on touch devices
	$('.primary-menu li:has(ul)').doubleTapToGo();
	$('.secondary-menu li:has(ul)').doubleTapToGo();
	// Load Flexslider
	$(".flexslider").flexslider({
		animation: "slide",
		controlNav: false,
		prevText: "",
		nextText: "",
		smoothHeight: true
	});
	// smooth scroll for any anchor link on same page
	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
				}, 1000);
				return false;
			}
		}
	});
	// resize videos after container
	var vidSelector = ".post iframe, .post object, .post video";
	var resizeVideo = function(sSel) {
			$(sSel).each(function() {
				var $video = $(this),
					$container = $video.parent(),
					iTargetWidth = $container.width();
				if (!$video.attr("data-origwidth")) {
					$video.attr("data-origwidth", $video.attr("width"));
					$video.attr("data-origheight", $video.attr("height"));
				}
				var ratio = iTargetWidth / $video.attr("data-origwidth");
				$video.css("width", iTargetWidth + "px");
				$video.css("height", ($video.attr("data-origheight") * ratio) + "px");
			});
		};
	resizeVideo(vidSelector);
	$(window).resize(function() {
		resizeVideo(vidSelector);
	});
});