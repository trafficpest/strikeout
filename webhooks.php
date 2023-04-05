<?php

$path_to_root = '.';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_root.'/inc/strike.php';

if ( isset($_POST['createSubcription']) ) {
  create_strike_subsrciption($_POST['webhookUrl']);
}

if ( isset($_GET['deleteSubscription']) ) {
delete_strike_subscriptions($_GET['deleteSubscription']);
}

include $path_to_root.'/inc/ui/header.php';
include $path_to_root.'/inc/ui/create-sub-form.php';
include $path_to_root.'/inc/ui/webhooks-table.php';
include $path_to_root.'/inc/ui/footer.php';

?>
