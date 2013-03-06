// JavaScript Document
var the_row = 1;

$(document).ready(function() {
	$('.article_preview').each(function(index){ if ($(this).attr('rownumber') != "1") { $(this).hide(); } });
	$('.moreArticlesLink').click(function(){
		the_row++;
		var keep_button = false;
		$('.article_preview').each(function(index){ 
			if ($(this).attr('rownumber') == the_row) { $(this).fadeIn(1000); } 
			if ($(this).attr('rownumber') == the_row + 1) { keep_button = true; } 
		});
		if(!keep_button) $(this).fadeOut(1000);
	});
});
