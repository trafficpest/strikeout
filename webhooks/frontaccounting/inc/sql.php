<?php

function get_sql_data( $sqlquery ){
  global $db;

  // Create connection
  $conn = new mysqli( 
    $db['hostname'], $db['username'], $db['password'], $db['db_name']
  );

  // Check connection  
  if ($conn->connect_error) {
    $error[] = 'ERROR';
    $error[] = $conn->connect_error ;
    return $error;
  }

  $result = $conn->query( $sqlquery );
  
  if ($result->num_rows > 0) {

  // output data of each row
    for ($sqlreturned = array (); $row = $result->fetch_assoc(); $sqlreturned[] = $row);
    return $sqlreturned;
  } else {

    $sqlreturned = "0 results";
    return $sqlreturned;
  }
  
  $conn->close();
}

function post_sql_data( $sqlpost ){
  global $db;

  // Create connection
  $conn = new mysqli( 
    $db['hostname'], $db['username'], $db['password'], $db['db_name']
  );

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ( $conn->query( $sqlpost ) === TRUE) {
  } else {
    echo "Error: " . $sqlpost . "<br>" . $conn->error;
  }
  $conn->close();
}
