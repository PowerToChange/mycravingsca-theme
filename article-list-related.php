<?php /* Start the Loop */ 
$articles = array();

$related_exists = false;

$ids = get_post_meta( $post->ID, '_mc_related_posts', true );

// wp_query to get posts
$the_query = new WP_Query( array( 'post__in' => explode(',',$ids) ) );

// The Loop
while ( $the_query->have_posts() ) {
	$the_query->the_post();
	$related_exists = true;
	$articles[] = mc_get_data_for('article-listed-with-excerpt.php');
}

// Restore original Post Data 
wp_reset_postdata();

if($related_exists)
{
?>

<div class="box pad tablet-laptop">
		<h2><?php echo mc_t('Related Posts'); ?></h2>
	<ul class="featured-articles double-display">
<?php
		foreach ($articles as $article) {
			mc_use_template_part_with_data('article-listed-with-excerpt.php', $article);
		}
?>
	</ul>
	<div class="clear"></div>
</div>
	<div class="box relative mobile">
	<?php
		foreach ($articles as $article) {
			mc_use_template_part_with_data('article-listed-no-excerpt.php', $article);
		}
			?>
			<div class="clear"></div>
	</div>
<?php
}