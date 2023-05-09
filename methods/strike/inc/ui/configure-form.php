<form class="p-3 mx-1 bg-light shadow rounded" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
  <h3 class="mb-3">Configure Strike</h3>
  <div class="mb-3">
    <label for="apiKey" class="form-label">Api Key:</label>    
    <div class="float-end">
      <a href="https://strike.me/developer/" target="_blank">Get it Here</a>
    </div>
    <input type="text" class="form-control"  id="apiKey" name="apiKey"
    value="<?=$strike['api_key']?>" required>
  </div>
  <div class="mb-3">
    <label for="secret" class="form-label">Webhook Secret</label>
    <input type="text" class="form-control"  id="secret" name="secret" 
    value="<?=$strike['secret']?>" minlength="10" required>
  </div>
    <input type="hidden" id="configForm" name="configForm" 
    value="true" >
    <div class="mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Submit</button>
  </div>
</form>
