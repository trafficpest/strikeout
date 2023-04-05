
<div class="container">
<h1>Create Lightning Invoice</h1>

<form class="w480" action="<?=$path_to_root.'/checkout.php'?>" method="post">
  <label for="name">Name:</label>
  <input type="text" id="name" name="name">
  <label for="custId">Reference:</label>
  <input type="text" id="custId" name="custId" >
  <label for="amount">Amount:</label>
  <input type="text" id="amount" name="amount" required>
  <input type="submit" value="Submit">  
</form>
</div>

