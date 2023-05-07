<?php

$subscriptions = list_pp_webhooks();

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

if ( isset($subscriptions['webhooks'][0]) ){
  
  foreach ( $subscriptions['webhooks'] as $sub ){

    echo '<tr>
      <td>'.$sub['id'].'</td><td>'.$sub['url'].'</td>
      <td>'.$sub['event_types'][0]['description'].'</td>
      <td>'.$sub['event_types'][0]['status'].'</td>
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
