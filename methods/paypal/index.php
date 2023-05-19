<?php

$path_to_root = '../..';
$path_to_pp = '.';

require_once $path_to_pp.'/inc/paypal.php';
$strikeout = load_strikeout_config($path_to_root.'/config/config.php');

//Use url variables first if available
if ( isset($_GET['amount']) ){ $_POST['amount'] = $_GET['amount']; }
if ( isset($_GET['name']) ) {$_POST['name'] = $_GET['name']; }
if ( isset($_GET['custId']) ) {$_POST['custId'] = $_GET['custId']; }
if ( isset($_GET['action_url']) ) {$_POST['action_url'] = $_GET['action_url']; }

// Set Action Url from default config if not set
if (empty($_POST['action_url'])){$_POST['action_url']=$strikeout['action_url'];}
if ( empty($_POST['custId']) ){$_POST['custId'] = 'No Reference';}

// error if amount wasn't set
if ( empty( $_POST['amount'] ) ){
  echo '<center><h2>No invoice amount was set!</h2></center>';
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=$path_to_root?>/assets/css/checkout.css">
  </head>
  <body>
    <div id="strikeout-button-container">
  <?include $path_to_pp.'/inc/ui/checkout-button.php'?>
    </div>
  </body>
</html>

