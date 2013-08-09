
$(document).ready(function() {

  

  var mySwiper = new Swiper('.tablet > .swiper-container',{
    pagination: '.pagination',
    paginationClickable: true,
    loop: true,
    centeredSlides: true,
    slidesPerView: 4 // <- Here is the difference if you're wondering :)
  });
  
  var mySwiper = new Swiper('.mobile > .swiper-container',{
    pagination: '.pagination',
    paginationClickable: true,
    loop: true,
    centeredSlides: true,
    slidesPerView: 3 // <- Here is the difference if you're wondering :)
  });
  
  $(window).resize(resize_swipers);
  
  resize_swipers();
  
});

function resize_swipers()
{
  $('.tablet > .swiper-container:visible').each(function(){
  	var scw = $(this).width();
  	$(this).css({'height':Math.floor(scw/6)+'px'});
  });
	
  $('.mobile > .swiper-container:visible').each(function(){
  	var scw = $(this).width();
  	$(this).css({'height':Math.floor(scw/4.5)+'px'});
  });
	
}
