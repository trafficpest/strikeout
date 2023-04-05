<?php

$path_to_root = '..';
include_once $path_to_root.'/inc/strike.php';
include_once $path_to_root.'/inc/csv.php';

date_default_timezone_set( $config['timezone'] );

if (check_strike_signature()){

  $webhook_data = json_decode(file_get_contents("php://input"), true);

  if ($webhook_data['eventType'] == 'invoice.updated'){
    
    $strike_invoice = find_strike_invoice( $webhook_data['data']['entityId'] );
    if ($strike_invoice['state'] == 'PAID'){
      
      $csv_line = array(
        date('Y-m-d'), 
        $strike_invoice['correlationId'],
        $strike_invoice['amount']['amount'],
        $strike_invoice['amount']['currency'],
        $strike_invoice['state'],
        $strike_invoice['invoiceId'],
        $strike_invoice['description']
      );

      append_payment_csv('./csv/payments.csv',$csv_line);
      
     }
  }
}
