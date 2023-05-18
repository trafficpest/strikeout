<form class="p-3 mx-1 bg-light shadow rounded" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
  <h3 class="mb-3">Configure PayPal</h3>
  <div class="mb-3">
    <label for="clientId" class="form-label">Client ID:</label>
    <input type="text" class="form-control"  id="clientId" name="clientId"
    value="<?=$paypal['CLIENT_ID']?>" required>
  </div>
  <div class="mb-3">
    <label for="appSecret" class="form-label">App Secret:</label>    
    <div class="float-end">
      <a href="https://developer.paypal.com/" target="_blank">Get it Here</a>
    </div>
    <input type="text" class="form-control"  id="appSecret" name="appSecret"
    value="<?=$paypal['APP_SECRET']?>" required>
  </div>
  <div class="mb-3">
    <label for="webhookId" class="form-label">Webhook ID:</label>
    <input type="text" class="form-control"  id="webhookId" name="webhookId"
    value="<?=$paypal['WEBHOOK_ID']?>" required>
  </div>
  <div class="mb-3">
    <label for="sdkOptions" class="form-label">PayPal SDK Options:</label>
    <div class="float-end">
      <a href="https://developer.paypal.com/sdk/js/configuration/#link-queryparameters" 
         target="_blank">Read Here</a>
    </div>
    <input type="text" class="form-control"  id="sdk_options" name="sdk_options"
    value="<?=$paypal['sdk_options']?>" required>
  </div>
    <input type="hidden" id="configForm" name="configForm" 
    value="true" >
    <div class="mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Submit</button>
  </div>
</form>

