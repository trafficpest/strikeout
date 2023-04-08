<?php

$path_to_root = '.';
require_once $path_to_root.'/inc/session.php';
include $path_to_root.'/inc/ui/header.php';

?>

<div class="container bg-light shadow rounded mt-5 w-80">
  <?include $path_to_root.'/inc/ui/create-invoice-form.php'?>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>
