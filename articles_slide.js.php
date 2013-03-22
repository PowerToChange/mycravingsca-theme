<script src="<?php bloginfo('template_url') ?>/js/jquery.mousewheel.min.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/jquery.browser.min.js"></script>
<script src="<?php bloginfo('template_url') ?>/js/jquery.dragscroll.min.js"></script>
<script>
		$(document).ready(function(){
			$('#ts_wrapper').dragscroll(
			{
				scrollClassName: 'example-1',
				scrollBars: true,
				smoothness: 15,
				mouseWheelVelocity: 2,
			});
		});
	
</script>
