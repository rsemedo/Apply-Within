<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

function AlphacontentBuildRoute(&$query) {
	$segments = array();
	$db		  = & JFactory::getDBO();

	$section = '';
	$category = '';
	
	if(isset($query['section'])) {
		$section = $query['section'];
		unset($query['section']);
	};
	
	if ( $section=='0' ) $section = "uncategorized";
	
	/* Get section name */
	if ( $section ) {
		switch ( $section ) {
		
			case 'weblinks':
				$section ='weblinks';
				break;
			case 'contacts':
				$section ='contacts';
				break;
			case 'uncategorized':
				$section = '0-' . urlencode(JText::_('AC_UNCATEGORIZED'));
				break;
			default:			
				if ( $section > 0 ) {
					$sql = "SELECT `alias` FROM `#__sections`
							WHERE `id` = " . $section . " LIMIT 1";
			
					$db->setQuery($sql);
					$section = $section . '-' . urlencode(trim($db->loadResult()));
					if (!$section) $section = '';				
				} else $section = '';			
		}		
		$segments[] = $section;		
	}


	if(isset($query['category'])) {
		$category = $query['category'];
		unset($query['category']);
	}
	
	/* Get category name */
	if ( $category ) {
		
		$sql = "SELECT `alias` FROM `#__categories`
				WHERE `id` = " . $category . " LIMIT 1";

		$db->setQuery($sql);
		$category = $category . '-' . urlencode(trim($db->loadResult()));
		if (!$section) $category = '';
		
		$segments[] = $category;
		
	}

	return $segments;
}

function AlphacontentParseRoute($segments)
{
	$vars = array();	
	$db	= & JFactory::getDBO();
	
	JPlugin::loadLanguage( 'com_alphacontent' );
	
	$task = JRequest::getVar ( 'task', '', 'get', 'string' );
	if ( $task=='viewmap' ) return $segments;
	
	// Count route segments
	$count = count($segments);

	if ( $count ) {
	
		$segments[0] = str_replace( '.html', '', $segments[0] );
		
		// Break up the section id into numeric and alias values.
		if (isset($segments[0]) && strpos($segments[0], ':')) {
			list($sectionid, $sectionalias) = explode(':', $segments[0], 2);
		}
		
		
		if ( $segments[0] == '0:' . urldecode(JText::_('AC_UNCATEGORIZED')) ) $segments[0] = 'uncategorized';
		
		switch ( $segments[0] ) {
			case 'weblinks':
				$vars['section'] = 'weblinks';
				break;
			case 'contacts':
				$vars['section'] = 'contacts';
				break;
			case 'uncategorized': 
				$vars['section'] = '0';
				break;
			default:
				$sql = "SELECT `id` FROM `#__sections`
						WHERE `alias` = '" . urldecode($sectionalias) . "' LIMIT 1";						
						
				$db->setQuery($sql);
				$section = $db->loadResult();
				
				if (!$section) $section = '';
				$vars['section'] = $section;
		}
		
		if ( $count==2 ) {
			
			$segments[1] = str_replace( '.html', '', $segments[1] );
			
			// Break up the category id into numeric and alias values.
			if (isset($segments[1]) && strpos($segments[1], ':')) {
				list($catid, $catalias) = explode(':', $segments[1], 2);
			}
					
			$sql = "SELECT `id` FROM `#__categories`
					WHERE `alias` = '" . urldecode($catalias) . "' LIMIT 1";

			$db->setQuery($sql);
			$category = $db->loadResult();
			if (!$category) $category = '';	
			$vars['category'] = $category;

		}
	}

	return $vars;
}
?>