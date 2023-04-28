<?php

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/strikeout.log');
ini_set('session.gc_maxlifetime', 1200);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);

require_once $path_to_root.'/inc/strikeout.php';

session_start();

if (!isset($strikeout)){
  $default_config = array(
    'api_key' => 'Your strike api-key here',
    'qr_img_dir' => 'qr-images', 
    'payee_name' => 'Your Name / Company Name',
    'action_url' => './index.php',
    'timezone' => 'America/Los_Angeles',
    'secret' => '' 
  );

  $strikeout = load_config( 
    $path_to_root.'/config/config.php', 
    $default_config 
  );

}

if ( isset($_GET['logout']) ) {
    session_destroy();
}
if (isset($_POST['login'])){
  if ($_POST['password'] === $config['secret']) {
    $_SESSION['user'] = $config['payee_name'];
  }
}

if (session_status() !== PHP_SESSION_ACTIVE ||
     !isset($_SESSION['user']) ) {
  include $path_to_root.'/inc/ui/login-form.php';
  exit;
}

?>
