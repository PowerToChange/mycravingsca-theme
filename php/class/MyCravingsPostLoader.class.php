<?php
include_once ('WordpressPostLoader.class.php');

define('MAX_TITLE_SIZE', 30);
define('FEATURED_EXCERPT_SIZE', 55);
define('MOBILETHUMB_WIDTH', 180);


class MyCravingsPostLoader extends WordpressPostLoader
{
	var $is_a_video;
	
	function MyCravingsPostLoader($id = NULL)
	{
		parent::WordpressPostLoader($id);
		$this->is_a_video = NULL;
	}
	
	function get_excerpt()
	{
		return $this->CropSentence(strip_tags(parent::get_excerpt()), FEATURED_EXCERPT_SIZE);
	}
	
	function get_facebook_excerpt()
	{
		return $this->CropSentence(strip_tags(parent::get_excerpt()), 300);
	}
	
	function get_straight_title()
	{
		return parent::get_title();
	}
	
	function get_title()
	{
		return $this->video_icon() . parent::get_title();
	}
	
	function get_cropped_title()
	{
		return $this->video_icon() . $this->CropSentence(parent::get_title(), MAX_TITLE_SIZE);
	}
	
	function custom_get($item)
	{
		$ret = NULL;
		switch ($item) {
			case 'cropped_title':
				$ret = $this->get_cropped_title();
				break;
			
			case 'straight_title':
				$ret = $this->get_straight_title();
				break;
			
			case 'is_video':
				$ret = $this->is_video();
				break;
			
			case 'thumbnail_full':
				$ret = $this->get_from_array(array('type' => 'thumbnail', 'size' => 'mycravings_full'), $key);
				break;
			
			case 'thumbnail_thumb':
				$ret = $this->get_from_array(array('type' => 'thumbnail', 'size' => 'mycravings_thumb'), $key);
				break;
			
			case 'thumbnail_mobilethumb':
				$ret = $this->get_from_array(array('type' => 'thumbnail', 'size' => 'mycravings_mobilethumb'), $key);
				break;
			
			case 'facebook_excerpt':
				$ret = $this->get_facebook_excerpt();
				break;
			
			default:
				$ret = NULL;
				break;
		}
		return $ret;
	}
	
	function video_icon()
	{
		$ret = '';
		if ($this->is_video()) $ret = '<span class="ssb-icon">&#x1F4F9;</span> ';
		return $ret;
	}
	
	function is_video()
	{
		if(is_null($this->is_a_video))
		{
			$ret = get_post_meta($this->get_id(), 'post_is_a_video', true);
			if($ret != 'true' && $ret != 'false')
			{
				$ret = 'false';
				if($this->video_on_page()) $ret = 'true';
				add_post_meta($this->get_id(), 'post_is_a_video', $ret);
			}
			$this->is_a_video = ($ret == 'true');
		}
		return $this->is_a_video;
	}
	
	function video_on_page() {
	  if(preg_match_all('#<([^ <>/]+) [^>]+(vimeo.com|youtube.com|globalshortfilmnetwork.com)[^>]+>#', $this->get_content(), $arr, PREG_PATTERN_ORDER))
		{
			foreach ($arr[1] as $tag) 
			{
				if(strtolower($tag) != 'a') $ret = true;
			}
		}
		return $ret;
	}
	
	
		
}


?>