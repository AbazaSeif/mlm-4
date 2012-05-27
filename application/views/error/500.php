<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Major League Mining</title>
<link rel="stylesheet" type="text/css" href="<?php echo URL::to_asset("css/style.css"); ?>" />
</head>
<body>
	<div id="errorbox">
	<a href="/"><img src="<?php echo URL::to_asset("images/static/logo.png") ?>" /></a>
	        <br>
			<hr>
			<br>
			<h1>500: Internal Server Error</h1>
			<br>
			<hr>
			<br>
			<p>
				Something got jinxed in our side.
				<br> 
				Try refreshing this page later.
			</p>
            <br>
		<?php echo Form::open("search"); ?>
		<?php echo Form::text("search_term", ""); ?>
		<?php echo Form::submit("Search", array('class' => 'btn-primary')); ?>
		<?php echo Form::close(); ?>
	</div>
</body>
</html>