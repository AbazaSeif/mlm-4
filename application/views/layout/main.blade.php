<!doctype html>
<!--[if IE]><style type="text/css">.timer { display: none !important; } div.caption { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000);zoom: 1; }</style><![endif]-->
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	@if (isset($title)) 
	<title>{{$title}} &raquo; MLM</title>
	@else 
	<title>Major League Mining</title>
	@endif
	<meta name="robots" content="all">
	<meta name="description" content="The official site for the Major League Mining">
	<meta name="keywords" content="minecraft, race for wool, wool, competitive minecraft, tournaments, official site, rmct, reddit">
	<meta name="copyright" content="Major League Mining 2012">
	<link type="text/plain" rel="author" href="{{ URL::to_asset("humans.txt") }}" />
	<link type="text/plain" rel="hackers" href="{{ URL::to_asset("hackers.txt") }}" />
	
	<link rel="shortcut icon" href="{{ URL::to_asset("images/static/favicon.ico") }}" />
	<link rel="apple-touch-icon" href="{{ URL::to_asset("images/static/apple-touch-icon-iphone.png") }}" /> 
	<link rel="apple-touch-icon" sizes="72x72" href="{{ URL::to_asset("images/static/apple-touch-icon-ipad.png") }}" /> 
	<link rel="apple-touch-icon" sizes="114x114" href="{{ URL::to_asset("images/static/apple-touch-icon-iphone4.png") }}" />
	<link rel="apple-touch-icon" sizes="144x144" href="{{ URL::to_asset("images/static/apple-touch-icon-ipad3.png") }}" />
	
	<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/style.css") }}" />
	<script src="{{ URL::to_asset("js/libs/modernizr-2.5.3-respond-1.1.0.min.js") }}"></script>
	<script type="text/javascript">
		var BASE_URL = "{{ URL::base() }}";
		var ASSET_URL = "{{ URL::to_asset(null) }}";
	</script>
</head>
@if(isset($javascript))
@if(count($javascript) > 1)
<body data-controller="{{ $javascript[0] }}" data-action="{{ $javascript[1] }}">
@else
<body data-controller="{{ $javascript[0] }}">
@endif
@else
<body>
@endif
	<!--[if lt IE 7]><p class="chromeframe">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/?locale=en">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<header id="global-header">
		<div id="bg">
		<div class="holder">
			<div id="logo">
				<a href="{{ URL::to("/") }}" title="Major League Mining">
					<img src="{{ URL::to_asset("images/static/logo.png") }}" />
					<h1>MAJOR LEAGUE MINING</h1>
				</a>
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
	<footer id="global-footer" class="clearfix">
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
	</footer>
	@yield("postfooter")
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="{{ URL::to_asset("js/libs/jquery-1.7.2.min.js") }}"><\/script>')</script>
	<script src="{{ URL::to_asset("js/plugins.js") }}"></script>
	<script src="{{ URL::to_asset("js/script.js") }}"></script>
</body>
</html>