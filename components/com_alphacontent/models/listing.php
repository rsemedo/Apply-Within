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

class alphacontentModelListing extends Jmodel {

	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Gets a list of items
	 * @param array
	 * @return mixed Object or null
	 */
	function _load_listing ( &$options, &$params )	{			
		global $mainframe;				

		$section     =  $options['section'];
		$category    =  $options['category'];
		$letter      =  $options['letter'];
		$search      =  $options['search']	;
		$searchfield =  $options['searchfield'];		
		$ordering    =  $this->_getOrdering( $options['ordering'], $section );
		$tag 		 =  $options['tag']	;
		
		$rowsListing[] = null;
		if ( !$tag ) {
			if ( $section=='' && $params->get('list_homeresult') && $search=='' && $letter=='' ) {
			
					switch ( $params->get('list_homeresult' ) ) {
						case '1':
							$_Listing = $this->_getItems( $category, $letter, $options, $params, $ordering );
							$rowsListing = $_Listing[0];
							$options['total'] = $_Listing[1];
							break;
						case '2':
							$_Listing = $this->_getItemsUN( $category, $letter, $options, $params, $ordering );
							$rowsListing = $_Listing[0];
							$options['total'] = $_Listing[1];
							break;
						case '3':
							$ordering    =  $this->_getOrdering( $options['ordering'], 'weblinks' );
							$_Listing = $this->_getItemsWL( $category, $letter, $options, $params, $ordering );		
							$rowsListing = $_Listing[0];
							$options['total'] = $_Listing[1];
							break;
						case '4':
							$ordering    =  $this->_getOrdering( $options['ordering'], 'contacts' );
							$_Listing = $this->_getItemsCT( $category, $letter, $options, $params, $ordering );
							$rowsListing = $_Listing[0];
							$options['total'] = $_Listing[1];
							break;
						case '5':
							$_Listing = $this->_getFeaturedItems( $params );
							$rowsListing = $_Listing[0];
							$options['total'] = $_Listing[1];
							break;
					}			
			
			} elseif  ( $section=='' && ( $search!='' || $letter!='' ) ) {
			
					switch ( $params->get('content') ) {				
						case '0': // content item only
							if ( $params->get('weblinkssection') || $params->get('contactsection') ) {
								$_Listing = $this->_getItems( $category, $letter, $options, $params, $ordering, 1000,   0 );
							} else {
								$_Listing = $this->_getItems( $category, $letter, $options, $params, $ordering );
							}
							$rowsListing = $_Listing[0];
							$options['total'] = $_Listing[1];
							break;					
						case '1': // uncategorized (static only)
							if ( $params->get('weblinkssection') || $params->get('contactsection') ) {
								$_Listing = $this->_getItemsUN( $category, $letter, $options, $params, $ordering, 1000, 0 );
							} else {
								$_Listing = $this->_getItemsUN( $category, $letter, $options, $params, $ordering );
							}
							$rowsListing = $_Listing[0];
							$options['total'] = $_Listing[1];
							break;
						case '2': // both
							if ( $params->get('weblinkssection') || $params->get('contactsection') ) {							
								$_Listing = $this->_getItems( $category, $letter, $options, $params, $ordering, 1000,   0 );		
							} else {
								$_Listing = $this->_getItems( $category, $letter, $options, $params, $ordering );		
							}
							$rowsListing1 = $_Listing[0];
							$total1 = $_Listing[1];
							if ( $params->get('weblinkssection') || $params->get('contactsection') ) {		
								$_Listing = $this->_getItemsUN( $category, $letter, $options, $params, $ordering, 1000, 0 );
							} else {
								$_Listing = $this->_getItemsUN( $category, $letter, $options, $params, $ordering );
							}
							$rowsListing2 = $_Listing[0];
							$total2 = $_Listing[1];
														
							$rowsListing = @array_merge($rowsListing1,$rowsListing2);
							$options['total'] = $total1 + $total2;
							break;
						case '3': // none
						default:
					}
					
					if ( $params->get('weblinkssection') ) {
							// Add weblinks component as a section
							$ordering    =  $this->_getOrdering( $options['ordering'], 'weblinks' );
							$_Listing = $this->_getItemsWL( $category, $letter, $options, $params, $ordering, 1000, 0 );
							$rowsListingWL = $_Listing[0];
							$rowsListing = @array_merge($rowsListing,$rowsListingWL);
							$options['total'] = $options['total'] + $_Listing[1];
					}
					
					if ( $params->get('contactsection') ) {
							// Add contacts component as a section
							$ordering    =  $this->_getOrdering( $options['ordering'], 'contacts' );
							$_Listing = $this->_getItemsCT( $category, $letter, $options, $params, $ordering, 1000, 0 );
							$rowsListingCT = $_Listing[0];		
							$rowsListing = @array_merge($rowsListing,$rowsListingCT);
							$options['total'] = $options['total'] + $_Listing[1];
					}			
										
			} elseif ( $section!='' ) {
			
				switch ( $section ) {			
					case 'weblinks':   // weblinks as a section			
						$_Listing = $this->_getItemsWL( $category, $letter, $options, $params, $ordering );		
						$rowsListing = $_Listing[0];
						$options['total'] = $_Listing[1];					
						break;					
					case 'contacts':   // contacts as a section			
						$_Listing = $this->_getItemsCT( $category, $letter, $options, $params, $ordering );
						$rowsListing = $_Listing[0];
						$options['total'] = $_Listing[1];
						break;					
					case '0':          // uncategorized articles			
						$_Listing = $this->_getItemsUN( $category, $letter, $options, $params, $ordering );
						$rowsListing = $_Listing[0];
						$options['total'] = $_Listing[1];
						break;				
					case ((intval($section) > '0' ) && ($section!='')): // articles					
						$_Listing = $this->_getItems( $category, $letter, $options, $params, $ordering );
						$rowsListing = $_Listing[0];
						$options['total'] = $_Listing[1];
						break;										
				}			
			
			
			}
		} else {		
			$_Listing = $this->_getItems( $category, $letter, $options, $params, $ordering, 1000, 0 );		
			$rowsListing1 = $_Listing[0];
			$total1 = $_Listing[1];
			$_Listing = $this->_getItemsUN( $category, $letter, $options, $params, $ordering, 1000, 0 );
			$rowsListing2 = $_Listing[0];
			$total2 = $_Listing[1];	
			
			$rowsListing = @array_merge($rowsListing1,$rowsListing2);
			$options['total'] = $total1 + $total2;
		}
		return $rowsListing;
	}
	
