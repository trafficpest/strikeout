<?php

require_once $path_to_root.'/inc/configure.php';

function set_lnbits_permissions($path){
  
  $dirs = array(
    $path.'/config' => 0750,
    $path.'/inc' => 0750,
  );

  update_file_permissions($dirs);
}

function load_lnbits_config($file){

  $default_config = array(
      'lnbits_url' => 'Your lnbits url', 
      'read_key' => 'Your wallet invoice/read key', 
      'webhook_url' => '', 
    );

  $config = load_config($file, $default_config);
  return $config;
}

function update_lnbits_config($file){

    $config = array( 
      'lnbits_url' => $_POST['lnbits_url'], 
      'read_key' => $_POST['read_key'],
      'webhook_url' => $_POST['webhook_url'],
    );
  
  update_config($file, $config);
  return $config;
}

function issue_lnbits_invoice($amount, $customer_name, $ref){
  
  if (empty ($customer_name) ){
    $customer_name = 'Customer';
  }

  global $strikeout, $lnbits;
  $memo = array(
    'Memo' => 'Payment to '.$strikeout['payee_name']                 
              .' from '.$customer_name,
    'Ref' => $ref,
    'Amount' => $amount,
  );

  $post_data = array(
    'out' => false,
    'amount' => $amount,
    'memo' => json_encode($memo),
  //'expiry' => 600,
    'unit' => 'USD',
  //'internal' => false,
  );

  if ( !empty($lnbits['webhook_url']) ){
  $post_data['webhook'] = $lnbits['webhook_url'];
  }

   
  $json = json_encode($post_data); 

  $url = $lnbits['lnbits_url'].'/api/v1/payments';
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Api-Key: '.$lnbits['read_key'],
    'Content-type: application/json',
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}


function check_lnbits_invoice($payment_hash){

  global $lnbits;  

  $url = $lnbits['lnbits_url'].'/api/v1/payments/'.$payment_hash;
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Api-Key: '.$lnbits['read_key'],
    'Content-type: application/json',
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($response , true);

  return $response;
}
/*
function check_lnbits_signature($payment_hash){

  global $lnbits;
  
  //pull the record yourself to verify
  $lnbits_invoice = check_lnbits_invoice($payment_hash);
  $req_signature = $_SERVER['HTTP_X_WEBHOOK_SIGNATURE']; 
  $json_payload = file_get_contents("php://input");
  $my_signature = strtoupper( hash_hmac('sha256', $json_payload, $secret) );

  if ($req_signature == $my_signature){
    return true;
  }
    return false;
}
 */
?>
