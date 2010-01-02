<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

 // no direct access
defined('_JEXEC') or die('Restricted access');

global $options;

// add style sheet
$document	= & JFactory::getDocument();
$document->addStyleSheet(JURI::base(true).'/components/com_alphacontent/assets/css/alphacontent.css');
if ( $this->params->get('weblinksthumbnail') ) {
	$document->addStyleDeclaration( ".arc90_linkpic { display: none; position: absolute; left: 0; top: 1.5em; } .arc90_linkpicIMG { padding: 0 4px 4px 0; background: #FFF url(" . JURI::base() . "/components/com_alphacontent/assets/images/linkpic_shadow.gif) no-repeat bottom right; }", "text/css" );
}
// var lang
$lang = $document->getLanguage();

// start template
if ( $this->params->def( 'show_page_title', 1 ) ) {
?>
<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
	<?php
	$page_title = ($this->params->get('page_title'))? $this->escape($this->params->get('page_title')) : $this->escape($this->menuname) ;
	echo $page_title;
	?>
</div>
<?php 
}
echo "<div id=\"alphacontent\">";

if ( $this->params->get('showalphabeticalbar')  ) {
?>
	<div id="alphabeticalbar"><div align="center"><p><?php echo $this->alphabeticalbar ?></p></div></div>
<?php
}

if ( $this->alphaPathway ) {
?>
	<div id="alphapathway">
		<p>
		<?php
		echo $this->alphaPathway;
		?>
		</p>
	</div>
<?php
}

if ( $this->contentdescriptiondirectory && $this->params->get('positiondescription')=='0' && @$this->currentdirectorylevel=='directory' ) {
?>
	<div id="descriptiondirectory">
		<p>
		<?php
		echo JHTML::_('content.prepare', $this->contentdescriptiondirectory );
		?>
		</p>
	</div>
<?php
}

// show directory level
$url = $this->url_alphacontent;

switch ( @$this->currentdirectorylevel ) {

	case 'directory':
		if ( $this->params->get('showdirectory')  ) {
			$n = $this->numsections;
			$p = $this->percent;
			$directory = $this->directory;
			$c = $this->numcols;
			$cs = $this->colspan;
			show_directory( $n, $p, $c, $cs, $url, $directory, $this->params, $this->menuid );
		}		
		break;
	
	case 'section':
		show_section( $url, $this->directory, $this->params, $this->menuid );
		break;
	
	case 'category':
		show_category( $url, $this->directory, $this->params, $this->menuid, $this->pagination );
		break;
}

if ( $this->contentdescriptiondirectory && $this->params->get('positiondescription')=='1' && @$this->currentdirectorylevel=='directory' ) {
?>
	<div id="descriptiondirectory">
		<p>
		<?php
		echo JHTML::_('content.prepare', $this->contentdescriptiondirectory );
		?>
		</p>
	</div>
<?php
}
// if you don't want the search box on main directory, just uncomment the code below and comment the following code...
/*
if ( (count($this->listing) && @$this->listing[0]->id!='') || $this->categoriesbegenningby!='' ) {
	show_listing( $this->listing, $url, $this->params, $this->searchbox, $this->searchboxbutton, $this->lists, $this->pagination, $this->options, $lang, $this->menuid, $this->categoriesbegenningby );
	getACCopyrightNotice();
} else {
	$noresult = ( @$this->currentdirectorylevel!='directory' ) ? "<br />" . JTEXT::_('AC_NO_RESULT') : "";	
	echo $noresult;
	getACCopyrightNotice();
}
*/
// --------------------------------------------------------------------------------------------------
show_listing( $this->listing, $url, $this->params, $this->searchbox, $this->searchboxbutton, $this->lists, $this->pagination, $this->options, $lang, $this->menuid, $this->categoriesbegenningby );
if ( count($this->listing)==0 ) {
	$noresult = ( @$this->currentdirectorylevel!='directory' || @$this->currentdirectorylevel=='directory' && $options['search']!='' ) ? "<br />" . JTEXT::_('AC_NO_RESULT') : "";	
	echo $noresult;
}
getACCopyrightNotice();
// --------------------------------------------------------------------------------------------------

if ( $this->contentdescriptiondirectory && $this->params->get('positiondescription')=='2' && @$this->currentdirectorylevel=='directory' ) {
?>
	<div id="descriptiondirectory">
		<p>
		<?php
		echo JHTML::_('content.prepare', $this->contentdescriptiondirectory );
		?>
		</p>
	</div>
<?php
}	


