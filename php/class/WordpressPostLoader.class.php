<?php

class WordpressPostLoader
{
	var $is_in_the_loop;
	var $my_post;
	var $my_post_loaded;
	var $post_id;
	var $featured_image;
	
	function WordpressPostLoader($id = NULL)
	{
		$this->is_in_the_loop = false;
		if(!$id) $this->is_in_the_loop = true;
		$this->post_id = $id;
		$this->my_post_loaded = false;
		$this->my_post = NULL;
		$this->featured_image = NULL;
	}
	
	function in_the_loop() { return $this->is_in_the_loop; }
	function post()
	{
		if(!$this->my_post_loaded)
		{
			$this->my_post = get_post($this->get_id());
			$this->my_post_loaded = true;
		}
		return $this->my_post;
	}
	
	function load($fields)
	{
		$ret = NULL;
		if($fields)
		{
			if(is_array($fields))
			{
				$ret = array();
				foreach ($fields as $field) {
					if(is_array($field))
					{
						$res = $this->get_from_array($field, $key);
						$ret[$key] = $res;
					}
					else 
					{
						$ret[$field] = $this->get($field);
					}
				}
			}
			else 
			{
				$ret = $this->get($fields);
			}
		}
		return $ret;
	}
	
	function custom_get($item){ return NULL; }
	
	function get($item)
	{
		$ret = NULL;
		if($item)
		{
			// give a chance to a children class to implement new stuff
			$ret = $this->custom_get($item);
			if(is_null($ret))
			{
				switch ($item) {
					case 'id':
						$ret = $this->get_id();
						break;
					
					case 'title':
						$ret = $this->get_title();
						break;
					
					case 'url':
						$ret = $this->get_url();
						break;
					
					case 'content':
						$ret = $this->get_content();
						break;
					
					case 'excerpt':
						$ret = $this->get_excerpt();
						break;
					
					case 'thumbnail':
						$ret = $this->get_thumbnail();
						break;
					
					case 'thumbnail_url':
						$ret = $this->get_thumbnail_url();
						break;
					
					default:
						$ret = get_post_meta($this->get_id(), $key, true);
						break;
				}
				
			}
			
		}
		return $ret;
	}
	
	function get_from_array($items, &$key)
	{
		$ret = NULL;
		if(is_array($items))
		{
			if(key_exists('type', $items))
			{
				$key = $items['type'];
				$size = NULL;
				if(key_exists('size', $items)) $size = $items['size'];
				if($items['type'] == 'thumbnail')
				{
					$ret = $this->get_thumbnail($size);
				}
				else if($items['type'] == 'thumbnail_url')
				{
					$ret = $this->get_thumbnail_url($size);
				}
			}
		}
		return $ret;
	}
	
	function get_id()
	{
		if($this->in_the_loop() && !$this->post_id) { $this->post_id = get_the_ID(); } 
		return $this->post_id;
	}

	function get_title()
	{
		$ret = NULL;
		if($this->in_the_loop()) {
			$ret = get_the_title();
		}
		else {
			$ret = $this->post()->post_title;
		}
		return $ret;
	}
	
	function get_url()
	{
		$ret = NULL;
		if($this->in_the_loop()) {
			$ret = get_permalink();
		}
		else {
			$ret = get_permalink($this->get_id());
		}
		return $ret;
	}
	
	function get_content()
	{
		$ret = NULL;
		if($this->in_the_loop()) {
			$ret = get_the_content();
		}
		else {
			$ret = $this->post()->post_content;
		}
		return $ret;
	}	
	
	function get_excerpt()
	{
		$ret = NULL;
		if($this->in_the_loop()) {
			$ret = get_the_excerpt();
		}
		else {
			// TODO: find the real way to get excerpt
			$ret = $this->post()->post_content;
		}
		return $ret;
	}
	
	function get_thumbnail($thumb = NULL)
	{
		$key = $thumb;
		if(!$key) $key = 'none';
		if(!$this->featured_image) $this->featured_image = array();
		if(!key_exists($key, $this->featured_image))
		{
			$this->featured_image[$key] = get_the_post_thumbnail($this->get_id(), $thumb);
		}
		return $this->featured_image[$key];
	}
	
	function get_thumbnail_url($thumb = NULL)
	{
		$ret = NULL;
		if(preg_match_all('#src="([^"]+)"#i', $this->get_thumbnail($thumb), $arr, PREG_PATTERN_ORDER))
		{
			$ret = $arr[1][0];
		}
		return $ret;
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
	function CropSentence($strText, $intLength, $strTrail = '...') {
	  $wsCount = 0;
	  $intTempSize = 0;
	  $intTotalLen = 0;
	  $intLength = $intLength - strlen($strTrail);
	  $strTemp = '';
	
	  if (strlen($strText) > $intLength) {
	    $arrTemp = explode(' ', $strText);
	    foreach ($arrTemp as $x) {
	      if (strlen($strTemp) <= $intLength)
	        $strTemp .= ' ' . $x;
	    }
	    $CropSentence = $strTemp . $strTrail;
	  } else {
	    $CropSentence = $strText;
	  }
	
	  $len = strlen($CropSentence);
	  $lenLimit = $intLength * 1.25;
	  if ($len > $lenLimit)
	    $CropSentence = mb_substr($strText, 0, $intLength) . $strTrail;
	
	  return $CropSentence;
	}	
	
}

function wppl_load($fields, $id = NULL)
{
	$wppl = new WordpressPostLoader($id);
	return $wppl->load($fields);
}

?>