<?php
// webhook needs work currently not finished
// needs signature proof and fees added
$path_to_root = '../../..';
$path_to_stripe = '..';

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/stripe.log');

require_once $path_to_root.'/inc/strikeout.php';
require_once $path_to_stripe.'/inc/stripe.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$stripe = load_stripe_config($path_to_stripe.'/config/config.php');

date_default_timezone_set( $strikeout['timezone'] );

$webhook_raw = file_get_contents("php://input");
  $webhook_data = json_decode($webhook_raw, true);
  
  if ($webhook_data['type'] == 'charge.succeeded'){ 
 error_log($webhook_raw);
    // code ran when invoice is updates
      $active_plugins = load_config($path_to_stripe.'/config/plugins.php');
      $method = 'stripe';
      if ($webhook_data['data']['object']['paid'] == 'true')
        {$pay_state = 'PAID';} else {$pay_state = 'UNPAID';}

      $plugin_payload = array(
        'Date' => date('Y-m-d'),
        'Reference' => $webhook_data['data']['object']['metadata']['custId'],
        'Correlation ID' => $webhook_data['id'],
        'Amount' => $webhook_data['data']['object']['metadata']['amount'],
        'Fee' => 0,
        'Net' => 0,
        'Currency' => strtoupper($webhook_data['data']['object']['currency']),
        'State' => $pay_state,
        'Invoice ID' => 'Need to add this',
        'Description' => 'Payment from '
          .$webhook_data['data']['object']['billing_details']['email'],
      );

      foreach($active_plugins as $plugin => $status){
        if ($status == 'on'){
          include $path_to_root.'/webhooks/'.$plugin.'.php';
        }
        ini_set('error_log', $path_to_root.'/logs/stripe.log');
        //return log to stripe
      }
  }
/*
}else{
  error_log('The webhook signature didnt pass. If your webhook id is set'
    .' correctly then you received a false message');
}
 */
?>
