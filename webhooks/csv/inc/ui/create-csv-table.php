<div class="table-responsive" style="max-height: 800px;">
<table class="table";
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
