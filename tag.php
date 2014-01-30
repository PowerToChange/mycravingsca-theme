<?php
/**
 * The template for displaying Tag pages.
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<?php
			the_post();
			$thumbnail_full = mc_load('thumbnail_full');
			rewind_posts();
			?>
			<div class="box">
				<div class="front_article">
					<div class="front_article_title_black_box"></div>
					<div class="front_article_title tk-league-gothic no_author"><?php echo single_tag_title( '', false ); ?></div>
					<?php echo $thumbnail_full; ?>
				</div>

			<?php if ( tag_description() ) : // Show an optional tag description ?>
				<div class="archive-meta"><?php echo tag_description(); ?></div>
			<?php endif; ?>

			</div><!-- .box -->

			<?php
			require('article-list.php');

			twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>