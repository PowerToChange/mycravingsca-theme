<?php
if($front_page) 
	if(array_key_exists($box_key, $front_page))
		if(count($front_page[$box_key]))
		{
?>
<div class="box half <?php echo $box_placement; ?> laptop">
<h2><?php echo $box_title; ?></h2>
<ul class="featured-articles">
<?php
if(array_key_exists($box_key, $front_page)) foreach ($front_page[$box_key] as $fa) {
	$more_text = "Read More";
	if(is_video($fa['id'])) $more_text = "Watch";
	?>
	<li>
		<a href="<?php echo $fa['url']; ?>"><? echo mycravings_get_thumbnail($fa['id'], 'mycravings_thumb'); ?></a>
		<a class="fa-title" href="<?php echo $fa['url']; ?>"><strong><?php echo $fa['title']; ?></strong></a>
		<?php echo $fa['excerpt']; ?>
		<a href="<?php echo $fa['url']; ?>"><?php echo $more_text; ?> &gt;</strong></a><br />
	</li>
	<?php
}
?>
</ul>
</div>
<?php
		}
?>