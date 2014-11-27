<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
</div><!-- #page -->
</div><!-- #page_wrapper -->
<?php include('footer-mobile-tablet.php'); ?>
<div id="large_footer" class="laptop">
<div id="footer_wrapper" class="site">
		<footer id="colophon" role="contentinfo">
			<div class="site-info">
				<a class="footerLogo" href="http://p2c.com/students"></a>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #footer_wrapper -->
</div><!-- #large_footer -->
<?php wp_footer(); ?>

  <script src="<?php bloginfo('template_url') ?>/js/idangerous.swiper-2.0.min.js"></script>
  <script src="<?php bloginfo('template_url') ?>/js/initialize_swiper.js"></script>


<!-- optional .js for legacy browser support -->
<script src="<?php bloginfo('template_url') ?>/css/social-circle/ss-social.js"></script>

<!-- google analytics -->
<script src="<?php bloginfo('template_url') ?>/js/fitvids.js"></script>
  <script>
    $(document).ready(function(){
      // Target your .container, .wrapper, .post, etc.
      $("#page_wrapper").fitVids();
    });
  </script>
  
  <!-- Google Analytics -->
  <script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo google_analytics_id(); ?>', 'auto');
  ga('send', 'pageview');

  </script>
  <!-- End Google Analytics -->
  
</body>
</html>
