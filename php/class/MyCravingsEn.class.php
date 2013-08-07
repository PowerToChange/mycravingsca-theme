<?php
include_once('MyCravings.class.php');

class MyCravingsEn extends MyCravings
{
	
	function MyCravingsEn()
	{
		parent::MyCravings();
	}
	
	function main_menu()
	{
		mc_use_template_part('main-menu-en.php');
	}
	
}

?>