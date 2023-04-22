<?php

$path_to_root = '../..';
$path_to_csv = '.';

require_once $path_to_root.'/inc/session.php';
require_once $path_to_csv.'/inc/csv.php';

$csv_file = $path_to_csv.'/private/payments.csv';
$csv_data = get_csv_file($csv_file);

if ( isset($_POST['downloadCsv']) ){
  download_file($csv_file);
}
?>

<?include $path_to_root.'/inc/ui/header.php'?>
<div class="container bg-light shadow rounded mt-5 w-80">
<?include $path_to_csv.'/inc/ui/download-form.php'?>
</div>

<div class="container bg-light shadow rounded mt-5 w-80">
<?include $path_to_csv.'/inc/ui/create-csv-table.php'?>
</div>

<?include $path_to_root.'/inc/ui/footer.php'?>
