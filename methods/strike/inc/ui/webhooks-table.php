<?php

$subscriptions = get_strike_subscriptions();

?>

<form class="p-3 mx-1 bg-light shadow rounded" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<h3>Active Subscriptions</h3>
<div style="overflow-x:auto;">
<table class="table center">
<thead class="thead">
<tr>
<th>ID</th><th>Webhook Url</th><th>Version</th><th>Enabled</th>
<th>Created</th><th>Event Types</th><th>Delete</th>
</thead>
</tr>
<?php

if ( isset($subscriptions[0]['enabled']) ){
  
  foreach ( $subscriptions as $sub ){
    if ($sub['enabled']=='1'){ $check = 'checked'; } else { $check = ''; }

    echo '<tr>
      <td>'.$sub['id'].'</td><td>'.$sub['webhookUrl'].'</td>
      <td>'.$sub['webhookVersion'].'</td><td>'.$sub['enabled'].'</td>
      <td>'.$sub['created'].'</td><td>'.json_encode($sub['eventTypes']).'</td>
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
