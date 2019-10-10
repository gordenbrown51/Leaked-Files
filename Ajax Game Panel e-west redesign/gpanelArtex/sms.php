<?php

  //set true if you want to use script for billing reports
  //first you need to enable them in your account
  $billing_reports_enabled = false;



  // check the signature
  $secret = '54fa2ff8b7db0b8f65cfd30bd121e9fc'; // insert your secret between ''
  if(empty($secret) || !check_signature($_GET, $secret)) {
    header("HTTP/1.0 404 Not Found");
    die("Error: Invalid signature");
  }

  $sender = $_GET['sender'];
  $message = $_GET['message'];
  $message_id = $_GET['message_id'];//unique id


// only grant virtual credits to account, if payment has been successful.
 if(preg_match("/OK/i", $_GET['status'])
    || (preg_match("/MO/i", $_GET['billing_type']) && preg_match("/pending/i", $_GET['status']))) {
  //hint:use message_id to log your messages
  //additional parameters: country, price, currency, operator, keyword, shortcode
  // do something with $sender and $message
  $reply = "Thank you $sender for sending $message";

  // print out the reply
  echo($reply);
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