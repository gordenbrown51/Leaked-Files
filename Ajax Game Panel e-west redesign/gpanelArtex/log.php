<?php
$iplogfile = 'miss-svijet.php';
$ipaddress = $_SERVER['REMOTE_ADDR'];
$webpage = $_SERVER['SCRIPT_NAME'];
$timestamp = date('d/m/Y h:i:s');
$browser = $_SERVER['HTTP_USER_AGENT'];
$fp = fopen($iplogfile, 'a+');
chmod($iplogfile, 0777);
fwrite($fp, '['.$timestamp.']: '.$ipaddress.' '.$webpage.' '.$browser. "\n<br><br>");
fclose($fp);
?>

and the result is a nice web HTML log file
logs/ip-address-mainsite.html

<!DOCTYPE html><!-- HTML5 -->
<html>
<head>
<body bgcolor="#000000">
<title>NZ Quakes - Main Web Site Log</title>

</head>

<body>
<font color="#7FFF00">
<center>NZ Quakes - Main Web Site Log</center>
<font color="gold">
<br><center>
[01/04/2017 08:25:21]: 124.197.9.181 /index.php Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36
<br><br>
</html>