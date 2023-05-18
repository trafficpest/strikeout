<?php

$path_to_root = '../..';
$path_to_fa = $path_to_root.'/webhooks/frontaccounting';

require_once $path_to_root.'/inc/session.php';
require_once $path_to_fa.'/inc/fa.php';

$db_config_file = $path_to_fa.'/config/db-config.php';
if (isset($_POST['dbConfigForm'])){
  $db = update_db_config($db_config_file);
}else{ $db = load_db_config($db_config_file); }


if (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] !== ''){
  //dont load or save config if method isnt selected
  $fa_config_file = $path_to_fa.'/config/'.$_POST['paymentMethod']
    .'-fa-config.php';
  if (isset($_POST['faConfigForm'])){
    $fa = update_fa_config($fa_config_file);
  }else{ $fa = load_fa_config($fa_config_file); }

  $fa_users = get_fa_users();
  $bank_accts = get_fa_bank_accts();
  $fa_coa = get_fa_coa();
}
?>

<?include $path_to_root.'/inc/ui/header.php'?>

<h1 class="text-white p-3">FrontAccounting</h1>
<div class="container mt-5 bg-secondary rounded p-3 mb-3">  
  <div class="row">
    <div class="col">
      <?include $path_to_fa.'/inc/ui/fa-install-info.php'?>
    </div>
  </div>
</div>
<div class="container mt-5 bg-secondary rounded p-3 mb-3">  
<h1 class="text-white text-center p-3">Configure</h1>
  <div class="row">
    <div class="col-12 col-md-6">
      <?include $path_to_fa.'/inc/ui/db-config-form.php'?>
    </div>
    <div class="col-12 col-md-6">
      <?include $path_to_fa.'/inc/ui/fa-config-select.php'?>
      <?include $path_to_fa.'/inc/ui/fa-config-form.php'?>
    </div>
  </div>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>
