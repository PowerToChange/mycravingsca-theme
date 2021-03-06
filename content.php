<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	<div class="box">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			<?php if ( is_single() && !video_on_page() ) :
        mc_use_template_part('article-featured-image.php'); 
			else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
			
		</header><!-- .entry-header -->
		<div class="box-content">
			<?php if ( is_single() ) { ?>
				<em>
					<span class="caption tk-nimbus-sans"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></span><br/>
					<span class="authorField tk-nimbus-sans"><?php echo mc_t('Written By'); ?> <?php the_author_posts_link(); ?></span>
				</em><br/><br/>
				<?php } ?>
			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php else : ?>
			<div class="entry-content">
				<span class="tk-nimbus-sans"><?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></span>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
			<?php endif; ?>
	
			<footer class="entry-meta tk-nimbus-sans">
				<?php if ( is_single() ) { the_tags( '<p>Tags: ', ', ', '</p>'); } ?>
			</footer><!-- .entry-meta -->
			<?php if ( is_single() ) {
				
				 include_once('social-share-this-article.php');
				 include_once('article-list-related.php');
				 comments_template( '', true ); } ?>
		</div>
	</article><!-- #post -->
	</div>
