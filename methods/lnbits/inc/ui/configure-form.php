<form class="p-3 mx-1 bg-light shadow rounded" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
  <h3 class="mb-3">Configure LNbits</h3>
  <div class="mb-3">
    <label for="lnbits_url" class="form-label">LNbits URL:</label>    
    <input type="text" class="form-control"  id="lnbits_url" name="lnbits_url"
    value="<?=$lnbits['lnbits_url']?>" required>
  </div>
  <div class="mb-3">
    <label for="read_key" class="form-label">Invoice/Read Key:</label>
    <input type="text" class="form-control"  id="read_key" name="read_key" 
    value="<?=$lnbits['read_key']?>" required>
  </div>
  <div class="mb-3">
    <label for="webhook_url" class="form-label">Webhook Url:</label>
    <input type="text" class="form-control"  id="webhook_url" name="webhook_url" 
    value="<?=$lnbits['webhook_url']?>">
  </div>
    <input type="hidden" id="configForm" name="configForm" 
    value="true" >
    <div class="mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Submit</button>
  </div>
</form>
