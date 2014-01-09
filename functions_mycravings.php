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

function is_launch_page()
{
	global $launch_page;
	return $launch_page;
}
 
function show_front_page()
{
	global $mycravings;
	$mycravings->show_front_page();
}
 
function show_launch_page()
{
	global $mycravings;
	$mycravings->show_launch_page();
}
 
 function video_on_page($post_id = NULL) {
	return mc_load('is_video', $id);
}

function facebook_head_stuff() {
	global $mycravings;
	$mycravings->facebook_head_stuff();
}

function mc_main_menu() {
	global $mycravings;
	$mycravings->main_menu();	
}

function google_analytics_id()
{
  global $mycravings;
  return $mycravings->google_analytics_id();
}


/**
 * Register our sidebars and widgetized areas.
 *
 */
function launch_widgets_init() {

	register_sidebar( array(
		'name' => 'Launch Page Sidebar',
		'id' => 'launch_right',
		'before_widget' => '<aside class="widget">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'launch_widgets_init' );

?>