<?php
if($front_page) if(count($front_page['others']))
{
	
	?>
	<div class="clear"></div>
	<div id="others-box" class="box relative laptop">
		<h2 class="laptop">Other Articles...</h2>
	<?php
	$nb_articles = 0;
	$row_number = 0;
	$show_row_number = 1;
	
	foreach ($front_page['others'] as $oa) {
		$nb_articles++;
		?>
			<div class="article_preview" rowNumber="<?php echo $show_row_number; ?>">
				<strong><a href="<?php echo $oa['url']; ?>">
				<?php echo mycravings_get_thumbnail($oa['id'], 'mycravings_thumb'); ?>
			    <?php echo $oa['title']; ?></a></strong>
			</div>
		<?php
		
		if($nb_articles % 6 == 0)
		{
			$row_number++;
			$show_row_number = $row_number;			
		}	
	}
	?>
			<div class="clear"></div>
			<?php if($row_number > 1) { ?> <a class="moreArticlesLink">More articles...</a> <?php } ?>
	</div>
	<?php
}
?>
