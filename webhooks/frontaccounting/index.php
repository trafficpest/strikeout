<?php

$path_to_root = '../..';
$path_to_fa = $path_to_root.'/webhooks/frontaccounting';

require_once $path_to_root.'/inc/session.php';
require_once $path_to_fa.'/inc/fa.php';

$db_config_file = $path_to_fa.'/config/db-config.php';
if (isset($_POST['dbConfigForm'])){
  $db = update_db_config($db_config_file);
}else{ $db = load_db_config($db_config_file); }

$fa_config_file = $path_to_fa.'/config/fa-config.php';
if (isset($_POST['faConfigForm'])){
  $fa = update_fa_config($fa_config_file);
}else{ $fa = load_fa_config($fa_config_file); }

$fa_users = get_fa_users();
$bank_accts = get_fa_bank_accts();
$fa_coa = get_fa_coa();

?>

<?include $path_to_root.'/inc/ui/header.php'?>
<div class="row">
<div class="container bg-light shadow rounded mt-5 w-80"
     style="max-width: 480px;">
<?include $path_to_fa.'/inc/ui/db-config-form.php'?>
</div>

<div class="container bg-light shadow rounded mt-5 w-80"
     style="max-width: 480px;">
<?
if ($fa_users[0] === 'ERROR'){
  //Database connection error
  echo '<h3 class="p-3">Unable to connect to FA Database</h3>';
} elseif ($fa_users === '0 results'){
  //No company data found in database
  echo '<h3 class="p-3">Database Connected:</h3>'
    .'<p class="p-3">No company found. Is Table Pref correct?</p>';
}else {
  //database and company found
  include $path_to_fa.'/inc/ui/fa-config-form.php';
}
?>

</div>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>
