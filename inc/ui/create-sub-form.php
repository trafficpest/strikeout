<div class="container2">
<h1>Create Subscription</h1>

<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
  <label for="webhookUrl">Webhook Url:</label>
  <input type="text" id="webhookUrl" name="webhookUrl"
    value="" required>
  <input type="hidden" id="createSubcription" name="createSubcription" 
  value="true" >
  <input type="submit" value="Submit">
</form>
</div>

