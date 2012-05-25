<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	@if (isset($title))
	<title>{{$title}} | Major League Mining</title>
	@else
	<title>Major League Mining</title>
	@endif
	<meta name="description" content="">
	<meta name="author" content="">

	<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/style.css") }}" />
	<script src="{{ URL::to_asset("js/libs/modernizr-2.5.3-respond-1.1.0.min.js") }}"></script>
<script src="{{ URL::to_asset("js/libs/jquery-1.7.2.min.js") }}"></script>
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
	
</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/?locale=en">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

<header name="global header">
<div id="logobg"><br style="clear:both" /></div>
<div class="logoholder">
<div class="logo">
<h1>MAJOR LEAGUE MINING</h1>
<a href="#" title="MLM"><img src="images/logo.png" /></a>
</div>
<div id="logs">
@if (Auth::check())
 {{ Auth::user()->username }} &bull; {{ HTML::link_to_action('account@logout', "Logout") }} 
@else
{{ HTML::link_to_action('account@login', "Login") }} &bull; {{ HTML::link_to_action('account@register', "Create Account") }} 
@endif
</div>
</div>

<nav id="menu">
<ul>
<li><a href="#">Home</a></li> 
<li><a href="#">News</a></li> 
<li><a href="#">Tournaments</a></li>
<li><a href="#">Maps</a></li>
<li><a href="#">Teams</a></li> 
<li><a href="#">Rankings</a></li> 
<li><a href="#">FAQ</a></li> 
</ul>
</nav>
</header>

<div id="wrapper">
 {{ Messages::get_html() }}	
@include('home.index')
  
		<div class="content">
		&nbsp;
		</div> 
		
		
	</div>	
		
<footer>
<div class="column">
<h3>Heading</h3>
All sorts of awesome footer goodness
</div>
<div class="column">
<h3>Heading</h3>
All sorts of awesome footer goodness
</div>
<div class="column">
<h3>Heading</h3>
All sorts of awesome footer goodness
</div>
<div class="clear"></div>
</footer>		
		
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<!--<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>-->

</body>
</html>
