<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	@if (isset($title)) 
	<title>{{$title}} | Major League Mining</title>
	@else 
	<title>Major League Mining</title>
	@endif
	<meta name="robots" content="index,follow">
	<meta name="googlebot" content="index,follow">
	<meta name="description" content="Competitive Minecraft and the best from the Minecraft community">
	<meta name="keywords" content="minecraft, race for wool, wool, competitive minecraft, tournaments, official site, rmct, reddit">
	<meta name="copyright" content="Major League Mining">
	<link type="text/plain" rel="author" href="{{ URL::to_asset("humans.txt") }}" />
	<link type="text/plain" rel="hackers" href="{{ URL::to_asset("hackers.txt") }}" />
	
	@if(isset($social) && is_array($social))
	@foreach($social as $skey => $scontent)
	<meta property="og:{{$skey}}" content="{{ e($scontent) }}" />
	@endforeach
	@endif

	<link rel="shortcut icon" href="{{ URL::to_asset("images/static/favicon.ico") }}" />
	<link rel="image_src" href="{{ URL::to_asset("images/static/mlm.png") }}" />
	<link rel="apple-touch-icon-precomposed" href="{{ URL::to_asset("images/static/apple-touch-icon.png") }}" />
	
	<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/fonts.css") }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/bootstrap.css") }}" />
	<!--[if IE]><link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/ie-sucks.css") }}" /><![endif]-->
	<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/style.css") }}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/nivo/nivo-slider.css") }}" />

	<script src="{{ URL::to_asset("js/libs/modernizr-2.5.3-respond-1.1.0.min.js") }}"></script>
	<script type="text/javascript">
		var BASE_URL = "{{ URL::to() }}";
		var ASSET_URL = "{{ URL::to_asset(null) }}";
	</script>

</head>
@if(isset($javascript))
@if(count($javascript) > 1)
<body data-controller="{{ $javascript[0] }}" data-action="{{ $javascript[1] }}" class="{{ Cookie::get_raw("multibg", 'bg-white') }}">
@else
<body data-controller="{{ $javascript[0] }}" class="{{ Cookie::get_raw("multibg", 'bg-white') }}">
@endif
@else
<body class="{{ Cookie::get_raw("multibg", 'bg-white') }}">
@endif
	<!--[if lt IE 7]><p class="chromeframe">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/?locale=en">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<noscript>
		<div class="y-u-no-have-javascript-enabled">Major League Mining requires JavaScript to be enabled. Please turn on JavaScript or add us to your exceptions</div>
	</noscript>
	<div class="global-wrapper">
		<header id="global-header">
			<div id="main">
				<div class="holder clearfix">
					<div id="logo">
						<a href="{{ URL::to("/") }}" title="Major League Mining">
							<img src="{{ URL::to_asset("images/static/logo.png") }}" />
							<h1>MAJOR LEAGUE MINING</h1>
						</a>
					</div>
					<div id="loginout">
						@if (Auth::user())
							{{ HTML::link_to_action('account@logout', "Logout") }}
							@if(Auth::user()->admin)
								{{ HTML::link('admin', 'Admin panel'); }}
							@endif
							{{ HTML::link('account', 'Edit Account'); }}
							<a href="/messages" title="{{ e(Auth::user()->unread_messages) }} new messages" style="border-right: none;padding-right: 0;">[{{ e(Auth::user()->unread_messages) }}]</a>
							<a href="{{ URL::to("user/".Auth::user()->username) }}" title="View your profile" style="padding-left: 0">Profile <img src="{{ Auth::user()->avatar_url }}" alt="avatar" /></a>
						@else
						{{ HTML::link('login', "Login &bull; Create account", array("class" => "nosep")) }}
						@endif
					</div>
					<a href="#" id="shownav"><i class="icon-reorder"></i></a>
				</div>
			</div>	
				<nav id="menu">
					<ul class="loginout">
						@if (Auth::check())
						<li>{{ HTML::link_to_action('account@logout', "Logout") }} </li>
						<li>{{ HTML::link('account', 'Edit Account'); }}</li>
						<li><a href="{{ URL::to("user/".Auth::user()->username) }}" title="View your profile">Profile <img src="{{ Auth::user()->avatar_url }}" alt="avatar" width="30" /></a></li>
						@else
						<li>{{ HTML::link('login', "Login &bull; Create account", array("class" => "nosep")) }}</li>
						@endif
					</ul>
					<ul id="mainmenu">
						<li><a href="{{ URL::to("/") }}">Home</a></li> 
						<li>{{ HTML::link('news', 'News'); }}</li>
						<li>{{ HTML::link('matches', 'Matches'); }}</li>
						<li>{{ HTML::link('teams', 'Teams'); }}</li> 
						<li>{{ HTML::link('maps', 'Maps'); }}</li>
						<li>{{ HTML::link('faq', 'FAQ'); }}</li>
						<div id="search" class="right clearfix">
							<form method="get" action="/search" class="">
								<div class="input-append">
								@if (isset($moduleURL))
								<input id="type" name="type" type="hidden" value={{ $moduleURL }}>
								@endif
								<input id="main-search" name="query" class="sbar" size="16" type="text"><button class="btn" type="button"><i class="icon-search icon-white"></i></button>
								</div>
							</form>
						</div>
					</ul>
				</nav>
		</header>
		<div id="wrapper">
			{{ Messages::get_html() }}
			@yield('content')
		</div>
	</div>
	<footer id="global-footer" class="clearfix">
		<div class="holder">
		<div class="left">
			<img src="{{ URL::to_asset("images/static/logo.png") }}" width="70" />
			<p>&copy;2012 Major League Mining</p>
		</div>
		<div class="right">
			<a href="http://facebook.com/mlm" title="Like us on Facebook" class="fb"><i class="icon-facebook-sign"></i></a>
			<a href="http://twitter.com/mlm" title="Follow us on Twitter" class="tw"><i class="icon-twitter-sign"></i></a>
			<a href="http://plus.google.com/+mlm" title="Circle us on Google+" class="gp"><i class="icon-google-plus-sign"></i></a>
		</div>
		</div>	
	</footer>

	@yield("postfooter")
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="{{ URL::to_asset("js/libs/jquery-1.8.0.min.js") }}"><\/script>')</script>

	<script src="{{ URL::to_asset("js/libs/showdown.js") }}"></script>
	<script src="{{ URL::to_asset("js/plugins.js") }}"></script>
	<script src="{{ URL::to_asset("js/script.js") }}"></script>
	<script>
		var _gaq=[['_setAccount','UA-XXXXXXX-X'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
</body>
</html>