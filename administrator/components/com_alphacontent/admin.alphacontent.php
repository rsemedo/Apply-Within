<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// include version
require_once (JPATH_COMPONENT.DS.'assets'.DS.'includes'.DS.'version.php');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller = new configurationController();

// Perform the Request task
$controller->execute( JRequest::getCmd( 'task', 'edit' ) );
$controller->redirect();
?>