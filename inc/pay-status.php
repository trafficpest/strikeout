<?php 

$path_to_root = '..';
require $path_to_root.'/inc/strike.php';

header('Content-Type: text/event-stream'); 
header('Cache-Control: no-cache');

$invoice_status = find_strike_invoice( $_GET['invoiceId'] );

echo "data:".$invoice_status['state']."\n\n"; 

flush();


?>
