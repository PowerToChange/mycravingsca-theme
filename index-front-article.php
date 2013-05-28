<?php

if(array_key_exists('front', $front_page))
{
	global $post;
	$save_post = $post;

	$id = $front_page['front']['id'];
	$post = get_post($id);
	$url = $front_page['front']['url'];
	$title = video_icon($id) . $post->post_title;
	
	$img = mycravings_get_thumbnail($id, 'mycravings_full');
	
	$post = $save_post;
?>

<div class="box">
	<a href="<?php echo $url; ?>">
		<div class="front_article">
			<div class="front_article_title_black_box"></div>
			<div class="front_article_title tk-league-gothic"><?php echo $title; ?></div>
			<?php echo $img; ?>
		</div>
	</a>
</div><!-- .box -->
<?php
}
?>