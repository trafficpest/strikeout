<form class="bg-light shadow rounded p-3" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<h3>Select CSV</h3>
<select class="form-control mb-3" id="selectCsv" name="selectCsv" >
<? 
$files = preg_grep('~\.(csv)$~', scandir($path_to_csv.'/private'));
echo '<option value="">***Select File***</option>';
foreach ($files as $file){
?>
<option value="<?=$file?>"><?=$file?></option>
  <?
}
?>
</select>
  <input type="hidden" id="selectCsvForm" name="selectCsvForm"> 
<div class="row">
  <div class="col">
<button type="submit" name="displayTable" 
  class="btn btn-warning mb-3" value="True">View</button>
  </div>
  <div class="col">
  <button type="submit" name="downloadFile" class="btn btn-warning mb-3" 
    value="true">Download</button>
  </div>
  <div class="col">
  <button type="submit" name="deleteFile" class="btn btn-danger float-end mb-3" 
    value="true">Delete</button>
  </div>
</div>
</form>
