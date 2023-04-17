<?php

$path_to_root = '..';

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/csv.log');

require_once $path_to_root.'/inc/strike.php';
require_once './csv/inc/csv.php';

date_default_timezone_set( $config['timezone'] );

if (check_strike_signature()){

  $webhook_data = json_decode(file_get_contents("php://input"), true);

  if ($webhook_data['eventType'] == 'invoice.updated'){
    
    $strike_invoice = find_strike_invoice( $webhook_data['data']['entityId'] );
    if ($strike_invoice['state'] == 'PAID'){
  
     $header_line = array(
        'Date',
        'CorrelationId',
        'Amount',
        'Currency',
        'State',
        'InvoiceId',
        'Description'
      );


      $csv_line = array(
        date('Y-m-d'), 
        $strike_invoice['correlationId'],
        $strike_invoice['amount']['amount'],
        $strike_invoice['amount']['currency'],
        $strike_invoice['state'],
        $strike_invoice['invoiceId'],
        $strike_invoice['description']
      );

      append_csv_file('./csv/payments.csv',$csv_line, $header_line);
      
     }
  }
}
