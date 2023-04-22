<?php

$path_to_root = '..';
require_once $path_to_root.'/inc/session.php';

if (isset($_POST['configForm'])){
  $config = update_config($path_to_root.'/config/config.php');
}
if (isset($_GET['deleteQr'])){
  array_map('unlink', glob($path_to_root.'/'.$config['qr_img_dir'].'/*.png'));
}
if ( isset($_POST['setPermissions']) ){
  set_so_permissions($path_to_root);
}
?>

<?include $path_to_root.'/inc/ui/header.php'?>

<div class="container bg-light shadow rounded mt-5 w-80">
<?include $path_to_root.'/inc/ui/so-perms-form.php'?>
</div>

<div class="container bg-light shadow rounded mt-5 w-80">
<?include $path_to_root.'/inc/ui/configure-form.php'?>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>

