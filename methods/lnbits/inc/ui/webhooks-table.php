<form class="p-3 mx-1 bg-light shadow rounded" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<h3>Active Subscriptions</h3>
<div style="overflow-x:auto;">
<table class="table center">
<thead class="thead">
<tr>
<th>ID</th><th>Webhook Url</th><th>Version</th><th>Enabled</th>
<th>Event Types</th>
</thead>
</tr>
<?php

if ( !empty($lnbits['webhook_url']) ){
  echo '<tr>
  <td>N/A</td><td>'.$lnbits['webhook_url'].'</td>
  <td>v1</td><td>Yes</td>
  <td>'.json_encode('invoice_paid').'</td>
</tr>';    
  }
?>

</table>
</div>
</form>
