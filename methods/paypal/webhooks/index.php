<?php

$path_to_root = '../../..';
$path_to_pp = '..';

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/paypal.log');

require_once $path_to_root.'/inc/strikeout.php';
require_once $path_to_pp.'/inc/paypal.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$paypal = load_pp_config($path_to_pp.'/config/config.php');

date_default_timezone_set( $strikeout['timezone'] );

if ( check_paypal_signature() ){
  //code goes here
}else{
  error_log('The webhook signature didnt pass. If your webhook id is set'
    .' correctly then you received a false message');
}

//verify the message is signed with your secret
/*
if (check_paypal_signature()){
  $webhook_data = json_decode(file_get_contents("php://input"), true);
  
  if ($webhook_data['eventType'] == 'invoice.updated'){
    // code ran when invoice is updates
  
    $strike_invoice = find_strike_invoice( $webhook_data['data']['entityId'] );
    if ($strike_invoice['state'] == 'PAID'){
      // if invoice update was a payment
      $active_plugins = load_config($path_to_strike.'/config/plugins.php');
      $method = 'paypal'; 
      $correlation = explode('|', $strike_invoice['correlationId']);
      $plugin_payload = array(
        'Date' => date('Y-m-d'),
        'Reference' => $correlation[0],
        'Correlation ID' => $correlation[1],
        'Amount' => $strike_invoice['amount']['amount'],
        'Currency' => $strike_invoice['amount']['currency'],
        'State' => $strike_invoice['state'],
        'Invoice ID' => $strike_invoice['invoiceId'],
        'Description' => $strike_invoice['description'],
      );

      w
        w
      w
      foreach($active_plugins as $plugin => $status){
        if ($status == 'on'){
          include $path_to_root.'/webhooks/'.$plugin.'.php';
        }
        ini_set('error_log', $path_to_root.'/logs/strike.log');
        //return log to strike
      }
    }
  }

  if ($webhook_data['eventType'] == 'invoice.created'){
  // Add code here for invoice created events 

  }
}
 */ 
?>
