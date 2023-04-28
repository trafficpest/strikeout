<?php

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/strike.log');

require_once $path_to_root.'/inc/configure.php';

function load_strike_config($file){
  $default_config = array(
    'hostname' => 'localhost',
    'username' => 'sql user here',
    'password' => 'password here',
    'db_name' => 'sql db name',
    'table_pref' => '0_'
  );

  $strike = load_config($file, $default_config);
  return $strike;
}

function update_strike_config($file){

    $config = array( 
      'api_key' => $_POST['apiKey'], 
      'qr_img_dir' => $_POST['qrDir'],
      'payee_name' => $_POST['payeeName'],
      'action_url' => $_POST['actionUrl'],
      'timezone' => $_POST['timezoneSelect'],
      'secret' => $_POST['secret'] 
    );
  
  update_config($file, $config);
  return $strike;
}

function issue_strike_invoice(
    $charge_amount, 
    $customer_name,
    $correlationId
){
  
  if (empty ($customer_name) ){
    $customer_name = 'Customer';
  }

  $correlationId = $correlationId.'|'.uniqid();
  
  global $strike;  

  $post_data = array(
    'correlationId' => $correlationId,
    'description' => 'Payment to '
                      .$strike['payee_name']                 
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
    'Authorization: Bearer '.$strike['api_key']
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}


function issue_strike_quote($invoiceId){

  global $strike;  

  $url = 'https://api.strike.me/v1/invoices/'.$invoiceId.'/quote';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'Authorization: Bearer '.$strike['api_key'],
    'Content-Length: 0'
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function find_strike_invoice( $invoiceId ){

  global $strike;

  $url = 'https://api.strike.me/v1/invoices/'.$invoiceId;
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'Authorization: Bearer '.$strike['api_key']
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;


}

function get_strike_subscriptions(){

  global $strike;  

  $url = 'https://api.strike.me/v1/subscriptions/';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'Authorization: Bearer '.$strike['api_key']
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;

}

function create_strike_subsrciption( $url ){

  global $strike;  

  $post_data = array(
    'webhookUrl' => $url,
    'webhookVersion' => 'v1',
    'secret' => $strike['secret'],
    'enabled' => true,
    'eventTypes' => array(
      'invoice.created',
      'invoice.updated'
    )
  );

  $json = json_encode($post_data);

  $url = 'https://api.strike.me/v1/subscriptions';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer '.$strike['api_key']
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}

function delete_strike_subscriptions($subscriptionId){

  global $strike;  

  $url = 'https://api.strike.me/v1/subscriptions/'.$subscriptionId;
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$strike['api_key']
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;

}

function check_strike_signature(){

  global $strike;

  $secret = $strike['secret'];
  $req_signature = $_SERVER['HTTP_X_WEBHOOK_SIGNATURE']; 
  $json_payload = file_get_contents("php://input");
  $my_signature = strtoupper( hash_hmac('sha256', $json_payload, $secret) );

  if ($req_signature == $my_signature){
    return true;
  }
    return false;
}

?>
