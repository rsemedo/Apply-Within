<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );
jimport( 'joomla.html.pagination' );

/**
 * HTML View class for AlphaContent Component
 *
 * @package	AlphaContent
 */
class alphacontentViewalphacontent extends JView
{

	var $numsections=0;
	var $percent='50%';
	var $numcols=0;
	var $totallines=0;
	var $numcell=0;
	var $colspan=0;
	var $url_alphacontent='index.php?option=com_alphacontent';
	var $alphabeticalbar='';

	function _display($tpl = null) {		
		global $mainframe, $options;	
		
		$document	= & JFactory::getDocument();
				
		if ( $this->params->get('showalphabeticalbar') ) {
			$this->alphabeticalbar = $this->_getAlphabeticalBar( $this->alphabeticalbar, $this->params, $this->url_alphacontent );
		}		
		
		// vars for directory
		$this->numsections = count( $this->directory );
		$this->percent  = $this->_getWidthPercent( $this->params->get('numcols') );
		$this->numcols = $this->params->get('numcols');		
		$this->totallines = @intval($this->numsections/$this->numcols);
		if ( @($this->numsections%$this->numcols>0) ) $this->totallines ++ ;
		$this->numcell = intval( $this->totallines*$this->numcols );
		$this->colspan = intval( $this->numcell-$this->numsections );
		
		$this->assignRef( 'currentdirectorylevel', $this->currentselection );
		$this->assignRef( 'params',	$this->params );
		$this->assignRef( 'directory', $this->directory );
		$this->assignRef( 'numcols', $this->numcols );
		$this->assignRef( 'percent', $this->percent );
		$this->assignRef( 'colspan', $this->colspan );
		$this->assignRef( 'numsections', $this->numsections );
		
		if ( $this->params->get('separativecharcatgeneralepage')=='line_break_br' ) $this->params->set('separativecharcatgeneralepage', '<br />');
		if ( $this->params->get('separativecharcatgeneralepage')=='list_li' ) $this->params->set('separativecharcatgeneralepage', '<li>');
		if ( $this->params->get('separativecharcatsectionpage')=='line_break_br' ) $this->params->set('separativecharcatsectionpage', '<br />');
		if ( $this->params->get('separativecharcatsectionpage')=='list_li' ) $this->params->set('separativecharcatsectionpage', '<li>');

		$this->assignRef( 'url_alphacontent', $this->url_alphacontent );
		$this->assignRef( 'currentletter', $options['letter'] );
		$this->assignRef( 'alphabeticalbar', $this->alphabeticalbar );
		$this->assignRef( 'contentdescriptiondirectory', $this->contentdescriptiondirectory );
		$this->assignRef( 'categoriesbegenningby', $this->categoriesbegenningby );		
		
		$this->assignRef( 'listing', $this->listing );
		
		// Create a pathway for go back to the directory
		$alphaPathway = "";
		// Get the menu item object
		$menus = &JSite::getMenu();		
		$home  = $menus->getDefault();
		$menu  = $menus->getActive();
		
		if(is_object($menu) && ($menu->id != $home->id)) {		
			$menuname = $menu->name;
			$menuid = $menu->id;
		} else {
			$menuid = $home->id;		
			$menus->setActive($home->id);
			$menu  = $menus->getActive();
			$menuname = $menu->name;
			$menuid = $menu->id;
		}		
					
		$this->assignRef( 'menuid', $menuid );

		switch ( $this->currentselection ) {
			case 'section':
				$alphaPathway .= "<a href=\"" . JRoute::_($this->url_alphacontent."&amp;Itemid=".$menuid) . "\">" . $menuname . "</a> &raquo; " . $this->directory[0]->title;			
				
				$document->setTitle($this->directory[0]->title); // added in 4.0.7
				
				if ($this->directory[0]->description) {
					$document->setDescription( acPrepareAlphaContent( $this->directory[0]->description) );
				}				
				
				break;
			case 'category':
				if ( $options['section']=='contacts' ) {
					$sectionname = JText::_('AC_CONTACTS');				
				} elseif ( $options['section']=='weblinks' ) {
					$sectionname = JText::_('AC_WEBLINKS');
				} else {
					$sectionname = $this->directory[0]->title;					
				}
				$catname = $this->directory[0]->currentcat;
				$urlpathway = $this->url_alphacontent . "&amp;section=".$options['section']."&amp;Itemid=".$menuid;
				$alphaPathway .= "<a href=\"" . JRoute::_($this->url_alphacontent."&amp;Itemid=".$menuid) . "\">" . $menuname . "</a> &raquo; <a href=\"" . JRoute::_($urlpathway) . "\">" . $sectionname . "</a> &raquo; " . $catname ;		
				
				$document->setTitle( $catname ); // added in 4.0.7	
				
				if ($this->directory[0]->descriptioncat) {
					$document->setDescription( acPrepareAlphaContent( $this->directory[0]->descriptioncat ) );
				}				
				
				break;
		}
		$this->assignRef( 'alphaPathway', $alphaPathway );
		$this->assignRef( 'menuname', $menuname );
		
		// build search box
		$searchbox = "";
		
		$defaultsearch = ( $options['search']!='' ) ? $options['search'] : JText::_( 'AC_SEARCHONDIRECTORY' ) ;
			
		if ($this->params->get('list_showsearchbox')) {		
			$searchbox = "\n<input type=\"text\" name=\"search\" class=\"inputbox\" value=\"" . $defaultsearch . "\" onfocus=\"this.value='';\" />";
		}
		$this->assignRef( 'searchbox', $searchbox );
		if ($this->params->get('list_showsearchboxbutton')) {
			$searchboxbutton = "\n<input type=\"submit\" name=\"Submit\" class=\"button\" value=\"". JText::_( 'AC_SEARCHLABELBUTTON' ) . "\" />";
		}
		$this->assignRef( 'searchboxbutton', $searchboxbutton );
		// build lists
		$this->assignRef( 'lists', $this->_getOptionsLists( $options, $this->params, $this->url_alphacontent ) );
		
		$pagination = new JPagination( $options['total'], $options['limitstart'], $options['limit'] );
		
		$this->assignRef('pagination', $pagination );
		$this->assignRef('options', $options );
		
  		JHTML::_('behavior.mootools');
		$document->addScriptDeclaration("window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });");
		
		JPlugin::loadLanguage( 'com_content' );
		
		/*
		if ( $this->currentselection=='directory' ) {
			// prepare meta description and keywords for main directory
			if ($article->metadesc) {
				$document->setDescription( $article->metadesc );
			}
			if ($article->metakey) {
				$document->setMetadata('keywords', $article->metakey);
			}
		}		
		*/
		
		parent::display($tpl);
	}	
	
