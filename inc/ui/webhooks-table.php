<?php

$subscriptions = get_strike_subscriptions();

?>

<div class="container2">
<h1>Webhook Subscriptions</h1>

<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<div style="overflow-x:auto;">
<table>
<tr>
<th>ID</th><th>Webhook Url</th><th>Version</th><th>Enabled</th>
<th>Created</th><th>Event Types</th><th>Delete</th>
</tr>
<?php

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

?>

</table>
</div>
</form>
</div>

