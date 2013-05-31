<?php

include_once ('php/class/MyCravingsPostLoader.class.php');
include_once ('php/mc_languages.php');


function mc_load($fields, $id = NULL)
{
	$wppl = new MyCravingsPostLoader($id);
	return $wppl->load($fields);
}

function mc_data_required($filename)
{
	$ret = NULL;
	switch ($filename) {
		case 'index-front-article.php':
			$ret = array('url', 'title', 'thumbnail_full');
			break;
		
		case 'article-listed-with-excerpt.php':
			$ret = array('id', 'url', 'cropped_title', 'excerpt', 'is_video', 'thumbnail_thumb');
			break;
		
		case 'article-listed-no-excerpt.php':
			$ret = array('id', 'url', 'cropped_title', 'thumbnail_thumb');
			break;
		
		default:
			
			break;
	}
	return $ret;
}

function mc_get_data_for($filename, $id = NULL)
{
	return  mc_load(mc_data_required($filename), $id);
}

function mc_use_template_part($filename, $id = NULL)
{
	extract(mc_load(mc_data_required($filename), $id));
	require($filename);
}

function mc_use_template_part_with_data($filename, $data)
{
	if(!is_null($data))
	{
		extract($data);
		require($filename);
	}
}

function show_front_page() {
  global $is_the_front_page;
  $is_the_front_page = true;

  $front_page = collect_articles_placement();

	mc_use_template_part_with_data('index-front-article.php', $front_page['front']);

  $box_title = mc_t('Featured Articles');
  $box_placement = 'left';
  $box_key = 'featured';
  require ('index-featured-box.php');

  $box_title = mc_t('Recent Articles');
  $box_placement = 'right';
  $box_key = 'recent';
  require ('index-featured-box.php');

  echo "<div class=\"clear\"></div>";

  require ('articles_slide.js.php');
  require ('index-featured-mobile-tablet.php');

  require ('index-other-articles.php');
}

function & collect_articles_placement() {
  $front_page = array('printed_ids' => array());

  $items = wp_get_nav_menu_items('Featured');

  collect_front($items, $front_page);
  collect_featured($items, $front_page);
  collect_recent_and_others($front_page);

  return $front_page;
}

function collect_front(&$items, &$front_page) {
  if (count($items)) {
    $front = array_shift($items);
    $id = url_to_postid($front -> url);
    if ($id) {
      // we have a post with that url, make it front page
      $front_page['printed_ids'][$id] = true;
      $front_page['front'] = mc_get_data_for('index-front-article.php', $id);
    } else {
      // url was invalid, maybe next url is.
      collect_front($items, $front_page);
    }
  }
}

function collect_featured(&$items, &$front_page) {
  $front_page['featured'] = array();
  if (count($items)) {
    foreach ($items as $fa) {
      $id = url_to_postid($fa -> url);
      if ($id) {
        $front_page['printed_ids'][$id] = true;
				$front_page['featured'][] = mc_get_data_for('article-listed-with-excerpt.php', $id);
      }
    }
  }
}

function collect_recent_and_others(&$front_page) {
  $query = new WP_Query('posts_per_page=-1');
  $nb_featured = count($front_page['featured']);
  $nb_recent = 0;

  $front_page['recent'] = array();
  $front_page['others'] = array();

  // The Loop
  while ($query -> have_posts()) :
    $query -> the_post();
    $id = get_the_ID();
    // if we did not already print it and if it should not be hidden
    if (!array_key_exists($id, $front_page['printed_ids']) && !get_post_meta($id, 'hide_from_front_page', true)) {

      $nb_recent++;
      if ($nb_recent <= $nb_featured) {
        // make it part of recent
        $front_page['recent'][] = mc_get_data_for('article-listed-with-excerpt.php');
      } else {
        // make it part of others
        $front_page['others'][] = mc_get_data_for('article-listed-no-excerpt.php');
      }
    }
  endwhile;
  wp_reset_postdata();
}

function video_on_page($post_id = NULL) {
	return mc_load('is_video', $id);
}

function facebook_head_stuff() {
  if (have_posts()) {
    the_post();
		extract(mc_load(array('straight_title', 'url', 'excerpt', 'thumbnail_url')));

    echo "<meta property=\"og:url\" content=\"{$url}\"/>
<meta property=\"og:title\" content=\"{$straight_title}\"/>
<meta property=\"og:description\" content=\"{$excerpt}\"/>
";
	  if ($thumbnail_url)
    	echo "<meta property=\"og:image\" content=\"{$thumbnail_url}\"/>
";
		rewind_posts();
  }
}

function mycravings_get_thumbnail($id, $thumb = NULL)
{
	$ret = get_the_post_thumbnail($id, $thumb);
	// image feature disabled for now
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

?>