<?php
if($front_page) 
	if(array_key_exists('featured', $front_page))
		if(count($front_page['featured']))
		{
			if(count($front_page['recent']))
				$fas = array_merge($front_page['featured'], $front_page['recent']);
			else
				$fas = $front_page['featured'];
?>
<div id="ts_wrapper" class="box pad mobile-tablet">
	<ul class="featured-articles">
<?php
if($fas) foreach ($fas as $fa) {
	?>
	<li>
		<a href="<?php echo $fa['url']; ?>"><? echo get_the_post_thumbnail($fa['id'], 'mycravings_thumb'); ?></a>
		<a class="fa-title" href="<?php echo $fa['url']; ?>"><strong><?php echo $fa['title']; ?></strong></a>
		<?php echo $fa['excerpt']; ?>
		<a href="<?php echo $fa['url']; ?>">Read More &gt;</strong></a><br />
	</li>
	<?php
}
?>
	</ul>
</div>
<?php
		}
?>