	function _load_listingcatbegenningby ( &$options, &$params, &$directory, $currentselection='' ){	
		$letter     	=  $options['letter'];
		$section 		=  $options['section'];		
		$listingcatbegenningby = "";
		if ( $letter!='' ) {		
			switch ( $currentselection ) {
				case 'directory':
					$listingcatbegenningby = $this->_getAllCategoriesBB( $letter, $directory, $params );					
					break;				
				case 'section':
					$listingcatbegenningby = $this->_getCategoriesOnSectionBB( $letter, $section, $params );	
					break;				
				case 'category':
				default:
			}					
		}	
		if ( $listingcatbegenningby ) {
			$listingcatbegenningby = sprintf( JText::_('AC_CATEGORIESBEGENNINGWITH'), "<b>" . $letter . "</b>") . "<br />" . $listingcatbegenningby;
		}
		return $listingcatbegenningby;
	}
	
	// get all categories Beginning By letter selected on entire directory
	function _getAllCategoriesBB( $letter, &$directory, &$params ) { 
		global $Itemid;	
		$db	=& JFactory::getDBO();
		$user = & JFactory::getUser();		
		$resultlist = "";		
		$selectspecificcats = "";
		$url = "index.php?option=com_alphacontent";		
		$n = count($directory);		
		$m = 0;
		for ( $i=0; $i < $n; $i++ ){
			if ( $directory[$i]->id!='' ) {
				$linkcat = $url . "&amp;section=" . $directory[$i]->id ;				
				if (  $directory[$i]->id=='weblinks' && $params->get('categoryidweblinks') ) {				
					$selectspecificcats = " AND id IN (" . $params->get('categoryidweblinks') . ")" ;				
				} elseif (  $directory[$i]->id=='contacts' && $params->get('categoryidcontacts') ) {				
					$selectspecificcats = " AND id IN (" . $params->get('categoryidcontacts') . ")" ;					
				} else {
					if ( $params->get('categoryid') ) $selectspecificcats = " AND id IN (" . $params->get('categoryid') . ")" ;
				}								
				if ( $directory[$i]->id !='0' ) { 
				
					switch ( $directory[$i]->id ) {
						case 'contacts':
						$query = "SELECT * FROM #__categories"
								. " WHERE section='com_contact_details' AND title LIKE '".$letter."%' AND published='1' AND access <= " . (int) $user->aid 
								. $selectspecificcats
								;
						break;	
						case 'weblinks':					
						$query = "SELECT * FROM #__categories"
								. " WHERE section='com_weblinks' AND title LIKE '".$letter."%' AND published='1' AND access <= " . (int) $user->aid 
								. $selectspecificcats
								;
						break;
						default:						
						$query = "SELECT * FROM #__categories"
								. " WHERE section='".$directory[$i]->id."' AND title LIKE '".$letter."%' AND published='1' AND access <= " . (int) $user->aid 
								. $selectspecificcats
								;
						break;
					}							
					$db->setQuery($query);
					$result = $db->loadObjectList();					
					
					if ( $result ) {
						$nn = count($result);
						if ($m) {
							$resultlist .= ", ";
						}
						$m = 1;					
						for ( $ii=0; $ii < $nn; $ii++ ){						
							$linklist = $linkcat . "&amp;category=" . $result[$ii]->id . "&amp;Itemid=" . $Itemid;						
							$resultlist .= "<a href=\"".JRoute::_($linklist) . "\">".$result[$ii]->title."</a>";
							if ( $ii < ($nn-1) && $nn>1 ) $resultlist .= ", ";
						}
						
					}						
				}
			}
		}		
		return $resultlist;		
	}
	
