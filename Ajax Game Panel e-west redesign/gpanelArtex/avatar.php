<?php
session_start();

$naslov = "Avatar";
$fajl = "gp";
$return = "gp.php";
$ucp = "mh-topserveri";

include("includes.php");

if(empty($_GET['mode'])) die("Morate izabrati ?mode=XX");
if(empty($_GET['id'])) die("Morate izabrati &id=XX");

if($_GET['mode'] == "a")
{
	$id = mysql_real_escape_string($_GET['id']);
	$id = htmlspecialchars($id);
	if(!is_numeric($id)) die("(!) Greska");

	$query = mysql_query("SELECT avatar FROM admin WHERE id = '{$id}'");
	if(mysql_num_rows($query) != 1) die("Greska");

	$query = mysql_fetch_assoc($query);

	if($query['avatar'] == "no_avatar.png" || $query['avatar'] == "default.png")
	{
		$image = imagecreatefrompng("http://188.165.61.144/avatari/noavatar.png");
		header('Content-Type: image/png');
		imagepng($image);			
	}
	else
	{
		$ext = str_replace(".", "", $query['avatar']);

		$imagepath = "http://188.165.61.144/admin/avatari/{$id}.{$ext}";

		if($ext == "jpeg" || $ext == "jpg")
		{
			$image = imagecreatefromjpeg($imagepath);
			header('Content-Type: image/jpeg');
			imagejpeg($image);			
		}
		else if($ext == "png")
		{
			$image = imagecreatefrompng($imagepath);
			header('Content-Type: image/png');
			imagepng($image);				
		}
		else if($ext == "gif")
		{
			$image = imagecreatefromgif($imagepath);
			header('Content-Type: image/gif');
			imagegif($image);				
		}
	}
}
else if($_GET['mode'] == "c")
{
	$id = mysql_real_escape_string($_GET['id']);
	$id = htmlspecialchars($id);
	if(!is_numeric($id)) die("(!) Greska");

	$query = mysql_query("SELECT avatar FROM klijenti WHERE klijentid = '{$id}'");
	if(mysql_num_rows($query) != 1) die("Greska");

	$query = mysql_fetch_assoc($query);

	if($query['avatar'] == "no_avatar.png" || $query['avatar'] == "default.png")
	{
		$image = imagecreatefrompng("./avatari/noavatar.png");
		header('Content-Type: image/png');
		imagepng($image);			
	}
	else
	{
		$ext = str_replace(".", "", $query['avatar']);

		$imagepath = "./avatari/{$id}.{$ext}";

		if($ext == "jpeg" || $ext == "jpg")
		{
			$image = imagecreatefromjpeg($imagepath);
			header('Content-Type: image/jpeg');
			imagejpeg($image);			
		}
		else if($ext == "png")
		{
			$image = imagecreatefrompng($imagepath);
			header('Content-Type: image/png');
			imagepng($image);				
		}
		else if($ext == "gif")
		{
			$image = imagecreatefromgif($imagepath);
			header('Content-Type: image/gif');
			imagegif($image);				
		}
	}
}
?>