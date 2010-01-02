<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */
 
defined('_JEXEC') or die('Restricted access');

defined('JPATH_BASE') or die();
global $mainframe;

$debugInstallSQL = "";

$cache = & JFactory::getCache();
$cache->clean( null, 'com_alphacontent' );

// include version
require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphacontent'.DS.'assets'.DS.'includes'.DS.'version.php');

// Copyright
$copyStart = 2005;
$copyNow = date('Y');  
if ($copyStart == $copyNow) { 
	$copySite = $copyStart;
} else {
	$copySite = $copyStart." - ".$copyNow ;
}

$db	=& JFactory::getDBO();

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');	

// plugin content

// prevent old bad install
$query = "UPDATE #__plugins SET element='alphacontentsys' WHERE name='AlphaContentSys' AND element='alphacontent'";
$db->setQuery( $query );
$db->query();

$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphacontent'.DS.'install'.DS.'plugins'.DS.'plugin_content';
if($plugin_installer->install($file_origin)) {
	// publish plugin
	$query = "UPDATE #__plugins SET published='1' WHERE name='Content - AlphaContent' AND element='alphacontent'";
	$db->setQuery( $query );
	$db->query();	
} else {
	$debugInstallSQL = '1';
}

// plugin system
$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphacontent'.DS.'install'.DS.'plugins'.DS.'plugin_system';
if($plugin_installer->install($file_origin)) {	
	// publish plugin
	$query = "UPDATE #__plugins SET published='1' WHERE name='System - AlphaContent' AND element='alphacontentsys'";
	$db->setQuery( $query );
	$db->query();	
} else {
	$debugInstallSQL = '1';
}

if ( $debugInstallSQL ) {
	$mainframe->redirect( 'index.php?option=com_alphacontent','NOTICE: AlphaContent plugin is not successfully installed. Make sure that the plugin directory is writeable' );
} else {

	$debugInstallSQL = "";
	// check if install.sql populate tables
	$query = "SELECT `total_votes` FROM #__alpha_rating";
	$db->setQuery( $query );
	// if not installed by install.sql...
	// populate now
	if (!$db->query()) {			
		$query = "CREATE TABLE IF NOT EXISTS `#__alpha_rating` (
		  `ref` int(11) NOT NULL auto_increment,
		  `id` int(11) NOT NULL default '0',
		  `total_votes` int(11) NOT NULL default '0',
		  `total_value` int(11) NOT NULL default '0',
		  `used_ips` longtext NOT NULL default '',
		  `component` varchar(30) NOT NULL default '',
		  `cid` int(11) NOT NULL default '0',
		  `rid` int(11) NOT NULL default '0',
		  PRIMARY KEY  (`ref`)
		) TYPE=MyISAM;";
		$db->setQuery( $query );
		$db->query();		
	
		$debugInstallSQL = "Install table successfully";
	}

	@unlink( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphacontent'.DS.'install'.DS.'plugins'.DS.'plugin_content'.DS.'alphacontent.php' );
	@unlink( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphacontent'.DS.'install'.DS.'plugins'.DS.'plugin_content'.DS.'alphacontent.xml' );
	
	@unlink( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphacontent'.DS.'install'.DS.'plugins'.DS.'plugin_system'.DS.'alphacontentsys.php' );
	@unlink( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphacontent'.DS.'install'.DS.'plugins'.DS.'plugin_system'.DS.'alphacontentsys.xml' );

	
	// Modify the admin icons
	$query = "SELECT id FROM #__components WHERE `name`='AlphaContent'";
	$db->setQuery( $query );
	$id = $db->loadResult();

	//add new admin menu images
	$query = "UPDATE #__components SET `name`='AlphaContent', admin_menu_img = '../administrator/components/com_alphacontent/assets/images/alphacontent_icon.png' WHERE id='$id'";
	$db->setQuery( $query );
	$db->query();

?>
<table width="100%" border="0">
<tr>
  <td><img src="components/com_alphacontent/assets/images/alphacontent.jpg"></td>
  <td>	<br />
  </td>
</tr>
<tr>
	<td colspan="2"><br /><b>
	  AlphaContent - A Joomla Directory Component</b><br />
      <font class="small">&copy; <?php echo $copySite ; ?> - Bernard Gilly - All Rights Reserved - <a href="http://www.alphaplug.com" target="_blank">www.alphaplug.com</a><br />
AlphaContent is Free Software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GNU/GPL License</a>.
</font><br />
<?php echo $debugInstallSQL ; ?></td>
</tr>
<tr>
  <td background="E0E0E0" style="border:1px solid #999999;color:green;font-weight:bold;" colspan="2">Installation finished.</td>
</tr>
</table>
<?php } ?>