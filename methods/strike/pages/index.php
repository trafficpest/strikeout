<?php

$path_to_root = '../../..';
$path_to_strike = '..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_strike.'/inc/strike.php';
require_once $path_to_root.'/inc/phpqrcode/qrlib.php';

$strike = load_strike_config($path_to_strike.'/config/config.php');

if (isset($_POST['configForm'])){
  $strike = update_strike_config(
    $path_to_strike.'/config/config.php',
  );
}

if ( isset($_POST['setPermissions']) ){
  set_strike_permissions($path_to_strike);
}

if ( isset($_POST['activatePlugin']) ){
  save_plugin_config($path_to_strike.'/config/plugins.php');
}

if ( isset($_POST['createSubcription']) ) {
  create_strike_subsrciption($_POST['webhookUrl']);
}

if ( isset($_GET['deleteSubscription']) ) {
  delete_strike_subscriptions($_GET['deleteSubscription']);
}
?>

<?include $path_to_root.'/inc/ui/header.php'?>
<h1 class="text-white p-3">Strike</h1>
<div class="container mt-5">
  <div class="row">
    <div class="col-12 mb-3">
    <?include $path_to_strike.'/inc/ui/perms-form.php'?>
    </div>
  </div>
</div>
<div class="container bg-secondary rounded p-3 mb-3">
<h1 class="text-center text-white p-1">Invoices</h1>
  <div class="row">
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_strike.'/inc/ui/create-invoice-form.php'?>
    </div>
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_strike.'/inc/ui/static-invoice-form.php'?>
    </div>
  </div>
  <div class="row">
    <div class="col-12 mb-3">
      <?include $path_to_strike.'/inc/ui/static-invoice.php'?>
    </div>
  </div>
</div>

<div class="container bg-secondary rounded p-3 mb-3">
<h1 class="text-center text-white p-1">Plugins</h1>
  <div class="row">
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_strike.'/inc/ui/create-sub-form.php'?>
    </div>
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_strike.'/inc/ui/activate-webhooks-form.php'?>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <?include $path_to_strike.'/inc/ui/webhooks-table.php'?>
    </div>
  </div>
</div>
<div class="container bg-secondary rounded p-3">
<h1 class="text-center text-white p-1">Configuration</h1>
  <div class="row">
    <div class="col-12 mb-3">
      <?include $path_to_strike.'/inc/ui/configure-form.php'?>
    </div>
  </div>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>

