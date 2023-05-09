<?php

ini_set('error_log', $path_to_root.'/logs/fa.log');

$path_to_fa = $path_to_root.'/webhooks/frontaccounting';

require_once $path_to_fa.'/inc/payments.php';
require_once $path_to_fa.'/inc/fa.php';

$db = load_db_config($path_to_fa.'/config/db-config.php');
$fa = load_fa_config($path_to_fa.'/config/'.$method.'-fa-config.php');

// check that config setting has been set for method first
foreach ($fa as $setting){
  if ($setting == ''){
    error_log('FA Config '.$setting.' was not set for '.$method.' had to exit');
    exit;
  }
}

if (isset ($plugin_payload['Amount']) ){
  if ($fa['acct_option'] == 'tax_id'){
    fa_payment_by_taxid(
                        $plugin_payload['Reference'], 
                        $plugin_payload['Amount']
                       );
  }
  if ($fa['acct_option'] == 'debtor_no'){
    fa_payment_by_debtor(
                        $plugin_payload['Reference'], 
                        $plugin_payload['Amount']
                        );
  }
  if ($fa['acct_option'] == 'invoice'){
    fa_payment_by_invoice(
                        $plugin_payload['Reference'], 
                        $plugin_payload['Amount']
                        );
  }
  if ($fa['acct_option'] == 'bank_deposit'){
    fa_bank_deposit($plugin_payload['Amount']);
  }
}
?> 
