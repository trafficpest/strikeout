<?php

function load_config($config_file, $config=null) {
  
// If config file exists, return the config array
  if (file_exists($config_file)) {

    include $config_file;
    return $config;

  } else {
    // If config file does not exist, create it with default values
    // from the $config arg if null log and return null

   if (is_null($config)){ 
    error_log('$config array was not set prior to creating');
    return null;
   }

   $config_string = '<?php'
     ."\n\n".'$config = ' . var_export($config, true) . ';';
    file_put_contents($config_file, $config_string);
    chmod( $config_file, 0640);

    // Return the config array
    return $config;
  }
}

function update_config($config_file, $config=null) {
  //update config_file with $config array if array is not set it
  //will log and return null
  if (is_null($config)){
    error_log('$config array was not set prior updating');
    return null;
  }
  $config_string = '<?php'
    ."\n\n".'$config = ' . var_export($config, true) . ';';
  file_put_contents($config_file, $config_string);
  chmod( $config_file, 0640);
  return $config;
}

function load_plugin_config($file){
  if (file_exists($file)) {

    include $file;
    return $config;
  }
}

function save_plugin_config($file){
  $config = update_config($file, $_POST);
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

?>
