<?php

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/paypal.log');

include_once $path_to_pp.'/config/paypal-config.php';

$baseURL = array(
  'sandbox' => 'https://api-m.sandbox.paypal.com',
  'production' => 'https://api-m.paypal.com'
);

function create_paypal_order($post_data) {
  $access_token = generate_pp_access_token();

  $json = json_encode($post_data);

  $url = 'https://api-m.sandbox.paypal.com/v2/checkout/orders';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$access_token,
    'Content-Type: application/json',
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function capture_pp_payment($order_id){

  $access_token = generate_pp_access_token();

  $url = 'https://api-m.sandbox.paypal.com/v2/checkout/orders/'
    .$order_id.'/capture';

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$access_token,
    'Content-Type: application/json',
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function generate_pp_access_token() {
  global $config;
  
  $post_data = 'grant_type=client_credentials';

  $auth = base64_encode($config['CLIENT_ID'].':'.$config['APP_SECRET']);

  $url = 'https://api-m.sandbox.paypal.com/v1/oauth2/token';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic '.$auth,
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response['access_token'];

}

?>
