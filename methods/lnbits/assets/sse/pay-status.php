<?php 

$path_to_root = '../../../..';
$path_to_lnbits = '../..';

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/lnbits.log');
require $path_to_root.'/inc/strikeout.php';
require $path_to_lnbits.'/inc/lnbits.php';

$strikeout = load_strikeout_config($path_to_root.'/config/config.php');
$lnbits = load_lnbits_config($path_to_lnbits.'/config/config.php');

header('Content-Type: text/event-stream'); 
header('Cache-Control: no-cache');

$invoice_info = check_lnbits_invoice($_GET['invoiceId']);

if ( isset($invoice_info['paid']) ){
  if ($invoice_info['paid'] == true){
    echo "data:".'PAID'."\n\n"; 
  }
}

flush();

?>

