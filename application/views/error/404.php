<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>404 - Major League Mining</title>
	<link rel="stylesheet" type="text/css" href="<?php echo URL::to_asset("css/fonts.css"); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo URL::to_asset("css/bootstrap.css") ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo URL::to_asset("css/style.css") ?>" />
	<link rel="shortcut icon" href="/images/static/favicon.ico" />
</head>
<body>
	<div id="actionbox">
	<a href="/" title="Major League Mining"><img src="<?php echo URL::to_asset("images/static/logo.png") ?>" /></a>
			<hr>
			<?php $messages = array('Stronghold not found', 'There is no wool here', 'Wool not found', 'An Enderman stole this page', 'Chunk not found', 'Page blew up', "PC CHUNK LETTER"); ?>
			<h1>404: <?php echo array_rand(array_flip($messages)); ?></h1>
			<hr>
			<p>
				This page probably moved, has been dumped into The Void or has never existed.
				<br> 
				You may check your link for errors or go to back to our <?php echo HTML::link('/', 'home page'); ?>.
			</p>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script>$(document).ready(function() { $('#actionbox').fadeIn(500); });</script>
</body>
</html>