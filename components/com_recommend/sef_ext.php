<?php
/**
* SEF advance component extension
*
* This extension will give the SEF advance style URLs to the recommend component
* Place this file (sef_ext.php) in the main component directory
* Note that class must be named: sef_componentname
*
* Copyright (C) 2003-2004 Emir Sakic, http://www.sakic.net, All rights reserved.
*
* Comments: for SEF advance > v3.6
**/

class sef_recommend {

	/**
	* Creates the SEF advance URL out of the Mambo request
	* Input: $string, string, The request URL (index.php?option=com_recommend&Itemid=$Itemid)
	* Output: $sefstring, string, SEF advance URL ($var1/$var2/)
	**/
	function create ($string) {
		$sefstring = "";
		return $sefstring;
	}

	/**
	* Reverts to the Mambo query string out of the SEF advance URL
	* Input:
	*    $url_array, array, The SEF advance URL split in arrays (first custom virtual directory beginning at $pos+1)
	*    $pos, int, The position of the first virtual directory (component)
	* Output: $QUERY_STRING, string, Mambo query string (var1=$var1&var2=$var2)
	*    Note that this will be added to already defined first part (option=com_recommend&Itemid=$Itemid)
	**/
	function revert ($url_array, $pos) {
		$QUERY_STRING = "";
		return $QUERY_STRING;
	}

}
?>