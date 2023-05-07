<?php

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/paypal.log');

require_once $path_to_root.'/inc/strikeout.php';

function set_pp_permissions($path_to_pp){
  
  $dirs = array(
    $path_to_pp.'/config' => 0750,
    $path_to_pp.'/inc' => 0750,
  );

  update_file_permissions($dirs);
}

function load_pp_config($file){
  
  $default_config = array(
      'CLIENT_ID' => 'Your strike api key here', 
      'APP_SECRET' => 'Your name / company name here',
      'WEBHOOK_ID' => 'Webhook ID from your Active Subscriptions',
    );

  $config = load_config($file, $default_config);
  return $config;
}

function update_pp_config($file){

    $config = array( 
      'CLIENT_ID' => $_POST['clientId'], 
      'APP_SECRET' => $_POST['appSecret'],
      'WEBHOOK_ID' => $_POST['webhookId'],
    );
  
  update_config($file, $config);
  return $config;
}
/*
$baseURL = array(
  'sandbox' => 'https://api-m.sandbox.paypal.com',
  'production' => 'https://api-m.paypal.com'
);*/

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

function create_pp_webhook($webhook_url){

  $post_data = array(
    'url' => $webhook_url,
    'event_types' => array(
      array(
        'name' => '*',
      ),
    ),
  );

  $json = json_encode($post_data);

  $access_token = generate_pp_access_token();

  $url = 'https://api-m.sandbox.paypal.com/v1/notifications/webhooks';

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$access_token,
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function list_pp_webhooks(){

  $access_token = generate_pp_access_token();

  $url = 'https://api-m.sandbox.paypal.com/v1/notifications/webhooks';

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$access_token,
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function delete_pp_webhook($webhook_id){

  $access_token = generate_pp_access_token();

  $url = 'https://api-m.sandbox.paypal.com/v1/notifications/webhooks/'
    .$webhook_id;

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$access_token,
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function show_pp_webhook($webhook_id){

  $access_token = generate_pp_access_token();

  $url = 'https://api-m.sandbox.paypal.com/v1/notifications/webhooks/'
    .$webhook_id;

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$access_token,
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function generate_pp_access_token() {
  global $paypal;

  $post_data = 'grant_type=client_credentials';

  $auth = base64_encode($paypal['CLIENT_ID'].':'.$paypal['APP_SECRET']);

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

function check_paypal_signature(){
  global $paypal;

   $post_data = array(
    'auth_algo' => $_SERVER['HTTP_PAYPAL_AUTH_ALGO'],
    'cert_url' => $_SERVER['HTTP_PAYPAL_CERT_URL'],
    'transmission_id' => $_SERVER['HTTP_PAYPAL_TRANSMISSION_ID'],
    'transmission_sig' => $_SERVER['HTTP_PAYPAL_TRANSMISSION_SIG'],
    'transmission_time' => $_SERVER['HTTP_PAYPAL_TRANSMISSION_TIME'],
    'webhook_id' => $paypal['WEBHOOK_ID'],
    'webhook_event' => json_decode(file_get_contents("php://input")),
  );

  $json = json_encode($post_data);

  $access_token = generate_pp_access_token();

  $url = 'https://api-m.sandbox.paypal.com'
    .'/v1/notifications/verify-webhook-signature';

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$access_token,
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);
  if ($response['verification_status'] == 'SUCCESS'){ return true; }
  else { return false; }
}
?>
