<?php

$path_to_root = '..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_root.'/inc/strike.php';

if ( isset($_POST['createSubcription']) ) {
  create_strike_subsrciption($_POST['webhookUrl']);
}

if ( isset($_GET['deleteSubscription']) ) {
  delete_strike_subscriptions($_GET['deleteSubscription']);
}


?>

<?include $path_to_root.'/inc/ui/header.php'?>

<div class="container bg-light shadow rounded mt-5 w-80">
  <?include $path_to_root.'/inc/ui/create-sub-form.php'?>
</div>
<div class="container bg-light shadow rounded mt-5 w-80">
  <?include $path_to_root.'/inc/ui/available-webhooks.php'?>
</div>
<div class="container bg-light shadow rounded mt-5 w-80">
  <?include $path_to_root.'/inc/ui/webhooks-table.php'?>
</div>


<?include $path_to_root.'/inc/ui/footer.php'?>
