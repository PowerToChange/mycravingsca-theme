<?php
$more_text = mc_t('Read More');
if($is_video) $more_text = mc_t('Watch');
?>
<li>
	<a href="<?php echo $url; ?>"><? echo $thumbnail_thumb; ?></a>
	<a class="fa-title" href="<?php echo $url; ?>"><strong><?php echo $cropped_title; ?></strong></a>
	<?php echo $excerpt; ?>
	<a href="<?php echo $url; ?>"><?php echo $more_text; ?> &gt;</strong></a><br />
</li>
