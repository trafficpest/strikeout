<?php
//check array of files/folders for permissions
  $dirs = array(
    $path_to_root.'/config' => 0750,
    $path_to_root.'/inc' => 0750,
    $path_to_root.'/logs' => 0750,
    $path_to_root.'/webhooks/csv/inc' => 0750,
    $path_to_root.'/webhooks/csv/private' => 0750,
    $path_to_root.'/webhooks/frontaccounting/inc' => 0750,
    $path_to_root.'/webhooks/frontaccounting/config' => 0750
  );

if (!check_file_permissions($dirs)){
  ?>

<form class="p-3" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
  <h1 class="text-danger">Warning!</h1>
  <P>Your installation's files are available to the public. 
    Click "Set" to correct</p>
  <input type="hidden" id="setPermissions" name="setPermissions" 
  value="true" >
  <button type="submit" class="btn btn-warning" value="Submit">Set</button>
</form>
  <?php

}

?>
