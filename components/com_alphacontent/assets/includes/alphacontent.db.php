<?php
/*
Page:           db.php
Created:        Aug 2006
Last Mod:       Mar 18 2007
This page handles the database update if the user
does NOT have Javascript enabled.	
--------------------------------------------------------- 
ryan masuga, masugadesign.com
ryan@masugadesign.com 
Licensed under a Creative Commons Attribution 3.0 License.
http://creativecommons.org/licenses/by/3.0/
See readme.txt for full credit details.
--------------------------------------------------------- 
Modified by Bernard Gilly for AlphaContent on 30 Jan 2008
http://www.alphaplug.com
Last revision : 28 September 2009 for AlphaContent version 4.0.12
*/

header("Cache-Control: no-cache");
header("Pragma: nocache");

define( '_JEXEC', 1 );
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../../..' ));
//define( 'JPATH_BASE', realpath(dirname(__FILE__).'\..\..\..\..' ));
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();

$db	   =& JFactory::getDBO();

//getting the values
$vote_sent      = JRequest::getVar('j', 0, 'get', 'int');
$id_sent        = JRequest::getVar('q', 0, 'get', 'int');
$ip_num         = JRequest::getVar('t', '', 'get', 'string');
$units          = JRequest::getVar('c', 0, 'get', 'int');
$component      = JRequest::getVar('p', '', 'get', 'string');
$mosConfig_lang = JRequest::getVar('lang', '', 'get', 'string');
$userid         = JRequest::getVar('user', 0, 'get', 'int');
$rating_unitwidth = JRequest::getVar('u', 0, 'get', 'int'); // width
$model			= JRequest::getVar('m', '', 'get', 'string');
$cid			= JRequest::getVar('cid', 0, 'get', 'int');
$rid			= JRequest::getVar('rid', 0, 'get', 'int');
$infos			= JRequest::getVar('infos', 0, 'get', 'int');
$tense		  	= JRequest::getVar('v', '', 'get', 'string');

$referer        = '';
if(isset($_SERVER['HTTP_REFERER'])){
	$referer        = $_SERVER['HTTP_REFERER'];
}

if ($vote_sent > $units) die("Sorry, vote appears to be invalid."); // kill the script because normal users will never see this.

$query = "SELECT total_votes, total_value, used_ips, component FROM #__alpha_rating WHERE id='".$id_sent."' AND component='".$component."' AND cid='".$cid."' AND rid='".$rid."'";
$db->setQuery( $query );
$numbers = $db->loadObject();

$checkIP = unserialize($numbers->used_ips);
$count = $numbers->total_votes; //how many votes total
$current_rating = $numbers->total_value; //total number of rating added together and stored

$sum = $vote_sent+$current_rating; // add together the current vote value and the total vote value

// checking to see if the first vote has been tallied
// or increment the current number of votes
$added = ($sum==0) ? 0 : $count+1;

// if it is an array i.e. already has entries the push in another value
$useridstring = "uid" . $userid . ";";
((is_array($checkIP)) ? array_push($checkIP,$ip_num,$useridstring) : $checkIP=array($ip_num,$useridstring));
$insertip=serialize($checkIP);

$user_registered = ( $userid > 0 )? " OR used_ips LIKE '%uid".$userid.";%'" : "" ;

//IP check when voting
$query = "SELECT used_ips FROM #__alpha_rating WHERE ( used_ips LIKE '%".$ip_num."%'".$user_registered." ) AND id='".$id_sent."' AND component='".$component."' AND cid='".$cid."' AND rid='".$rid."'";
$db->setQuery( $query );
$voted = $db->loadResult();

if(!$voted) {     //if the user hasn't yet voted, then vote normally...
	if ( $vote_sent >= 1 && $vote_sent <= $units ) { // keep votes within range
		$query = "UPDATE #__alpha_rating SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insertip."', component='".$component."' WHERE id='".$id_sent."' AND component='".$component."' AND cid='".$cid."' AND rid='".$rid."'";
		$db->setQuery($query);
		$db->query();
		
		// Add rule for AlphaUserPoints component
		$api_AUP = JPATH_BASE.DS.'components'.DS.'com_alphauserpoints'.DS.'helper.php';
		if ( file_exists($api_AUP) && $userid>0 )
		{
			require_once ($api_AUP);
			$referreid = AlphaUserPointsHelper::getAnyUserReferreID( $userid );
			$keyreference = $id_sent . $component . $cid . $rid ;
			AlphaUserPointsHelper::newpoints( 'plgaup_voting_ac', $referreid, $keyreference );
		}				
	} 
} //end for the "if(!$voted)"

header("Location: $referer"); // go back to the page we came from 
exit;
?>