<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

 // no direct access
defined('_JEXEC') or die('Restricted access');

function getACCopyrightNotice() {
	
	require_once (JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_alphacontent'.DS.'assets'.DS.'includes'.DS.'version.php' );
	
	$copyStart = 2005; 
	$copyNow = date('Y');  
	if ($copyStart == $copyNow) { 
		$copySite = $copyStart;
	} else {
		$copySite = $copyStart."-".$copyNow ;
	} 
	$noticeACCopyright = "<div style=\"clear:both;text-align:center;\"><span class=\"small\"><br />Powered by <a href=\"http://www.alphaplug.com\" target=\"_blank\">AlphaContent</a> " . JTEXT::_('_ALPHACONTENT_NUM_VERSION') . "&nbsp;&copy;&nbsp;";
	$noticeACCopyright .= $copySite . " - All rights reserved</span></div>";
	
	echo $noticeACCopyright;		
}

function findIMG( $contenttext, $showfirstimg ) {	
	$image = "";
	if ( preg_match_all('#src="(.*)"#Uis', $contenttext, $match ) ) {
		if ( count($match) ) {
			$n = sizeof($match[1]);
			if ( $showfirstimg=='2' ) {
				$image = $match[1][$n-1];
			} else $image = $match[1][0];
		}
	}
	return $image;
}

function acSmartSubstr( $text, $length=250 ) {
	if ( strlen($text) > $length ) {     
		$text = substr( $text, 0, $length );
		$blankpos = strrpos( $text, ' ' );    
		$text = substr( $text, 0, $blankpos );    
		$text .= "...";
	}  
	return $text;  
}

function acPrepareAlphaContent( $text, $length=250, $tags='' ) {
	// strips tags won't remove the actual jscript
	$text = preg_replace( "'<script[^>]*>.*?</script>'si", "", $text );
	$text = preg_replace( '/{.+?}/', '', $text);
	// replace line breaking tags with whitespace
	$text = preg_replace( "'<(br[^/>]*?/|hr[^/>]*?/|/(div|h[1-6]|li|p|td))>'si", ' ', $text );
	//return html_entity_decode(acSmartSubstr( strip_tags( $text, $tags ), $length, $searchword ));
	return html_entity_decode( acSmartSubstr( strip_tags( $text, $tags ), $length ) );
}

function getCategories ( $ncat, $subcats, $sectionid, $url, $params, $showmore=1, $char, $menuid='' ) {
	$catlist = "";
	$more = 0;
	$cat  = @explode ( "\n", $subcats );
	$nsubcats = count($cat);
	$char = stripslashes($char);
	if ( $ncat>$params->get('limitnumcat') && $params->get('limitnumcat')>0 && $showmore ) $more = 1;
	if ( $sectionid!='0' ) {
		if ($char=='<li>') $catlist .= "<ul>";
		$endli = ($char== '<li>')? "</li>" : "";
		for ( $i=0; $i < $ncat; $i++ ){
			$subcat = @explode ( "|", $cat[$i] );
			if ( $subcat[0]!='' ) {				
				$sep = ( $i < ($nsubcats-1) ) ? $char . " "  : "" ;
				$linkcat = $url . "&amp;section=" . $sectionid . "&amp;category=" . $subcat[0] . "&amp;Itemid=" . $menuid;
				if ( $endli=='</li>' ) {
					$sep = ""; 
					$catlist .= "<li>";
				}
				$catlist .= "<a href=\"" . JRoute::_($linkcat) . "\">" . $subcat[1] . "</a>" . $endli.$sep;
			}
		}
		if ( $more ) {
			$linkcat = $url . "&amp;section=" . $sectionid . "&amp;Itemid=" . $menuid;
			$catlist .= $char . " <a href=\"" . JRoute::_($linkcat) . "\">...</a>" . $endli;
		}
		if ($char== '<li>') $catlist .= "</ul>";
		$endli = "";
	}
	return $catlist;
}

function insertImageDirectory( $image, $title, $width='80') {

	$image4directory = "";
	
	// Insert image section/category			
	if ( $image!='' ) {
		$image4directory = "<img src=\"" . JURI::base() . "images/stories/" . $image . "\" class=\"ac_image_directory\" width=\"" . $width . "px\" title=\"\" alt=\"\" />";
	}
	return $image4directory;
}

function showIconNew ( $created, $numdaynew=7, $lang ){

	$icon_new = "";
	$cdate = $created;
	$cjour = substr($cdate,8,2); 
	$cmois = substr($cdate,5,2); 
	$cannee = substr($cdate,0,4); 
			
	$timestamp = @mktime(0,0,0,$cmois,$cjour,$cannee);
	$cmaintenant = time();							
	$ecart_secondes = $cmaintenant - $timestamp;
	$ecart_jours = floor($ecart_secondes / (60*60*24)); 			
	
	if ( $numdaynew > '0' ){ 
		if ($ecart_jours <= $numdaynew){
			// set default icons
			$new_icon = "new_en-gb.gif";		
			// Get icon in right language if exists
			if (file_exists(JPATH_SITE."/components/com_alphacontent/assets/images/new_".$lang.".gif")){
				$new_icon = "new_".$lang.".gif";
			}
			$icon_new = " <span style=\"vertical-align:middle\"><img src=\"".JURI::base()."/components/com_alphacontent/assets/images/".$new_icon."\" alt=\"\" /></span>";
		}
	}
	return $icon_new;
}

function showIconHot( $hits, $numhitshot=50, $lang ){
	
	$icon_hot = "";
	if ( $numhitshot > '0' ){ 
		if($hits >= $numhitshot){
			$hot_icon = "hot_en-gb.gif";
			// Get icon in right language if exists
			if (file_exists(JPATH_SITE."/components/com_alphacontent/assets/images/hot_".$lang.".gif")){
				$hot_icon = "hot_".$lang.".gif";
			}			
			$icon_hot = " <span style=\"vertical-align:middle\"><img src=\"".JURI::base()."/components/com_alphacontent/assets/images/".$hot_icon."\" alt=\"\" /></span>";
		}
	}
	return $icon_hot;
}

function buildWhereComment ( $commentsystem, $idarticle ){
	
	switch ( $commentsystem ) {
	
		case 'yvcomment':
			$wherecomment = "parentid = '" . intval($idarticle) . "' AND `state` = '1'";
			break;
			
		case 'comments':
			$wherecomment = "articleid = '" . intval($idarticle) . "' AND `approved` = '1'";
			break;
			
		case 'chrono_comments':
			$wherecomment = "pageid = '" . intval($idarticle) . "' AND `verify` = '1' AND `published` = '1'";
			break;
			
		case 'msComment_Comment':
			$wherecomment = "articleId = '" . intval($idarticle) . "'";
			break;
			
		case 'mxc_comments':
		case 'jomcomment'  :
			$wherecomment = "contentid = '" . intval($idarticle) . "' AND `published` = '1'";
			break;
			
		case 'jcomments':
			$wherecomment = "`object_id` = '" . intval($idarticle) . "' AND `published` = '1'";
			break;
		
		default:
			$wherecomment = '';
	
	}
	return $wherecomment;


}

function getNumberComments( $commentsystem, $idarticle ) {

	$db =& JFactory::getDBO();
	$numcomments = 0;
	$wherecomment = buildWhereComment ( $commentsystem, $idarticle );
	
	if ( $wherecomment ) {
		$query = "SELECT COUNT(*) FROM #__" . $commentsystem . " WHERE " . $wherecomment;
		$db->setQuery( $query );
		$num = $db->loadResult();
		$numcomments = $num[0];
	}
	return $numcomments;
}

function showShareThis( $params ) {

	$sharethis = ( $params->get('showsharethiswidget')=='1' ) ? stripslashes( $params->get('sharethiscode') ) : '' ;
	
	return $sharethis;

}

function showRSSicon( $params, $section, $category, $menuid ) {
	global $mainframe;
	
	$rss2    = "";
	$linkRSS = "";
	if ( $section>=0 ) $linkRSS  = JRoute::_( "index.php?option=com_alphacontent&amp;task=showRSS&amp;s=$section&amp;m=$menuid" );	
	if ( $category ) $linkRSS = JRoute::_( "index.php?option=com_alphacontent&amp;task=showRSS&amp;s=$section&amp;c=$category&amp;m=$menuid" );	

	$rss2 .= "<a href=\"".$linkRSS."\">";
	$rss2 .= "<span class=\"ac_rss2\">" . JText::_('AC_RSS') . "</span>";
	$rss2 .= "</a>";
	
	return $rss2;
}
?>