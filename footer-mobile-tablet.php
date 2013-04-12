<div id="mobile-tablet-footer" class="mobile-tablet">
	<div class="transparent-black-box"></div>
	<div class="inside-content">
		<?php if(is_front_page()) { ?>
			<span class="tk-nimbus-sans">OTHER POSTS &rarr;</span>
		<?php } //if(is_front_page()) ?>
		<div class="social-icons"><?php include('social-icons.php'); ?></div>
					<script src="http://widgets.twimg.com/j/2/widget.js"></script> 
					<script> 
					new TWTR.Widget({
					  version: 2,
					  type: 'profile',
					  rpp: 3,
					  interval: 6000,
					  width: 300,
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
					</script> 	</div>
</div>
