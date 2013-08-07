<?php
/*
Template Name: Launch page
*/

global $launch_page;
$launch_page = true;
get_header();

?>  
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<div class="box">
				<?php the_content(); ?> 
			</div>
<?php show_launch_page(); ?>
		</div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

