<?php

$path_to_root = '.';
require_once $path_to_root.'/inc/session.php';

?>

<?include $path_to_root.'/inc/ui/header.php'?>

<div class="container bg-light p-4 text-center shadow rounded mt-5">
<h1 class="text-uppercase">Welcome</h1>
<h3 class="text-muted pb-4"><?=$strikeout['payee_name']?></h3>

<hr class="hr" />
<h3>Payment Methods</h3>
<? include $path_to_root.'/inc/ui/create-method-index.php'?>

<hr class="hr" />
<h3>Webhook Plugins</h3>
<? include $path_to_root.'/inc/ui/create-webhook-index.php'?>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>

