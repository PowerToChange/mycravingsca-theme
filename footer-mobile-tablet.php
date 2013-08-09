<div id="mobile-tablet-footer" class="mobile-tablet">
	<div class="transparent-black-box"></div>
	<div class="inside-content">
		<?php 
		if(is_front_page() || is_launch_page()) { ?>
			<span id="other-posts-button" class="tk-nimbus-sans"><?php echo mc_t('OTHER POSTS'); ?> &rarr;</span>
		<?php 
			global $mycravings_bloggers;
			if(is_array($mycravings_bloggers))
			{
				?>
  <div class="swiping-device mobile-tablet">
    <a class="arrow-left" href="#"></a> 
    <a class="arrow-right" href="#"></a>
	  <div class="blogger-swiper-container">
	    <div class="swiper-wrapper">
<?php
foreach ($mycravings_bloggers as $author_id) {
	$img_url = Blogger_Facepile_Widget::get_author_img($author_id);
	$data = array();
	$data['url'] = get_author_posts_url($author_id);
	$data['thumbnail_mobilethumb'] = "<img src=\"$img_url\">";
	$data['cropped_title'] = get_userdata($author_id)->display_name;
	?>
        <div class="swiper-slide">
          <div class="content-slide blogger-slide">
	<?php mc_use_template_part_with_data('article-list-slide.php', $data);	?>
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
		} //if(is_front_page())
		
		 ?>
		<div class="social-icons"><?php include('social-icons.php'); ?></div>
					<script src="http://widgets.twimg.com/j/2/widget.js"></script> 
					<script> 
					new TWTR.Widget({
					  version: 2,
					  type: 'profile',
					  rpp: 3,
					  interval: 6000,
					  width: 320,
					  height: 250,
					  theme: {
					    shell: {
					      background: '#878787',
					      color: '#FFFFFF'
					    },
					    tweets: {
					      background: '#878787',
					      color: '#FFFFFF',
					      links: '#A7C9CE'
					    }
					  },
					  features: {
					    scrollbar: false,
					    loop: false,
					    live: false,
					    hashtags: true,
					    timestamp: true,
					    avatars: false,
					    behavior: 'all'
					  }
					}).render().setUser('my_cravings').start();
					</script> 	
		<a class="footerLogo" href="http://p2c.com/students"></a>
	</div>

</div>
