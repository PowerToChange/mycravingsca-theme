<?php
/**
 * The template for displaying Author Archive pages.
 *
 * Used to display archive-type pages for posts by an author.
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
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>

			<?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
			?>

			<?php twentytwelve_content_nav( 'nav-above' ); ?>
			<div class="clear"></div>
			<?php
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author_presentation box tablet-laptop">
				<div class="author-description">
					<div class="wrap_author_picture">
							<?php the_author_image(); ?>
							<div class="front_article_title_black_box"></div>
							<div class="front_article_title tk-league-gothic"><?php the_author(); ?></div>
					</div>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div>
			</div><!-- .author-info -->
			<div class="author_presentation box mobile">
				<div class="author-description">
					<div class="center_this">
						<div class="wrap_author_picture">
								<?php the_author_image(); ?>
								<div class="front_article_title_black_box"></div>
								<div class="front_article_title tk-league-gothic"><?php the_author(); ?></div>
						</div>
					</div>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
			<?php else : ?>
				<?php $thumbnail_full = mc_load('thumbnail_full'); ?>
			<div class="box">
				<div class="front_article">
					<div class="front_article_title_black_box"></div>
					<div class="front_article_title tk-league-gothic"><?php the_author(); ?></div>
					<?php echo $thumbnail_full; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php require('article-list.php') ?>
			<?php twentytwelve_content_nav( 'nav-below' ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>