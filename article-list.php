<?php /* Start the Loop */ 
$articles = array();
while ( have_posts() ){
	the_post(); 
	$articles[] = mc_get_data_for('article-listed-with-excerpt.php');
}

?>

<div class="box pad tablet-laptop">
		<h2><?php echo mc_t('Posts'); ?></h2>
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