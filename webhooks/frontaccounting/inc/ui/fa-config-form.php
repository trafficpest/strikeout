<form class="p-3" action="<?=$path_to_fa.'/index.php'?>" method="post">
  <h1>Configure FA Settings</h1>
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
    <option value="deposit">Bank Deposit</option>
    <option value="customer">Customer Payment</option>
    </select>
  </div>
    <input type="hidden" id="faConfigForm" name="faConfigForm" 
    value="true" >
  <div class="mb-3">
    <button type="submit" class="btn btn-warning" value="Submit">Submit</button>
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
  acctOption.value = "<?=$fa['acctOption']?>";
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

