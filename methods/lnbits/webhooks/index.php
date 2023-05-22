<?php

$path_to_root = '../../..';
$path_to_lnbits = '..';

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/lnbits.log');

require_once $path_to_root.'/inc/strikeout.php';
require_once $path_to_lnbits.'/inc/lnbits.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$lnbits = load_lnbits_config($path_to_lnbits.'/config/config.php');

date_default_timezone_set( $strikeout['timezone'] );

//no way to verify the message?, Checking the payment ourselves

$webhook_data = json_decode(file_get_contents("php://input"), true);
$invoice_info = check_lnbits_invoice($webhook_data['payment_hash']);

  if ($invoice_info['paid'] == true){
    // code ran when invoice is paid 
    // values are in millisats hence /1000
  
      $active_plugins = load_config($path_to_lnbits.'/config/plugins.php');
      $method = 'lnbits'; 
      $memo = json_decode($invoice_info['details']['memo'], true);
      $plugin_payload = array(
        'Date' => date('Y-m-d'),
        'Reference' => $memo['Ref'],
        'Correlation ID' => $invoice_info['details']['payment_hash'],
        'Amount' => $memo['Amount'],
        'Fee' => '0.00',
        'Net' => $memo['Amount'],
        'Currency' => 'USD',
        'State' => 'PAID',
        'Item Received' => 'BTC',
        'Quantity' => $invoice_info['details']['amount']/1000,
        'Rate' => round($memo['Amount']/($invoice_info['details']['amount']/1000), 10),
        'Location' => $invoice_info['details']['wallet_id'],
        'Invoice ID' => $invoice_info['details']['bolt11'],
        'Description' => $memo['Memo'],
      );

      foreach($active_plugins as $plugin => $status){
        if ($status == 'on'){
          include $path_to_root.'/webhooks/'.$plugin.'.php';
        }
        ini_set('error_log', $path_to_root.'/logs/strike.log');
        //return log to strike
      }
    }
 
  
?>
