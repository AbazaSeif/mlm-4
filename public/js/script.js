	$(document).ready(function() {
		$('.slider').coinslider({ 
		width: 600, // width of slider panel
height: 300, // height of slider panel
spw: 8, // squares per width
sph: 8, // squares per height
delay: 7000, // delay between images in ms
sDelay: 30, // delay beetwen squares in ms
opacity: 0.7, // opacity of title and navigation
titleSpeed: 500, // speed of title appereance in ms
effect: 'straight', // random, swirl, rain, straight
navigation: true, // prev next and buttons
links : true, // show images as links
hoverPause: true // pause on hover
		});
	});

