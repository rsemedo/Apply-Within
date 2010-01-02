<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JPlugin::loadLanguage( 'tpl_SG1' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

</head>
<body id="page_bg">
<div id="topfade">
<a name="up" id="up"></a>
<div id="header">
			<div id="header_r">
				<div id="header_l">
					<div id="logo_bg">
						<div id="logo">
							<a href="index.php"><div style="position:absolute;top:0px;left:0;z-index:1;width:100%;"></div></a>
							
						</div>
					</div>
				</div>
			</div>
		</div>		
<div id="wrapper">
	<div id="wrapper_r">
        <div id="pillmenu_t"></div>
		<div id="tabarea">
			<div id="tabarea_r">
				<div id="tabarea_l">
             		<table cellpadding="0" cellspacing="0" class="pill">
						<tr>
							<td class="pill_m">
							<div id="pillmenu">
								<jdoc:include type="modules" name="user3" />
							</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>	
		<div id="pillmenu_b"></div>
			<div id="whitebox_m">
				<div id="area">
						<?php if($this->countModules('left') and JRequest::getCmd('layout') != 'form') : ?>
							<div id="leftcolumn" style="float:left;">
								<jdoc:include type="modules" name="left" style="xhtml" />
							</div>
						<?php endif; ?>
						<?php if($this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
							<div id="rightcolumn" style="float:right;">
										<jdoc:include type="modules" name="right" style="xhtml" />								
							</div>
						<?php endif; ?>
						<?php if($this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
						<div id="maincolumn">
						<?php else: ?>
						<div id="maincolumn_full">
						<?php endif; ?>
								<jdoc:include type="message" />
                            <?php if($this->params->get('showComponent')) : ?>
									<jdoc:include type="component" />
							<?php endif; ?>
						</div>
				</div>
			</div>
		</div>
	<div id="footer">
		<div id="footer_l">
			<div id="footer_r">
				<div>Apply Within, 'Live In Choice ~ Love Your Life,' The Enterprising Moms, and 'Growing Businesses While Growing Families' 
are service marks of Apply Within, LLC.<br />Apply Within and The Enterprising Moms are Apply Within, LLC companies. &copy; 2007 - <?php echo JHTML::_('date',  'now', '%Y' ) . ' ' . $mainframe->getCfg('sitename'); ?>. All Rights Reserved.</div>
			</div>
		</div>
	</div>			
		</div>
	</div>
</div>
</div>
<jdoc:include type="modules" name="debug" />
</body>
</html>
