<?php
// Much of this via http://pastebin.com/M9eg9NH7

function is_404($url) {
	$handle = curl_init($url);
	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($handle);
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	curl_close($handle);
 
	if ($httpCode >= 200 && $httpCode < 300) {
		return false;
	} else {
		return true;
	}
}
$username = $_GET['user'];
if(!preg_match('/^[a-z0-9_]*$/i', $username)) {
	header("HTTP/1.0 400 Bad Request", true, 400);
	die();
}
$fn = 'images/skins/'.$username.'.png';

// If doesn't exist or older than 1 days
if(!file_exists($fn) or (filemtime($fn) + 60 * 60 * 24 * 1) < time()) {
	$url = 'http://s3.amazonaws.com/MinecraftSkins/'.$username.'.png';
	if(is_404($url)) {
		$url = 'images/steve.png';
	}
	
	$scale = 8; // image size = 8px * scale
	$skin = imagecreatefrompng($url);
	$preview = imagecreatetruecolor(16*$scale, 32*$scale);
	imagesavealpha($preview, true);
	imagefill($preview, 0, 0, imagecolorallocatealpha($preview, 255, 255, 255, 127));
	
	// head
	imagecopyresized($preview, $skin,  4*$scale,         0,  8,  8,  8*$scale,  8*$scale, 8,  8);
	
	// chest	
	imagecopyresized($preview, $skin,  4*$scale,  8*$scale, 20, 20,  8*$scale, 12*$scale, 8, 12);
	
	// arms
	imagecopyresized($preview, $skin,         0,  8*$scale, 44, 20,  4*$scale, 12*$scale, 4, 12);
	imagecopyresized($preview, $skin, 12*$scale,  8*$scale, 44, 20,  4*$scale, 12*$scale, 4, 12);
	
	// legs
	imagecopyresized($preview, $skin,  4*$scale, 20*$scale,  4, 20,  4*$scale, 12*$scale, 4, 12);
	imagecopyresized($preview, $skin,  8*$scale, 20*$scale,  4, 20,  4*$scale, 12*$scale, 4, 12);
	
	// hat
	imagecopyresized($preview, $skin,  4*$scale,         0, 40,  8,  8*$scale,  8*$scale, 8,  8);

	imagedestroy($skin);
	
	header("Content-type: image/png");
	imagepng($preview, $fn);
}

if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($fn))) {
	// Client's cache IS current, so we just respond '304 Not Modified'.
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($fn)).' GMT', true, 304);
} else {
	// Image not cached or cache outdated, we respond '200 OK' and output the image.
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($fn)).' GMT', true, 200);
	header('Content-Length: '.filesize($fn));
	header('Content-Type: image/png');
	print file_get_contents($fn);
}

