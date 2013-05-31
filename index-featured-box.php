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
foreach ($front_page[$box_key] as $fa) {
	mc_use_template_part_with_data('article-listed-with-excerpt.php', $fa);
}
?>
</ul>
</div>
<?php
		}
?>