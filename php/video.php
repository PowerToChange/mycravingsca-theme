<?php

/*
 * Needs GD image for php to work
 * Not functionnal right now but works on local machine if called.
 * 
 * */

function mycravings_get_thumbnail($id, $thumb = NULL)
{
	$ret = get_the_post_thumbnail($id, $thumb);
	// image feature disabled for now
	if(false && is_video($id))
	{
		if(preg_match_all('#http://.*\.jpe?g#i', $ret, $arr, PREG_PATTERN_ORDER))
		{
			$url = $arr[0][0];
			get_video_img($url);
			$ret = mycravings_video_url_replace($ret);
		}
	}
	return $ret;
}

function mycravings_video_url_replace($url)
{
	return preg_replace('#/([^/]+)\.jp#', '/\1-vid.jp', $url);
}

function get_video_img($url)
{
	$site = $_SERVER['HTTP_HOST'];
	$base_path = $_SERVER['DOCUMENT_ROOT'];
	$path = str_replace('http://' . $site . '/', $base_path, $url);
	$newpath = mycravings_video_url_replace($path);
	$newurl = mycravings_video_url_replace($url);
	if(!file_exists($newpath))
	{
		$cur = imagecreatefromjpeg($path);
		imagealphablending($cur, true);
		imagesavealpha($cur, true);
		list($w, $h) = getimagesize($path);
		$divider = 7;
		if($w < 200) $divider = 4;
		if($w < 100) $divider = 3;
		
		$butdim = floor($w / $divider);
		$hbd = floor($butdim / 2);
		$butx = floor($w / 2) - $hbd;
		$buty = floor($h / 2) - $hbd;
		
		$play = imagecreatefrompng(get_stylesheet_directory() . '/images/play_icon.png');
		imagealphablending($play, true);
		imagesavealpha($play, true);
		
		imagecopyresized($cur, $play, $butx, $buty, 0, 0, $butdim, $butdim, 89, 89);
		imagedestroy($play);
	
		imagejpeg($cur, $newpath);
		imagedestroy($cur);
	}
	return $newurl;
}


?>