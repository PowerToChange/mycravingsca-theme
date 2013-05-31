<?php
include_once ('functions_mc_load.php');
include_once ('php/mc.php');

define('MYCRAVINGS_TEMPLATE_DIR', dirname(__FILE__));

/*
 * Here are the functions you should call from template pages.
 * 
 * See
 * 	 php/class/MyCravingsFr.class.php for jaisoif.ca specific functions
 * 	 php/class/MyCravingsEn.class.php for mycravings.ca specific functions
 * 	 php/class/MyCravings.class.php for general functions
 * */

function show_front_page()
{
	global $mycravings;
	$mycravings->show_front_page();
}
 
function video_on_page($post_id = NULL) {
	return mc_load('is_video', $id);
}

function facebook_head_stuff() {
	global $mycravings;
	$mycravings->facebook_head_stuff();
}

?>