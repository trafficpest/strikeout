<?php
if (isset($fa_users)){
if ($fa_users[0] === 'ERROR'){
  //Database connection error
  echo '<div class="bg-light rounded p-3 mb-3">'
    .'<h3 class="text-center p-3">Unable to connect to FA Database</h3>'
    .'</div>';
} elseif ($fa_users === '0 results'){
  //No company data found in database
  echo '<div class="bg-light rounded p-3 mb-3">'
    .'<h3 class="text-center p-3">Database Connected:</h3>'
    .'<p class="text-center p-3">No company found. Is Table Pref correct?</p>'
    .'</div>';
}elseif (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] !== '') {
  //database and company found
?>
<form class="bg-light rounded p-3 mb-3" 
  action="<?=$path_to_fa.'/index.php'?>" method="post">
  <h3>FA Settings</h3>
  <div class="mb-3">
    <label for="userLogin" class="form-label">FA Login:</label>
    <select class="form-control" id="userLogin" name="userLogin">
    <option value="">***User to Enter Payments***</option>
<?
foreach ($fa_users as $fa_user){
  echo '<option value="'.$fa_user['id'].'">'
    .$fa_user['user_id'].'</option>'."\r\n";
}
?>
  </select>
  </div>
  <div class="mb-3">
    <label for="bankAcctName" class="form-label">Bank Account:</label>
    <select class="form-control"  id="bankAcctName" name="bankAcctName"
      onChange="setDebitAccount()">
    <option value="">***Deposit Bank Account***</option>
<?
foreach ($bank_accts as $bank_acct){
  echo '<option value="'.$bank_acct['id'].'">'
    .$bank_acct['bank_account_name'].'</option>'."\r\n";
}
?>
  </select>
  </div>
  <div class="mb-3">
    <label for="debitAcct" class="form-label">Debit Account:</label>
    <select class="form-control"  id="debitAcct" name="debitAcct">
    <option value="">***Ledger Account to Debit(+)***</option>
<?
foreach ($fa_coa as $account){
  echo '<option value="'.$account['account_code'].'">'
    .$account['account_code'].' '.$account['account_name'].'</option>'."\r\n";
}
?>
    </select>
  </div>
  <div class="mb-3">
    <label for="creditAcct" class="form-label">Credit Account:</label>
    <select class="form-control"  id="creditAcct" name="creditAcct">
    <option value="">***Ledger Account to Credit(-)***</option>
<?
foreach ($fa_coa as $account){
  echo '<option value="'.$account['account_code'].'">'
    .$account['account_code'].' '.$account['account_name'].'</option>'."\r\n";
}
?>
    </select> 
  </div>
    <div class="mb-3">
    <label for="acctOption" class="form-label">Account Option:</label>
    <select class="form-control"  id="acctOption" name="acctOption">
    <option value="">***Select Entry Type***</option>
    <option value="bank_deposit">Bank Deposit</option>
    <option value="invoice">Customer Payment (Invoice)</option>
    <option value="debtor_no">Customer Payment (Debtor #)</option>
    <option value="tax_id">Customer Payment (Tax ID)</option>
    </select>
  </div>
    <input type="hidden" id="hiddenMethod" name="paymentMethod" 
    value="<?=$_POST['paymentMethod']?>" >
    <input type="hidden" id="faConfigForm" name="faConfigForm" 
    value="true" >
  <div class="mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Save</button>
  </div>
</form>
<script>
  var userLogin = document.getElementById("userLogin");
  userLogin.value = "<?=$fa['user_login']?>";
  var bankAcctName = document.getElementById("bankAcctName");
  bankAcctName.value = "<?=$fa['bank_acct_name']?>";
  var debitAcct = document.getElementById("debitAcct");
  debitAcct.value = "<?=$fa['debit_acct']?>";
  var creditAcct = document.getElementById("creditAcct");
  creditAcct.value = "<?=$fa['credit_acct']?>";
  var acctOption = document.getElementById("acctOption");
  acctOption.value = "<?=$fa['acct_option']?>";
  function setDebitAccount(){
    var bankAcctId = document.getElementById("bankAcctName").value;
    var bankAccts = <?=json_encode($bank_accts)?>;
    var debitAcct = document.getElementById("debitAcct");
    bankAccts.forEach((bankAcct) => {
      if (bankAcct['id']  === bankAcctId){
        debitAcct.value = bankAcct['account_code'];
      }
    });
  }
</script>
<? }
else {
// no payment method selected
  include $path_to_fa.'/inc/ui/fa-config-select.php';
}
}
