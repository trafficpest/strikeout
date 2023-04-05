<?php

$path_to_root = '.';
require_once $path_to_root.'/inc/session.php';

if (isset($_POST['configForm'])){
      $config = update_config( $path_to_root.'/config.php' );
}

include $path_to_root.'/inc/ui/header.php';
include $path_to_root.'/inc/ui/configure-form.php';
include $path_to_root.'/inc/ui/footer.php';
?>

