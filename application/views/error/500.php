<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>500 - Major League Mining</title>
	<link rel="stylesheet" type="text/css" href="<?php echo URL::to_asset("css/fonts.css"); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo URL::to_asset("css/bootstrap.css") ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo URL::to_asset("css/style.css") ?>" />
	<link rel="shortcut icon" href="{{ URL::to_asset("images/static/favicon.ico") }}" />
</head>
<body>
	<div id="actionbox">
	<a href="/" title="Major League Mining"><img src="<?php echo URL::to_asset("images/static/logo.png") ?>" /></a>
			<hr>
			<h1>500: Internal Server Error</h1>
			<hr>
			<p>
				Something got jinxed in our side.
				<br> 
				Try refreshing this page later.
			</p>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script> $(document).ready(function() { $('#actionbox').fadeIn(500); }); </script>
</body>
</html>