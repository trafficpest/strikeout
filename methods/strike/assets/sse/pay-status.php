<?php 

$path_to_root = '../../../..';
$path_to_strike = '../..';

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/strike.log');
require $path_to_root.'/inc/strikeout.php';
require $path_to_strike.'/inc/strike.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$strike = load_strike_config($path_to_strike.'/config/config.php');

header('Content-Type: text/event-stream'); 
header('Cache-Control: no-cache');

$invoice_status = find_strike_invoice( $_GET['invoiceId'] );

echo "data:".$invoice_status['state']."\n\n"; 

flush();


?>
