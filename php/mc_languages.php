<?php

function mc_lng() 
{
	global $the_mc_lng;
	if(!$the_mc_lng)
	{
		$the_mc_lng = 'en';
		if(isset($_GET['lng'])) 
		{
			if($_GET['lng'] == 'fr') 
			{
				$the_mc_lng = 'fr'; 
				$_SESSION['lng'] = 'fr'; 
			} 
		}
		else
		{
			if(preg_match('#jaisoif.ca#', $_SERVER['HTTP_HOST']))
			{
				$the_mc_lng = 'fr';
			}
		}
	}
	return $the_mc_lng; 
}
function mc_fr() { return mc_lng() == 'fr'; }
function mc_en() { return mc_lng() == 'en'; }

function mc_t($str)
{
	$res = $str;
	if(mc_fr()) $res = mc_translate($str);
	return $res;
}

function mc_translate($str)
{
	global $mc_translation_array;
	if(!$mc_translation_array)
	{
		$mc_translation_array = array(
			'Featured Articles' => 'En vedette',
			'Recent Articles' => 'Articles récents',
			'Read More' => 'Lire la suite',
			'Watch' => 'Regarder',
			'Other Articles...' => 'Autres articles...',
			'More Articles...' => 'Plus d\'articles...',
			'Written By' => 'Par',
			'OTHER POSTS' => 'AUTRES ARTICLES',
		);
	}
	if(array_key_exists($str, $mc_translation_array))
	{
		return $mc_translation_array[$str];
	}
	return $str;
}

function mc_body_class()
{
	return array(mc_lng());
}

add_filter( 'body_class', 'mc_body_class' );


?>