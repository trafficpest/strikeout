<?php

$path_to_root = '../../../..';
$path_to_stripe = '../..';

require_once $path_to_stripe.'/inc/stripe.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$stripe = load_stripe_config($path_to_stripe.'/config/config.php');

error_log(file_get_contents("php://input"));
$post_data = json_decode(file_get_contents("php://input"), true);

//if (isset($post_data['strikeout']['amount'])){
  $post_data = array(
    'amount' => 500,
    'currency' => 'USD',
  );
  $response = create_stripe_payment_intent($post_data);

  $output = [
    'clientSecret' => $response['client_secret'],
  ];

  echo json_encode($output);
//}

?>
