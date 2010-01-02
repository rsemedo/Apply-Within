<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * @package AlphaContent
 */
class alphacontentController extends JController
{
	var $options = null;

	/**
	 * Custom Constructor
	 */
 	function __construct()	{
		parent::__construct( );
	}	
	
	function showdirectory() {
	
		global $mainframe, $options;

		$options['letter']		= urldecode(JRequest::getVar ( 'letter', '', 'default', 'string'	 ));		
		$options['section']  	= JRequest::getVar ( 'section', '', 'default', 'string'	 );
		$options['category']	= JRequest::getVar ( 'category', '', 'default', 'int' 	 );
		$options['ordering']	= JRequest::getVar ( 'ordering', '', 'default', 'int' 	 );
		$options['search']		= JRequest::getVar ( 'search', '', 'default', 'string'   	 );
		$options['search']		= JString::strtolower( $options['search']                );
		$options['searchfield']	= JRequest::getVar ( 'searchfield', '', 'default', 'string' );
		$options['tag']			= JRequest::getVar ( 'tag', '', 'GET', 'string'          );
		$options['total']		= 0;
	
		$model        = &$this->getModel ( 'alphacontent' );
		$modelListing = &$this->getModel ( 'listing' );
		$view         = $this->getView   ( 'alphacontent','html' );
		
		if ( $options['search']!='' && isset($_POST['search'])) {			
			$uri =& JFactory::getURI();			
			$uri->setQuery( $uri->getQuery() . "&search=".urlencode($options['search']) );
			if ( $options['searchfield']!='' ) $uri->setQuery( $uri->getQuery() . "&searchfield=".$options['searchfield'] );
			$urlredirect = $uri->toString();
			$mainframe->redirect( $urlredirect );			
		}
		
		// load params
		$params = $model->_setDirectoryParams();
		
		$options['limitstart'] = JRequest::getVar ( 'limitstart', 0, 'default', 'int' );
		$options['limit']      = JRequest::getVar ( 'limit', $params->get('list_resultperpage'), 'default', 'int'  );
		
		// get Ordering
		$options['ordering']  = ( $options['ordering']=='' ) ? $params->get('list_defaultordering') : $options['ordering'];

		// load Directory structure
		$_directory = $model->_load_alphacontent ( $options, $params );
		
		// load alphabetical bar
		$_alphabetical_bar = $model->_load_alphabetical_bar ( $params );
		
		// Load description article directory if setting
		$_contentdescriptiondirectory = $model->_load_description_directory ( $params );	
		
		// Assign vars to tmpl
		$view->assign('directory', $_directory[0] );
		$view->assign('params', $params );
		$view->assign('currentselection', $_directory[1] );
		$view->assign('alphabeticalbar', $_alphabetical_bar );
		$view->assign('contentdescriptiondirectory', $_contentdescriptiondirectory );	
		
		// load listing if exist
		$_listing = $modelListing->_load_listing ( $options, $params );
		$view->assign('listing', $_listing );

		$_listingcatbegenningby = $modelListing->_load_listingcatbegenningby ( $options, $params, $_directory[0], $_directory[1] );
		$view->assign('categoriesbegenningby', $_listingcatbegenningby );
		
		// Display
		$view->_display();		
	}
	
	function viewmap() {		
		global $mainframe;
	
		$model        = &$this->getModel ( 'alphacontent' );
		$view         = $this->getView  ( 'alphacontent','html' );
		// load params
		$params = $model->_setDirectoryParams();
		$view->_viewmap( $params );
	}
	
	function showRSS() {
		global $mainframe;

		$options['s']  	= JRequest::getVar ( 's', '', 'default', 'int'	 );
		$options['c']	= JRequest::getVar ( 'c', '', 'default', 'int' 	 );
		$options['m']	= JRequest::getVar ( 'm', '', 'default', 'int' 	 );
		
		$model        = &$this->getModel ( 'alphacontent' );
		$modelListing = &$this->getModel ( 'listing' );
		
		$view         = $this->getView  ( 'alphacontent','html' );
		// load params
		$params = $model->_setDirectoryParams();
		$rows = $modelListing->_getRSS( $options, $params );
		
		$view->assign('rows', $rows );
		$view->assign('menuid', $options['m'] );
		
		$view->_showrss();
	}
	
	function report() {
		global $mainframe;
		
		$type = JRequest::getVar ( 'type', '', 'default', 'string' );
		$id   = JRequest::getVar ( 'id', '0', 'default', 'int' );		
		
		$view         = $this->getView  ( 'alphacontent','html' );
		$model        = &$this->getModel ( 'alphacontent' );
		
		// load params
		$params = $model->_setDirectoryParams();		
		
		$view->assign('type', $type );
		$view->assign('id', $id );
		$view->assign('list_email_administrator', $params->get('list_email_administrator') );
		
		$view->_showreport();
	
	}	
}
?>