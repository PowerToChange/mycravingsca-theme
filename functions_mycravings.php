<?php
define('MAX_TITLE_SIZE', 30);
define('FEATURED_EXCERPT_SIZE', 55);



function show_front_page()
{
	$front_page = collect_articles_placement();
	
	require('index-front-article.php');
	
	$box_title = 'Featured Articles';
	$box_placement = 'left';
	$box_key = 'featured';
	require('index-featured-box.php');
	
	$box_title = 'Recent Articles';
	$box_placement = 'right';
	$box_key = 'recent';
	require('index-featured-box.php');

	echo "<div class=\"clear\"></div>";
	
	require('index-featured-mobile.php');

	require('index-other-articles.php');
}


function &collect_articles_placement()
{
	$front_page = array('printed_ids' => array());

	$items = wp_get_nav_menu_items('Featured');
	
	collect_front($items, $front_page);
	collect_featured($items, $front_page);
	collect_recent_and_others($front_page);

	return $front_page;
}

function collect_front(&$items, &$front_page)
{
	if(count($items))
	{
		$front = array_shift($items);
		$id = url_to_postid($front->url);
		if($id)
		{
			// we have a post with that url, make it front page
			$front_page['printed_ids'][$id] = true;
			$front_page['front'] = array('id' => $id, 'url' => $front->url);
		}
		else {
			// url was invalid, maybe next url is.
			collect_front($items, $front_page);
		}
	}	
}

function collect_featured(&$items, &$front_page)
{
	global $post;
	$save_post = $post;

	$front_page['featured'] = array();
	
	if(count($items))
	{
		foreach ($items as $fa)
		{
			$id = url_to_postid($fa->url);
			if($id)
			{
				// we have a post with that url, add it to featured articles
				// get that post
				$post = get_post($id);
				$excerpt = CropSentence(strip_tags($post->post_content), FEATURED_EXCERPT_SIZE);
				$title = CropSentence($post->post_title, MAX_TITLE_SIZE);
				
				//id, url, title, excerpt
				$front_page['printed_ids'][$id] = true;
				array_push($front_page['featured'], array('id' => $id, 'url' => $fa->url, 
														'title' => $title, 'excerpt' => $excerpt));
			}
		}
	}
	
	$post = $save_post;
}

function collect_recent_and_others(&$front_page)
{
		$query = new WP_Query( 'posts_per_page=-1' );
		$nb_featured = count($front_page['featured']);
		$nb_recent = 0;

		$front_page['recent'] = array();
		$front_page['others'] = array();

	
		// The Loop
		while ( $query->have_posts() ) :
			$query->the_post();
			$id = get_the_ID();
			if(!array_key_exists($id, $front_page['printed_ids']))
			{
				$title = CropSentence(get_the_title(), MAX_TITLE_SIZE);

				$nb_recent++;
				if($nb_recent <= $nb_featured)
				{
					// make it part of recent

					// only needed in recent box
					$excerpt = CropSentence(strip_tags(get_the_content()), FEATURED_EXCERPT_SIZE);
					
					array_push($front_page['recent'], array('id' => $id, 'url' => get_permalink(), 
														'title' => $title, 'excerpt' => $excerpt));
				}
				else
				{
					// make it part of others
					array_push($front_page['others'], array('id' => $id, 'url' => get_permalink(),
															'title' => $title));
				}
			}
		endwhile;
		
		wp_reset_postdata();
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