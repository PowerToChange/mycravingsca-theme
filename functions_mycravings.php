<?php
define('MAX_TITLE_SIZE', 30);
define('FEATURED_EXCERPT_SIZE', 55);


function show_featured()
{
	$items = wp_get_nav_menu_items('Featured');
	$fa_urls = array();
	$printed_ids = array();

	// print the front article if any	
	if(count($items))
	{
		$front = array_shift($items);
		$printed_ids[url_to_postid($front->url)] = true;
		require('index-front-article.php');
	}

	// array_shift removed the first item, are there any left?
	if(count($items))
	{
		foreach ($items as $fa)
		{
			array_push($fa_urls, $fa->url);
			$printed_ids[url_to_postid($fa->url)] = true;
		}
		$box_title = 'Featured Articles';
		$box_placement = 'left';
		require('index-featured-box.php');

		//reset that array
		$fa_urls = array();
		$nb_posts_needed = (count($items) * 2) + 1;
		
		$query = new WP_Query( 'posts_per_page=' . $nb_posts_needed );
	
		// The Loop
		while ( $query->have_posts() ) :
			$query->the_post();
			$id = get_the_ID();
			if(!array_key_exists($id, $printed_ids) 
				&& count($printed_ids) < $nb_posts_needed)
			{
				array_push($fa_urls, get_permalink());
				$printed_ids[$id] = true;
			}
		endwhile;
		
		wp_reset_postdata();
		
		$box_title = 'Recent Articles';
		$box_placement = 'right';
		require('index-featured-box.php');


	}
	


	
}


/*################################################################
#                                                                #
# You pass the script a string, a length you want the string     #
# to be and the trailing characters, what the function does,     #
# is takes the string, finds the last word that will fit into    #
# the overall length, and return a string that has been cropped. #
# The function makes sure that a word is not cut in half.        #
#                                                                #
##################################################################
#        Written by David Speake - david@evilwarus.com           #
#      Adapted from Oliver Southgate's ASP interpretation        #
#     http://www.haneng.com/code/VBScript/CropSentence.txt       #
##################################################################
#                                                                #
# Examples:                                                      #
#                                                                #
# $strTemp = "Hello, I am a fish and you are not.";              #
# $strTemp = CropSentence($strTemp, 16, "...");                  #
# //returns "Hello, I am a..."                                   #
#                                                                #
# $strTemp = "Hello, I am a fish and you are not.";              #
# $strTemp = CropSentence($strTemp, 17, "...");                  #
# //returns "Hello, I am a fish..."                              #
#                                                                #
################################################################*/
function CropSentence ($strText, $intLength, $strTrail = '...')
{
    $wsCount = 0;
    $intTempSize = 0;
    $intTotalLen = 0;
    $intLength = $intLength - strlen($strTrail);
    $strTemp = '';

    if (strlen($strText) > $intLength) {
        $arrTemp = explode(' ', $strText);
        foreach ($arrTemp as $x) {
            if (strlen($strTemp) <= $intLength) $strTemp .= ' ' . $x;
        }
        $CropSentence = $strTemp . $strTrail;
    } else {
        $CropSentence = $strText;
    }
    
    $len = strlen($CropSentence);
    $lenLimit = $intLength * 1.25;
    if($len > $lenLimit)
    	$CropSentence = mb_substr($strText, 0, $intLength) . $strTrail;

    return $CropSentence;
}

?>