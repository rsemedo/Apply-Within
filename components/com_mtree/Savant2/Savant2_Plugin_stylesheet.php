<?php
defined('_JEXEC') or die('Restricted access');

/**
* Base plugin class.
*/
require_once JPATH_ROOT.DS.'components'.DS.'com_mtree'.DS.'Savant2'.DS.'Plugin.php';

/**
* 
* Outputs a <link ... /> to a CSS stylesheet.
* 
* $Id: Savant2_Plugin_stylesheet.php 432 2008-10-09 08:42:32Z cy $
* 
* @author Paul M. Jones <pmjones@ciaweb.net>
* 
* @package Savant2
* 
* @license http://www.gnu.org/copyleft/lesser.html LGPL
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as
* published by the Free Software Foundation; either version 2.1 of the
* License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, but
* WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
* 
*/

class Savant2_Plugin_stylesheet extends Savant2_Plugin {

	/**
	* 
	* Output a <link ... /> to a CSS stylesheet.
	* 
	* @access public
	* 
	* @param object &$savant A reference to the calling Savant2 object.
	* 
	* @param string $href The HREF leading to the stylesheet file.
	* 
	* @return string
	* 
	*/
	
	function plugin($href)
	{
		return '<link rel="stylesheet" type="text/css" href="' .
			htmlspecialchars($href) . '" />';
	}

}

?>