	// get all categories Beginning By letter selected on section selected
	function _getCategoriesOnSectionBB( $letter, $section, $params ) { 
		global $Itemid;
		$db	=& JFactory::getDBO();
		$user = & JFactory::getUser();
		$resultlist = "";		
		$selectspecificcats = "";
		$linkcat = "index.php?option=com_alphacontent&amp;section=" . $section;
		if ( $section !='0' ) { 
		
			if ( $section=='weblinks' && $params->get('categoryidweblinks') ) {				
				$selectspecificcats = " AND id IN (" . $params->get('categoryidweblinks') . ")" ;				
			} elseif ( $section=='contacts' && $params->get('categoryidcontacts') ) {				
				$selectspecificcats = " AND id IN (" . $params->get('categoryidcontacts') . ")" ;					
			} else {
				if ( $params->get('categoryid') ) $selectspecificcats = " AND id IN (" . $params->get('categoryid') . ")" ;
			}								
		
			switch ( $section ) {
				case 'contacts':
				$query = "SELECT * FROM #__categories"
						. " WHERE section='com_contact_details' AND title LIKE '".$letter."%' AND published='1' AND access <= " . (int) $user->aid 
						. $selectspecificcats
						;
					break;	
				case 'weblinks':					
				$query = "SELECT * FROM #__categories"
						. " WHERE section='com_weblinks' AND title LIKE '".$letter."%' AND published='1' AND access <= " . (int) $user->aid 
						. $selectspecificcats
						;
					break;
				default:						
				$query = "SELECT * FROM #__categories"
						. " WHERE section='".$section."' AND title LIKE '".$letter."%' AND published='1' AND access <= " . (int) $user->aid 
						. $selectspecificcats
						;
					break;
			}							
			$db->setQuery($query);
			$result = $db->loadObjectList();
			if ( $result ) {
				$nn = count($result);
				for ( $ii=0; $ii < $nn; $ii++ ){						
					$linklist = $linkcat . "&amp;category=" . $result[$ii]->id . "&amp;Itemid=" . $Itemid;						
					$resultlist .= "<a href=\"".JRoute::_($linklist) . "\">".$result[$ii]->title."</a>";
					if ( $ii < ($nn-1) && $nn>1 ) $resultlist .= ", ";
				}
			}						
		}
		return $resultlist;		
	}

	
	function _getItems( $category, $letter, $options, $params, $orderby, $limit='', $limitstart='' ) {
		global $mainframe;
		
		$section     =  $options['section'];
		$category    =  $options['category'];
		$letter      =  $options['letter'];
		$search      =  $options['search'];
		$searchfield =  $options['searchfield'];
		$tag		 = 	$options['tag'];		
		$limit       = ( $limit ) ? $limit : $options['limit'] ;
		$limitstart  = ( $limitstart ) ? $limitstart : $options['limitstart'] ;
				
		$_db	=& JFactory::getDBO();
		$user = & JFactory::getUser();
		
		jimport('joomla.utilities.date');
		$jnow		= new JDate();
		$now		= $jnow->toMySQL();
		$nullDate	= $this->_db->getNullDate();

		// If voting is turned on, get voting data as well for the content items
		$queryRating  = ( $params->get('systemrating') ) ? " ROUND(ar.total_value/ar.total_votes) AS rating, ar.total_votes AS rating_count" : " ROUND(v.rating_sum/v.rating_count) AS rating, v.rating_count";
		$queryRating2 = ( $params->get('systemrating') ) ? " LEFT JOIN #__alpha_rating AS ar ON a.id=ar.id AND ar.component='com_content' AND ar.cid='0' AND ar.rid='0'" : " LEFT JOIN #__content_rating AS v ON a.id = v.content_id";
		
		// Building where
		// --------------
		$wheres[] = "  a.sectionid > '0'";
		if ( $section ) $wheres[] = " a.sectionid = '".$section."'";		
		if ( $category ) $wheres[] = " a.catid = '".$category."'";
		// specifics Sections/Categories in params menu
		if ( $params->get('sectionid') ) $wheres[] = " a.sectionid IN (" . $params->get('sectionid') . ")";
		if ( $params->get('categoryid') ) $wheres[] = " a.catid IN (" . $params->get('categoryid') . ")";
		
		if ( $search!='' ) {
			//$limit = 1000;
			switch ( $searchfield ) {			
				case 'a.title':
				case 'a.introtext':				
				case 'a.metakey':				
					$wheres[] = " ( LOWER( ".$searchfield." ) LIKE '%".$search."%')";		
					break;
				case 'a.fulltext':
				default:
					$wheres[] = " ( LOWER( a.title ) LIKE '%".$search."%' OR a.introtext LIKE '%".$search."%' OR a.fulltext LIKE '%".$search."%')";	
					break;
			}		
		}

		if ( $letter ) {
			switch ($letter) {			
				case '#':
					$wheres[] = " (a.title LIKE '\_%' OR a.title LIKE '\#%' OR a.title LIKE '\-%' OR a.title LIKE '\$%' OR a.title LIKE '\@%'".
								"  OR a.title LIKE '\!%' OR a.title LIKE '\:%' OR a.title LIKE '\*%' OR a.title LIKE '\~%' OR a.title LIKE '\?%')";
					break;
				case '0-9':					
					$wheres[] = " (a.title LIKE '0%' OR a.title LIKE '1%' OR a.title LIKE '2%' OR a.title LIKE '3%' OR a.title LIKE '4%'".
								"  OR a.title LIKE '5%' OR a.title LIKE '6%' OR a.title LIKE '7%' OR a.title LIKE '8%' OR a.title LIKE '9%')";								
					break;
				default:
					$wheres[] = " a.title LIKE '" . $letter . "%'";	
			}
			$orderby = "a.title ASC";
		}
		
		// state
		if ( $params->get('archived')=='1' ){ 
			$state = " (a.state = '1' OR a.state = '-1')";
		} else {
			$state = " (a.state = '1')";	
		}
		$wheres[] = $state;		
		// published
		//if (!$user->authorize('com_content', 'edit', 'content', 'all'))	{
			//$wherepublish  = ' ( ';
			//$wherepublish .= ' ( a.created_by = ' . (int) $user->id . ' ) ';
			//$wherepublish .= '   OR ';
			//$wherepublish .= $state .
			$wherepublish = 
						' ( a.publish_up = '.$this->_db->Quote($nullDate).' OR a.publish_up <= '.$this->_db->Quote($now).' )' .
						' AND ( a.publish_down = '.$this->_db->Quote($nullDate).' OR a.publish_down >= '.$this->_db->Quote($now).' )';
			//$wherepublish .= ' ) ';
			$wheres[] = $wherepublish;
		//}	
		
		 
		if ($user->aid !== null && !$params->get('noauth')) {
			$wheres[] = " a.access <= " . (int) $user->aid;
		}
		
		if ( $tag ) {
			$wheres[] = " LOWER(a.metakey) LIKE '%" . strtolower($tag) . "%'";
		}
		
		$query = "SELECT CONCAT_WS( '/', s.title, cc.title ) AS section, " .
				" a.id, a.title, a.introtext as text, a.fulltext, a.created, a.modified, a.created_by,".
				" a.hits, a.images, a.metakey, a.metadesc, a.attribs, '0' AS featured, '1' AS is_article," .
				" CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT(':', a.alias) ELSE '' END as slug," .
				" CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(':', cc.id, cc.alias) ELSE a.catid END as catslug," .
				" CHAR_LENGTH( a.`fulltext` ) AS readmore,".
				" CASE WHEN CHAR_LENGTH(a.created_by_alias) THEN a.created_by_alias ELSE u.name END as author," .
				" CONCAT('index.php?option=com_content&view=article&id=', a.id) AS href," .
				" CONCAT('index.php?option=com_content&view=article&id=', a.id) AS reallink," .
				" a.access," .
				$queryRating .
				" FROM #__content AS a" .
				" LEFT JOIN #__sections AS s ON a.sectionid = s.id" .
				" LEFT JOIN #__categories AS cc ON a.catid = cc.id" .
				" LEFT JOIN #__users AS u ON u.id = a.created_by" .
				" LEFT JOIN #__groups AS g ON a.access = g.id" .
				$queryRating2 .
				" WHERE " . implode( " AND ", $wheres ) .
				" ORDER BY " . $orderby ;			
				
		$total = @$this->_getListCount($query);
	
		$result = $this->_getList($query, $limitstart, $limit);
		return array($result, $total);		
	}
	
