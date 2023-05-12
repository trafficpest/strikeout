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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" 
        crossorigin="anonymous">

  </head>
  <body>
  <div id="strikeout-button-container">
<?php 
$active_methods = load_plugin_config($path_to_root.'/config/methods.php');

foreach($active_methods as $active_method => $status) {
  if ($status == 'on'){
    include $path_to_root.'/methods/'.$active_method.'/inc/ui/checkout-button.php';
  }
}

?>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>

