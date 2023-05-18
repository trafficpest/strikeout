<?php
$plugin_cfg = load_plugin_config($path_to_lnbits.'/config/plugins.php');
?>
<form class="p-3 mx-1 bg-light shadow rounded" 
  action="<?=$_SERVER['REQUEST_URI']?>" method="post">
  <h3>Activate Webhooks</h3>
<?php
$cnt=0;
  foreach(glob($path_to_root.'/webhooks/*', GLOB_ONLYDIR) as $plugin) {
    $cnt++;
    $plugin = str_replace($path_to_root.'/webhooks/', '', $plugin);
    if (isset($plugin_cfg[$plugin]) == 'on'){
      $status = 'checked';
    }else{ $status = '';}
?>
  <div class="form-check form-switch mb-3">
    <input class="form-check-input" name="<?=$plugin?>" 
    type="checkbox" id="selectPlugin<?=$cnt?>" <?=$status?>>
    <label class="form-check-label" for="selectPlugin<?=$cnt?>">
      <?=ucfirst($plugin)?>
    </label>
  </div>
<?php
  }
?>
  <input type="hidden" id="activatePlugin" name="activatePlugin" 
  value="true" >
  <button type="submit" class="btn btn-warning" value="Submit">Submit</button>
</form>

