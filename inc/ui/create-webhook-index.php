<?php 
$col=0;
  foreach(glob($path_to_root.'/webhooks/*', GLOB_ONLYDIR) as $dir) {
    $col++;
    if ($col <= 1){
      echo '<div class="row mb-3">'."\r\n";
    }
    echo '<div class="text-white col bg-secondary pt-3 mx-2 shadow rounded">';
    include $dir.'/inc/ui/index-menu.php';
    echo '</div>'."\r\n";
    if ($col >= 3){
      echo '</div>'."\r\n";
      $col=0;
    }
  }
if ($col != 0) { 
  for($col; $col <= 2; $col++){
    echo '<div class="col">';
    echo '</div>'."\r\n";
  }
  echo '</div>'."\r\n"; 
}

?>
