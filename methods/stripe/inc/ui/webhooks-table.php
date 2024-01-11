<?php
// Need to add webhooks in future
$subscriptions = list_stripe_webhooks();

?>

<form class="p-3 mx-1 bg-light shadow rounded" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<h3>Active Subscriptions</h3>
<div style="overflow-x:auto;">
<table class="table center">
<thead class="thead">
<tr>
<th>ID</th><th>Webhook Url</th>
<th>Event Types</th><th>Status</th><th>Delete</th>
</thead>
</tr>
<?php

if ( isset($subscriptions['data'][0]) ){
  
  foreach ( $subscriptions['data'] as $sub ){

    echo '<tr>
      <td>'.$sub['id'].'</td><td>'.$sub['url'].'</td>
      <td>'.$sub['enabled_events'][0].'</td>
      <td>'.$sub['status'].'</td>
      <td>
      <a href="'.strtok($_SERVER["REQUEST_URI"], '?').'?deleteSubscription='.$sub['id'].'">X
      </a>
      </td>
      </tr>';    
  }
}
?>

</table>
</div>
</form>