	function _getWidthPercent( $nbcolums ) {
	
		switch( $nbcolums ){				
			case "1":
				$percent = '100%';
				break;
			case "3":
				$percent = '33%';			
				break;
			case "4":
				$percent = '25%';			
				break;
			case "5":
				$percent = '20%';
				break;
			case "6":
				$percent = '16%';
				break;
			case "2":
			default:
				$percent = '50%';
		}
		return $percent;	
	}
	
	function _getAlphabeticalBar( $ar_bar, $params, $url ) {
		global $options;	
		
		// build alphabetical bar
		$alphabar = "";		
		
		$url .= $this->_getOptions ( $options );
		
		$linkletter = $url . "&amp;letter=";
		
		// specials chars
		if ( $options['letter']=='#' ) {		
			$alphabar .= "\r\n<b>#</b>\r\n";
		} else {
			$alphabar .= "\r\n<a href=\"".JRoute::_($linkletter.urlencode("#")) . "\" rel=\"nofollow\" title=\"#\">#</a>\r\n";
		}
		
		$alphabar .= stripslashes($params->get('seperatingchar'));
		
		// numbers
		if ( $options['letter']=='0-9' ) {		
			$alphabar .= "\r\n<b>0-9</b>\r\n";
		} else {
			$alphabar .= "\r\n<a href=\"".JRoute::_($linkletter."0-9") . "\" rel=\"nofollow\" title=\"0-9\">0-9</a>\r\n";
		}
		
		// letters
		$tagbr = 0;
		for($i=0;$i<sizeof($ar_bar);$i++) {			
			
			if ( $options['letter']==$ar_bar[$i] ) {
				$alphabar .= stripslashes($params->get('seperatingchar'));
				$alphabar .= "<b>" . $ar_bar[$i] . "</b>";
			} else {
				if ( $ar_bar[$i]!=strtolower('<br/>') && $ar_bar[$i]!=strtolower('<br />') ) {				
					if ( !$tagbr ) {
						$alphabar .= stripslashes($params->get('seperatingchar'));						
					} else $tagbr = 0;					
					$alphabar .= "<a href=\"" . JRoute::_($linkletter . $ar_bar[$i]) . "\" rel=\"nofollow\" title=\"" . $ar_bar[$i] . "\">" . $ar_bar[$i] . "</a>";
				} else {
					$alphabar .= "<br />";
					$tagbr = 1;
				}
			}			
			$alphabar .= "\r\n";
		}
		
		return $alphabar;
		
	}	
	
