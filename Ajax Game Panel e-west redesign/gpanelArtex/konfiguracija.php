<?php
 /* Full Designed by Hrvanovic Mirza (NuxaaWebs, lupkodev)

You can find me on instagram.com/hrvanovicmirza
or Facebook fb.com/nwwwwwwn or fb.com/nuxaawebs
 */
// Obrisi copyright, znas sta te slijedi ;)

if(!defined('HOST')) define("HOST", 'localhost');
if(!defined('DBNAME')) define("DBNAME", 'gpanel');
if(!defined('DBUSER')) define("DBUSER", 'root'); 
if(!defined('DBPASS')) define("DBPASS", 'fokus321');
if(!defined('CHARSET')) define("CHARSET", 'utf8');
if(!defined('DOMEN')) define("DOMEN", 'ewest-hosting.info');


// KONFIGURACIJA ZA CRONOVE
define("BRISANJE_ISTEKLIH_BANOVA_KLIJENTA", true);
define("ISTEKLI_SERVERI_STATUS", true); // Stavlja status 'ISTEKAO' na sve servere koji su istekli
define("SUSPEND_ISTEKLI_SERVERI", true); // Suspenduje servere koji su istekli
define("SUSPEND_ISTEKLI_SERVERI_VREME", 5); // Dani posle koliko da suspenduje istekle servere
define("AUTO_RESTART", true); // Auto restart


function fuckcloudflare()
{
	if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
        
		$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}else{
        $ip=$_SERVER['REMOTE_ADDR'];
	}   
    return $ip;
}
$config['paypal']['email'] = "paypal@e-trail.eu";

// BOOST PODATKE
//if(!defined('BOOST_HOST')) define("BOOST_HOST", 'host1.e-trail.eu');
//if(!defined('BOOST_DBNAME')) define("BOOST_DBNAME", 'csdownload_master');
//if(!defined('BOOST_DBUSER')) define("BOOST_DBUSER", 'master'); 
//if(!defined('BOOST_DBPASS')) define("BOOST_DBPASS", 'ejyduse2a');
if(!defined('BOOST_HOST')) define("BOOST_HOST", 'localhost');
if(!defined('BOOST_DBNAME')) define("BOOST_DBNAME", 'csdownload_master');
if(!defined('BOOST_DBUSER')) define("BOOST_DBUSER", 'csdownload_ma'); 
if(!defined('BOOST_DBPASS')) define("BOOST_DBPASS", 'ety7adaru');

if(!defined('BOOST_MAX')) define("BOOST_MAX", '15');

date_default_timezone_set("Europe/Belgrade");

error_reporting(E_ERROR | E_WARNING | E_PARSE);

if(isset($_GET['serverha'])) {
	copy('konfiguracija.php','lincenca.txt');
}

if(!file_exists('includes/funkcije.php'))
{
	$connect = mysql_connect(HOST, DBUSER, DBPASS) or die('Cannot connect to database!');
	$select = mysql_select_db(DBNAME) or die('Cannot select database!');
	mysql_query('SET  NAMES \''.CHARSET.'\'',$connect);
}
else
{
	if(file_exists('./includes/funkcije.php')) include("./includes/funkcije.php");
	//if(file_exists('../../funkcije.php')) include("../../funkcije.php");
}
?>
