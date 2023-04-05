<?php

require_once $path_to_root.'/inc/configure.php';

ini_set('session.gc_maxlifetime', 1200);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
session_start();

if (!isset($config)){
  $config = load_config( $path_to_root.'/config.php' );
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
  include $path_to_root.'/inc/ui/password-form.php';
  exit;
}


?>
