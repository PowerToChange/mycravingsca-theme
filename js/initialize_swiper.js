
var mySwiper;
var bloggerSwiper;
var swiper_nb_slides;
var swiper_width;

$(document).ready(function() {

  swiper_width = $('.swiper-container').width();
  swiper_nb_slides = get_swipers_nb_slides();  

  mySwiper = new Swiper('.swiper-container',{
    loop: false,
    centeredSlides: true,
    initialSlide: 2,
    slidesPerView: swiper_nb_slides
  });
  
  bloggerSwiper = new Swiper('.blogger-swiper-container',{
    loop: false,
    centeredSlides: true,
    initialSlide: 2,
    slidesPerView: 4
  });
  
  $(window).resize(resize_swipers);
  
  resize_swipers();
  
});

function get_swiper_height_dividor()
{
	return get_swipers_nb_slides()*3/2;
}

function get_swipers_nb_slides()
{
	var ret = 4;
	if(swiper_width < 540) ret = 3;
	if(swiper_width < 360) ret = 2;
	return ret;
}

function resize_swipers()
{
  swiper_width = $('.swiper-container').width();
  var dividor = get_swiper_height_dividor();
  var sw_height = Math.floor(swiper_width/dividor);
  var bl_height = Math.floor(swiper_width/4);
  
  if(swiper_nb_slides != get_swipers_nb_slides())
  {
  	swiper_nb_slides = get_swipers_nb_slides()
  	mySwiper.params.slidesPerView = swiper_nb_slides;
  	mySwiper.reInit();
  }
  
  $('.swiper-container').each(function(){
  	$(this).css({'height':sw_height+'px', 'font-size': (sw_height/120) + 'em' });
  });
	
  $('.blogger-swiper-container').each(function(){
  	$(this).css({'width': swiper_width+'px', 'height': bl_height+'px', 'font-size': (bl_height/180) + 'em' });
  	$('.blogger-swiper-container .article_slide').css({'height': bl_height+'px', 'width': bl_height+ 'px' });
  });
	
	
}
