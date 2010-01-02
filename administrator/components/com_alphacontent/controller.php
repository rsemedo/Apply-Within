<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

/**
 * @package AlphaContent
 */
class configurationController extends JController
{
	/**
	 * Custom Constructor
	 */
 	function __construct()	{
		parent::__construct( );
	}	

	
	/**
	* Show/Edit Configuration
	*/
	function edit() {

		$model 			= &$this->getModel( 'alphacontent' );
		$modelUpdate 	= &$this->getModel( 'upgrade' );
		
		$_params 		= &JComponentHelper::getParams( 'com_alphauserpoints' );
		
		$view  			= $this->getView( 'alphacontent','html');
		
		$model->_set_configuration ();
		
		//get instance of cache class
		$cache = & JFactory::getCache('com_alphacontent');
		//enable caching
		$cache->setCaching( 1 );
		//set life time for caching
		$cache->setLifeTime( 15 * 60 ); // 15 minutes to seconds
		//calling _getUpdate method in alphauserpointsModelUpgrade class (in model upgrade)
		$_check = $cache->get(array( 'configurationModelUpgrade', '_getUpdate'), 'component');	
		
		$view->assign('check', $_check);
		$view->assign('alphacontent_configuration', $model->_configuration);

		$view->edit();
	}

	/**
	* Save the configuration file
	*/
	function save() {		
		// get the model
		$model = &$this->getModel('alphacontent');
		if ( $model->_save_configuration() ) {
			$this->setRedirect('index.php?option=com_alphacontent', JTEXT::_('AC_CONFIGURATION_SAVED'));
		} else {
			$this->setRedirect('index.php?option=com_alphacontent', JTEXT::_('AC_CONFIGURATION_ERROR'));
		}
	}

}

?>