<?php

$path_to_root = '..';
$path_to_strike = '..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_root.'/inc/strikeout.php';

if (isset($_POST['configForm'])){
  $strikeout = update_strikeout_config(
    $path_to_root.'/config/config.php',
  );
}
if (isset($_GET['deleteQr'])){
 array_map('unlink', glob($path_to_root.'/'.$strikeout['tmp_dir'].'/*.png'));
}
if ( isset($_POST['setPermissions']) ){
  set_so_permissions($path_to_root);
}
if ( isset($_POST['activatePlugin']) ){
  save_plugin_config($path_to_root.'/config/methods.php');
}
?>

<?include $path_to_root.'/inc/ui/header.php'?>

<div class="container bg-light shadow rounded mt-5 mb-3">
<?include $path_to_root.'/inc/ui/perms-form.php'?>
</div>

<div class="container bg-secondary shadow rounded p-3">
<h1 class="text-center text-white p-1">Configuration</h1>
<div class="row">
<div class="col-md-12 col-lg-6 mb-3">
<?include $path_to_root.'/inc/ui/configure-form.php'?>
</div>
<div class="col-md-12 col-lg-6">
<?include $path_to_root.'/inc/ui/activate-methods-form.php'?>
</div>
</div>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>

