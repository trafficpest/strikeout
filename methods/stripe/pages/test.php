<?php

$path_to_root = '../../..';
$path_to_stripe = '..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_stripe.'/inc/stripe.php';

$stripe = load_stripe_config($path_to_stripe.'/config/config.php');

$response = get_stripe_transaction('txn_3OXe3FIHV3zDeNmw1FbCgcpG');

print_r($response);

?>