	// uncategorized
	function _getItemsUN( $category, $letter, $options, $params, $orderby, $limit='', $limitstart='', $tag='' ) {
		global $mainframe;
		
		$section     =  $options['section'];
		$category    =  $options['category'];
		$letter      =  $options['letter'];
		$search      =  $options['search'];
		$searchfield =  $options['searchfield'];		
		$tag		 = 	$options['tag'];		
		$limit       = ( $limit ) ? $limit : $options['limit'] ;
		$limitstart  = ( $limitstart ) ? $limitstart : $options['limitstart'] ;
		
		$_db	=& JFactory::getDBO();
		$user = & JFactory::getUser();
		
		jimport('joomla.utilities.date');
		$jnow		= new JDate();
		$now		= $jnow->toMySQL();
		$nullDate	= $this->_db->getNullDate();

		// If voting is turned on, get voting data as well for the content items
		$queryRating  = ( $params->get('systemrating') ) ? " ROUND(ar.total_value/ar.total_votes) AS rating, ar.total_votes AS rating_count" : " ROUND(v.rating_sum/v.rating_count) AS rating, v.rating_count";
		$queryRating2 = ( $params->get('systemrating') ) ? " LEFT JOIN #__alpha_rating AS ar ON a.id = ar.id AND ar.component='com_content' AND ar.cid='0' AND ar.rid='0'" : " LEFT JOIN #__content_rating AS v ON a.id = v.content_id";
		
		// Building where
		// --------------
		$wheres[] = " a.sectionid = '0' AND a.catid = '0'";
	
		if ( $search!='' ) {
			//$limit = 1000;
			switch ( $searchfield ) {			
				case 'a.title':
				case 'a.introtext':				
				case 'a.metakey':
					$wheres[] = " ( LOWER( ".$searchfield." ) LIKE '%".$search."%')";		
					break;
				case 'a.fulltext':
				default:
					$wheres[] = " ( LOWER( a.title ) LIKE '%".$search."%' OR a.introtext LIKE '%".$search."%' OR a.fulltext LIKE '%".$search."%' )";	
					break;
			}		
		} 

		if ( $letter ) {		
			switch ($letter) {
				case '#':
					$wheres[] = " (a.title LIKE '\_%' OR a.title LIKE '\#%' OR a.title LIKE '\-%' OR a.title LIKE '\$%' OR a.title LIKE '\@%'".
								"  OR a.title LIKE '\!%' OR a.title LIKE '\:%' OR a.title LIKE '\*%' OR a.title LIKE '\~%' OR a.title LIKE '\?%')";
					break;
				case '0-9':
					$wheres[] = " (a.title LIKE '0%' OR a.title LIKE '1%' OR a.title LIKE '2%' OR a.title LIKE '3%' OR a.title LIKE '4%'".
								"  OR a.title LIKE '5%' OR a.title LIKE '6%' OR a.title LIKE '7%' OR a.title LIKE '8%' OR a.title LIKE '9%')";
					break;
				default:
					$wheres[] = " a.title LIKE '" . $letter . "%'";	
			}
			$orderby = "a.title ASC";
		}
	
		// state
		if ( $params->get('archived')=='1' ){ 
			$state = " (a.state = '1' OR a.state = '-1')";
		} else {
			$state = " (a.state = '1')";	
		}
		$wheres[] = $state;		
		// published
		//if (!$user->authorize('com_content', 'edit', 'content', 'all'))	{
			//$wherepublish  = ' ( ';
			//$wherepublish .= ' ( a.created_by = ' . (int) $user->id . ' ) ';
			//$wherepublish .= '   OR ';
			//$wherepublish .= $state .
			$wherepublish = 
						' ( a.publish_up = '.$this->_db->Quote($nullDate).' OR a.publish_up <= '.$this->_db->Quote($now).' )' .
						' AND ( a.publish_down = '.$this->_db->Quote($nullDate).' OR a.publish_down >= '.$this->_db->Quote($now).' )';
			//$wherepublish .= ' ) ';
			$wheres[] = $wherepublish;
		//}			 
		if ($user->aid !== null && !$params->get('noauth')) {
			$wheres[] = " a.access <= " . (int) $user->aid;
		}
		
		if ( $tag ) {
			$wheres[] = " LOWER(a.metakey) LIKE '%" . strtolower($tag) . "%'";
		}

		$query = "SELECT '" . JText::_( 'AC_UNCATEGORIZED' ) . "' as section, a.id, a.title, a.introtext as text, a.fulltext, a.created, a.modified, a.created_by," .
				" a.hits, a.images, a.metakey, a.metadesc, a.attribs, '0' AS featured, '1' AS is_article," .
				" CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT(':', a.alias) ELSE '' END as slug,".
				" '' as catslug,".
				" CHAR_LENGTH( a.`fulltext` ) AS readmore,".
				" CASE WHEN CHAR_LENGTH(a.created_by_alias) THEN a.created_by_alias ELSE u.name END as author,".
				" CONCAT('index.php?option=com_content&view=article&id=', a.id) AS href,".
				" CONCAT('index.php?option=com_content&view=article&id=', a.id) AS reallink,".
				" a.access," .
				$queryRating .
				" FROM #__content AS a" .
				" LEFT JOIN #__users AS u ON u.id = a.created_by" .
				" LEFT JOIN #__groups AS g ON a.access = g.id".
				$queryRating2 .
				" WHERE " . implode( " AND ", $wheres ).
				" ORDER BY " . $orderby;			

		$total = @$this->_getListCount($query);
		$resultUN = $this->_getList($query, $limitstart, $limit);
		return array($resultUN, $total);		
	}	
	
