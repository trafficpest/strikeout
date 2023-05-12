<?php

$path_to_root = '.';

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/strikeout.log');
require_once $path_to_root.'/inc/strikeout.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');

//Use url variables first if available
if ( isset($_GET['amount']) ){ $_POST['amount'] = $_GET['amount']; }
if ( isset($_GET['name']) ) {$_POST['name'] = $_GET['name']; }
if ( isset($_GET['custId']) ) {$_POST['custId'] = $_GET['custId']; }
if ( isset($_GET['action_url']) ) {$_POST['action_url'] = $_GET['action_url']; }

// Set Action Url from default config if not set
if (empty($_POST['action_url'])){$_POST['action_url']=$strikeout['action_url'];}
if (empty($_POST['name'])){$_POST['name']=null;}
if (empty($_POST['custId'])){$_POST['custId']=null;}

// error if amount wasn't set
if ( empty( $_POST['amount'] ) ){
  echo '<center><h2>No invoice amount was set!</h2></center>';
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=$path_to_root?>/assets/css/checkout.css">
  </head>
  <body>
  <div id="strikeout-button-container">
  <h3>Select your payment method</h3>
<?php 
$active_methods = load_plugin_config($path_to_root.'/config/methods.php');

foreach($active_methods as $active_method => $status) {
  if ($status == 'on'){
    include $path_to_root.'/methods/'.$active_method.'/inc/ui/checkout-button.php';
  }
}

?>
</div>
  </body>
</html>

