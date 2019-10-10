<?php
$billing_reports_enabled = true;

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

  echo $sender;
  echo $message;
  echo $price;
  echo $_GET['amount'];
  echo $operator;
  echo $status;
  echo $username;
  echo "Kraj";