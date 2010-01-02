<?php
/**
* Modul Special HTML For Joomla 1.5.x
* Version			: 1.2
* Created by		: Rony Sandra Yofa Zebua
* Mail				: ronysyz@gmail.com
* camp26.biz mail	: camp26team@gmail.com
* Created on		: 07 Februari 2008
* Last Updated on	: 03 February 2009
* URL				: www.camp26.biz - www.camp26.net - www.camp26.org
* camp26.biz ready to service all of you for developt, rebuild,redesign and customize your Joomla live site
* camp26.biz Products: Expert Joomla Developer, Expert Designer, Expert Flash Creator, Get your Expert FreeLancer here, Expert Programmer Aplications (send your reguest to marketing@camp26.biz)
* Based Idea From: Mod_HTML for J1.0.x
* License 			: http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

//Parameters
$codearea 	= $params->get( 'code_area' ); 	
$clean_js 	= $params->get( 'clean_js' );		
$clean_css 	= $params->get( 'clean_css' );		
$clean_all 	= $params->get( 'clean_all' );
$userlevel 	= $params->get('userlevel');	

$user 		= & JFactory::getUser();
$mylevel 	= (!$user->get('guest')) ? 'logout' : 'login';

//Clean CSS & JS  & All
if (!$clean_all) {
	if ($clean_js) {
		preg_match("/<script(.*)>(.*)<\/script>/i", $codearea, $matches);
		if ($matches) {
			foreach ($matches as $i=>$match) {
				$clean_js = str_replace('<br />', '', $match);
				$codearea = str_replace($match, $clean_js, $codearea);
			}
		}
	}
	if ($clean_css) {
		preg_match("/<style(.*)>(.*)<\/style>/i", $codearea, $matches);
		if ($matches) {
			foreach ($matches as $i=>$match) {
				$clean_js = str_replace('<br />', '', $match);
				$codearea = str_replace($match, $clean_js, $codearea);
			}
		}
	}
} else {
	$codearea = str_replace('<br />', '', $codearea);
}

switch($userlevel) {
	case 1: //All Visitors
		if (($mylevel == 'logout') or ($mylevel == 'login')){
				echo $codearea;
		}
		break;
	case 2: //Guest Visitors
		if ($mylevel == 'login'){
				echo $codearea;
		}
		break;
	case 0: //Registered Visitors
	default:
		if ($mylevel == 'logout'){
				echo $codearea;		}
		break;
	}
 ?>