	// weblinks
	function _getItemsWL( $category, $letter, $options, $params, $orderby, $limit='', $limitstart='' ) {
		global $mainframe;
		
		$section     =  $options['section'];
		$category    =  $options['category'];
		$letter      =  $options['letter'];
		$search      =  strtolower($options['search']);		
		$searchfield =  $options['searchfield'];			
		$limit       = ( $limit ) ? $limit : $options['limit'] ;
		$limitstart  = ( $limitstart ) ? $limitstart : $options['limitstart'] ;
	
		$_db	=& JFactory::getDBO();
		
		jimport('joomla.utilities.date');
		$jnow		= new JDate();
		$now		= $jnow->toMySQL();
		$nullDate	= $this->_db->getNullDate();

		// If voting is turned on, get voting data as well for the content items
		$queryRating  = ( $params->get('systemrating') ) ? " ROUND(ar.total_value/ar.total_votes) AS rating, ar.total_votes AS rating_count" : " '' AS rating, '' AS rating_count";
		$queryRating2 = ( $params->get('systemrating') ) ? " LEFT JOIN #__alpha_rating AS ar ON a.id = ar.id AND ar.component='com_weblinks' AND ar.cid='0' AND ar.rid='0'" : "";
		
		// Building where
		// --------------
		if ( $category ) $wheres[] = " a.catid = '".$category."'";
		
		// specifics Categories in params menu
		if ( $params->get('categoryid') ) $wheres[] = " a.catid IN (" . $params->get('categoryid') . ")";
		
		if ( $search!='' ) {
			//$limit = 1000;
			// replace introtext by description
			if ( $searchfield=='a.introtext' || $searchfield=='a.fulltext' || $searchfield=='a.metakey' ) $searchfield = "a.description";
			switch ( $searchfield ) {			
				case 'a.title':
				case 'a.description':				
					$wheres[] = " ( LOWER( ".$searchfield." ) LIKE '%".$search."%')";		
					break;
				case '':
				default:
					$wheres[] = " ( LOWER( a.title ) LIKE '%".$search."%' OR LOWER( a.description ) LIKE '%".$search."%' OR a.url LIKE '%".$search."%' )";	
					break;
			}		
		} 

		if ( $letter ) {		
			switch ($letter) {
				case '#':
					$wheres[] = " (a.title LIKE '\_%' OR a.title LIKE '\#%' OR a.title LIKE '\-%' OR a.title LIKE '\$%' OR a.title LIKE '\@%'".
								"  OR a.title LIKE '\!%' OR a.title LIKE '\:%' OR a.title LIKE '\*%' OR a.title LIKE '\~%' OR a.title LIKE '\?%')";
					break;
				case '0-9':
					$wheres[] = " (a.title LIKE '0%' OR a.title LIKE '1%' OR a.title LIKE '2%' OR a.title LIKE '3%' OR a.title LIKE '4%'".
								"  OR a.title LIKE '5%' OR a.title LIKE '6%' OR a.title LIKE '7%' OR a.title LIKE '8%' OR a.title LIKE '9%')";
					break;
				default:
					$wheres[] = " a.title LIKE '" . $letter . "%'";	
			}
			$orderby = "a.title ASC";
		}
		
		// published
		$wheres[] = " a.published = '1' AND a.approved = '1'";

		$query = "SELECT CONCAT_WS( '/', '" . JText::_( 'AC_WEBLINKS' ) . "', cc.title ) AS section, a.id, a.title, a.description as text, '' AS `fulltext`, a.`date` AS created, a.`date` AS modified, '' AS created_by," .
				" a.hits, '' AS images, '' AS metakey, '' AS metadesc, '' AS attribs, '0' AS featured, 'weblink' AS is_article," .
				" CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT(':', a.alias) ELSE '' END AS slug,".
				" a.catid as catslug,".
				" '' AS readmore,".
				" '' AS author,".
				" CONCAT('index.php?option=com_weblinks&view=weblink&catid=', a.catid, '&id=', a.id ) AS href,".
				" a.url AS reallink,".
				" '0' AS access," .
				$queryRating .
				" FROM #__weblinks AS a" .
				" LEFT JOIN #__categories AS cc ON a.catid = cc.id" .
				$queryRating2 .
				" WHERE " . implode( " AND ", $wheres ).
				" ORDER BY " . $orderby;			
		
		$total = @$this->_getListCount($query);
		$resultWL = $this->_getList($query, $limitstart, $limit);
		
		return array($resultWL, $total);
	}	
	
