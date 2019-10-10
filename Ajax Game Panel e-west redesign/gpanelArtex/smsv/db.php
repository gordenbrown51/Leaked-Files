<?php
$dbhost = 'localhost';
$dbuser = 'gpanel';
$dbpass = '5X6eAcA1kM';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db( 'gpanel' );
?>