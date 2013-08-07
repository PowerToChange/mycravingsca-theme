<?php
/*
 * This page loads functionnalites for mycravings
 * 
 * */

include_once ('mc_languages.php');
include_once ('class/MyCravingsFr.class.php');
include_once ('class/MyCravingsEn.class.php');
include_once ('class/RelatedPosts.class.php');
include_once ('class/BloggersFacePileWidget.class.php');

global $mycravings;
if(mc_fr()) $mycravings = new MyCravingsFr();
else $mycravings = new MyCravingsEn();
?>