	// contacts
	function _getItemsCT( $category, $letter, $options, $params, $orderby, $limit='', $limitstart='' ) {
		global $mainframe;		
		
		$section     =  $options['section'];
		$category    =  $options['category'];
		$letter      =  $options['letter'];
		$search      =  $options['search'];
		$searchfield =  $options['searchfield'];		
		$limit       = ( $limit ) ? $limit : $options['limit'] ;
		$limitstart  = ( $limitstart ) ? $limitstart : $options['limitstart'] ;
	
		$_db	=& JFactory::getDBO();
		$user   = & JFactory::getUser();
		
		// If voting is turned on, get voting data as well for the content items
		$queryRating  = ( $params->get('systemrating') ) ? " ROUND(ar.total_value/ar.total_votes) AS rating, ar.total_votes AS rating_count" : " '' AS rating, '' AS rating_count";
		$queryRating2 = ( $params->get('systemrating') ) ? " LEFT JOIN #__alpha_rating AS ar ON a.id = ar.id AND ar.component='com_contact' AND ar.cid='0' AND ar.rid='0'" : "";
		
		// Building where
		// --------------
		if ( $category ) $wheres[] = " a.catid = '".$category."'";
		
		// specifics Categories in params menu
		if ( $params->get('categoryid') ) $wheres[] = " a.catid IN (" . $params->get('categoryid') . ")";
		
		if ( $search!='' ) {
			//$limit = 1000;
			//$limitstart = 0;
			// replace introtext by description
			if ( $searchfield=='a.title') $searchfield = "a.name";
			if ( $searchfield=='a.introtext' || $searchfield=='a.fulltext' || $searchfield=='a.metakey' ) $searchfield = "a.con_position";
			switch ( $searchfield ) {			
				case 'a.name':
				case 'a.con_position':
					$wheres[] = " ( LOWER( ".$searchfield." ) LIKE '%".$search."%')";		
					break;
				default:
					$wheres[] = " ( LOWER( a.name ) LIKE '%".$search."%' OR a.con_position LIKE '%".$search."%' )";	
					break;
			}		
		}
		
		if ( $letter ) {		
			switch ($letter) {
				case '#':
					$wheres[] = " (a.`name` LIKE '\_%' OR a.`name` LIKE '\#%' OR a.`name` LIKE '\-%' OR a.`name` LIKE '\$%' OR a.`name` LIKE '\@%'".
								"  OR a.`name` LIKE '\!%' OR a.`name` LIKE '\:%' OR a.`name` LIKE '\*%' OR a.`name` LIKE '\~%' OR a.`name` LIKE '\?%')";
					break;
				case '0-9':
					$wheres[] = " (a.`name` LIKE '0%' OR a.`name` LIKE '1%' OR a.`name` LIKE '2%' OR a.`name` LIKE '3%' OR a.`name` LIKE '4%'".
								"  OR a.`name` LIKE '5%' OR a.`name` LIKE '6%' OR a.`name` LIKE '7%' OR a.`name` LIKE '8%' OR a.`name` LIKE '9%')";
					break;
				default:
					$wheres[] = " a.`name` LIKE '" . $letter . "%'";	
			}
			$orderby = "a.`name` ASC";
		}
		
		// published
		$wheres[] = " a.published = '1'";		
		
		if ($user->aid !== null && !$params->get('noauth')) {
			$wheres[] = " a.access <= " . (int) $user->aid;
		}
		
		$query = "SELECT CONCAT_WS( '/', '" . JText::_( 'AC_CONTACTS' ) . "', cc.title ) AS section, a.id, a.`name` AS title," .
		
				//" CONCAT_WS('&lt;br /&gt;', a.con_position, a.address, a.suburb, a.state, a.country, a.postcode, a.telephone, a.email_to) AS text," . 
				
				//" CONCAT(a.address, '&lt;br /&gt;', a.suburb, ', ', a.state, ' ', a.postcode, '&lt;br /&gt;', a.country, '&lt;br /&gt;', a.telephone) AS text," . 
				
				" CONCAT(a.address, '&lt;br /&gt;', a.suburb, ', ', a.state, ' ', a.postcode, '&lt;br /&gt;', a.telephone) AS text," . 
				
				" '' AS `fulltext`, '' AS created, '' AS modified, '' AS created_by," .
				" '' AS hits, a.image AS images, '' AS metakey, '' AS metadesc, '' AS attribs, '0' AS featured, 'contact' AS is_article," .
				" CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT(':', a.alias) ELSE '' END AS slug,".
				" CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(':', cc.id, cc.alias) ELSE '' END as catslug,".
				" '1' AS readmore,".
				" a.email_to AS author,".
				" CONCAT('index.php?option=com_contact&view=contact&id=', a.id) AS href,".
				" a.webpage AS reallink,".
				" a.access," .
				$queryRating .
				" FROM #__contact_details AS a" .
				" LEFT JOIN #__categories AS cc ON a.catid = cc.id" .
				" LEFT JOIN #__groups AS g ON a.access = g.id".
				$queryRating2 .
				" WHERE " . implode( " AND ", $wheres ).
				" ORDER BY " . $orderby;
				
		$total = @$this->_getListCount($query);
		$resultCT = $this->_getList($query, $limitstart, $limit);
		return array($resultCT, $total);		
	}
		
