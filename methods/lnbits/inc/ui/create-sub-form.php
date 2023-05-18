<?php

$webhook_path = 'https://'.$_SERVER['HTTP_HOST']
  .strtok($_SERVER['REQUEST_URI'], '?');
  
$webhook_path = str_replace(
  'pages/',
  'webhooks/index.php',
  $webhook_path
);

?>
<form class="p-3 mx-1 bg-light shadow rounded" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<h3>Create Subscription</h3>
  <label for="webhookUrl" class="form-label">Webhook Url:</label>
  <input type="text" class="form-control mb-3" id="webhookUrl" name="webhookUrl"
  value="<?=$webhook_path?>" readonly>
  <input type="hidden" id="createSubcription" name="createSubcription" 
  value="true" >
  <p class="text-center">Copy to config to activate</p> 
</form>

