<?php

$path_to_root = '../../..';
$path_to_pp = '..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_pp.'/inc/paypal.php';
require_once $path_to_root.'/inc/phpqrcode/qrlib.php';

$paypal = load_pp_config($path_to_pp.'/config/config.php');

if (isset($_POST['configForm'])){
  $paypal = update_pp_config(
    $path_to_pp.'/config/config.php',
  );
}

if ( isset($_POST['setPermissions']) ){
  set_pp_permissions($path_to_pp);
}

if ( isset($_POST['activatePlugin']) ){
  save_plugin_config($path_to_pp.'/config/plugins.php');
}

if ( isset($_POST['createSubcription']) ) {
  create_pp_webhook($_POST['webhookUrl']);
}

if ( isset($_GET['deleteSubscription']) ) {
  delete_pp_webhook($_GET['deleteSubscription']);
}
?>

<?include $path_to_root.'/inc/ui/header.php'?>
<h1 class="text-white p-3">PayPal</h1>
<div class="container mt-5">  
  <div class="row">
    <div class="col-12 mb-3">
    <?include $path_to_pp.'/inc/ui/perms-form.php'?>
    </div>
  </div>
</div>
<div class="container bg-secondary rounded p-3 mb-3">
  <h1 class="text-center text-white p-1">Invoices</h1>
  <div class="row">
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_pp.'/inc/ui/create-invoice-form.php'?>
    </div>    
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_pp.'/inc/ui/static-invoice-form.php'?>
    </div>
  </div>
  <div class="row">
    <div class="col-12 mb-3">
      <?include $path_to_pp.'/inc/ui/static-invoice.php'?>
    </div>
  </div>
</div>

<div class="container bg-secondary rounded p-3 mb-3">
<h1 class="text-center text-white p-1">Plugins</h1>
  <div class="row">
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_pp.'/inc/ui/create-sub-form.php'?>
    </div>
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_pp.'/inc/ui/activate-webhooks-form.php'?>
    </div>
  </div>
  <div class="row">
    <div class="col-12 mb-3">
      <?include $path_to_pp.'/inc/ui/webhooks-table.php'?>
    </div>
  </div>
</div>
 
<div class="container bg-secondary rounded p-3">
<h1 class="text-center text-white p-1">Configuration</h1>
 <div class="row">
    <div class="col-12 mb-3">
        <?include $path_to_pp.'/inc/ui/configure-form.php'?>
    </div>
  </div>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>

