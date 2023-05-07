<?php

ini_set('error_log', $path_to_root.'/logs/csv.log');

require_once $path_to_root.'/webhooks/csv/inc/csv.php';

if (isset ($plugin_payload) ){
  foreach ($plugin_payload as $key => $value){
    $header_line[] = $key;
    $csv_line[] = $value;
  }
  append_csv_file(
    $path_to_root.'/webhooks/csv/private/'.$method.'.csv',
    $csv_line, 
    $header_line
  );
}

?>
