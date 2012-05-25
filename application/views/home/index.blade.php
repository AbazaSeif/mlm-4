<script src="{{ URL::to_asset("js/libs/coin-slider.min.js") }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/coin-slider-styles.css") }}" />
	
	<script type="text/javascript">
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
    effect: 'straigth', // random, swirl, rain, straight
    navigation: true, // prev next and buttons
    links : true, // show images as links
    hoverPause: true // pause on hover
		
	});
	});
</script>

<div id="home">
<div class="slider">

	<a href="img01_url" target="_blank">
		<img src='http://www.crazybutable.com/sites/default/files/styles/weblog/public/project_documentation_images/forrest-2538.jpg' >
		<span>
			Description for img01
		</span>
	</a>
	......
	......
	<a href="imgN_url">
		<img src='http://www.filminamerica.com/Movies/ForrestGump/gump02.jpg' >
		<span>
			Description for imgN
		</span>
	</a>
</div>


<div class="featured">
<br style="clear:both" />
</div>

<div class="ticker">
<br style="clear:both" />
</div>

</div>