<?php
	/**
	 *	Recommend Component for Joomla! / Mambo
	 *	Dynamic portal server and Content managment engine
	 *	26-09-2003
 	 *
	 *	Copyright (C) 2003-2006 Emir Sakic
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
	 *
	 *	File Name: com_recommend.php
	 *	Developer: Emir Sakic - saka@hotmail.com
	 * 	Version #: 2.4
	 *	Comments:
	**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/* SETTINGS */

$recommend_from_sender = 0;					// 0 = from webmaster, 1 = from sender

/* NO CHANGES BELOW THIS LINE (unless you know what you are doing) */
$recommend_version = "2.4";					// script version

if (file_exists("components/com_recommend/lang/$mosConfig_lang.php")) {
	include_once("components/com_recommend/lang/$mosConfig_lang.php");
} else {
	include_once("components/com_recommend/lang/english.php");
}

// Find out $Itemid
$database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_recommend'");
$base_url = "index.php?option=com_recommend&amp;Itemid=" . $database->loadResult();	// Base URL string
?>

<!-- Recommend Mambo Component by Emir Sakic, http://www.sakic.net-->

<script type="text/javascript">
<!--
function recommendvalidate(){
	if ((document.recommend.recommend_from_email.value=='') || (document.recommend.recommend_to_email.value=='')){
		alert('<?php echo _RMC_ALERT_FIELDS; ?>');
		return false;
	} else {
		return true;
	}
}
//-->
</script>

<table width="100%" cellpadding="4" cellspacing="4" border="0" align="center" class="contentpane">
	<tr>
		<td><span class="contentheading"><?php echo _RMC_TITLE; ?></span></td>
	</tr>
	<tr>
    <td><br />
      <?php

$recommend_option = mosGetParam( $_REQUEST, 'recommend_option', '' );

switch($recommend_option) {
	case "send":
		$recommend_to_email = mosGetParam( $_REQUEST, 'recommend_to_email', '' );
		$recommend_from_name = mosGetParam( $_REQUEST, 'recommend_from_name', '' );
		$recommend_from_email = mosGetParam( $_REQUEST, 'recommend_from_email', '' );
		$recommend_text = mosGetParam( $_REQUEST, 'recommend_text', '' );
		if (NotValidEmail($recommend_to_email)) {
			echo "<SCRIPT> alert('" . _RMC_ALERT_EMAIL . "'); window.history.go(-1); </SCRIPT>\n";
			exit;
		} else {
			sendmail($recommend_from_name, $recommend_from_email, $recommend_to_email, $recommend_text);
		}
		break;
	default:
		if (isset($my->id) && $my->id!="") {
			$query = "SELECT name, email FROM #__users WHERE id='$my->id'";
			$database->setQuery($query);
			$rows = $database->loadObjectList();
			$row = $rows[0];
			$recommend_from_name = $row->name;
			$recommend_from_email = $row->email;
		} else {
			$recommend_from_name = "";
			$recommend_from_email = "";
		}
	?>
      <form name="recommend" method="post" action="<? echo $base_url; ?>" onsubmit="return recommendvalidate()">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td nowrap="nowrap"><?php echo _RMC_YOUR_NAME; ?>&nbsp;</td>
            <td><input name="recommend_from_name" type="text" class="inputbox" value="<?php echo $recommend_from_name; ?>" /></td>
          </tr>
          <tr>
            <td nowrap="nowrap">*&nbsp;<?php echo _RMC_YOUR_EMAIL; ?>&nbsp;</td>
            <td><input name="recommend_from_email" type="text" class="inputbox" value="<?php echo $recommend_from_email; ?>" /></td>
          </tr>
          <tr>
            <td nowrap="nowrap">*&nbsp;<?php echo _RMC_FRIENDS_EMAIL; ?>&nbsp;</td>
            <td><input name="recommend_to_email" type="text" class="inputbox" /></td>
          </tr>
          <tr>
            <td nowrap="nowrap"><?php echo _RMC_MESSAGE; ?>&nbsp;</td>
            <td><textarea name="recommend_text" id="recommend_text" class="inputbox" rows="3" cols="25"></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="recommend_option" type="hidden" id="recommend_option" value="send" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="<?php echo _RMC_SEND; ?>" class="button" /></td>
          </tr>
        </table>
      </form>
      <?
		break;
}
?>
    </td>
	</tr>
</table>
<div align="center" class="small"><font color="#999999">Recommend v<?php echo $recommend_version?>. Copyright &copy; 2003-2006 by
<a href="http://www.sakic.net" target="_blank">Sakic.Net</a>.</font></div>

<!-- Recommend Mambo Component by Emir Sakic, http://www.sakic.net-->

<?php
	function sendmail($recommend_from_name, $recommend_from_email, $recommend_to_email, $recommend_text){
		global $database, $recommend_from_sender, $mosConfig_sitename, $mosConfig_live_site, $mosConfig_fromname, $mosConfig_mailfrom;
		if (isset($recommend_from_email) && $recommend_from_email != "" && isset($recommend_to_email) && $recommend_to_email != ""){
			if (isset($recommend_from_name) && $recommend_from_name != "") {
				$frname = $recommend_from_name;
			} else {
				$frname = $recommend_from_email;
			}
				$subject = $frname . " " . _RMC_INVITES_YOU . " " . $mosConfig_sitename;

			$text = _RMC_HELLO . "\n\n";
			$text .= $frname . " (" . $recommend_from_email . ") " . _RMC_INVITES_YOU . " " . $mosConfig_sitename . "\n";
			$text .= _RMC_GO_TO . " " . $mosConfig_live_site . "\n\n";
			if (isset($recommend_text) && $recommend_text != "")
				$text .= $frname . " " . _RMC_TELLS_YOU . "\n" . $recommend_text . "\n";
			$text .= "------------------------------------------\n";
			$text .= "Recommend Component (http://www.sakic.net)";

			if ($recommend_from_sender == 0) {
				$from =  "\"$mosConfig_fromname\" <$mosConfig_mailfrom>";
				$reply = $recommend_from_email;
			} else {
				$from = $recommend_from_name . " <" . $recommend_from_email . ">";
			}

			if (@mail($recommend_to_email, $subject, $text,
			           "From: " . $from . "\n"
			          . "Reply-To: " . $reply . "\n"
			          . "X-Mailer: PHP/" . phpversion())) {?>
<center>
<?php echo _RMC_SUCCESS; ?>
<br />
<br />[ <a href="javascript:history.go(-1)"><?php echo _RMC_BACK; ?></a> ]</center>
	  	  <?php } else {?>
<center>
<?php echo _RMC_FAILURE; ?>
<br />
<br />[ <a href="javascript:history.go(-1)"><?php echo _RMC_BACK; ?></a> ]</center>
	  	  <?php }
	    }
	}

	function NotValidEmail($email) {
		if (eregi("^([._a-z0-9-]+[._a-z0-9-]*)@(([a-z0-9-]+\.)*([a-z0-9-]+)(\.[a-z]{2,4}))$", $email)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
?>