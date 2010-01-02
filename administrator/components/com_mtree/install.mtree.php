<?php
/**
 * @version		$Id: install.mtree.php 758 2009-08-07 01:36:39Z CY $
 * @package		Mosets Tree
 * @copyright	(C) 2005-2009 Mosets Consulting. All rights reserved.
 * @license		GNU General Public License
 * @author		Lee Cher Yeong <mtree@mosets.com>
 * @url			http://www.mosets.com/tree/
 */

defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mtree'.DS.'config.mtree.class.php' );

function com_install()
{
	$my	=& JFactory::getUser();
	$database =& JFactory::getDBO();
	$mtconf = new mtConfig($database);
	
	// Assign current user's email as Mosets Tree admin
	$database->setQuery("UPDATE #__mt_config SET value='" . $my->email . "' WHERE varname='admin_email' LIMIT 1");
	$database->query();

	// Change Admin Icon to Mosets icon
	$database->setQuery("UPDATE #__components SET admin_menu_img='../components/com_mtree/img/icon-16-mosetstree.png' WHERE admin_menu_link='option=com_mtree'");
	$database->query();

	// Rename htaccess.txt to .htaccess in attachments directory
	jimport('joomla.filesystem.file');
    if(!JFile::move(JPATH_SITE.$mtconf->get('relative_path_to_attachments').'htaccess.txt', JPATH_SITE.$mtconf->get('relative_path_to_attachments').'.htaccess' )) {
		$htaccess_rename_status = false;
	} else {
		$htaccess_rename_status = true;
	}

	?>
	<div>
		<div class="t">
			<div class="t">
				<div class="t"></div>
			</div>
		</div>
		<div class="m" style="overflow:hidden;padding-bottom:12px;">
			<div style="padding: 20px;border-right:1px solid #ccc;float:left">
			<img src="../components/com_mtree/img/logo.png" alt="Mosets Tree" style="float:left;padding-right:15px;" />
			</div>
			<div style="margin-left:350px;">
				<h2 style="margin-bottom:0;">Mosets Tree <?php echo $mtconf->get('version'); ?></h2>
				<strong>A flexible directory component for Joomla!</strong>
				<br /><br />
				&copy; Copyright 2005-<?php echo date('Y'); ?> by Mosets Consulting. <a href="http://www.mosets.com/">www.mosets.com</a><br />
				<input type="button" value="Go to Mosets Tree now" onclick="location.href='index.php?option=com_mtree'" style="margin-top:13px;cursor:pointer;width:200px;font-weight:bold" />
			</div>
		</div>
	</div>	
	<table class="adminlist">
		<tbody>
			<?php echo getHtaccessRenameRow($htaccess_rename_status); ?>
			<?php echo getWritableRow($mtconf->getjconf('absolute_path').$mtconf->get('relative_path_to_cat_original_image')); ?>
			<?php echo getWritableRow($mtconf->getjconf('absolute_path').$mtconf->get('relative_path_to_cat_small_image')); ?>
			<?php echo getWritableRow($mtconf->getjconf('absolute_path').$mtconf->get('relative_path_to_listing_original_image')); ?>
			<?php echo getWritableRow($mtconf->getjconf('absolute_path').$mtconf->get('relative_path_to_listing_medium_image')); ?>
			<?php echo getWritableRow($mtconf->getjconf('absolute_path').$mtconf->get('relative_path_to_listing_small_image')); ?>
		</tbody>
	</table>

	<?php
	
	return true;
}

function getHtaccessRenameRow($htaccess_rename_status)
{
	$msg = '';
	if(!$htaccess_rename_status)
	{
		$msg .= '<tr>';
		$msg .= '<td>';
		$msg .= 'Mosets Tree was unable to rename htaccess.txt to .htaccess at '.JPATH_SITE.$mtconf->get('relative_path_to_attachments').'. Please manually rename this file before using Mosets Tree.';
		$msg .= '</td>';
		$msg .= '<td>';
		$msg .= '<b><font color="red">Warning</font></b>';
		$msg .= '</td>';
		$msg .= '</tr>';
	}
	return $msg;
}

function getWritableRow($dir)
{
	$msg = '<tr>';
	$msg .= '<td>';
	$msg .= $dir;
	$msg .= '</td>';
	$msg .= '<td>';
	$msg .= (is_writable( $dir ) ? '<b><font color="green">Writeable</font></b>' : '<b><font color="red">Unwriteable</font></b>');
	$msg .= '</td>';
	$msg .= '</tr>';
	return $msg;
}
?>