function show_directory( $n, $p, $c, $cs, $url, $directory, $params, $menuid ){
$countersection = "";
?>
<div id="alphadirectory">
<table width="100%"  border="0" cellspacing="5" cellpadding="0" align="center">
<?php
$g=0;
$endlineok = 0;
	for ( $i=0; $i < $n; $i++ ){
	
		if ( $directory[$i]->id!='' ) {
		
			$linksection = $url . "&amp;section=".$directory[$i]->id."&amp;Itemid=".$menuid;
			
			if ( $directory[$i]->id=='0' ) {
			 	$info = JText::_('AC_THISSECTIONCONTAINSXENTRIES');
				$thesection = "<span class=\"editlinktip hasTip\" title=\"".  JText::_( $directory[$i]->title ) . "::" . sprintf( $info, $directory[$i]->nitems  ) . "\">";
			} else {
				$info = JText::_('AC_THISSECTIONCONTAINSXCATEGORIESXENTRIES');
				$thesection = "<span class=\"editlinktip hasTip\" title=\"".  JText::_( $directory[$i]->title ) . "::" . sprintf( $info, $directory[$i]->ncat, $directory[$i]->nitems  ) . "\">";
			}			
			
			$thesection .="<a href=\"".JRoute::_($linksection) . "\">";
			
			// Show image section
			if ( $params->get('showimagesection') ) {
				$thesection .= insertImageDirectory( $directory[$i]->image, $directory[$i]->title, $params->get('widthimagesectioncat') );		
			}
			
			$thesection .= JTEXT::_( $directory[$i]->title );	
			$thesection .= "</a></span> ";
		
			if ( $params->get('showsumcategoriesitems' ) ) {
				$countersection = "<span class=\"ac_counter_directory\">(" . $directory[$i]->ncat . "/" . $directory[$i]->nitems . ")</span>";
			}
		
			if ($g%$c == 0) {
				echo "<tr>\n";
				$g = 0;
			}
			
			echo "<td width=100%>\n"
				 . $thesection . "</span>"
				 . $countersection
				 . "<p class=\"ac_categories_directory\">" . getCategories( $directory[$i]->ncat, $directory[$i]->subcats, $directory[$i]->id, $url, $params, 1, $params->get('separativecharcatgeneralepage'), $menuid ) . "</p>"
				 . "</td>\n";
		}
	}
?> 
</table>
</div>
<?php
}

function show_section( $url, $directory, $params, $menuid ) {
?>
<div id="alphasection">
<?php
	$thesection = JTEXT::_( $directory[0]->title );
	
	$info = ( $directory[0]->id !='0' ) ? JText::_('AC_THISSECTIONCONTAINSXCATEGORIESXENTRIES') : JText::_('AC_THISSECTIONCONTAINSXENTRIES') ;
	$infos = ( $directory[0]->id !='0' ) ? sprintf( $info, $directory[0]->ncat, $directory[0]->nitems  ) : sprintf( $info, $directory[0]->nitems  ) ; 
		
	$countersection = "";
	$imageS = "";
	// Show image section
	if ( $params->get('showimagesection') ) {
		$imageS = insertImageDirectory( $directory[0]->image, $directory[0]->title, $params->get('widthimagesectioncat') );			
	}
	
	$thesection = "<span class=\"editlinktip hasTip\" title=\"" .  $thesection  . "::" . $infos . "\">" . $imageS . $thesection;	
	
	if ( $params->get('showsumcategoriesitems' ) ) {
		$countersection = "<span class=\"ac_counter_directory\">(" . $directory[0]->nitems . ")</span>";
	}
	
	$block_section = "";
	
	$block_section .= "<span class=\"ac_title_section_directory\">"			
		 . $thesection . "</span></span> "
		 . $countersection;
	
	if ( $params->get('showsectiondescription' )) {
		$block_section .= "<p class=\"ac_section_description\">" . JHTML::_('content.prepare', $directory[0]->description) . "</p>";
	} 
		
	$block_section .= "<p class=\"ac_categories_directory\">" . getCategories( $directory[0]->ncat, $directory[0]->subcats, $directory[0]->id, $url, $params, 0, $params->get('separativecharcatsectionpage'), $menuid ) . "</p>";
	
	echo $block_section;
	 
	if ( $directory[0]->id!='weblinks' && $directory[0]->id!='contacts' && $params->get('showrss') ) echo showRSSicon( $params, $directory[0]->id, '', $menuid );
	
	echo showShareThis( $params );	
?>
</div>
<?php
}

