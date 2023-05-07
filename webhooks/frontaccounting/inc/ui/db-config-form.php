<form class="bg-light rounded p-3 mb-3" 
  action="<?=$path_to_fa.'/index.php'?>" method="post">
  <h3>FA SQL Database</h3>
  <div class="mb-3">
    <label for="hostname" class="form-label">Hostname:</label>
    <input type="text" class="form-control"  id="hostname" name="hostname"
      value="<?=$db['hostname']?>" required>
  </div>
  <div class="mb-3">
    <label for="userName" class="form-label">User Name:</label>
    <input type="text" class="form-control"  id="userName" name="userName"
    value="<?=$db['username']?>" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="text" class="form-control"  id="password" name="password"
      value="<?=$db['password']?>" >
  </div>
  <div class="mb-3">
    <label for="dbName" class="form-label">DB Name:</label>
    <input type="text" class="form-control"  id="dbName" name="dbName" required
      value="<?=$db['db_name']?>" >
  </div>
  <div class="mb-3">
    <label for="tablePref" class="form-label">Table Pref:</label>
    <input type="text" class="form-control"  id="tablePref" name="tablePref" 
    value="<?=$db['table_pref']?>" required>
  </div>
    <input type="hidden" id="dbConfigForm" name="dbConfigForm" 
    value="true" >
  <div class="mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Submit</button>
  </div>
</form>
