<?php

include_once $path_to_root.'/config.php';

function issue_strike_invoice(
    $charge_amount, 
    $customer_name = 'unknown',
    $correlationId = null
){

  $correlationId = $correlationId.'|'.uniqid();
  

  global $config;  

  $post_data = array(
    'correlationId' => $correlationId,
    'description' => 'Payment to '
                      .$config['payee_name']                 
                      .' from '
                      .$customer_name,
    'amount' => array(
      'currency' => 'USD',
      'amount' => $charge_amount
      )
    );
   
  $json = json_encode($post_data);

  $url = 'https://api.strike.me/v1/invoices';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer '.$config['api_key']
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}


function issue_strike_quote($invoiceId){

  global $config;  

  $url = 'https://api.strike.me/v1/invoices/'.$invoiceId.'/quote';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'Authorization: Bearer '.$config['api_key'],
    'Content-Length: 0'
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function find_strike_invoice( $invoiceId ){

  global $config;  

  $url = 'https://api.strike.me/v1/invoices/'.$invoiceId;
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'Authorization: Bearer '.$config['api_key']
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;


}

function create_strike_subsrciption( $json ){

  global $config;  

  $url = 'https://api.strike.me/v1/invoices/'.$invoiceId.'/quote';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'accept: application/json',
    'Authorization: Bearer '.$config['api_key']
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function check_strike_signature(){

  global $config;

  $secret = $config['secret'];
  $req_signature = $_SERVER['HTTP_X_WEBHOOK_SIGNATURE']; 
  $json_payload = file_get_contents("php://input");
  $my_signature = strtoupper( hash_hmac('sha256', $json_payload, $secret) );

  if ($req_signature == $my_signature){
    return true;
  }
    return false;
}
