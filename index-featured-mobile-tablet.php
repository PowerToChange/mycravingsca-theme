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
<!--
<div id="ts_wrapper" class="box pad mobile-tablet">
	<ul class="featured-articles">
<?php
foreach ($fas as $fa) {
	mc_use_template_part_with_data('article-listed-with-excerpt.php', $fa);
}
?>
	</ul>
</div>
-->
  <div class="swiping-device tablet">
    <a class="arrow-left" href="#"></a> 
    <a class="arrow-right" href="#"></a>
	  <div class="swiper-container">
	    <div class="swiper-wrapper">
<?php
if(true) foreach ($fas as $fa) {
	?>
        <div class="swiper-slide">
          <div class="content-slide">
	<?php mc_use_template_part_with_data('article-list-slide.php', $fa);	?>
          </div>
        </div>
<?php
}
?>
      </div>
    </div>
    <div class="pagination"></div>
  </div>

  <div class="swiping-device mobile">
    <a class="arrow-left" href="#"></a> 
    <a class="arrow-right" href="#"></a>
	  <div class="swiper-container">
	    <div class="swiper-wrapper">
<?php
if(true) foreach ($fas as $fa) {
	?>
        <div class="swiper-slide">
          <div class="content-slide">
	<?php mc_use_template_part_with_data('article-list-slide.php', $fa);	?>
          </div>
        </div>
<?php
}
?>
      </div>
    </div>
    <div class="pagination"></div>
  </div>
<?php
		}
?>