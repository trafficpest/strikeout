<?php 
$col=0;
  foreach(glob($path_to_root.'/webhooks/*', GLOB_ONLYDIR) as $dir) {
    $col++;
    if ($col <= 1){
      echo '<div class="row p-2">'."\r\n";
    }
    echo '<div class="col text-center">';
    include $dir.'/inc/ui/index-menu.php';
    echo '</div>'."\r\n";
    if ($col >= 3){
      echo '</div>'."\r\n";
      $col=0;
    }
  }
if ($col != 0) { 
  for($col; $col <= 2; $col++){
    echo '<div class="col text-center">';
    echo '</div>'."\r\n";
  }
  echo '</div>'."\r\n"; 
}

?>
