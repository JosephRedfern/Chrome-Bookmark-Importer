<?php
//Chrome bookmark import script by Joseph Redfern (joseph [at] redfern [dot] me, http://redfern.me/)
//
//This script takes bookmarks which have been exported by Chromium/Google Chrome, and imports them into a mysql database. It might also work for other browsers, but that is untested.
//I wrote this to test the feasability of a larger project that I am planning on starting.
//
//I license the code I have written under the GNU General Public License - However, file "simple_html_dom.php" is licensed under the MIT license.
//
//(I didn't have to do much work for this, it was pretty much all done for my by the guys that wrote the "PHP Simple HTML DOM parser"!)

$server = ""; //mysql server
$username = ""; //mysql username
$password = ""; //mysql password
$database = ""; //mysql database name

$filename = ""; //Name of the file which is to be imported, relative to the location of this script.

//End configurables

include_once('simple_html_dom.php'); //include the "PHP Simple HTML DOM Parser".
$conn = mysql_connect($server, $username, $password);//connect to mysql server
mysql_select_db("bookmark", $conn); //select database


$html = file_get_html($filename); //load bookmark file

foreach($html->find('a') as $a){ //for each hyperlink in the html file, extract the 
		$query = "INSERT INTO `bookmarks`(`bid`, `url`, `title`) VALUES(NULL, '".mysql_real_escape_string($a->href)."', '".mysql_real_escape_string($a->innertext)."')"; // query insert values into mysql db, escape strings just in case.
		
		if(!mysql_query($query)){ //if failes, notify of error.
			print "Error occurred during the database insertion process.";
		}
}
?>