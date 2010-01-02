<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * AlphaContent System Plugin
 *
 * @package		Joomla
 * @subpackage	AlphaContent
 * @since 		1.5
 */
class plgSystemAlphacontentsys extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemAlphacontentsys(& $subject, $config) {
		parent::__construct($subject, $config);
	}

	function onAfterInitialise(){
		global $mainframe;
		
		$newDirectory = JRequest::getVar('directory', 0 );
		if ( $newDirectory ) {
			JRequest::setVar('Itemid', $newDirectory );
		}
	
	}
}
?>