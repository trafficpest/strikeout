<?php

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/strikeout.log');
ini_set('session.gc_maxlifetime', 1200);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);

require_once $path_to_root.'/inc/strikeout.php';

session_start();

if (!isset($strikeout)){
  $strikeout = load_strikeout_config($path_to_root.'/config/config.php');
}

if ( isset($_GET['logout']) ) {
    session_destroy();
}
if (isset($_POST['login'])){
  if ($_POST['password'] === $strikeout['password']) {
    $_SESSION['user'] = $strikeout['payee_name'];
  }
}

if (session_status() !== PHP_SESSION_ACTIVE ||
     !isset($_SESSION['user']) ) {
  include $path_to_root.'/inc/ui/login-form.php';
  exit;
}

?>
