<?php

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/stripe.log');

require_once $path_to_root.'/inc/strikeout.php';

function set_stripe_permissions($path_to_stripe){
  
  $dirs = array(
    $path_to_stripe.'/config' => 0750,
    $path_to_stripe.'/inc' => 0750,
  );

  update_file_permissions($dirs);
}

function load_stripe_config($file){
  
  $default_config = array(
      'PUB_KEY' => 'Your Stripe key here', 
      'PRI_KEY' => 'Your Stripe Secret here',
    );

  $config = load_config($file, $default_config);
  return $config;
}

function update_stripe_config($file){

    $config = array( 
      'PUB_KEY' => $_POST['PUB_KEY'], 
      'PRI_KEY' => $_POST['PRI_KEY'],
    );
  
  update_config($file, $config);
  return $config;
}

function create_stripe_payment_intent($post_data) {
  global $stripe;
  
  $query = http_build_query($post_data);

  $url = 'https://api.stripe.com/v1/payment_intents';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$stripe['PRI_KEY'],
    'Content-Type: application/x-www-form-urlencoded',
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function get_stripe_payment_intent($id) {
  global $stripe;
  
  $url = 'https://api.stripe.com/v1/payment_intents/'.$id;
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$stripe['PRI_KEY'],
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function create_stripe_webhook($webhook_url){
  global $stripe;

  $post_data = [
    'url' => $webhook_url,
    'enabled_events' => ['*'],
    ];
  $query = http_build_query($post_data);
  $url = 'https://api.stripe.com/v1/webhook_endpoints';

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$stripe['PRI_KEY'],
    'Content-Type: application/x-www-form-urlencoded',
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function list_stripe_webhooks(){
  global $stripe;

  $url = 'https://api.stripe.com/v1/webhook_endpoints';

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$stripe['PRI_KEY'],
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);
  return $response;
}

function delete_stripe_webhook($webhook_id){
  global $stripe;

  $url = 'https://api.stripe.com/v1/webhook_endpoints/'
    .$webhook_id;

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$stripe['PRI_KEY'],
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function get_stripe_transaction($trans_id){
  global $stripe;

  $url = 'https://api.stripe.com/v1/balance_transactions/'
    .$trans_id;

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$stripe['PRI_KEY'],
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

/*
function show_pp_webhook($webhook_id){

  $access_token = generate_pp_access_token();

  $url = 'https://api-m.paypal.com/v1/notifications/webhooks/'
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

  $url = 'https://api-m.paypal.com'
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
*/
?>
