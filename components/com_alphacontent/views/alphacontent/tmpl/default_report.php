<?php
/*
 * @component AlphaContent
 * @copyright Copyright (C) 2005 - 2009 Bernard Gilly. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @Website : http://www.alphaplug.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

global $mainframe;

$type = $this->type;
$id = $this->id;
$list_email_administrator = $this->list_email_administrator;
?>
<div style="padding: 10px;">
	<div style="text-align:right">
		<a href="javascript: void window.close()">
			<?php echo JText::_('AC_CLOSE_WINDOW'); ?> <img src="<?php echo JURI::base() ?>components/com_mailto/assets/close-x.png" border="0" alt="" title="" /></a>
	</div>
	<div class="componentheading"><?php echo JText::_( 'AC_REPORT_THIS_LISTING' ); ?></div><br />
<?php
	if ( $_POST )
	{	
		jimport( 'joomla.mail.helper' );
		
		$SiteName 	= $mainframe->getCfg('sitename');
		$MailFrom 	= $mainframe->getCfg('mailfrom');
		$FromName 	= $mainframe->getCfg('fromname');		
		
		// An array of e-mail headers we do not want to allow as input
		$headers = array (	'Content-Type:',
							'MIME-Version:',
							'Content-Transfer-Encoding:',
							'bcc:',
							'cc:');

		// An array of the input fields to scan for injected headers
		$fields = array ('mailto',
						 'sender',
						 'from',
						 'subject',
						 );

		/*
		 * Here is the meat and potatoes of the header injection test.  We
		 * iterate over the array of form input and check for header strings.
		 * If we fine one, send an unauthorized header and die.
		 */
		foreach ($fields as $field)
		{
			foreach ($headers as $header)
			{
				if (strpos($_POST[$field], $header) !== false)
				{
					JError::raiseError(403, '');
				}
			}
		}

		/*
		 * Free up memory
		 */
		unset ($headers, $fields);
		
		$reportemail = JRequest::getVar ( 'reportemail', '', 'POST', 'string' );	
		$reportname = JRequest::getVar ( 'reportname', '', 'POST', 'string' );		
		$report = JRequest::getVar ( 'report', '', 'POST', 'string' );				
		$report = stripslashes( $report );
		
		$type = JRequest::getVar ( 'type', '', 'POST', 'string' );
		$id = JRequest::getVar ( 'id', '0', 'POST', 'int' );
		
		if ( $list_email_administrator=='' ) $list_email_administrator = $MailFrom;
		
		$emails = @explode( ',', $list_email_administrator );
		
		$subject = JText::_( 'AC_REPORT_THIS_LISTING' ) . " (" . $SiteName . ")";
		
		// Build the message to send
		$msg	= JText :: _('AUP_EMAIL_MSG_INVITE');
		$body	= sprintf( $msg, $SiteName, $sender, $link) . " \n" . $report;
		
		$body  = JText :: _('AC_USER_REPORTED_ARTICLE') . " \n";
		$body .= JText :: _('AC_NAME') . ": " . $reportname . " \n";
		$body .= JText :: _('AC_EMAIL') . ": " . $reportemail . " \n";		
		$body .= JText :: _('AC_REPORT') . ": " . $report . " \n";
		$body .= JText :: _('AC_COMPONENT') . ": " . $type . " \n";
		$body .= JText :: _('AC_ID') . ": " . $id . " \n";

		// Clean the email data
		$subject = JMailHelper::cleanSubject($subject);
		$body	 = JMailHelper::cleanBody($body);

		foreach ($emails as $email) {				
			
			if ( JMailHelper::isEmailAddress($email) ) {
				$mailer =& JFactory::getMailer();
				$mailer->setSender( array( $MailFrom, $FromName ) );
				$mailer->setSubject( $subject);
				$mailer->setBody($body);
				$mailer->addRecipient( $email );					
				if ( $mailer->Send() === true ) {
					$success = true;
				}
			}

		}
			
		if ( $success ){
			echo JText::_('AC_THANKS4UREPORT');
		} else {
			echo JText::_('AC_ERRORONSENDREPORT');
		}

	}
	else // no posting -> just show form
	{
	?>
<script language="javascript" type="text/javascript">
<!--
	function submitbutton(pressbutton) {
	    var form = document.reportForm;

		// do field validation
		if ( form.reportemail.value == "") {
			alert( '<?php echo JText::_('AC_EMAIL_ERR_NOINFO'); ?>' );
			return false;
		} else if ( form.reportname.value == "" ) {		
			alert( '<?php echo JText::_('AC_ENTERYOURNAME'); ?>' );
			return false;
		} else if ( form.report.value == "" ) {		
			alert( '<?php echo JText::_('AC_ENTERYOURREPORT'); ?>' );
			return false;
		}
		form.submit();
	}
-->
</script>
	  <form action="<?php echo JRoute::_('index.php?option=com_alphacontent&amp;task=report&amp;type='.$type.'&amp;id='.$id.'&amp;tmpl=component'); ?>" method="post" name="reportForm">
	    <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="30%"><div align="right"><?php echo JText::_( 'AC_ENTERYOURNAME' ); ?></div></td>
            <td width="12">&nbsp;</td>
            <td width="68%"><input type="text" id="reportname" name="reportname" class="inputbox"></td>
          </tr>
          <tr>
            <td><div align="right"><?php echo JText::_( 'AC_ENTERYOURMAIL' ); ?></div></td>
            <td>&nbsp;</td>
            <td><input type="text" id="reportemail" name="reportemail" class="inputbox"></td>
          </tr>
          <tr>
            <td valign="top"><div align="right"><?php echo JText::_( 'AC_ENTERYOURREPORT' ); ?></div></td>
            <td>&nbsp;</td>
            <td><textarea id="report" name="report" cols="30" rows="5" class="inputbox"></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
			</td>			
          </tr>
          <tr>
            <td><div align="right"></div></td>
            <td>&nbsp;</td>
            <td>			
			<button class="button" onclick="return submitbutton('send');">
				<?php echo JText::_('AC_SEND'); ?>
			</button>
			<button class="button" onclick="window.close();return false;">
				<?php echo JText::_('AC_CANCEL'); ?>
			</button>
			</td>
          </tr>
        </table>
		<input type="hidden" name="option" value="com_alphacontent" />
		<input type="hidden" name="task" value="report" />
		<input type="hidden" name="type" value="<?php echo $type; ?>" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="tmpl" value="component" />
     </form>
	<?php
	}	
?>
	</div>
</div>