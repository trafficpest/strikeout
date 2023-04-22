<?php

$path_to_root = '.';
require_once $path_to_root.'/inc/session.php';

?>

<?include $path_to_root.'/inc/ui/header.php'?>

<div class="container bg-light p-4 text-center shadow rounded mt-5 w-80">
<h1 class="text-uppercase">Welcome</h1>
<h3 class="text-muted pb-4"><?=$config['payee_name']?></h3>
<div class="row pt-4">
  <div class="col pt-3 mx-2 shadow rounded">
  <a href="<?=$path_to_root.'/pages/invoice.php'?>">
  <img src="<?=$path_to_root.'/assets/images/qr.png'?>" 
        alt="Invoices" 
        class="rounded img-fluid pb-2"></a>
  <p>Create Invoices</p>
  </div>
  <div class="col pt-3 mx-2 shadow rounded">
  <a href="<?=$path_to_root.'/pages/webhooks.php'?>">
  <img src="<?=$path_to_root.'/assets/images/webhook-icon.png'?>" 
        alt="Webhooks" 
        class="rounded img-fluid pb-2"></a>
  <p>Manage Webhooks</p>
  </div>
  <div class="col pt-3 mx-2 shadow rounded">
  <a href="<?=$path_to_root.'/pages/setup.php'?>">
  <img src="<?=$path_to_root.'/assets/images/settings.png'?>" 
        alt="Settings" 
        class="rounded img-fluid pb-2"></a>
  <p>Configure</p>
  </div>
</div>
<hr class="hr" />
<? include $path_to_root.'/inc/ui/create-plugin-index.php'?>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>