	function _getOptions ( $options ){
		
		$urlOptions = "";
		
		if ( $options['section']!='' )  $urlOptions .= "&amp;section="  . $options['section']  ;
		if ( $options['category']!='' ) $urlOptions .= "&amp;category=" . $options['category'] ;
		if ( $options['ordering']!='' )	$urlOptions .= "&amp;ordering=" . $options['ordering'] ;
		
		return $urlOptions;
	
	}
	
	function _getOptionsLists ( $request, $params, $link ){
		global $mainframe, $Itemid;
		
		$this->ac_Jimport( 'joomla.html.html.select');
		
		$lists = array();
		
		if ( $request['section']!='' )  $link .= "&amp;section="  . $request['section']  ;
		if ( $request['category']!='' ) $link .= "&amp;category=" . $request['category'] ;
	
		$thelimit = "&amp;limitstart=" . $request['limitstart'] . "&amp;limit=" . $request['limit'] . "&amp;Itemid=" . $Itemid;

		if ($params->get('list_showorderinglist')) {
			if ( $request['ordering']=='' ) $request['ordering'] = $params->get('list_defaultordering');			
			$options = array();
			$options[] = JHTMLSelect::Option( '',  JText::_( 'AC_ORDERING_BY' ) );					
			$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=1'.$thelimit),  JText::_( 'AC_TITLEAZ' ) );
			$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=2'.$thelimit),  JText::_( 'AC_TITLEZA' ) );			
			if ( $request['section']!='weblinks' && $request['section']!='contacts' ) {			
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=3'.$thelimit),  JText::_( 'AC_DATECREATEDASC' ) );				
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=4'.$thelimit),  JText::_( 'AC_DATECREATEDDESC' ) );				
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=5'.$thelimit),  JText::_( 'AC_DATEMODIFIEDASC' ) );				
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=6'.$thelimit),  JText::_( 'AC_DATEMODIFIEDDESC' ) );			
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=7'.$thelimit),  JText::_( 'AC_HITSASC' ) );				
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=8'.$thelimit),  JText::_( 'AC_HITSDESC' ) );				
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=9'.$thelimit),  JText::_( 'AC_RATINGASC' ) );				
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=10'.$thelimit), JText::_( 'AC_RATINGDESC' ) );				
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=11'.$thelimit), JText::_( 'AC_AUTHORASC' ) );				
				$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=12'.$thelimit), JText::_( 'AC_AUTHORDESC' ) );				
			}
			$options[] = JHTMLSelect::Option( JRoute::_($link.'&amp;ordering=13'.$thelimit),  JText::_( 'AC_DEFAULTORDERING' ) );
			$lists['list_defaultordering'] = JHTMLSelect::genericlist( $options, 'ordering', 'class="inputbox" size="1" onchange="jumpmenu(\'parent\',this,1)"' ,'value', 'text', $request['ordering'] );
		}

		// create list field search	
		if ($params->get('list_showsearchbox')) {		
			$options = array();
			$options[] = JHTMLSelect::Option( 'a.title',  JText::_( 'AC_TITLE_ONLY' ) );
			$options[] = JHTMLSelect::Option( 'a.introtext',  JText::_( 'AC_INTRO_ONLY' ) );
			$options[] = JHTMLSelect::Option( '',  JText::_( 'AC_TITLE_AND_INTRO' ) );
			
			$options[] = JHTMLSelect::Option( 'a.fulltext',  JText::_( 'AC_CONTENT' ) );
			$options[] = JHTMLSelect::Option( 'a.metakey',  JText::_( 'AC_KEYWORDS' ) );

			$lists['list_searchfield'] = JHTMLSelect::genericlist( $options, 'searchfield', 'class="inputbox" size="1"', 'value', 'text', $request['searchfield'] );
		}

		return $lists;
	}
	
