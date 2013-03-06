<?php
		$url = $front->url;
		$title = $front->post_title;
		
		$id = url_to_postid($url);
		$img = get_the_post_thumbnail($id, 'full');
?>

<div class="box">
	<a href="<?php echo $url; ?>">
		<div class="front_article">
			<div class="front_article_title_black_box"></div>
			<div class="front_article_title"><?php echo $title; ?></div>
			<?php echo $img; ?>
		</div>
	</a>
</div><!-- .box -->
