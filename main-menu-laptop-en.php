    <div class="menu">
        <span>
            <ul id="nav">
                <li><a href="<?php bloginfo('url'); ?>">Home</a></li>
                <li><a href="<?php bloginfo('url'); ?>/about-us/">About Us</a></li>
                <li><a href="#">Cravings</a>
                    <div class="subs">
                        <div>
                            <ul>
                              <li><a href="<?php bloginfo('url'); ?>/power/">Power</a></li>
                              <li><a href="<?php bloginfo('url'); ?>/acceptance/">Acceptance</a></li>
                              <li><a href="<?php bloginfo('url'); ?>/security/">Security</a></li>
                              <li><a href="<?php bloginfo('url'); ?>/pleasure/">Pleasure</a></li>
                              <li><a href="<?php bloginfo('url'); ?>/purpose/">Purpose</a></li>
                              <li><a href="<?php bloginfo('url'); ?>/meaning/">Meaning</a></li>
                        </div>
                    </div>
                </li>
                <li><a href="#">Topics</a>
                    <div class="subs">
                        <div>
                            <ul>
                              <li><a href="<?php bloginfo('url'); ?>/school/">School</a></li>
                              <li><a href="<?php bloginfo('url'); ?>/culture/">Culture</a></li>
                              <li><a href="<?php bloginfo('url'); ?>/life/">Life</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li><a href="<?php bloginfo('url'); ?>/video/">Video</a></li>
            </ul>
        </span>
    </div>
 
<script type="text/javascript">
jQuery(window).load(function() {
 
    $("#nav > li > a").click(function (e) { // binding onclick
        if ($(this).parent().hasClass('selected')) {
            $("#nav .selected div div").slideUp(100); // hiding popups
            $("#nav .selected").removeClass("selected");
        } else {
            $("#nav .selected div div").slideUp(100); // hiding popups
            $("#nav .selected").removeClass("selected");
 
            if ($(this).next(".subs").length) {
                $(this).parent().addClass("selected"); // display popup
                $(this).next(".subs").children().slideDown(200);
            }
        }
        e.stopPropagation();
    });
 
    $("body").click(function () { // binding onclick to body
        $("#nav .selected div div").slideUp(100); // hiding popups
        $("#nav .selected").removeClass("selected");
    });
 
});
</script>
