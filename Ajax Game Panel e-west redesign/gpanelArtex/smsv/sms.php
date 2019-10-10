<?php
include "db.php";
  $billing_reports_enabled = true;
  $secret = '5230fa1a3f850882a3dac799e0c8474c';
  if(empty($secret) || !check_signature($_GET, $secret)) {
    header("HTTP/1.0 404 Not Found");
    die("Error: Invalid signature");
  }
  $sender = $_GET['sender'];
  $message = $_GET['message'];
  $message_id = $_GET['message_id'];
  $country = $_GET['country'];
  $price = $_GET['price'];
  $currency = $_GET['currency'];
  $shortcode = $_GET['shortcode'];
  $operator = $_GET['operator'];
  $billing_type = $_GET['billing_type'];
  $status = $_GET['status'];
  $username = $_GET['message'];
  $revenue = $_GET['revenue'];
  $keyword = $_GET['keyword'];

$user = mysql_query("SELECT `username` FROM `klijenti` WHERE `username`='{$username}'");
if(preg_match("/failed/i", $_GET['status'])){
$updejt = mysql_query("UPDATE billing_sms set status='".$status."' WHERE message_id='".$message_id."'");
}
if(preg_match("/OK/i", $_GET['status'])){
$updejt2 = mysql_query("UPDATE billing_sms set status='".$status."' WHERE message_id='".$message_id."'");
}
if(preg_match("/MO/i", $_GET['billing_type']) && preg_match("/pending/i", $_GET['status'])) {
$baza = mysql_query("INSERT INTO billing_sms SET sender='".$sender."', message='".$message."',`time` = '".time()."',revenue='".$revenue."',billing_type='".$billing_type."',message_id='".$message_id."',username='".$username."',keyword='".$keyword."',country='".$country."',price='".$price."',currency='".$currency."',shortcode='".$shortcode."',status='".$status."',operator='".$operator."'");
  if($currency == "MKD"){
	  $novacplus = $price / 62.5;
	  $fee = 0.00 * $novacplus;
	  $novacplus = round($novacplus - $fee,2);
	  if (mysql_num_rows($user) == 0)
      {
	  echo "Takav username ne postoji u bazi. Цена: $price MKD by Fortumo.com, Support: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
	  die();
      }
	  $upis = mysql_query("UPDATE `klijenti` SET `novac`=`novac`+'{$novacplus}' WHERE `username`='{$username}'");  
	  $reply = "You purchased credits Цена:$price MKD on $message account by Fortumo.com Подршка: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
      echo($reply);	
} else if($currency == "EUR"){
	  $novacplus = $price;
	  if (mysql_num_rows($user) == 0)
      {
	  echo "That username don't exist in database. Цена: $price eur by Fortumo.com, Support: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
	  die();
      }
	  $upis = mysql_query("UPDATE `klijenti` SET `novac`=`novac`+'{$novacplus}' WHERE `username`='{$username}'");
	  if($country == "DE"){
      $reply = "Du hast E-West Hosting Bon fur preis:$novacplus eur gekauft fur $message nalog by Fortumo.com Support: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
	  } else {
	  $reply = "Na $message eWest račun je dodano $novacplus EUR by Fortumo.com, Support https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
	  }
      echo($reply);	  
}else if($currency == "BAM"){
	  if (mysql_num_rows($user) == 0)
      {
	  echo "Takav username ne postoji u bazi. Cena: $price BAM + PDV by Fortumo.com, Support: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
	  die();
      } 
	  $novacplus = $price / 1.959;
	  $upis = mysql_query("UPDATE `klijenti` SET `novac`=`novac`+'{$novacplus}' WHERE `username`='{$username}'");  
	  $reply = "Na $message eWest račun je dodano $price BAM. Cijena poruke je $price BAM + PDV by Fortumo.com, Podrska: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
  echo($reply);
  }
  }

  if(preg_match("/MT/i", $_GET['billing_type']) && preg_match("/pending/i", $_GET['status'])) {
$baza = mysql_query("INSERT INTO billing_sms SET sender='".$sender."', message='".$message."',`time` = '".time()."',revenue='".$revenue."',billing_type='".$billing_type."',message_id='".$message_id."',username='".$username."',keyword='".$keyword."',country='".$country."',price='".$price."',currency='".$currency."',shortcode='".$shortcode."',status='".$status."',operator='".$operator."'");
 if($currency == "RSD"){
	  $novacplus = $price / 123.322645;
	  $fee = 0.00 * $novacplus;
	  $novacplus = round($novacplus - $fee,2);
	  if (mysql_num_rows($user) == 0)
      {
	  echo "Takav username ne postoji u bazi. Cena: $price RSD + 1 Standard SMS by Fortumo.com, Podrska: https://ewest-hosting.info/ , cvrle.biznis@gmail.com";
	  die();
      }
	  $upis = mysql_query("UPDATE `klijenti` SET `novac`=`novac`+'{$novacplus}' WHERE `username`='{$username}'");  
	  $reply = "Upravo ste kupili E-West Hosting bon za $price RSD + 1 Standard SMS Hvala! by Fortumo.com Podrska: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
  echo($reply);
  } else if($currency == "HRK"){
	  $novacplus = $price / 7.53401;
	  $fee = 0.00 * $novacplus;
	  $novacplus = round($novacplus - $fee,2);
	  if (mysql_num_rows($user) == 0)
      {
	  echo "Takav username ne postoji u bazi. Cijena: $price HRK by Fortumo.com, Podrska: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
	  die();
      }
	  $upis = mysql_query("UPDATE `klijenti` SET `novac`=`novac`+'{$novacplus}' WHERE `username`='{$username}'");  
	  $reply = "Kupili ste E-West Hosting bon za $price HRK Hvala vam! by Fortumo.com, Podrska: https://ewest-hosting.info/ , cvrle.biznis@gmail.com";
  echo($reply);
  } else if($currency == "BAM"){
	  if (mysql_num_rows($user) == 0)
      {
	  echo "Takav username ne postoji u bazi. Cena: $price BAM + PDV by Fortumo.com, Podrska: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
	  die();
      } 
	  $novacplus = $price / 1.959;
	  $upis = mysql_query("UPDATE `klijenti` SET `novac`=`novac`+'{$novacplus}' WHERE `username`='{$username}'");  
	  $reply = "Na $message eWest račun je dodano $price BAM. Cijena poruke je $price BAM + PDV by Fortumo.com, Podrska: https://ewest-hosting.info/ , cvrle.biznis@gmail.com,";
  echo($reply);
  } 
}
function check_signature($params_array, $secret) {
    ksort($params_array);
    $str = '';
    foreach ($params_array as $k=>$v) {
      if($k != 'sig') {
        $str .= "$k=$v";
      }
    }
    $str .= $secret;
    $signature = md5($str);
    return ($params_array['sig'] == $signature);
  }
?>