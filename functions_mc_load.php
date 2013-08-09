<?php
include_once ('php/class/MyCravingsPostLoader.class.php');


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
			$ret = array('id', 'url', 'cropped_title', 'excerpt', 'is_video', 'thumbnail_thumb', 'thumbnail_mobilethumb');
			break;
		
		case 'article-listed-no-excerpt.php':
			$ret = array('id', 'url', 'cropped_title', 'thumbnail_thumb');
			break;
		
		case 'article-list-slide.php':
			$ret = array('id', 'url', 'cropped_title', 'thumbnail_mobilethumb');
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
	$data = mc_load(mc_data_required($filename), $id);
	if(is_array($data)) extract($data);
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


?>