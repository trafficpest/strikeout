<form class="p-3 bg-light shadow rounded mx-1" action="<?=$path_to_strike?>" 
  method="post">
  <h3>Test Invoice</h3>
  <div class="mb-3">
    <label for="name" class="form-label">Name:</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="mb-3">
    <label for="custId" class="form-label">Reference:</label>
    <input type="text" class="form-control" id="custId" name="custId" >
  </div>
   <div class="mb-3">
    <label for="action_url" class="form-label">Action URL:</label>
    <input type="text" class="form-control" id="action_url" name="action_url" >
  </div> 
  <div class="mb-3">
    <label for="amount" class="form-label">Amount:</label>
    <input type="text"  class="form-control" id="amount" name="amount" required>
  </div>
  <div class="mb-3">
    <input type="submit" class="btn btn-warning" value="Submit">  
  </div>
</form>

