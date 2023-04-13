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
    //code goes here
      $correlation = explode('|', $strike_invoice['correlationId']);
      if ($fa['acct_option'] == 'tax_id'){
        fa_payment_by_taxid(
                            $correlation[0], 
                            $strike_invoice['amount']['amount']
                           );
      }
      if ($fa['acct_option'] == 'debtor_no'){
        fa_payment_by_debtor(
                             $correlation[0], 
                             $strike_invoice['amount']['amount']
                            );
      }
      if ($fa['acct_option'] == 'invoice'){
        fa_payment_by_invoice(
                              $correlation[0], 
                              $strike_invoice['amount']['amount']
                            );
      }
      if ($fa['acct_option'] == 'bank_deposit'){
        fa_bank_deposit($strike_invoice['amount']['amount']);
      }
    }
  }
}
?> 
