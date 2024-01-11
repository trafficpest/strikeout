<?php

$path_to_root = '../../..';
$path_to_stripe = '..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_stripe.'/inc/stripe.php';

$stripe = load_stripe_config($path_to_stripe.'/config/config.php');

$response = list_stripe_webhooks();

print_r($response);

echo '<br><br>';
print_r($response['data'][0]['enabled_events'][0]);
?>
