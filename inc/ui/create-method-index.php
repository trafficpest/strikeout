<?php 
$col=0;
$row=1;
  foreach(glob($path_to_root.'/methods/*', GLOB_ONLYDIR) as $dir) {
    $col++;
    if ($col <= 1){
      echo '<div class="row">'."\r\n";
      if ($row == 1){ 
      echo '<div class="text-white col bg-secondary pt-3 mx-2 shadow rounded">'
        .'<a href="'.$path_to_root.'/pages">'
        .'<img src="'.$path_to_root.'/assets/images/sq-logo.png" alt="StrikeOut"' 
        .'class="rounded img-fluid pb-2"></a><p>StrikeOut</p>'
        .'</div>'."\r\n";
        $col++;
      }
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
