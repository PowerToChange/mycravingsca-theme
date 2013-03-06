<?php

global $post, $post_id;
$save_post = $post;
	
?>
<div class="box half <?php echo $box_placement; ?>">
<h2><?php echo $box_title; ?></h2>
<ul class="featured-articles">
<?php
foreach ($fa_urls as $fa_url) {
	$post = get_post(url_to_postid($fa_url));
	?>
	<li>
	<a href="<?php echo $fa_url; ?>"><? the_post_thumbnail('mycravings_thumb'); ?></a>
	<a class="fa-title" href="<?php echo $fa_url; ?>"><strong><?php echo CropSentence($post->post_title, MAX_TITLE_SIZE); ?></strong></a>
	<?php 
	// for some unknown reason, get_the_excerpt or get_the_content won't work here...
	echo CropSentence($post->post_content, FEATURED_EXCERPT_SIZE); 
	?>
	<a href="<?php echo $fa_url; ?>">Read More &gt;</strong></a><br />
	</li>
	<?php
}
?>
</ul>
</div>
<?php

$post = $save_post;

?>