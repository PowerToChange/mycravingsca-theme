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
foreach ($fas as $fa) {
	mc_use_template_part_with_data('article-listed-with-excerpt.php', $fa);
}
?>
	</ul>
</div>
<?php
		}
?>