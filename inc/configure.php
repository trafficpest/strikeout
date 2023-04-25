<?php

function create_strikeout_config(){
  $config = array(
    'api_key' => 'Your strike api-key here',
    'qr_img_dir' => 'qr-images', 
    'payee_name' => 'Your Name / Company Name',
    'action_url' => './index.php',
    'timezone' => 'America/Los_Angeles',
    'secret' => '' 
  );

  return $config;
}

function load_config($config_file, $config=null) {
  
// If config file exists, return the config array
  if (file_exists($config_file)) {

    include $config_file;
    return $config;

  } else {
    // If config file does not exist, create it with default values
    // from the $config arg if null make strikeout config

   if (is_null($config)){ 
    $config = create_strikeout_config();
   }

    $config_string = '<?php $config = ' . var_export($config, true) . ';';
    file_put_contents($config_file, $config_string);
    chmod( $config_file, 0600);

    // Return the config array
    return $config;
  }
}

function update_config($config_file, $config=null) {
  //update config_file with $config array if array is not set it
  //will update it as a strikeout config
  if (is_null($config)){
    $config = array( 
      'api_key' => $_POST['apiKey'], 
      'qr_img_dir' => $_POST['qrDir'],
      'payee_name' => $_POST['payeeName'],
      'action_url' => $_POST['actionUrl'],
      'timezone' => $_POST['timezoneSelect'],
      'secret' => $_POST['secret'] 
    );
  }
  $config_string = '<?php $config = ' . var_export($config, true) . ';';
  file_put_contents($config_file, $config_string);
  chmod( $config_file, 0600);
  return $config;
}

function update_file_permissions($files){
  foreach ($files as $file => $perms){
      chmod ($file, $perms);
  }
}

function check_file_permissions($files){
  // check array of files to perms if all match return true
  foreach ($files as $file => $perms){
    if ( $perms !== (fileperms($file) & 0777) ){
      return false;
    }
  }
  return true;
}
function set_so_permissions($path_to_root){
  
  $dirs = array(
    $path_to_root.'/config' => 0750,
    $path_to_root.'/inc' => 0750,
    $path_to_root.'/logs' => 0750,
    $path_to_root.'/webhooks/csv/inc' => 0750,
    $path_to_root.'/webhooks/csv/private' => 0750,
    $path_to_root.'/webhooks/frontaccounting/inc' => 0750,
    $path_to_root.'/webhooks/frontaccounting/config' => 0750
  );

  update_file_permissions($dirs);
}

?>
