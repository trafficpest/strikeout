<?php

$path_to_root = '../../../..';
$path_to_stripe = '../..';

require_once $path_to_stripe.'/inc/stripe.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$stripe = load_stripe_config($path_to_stripe.'/config/config.php');

//error_log(file_get_contents("php://input"));
$post_data = json_decode(file_get_contents("php://input"), true);

if (isset($post_data['strikeout']['amount'])){
  $post_data = array(
    'amount' => $post_data['strikeout']['amount']*100,
    'currency' => 'USD',
    'automatic_payment_methods' => array(
      'enabled' => 'true',
    ), 
    'metadata' => array(
      'amount' => $post_data['strikeout']['amount'],
      'custId' => $post_data['strikeout']['custId'],
      'name' => $post_data['strikeout']['name'],
      'action_url' => $post_data['strikeout']['action_url'],
    ),
  );
  $response = create_stripe_payment_intent($post_data);

  $output = [
    'clientSecret' => $response['client_secret'],
  ];

  echo json_encode($output);
}

?>