function show_category( $url, $directory, $params, $menuid, $pagination ) {
?>
<div id="alphacategory">
<?php
	$thecategory = JTEXT::_( $directory[0]->currentcat );	
	// Show image category
	if ( $params->get('showimagecategory') ) {
		$thecategory .= insertImageDirectory( $directory[0]->imagecat, $directory[0]->currentcat, $params->get('widthimagesectioncat') );		
	}
	$countercategory = "";
	
	echo "<span class=\"ac_title_section_directory\">" . $thecategory . "</span> ";	
	
	if ( $params->get('showsumcategoriesitems' ) ) {
		$countercategory = "<span class=\"ac_counter_directory\"> (" . $pagination->total . ")</span>";
		echo $countercategory;
	}
	
	if ( $params->get('showcategorydescription' ) ) {
		echo "<p class=\"ac_category_description\">" . JHTML::_('content.prepare', $directory[0]->descriptioncat) . "</p>";
	}
	 
	if ( $directory[0]->id!='weblinks' && $directory[0]->id!='contacts' && $params->get('showrss') ) echo showRSSicon( $params, $directory[0]->id, $directory[0]->catid, $menuid );
	
	echo showShareThis( $params );
	
?>
</div>
<?php
}

function show_listing( $listing, $url, $params, $searchbox, $searchboxbutton, $lists, $pagination, $options, $lang, $menuid, $categoriesbegenningby ) {
	global $mainframe;
	
	$document	= & JFactory::getDocument();
	
	$user   = & JFactory::getUser();

	// show search bar
	if ( $searchbox ) {
	
	$jumpmenulist = "		<!--
		function jumpmenu(target,obj,restore){
		  eval(target+\".location='\"+obj.options[obj.selectedIndex].value+\"'\");		
		  if (restore) obj.selectedIndex=0;		
		}		
		//-->";
	?>
	<?php $document->addScriptDeclaration( $jumpmenulist ); ?>			
		<div id="searchbar">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
				<form name="adminFormSearchAC" action="" method="post">
				<?php echo $searchbox ?> <?php echo $lists['list_searchfield'] ?> <?php echo $searchboxbutton ?>
				</form>			
				</td>
				<td><div class="orderinglist">
				<?php 
				if ( count($listing) && @$listing[0]->id!='' && $options['letter']=='' ) echo $lists['list_defaultordering'] ;
				?>
				</div></td>
			</tr>
		</table>
		</div>
		
	<?php
	}
	
	// If result search letter -> show result categories beginning with this letter
	if ( $categoriesbegenningby ) {
	
		echo "<div id=\"alphapcategoriesbegenningby\"><span class=\"bigletter\">".$options['letter']."</span><span class=\"allcategoriesbeginningby\">" . $categoriesbegenningby . "</span></div>";	
	}
	
	
	if ( count($listing) > $pagination->limit ) {
		$newlimit = count($listing) ;

		$pagination = new JPagination( $options['total'], $newlimit, $pagination->limitstart );

	}
	
	// show Pages Counter
	if ( $params->get('list_shownumberpagetotal') && ( count($listing) && @$listing[0]->id!='' ) ) {
		if ( !($options['section']=='' && ( $options['letter']!='' || $options['search']!='' ) && ( $params->get('weblinkssection') || $params->get('contactsection')) ) ) {
			echo "<div id=\"alphapagecounter\"><p>";
			echo $pagination->getResultsCounter();		
			echo "</p></div>";
		}
	}	

	$ac_alignimage = $params->get('list_imageposition');
	$ac_numcolumnslisting = $params->get('list_numcols');
	$ac_k = (($ac_alignimage == '2') ? 0 : 'none' ); // for alternate image left-right
	
	$line=0; // just using for 2 columns	

	for ( $i=0; $i < count($listing); $i++ ){
	//for ( $i=0; $i < $new_pagination ; $i++ ){
			
		// prepare each listing
		if ( @$listing[$i]->id!='' ) {		
		
			// define all vars for listing template
			$id_article=$listing[$i]->id; // id of item article
			$num = ( $params->get('list_numindex') ) ? $i+1+$options['limitstart'] : ''; //num listing
			$title = ""; // title of item
			$featured = ""; // show "Featured" article on homepage of AlphaContent if this option is selected
			$icon_new=""; // icon new
			$icon_hot=""; // icon hot
			$section_category = ""; // section / category
			$author=""; // author or alias author if defined in item
			$content=""; // content intro
			$date=""; // date created
			$hits=""; // num hits
			$comments=""; // num of comments
			$rating=""; // rating bar (native Joomla)
			$print=""; // link to print
			$pdf=""; // link to pdf
			$emailthis=""; // link to email this
			$report=""; // link to report this listing
			$readmore=""; // readmore link if exist
			$ratingbar=""; // ajax rating bar integrated in AlphaContent
			$googlemaps=""; // link to Google Maps Location
			$tags=""; // tags / keywords
			$link_to_article = $listing[$i]->reallink; // real link to article or contact or weblink
			
			/*		
			*
			* Notes *
			---------
			$rating is disabled if you use ajax rating bar integrated in AlphaContent ($ratingbar)		
			*
			*/
			$url_article = $listing[$i]->slug;
			if ( $listing[$i]->catslug && $url_article!='' ) $url_article .= "&amp;catid=" . $listing[$i]->catslug;
			$url_article .= "&amp;directory=" . $menuid;
			$start_url_article = "<a href=\"". JRoute::_( $listing[$i]->href.$url_article ) ."\">";
			$end_url_article = "</a>";
			
			// get Title article/contact/weblink
			if ( $params->get('list_titlelinkable') ) {
				$title = $start_url_article . $listing[$i]->title . $end_url_article;
				if ( $listing[$i]->is_article=='weblink' ) {
					$title = "<a href=\"" . $listing[$i]->href . "\" target=\"_blank\">" . $listing[$i]->title . "</a>";
				}				
			} else {			
				$title = $listing[$i]->title;
			}
			
			// Featured
			if ( $listing[$i]->is_article ) {
				$featuredID = @explode( ',', $params->get('list_featuredID') );
				$featured = ( $listing[$i]->featured || @in_array( $listing[$i]->id, $featuredID ) ) ? JText::_( 'AC_FEATURED') : '' ;				
			}
			
			// get icon new and hot
			$typedatearticle = ( $params->get('list_showdate') ) ? $params->get('list_showdate') : 'created' ;
			if ( $params->get('list_iconnew') ) $icon_new = showIconNew( $listing[$i]->$typedatearticle, $params->get('list_numdaynew'), $lang );
			if ( $params->get('list_iconhot') ) $icon_hot = showIconHot( $listing[$i]->hits, $params->get('list_numhitshot'), $lang );
			if ( $params->get('list_showsectioncategory') ) $section_category = $listing[$i]->section;			
			
			// get Section/Category
			$section_category = ( $params->get('list_showsectioncategory') ) ? $listing[$i]->section : '';
			
			// get Author
			$author = ( $params->get('list_showauthor') ) ? $listing[$i]->author : '';
			
			// get Ajax rating bar for AlphaContent
			if ( $params->get('showsystemrating') && $params->get('activeglobalsystemrating') && $params->get('systemrating')) {
				switch ( $options['section'] ) {
					case 'weblinks':
						$component4rating = 'com_weblinks';
						break;
					case 'contacts':
						$component4rating = 'com_contact';
						break;
					default:
						$component4rating = 'com_content';
						
				}
				
				$document = & JFactory::getDocument();
				$document->addScript(JURI::base(true).'/components/com_alphacontent/assets/js/behavior.js');
				$document->addScript(JURI::base(true).'/components/com_alphacontent/assets/js/rating.js'); 				
				$document->addStyleSheet(JURI::base(true).'/components/com_alphacontent/assets/css/rating.css');
				require_once (JPATH_COMPONENT.DS.'assets'.DS.'includes'.DS.'alphacontent.drawrating.php' );
				$ratingbar = rating_bar( $listing[$i]->id, $params->get('numstars'), $component4rating, $params->get('widthstars', 16), '', '', 0, 0, $params->get('showinfosrating') );
				// usage rating_bar( id article, num stars, component, width stars, default=16 ), static, model (example for module), comment id, review id, show or hide sum*rating/num stars (num votes) );
			}
			
			// get Joomla native rating bar
			if ( $params->get('showsystemrating') && $params->get('systemrating')=='0' && $listing[$i]->rating_count!='' ) {	
				// look for images in template if available
				$img = "";
				$starImageOn 	= JHTML::_( 'image.site',  'rating_star.png', '/images/M_images/' );
				$starImageOff 	= JHTML::_( 'image.site',  'rating_star_blank.png', '/images/M_images/' );	
				for ($rb=0; $rb < $listing[$i]->rating; $rb++) {
					$img .= $starImageOn;
				}
				for ($rb=$listing[$i]->rating; $rb < 5; $rb++) {
					$img .= $starImageOff;
				}
				$rating  = '<span class="content_rating">';
				$rating .= JText::_( 'User Rating' ) . ':' . $img .'&nbsp;/&nbsp;';
				$rating .= intval( $listing[$i]->rating_count );
				$rating .= "</span>";
			}
			
			// Location Google Maps link								
			//if ( $params->get('list_showlinkmap') && $params->get('apikeygooglemap') ) {
			if ( $params->get('list_showlinkmap') ) {
				$mapIsDefined = 0;								
				if ( preg_match('#{ALPHAGMAP=(.*)}#Uis', $listing[$i]->text, $m) ) {
					$listing[$i]->text = preg_replace( "#{ALPHAGMAP=(.*)}#Uis", "", $listing[$i]->text );
					$mapIsDefined = 1;
				} elseif ( preg_match('#{ALPHAGMAP=(.*)}#Uis', $listing[$i]->fulltext, $m) ) {
					$listing[$i]->fulltext = preg_replace( "#{ALPHAGMAP=(.*)}#Uis", "", $listing[$i]->fulltext );
					$mapIsDefined = 1;
				}
				$a = array();
				if ( $mapIsDefined ) {
					$a = explode("|", $m[1]);
					if ( count($a)==3 ) {
						$thewidthmap  = $params->get('widthgooglemap') + 20;
						$theheightmap = $params->get('heightgooglemap') + 20;
						$status       = "status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=no,width=".$thewidthmap.",height=".$theheightmap.",directories=no,location=no";
						$googlemaps   = "<a href=\"javascript:void window.open('index2.php?option=com_alphacontent&amp;task=viewmap&amp;la=".$a[0]."&amp;lo=".$a[1]."&amp;txt=".$a[2]."', 'win2', '$status');\">" . JTEXT::_('AC_MAP') . "</a>";						
					}
				}								
			}
			$listing[$i]->text = preg_replace( '#{ALPHAGMAP=(.*)}#Uis', '', $listing[$i]->text );
			
			// prepare content
			$cuttext = 0;			

			switch ( $params->get('list_introstyle') ) {
				case '1':
					// text only
					$numcharsintro = ( $params->get('list_numcharsintro') ) ? $params->get('list_numcharsintro') : '999999';
					$cuttext = ( strlen($listing[$i]->text) > $numcharsintro ) ? 1 : 0;
					$content = acPrepareAlphaContent( $listing[$i]->text, $numcharsintro, '' );
					break;
				case '2':
					// Original intro with plugins
					//if ( $listing[$i]->attribs!='' ) {
						// Process the prepare content plugins
						JPluginHelper::importPlugin('content');
						$dispatcher	=& JDispatcher::getInstance();
						$tparams =& $mainframe->getParams('com_content');										
						// Merge article parameters into the page configuration						
						$aparams = new JParameter( $listing[$i]->attribs );
						$tparams->merge($aparams);
						
						//$results = @$dispatcher->trigger('onPrepareContent', array (& $listing[$i]->text, & $tparams, 0));
						$results = @$dispatcher->trigger('onPrepareContent', array (& $listing[$i], & $tparams, 0));
						$content = $listing[$i]->text;						
					//}
					break;
				case '3':
					// Metadesc
					$numcharsintro = ( $params->get('list_numcharsintro') ) ? $params->get('list_numcharsintro') : '999999';
					$content = ( $listing[$i]->metadesc ) ? $listing[$i]->metadesc : acPrepareAlphaContent( $listing[$i]->text, $numcharsintro, '' );					
					break;
			}			
			
			if ( $listing[$i]->created ) {
				if ( $params->get('list_showdate')=='created' ) {
					$date = JHTML::_( 'date', $listing[$i]->created, JText::_($params->get('list_formatdate')) );
				} elseif ( $params->get('list_showdate')=='modified' ) { 
					$date = JHTML::_( 'date', $listing[$i]->modified, JText::_($params->get('list_formatdate')) );
				}
			}
			
			$hits = ( $params->get('list_showhits') ) ? intval($listing[$i]->hits) : '' ;
			
			// get number of comments
			if ( $params->get('list_shownumcomments') && $params->get('list_commentsystem') && $listing[$i]->is_article=='1' ) {				
				$comments = getNumberComments( $params->get('list_commentsystem'), $listing[$i]->id );
			}
			
			// PDF link
			if ( $listing[$i]->is_article=='1' && $params->get('list_showpdf') ) {						
				$url  = 'index.php?view=article';
				$url .=  @$listing[$i]->catslug ? '&catid='.$listing[$i]->catslug : '';
				$url .= '&id=' . $listing[$i]->id . $listing[$i]->slug . '&format=pdf&option=com_content';		
				$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';		
				$text = JText::_('PDF');		
				$attribs['title']	= JText::_( 'PDF' );
				$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
				$attribs['rel']     = 'nofollow';		
				$pdf = JHTML::_('link', JRoute::_($url), $text, $attribs);
			}			
			// Print link
			if ( $listing[$i]->is_article=='1' && $params->get('list_showprint') ) {
				$url  = 'index.php?view=article';
				$url .=  @$listing[$i]->catslug ? '&catid='.$listing[$i]->catslug : '';
				$url .= '&id=' . $listing[$i]->id . $listing[$i]->slug . '&tmpl=component&print=1&option=com_content';		
				$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';		
				$text = JText::_( 'Print' );		
				$attribs['title']	= JText::_( 'Print' );
				$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";		
				$print = JHTML::_('link', JRoute::_($url), $text, $attribs);			
			}
			// Email link
			if ( $listing[$i]->is_article=='1' && $params->get('list_showemail') ) {
				$uri     =& JURI::getInstance();
				$base   = $uri->toString( array('scheme', 'host', 'port'));
				$link   = $base.JRoute::_( "index.php?view=article&id=" . $listing[$i]->id . $listing[$i]->slug, false );
				$url	= 'index.php?option=com_mailto&tmpl=component&link=' . base64_encode( $link );		
				$status = 'width=400,height=300,menubar=yes,resizable=yes';		
				$text = '&nbsp;'.JText::_('Email');
				$attribs['title'] = JText::_( 'Email' );
				$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
				$emailthis = JHTML::_('link', JRoute::_($url), $text, $attribs);
			}			
			
			// report this listing link
			if ( $params->get('list_showreportlisting') ) {
				$url  = 'index.php?option=com_alphacontent&task=report';
				//switch ( $options['section'] ) {
				switch ( $listing[$i]->is_article ) {
					case 'weblink':
						$report_type = 'com_weblinks';
						break;
					case 'contact':
						$report_type = 'com_contact';
						break;
					default:
						$report_type = 'com_content';
						
				}
				$url  .= '&type='.$report_type.'&id='.$id_article.'&tmpl=component';
				$status = 'width=400,height=300,menubar=yes,resizable=yes';		
				$text = JText::_('AC_REPORT');
				$attribsr['title'] = JText::_( 'AC_REPORT_THIS_LISTING' );
				$attribsr['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";		
				$report = JHTML::_('link', JRoute::_($url), $text, $attribsr);
			}			
			
			// readmore link
			if ( ( $listing[$i]->readmore || $cuttext ) && $params->get('list_showreadmore') ) {
				$sluggy = $listing[$i]->slug;
				if ( $listing[$i]->catslug && $sluggy!='' ) $sluggy .= "&amp;catid=" . $listing[$i]->catslug;
				$sluggy .= "&amp;directory=" . $menuid;	
				$readmore = "<a href=\"". JRoute::_( $listing[$i]->href.$sluggy ) ."\">" . JText::_( 'Readmore' ) . "</a>";
				if ( $listing[$i]->access > $user->aid ) $readmore = "<a href=\"". JRoute::_( $listing[$i]->href.$sluggy ) ."\">" . JText::_("REGISTER TO READ MORE...") . "</a>";
				
			}
			
			// prepare image
			$linkimgsrc = "";
			if ( $params->get('list_showimage') ) {
				if ( $listing[$i]->is_article=='1' ) {
					$linkIMG = findIMG( $listing[$i]->text, $params->get('list_showimage') );				
					if( $linkIMG == "") { 
						$linkIMG = findIMG( $listing[$i]->fulltext, $params->get('list_showimage') );
					}
					$linkimgsrc = ( $linkIMG ) ? $start_url_article . "<img src=\"" . $linkIMG . "\" width=\"" . $params->get('list_widthimage') . "px\" alt=\"\" />" . $end_url_article :  "";
					
				} elseif ( $listing[$i]->is_article=='contact' && $listing[$i]->images ) {
					$linkimgsrc = $start_url_article . "<img src=\"images/stories/" . $listing[$i]->images . "\" width=\"" . $params->get('list_widthimage') . "px\" alt=\"\" />" . $end_url_article;

				} elseif ( $listing[$i]->is_article=='weblink' && $params->get( 'weblinksthumbnail' ) == '1' ) {
					$forcewidth = "width=\"" . $params->get('list_widthimage') . "px\"";					
					if ( $params->get('list_keywebsnapr') && $params->get('list_sizewebsnapr', 'AC')!='AC') {						
						$sizewebsnapr = "size=".$params->get('list_sizewebsnapr');
						$sizewebsnapr .= "&key=".$params->get('list_keywebsnapr');
						$forcewidth = "";
					} else $sizewebsnapr = "size=s";					
					
					$linkimgsrc = "<a href=\"" . $listing[$i]->href . "\" target=\"_blank\">"
							 . "<img src=\"http://images.websnapr.com/?".$sizewebsnapr."&url=" . $listing[$i]->reallink . "\" alt=\"" . $listing[$i]->reallink . "\" $forcewidth />"
							 . "</a>";
				}
			}
			
			if ( $listing[$i]->is_article=='weblink' ) {
				// prepare link for weblink
				$content = "<a href=\"" . $listing[$i]->href . "\" target=\"_blank\">" . $listing[$i]->reallink . "</a><br />" . $content;
			}
			
			if ( $listing[$i]->is_article=='contact' && $listing[$i]->author!='' ) {
				// prepare link for email contact
				$content .= "<br /><a href=\"mailto:" . $listing[$i]->author . "\">" . $listing[$i]->author . "</a>";
				$author = "";
			}
			
			if ( $listing[$i]->is_article=='contact' && $listing[$i]->reallink!='' ) {
				// prepare link for webpage url
				$content .= "<br /><a href=\"" . $listing[$i]->reallink . "\" target=\"_blank\">" . $listing[$i]->reallink . "</a><br />";
			}			
			
			if ( $listing[$i]->metakey!='' && $params->get('showtags') ) {
				$keywords = array();
				$keywords = explode( "," , trim($listing[$i]->metakey) );	
				for ($a=0, $b=count($keywords); $a < $b; $a++) {
					$metakey = trim($keywords[$a]);
					if ( $a > 0 ) $tags .= ", ";
					$tags .= " <a href=\"" . JRoute::_("index.php?option=com_search&searchword=$metakey&submit=Search&searchphrase=any&ordering=newest") . "\">" . $metakey . "</a>";
				}
			}			

			// START LAYOUT			
			$ac_m = ($line % 2) + 1;			
			// using 2 columns
			if ( $ac_numcolumnslisting && $ac_m=='1' ) echo "\n<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\"><tr><td width=\"50%\" valign=\"top\">\n";
			if ( $ac_numcolumnslisting && $ac_m=='2' ) echo "\n<td width=\"50%\" valign=\"top\">\n";

			?>
			<!-- STARTING DIV CONTAINER ARTICLE -->
			<div id="container<?php echo $num; ?>" class="alphalisting">
			<table width="100%"><tr>	
			<?php
			if ( $params->get('list_showimage') && $linkimgsrc!='' ) {
				if ( $ac_alignimage == 0 && $ac_k == 'none' || $ac_alignimage == '2' && $ac_k == 0 ){
				?>
				<td valign="top" width="<?php echo $params->get('list_widthimage') ?>px">
				<!-- STARTING DIV IMAGE LEFT -->				
				<div class="_imageleft"><?php echo $linkimgsrc ?></div>
				<!-- END DIV IMAGE LEFT -->
				</td>
				<?php
				}
			}			
			?>
			<!-- STARTING DIV ARTICLE -->
			<td>
			<div id="article<?php echo $num; ?>">
			<div id="title<?php echo $num; ?>">
			<?php if ( $num ) { ?><span class="_alphanum" style="display:inline;"><?php echo $num ?>. </span><?php } ?>
			<?php if ( $title ) { ?><span class="_alphatitle" style="display:inline;"><?php echo $title ?></span> <span class="_alphafeatured"><sup><?php echo $featured ?></sup></span> <?php } ?>
			<?php if ( $icon_new || $icon_hot ) { ?><span style="display:inline;"><?php echo " " . $icon_new . " " . $icon_hot ?></span><?php } ?>
			</div>
			<?php if ( $ratingbar || $rating ) { ?>
				<div id="ratingbar<?php echo $num; ?>" class="small">				
				<?php echo $ratingbar;  ?><?php if ( $rating ) echo $rating; ?> 
				</div>
			<?php } ?>
			<?php if ( $section_category ) { ?>
				<div class="small"><?php echo $section_category; ?></div>
			<?php } ?>
			<?php if ( $author ) { ?>
				<div class="small">
				<?php echo JTEXT::_( 'AC_AUTHOR' ) . $author; ?>
				</div>
			<?php } ?>
			<?php if ( $tags ) { ?>			
				<div class="small">
				<?php echo JTEXT::_( 'AC_TAGS' ) . $tags; ?>
				</div>
			<?php } ?>
			<?php if ( $content ) { ?>
				<div id="content<?php echo $num; ?>"><?php	echo $content; ?></div>
			<?php } ?>
			<div id="features<?php echo $num; ?>">
			<?php if ( $date ) { ?><span class="small"><?php echo $date; ?></span><?php } ?>
			<?php if ( $hits ) { ?> | <span class="small"><?php $labelHit = ( $hits>1 )? 'AC_HITS' : 'AC_HIT'; echo $hits . " " . JTEXT::_($labelHit); ?></span><?php } ?>
			<?php if ( $comments ) { ?> | <span class="small"><?php $labelComment = ( $comments>1 )? JTEXT::_('AC_COMMENTS') : JTEXT::_('AC_COMMENT'); echo $comments . " " . $start_url_article . $labelComment . $end_url_article ; ?></span><?php } ?>
			<?php if ( $print ) { ?> | <span class="small"><?php echo $print; ?></span><?php } ?>
			<?php if ( $pdf ) { ?> | <span class="small"><?php echo $pdf; ?></span><?php } ?>
			<?php if ( $emailthis ) { ?> | <span class="small"><?php echo $emailthis; ?></span><?php } ?>
			<?php if ( $report ) { ?> | <span class="small"><?php echo $report; ?></span><?php } ?>			
			<?php if ( $readmore ) { ?> | <span class="small"><?php echo $readmore; ?></span><?php } ?>
			<?php if ( $googlemaps ) { ?> | <span class="small"><?php echo $googlemaps; ?></span><?php } ?>
			</div>
			</div><!-- END DIV ARTICLE -->
			</td>
			<?php
			if ( $params->get('list_showimage') && $linkimgsrc!='' ) {
				if ( $ac_alignimage == 1 && $ac_k == 'none' || $ac_alignimage == '2' && $ac_k == 1 ) {
				?>
				<td valign="top" width="<?php echo $params->get('list_widthimage') ?>px">
				<!-- STARTING DIV IMAGE RIGHT -->
				<div class="_imageright"><?php echo $linkimgsrc ?></div>				
				<!-- END DIV IMAGE RIGHT -->
				</td>
				<?php
				}
			}			
			?>
			</tr></table></div><!-- END DIV CONTAINER -->
			<div class="_separate"></div>
			<?php
			// END LAYOUT HTML
			// using 2 columns
			if ( $ac_numcolumnslisting && $ac_m=='1' ) echo "\n</td>\n";
			if ( $ac_numcolumnslisting && $ac_m=='1' && $i==(count($listing)-1) ) echo "\n<td width=\"50%\" valign=\"top\">&nbsp;";
			if ( $ac_numcolumnslisting && $ac_m=='2' || $ac_numcolumnslisting && $ac_m=='1' && $i==(count($listing)-1) ) echo "\n</td></tr></table>\n";
			
			$line++;
			if ( $ac_alignimage == '2' ){ $ac_k = 1 - $ac_k ; }

		} else {
			if ( $i > 0) $i=$i-1;	
		}
	}
	?>
	
	<?php
	if ( count($listing) && @$listing[0]->id!='' ) {
		if ( !($options['section']=='' && ( $options['letter']!='' || $options['search']!='' ) && ( $params->get('weblinkssection') || $params->get('contactsection')) ) ) {
			echo "<div id=\"alphapagination\"><p>";		
			echo $pagination->getPagesLinks();
			echo "<br />";
			echo $pagination->getPagesCounter();
			echo "</p></div>";
		}
	}	
	
}
echo "</div>"; // end general div named alphacontent
?>