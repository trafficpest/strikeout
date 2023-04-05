<?php

function load_config( $configFile ) {
  
  if (file_exists($configFile)) {
      // If config file exists, return the config array
    include $configFile;
    return $config;
  } else {
      // If config file does not exist, create it with default values
    $config = array(
      'api_key' => 'Your strike api-key here',
      'qr_img_dir' => './qr-images/', 
      'payee_name' => 'Your Name / Company Name',
      'action_url' => './index.php',
      'timezone' => 'America/Los_Angeles',
      'secret' => '' 
    );
    
    $configString = '<?php $config = ' . var_export($config, true) . ';';
    file_put_contents($configFile, $configString);
    chmod( $configFile, 0600);

      // Return the config array
      return $config;
  }
}

function update_config( $configFile ) {

  $config = array(
  'api_key' => $_POST['apiKey'],
  'qr_img_dir' => $_POST['qrDir'], 
  'payee_name' => $_POST['payeeName'],
  'action_url' => $_POST['actionUrl'],
  'timezone' => $_POST['timezoneSelect'],
  'secret' => $_POST['secret'] 
);

  $configString = '<?php $config = ' . var_export($config, true) . ';';
  file_put_contents($configFile, $configString);
  chmod( $configFile, 0640);
  return $config;
}

?>
