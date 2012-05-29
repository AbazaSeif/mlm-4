<!doctype html>
<!--[if IE]><style type="text/css"> .timer { display: none !important; } div.caption { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000);zoom: 1; }</style><![endif]-->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	@if (isset($title)) 
	<title>{{$title}} | MLM</title>
	@else 
	<title>Major League Mining</title>
	@endif
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/style.css") }}" />
	<script src="{{ URL::to_asset("js/libs/modernizr-2.5.3-respond-1.1.0.min.js") }}"></script>
</head>
<body>
	<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/?locale=en">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<header name="global header">
		<div id="logobg"><br class="clear" /></div>
		<div class="logoholder">
			<div class="logo">
				<h1>MAJOR LEAGUE MINING</h1>
				<a href="{{ URL::to("/") }}" title="Major League Mining"><img src="{{ URL::to_asset("images/static/logo.png") }}" /></a>
			</div>
			<div id="logs">
			@if (Auth::user() && Auth::user()->admin)
				{{ HTML::link('admin', 'Admin panel'); }} &bull; <a href="{{ URL::to("user/".Auth::user()->username) }}">{{ Auth::user()->username }}</a> &bull; {{ HTML::link_to_action('account@logout', "Logout") }} 
			@elseif (Auth::check())
				<a href="{{ URL::to("user/".Auth::user()->username) }}">{{ Auth::user()->username }}</a> &bull; {{ HTML::link_to_action('account@logout', "Logout") }} 
			@else
				{{ HTML::link_to_action('account@login', "Login &bull; Create account") }}
			@endif
			</div>
		</div>
		<nav id="menu">
			<ul>
				<li><a href="{{ URL::to("/") }}">Home</a></li> 
				<li>{{ HTML::link('news', 'News'); }}</li> 
				<li>{{ HTML::link('tournaments', 'Tournaments'); }}</li>
				<li>{{ HTML::link('maps', 'Maps'); }}</li>
				<li>{{ HTML::link('teams', 'Teams'); }}</li> 
				<li>{{ HTML::link('rankings', 'Rankings'); }}</li> 
				<li>{{ HTML::link('faq', 'FAQ'); }}</li> 
			</ul>
		</nav>
	</header>
	<div id="wrapper">
		{{ Messages::get_html() }}	
		@yield('content')
	</div>	
	<footer>
		<div class="column">
			<h3>Heading</h3>
			<p>All sorts of awesome footer goodness</p>
		</div>
		<div class="column">
			<h3>Heading</h3>
			<p>All sorts of awesome footer goodness</p>
		</div>
		<div class="column">
			<h3>Heading</h3>
			<p>All sorts of awesome footer goodness</p>
		</div>
		<br class="clear" />
	</footer>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="{{ URL::to_asset("js/libs/jquery-1.7.2.min.js") }}"><\/script>')</script>
	<script src="{{ URL::to_asset("js/plugins.js") }}"></script>
	<script src="{{ URL::to_asset("js/script.js") }}"></script>
</script>
</body>
</html>