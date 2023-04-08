<form class="p-3" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<h1>Create Subscription</h1>
  <label for="webhookUrl" class="form-label">Webhook Url:</label>
  <input type="text class="form-control"" id="webhookUrl" name="webhookUrl"
    value="" required>
  <input type="hidden" id="createSubcription" name="createSubcription" 
  value="true" >
  <button type="submit" class="btn btn-success" value="Submit">Submit</button>
</form>

