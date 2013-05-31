<?php
$url = "http://local.mycravings.ca/wp-content/uploads/2013/03/medium_4608514052.jpg";

$site = $_SERVER['HTTP_HOST'];
$base_path = $_SERVER['DOCUMENT_ROOT'];
$path = str_replace('http://' . $site . '/', $base_path, $url);
$newpath = preg_replace('#/([^/]+)\.jp#', '/\1-vid.jp', $path);
$newurl = preg_replace('#/([^/]+)\.jp#', '/\1-vid.jp', $url);

	$cur = imagecreatefromjpeg($path);
	imagealphablending($cur, true);
	imagesavealpha($cur, true);
	$dim = getimagesize($path);
	$butdim = floor($dim[0] / 7);
	$hbd = floor($butdim / 2);
	$butx = floor($dim[0] / 2) - $hbd;
	$buty = floor($dim[1] / 2) - $hbd;
	
	$play = imagecreatefrompng('/home/jacques/git/powertochange/jaisoif/images/play_icon.png');
	imagealphablending($play, true);
	imagesavealpha($play, true);
	
	imagecopyresized($cur, $play, $butx, $buty, 0, 0, $butdim, $butdim, 89, 89);
	imagedestroy($play);

//	header('Content-type: image/png');
	imagejpeg($cur, $newpath);
	imagedestroy($cur);
	echo "<img src=\"$newurl\" />";
	
	//var_dump($_SERVER);
?>