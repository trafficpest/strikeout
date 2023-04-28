<?php

require_once($path_to_root.'/inc/configure.php');


function set_so_permissions($path_to_root){
  
  $dirs = array(
    $path_to_root.'/config' => 0750,
    $path_to_root.'/inc' => 0750,
    $path_to_root.'/logs' => 0750,
    $path_to_root.'/webhooks/csv/inc' => 0750,
    $path_to_root.'/webhooks/csv/private' => 0750,
    $path_to_root.'/webhooks/frontaccounting/inc' => 0750,
    $path_to_root.'/webhooks/frontaccounting/config' => 0750
  );

  update_file_permissions($dirs);
}

?>
