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

	<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("assets/style.css") }}">

	<script src="{{ URL::to_asset("js/libs/modernizr-2.5.3-respond-1.1.0.min.js") }}"></script>
</head>
<body>
<header name="global header">
<div id="logobg"><br style="clear:both" /></div>
<div class="logoholder">
<div class="logo">
<h1>MAJOR LEAGUE MINING</h1>
<a href="#" title="MLM"><img src="images/logo.png" /></a>
</div>
<div id="logs"><a href="#">Login</a> &bull; <a href="#">Create Account</a></div>
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
@endsection