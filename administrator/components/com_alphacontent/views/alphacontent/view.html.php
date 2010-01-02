<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

Jimport( 'joomla.application.component.view');

class configurationViewAlphacontent extends JView {

	function edit($tpl = null) {
	
  		$document =& JFactory::getDocument();
  		JHTML::_('behavior.mootools');
		$document->addScriptDeclaration("window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });");
		
		jimport('joomla.html.pane');
		$pane =& JPane::getInstance('tabs');		
		
		//ac_Jimport( 'joomla.html.html.select' );
		
		$lists = array();
				
		$options = array();
		$auth[] = JHTML::_('select.option', 'Registered', 'Registered');
		
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_NONE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_CONTENTSECTION' ) );
		$options[] = JHTML::_('select.option', '2', JText::_( 'AC_STATICSCONTENT' ) );
		$options[] = JHTML::_('select.option', '3', JText::_( 'AC_WEBLINKSSECTION' ) );
		$options[] = JHTML::_('select.option', '4', JText::_( 'AC_CONTACTSSECTION' ) );
		$options[] = JHTML::_('select.option', '5', JText::_( 'AC_FEATUREDBELOW' ) );		
		$lists['list_homeresult'] = JHTML::_('select.genericlist', $options, 'list_homeresult', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_homeresult );		
		$options = array();
		$options[] = JHTML::_('select.option', '0', '1' );
		$options[] = JHTML::_('select.option', '1', '2' );
		$lists['list_numcols'] = JHTML::_('select.radiolist', $options, 'list_numcols', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_numcols );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_NONE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_TEXTONLY' ) );
		$options[] = JHTML::_('select.option', '2', JText::_( 'AC_ORIGINALINTRO' ) );
		$options[] = JHTML::_('select.option', '3', JText::_( 'AC_METADESC' ) );
		$lists['list_introstyle'] = JHTML::_('select.genericlist', $options, 'list_introstyle', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_introstyle );
		$lists['list_titlelinkable'] = JHTML::_('select.booleanlist','list_titlelinkable', 1, $this->alphacontent_configuration->list_titlelinkable );	
			 
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_numindex'] = JHTML::_('select.radiolist', $options, 'list_numindex', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_numindex );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_iconnew'] = JHTML::_('select.radiolist', $options, 'list_iconnew', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_iconnew );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_iconhot'] = JHTML::_('select.radiolist', $options, 'list_iconhot', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_iconhot );
		$options = array();
		$options[] = JHTML::_('select.option', 'created', JText::_( 'AC_DATECREATED' ) );
		$options[] = JHTML::_('select.option', 'modified', JText::_( 'AC_DATEMODIFIED' ) );
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_DONOTSHOW' ) );
		$lists['list_showdate'] = JHTML::_('select.genericlist', $options, 'list_showdate', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_showdate );
		$options = array();
		$options[] = JHTML::_('select.option', JText::_( 'DATE_FORMAT_LC' ), JText::_( 'DATE_FORMAT_LC' ) );
		$options[] = JHTML::_('select.option', JText::_( 'DATE_FORMAT_LC2' ), JText::_( 'DATE_FORMAT_LC2' ) );
		$lists['list_formatdate'] = JHTML::_('select.genericlist', $options, 'list_formatdate', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_formatdate );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showauthor'] = JHTML::_('select.radiolist', $options, 'list_showauthor', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showauthor );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showsectioncategory'] = JHTML::_('select.radiolist', $options, 'list_showsectioncategory', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showsectioncategory );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showhits'] = JHTML::_('select.radiolist', $options, 'list_showhits', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showhits );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_shownumcomments'] = JHTML::_('select.radiolist', $options, 'list_shownumcomments', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_shownumcomments );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_NONE' ) );
		$options[] = JHTML::_('select.option', 'yvcomment', 'Yvcomment' );
		$options[] = JHTML::_('select.option', 'comments', 'Simple comment system' );
		$options[] = JHTML::_('select.option', 'chrono_comments', 'ChronoComments' );
		$options[] = JHTML::_('select.option', 'msComment_Comment', 'MS Comment' );
		$options[] = JHTML::_('select.option', 'mxc_comments', 'mXcomment' );
		$options[] = JHTML::_('select.option', 'jcomments', 'JComments' );
		$options[] = JHTML::_('select.option', 'jomcomment', 'JomComment' );
		$lists['list_commentsystem'] = JHTML::_('select.genericlist', $options, 'list_commentsystem', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_commentsystem );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showprint'] = JHTML::_('select.radiolist', $options, 'list_showprint', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showprint );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showpdf'] = JHTML::_('select.radiolist', $options, 'list_showpdf', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showpdf );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showemail'] = JHTML::_('select.radiolist', $options, 'list_showemail', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showemail );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showreportlisting'] = JHTML::_('select.radiolist', $options, 'list_showreportlisting', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showreportlisting );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showreadmore'] = JHTML::_('select.radiolist', $options, 'list_showreadmore', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showreadmore );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showlinkmap'] = JHTML::_('select.radiolist', $options, 'list_showlinkmap', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showlinkmap );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_shownumberpagetotal'] = JHTML::_('select.radiolist', $options, 'list_shownumberpagetotal', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_shownumberpagetotal );
		$options = array();
		$options[] = JHTML::_('select.option', '5', '5' );
		$options[] = JHTML::_('select.option', '6', '6' );
		$options[] = JHTML::_('select.option', '8', '8' );
		$options[] = JHTML::_('select.option', '10', '10' );
		$options[] = JHTML::_('select.option', '12', '12' );
		$options[] = JHTML::_('select.option', '15', '15' );
		$options[] = JHTML::_('select.option', '16', '16' );
		$options[] = JHTML::_('select.option', '18', '18' );
		$options[] = JHTML::_('select.option', '20', '20' );
		$options[] = JHTML::_('select.option', '25', '25' );
		$options[] = JHTML::_('select.option', '30', '30' );
		$options[] = JHTML::_('select.option', '40', '40' );
		$options[] = JHTML::_('select.option', '50', '50' );
		$options[] = JHTML::_('select.option', '30', '30' );
		$options[] = JHTML::_('select.option', '100', '100' );
		$options[] = JHTML::_('select.option', '200', '200' );
		$options[] = JHTML::_('select.option', '500', '500' );
		$options[] = JHTML::_('select.option', '1000', '1000' );		
		$lists['list_resultperpage'] = JHTML::_('select.genericlist', $options, 'list_resultperpage', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_resultperpage );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showsearchbox'] = JHTML::_('select.radiolist', $options, 'list_showsearchbox', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showsearchbox );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showsearchboxbutton'] = JHTML::_('select.radiolist', $options, 'list_showsearchboxbutton', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showsearchboxbutton );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['list_showorderinglist'] = JHTML::_('select.radiolist', $options, 'list_showorderinglist', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->list_showorderinglist );
		$options = array();
		$options[] = JHTML::_('select.option', '1',  JText::_( 'AC_TITLEAZ' ) );
		$options[] = JHTML::_('select.option', '2',  JText::_( 'AC_TITLEZA' ) );
		$options[] = JHTML::_('select.option', '3',  JText::_( 'AC_DATECREATEDASC' ) );
		$options[] = JHTML::_('select.option', '4',  JText::_( 'AC_DATECREATEDDESC' ) );
		$options[] = JHTML::_('select.option', '5',  JText::_( 'AC_DATEMODIFIEDASC' ) );
		$options[] = JHTML::_('select.option', '6',  JText::_( 'AC_DATEMODIFIEDDESC' ) );
		$options[] = JHTML::_('select.option', '7',  JText::_( 'AC_HITSASC' ) );
		$options[] = JHTML::_('select.option', '8',  JText::_( 'AC_HITSDESC' ) );
		$options[] = JHTML::_('select.option', '9',  JText::_( 'AC_RATINGASC' ) );
		$options[] = JHTML::_('select.option', '10', JText::_( 'AC_RATINGDESC' ) );
		$options[] = JHTML::_('select.option', '11', JText::_( 'AC_AUTHORASC' ) );
		$options[] = JHTML::_('select.option', '12', JText::_( 'AC_AUTHORDESC' ) );
		$options[] = JHTML::_('select.option', '13', JText::_( 'AC_FEATURED' ) );
		$options[] = JHTML::_('select.option', '0',  JText::_( 'AC_DEFAULTORDERING' ) );		
		$lists['list_defaultordering'] = JHTML::_('select.genericlist', $options, 'list_defaultordering', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_defaultordering );
		$options = array();
		$options[] = JHTML::_('select.option', '0',  JText::_( 'AC_NO' ) );
		$options[] = JHTML::_('select.option', '1',  JText::_( 'AC_FIRST' ) );
		$options[] = JHTML::_('select.option', '2',  JText::_( 'AC_LAST' ) );
		$lists['list_showimage'] = JHTML::_('select.genericlist', $options, 'list_showimage', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_showimage );
		$options = array();
		$options[] = JHTML::_('select.option', '0',  JText::_( 'AC_LEFT' ) );
		$options[] = JHTML::_('select.option', '1',  JText::_( 'AC_RIGHT' ) );
		$options[] = JHTML::_('select.option', '2',  JText::_( 'AC_ALTERNATE' ) );
		$lists['list_imageposition'] = JHTML::_('select.genericlist', $options, 'list_imageposition', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_imageposition );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['showmaptypemenu'] = JHTML::_('select.radiolist', $options, 'showmaptypemenu', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->showmaptypemenu );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['showmapcontrolsmenu'] = JHTML::_('select.radiolist', $options, 'showmapcontrolsmenu', 'class="inputbox"' ,'value', 'text', $this->alphacontent_configuration->showmapcontrolsmenu );
		$lists['activeglobalsystemrating'] = JHTML::_('select.booleanlist','activeglobalsystemrating', 1, $this->alphacontent_configuration->activeglobalsystemrating );		
		$options = array();
		$options[] = JHTML::_('select.option', '5', '5' );
		$options[] = JHTML::_('select.option', '6', '6' );
		$options[] = JHTML::_('select.option', '7', '7' );
		$options[] = JHTML::_('select.option', '8', '8' );
		$options[] = JHTML::_('select.option', '9', '9' );
		$options[] = JHTML::_('select.option', '10', '10' );
		$lists['numstars'] = JHTML::_('select.genericlist', $options, 'numstars', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->numstars );
		$options = array();
		$options[] = JHTML::_('select.option', '0', JText::_( 'AC_HIDE' ) );
		$options[] = JHTML::_('select.option', '1', JText::_( 'AC_SHOW' ) );
		$lists['showsharethis'] = JHTML::_('select.booleanlist','showsharethis', 1, $this->alphacontent_configuration->showsharethis );		
		// websnapr
		$options = array();		
		$options[] = JHTML::_('select.option', 'AC', JText::_( 'AC_GENERAL_WIDTH_IMAGE' ));
		$options[] = JHTML::_('select.option', 'T', JText::_( 'AC_WEBSNAPR' ) . ' ' . JText::_( 'AC_MICRO' ) . ' (92x70)' );
		$options[] = JHTML::_('select.option', 'S', JText::_( 'AC_WEBSNAPR' ) . ' ' .  JText::_( 'AC_SMALL' ) . ' (202x152)' );
		$options[] = JHTML::_('select.option', 'M', JText::_( 'AC_WEBSNAPR' ) . ' ' .  JText::_( 'AC_MEDIUM' ) . ' (400x300)' );
		$options[] = JHTML::_('select.option', 'L', JText::_( 'AC_WEBSNAPR' ) . ' ' .  JText::_( 'AC_LARGE' ) . ' (640x480)' );
		$lists['list_sizewebsnapr'] = JHTML::_('select.genericlist', $options, 'list_sizewebsnapr', 'class="inputbox" size="1"' ,'value', 'text', $this->alphacontent_configuration->list_sizewebsnapr );
		
		$this->assignRef('lists', $lists);
		$this->assignRef('pane', $pane);
		$this->assignRef('check', $this->check);
		
		parent::display( $tpl) ;
		
	}
}
?>