	function ac_Jimport ( $lib_path ) {
		$path  = JPATH_ROOT . DS . 'libraries' . DS . str_replace( '.', DS, $lib_path ) . '.php';
		include_once ( $path );
	}
	
	
	function _viewmap( &$params ) {
	
		$latitude   = trim( JRequest::getVar ( 'la', '', 'GET', 'string'	) );
		$longitude  = trim( JRequest::getVar ( 'lo', '', 'GET', 'string'	) );
		$messag     = trim( JRequest::getVar ( 'txt', '', 'GET', 'string'	) );
		$marker_lat = $latitude;
		$marker_lon = $longitude;
		
		if ( $params->get('showmaptypemenu', '1') ) {
			$showmaptypemenu = 'true';		
		} else $showmaptypemenu = 'false';
		
		if ( $params->get('showmapcontrolsmenu', '1') ) {
			$showmapcontrolsmenu = 'true';		
		} else $showmapcontrolsmenu = 'false';
		
		
		
		?>
		<iframe src="components/com_alphacontent/assets/includes/alphacontent.google_map.php?google_map_key=<?php echo $params->get('apikeygooglemap'); ?>&
			latitude=<?php echo $latitude; ?>&
			longitude=<?php echo $longitude; ?>&
			zoom=<?php echo $params->get('zoomlevel'); ?>&
			marker_lat=<?php echo $marker_lat; ?>&
			marker_lon=<?php echo $marker_lon; ?>&
			menu_map=<?php echo $showmaptypemenu; ?>&
			control_map=<?php echo $showmapcontrolsmenu; ?>&
			messag=<?php echo $messag; ?>&
			map_width=<?php echo $params->get('widthgooglemap'); ?>&
			map_height=<?php echo $params->get('heightgooglemap'); ?>"
			
			scrolling="no" style="width: <?php echo $params->get('widthgooglemap'); ?>px; height: <?php echo $params->get('heightgooglemap'); ?>px;" border="0px" marginwidth="0px" marginheight="0px">
		</iframe>
		<?php
	}
	
	function _showrss() {
		global $mainframe;
	
		// Load feed creator class
		require_once (JPATH_SITE.DS.'includes'.DS.'feedcreator.class.php' );			

		$rssfile = $mainframe->getCfg('tmp_path') . '/rss.xml';
		
		$rss = new UniversalFeedCreator(); 
		$rss->title = $mainframe->getCfg('sitename');
		$rss->description = $mainframe->getCfg('MetaDesc');
		$rss->link = JURI::base();
		$rss->syndicationURL = JURI::base();
		$rss->cssStyleSheet = NULL;
		$rss->descriptionHtmlSyndicated = true;
		
		$rows = $this->rows;
		
		if ( $rows ) {
			foreach ( $rows as $row ) {			
				$item = new FeedItem(); 
				$sluggy = $row->slug;
				if ( $row->catslug && $sluggy!='' ) $sluggy .= "&catid=" . $row->catslug;
				$sluggy .= "&directory=" . $this->menuid;
				$item->title = JHTML::_( 'date', $row->created, JText::_('DATE_FORMAT_LC2') ) . "  -  " . stripslashes($row->title);					
				$item->link = JURI::base() . "/" . $row->href . $sluggy;
				$item->description = ( $row->text!='' ) ? $row->text : $row->fulltext ;	
				$item->descriptionTruncSize = 250;
				$item->descriptionHtmlSyndicated = true;
				@$date = ( $row->created ? date( 'r', strtotime($row->created) ) : '' );
				$item->date = $date;
				$item->source = JURI::base();
				$rss->addItem( $item );
			}
		}	
		// save feed file
		$rss->saveFeed('RSS2.0', $rssfile);
	}
	
	function _showreport($tpl = null) {
		global $mainframe;
		
		$this->assignRef( 'type', $this->type );
		$this->assignRef( 'id', $this->id );
		$this->assignRef( 'list_email_administrator', $this->list_email_administrator );
		
		parent::display( "report" );
	}
	
}
?>