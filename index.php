<?php

$path_to_root = '.';
require_once $path_to_root.'/inc/session.php';


?>

<?include $path_to_root.'/inc/ui/header.php'?>

<div class="container bg-light shadow rounded mt-5 w-80">
<h1 class="text-center pt-3">Welcome</h1>
<p class="text-center">Lets get you started</p>
<div class="row p-2">
  <div class="col text-center">
  <a href="<?=$path_to_root.'/pages/invoice.php'?>">
  <img src="<?=$path_to_root.'/assets/images/qr.png'?>" 
        alt="Invoices" 
        class="rounded img-fluid pb-2"></a>
  <p>Create Invoices</p>
  </div>
  <div class="col text-center">
  <a href="<?=$path_to_root.'/pages/webhooks.php'?>">
  <img src="<?=$path_to_root.'/assets/images/webhook-icon.png'?>" 
        alt="Webhooks" 
        class="rounded img-fluid pb-2"></a>
  <p>Manage Webhooks</p>
  </div>
  <div class="col text-center">
  <a href="<?=$path_to_root.'/pages/setup.php'?>">
  <img src="<?=$path_to_root.'/assets/images/settings.png'?>" 
        alt="Settings" 
        class="rounded img-fluid pb-2"></a>
  <p>Configure</p>
  </div>
</div>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>

