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
  <div class="device">
    <a class="arrow-left" href="#"></a> 
    <a class="arrow-right" href="#"></a>
    <div class="swiper-container">
      <div class="swiper-wrapper">
<?php
foreach ($fas as $fa) {
	?>
        <div class="swiper-slide">
          <div class="content-slide">
	<?php mc_use_template_part_with_data('article-listed-with-excerpt.php', $fa);	?>
          </div>
        </div>
<?php
}
?>
      </div>
    </div>
    <div class="pagination"></div>
  </div>
  <script src="<?php bloginfo('template_url') ?>/js/idangerous.swiper-2.0.min.js"></script>
  <script>
  var mySwiper = new Swiper('.swiper-container',{
    pagination: '.pagination',
    loop:true,
    grabCursor: true,
    paginationClickable: true
  })
  $('.arrow-left').on('click', function(e){
    e.preventDefault()
    mySwiper.swipePrev()
  })
  $('.arrow-right').on('click', function(e){
    e.preventDefault()
    mySwiper.swipeNext()
  })
  </script>
<?php
		}
?>