	function _getFeaturedItems( $params ) {
		global $mainframe;
		
		$_db	=& JFactory::getDBO();
		$user = & JFactory::getUser();
		
		jimport('joomla.utilities.date');
		$jnow		= new JDate();
		$now		= $jnow->toMySQL();
		$nullDate	= $this->_db->getNullDate();

		// If voting is turned on, get voting data as well for the content items
		$queryRating  = ( $params->get('systemrating') ) ? " ROUND(ar.total_value/ar.total_votes) AS rating, ar.total_votes AS rating_count" : " ROUND(v.rating_sum/v.rating_count) AS rating, v.rating_count";
		$queryRating2 = ( $params->get('systemrating') ) ? " LEFT JOIN #__alpha_rating AS ar ON a.id = ar.id AND ar.component='com_content' AND ar.cid='0' AND ar.rid='0'" : " LEFT JOIN #__content_rating AS v ON a.id = v.content_id";
		
		// Building where
		// --------------
		$wheres[] = " a.id IN (" . $params->get('list_featuredID') . ")";
		
		// state
		if ( $params->get('archived')=='1' ){ 
			$state = " (a.state = '1' OR a.state = '-1')";
		} else {
			$state = " (a.state = '1')";	
		}				
		// published
		//if (!$user->authorize('com_content', 'edit', 'content', 'all'))	{
			$wherepublish  = ' ( ';
			$wherepublish .= ' ( a.created_by = ' . (int) $user->id . ' ) ';
			$wherepublish .= '   OR ';
			$wherepublish .= $state .
						' AND ( a.publish_up = '.$this->_db->Quote($nullDate).' OR a.publish_up <= '.$this->_db->Quote($now).' )' .
						' AND ( a.publish_down = '.$this->_db->Quote($nullDate).' OR a.publish_down >= '.$this->_db->Quote($now).' )';
			$wherepublish .= ' ) ';
			$wheres[] = $wherepublish;
		//}			 
		if ($user->aid !== null) {
			$wheres[] = " a.access <= " . (int) $user->aid;
		}

		$query = "SELECT CONCAT_WS( '/', s.title, cc.title ) AS section, a.id, a.title, a.introtext as text, a.fulltext, a.created, a.modified, a.created_by,".
			" a.hits, a.images, a.metakey, a.metadesc, a.attribs, '1' AS featured, '1' AS is_article," .
			" CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT(':', a.alias) ELSE '' END as slug,".
			" CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(':', cc.id, cc.alias) ELSE '' END as catslug,".
			" CHAR_LENGTH( a.`fulltext` ) AS readmore,".
			" CASE WHEN CHAR_LENGTH(a.created_by_alias) THEN a.created_by_alias ELSE u.name END as author,".
			" CONCAT('index.php?option=com_content&view=article&id=', a.id) AS href,".
			" CONCAT('index.php?option=com_content&view=article&id=', a.id) AS reallink,".
			" a.access," .
			$queryRating .
			" FROM #__content AS a" .
			" LEFT JOIN #__sections AS s ON a.sectionid = s.id" .
			" LEFT JOIN #__categories AS cc ON a.catid = cc.id" .
			" LEFT JOIN #__users AS u ON u.id = a.created_by" .
			" LEFT JOIN #__groups AS g ON a.access = g.id".
			$queryRating2 .
			" WHERE " . implode( " AND ", $wheres );
				
		$total = @$this->_getListCount($query);
		$result = $this->_getList($query);
		return array($result, $total);		
	}
	
