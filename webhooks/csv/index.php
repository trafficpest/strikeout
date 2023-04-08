<?php


$path_to_root = '../..';
require_once $path_to_root.'/inc/session.php';
require_once $path_to_root.'/webhooks/csv/inc/csv.php';

$csv_file = './payments.csv';
$csv_data = get_csv_file($csv_file);
?>


<?include $path_to_root.'/inc/ui/header.php'?>
<div class="container bg-light shadow rounded mt-5 w-80">
<div class="p-3">
<h1>Download CSV</h1>
<a href="<?=$csv_file?>">CSV File</a>
</div>
</div>


<div class="container bg-light shadow rounded mt-5 w-80">
<div class="table-responsive" style="max-height: 800px;">
<table class="table">
<?php
echo '<tr>';
foreach ($csv_data[0] as $header => $value){
  echo '<th>'.$header.'</th>';
  }
echo '</tr>'."\r\n";
foreach ($csv_data as $row){
echo '<tr>';
foreach ($row as $col){
  echo '<td>'.$col.'</td>';
  }
echo '</tr>'."\r\n";
}
?>
</table>
</div>
</div>
<?include $path_to_root.'/inc/ui/footer.php'?>
