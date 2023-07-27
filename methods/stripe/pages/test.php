<?php

$path_to_root = '../../..';
$path_to_stripe = '..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_stripe.'/inc/stripe.php';
require_once $path_to_root.'/inc/phpqrcode/qrlib.php';

$stripe = load_stripe_config($path_to_stripe.'/config/config.php');

$post_data = array(
  'amount' => 500,
  'currency' => 'USD',
);

//$response = create_stripe_payment_intent($post_data);
$response = get_stripe_payment_intent('pi_3NYGf1IHV3zDeNmw14QBO2Yp');

print_r($response);
?>
