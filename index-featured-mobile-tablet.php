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
<div id="ts_wrapper" class="box mobile-tablet">
	<div id="thumbslide">
		<div class="dragger">
<?php
if($fas) foreach ($fas as $fa) {
	?><a href="<?php echo $fa['url']; ?>"><? 
	echo get_the_post_thumbnail($fa['id'], 'mycravings_mobilethumb'); 
	?></a><?php
}
?>
		</div>
	</div>
</div>
<?php
		}
?>