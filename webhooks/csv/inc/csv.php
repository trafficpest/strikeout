<?php

ini_set('error_log', $path_to_root.'/logs/csv.log');
require_once $path_to_root.'/webhooks/csv/inc/download.php';

function append_csv_file( $file, $csv_line, $header_line ){
  // csv_line and header_line should be arrays

  // create file with first row if it doesnt exist
  if ( !is_file($file) ){
    $csvfile = fopen($file, 'w') 
      or die("Unable to open file!");

        fputcsv($csvfile, $header_line);
    fclose($csvfile);
  }
  // append row to end of file    
  $csvfile = fopen( $file, 'a') 
    or die("Unable to open file!");

  fputcsv($csvfile, $csv_line);
  fclose($csvfile);
}

function get_csv_file($file){
  // csv_line and header_line should be arrays

  // create file with first row if it doesnt exist
  if ( !is_file($file) ){
    $data[] = 'No CSV data available';
    return $data;
  }
    $rows   = array_map('str_getcsv', file($file));
    $header = array_shift($rows);
    $csv    = array();
    foreach($rows as $row) {
        $csv[] = array_combine($header, $row);
    }
  return $csv;
}

?>
