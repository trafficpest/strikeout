<?php

$path_to_root = '..'; $path_to_fa = './frontaccounting';

require_once $path_to_root.'/inc/strike.php';
require_once $path_to_fa.'/inc/payments.php';
require_once $path_to_fa.'/inc/fa.php';

$config = load_config($path_to_root.'/config.php');
$db = load_db_config($path_to_fa.'/db-config.php');
$fa = load_fa_config($path_to_fa.'/fa-config.php');

if (check_strike_signature()){

  $webhook_data = json_decode(file_get_contents("php://input"), true);

  if ($webhook_data['eventType'] == 'invoice.updated'){
    
    $strike_invoice = find_strike_invoice( $webhook_data['data']['entityId'] );
    if ($strike_invoice['state'] == 'PAID'){
    //code will go here
    $tax_id = explode('|', $strike_invoice['correlationId']);
    enter_fa_payment($tax_id[0], $strike_invoice['amount']['amount']);

    }
  }
}
    
//enter_fa_payment(21333, 50);

    $strike_invoice = find_strike_invoice( '8af4d6f1-81ee-4578-bb93-1e6ba41d4f87' );
    $tax_id = explode('|', $strike_invoice['correlationId']);

?> 
