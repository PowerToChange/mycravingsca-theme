<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php facebook_head_stuff(); ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

 <link href="<?php bloginfo('template_url'); ?>/css/fonts.css" rel="stylesheet" />
 <link href="<?php bloginfo('template_url'); ?>/css/social-circle/ss-social-circle.css" rel="stylesheet" />
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/more_articles.js"></script>
<?php include_once('head-include-typekit.php'); // include typekit requirements ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="head_wrapper" class="site">
	<header id="masthead" class="site-header" role="banner">
		<div id="logowrapper"></div>
		<a class="logo" href="<?php bloginfo( 'url' ); ?>"></a>
		<div class="clear"></div>
		<div id="menubar" class="mobile-tablet">
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><span class="tk-nimbus-sans">menu</span>&nbsp;<span class="entypo">&darr;</span>&nbsp;&nbsp;</h3>
			<?php $html_menu = wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'echo' => '0' ) ); ?>
			<span class="tk-abril-dsplay mobile-tablet"><em><?php echo $html_menu; ?></em></span>
		</nav><!-- #site-navigation -->
		</div>
		<div id="menubar-laptop" class="laptop">
			<?php echo $html_menu; ?>
		</div>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>
	</header><!-- #masthead -->
</div> <!-- #head_wrapper --> 
<div id="page_wrapper">
<div id="page" class="hfeed site">

	<div id="main" class="wrapper">