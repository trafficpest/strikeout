<?php

$path_to_root = '../../../..';
$path_to_pp = '../..';

require_once $path_to_pp.'/inc/paypal.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$paypal = load_pp_config($path_to_pp.'/config/config.php');

$post_data = json_decode(file_get_contents("php://input"), true);

if (isset($post_data['orderID'])){

  $access_token = generate_pp_access_token();

  $url = 'https://api-m.paypal.com/v2/checkout/orders/'
    .$post_data['orderID'].'/capture';

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$access_token,
    'Content-Type: application/json',
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  echo $response;
}

?>