	function _getOrdering( $orderingitems, $section ) {
	
		switch( $orderingitems ){
			case '1':
				$ordering = ( $section!='contacts' ) ? 'a.title ASC' : 'a.`name` ASC';				
				break;
			case '2':
				$ordering = ( $section!='contacts' ) ? 'a.title DESC' : 'a.`name` DESC';
				break;
			case '3':
				if ( $section=='weblinks' ) {				
					$ordering = 'a.`date` ASC';		
				}  elseif ( $section=='contacts' ){
					$ordering = 'a.`name` ASC';		
				} else $ordering = 'a.created ASC';				
				break;
			case '4':
				if ( $section=='weblinks' ) {				
					$ordering = 'a.`date` DESC';		
				}  elseif ( $section=='contacts' ){
					$ordering = 'a.`name` DESC';		
				} else $ordering = 'a.created DESC';
				break;
			case '5':
				if ( $section=='weblinks' ) {				
					$ordering = 'a.`date` ASC';		
				}  elseif ( $section=='contacts' ){
					$ordering = 'a.`name` ASC';		
				} else $ordering = 'a.modified ASC';				
				break;
			case '6':
				if ( $section=='weblinks' ) {				
					$ordering = 'a.`date` DESC';		
				}  elseif ( $section=='contacts' ){
					$ordering = 'a.`name` DESC';		
				} else $ordering = 'a.modified DESC';					
				break;
			case '7':
				$ordering = 'a.hits ASC';
				break;
			case '8':
				$ordering = 'a.hits DESC';	
				break;
			case '9':
				$ordering = 'rating ASC';
				break;
			case '10':
				$ordering = 'rating DESC';	
				break;
			case '11':
				if ( $section=='weblinks' ) {				
					$ordering = 'a.title ASC';		
				}  elseif ( $section=='contacts' ){
					$ordering = 'a.`name` ASC';		
				} else $ordering = 'CONCAT( a.created_by_alias, u.`name`) ASC';		
				break;
			case '12':
				if ( $section=='weblinks' ) {
					$ordering = 'a.title DESC';
				}  elseif ( $section=='contacts' ){
					$ordering = 'a.`name` DESC';		
				} else $ordering = 'CONCAT( a.created_by_alias, u.`name`) DESC';
				break;
			case '13':
				$ordering = 'featured DESC, a.title ASC';
				break;				
			default:
				if ( $section=='weblinks' || $section=='contacts' ) {
					$ordering = 'a.ordering ASC';
				} else $ordering = 'a.catid ASC, a.ordering ASC'; // default ordering				
		}
		return $ordering;
	}
	
	
	function _getRSS( $options, $params ) {
	
		$options['section']     = $options['s'];
		$options['category']    = $options['c'];
		$options['menuid']      = $options['m'];
		$options['limit']		= 20;
		$options['limitstart']	= 0;
		$options['letter']      = "";
		$options['search']      = "";
		$options['searchfield'] = "";
		$options['tag']         = "";
			
		if ( $options['section'] > 0 ) {
			$result = $this->_getItems( '', '', $options, $params, 'a.created DESC', 20, 0 );
		} elseif ( $options['section'] == '0' ) {
			$result = $this->_getItemsUN( '', '', $options, $params, 'a.created DESC', 20, 0 );
		}

		$rows = $result[0];
		
		return $rows;
	
	}
}
?>