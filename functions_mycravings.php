<?php

include_once('php/video.php');

define('MAX_TITLE_SIZE', 30);
define('FEATURED_EXCERPT_SIZE', 55);
define('MOBILETHUMB_WIDTH', 180);


function show_front_page()
{
	global $is_the_front_page;
	$is_the_front_page = true;
	
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
	
	require('articles_slide.js.php');
	require('index-featured-mobile-tablet.php');

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
				$title = video_icon($id) . CropSentence($post->post_title, MAX_TITLE_SIZE);
				
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
			// if we did not already print it and if it should not be hidden
			if(!array_key_exists($id, $front_page['printed_ids']) && !get_post_meta($id, 'hide_from_front_page', true))
			{
				$title = video_icon() . CropSentence(get_the_title(), MAX_TITLE_SIZE);

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

function video_icon($post_id = NULL)
{
	$ret = '';
	if (is_video($post_id)) $ret = '<span class="entypo entypo-left">q</span> ';
	return $ret;
}

function is_video($post_id = NULL)
{
	global $id;
	if(!$post_id) $post_id = $id;
	$ret = get_post_meta($post_id, 'post_is_a_video', true);
	if($ret != 'true' && $ret != 'false')
	{
		$ret = 'false';
		if(video_on_page($post_id)) $ret = 'true';
		add_post_meta($post_id, 'post_is_a_video', $ret);
	}
	return ($ret == 'true');
}

function mycravings_excerpt()
{
	return CropSentence(strip_tags(get_the_excerpt()), FEATURED_EXCERPT_SIZE);
}

function video_on_page($post_id = NULL) {
	global $id;
	$content = NULL;
	// if we are not in the loop
	if($id != $post_id)
	{
		$my_post = get_post($post_id);
		$content = $my_post->post_content;
	}
	// if we are in the loop
  if(!$content) $content = get_the_content();
  return preg_match('#vimeo.com|youtube.com|globalshortfilmnetwork.com#', $content);
}

function mycravings_get_thumbnail($id, $thumb = NULL)
{
	$ret = get_the_post_thumbnail($id, $thumb);
	if(false && is_video($id))
	{
		if(preg_match_all('#http://.*\.jpe?g#i', $ret, $arr, PREG_PATTERN_ORDER))
		{
			$url = $arr[0][0];
			get_video_img($url);
			$ret = mycravings_video_url_replace($ret);
		}
	}
	return $ret;
}

function mycravings_video_url_replace($url)
{
	return preg_replace('#/([^/]+)\.jp#', '/\1-vid.jp', $url);
}

function get_video_img($url)
{
	$site = $_SERVER['HTTP_HOST'];
	$base_path = $_SERVER['DOCUMENT_ROOT'];
	$path = str_replace('http://' . $site . '/', $base_path, $url);
	$newpath = mycravings_video_url_replace($path);
	$newurl = mycravings_video_url_replace($url);
	if(!file_exists($newpath))
	{
		$cur = imagecreatefromjpeg($path);
		imagealphablending($cur, true);
		imagesavealpha($cur, true);
		list($w, $h) = getimagesize($path);
		$divider = 7;
		if($w < 200) $divider = 4;
		if($w < 100) $divider = 3;
		
		$butdim = floor($w / $divider);
		$hbd = floor($butdim / 2);
		$butx = floor($w / 2) - $hbd;
		$buty = floor($h / 2) - $hbd;
		
		$play = imagecreatefrompng(get_stylesheet_directory() . '/images/play_icon.png');
		imagealphablending($play, true);
		imagesavealpha($play, true);
		
		imagecopyresized($cur, $play, $butx, $buty, 0, 0, $butdim, $butdim, 89, 89);
		imagedestroy($play);
	
		imagejpeg($cur, $newpath);
		imagedestroy($cur);
	}
	return $newurl;
}

function facebook_head_stuff() {
  if (have_posts()) {
    the_post();
    $id = get_the_ID();
    $title = get_the_title();
    $url = get_permalink();
    $excerpt = get_the_excerpt();
    echo "<meta property=\"og:url\" content=\"{$url}\"/>
<meta property=\"og:title\" content=\"{$title}\"/>
<meta property=\"og:description\" content=\"{$excerpt}\"/>
";
    if ($id) {
      $the_img = mycravings_get_thumbnail($id);
      if ($the_img && preg_match_all('#src="([^"]*)"#i', $the_img, $arr, PREG_PATTERN_ORDER)) {
        $img_url = $arr[1][0];
        if ($img_url)
          echo "<meta property=\"og:image\" content=\"{$img_url}\"/>
";
      }
    }
		rewind_posts();
  }
}

//function is_front_page()
//{
//	global $is_the_front_page;
//	return ($is_the_front_page ? true : false);
//}


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