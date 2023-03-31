<?php

function append_payment_csv( $file, $csv_line ){

  // csv_line should be an array of items
  if ( !is_file($file) ){
    $csvfile = fopen($file, 'w') 
      or die("Unable to open file!");

    $header_line = array(
      'Date',
      'CorrelationId',
      'Amount',
      'Currency',
      'State',
      'InvoiceId',
      'Description'
    );

    fputcsv($csvfile, $header_line);
    fclose($csvfile);
  }
      
  $csvfile = fopen( $file, 'a') 
    or die("Unable to open file!");

  fputcsv($csvfile, $csv_line);
  fclose($csvfile);
}

?>
