<?php

$path_to_root = '../..';
$path_to_csv = '.';

require_once $path_to_root.'/inc/session.php';
require_once $path_to_csv.'/inc/csv.php';

if ( isset($_POST['selectCsvForm']) && ($_POST['selectCsv'] !== '') ){
  $csv_file = $path_to_csv.'/private/'.$_POST['selectCsv'];
  if (isset($_POST['displayTable'])){
  $csv_data = get_csv_file($csv_file);
  }
  if (isset($_POST['deleteFile'])){
  unlink($csv_file);
  }
  if (isset($_POST['downloadFile'])){
  download_file($csv_file);
  $csv_data = get_csv_file($csv_file);
  }
}


?>

<?include $path_to_root.'/inc/ui/header.php'?>

<h1 class="text-white p-3">CSV</h1>
<div class="container mt-5 bg-secondary rounded p-3 mb-3">  
  <div class="row">
    <div class="col-12 col-md-6 mb-3">
      <?include $path_to_csv.'/inc/ui/select-csv-form.php'?>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <?include $path_to_csv.'/inc/ui/create-csv-table.php'?>
    </div>
  </div>
</div>

</div>
<?include $path_to_root.'/inc/ui/footer.php'?>
