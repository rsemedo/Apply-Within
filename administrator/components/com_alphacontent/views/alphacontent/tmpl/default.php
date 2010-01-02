<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JToolBarHelper::title(   JText::_( 'AC_CONFIGURATION_TITLE' ), 'cpanel' );
JToolBarHelper::save( 'save' );
JToolBarHelper::help( 'screen.alphacontent', true );

// Copyright
$copyStart = 2005; 
$copyNow = date('Y');  
if ($copyStart == $copyNow) { 
	$copySite = $copyStart;
} else {
	$copySite = $copyStart." - ".$copyNow ;
}

$template	= $mainframe->getTemplate();

?>
<table>
<tr>
<td width="65%" valign="top">
<form action="index.php" method="post" name="adminForm">
<?php
echo $this->pane->startPane("content-pane");
	
echo $this->pane->startPanel(JText::_( 'AC_CONFIGURATION_LISTING' ), "config-panel-general" );
?>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'AC_CONFIGURATION_LISTING' ); ?></legend>
			<table width="100%">
				<tr>
					<td width="50%" valign="top">
						<table class="admintable">
							<tbody>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_HOMELISTING' ); ?>::<?php echo JText::_('AC_HOMELISTINGDESC'); ?>">
											<?php echo JText::_( 'AC_HOMELISTING' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_homeresult']; ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_ITEMS_ID' ); ?>::<?php echo JTEXT::_('AC_ITEMS_ID_DESC'); ?>">
											<?php echo JText::_( 'AC_ITEMS_ID' ); ?>
										</span>
									</td>
									<td>
										<input type="text" name="list_featuredID" id="list_featuredID" class="inputbox" size="20" value="<?php echo $this->alphacontent_configuration->list_featuredID; ?>" />
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_NUMCOLS' ); ?>::<?php echo JText::_('AC_NUMCOLSDESC'); ?>">
											<?php echo JText::_( 'AC_NUMCOLS' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_numcols']; ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_INTROSTYLE' ); ?>::<?php echo JText::_('AC_INTROSTYLE'); ?>">
											<?php echo JText::_( 'AC_INTROSTYLE' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_introstyle']; ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_LIMITNUMCHARSINTRO' ); ?>::<?php echo JTEXT::_('AC_LIMITNUMCHARSINTRODESC'); ?>">
											<?php echo JText::_( 'AC_LIMITNUMCHARSINTRO' ); ?>
										</span>
									</td>
									<td>
										<input type="text" name="list_numcharsintro" id="list_numcharsintro" class="inputbox" size="5" value="<?php echo $this->alphacontent_configuration->list_numcharsintro; ?>" />
									</td>
								</tr>						
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_TITLELINKABLE' ); ?>::<?php echo JText::_('AC_TITLELINKABLE'); ?>">
											<?php echo JText::_( 'AC_TITLELINKABLE' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_titlelinkable']	; ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_NUMINDEX' ); ?>::<?php echo JTEXT::_('AC_NUMINDEXDESC'); ?>">
											<?php echo JText::_( 'AC_NUMINDEX' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_numindex'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_ICONNEW' ); ?>::<?php echo JTEXT::_('AC_ICONNEW'); ?>">
											<?php echo JText::_( 'AC_ICONNEW' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_iconnew'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_NUMDAYS' ); ?>::<?php echo JTEXT::_('AC_NUMDAYSDESC'); ?>">
											<?php echo JText::_( 'AC_NUMDAYS' ); ?>
										</span>
									</td>
									<td>
										<input type="text" name="list_numdaynew" id="list_numdaynew" class="inputbox" size="5" value="<?php echo $this->alphacontent_configuration->list_numdaynew; ?>" />
									</td>
								</tr>						
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_ICONHOT' ); ?>::<?php echo JTEXT::_('AC_ICONHOT'); ?>">
											<?php echo JText::_( 'AC_ICONHOT' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_iconhot'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_NUMHITS' ); ?>::<?php echo JTEXT::_('AC_NUMHITSDESC'); ?>">
											<?php echo JText::_( 'AC_NUMHITS' ); ?>
										</span>
									</td>
									<td>
										<input type="text" name="list_numhitshot" id="list_numhitshot" class="inputbox" size="5" value="<?php echo $this->alphacontent_configuration->list_numhitshot; ?>" />
									</td>
								</tr>					
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_DATEARTICLE' ); ?>::<?php echo JTEXT::_('AC_DATEARTICLE'); ?>">
											<?php echo JText::_( 'AC_DATEARTICLE' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showdate'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_FORMATDATE' ); ?>::<?php echo JTEXT::_('AC_FORMATDATE'); ?>">
											<?php echo JText::_( 'AC_FORMATDATE' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_formatdate'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_AUTHOR' ); ?>::<?php echo JTEXT::_('AC_AUTHOR'); ?>">
											<?php echo JText::_( 'AC_AUTHOR' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showauthor'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_SECTIONCATEGORY' ); ?>::<?php echo JTEXT::_('AC_SECTIONCATEGORY'); ?>">
											<?php echo JText::_( 'AC_SECTIONCATEGORY' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showsectioncategory'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_HITS' ); ?>::<?php echo JTEXT::_('AC_HITS'); ?>">
											<?php echo JText::_( 'AC_HITS' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showhits']; ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_NUMCOMMENT' ); ?>::<?php echo JTEXT::_('AC_NUMCOMMENT'); ?>">
											<?php echo JText::_( 'AC_NUMCOMMENT' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_shownumcomments'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_COMMENTSYSTEM' ); ?>::<?php echo JTEXT::_('AC_COMMENTSYSTEMDESC'); ?>">
											<?php echo JText::_( 'AC_COMMENTSYSTEM' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_commentsystem'] ?>
									</td>
								</tr>
						  </tbody>
						</table>		
				  </td>
					
					<td width="50%" valign="top">
						<table class="admintable">
							<tbody>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_PRINT' ); ?>::<?php echo JTEXT::_('AC_PRINT'); ?>">
											<?php echo JText::_( 'AC_PRINT' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showprint'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_PDF' ); ?>::<?php echo JTEXT::_('AC_PDF'); ?>">
											<?php echo JText::_( 'AC_PDF' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showpdf'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_EMAIL' ); ?>::<?php echo JTEXT::_('AC_EMAIL'); ?>">
											<?php echo JText::_( 'AC_EMAIL' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showemail'] ?>
									</td>
								</tr>
								<tr>
								  <td class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_REPORT' ); ?>::<?php echo JTEXT::_('AC_REPORT_THIS_LISTING'); ?>">
											<?php echo JText::_( 'AC_REPORT' ); ?>
										</span>
								  </td>
								  <td>
										<?php echo $this->lists['list_showreportlisting'] ?>
								  </td>
							  </tr>
								<tr>
								  <td class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_EMAIL_ADMINISTRATOR' ); ?>::<?php echo JTEXT::_('AC_EMAIL_ADMINISTRATOR_DESCRIPTION'); ?>">
											<?php echo JText::_( 'AC_EMAIL_ADMINISTRATOR' ); ?>
										</span>
								</td>
								  <td>
								  <input type="text" name="list_email_administrator" id="list_email_administrator" class="inputbox" size="40" value="<?php echo $this->alphacontent_configuration->list_email_administrator; ?>" />
								  </td>
							  </tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_READMORE' ); ?>::<?php echo JTEXT::_('AC_READMORE'); ?>">
											<?php echo JText::_( 'AC_READMORE' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showreadmore'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_LINKMAP' ); ?>::<?php echo JTEXT::_('AC_LINKMAPDESC'); ?>">
											<?php echo JText::_( 'AC_LINKMAP' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showlinkmap'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_NUMBERPAGETOTAL' ); ?>::<?php echo JTEXT::_('AC_NUMBERPAGETOTAL'); ?>">
											<?php echo JText::_( 'AC_NUMBERPAGETOTAL' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_shownumberpagetotal'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_RESULTPERPAGE' ); ?>::<?php echo JTEXT::_('AC_RESULTPERPAGE'); ?>">
											<?php echo JText::_( 'AC_RESULTPERPAGE' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_resultperpage'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_SEARCHBOX' ); ?>::<?php echo JTEXT::_('AC_SEARCHBOX'); ?>">
											<?php echo JText::_( 'AC_SEARCHBOX' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showsearchbox'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_SEARCHBOXBUTTON' ); ?>::<?php echo JTEXT::_('AC_SEARCHBOXBUTTON'); ?>">
											<?php echo JText::_( 'AC_SEARCHBOXBUTTON' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showsearchboxbutton'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_ORDERINGLIST' ); ?>::<?php echo JTEXT::_('AC_ORDERINGLIST'); ?>">
											<?php echo JText::_( 'AC_ORDERINGLIST' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showorderinglist'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_DEFAULTORDERING' ); ?>::<?php echo JTEXT::_('AC_DEFAULTORDERING'); ?>">
											<?php echo JText::_( 'AC_DEFAULTORDERING' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_defaultordering'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_SHOWIMAGE' ); ?>::<?php echo JTEXT::_('AC_SHOWIMAGE'); ?>">
											<?php echo JText::_( 'AC_SHOWIMAGE' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_showimage'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_IMAGEPOSITION' ); ?>::<?php echo JTEXT::_('AC_IMAGEPOSITION'); ?>">
											<?php echo JText::_( 'AC_IMAGEPOSITION' ); ?>
										</span>
									</td>
									<td>
										<?php echo $this->lists['list_imageposition'] ?>
									</td>
								</tr>
								<tr>
									<td width="280" class="key">
										<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_WIDTHIMAGE' ); ?>::<?php echo JTEXT::_('AC_WIDTHIMAGE'); ?>">
											<?php echo JText::_( 'AC_WIDTHIMAGE' ); ?>
										</span>
									</td>
									<td>
										<input type="text" name="list_widthimage" id="list_widthimage" class="inputbox" size="20" value="<?php echo $this->alphacontent_configuration->list_widthimage; ?>" />
									</td>
								</tr>
							</tbody>
						</table>							
				  </td>
				</tr>			
			</table>			
		</fieldset>
				
<?php
	echo $this->pane->endPanel();	
	echo $this->pane->startPanel(JText::_( 'AC_GOOGLEMAPSLOCATION' ), "config-panel-google" );
?>
				
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'AC_GOOGLEMAPSLOCATION' ); ?></legend>
				<table class="admintable">
					<tbody>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_APIKEY' ); ?>::<?php echo JTEXT::_('AC_APIKEYGOOGLEMAPS'); ?>">
									<?php echo JText::_( 'AC_APIKEY' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="apikeygooglemap" id="apikeygooglemap" class="inputbox" size="50" value="<?php echo $this->alphacontent_configuration->apikeygooglemap; ?>" />
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_ZOOMLEVEL' ); ?>::<?php echo JTEXT::_('AC_ZOOMLEVEL'); ?>">
									<?php echo JText::_( 'AC_ZOOMLEVEL' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="zoomlevel" id="zoomlevel" class="inputbox" size="10" value="<?php echo $this->alphacontent_configuration->zoomlevel; ?>" />
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_WIDTHMAP' ); ?>::<?php echo JTEXT::_('AC_WIDTHMAP'); ?>">
									<?php echo JText::_( 'AC_WIDTHMAP' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="widthgooglemap" id="widthgooglemap" class="inputbox" size="10" value="<?php echo $this->alphacontent_configuration->widthgooglemap; ?>" />
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_HEIGHTMAP' ); ?>::<?php echo JTEXT::_('AC_HEIGHTMAP'); ?>">
									<?php echo JText::_( 'AC_HEIGHTMAP' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="heightgooglemap" id="heightgooglemap" class="inputbox" size="10" value="<?php echo $this->alphacontent_configuration->heightgooglemap; ?>" />
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_MAPTYPEMENU' ); ?>::<?php echo JTEXT::_('AC_MAPTYPEMENUDESC'); ?>">
									<?php echo JText::_( 'AC_MAPTYPEMENU' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['showmaptypemenu'] ?>
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_MAPCONTROLSMENU' ); ?>::<?php echo JTEXT::_('AC_MAPCONTROLSMENUDESC'); ?>">
									<?php echo JText::_( 'AC_MAPCONTROLSMENU' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['showmapcontrolsmenu'] ?>
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="">
									&nbsp;
								</span>
							</td>
							<td>
								<?php echo JText::_( 'AC_SEEHELPFORTAGUSAGE' ); ?>
							</td>
						</tr>
					</tbody>
				</table>
		</fieldset>
				
<?php
	echo $this->pane->endPanel();	
	echo $this->pane->startPanel(JText::_( 'AC_AJAXSYSTEMRATING' ), "config-panel-rating" );
?>		
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'AC_AJAXSYSTEMRATING' ); ?></legend>
				<table class="admintable">
					<tbody>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_USESYSTEMRATING' ); ?>::<?php echo JText::_('AC_USESYSTEMRATINGDESC'); ?>">
									<?php echo JText::_( 'AC_USESYSTEMRATING' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['activeglobalsystemrating']; ?>
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_STARS' ); ?>::<?php echo JTEXT::_('AC_NUMSTARSDESC'); ?>">
									<?php echo JText::_( 'AC_STARS' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['numstars'] ?>
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_WIDTH' ); ?>::<?php echo JTEXT::_('AC_WIDTHSTAR'); ?>">
									<?php echo JText::_( 'AC_WIDTH' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="widthstars" id="widthstars" class="inputbox" size="10" value="<?php echo $this->alphacontent_configuration->widthstars; ?>" />
							</td>
						</tr>
					</tbody>
				</table>
		</fieldset>
				
<?php
	echo $this->pane->endPanel();	
	echo $this->pane->startPanel(JText::_( 'AC_SHARETHISWIDGET' ), "config-panel-sharethis" );
?>
				
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'AC_SHARETHISWIDGET' ); ?></legend>
				<table class="admintable">
					<tbody>
						<tr>
							<td colspan="2"><?php echo JText::_( 'AC_SHARETHISWIDGETDESC' ); ?></td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_USESHARETHISWIDGET' ); ?>::<?php echo JText::_('AC_USESHARETHISWIDGET'); ?>">
									<?php echo JText::_( 'AC_USESHARETHISWIDGET' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['showsharethis']; ?>
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_SHARETHISWIDGETCODE' ); ?>::<?php echo JTEXT::_('AC_SHARETHISPASTEYOURWIDGETCODE'); ?>">
									<?php echo JText::_( 'AC_SHARETHISWIDGETCODE' ); ?>
								</span>
							</td>
							<td>
                              <textarea name="sharethiscode" cols="50" rows="5" class="inputbox" id="sharethiscode"><?php echo htmlspecialchars($this->alphacontent_configuration->sharethiscode); ?></textarea>
							</td>
						</tr>
					</tbody>
				</table>
		</fieldset>
<?php
	echo $this->pane->endPanel();
	echo $this->pane->startPanel(JText::_( 'AC_WEBSNAPR' ), "config-panel-websnapr" );
?>				
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'AC_WEBSNAPR' ); ?></legend>
				<table class="admintable">
					<tbody>
						<tr>
							<td colspan="2"><?php echo JText::_( 'AC_WEBSNAPRDESC' ); ?></td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_KEY' ); ?>::<?php echo JTEXT::_('AC_KEY'); ?>">
									<?php echo JText::_( 'AC_KEY' ); ?>
								</span>
							</td>
							<td>
                             <input type="text" name="list_keywebsnapr" id="list_keywebsnapr" class="inputbox" size="50" value="<?php echo $this->alphacontent_configuration->list_keywebsnapr; ?>" />
							</td>
						</tr>
						<tr>
							<td width="280" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'AC_SIZE' ); ?>::<?php echo JTEXT::_('AC_SIZE'); ?>">
									<?php echo JText::_( 'AC_SIZE' ); ?>
								</span>
							</td>
							<td>
                            <?php echo $this->lists['list_sizewebsnapr']; ?>
							</td>
						</tr>
						
					</tbody>
				</table>
		</fieldset>
<?php
	echo $this->pane->endPanel();	
	echo $this->pane->endPane();			
?>				
	<input type="hidden" name="option" value="com_alphacontent" />
	<input type="hidden" name="task" value="save" />
</form>
</td>

<td width="35%" valign="top">
<?php
if($this->check['connect'] == 0) {
?>
	<table class="adminlist">
		<thead>
				<tr>
					<th colspan="2">
					<?php echo JText::_( 'AC_VERSION' ); ?>
					</th>
				</tr>
		</thead>
		<tbody>
			<tr>
			<td colspan="2">
				<?php
		  			echo '<b><font color="red">'.JText::_( 'AC_CONNECTION_FAILED' ).'</font></b>';
		  		?>
			</td>
			</tr>
		</tbody>
	</table>
<?php
} elseif ($this->check['enabled'] == 1) {
?>
	<table class="adminlist">
		<thead>
				<tr>
					<th colspan="2">
					<?php echo JText::_( 'AC_UPDATE_CHECK' ); ?>
					</th>
				</tr>
		</thead>
		<tbody>
			<tr>
			<td width="33%">
				<?php
		  			if ($this->check['current'] == 0 ) {		  				
						echo JHTML::_('image', 'administrator/templates/'. $template .'/images/header/icon-48-checkin.png', NULL, 'width=32');
		  			} elseif( $this->check['current'] == -1 ) {
		  				echo JHTML::_('image', 'administrator/templates/'. $template .'/images/header/icon-48-info.png', NULL, 'width=32');
		  			} else {
		  				echo JHTML::_('image', 'administrator/templates/'. $template .'/images/header/icon-48-info.png', NULL, 'width=32');
		  			}
		  		?>
			</td>
			<td>
				<?php
		  			if ($this->check['current'] == 0) {
		  				echo '<strong><font color="green">'.JText::_( 'AC_LATEST_VERSION_INSTALLED' ).'</font></strong>';
		  			} elseif( $this->check['current'] == -1 ) {
		  				echo '<b><font color="red">'.JText::_( 'AC_OLD_VERSION' ).'</font></b>';
		  			} else {
		  				echo '<b><font color="orange">'.JText::_( 'AC_NEWER_VERSION' ).'</font></b>';
		  			}
		  		?>
			</td>
			</tr>
			<tr>
				<td width="33%">
					<?php echo JText::_( 'AC_LATEST_VERSION' ).':'; ?>
				</td>
				<td>
					<?php echo $this->check['version']; ?>
				</td>
			</tr>
			<tr>
				<td width="33%">
					<?php echo JText::_( 'AC_INSTALLED_VERSION' ).':'; ?>
				</td>
				<td>
					<?php echo $this->check['current_version']; ?>
				</td>
			</tr>
			<tr>
				<td width="33%">
					<?php echo JText::_( 'AC_RELEASED_DATE' ).':'; ?>
				</td>
				<td>
					<?php echo $this->check['released']; ?>
				</td>
			</tr>
	</tbody>
</table>
<?php 
} 
?>
	    <table class="adminlist">
			<thead>
				<tr>
					<th colspan="2">
					<?php echo JText::_( 'AC_DONATE' ); ?>
					</th>
				</tr>
			</thead>			
			<tbody>
			<tr>
			<td width="33%">
			<?php echo JText::_( 'AC_IF_YOU_LIKE_ALPHACONTENT' ) ; ?>
			</td>
		  	<td>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="donation">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="image" src="<?php echo JURI::base(true).'/components/com_alphacontent/assets/images/btn_donateCC_LG.gif'; ?>" name="submit" alt="PayPal - The safer, easier way to pay online!" style="border:0"/>
<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHZwYJKoZIhvcNAQcEoIIHWDCCB1QCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYAT9nEa3B+bkCBKacZ0gbNRwIl5c1cIO4YrYMV56RNDAYwEymfO82rnr/om2RdMS66WseQrzED4gWtOXuBruUCUO9Hmw3CyoUDu9B2gK36xIsKKBhm4yd/jz4+PLBCqh7NfarzqeDraX5qE7EDHuwON1peRGYxiIyIga8UPtaxX0jELMAkGBSsOAwIaBQAwgeQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIGIrk7rsPtEqAgcBxWCR/nHoq7v1d2+2NUZKmEq1oSw2B7R76idjVYd5zEg9xbjLD3btoQZs+kmp5UdOz2WOg4joWqnA2QXL7ZJcV/dvYKTndmk7F0fr5rALFkpuK9RtrFFszcr97yxNqXD44n0enJ5tIsm6UG5ION3b6DPFA9ofQWbL+rY4WPr0qZrCtMRrhW8wZm96joY7A+9eV7RRuyrohbqf/sAht0tRoEXPYjgVrfWW2aEmyOWREjtK8A5GESVH/kxvlfJUXcq+gggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0wODA4MTYxNjQ0MzVaMCMGCSqGSIb3DQEJBDEWBBRZOBvgB6D58p+m7R4HwqVXaBzabzANBgkqhkiG9w0BAQEFAASBgKzd3vnqbc86Na7eqcjf5daTTMYHKAjM6yR4KczcjyIBHz2yY/eATfZvtOzlsbszgVtFqnZuTODG2Ex1Tu9CZJWw9KhplcwyX+Fdd0bNtxXq8NsBVsSu0gF6OBrLlvBiW8JEgku6Y1LxfRow77TtPnPleyiagG9bjVEgOa3Vj7Uh-----END PKCS7-----" />
</form>
		  	</td>
			</tr>
			</tbody>	
		</table>				
</td>
</tr>
</table>
<br /><div align="center">AlphaContent is Free Software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GNU/GPL License</a>. <b><br />AlphaContent &copy; <?php echo $copySite ; ?> - Bernard Gilly - <a href="http://www.alphaplug.com" target="_blank">www.alphaplug.com</a> - All Rights Reserved </div>