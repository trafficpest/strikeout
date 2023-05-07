<form class="bg-light shadow rounded p-3" 
  action="<?=$_SERVER['REQUEST_URI']?>" method="post">
  <h3>Configure Strikeout</h3>
  <div class="mb-3">
    <label for="payeeName" class="form-label">Payee Name:</label>
    <input type="text" class="form-control"  id="payeeName" name="payeeName"
      value="<?=$strikeout['payee_name']?>" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="text" class="form-control"  id="password" name="password" 
    value="<?=$strikeout['password']?>" required>
  </div>
  <div class="mb-3">
    <label for="tmpDir" class="form-label">Working Dir:</label>
    <div class="float-end">
      <a href="<?=strtok($_SERVER["REQUEST_URI"], '?').'?deleteQr=true'?>">
        Delete Contents</a>
    </div>
    <input type="text" class="form-control"  id="tmpDir" name="tmpDir"
      value="<?=$strikeout['tmp_dir']?>" >
  </div>
  <div class="mb-3">
    <label for="actionUrl" class="form-label">Redirect After Payment:</label>
    <input type="text" class="form-control"  id="actionUrl" name="actionUrl" 
      value="<?=$strikeout['action_url']?>" required>
  </div>
  <div class="mb-3">
    <label for="timezone" class="form-label">Timezone:</label>
    <?include_once $path_to_root.'/inc/ui/timezones.php'?>
  </div>
    <input type="hidden" id="configForm" name="configForm" 
    value="true" >
  <div class="mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Submit</button>
  </div>
</form>
