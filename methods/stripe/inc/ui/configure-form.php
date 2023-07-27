<form class="p-3 mx-1 bg-light shadow rounded" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
  <h3 class="mb-3">Configure Stripe</h3>
  <div class="mb-3">
    <label for="clientId" class="form-label">Pub Key:</label>
    <input type="text" class="form-control"  id="pubKey" name="PUB_KEY"
    value="<?=$stripe['PUB_KEY']?>" required>
  </div>
  <div class="mb-3">
    <label for="appSecret" class="form-label">Private Key:</label>    
    <input type="text" class="form-control"  id="priKey" name="PRI_KEY"
    value="<?=$stripe['PRI_KEY']?>" required>
  </div>
    <input type="hidden" id="configForm" name="configForm" 
    value="true" >
    <div class="mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Submit</button>
  </div>
</form>
