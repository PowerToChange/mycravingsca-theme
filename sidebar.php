<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $launch_page;
?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area box laptop" role="complementary">
			<?php include('social-icons.php'); ?>
			<?php 
				if($launch_page) { dynamic_sidebar( 'launch_right'); }
				else { dynamic_sidebar( 'sidebar-1' ); }
			 ?>
		</div><!-- #secondary -->
	<?php endif; ?>