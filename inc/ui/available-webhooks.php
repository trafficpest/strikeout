<?php

$ls_files = scandir($path_to_root.'/webhooks/');

$webhook_path = 'https://'.$_SERVER['HTTP_HOST']
  .strtok($_SERVER['REQUEST_URI'], '?');
  
$webhook_path = str_replace(
  'pages/webhooks.php',
  'webhooks/',
  $webhook_path
);


foreach ($ls_files as $file_name){
  $file_ext = substr(strrchr($file_name, '.'), 1);
  if ($file_ext === 'php'){
    $webhooks[] = $webhook_path.$file_name;
  }
}
?>


<form class="p-3">
<h1>Webhooks Available</h1>
<div style="overflow-x:auto;">
<?
foreach ($webhooks as $hook){
  echo '<p>'.$hook.'</p>';
}
?>
</div>
</form>
