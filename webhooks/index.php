<?php

$path_to_root = '..';
include_once '../inc/strike.php';

?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<body>

<center>
<h1>Create Strike Webhook Subscription</h2>
<form action="./create-subscription.php" method="post">
  <label for="webhookUrl">Your Webhook Url:</label><br>
  <input type="text" id="webhookUrl" name="webhookUrl" required><br>
  <label for="webhookVersion">Webhook Version:</label><br>
  <input type="text" id="webhookVersion" name="webhookVersion" value="v1" required><br> 
  <label for="secret">Your Secret Signature:</label><br>
  <input type="text" id="secret" name="secret" required><br><br>
  <label for="enabled">Enabled:</label><br>
  <select id="enabled" name="enabled" >
  <option value="true">True</option>
  <option value="false">False</option>
  </select>

  <br><br> 
  <input type="submit" value="Submit">  
</form>
</center>

</body>
</html>
