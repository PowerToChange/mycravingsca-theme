<?php

class MyCravings
{
	
	function MyCravings()
	{
		
	}
	
	
	function show_launch_page() {
		$launch_page = $this->collect_launch_articles();
		mc_use_template_part_with_data('index-front-article.php', $front_page['front']);
	
		$data = array(
			'box_title' => mc_t('Featured Posts'),
			'box_placement' => '',
			'box_key' => 'featured',
			'front_page' => $launch_page,
		);
	  mc_use_template_part_with_data ('index-featured-box.php', $data);
	
		$data = array('front_page' => $launch_page);
	  echo "<div class=\"clear\"></div>";
	
	  mc_use_template_part_with_data ('articles_slide.js.php', $data);
	  mc_use_template_part_with_data ('index-featured-mobile-tablet.php', $data);
	
	}
	
	function & collect_launch_articles() {
	  $launch_page = array('printed_ids' => array());
	
	  $items = wp_get_nav_menu_items('Launch');
	
	  $this->collect_featured($items, $launch_page);
	
	  return $launch_page;
	}
	
	
	function show_front_page() {
	  global $is_the_front_page;
	  $is_the_front_page = true;
	
	  $front_page = $this->collect_articles_placement();

		mc_use_template_part_with_data('index-front-article.php', $front_page['front']);
	
		$data = array(
			'box_title' => mc_t('Featured Posts'),
			'box_placement' => 'half left',
			'box_key' => 'featured',
			'front_page' => $front_page,
		);
	  mc_use_template_part_with_data ('index-featured-box.php', $data);
	
		$data = array(
			'box_title' => mc_t('Recent Posts'),
			'box_placement' => 'half right',
			'box_key' => 'recent',
			'front_page' => $front_page,
		);
	  mc_use_template_part_with_data ('index-featured-box.php', $data);
	
	
		$data = array('front_page' => $front_page);
	  echo "<div class=\"clear\"></div>";
	
	  mc_use_template_part_with_data ('articles_slide.js.php', $data);
	  mc_use_template_part_with_data ('index-featured-mobile-tablet.php', $data);
	
	  mc_use_template_part_with_data ('index-other-articles.php', $data);
	}
	
	function & collect_articles_placement() {
	  $front_page = array('printed_ids' => array());
	
	  $items = wp_get_nav_menu_items('Featured');
	
	  $this->collect_front($items, $front_page);
	  $this->collect_featured($items, $front_page);
	  $this->collect_recent_and_others($front_page);
	
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
	      $this->collect_front($items, $front_page);
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

	function collect_others(&$front_page) {
	  $query = new WP_Query('posts_per_page=-1');
	  $nb_featured = count($front_page['featured']);
	  $nb_recent = 0;
	
	  $front_page['others'] = array();
	
	  // The Loop
	  while ($query -> have_posts()) :
	    $query -> the_post();
	    $id = get_the_ID();
	    // if we did not already print it and if it should not be hidden
	    if (!array_key_exists($id, $front_page['printed_ids']) && !get_post_meta($id, 'hide_from_front_page', true)) {	
        // make it part of others
        $front_page['others'][] = mc_get_data_for('article-listed-no-excerpt.php');
	    }
	  endwhile;
	  wp_reset_postdata();
	}

	function facebook_head_stuff() {
	  if (have_posts()) {
	    the_post();
			extract(mc_load(array('straight_title', 'url', 'facebook_excerpt', 'thumbnail_url')));
	
	    echo "<meta property=\"og:url\" content=\"{$url}\"/>
	<meta property=\"og:title\" content=\"{$straight_title}\"/>
	<meta property=\"og:description\" content=\"{$facebook_excerpt}\"/>
	";
		  if ($thumbnail_url)
	    	echo "<meta property=\"og:image\" content=\"{$thumbnail_url}\"/>
	";
			rewind_posts();
	  }
	}
	
	function main_menu() {
		wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) );
	}

  function google_analytics_id()
  {
    return 'not-defined';
  }
  


}

?>