<?php

require_once($path_to_root.'/inc/configure.php');

function load_strikeout_config($file){

  $default_config = array(
    'tmp_dir' => 'tmp', 
    'payee_name' => 'Your Name / Company Name',
    'action_url' => './index.php',
    'timezone' => 'America/Los_Angeles',
    'password' => '' 
  );

  $strikeout = load_config( 
    $file, 
    $default_config 
  );
  
  return $strikeout;
}

function update_strikeout_config($file){

    $config = array( 
      'payee_name' => $_POST['payeeName'],
      'password' => $_POST['password'], 
      'tmp_dir' => $_POST['tmpDir'],
      'action_url' => $_POST['actionUrl'],
      'timezone' => $_POST['timezoneSelect'],
    );
  
  update_config($file, $config);
  return $config;
}

function set_so_permissions($path_to_root){
  
  $dirs = array(
    $path_to_root.'/config' => 0750,
    $path_to_root.'/inc' => 0750,
    $path_to_root.'/logs' => 0750,
    $path_to_root.'/webhooks/csv/inc' => 0750,
    $path_to_root.'/webhooks/csv/private' => 0750,
    $path_to_root.'/webhooks/frontaccounting/inc' => 0750,
    $path_to_root.'/webhooks/frontaccounting/config' => 0750,
    $path_to_root.'/methods/strike/config' => 0750,
    $path_to_root.'/methods/strike/inc' => 0750,
    $path_to_root.'/methods/paypal/config' => 0750,
    $path_to_root.'/methods/paypal/inc' => 0750,
  );

  update_file_permissions($dirs);
}

?>
