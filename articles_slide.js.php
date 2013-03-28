<script src="<?php bloginfo('template_url') ?>/js/jquery.touchSwipe.js"></script>
<style>
	.testbox
{
	margin-top:20px;
	margin-bottom:20px;
	max-width:768px;
	height:100px;
	
	padding: 10px;
	background-color: #EEE;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	
	text-align:center;
	font-weight: 300;
	font-size: 20px;
	line-height: 36px;
}

</style>
<script id='code_1'>
				$(function() {			
					//Enable swiping...
					$("#thumbslide").swipe( {
						//Generic swipe handler for all directions
						swipeStatus:function(event, phase, direction, distance) {
							$("#test").text("You swiped " + direction + " "  + distance + " " + $("#thumbslide").css("-webkit-transform"));
							scrollImages($("#thumbslide"), distance, 0);
						},
						allowPageScroll:"vertical",
						//Default is 75px, set to 0 for demo so any distance triggers swipe
					   threshold:0
					});
					
					function scrollImages(thediv, distance, duration)
					{
						thediv.css("-webkit-transition-duration", (duration/1000).toFixed(1) + "s");
						thediv.css("-moz-transition-duration", (duration/1000).toFixed(1) + "s");
						
						//inverse the number we set in the css
						var value = "-"+distance;//(distance<0 ? "" : "-") + Math.abs(distance).toString();
						
						thediv.css("-webkit-transform", "translate3d("+value +"px,0px,0px)");
						thediv.css("-moz-transform", "translate3d("+value +"px,0px,0px)");
						thediv.css("-ms-transform", "translateX("+value +"px)");
					}
					
				});
				
				
</script>
<div id="test" class="testbox">Swipe me</div>