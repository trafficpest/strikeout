<?php

$path_to_root = '..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_root.'/inc/phpqrcode/qrlib.php';

?>

<?include $path_to_root.'/inc/ui/header.php'?>

<div class="container mt-5">
  <div class="row">
    <div class="col-12 col-md-6">
      <?include $path_to_root.'/inc/ui/create-invoice-form.php'?>
    </div>
    <div class="col-12 col-md-6">
      <?include $path_to_root.'/inc/ui/static-invoice-form.php'?>
    </div>
  </div>
</div>
<?include $path_to_root.'/inc/ui/static-invoice.php'?>



<?include $path_to_root.'/inc/ui/footer.php'?>
