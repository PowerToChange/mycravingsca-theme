<script src="<?php bloginfo('template_url') ?>/js/jquery.scrollsync.js"></script>
<script>
  $(function() {
    
    // Set header viewport to follow viewport scroll on x axis
    $('#viewport, #header_viewport').
        scrollsync({targetSelector: '#viewport', axis : 'x',mouseMoveHandler:function(){
    console.log("H");
    }});
    
    // Set drag scroll on first descendant of class dragger on both selected elements
    $('#viewport, #ts_wrapper').
        dragscrollable({dragSelector: '.dragger:first', preventDefault: true});
     
  });

</script>
