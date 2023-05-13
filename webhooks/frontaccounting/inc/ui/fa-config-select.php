<form class="bg-light rounded p-3 mb-3" 
  action="<?=$path_to_fa.'/index.php'?>" method="post">
  <h3>FA Config Select</h3>
  <div class="row">
    <label for="paymentMethod" class="form-label">Payment Method:</label>
  <div class="col-9 mb-3">
    <select class="form-control" id="paymentMethod" name="paymentMethod">
    <option value="">***Select Payment Method***</option>
<?
  foreach(glob($path_to_root.'/methods/*', GLOB_ONLYDIR) as $plugin) {
    $plugin = str_replace($path_to_root.'/methods/', '', $plugin);
    echo '<option value="'.$plugin.'">'.ucfirst($plugin).'</option>';
  }
?>
  </select>
  </div>
    <input type="hidden" id="faConfigSelect" name="faConfigSelect" 
    value="true" >
  <div class="col-3 mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Select</button>
  </div>
  </div>
</form>
<?
  if (isset ($_POST['paymentMethod'] )){
    // show the selected value in list
?>
<script>
  var paymentMethod = document.getElementById("paymentMethod");
  paymentMethod.value = "<?=$_POST['paymentMethod']?>";
  </script>
    <?
}    
