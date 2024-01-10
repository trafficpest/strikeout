<?php
// webhook needs work currently not finished
$path_to_root = '../../..';
$path_to_stripe = '..';

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/stripe.log');

require_once $path_to_root.'/inc/strikeout.php';
require_once $path_to_stripe.'/inc/stripe.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$stripe = load_stripe_config($path_to_stripe.'/config/config.php');

date_default_timezone_set( $strikeout['timezone'] );

if ( check_paypal_signature() ){
  $webhook_data = json_decode(file_get_contents("php://input"), true);
  
  if ($webhook_data['event_type'] == 'PAYMENT.CAPTURE.COMPLETED'){ 
    // code ran when invoice is updates
  
      $active_plugins = load_config($path_to_stripe.'/config/plugins.php');
      $method = 'stripe'; 
      $plugin_payload = array(
        'Date' => date('Y-m-d'),
        'Reference' => $webhook_data['resource']['custom_id'],
        'Correlation ID' => $webhook_data['resource']['id'],
        'Amount' => $webhook_data['resource']['seller_receivable_breakdown']['gross_amount']['value'],
        'Fee' => $webhook_data['resource']['seller_receivable_breakdown']['paypal_fee']['value'],
        'Net' => $webhook_data['resource']['seller_receivable_breakdown']['net_amount']['value'],
        'Currency' => $webhook_data['resource']['seller_receivable_breakdown']['gross_amount']['currency_code'],
        'State' => $webhook_data['resource']['status'],
        'Invoice ID' => $webhook_data['resource']['supplementary_data']['related_ids']['order_id'],
        'Description' => $webhook_data['summary'],
      );

      foreach($active_plugins as $plugin => $status){
        if ($status == 'on'){
          include $path_to_root.'/webhooks/'.$plugin.'.php';
        }
        ini_set('error_log', $path_to_root.'/logs/stripe.log');
        //return log to i
      }
  }
}else{
  error_log('The webhook signature didnt pass. If your webhook id is set'
    .' correctly then you received a false message');
}

?>
