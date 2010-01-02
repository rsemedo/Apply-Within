<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class alphacontentModelAlphacontent extends Jmodel {

	var $currentselection = null;
	var $_rowsDirectory = null;
	var $_rowUncategorized = null;
	var $_rowWeblinksSection = null;
	
	function __construct(){
		parent::__construct();
	}
	
	function _load_alphabetical_bar ( $params ) {		
		$alphabeticalindex = @explode( ",", $params->get('alphabeticalindex') );
		return $alphabeticalindex;		
	}

	function _load_alphacontent ( &$options, &$params ) {	
		global $mainframe;
		
		$user = & JFactory::getUser();
		$aid = $user->get('aid', 0);			
		$currentselection = "none";
		$_rowsDirectory[] = null;
	
		// Home Directory
		if ( $options['section']=='' && $options['section']!=='0') {
			switch ( $params->get('content') ) {				
				case '0': // content item only
					$_rowsDirectory = $this->_getDirectory( $aid, $params );
					$_rowsDirectory = $this->add_subcategories( $_rowsDirectory, 'content', $aid, $params );
					break;					
				case '1': // uncategorized (static only)
					$_rowsDirectory[0] = $this->_getUncategorized( $params->get('imageuncategorizedsection'), $aid, $params->get('archived') );
					break;
				case '2': // both							
					$_rowsDirectory = $this->_getDirectory( $aid, $params );
					$_rowsDirectory = $this->add_subcategories( $_rowsDirectory, 'content', $aid, $params );
					$_rowUncategorized = $this->_getUncategorized( $params->get('imageuncategorizedsection'), $aid, $params->get('archived') );
					$_rowsDirectory[count( $_rowsDirectory )] = $_rowUncategorized;
					break;
				case '3': // none
				default:
					$_rowsDirectory[0]->id          = '';
					$_rowsDirectory[0]->title       = '';
					$_rowsDirectory[0]->image       = '';
					$_rowsDirectory[0]->ncat        = '';
					$_rowsDirectory[0]->nitems      = '';
					$_rowsDirectory[0]->subcats     = '';
			}			
			if ( $params->get('weblinkssection') ) {
					// Add weblinks component as a section
					$_rowWeblinksSection = $this->_getWeblinksSection( $params->get('imageweblinkssection'), $params->get('categoryidweblinks'), $aid );							
					$_rowWeblinksSection = $this->add_subcategories( $_rowWeblinksSection, 'weblinks', $aid, $params );
					$_rowsDirectory[count( $_rowsDirectory )] = $_rowWeblinksSection;	
			}			
			if ( $params->get('contactsection') ) {
					// Add weblinks component as a section
					$_rowContactSection = $this->_getContactSection( $params->get('imagecontactsection'), $params->get('categoryidcontacts'), $aid );
					$_rowContactSection = $this->add_subcategories( $_rowContactSection, 'contact_details', $aid, $params );
					$_rowsDirectory[count( $_rowsDirectory )] = $_rowContactSection;
			}
			$currentselection = 'directory';
		}
		// Show Section selected
		if ( $options['section']!='' && $options['category']=='' ) {
			$_rowsDirectory = $this->_getSection( $options, $params );
			$currentselection = 'section';
		}
		// Show Category selected
		if ( $options['category'] ) {
			$_rowsDirectory = $this->_getCategory( $options, $params );
			$currentselection = 'category';
		}		
		return array ($_rowsDirectory, $currentselection);	
	}
	
	function _setDirectoryParams() {
		global $mainframe;
		
		// Get general component configuration
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphacontent'.DS.'configuration'.DS.'configuration.php' );
		$alphacontentparams = new alphaConfiguration();
		
		// Get the page/component configuration
		$menus = &JSite::getMenu();		
		$home  = $menus->getDefault();
		$menu  = $menus->getActive();
		
		if(is_object($menu) && ($menu->id != $home->id)) {		
			$menuid = $menu->id;
		} else {
			$menuid = $home->id;		
			$menus->setActive($home->id);
			$menu  = $menus->getActive();
			$menuid = $menu->id;
		}			
		
		$params = $menus->getParams($menuid);
		
		// Set the page/component configuration with general configuration
		$params->def( 'list_homeresult', $alphacontentparams->list_homeresult );
		$params->def( 'list_featuredID', $alphacontentparams->list_featuredID );
		$params->def( 'list_numcols', $alphacontentparams->list_numcols );		
		$params->def( 'list_introstyle', $alphacontentparams->list_introstyle );		
		$params->def( 'list_titlelinkable', $alphacontentparams->list_titlelinkable );
		$params->def( 'list_numindex', $alphacontentparams->list_numindex );
		$params->def( 'list_iconnew', $alphacontentparams->list_iconnew );
		$params->def( 'list_iconhot', $alphacontentparams->list_iconhot );
		$params->def( 'list_showdate', $alphacontentparams->list_showdate );
		$params->def( 'list_formatdate', $alphacontentparams->list_formatdate );
		$params->def( 'list_showauthor', $alphacontentparams->list_showauthor );
		$params->def( 'list_showsectioncategory', $alphacontentparams->list_showsectioncategory );
		$params->def( 'list_showhits', $alphacontentparams->list_showhits );
		$params->def( 'list_shownumcomments', $alphacontentparams->list_shownumcomments );
		$params->def( 'list_commentsystem', $alphacontentparams->list_commentsystem );
		$params->def( 'list_showprint', $alphacontentparams->list_showprint );
		$params->def( 'list_showpdf', $alphacontentparams->list_showpdf );
		$params->def( 'list_showemail', $alphacontentparams->list_showemail );
		$params->def( 'list_showreportlisting', $alphacontentparams->list_showreportlisting );		
		$params->def( 'list_email_administrator', $alphacontentparams->list_email_administrator );		
		$params->def( 'list_showreadmore', $alphacontentparams->list_showreadmore );		
		$params->def( 'list_showlinkmap', $alphacontentparams->list_showlinkmap );
		$params->def( 'list_shownumberpagetotal', $alphacontentparams->list_shownumberpagetotal );		
		$params->def( 'list_resultperpage', $alphacontentparams->list_resultperpage );
		$params->def( 'list_showsearchbox', $alphacontentparams->list_showsearchbox );
		$params->def( 'list_showsearchboxbutton', $alphacontentparams->list_showsearchboxbutton );
		$params->def( 'list_showorderinglist', $alphacontentparams->list_showorderinglist );
		$params->def( 'list_defaultordering', $alphacontentparams->list_defaultordering );
		$params->def( 'list_showimage', $alphacontentparams->list_showimage );
		$params->def( 'list_imageposition', $alphacontentparams->list_imageposition );
		$params->def( 'list_widthimage', $alphacontentparams->list_widthimage );
		$params->def( 'apikeygooglemap', $alphacontentparams->apikeygooglemap );
		$params->def( 'zoomlevel', $alphacontentparams->zoomlevel );
		$params->def( 'widthgooglemap', $alphacontentparams->widthgooglemap );
		$params->def( 'heightgooglemap', $alphacontentparams->heightgooglemap );
		$params->def( 'showmaptypemenu', $alphacontentparams->showmaptypemenu );
		$params->def( 'showmapcontrolsmenu', $alphacontentparams->showmapcontrolsmenu );
		$params->def( 'activeglobalsystemrating', $alphacontentparams->activeglobalsystemrating );
		$params->def( 'numstars', $alphacontentparams->numstars );
		$params->def( 'widthstars', $alphacontentparams->widthstars );		
		$params->def( 'showsharethis', $alphacontentparams->showsharethis );
		$params->def( 'sharethiscode', $alphacontentparams->sharethiscode );		
		$params->def( 'list_keywebsnapr', $alphacontentparams->list_keywebsnapr );
		$params->def( 'list_sizewebsnapr', $alphacontentparams->list_sizewebsnapr );

		return $params;
	}
	
	
	function _getUncategorized( $image, $aid, $archived, $desc=0 ) {
	
		if ( $image == '-1' ) $image = '';

		$rowWeblinksSection        = new stdClass();
		$rowUncategorized->id      = '0';
		$rowUncategorized->title   = JText::_( 'AC_UNCATEGORIZED' );
		$rowUncategorized->image   = $image;
		$rowUncategorized->ncat    = '0';
		$rowUncategorized->nitems  = $this->_getNumberItem('0', '', $aid, $archived );
		$rowUncategorized->subcats = '';
		
		if ( $desc ) $rowUncategorized->description = JText::_('AC_DESCRIPTION_UNCATEGORIZED');
		
		return $rowUncategorized;	
	}
	
	function _getContactSection( $image, $in_cat_id, $aid, $desc=0 ) {
	
		if ( $image == '-1' ) $image = '';
	
		$rowContactSection          = new stdClass();
		$rowContactSection->id      = 'contacts';		
		$rowContactSection->title   = JText::_( 'AC_CONTACTS' );
		$rowContactSection->image   = $image;
		$rowContactSection->ncat    = $this->_getNumberCat( 'com_contact_details', $in_cat_id, $aid );
		$rowContactSection->nitems  = $this->_getNumberItem( 'contacts', $in_cat_id, $aid );
		$rowContactSection->subcats = '';
		
		if ( $desc ) $rowContactSection->description = JText::_('AC_DESCRIPTION_CONTACTS');
		
		return $rowContactSection;
	}
	
	function _getWeblinksSection( $image, $in_cat_id, $aid, $desc=0) {
		
		if ( $image == '-1' ) $image = '';
		
		$rowWeblinksSection          = new stdClass();
		$rowWeblinksSection->id      = 'weblinks';
		$rowWeblinksSection->title   = JText::_( 'AC_WEBLINKS' );
		$rowWeblinksSection->image   = $image;
		$rowWeblinksSection->ncat    = $this->_getNumberCat( 'com_weblinks', $in_cat_id, $aid );
		$rowWeblinksSection->nitems  = $this->_getNumberItem( 'weblinks', $in_cat_id, $aid );
		$rowWeblinksSection->subcats = '';
		
		if ( $desc ) $rowWeblinksSection->description = JText::_('AC_DESCRIPTION_WEBLINKS');
		
		return $rowWeblinksSection;	
	}
	
	function _getNumberCatQuery( $section, $in_cat_id, $aid ) {
	
		$db	=& JFactory::getDBO();
		
		$select = "COUNT(*) as totalCat";
		$from	= "#__categories";

		$wheres[] = "section = '".$section."'";
		$wheres[] = "published = 1";
		$wheres[] = "parent_id = 0";

		if ($aid !== null) {
			$wheres[] = "access <= " . (int) $aid;
		}		
		
		if ($in_cat_id) {
			$ids = explode( ',', $in_cat_id );
			JArrayHelper::toInteger( $ids );
			$wheres[] = '(id=' . implode( ' OR id=', $ids ) . ')';
		}
		
		$query = "SELECT " . $select .
				" FROM " . $from .
				" WHERE " . implode( " AND ", $wheres );

		return $query;	
	}
	

	function _getNumberCat ( $section, $in_cat_id, $aid ) {
	
		$db	=& JFactory::getDBO();
		$query	= $this->_getNumberCatQuery( $section, $in_cat_id, $aid );
		
		$result = $this->_getList( $query );
		return @$result[0]->totalCat;		
	}
	
	function _getNumberItemQuery( $section, $in_cat_id, $aid, $archived ) {	
	
		$db	=& JFactory::getDBO();
		
		$user = & JFactory::getUser();
		
		$params = $this->_setDirectoryParams();
		
		jimport('joomla.utilities.date');
		$jnow		= new JDate();
		$now		= $jnow->toMySQL();
		$nullDate	= $this->_db->getNullDate();
		
		$select = "COUNT(*) as totalItem";		
		
		if ( $section!='weblinks' && $section!='contacts' ) {
		
			// used just for uncategorized item			
			$from = "#__content";			

			$wheres[] = "sectionid = '".$section."'";
			
			// state		
			$state = ' state = 1 ';	
			if ( $archived ){ 
				$state = ' (state = 1 OR state = -1)'; 
			}
			$wheres[] = $state;
			
			//if (!$user->authorize('com_content', 'edit', 'content', 'all'))	{
			/*
				$wherepublish  = ' ( ';
				$wherepublish .= ' ( created_by = ' . (int) $user->id . ' ) ';
				$wherepublish .= '   OR ';
				$wherepublish .= $state .
			*/
				$wherepublish = 
							' ( publish_up = '.$this->_db->Quote($nullDate).' OR publish_up <= '.$this->_db->Quote($now).' )' .
							' AND ( publish_down = '.$this->_db->Quote($nullDate).' OR publish_down >= '.$this->_db->Quote($now).' )';
				//$wherepublish .= ' ) ';
				$wheres[] = $wherepublish;
			//}
			
			if ($user->aid !== null && !$params->get('noauth')) {
				$wheres[] = " access <= " . (int) $user->aid;
			}			
			
		} elseif ( $section == 'contacts' ) {
			$from = "#__contact_details";				
	
			$wheres[] = "published='1'";
			if ($user->aid !== null && !$params->get('noauth')) {
				$wheres[] = " access <= " . (int) $user->aid;
			}
						
			if ($in_cat_id) {
				$ids = explode( ',', $in_cat_id );
				JArrayHelper::toInteger( $ids );
				$wheres[] = '(catid=' . implode( ' OR catid=', $ids ) . ')';
			}

		} elseif ( $section == 'weblinks' ) {

			$from = "#__weblinks";
			
			$wheres[] = "published='1'";
			$wheres[] = "approved='1'";
			
			if ($in_cat_id) {
				$ids = explode( ',', $in_cat_id );
				JArrayHelper::toInteger( $ids );
				$wheres[] = '(catid=' . implode( ' OR catid=', $ids ) . ')';
			}
					
		} 		
		$query = "SELECT " . $select .
				" FROM " . $from .
				" WHERE " . implode( " AND ", $wheres );				

		return $query;
	
	}

	function _getNumberItem ( $section, $in_cat_id, $aid, $archived='' ) {
	
		$query	= $this->_getNumberItemQuery( $section, $in_cat_id, $aid, $archived );
		$result = $this->_getList( $query );
		return @$result[0]->totalItem;
		
	}
	
	function _getDirectoryQuery( $aid, $params ) {
	
		$db	=& JFactory::getDBO();
		
		$in_section_id = $params->get('sectionid');
		if ($in_section_id) {
			$ids = explode( ',', $in_section_id );
			JArrayHelper::toInteger( $ids );
			$in_section_id = ' AND (s.id=' . implode( ' OR s.id=', $ids ) . ')';
		}	
		
		$select = "s.id, s.title, s.image, '0' AS ncat, '0' AS nitems, '' as subcats";
		$from	= "#__sections AS s";

		$wheres[] = "s.published = 1";
		
		//if ($aid !== NULL) {
		$wheres[] = "s.access <= " . (int) $aid;
		//}
		
		$ordering_by = " ORDER BY s.".$params->get('orderingsectioncat');

		$query = "SELECT " . $select .
				" FROM " . $from .
				" WHERE " . implode( " AND ", $wheres ) .
				$in_section_id .
				$ordering_by;
				
		return $query;
	}
	
	// add subcategories in each section
	function add_subcategories( $_rows, $com, $aid, $params, $limit=0 ) {
	
		global $mainframe;
	
		$db	=& JFactory::getDBO();
		
		$user = & JFactory::getUser();
		
		$tempsubcats = "";
		$ordering_by = " ORDER BY ".$params->get('orderingsectioncat');

		$limit = ( $params->get('limitnumcat')>0 && $limit==0 ) ? " LIMIT " . $params->get('limitnumcat') : "";
		
		$wheres = '';
		$access = '';
		
		jimport('joomla.utilities.date');
		$jnow		= new JDate();
		$now		= $jnow->toMySQL();
		$nullDate	= $db->getNullDate();
		
		switch ( $com ) {		
			case 'content':	
						
				$in_cat_id = $params->get('categoryid');
				if ($in_cat_id) {
					$ids = explode( ',', $in_cat_id );
					JArrayHelper::toInteger( $ids );
					$in_cat_id = ' AND (id=' . implode( ' OR id=', $ids ) . ')';
				}				
				for($i = 0; $i <  count( $_rows ); $i++) {
					$row =& $_rows[$i];
					// get categories...
					$query = "SELECT COUNT(*) FROM #__categories WHERE section='".$row->id."' AND published='1' AND access <= " . (int) $aid . $in_cat_id;
					$db->setQuery( $query );
					$totalcat = $db->loadResult();
					
					$query = "SELECT id, title FROM #__categories WHERE section='".$row->id."' AND published='1' AND access <= " . (int) $aid . $in_cat_id . $ordering_by . $limit;
					$db->setQuery( $query );
					$result = $db->loadObjectList();
					if ( $result ) {					
						$row->ncat = $totalcat;
						for($n=0; $n < count( $result ); $n++) {
							$sep = ( $n < (count( $result )-1) && $totalcat > 1  ) ? "\n"  : "" ;							
							$tempsubcats .= $result[$n]->id . "|" . $result[$n]->title . $sep;
						}
						$row->subcats = $tempsubcats;
						$tempsubcats = "";
					}
					
					// count num articles in each section
					
					// state
					if ( $params->get('archived')=='1' ){ 
						$state = " AND (state = '1' OR state = '-1')";
					} else {
						$state = " AND (state = '1')";	
					}	
					$wheres[] = $state;
					
					// published
					//if (!$user->authorize('com_content', 'edit', 'content', 'all'))	{
						//$wherepublish  = " AND ( ";
						//$wherepublish .= " ( created_by = " . (int) $user->id . " ) ";
						//$wherepublish .= " ( created_by = " . (int) $user->id . " ) ";
						//$wherepublish .= "   OR ";
						//$wherepublish .= $state .
						$wherepublish = 
									' ( publish_up = '.$this->_db->Quote($nullDate).' OR publish_up <= '.$this->_db->Quote($now).' )' .
									' AND ( publish_down = '.$this->_db->Quote($nullDate).' OR publish_down >= '.$this->_db->Quote($now).' )';
						//$wherepublish .= ' ) ';
						$wheres[] = $wherepublish;
					//}
					/*
					if ($user->aid !== null && !$params->get('noauth')) {
						$access = " AND access <= " . (int) $user->aid;
					}
					*/
					if ($user->aid !== null && !$params->get('noauth')) {
						$wheres[] = " access <= " . (int) $user->aid;
					}			

					
					$in_cat_id = $params->get('categoryid');
					if ($in_cat_id) {
						$ids = explode( ',', $in_cat_id );
						JArrayHelper::toInteger( $ids );
						$wheres[] = " (catid=" . implode( " OR catid=", $ids ) . ")";
					}		 

					//$query = "SELECT COUNT(*) FROM #__content WHERE sectionid='".$row->id."'" . @implode( " AND ", $wheres ) . $access;
					$query = "SELECT COUNT(*) FROM #__content WHERE sectionid='".$row->id."'" . @implode( " AND ", $wheres );
					$db->setQuery( $query );
					$row->nitems = $db->loadResult();
					
					$wheres = '';
				}				
				return $_rows;
				break;			
			case 'weblinks':
			
				$in_cat_id = $params->get('categoryidweblinks');
				if ($in_cat_id) {
					$ids = explode( ',', $in_cat_id );
					JArrayHelper::toInteger( $ids );
					$in_cat_id = ' AND (id=' . implode( ' OR id=', $ids ) . ')';
				}
				$query = "SELECT id, title FROM #__categories WHERE section='com_" . $com . "' AND published='1' AND access <= " . (int) $aid . $in_cat_id;
				$db->setQuery( $query );
				$totalcat = $db->loadResult();
				
				$query = "SELECT id, title FROM #__categories WHERE section='com_" . $com . "' AND published='1' AND access <= " . (int) $aid . $in_cat_id . $ordering_by . $limit;
				$db->setQuery( $query );
				$result  = $db->loadObjectList();
				if ( $result ) {
					for($n = 0; $n <  count( $result ); $n++) {
						$sep = ( $n < (count( $result )-1) && $totalcat > 1 ) ? "\n"  : "" ;		
						$tempsubcats .= $result[$n]->id . "|" . $result[$n]->title . $sep;						
					}
					if ( ( $totalcat > $params->get('limitnumcat') ) && $params->get('limitnumcat' ) > 1 && !(count( $result )==$params->get('limitnumcat' )) ) $tempsubcats .= "\n...";
					$_rows->subcats = $tempsubcats;
					$tempsubcats = "";
				}
				return $_rows;			
				break;

			case 'contact_details':
			
				$in_cat_id = $params->get('categoryidcontacts');
				if ($in_cat_id) {
					$ids = explode( ',', $in_cat_id );
					JArrayHelper::toInteger( $ids );
					$in_cat_id = ' AND (id=' . implode( ' OR id=', $ids ) . ')';
				}	
				$query = "SELECT id, title FROM #__categories WHERE section='com_" . $com . "' AND published='1' AND access <= " . (int) $aid . $in_cat_id;
				$db->setQuery( $query );
				$totalcat = $db->loadResult();
				
				$query = "SELECT id, title FROM #__categories WHERE section='com_" . $com . "' AND published='1' AND access <= " . (int) $aid . $in_cat_id . $ordering_by . $limit;
				$db->setQuery( $query );
				$result  = $db->loadObjectList();
				if ( $result ) {
					for($n = 0; $n <  count( $result ); $n++) {
						$sep = ( $n < (count( $result )-1) && $totalcat > 1 ) ? "\n"  : "" ;		
						$tempsubcats .= $result[$n]->id . "|" . $result[$n]->title . $sep;						
					}
					if ( ( $totalcat > $params->get('limitnumcat') ) && $params->get('limitnumcat' ) > 1 && !(count( $result )==$params->get('limitnumcat' )) ) $tempsubcats .= "\n...";
					$_rows->subcats = $tempsubcats;
					$tempsubcats = "";
				}
				return $_rows;			
				break;																			
		}				
	}	
	

	/**
	 * Gets a list of Sections
	 * @param array
	 * @return mixed Object or null
	 */	 
	function _getDirectory( $aid, $params ) {
	
		$query	= $this->_getDirectoryQuery( $aid, $params );
		$result = $this->_getList( $query );
		return @$result;
		
	}	
	
	function _getSectionQuery( $section, $aid, $archived, $in_cat_id ) {
	
		$select = "s.id, s.title, s.image, '0' AS ncat, '0' AS nitems, '' as subcats, s.description";
		$from	= "#__sections AS s";
		$wheres[] = "s.id = '".intval($section)."'";
		
		$query = "SELECT " . $select .
				" FROM " . $from .
				" WHERE " . implode( " AND ", $wheres ) //.
				;

		return $query;
	}

	/**
	 * Gets a list of categories when a section is selected
	 * @param array
	 * @return mixed Object or null
	 */
	function _getSection( &$options, &$params )	{
		
		$user = & JFactory::getUser();
		$aid = $user->get('aid', 0);
		
		$result[0]->id          = '';
		$result[0]->title       = '';
		$result[0]->image       = '';
		$result[0]->ncat        = '';
		$result[0]->nitems      = '';
		$result[0]->subcats     = '';
		$result[0]->description = '';
		
		switch ( $options['section'] ) {
			case 'weblinks':
				$resultW = $this->_getWeblinksSection( $params->get('imageweblinkssection'), $params->get('categoryidweblinks'), $aid, 1 );
				$resultW = $this->add_subcategories( $resultW, 'weblinks', $aid, $params, 1 );
				$result[0] = $resultW;
				break;
			case 'contacts':
				$resultC = $this->_getContactSection( $params->get('imagecontactsection'), $params->get('categoryidcontacts'), $aid, 1 );
				$resultC = $this->add_subcategories( $resultC, 'contact_details', $aid, $params, 1 );
				$result[0] = $resultC;
				break;
			case '0':				
				$result[0] = $this->_getUncategorized( $params->get('imageuncategorizedsection'), $aid, $params->get('archived'), 1 );
				break;
			default:
				$query	= $this->_getSectionQuery( $options['section'], $aid, $params->get('archived'), $params->get('categoryid') );				
				$result = $this->_getList( $query );
				$result = $this->add_subcategories( $result, 'content', $aid, $params, 1 );	
		}
		return @$result;
	}
	
	
	/**
	 * Gets pathway when a category is selected
	 * @param array
	 * @return mixed Object or null
	 */
	function _getCategory( &$options, &$params ) {
	
		$db	=& JFactory::getDBO();
	
		$user = & JFactory::getUser();
		$aid = $user->get('aid', 0);
		
		$result[0]->id             = '';
		$result[0]->title          = '';
		$result[0]->image          = '';
		$result[0]->ncat           = '';
		$result[0]->nitems         = '';
		$result[0]->subcats        = '';
		$result[0]->currentcat     = '';
		$result[0]->imagecat       = '';
		$result[0]->descriptioncat = '';
		
		switch ( $options['section'] ) {
			case 'weblinks':
				$resultW = $this->_getWeblinksSection( $params->get('imageweblinkssection'), $params->get('categoryidweblinks'), $aid, 0 );
				$result[0] = $resultW;
				break;
			case 'contacts':
				$resultC = $this->_getContactSection( $params->get('imagecontactsection'), $aid, 0 );
				$result[0] = $resultC;
				break;
			default:
				$query	= $this->_getSectionQuery( $options['section'], $aid, $params->get('archived'), $params->get('categoryid') );				
				$result = $this->_getList( $query );
		}
		$query = "SELECT id, title, image, description FROM #__categories WHERE id = '".intval($options['category'])."'";
		$resultcat = $this->_getList( $query );
		
		$result[0]->currentcat     = $resultcat[0]->title;
		$result[0]->imagecat       = $resultcat[0]->image;
		$result[0]->descriptioncat = $resultcat[0]->description;
		$result[0]->catid          = $resultcat[0]->id;
		
		return @$result;
	}
	
	
	function _load_description_directory ( &$params ) {
	
		// prepare description directory
		$contentdescriptiondirectory = "";
		
		if ( $params->get( 'showdescriptiondirectory' ) ) {
			$db	=& JFactory::getDBO();			
			$db->setQuery( "SELECT introtext FROM #__content  WHERE id=".$params->get('descriptiondirectorycontentid')."");
			$contentdescriptiondirectory = $db->loadResult();			
		}
		
		return $contentdescriptiondirectory;	
	
	}
}
?>