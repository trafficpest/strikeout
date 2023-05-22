<?php

require_once $path_to_fa.'/inc/sql.php';

function get_fa_fiscal_year(){
  // find the current fiscal year id
  global $db;
  $sql = "SELECT * FROM `".$db['table_pref']."fiscal_year` WHERE `begin` <= '"
    .date('Y-m-d')."' AND `end` >= '".date('Y-m-d')."'";
  $fiscalyear_row = get_sql_data( $sql );
  
  if (empty($fiscalyear_row[0]['id'])){
    //if new year hasnt been opened open it
    $sql = "INSERT INTO `".$db['table_pref']."fiscal_year` (`id`, `begin`, "
      ."`end`, `closed`) VALUES (NULL, '".date('Y')."-01-01', "
      ."'".date('Y')."-12-31', '0')";

    //echo $sql.'<br><br>';
    post_sql_data($sql);

    $sql = "SELECT * FROM `".$db['table_pref']."fiscal_year` WHERE `begin` <= '"
      .date('Y-m-d')."' AND `end` >= '".date('Y-m-d')."'";
    $fiscalyear_row = get_sql_data( $sql );
    }
  return $fiscalyear_row; 
}

function get_fa_debtor_by_taxid($tax_id){
  // find the client in debtor_master table
  global $db;
  $sql = "SELECT * FROM `".$db['table_pref']."debtors_master` WHERE "
    ."`tax_id` = '".$tax_id."'";
  $debtor_row = get_sql_data( $sql );
  return $debtor_row; 
}

function get_fa_debtor_by_debtor($debtor_no){
  // find the client in debtor_master table
  global $db;
  $sql = "SELECT * FROM `".$db['table_pref']."debtors_master` WHERE "
    ."`debtor_no` = '".$debtor_no."'";
  $debtor_row = get_sql_data( $sql );
  return $debtor_row; 
}

function get_fa_invoice_by_no($invoice_no){
  // invoice_no is reference in db
  global $db;
  $sql = "SELECT * FROM `".$db['table_pref']."debtor_trans` WHERE "
    ."`reference` = '".$invoice_no."' AND `type` = 10 ORDER BY `trans_no` DESC";
  $invoice_row = get_sql_data( $sql );
  return $invoice_row; 
}


function get_fa_branch_by_debtor($debtor_row){
  // find a branch_row for the client
  global $db;
  $sql = 'SELECT * FROM `'.$db['table_pref'].'cust_branch` WHERE `debtor_no`='
    .$debtor_row[0]['debtor_no'].' ORDER BY `branch_code` ASC Limit 1';
  $branch_row = get_sql_data( $sql ); 
  return $branch_row;
}

function get_last_debtor_trans(){
  // get last payment trans_no used
  global $db;
  $sql =  "SELECT * FROM `".$db['table_pref']."debtor_trans` WHERE `type` = 12 "
    ."ORDER BY `trans_no` DESC Limit 1";
  $debttran_row = get_sql_data( $sql );
  return $debttran_row;
}

function get_last_bank_trans(){
  // get last payment trans_no used
  global $db;
  $sql =  "SELECT * FROM `".$db['table_pref']."bank_trans` WHERE `type` = 2 "
    ."ORDER BY `trans_no` DESC Limit 1";
  $banktran_row = get_sql_data( $sql );
  return $banktran_row;
}

function get_last_inv_adjust(){
  // get last payment trans_no used
  global $db;
  $sql =  "SELECT * FROM `".$db['table_pref']."stock_moves` WHERE `type` = 17 "
    ."ORDER BY `trans_no` DESC Limit 1";
  $invtran_row = get_sql_data( $sql );
  return $invtran_row;
}

function insert_debtor_trans($data){
  global $db;
// insert debtor trans
  $sql = "INSERT INTO `".$db['table_pref']."debtor_trans` (`trans_no`, "
    ."`type`, `version`, `debtor_no`, `branch_code`, `tran_date`, "
    ."`due_date`, `reference`, `tpe`, `order_`, `ov_amount`, `ov_gst`, "
    ."`ov_freight`, `ov_freight_tax`, `ov_discount`, `alloc`, `prep_amount`, "
    ."`rate`, `ship_via`, `dimension_id`, `dimension2_id`, `payment_terms`, "
    ."`tax_included`) "
    ."VALUES ('".$data['trans_no']."', '".$data['type']."', '0', '"
    .$data['debtor_no']."', '".$data['branch_code']."', '"
    .date('Y-m-d')."', '0000-00-00', '".$data['ref']."', '0', '0', '"
    .$data['amount']."', "."'0', '0', '0', '0', '0', '0', '1', '0', "."'0', "
    ."'0', NULL, '0')";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
}
function insert_trans_ref($data){
  global $db;

  $sql = "INSERT INTO `".$db['table_pref']."refs` (`id`, `type`, `reference`) "
    ."VALUES ('".$data['trans_no']."', '".$data['type']."', '"
    .$data['ref']."')";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
  

}
function insert_audit_trail($data){
  global $db,$fa;

  $sql = "INSERT INTO `".$db['table_pref']."audit_trail` (`id`, `type`, "
    ."`trans_no`, `user`, `stamp`, `description`, `fiscal_year`, `gl_date`, "
    ."`gl_seq`) "
    ."VALUES (NULL, '".$data['type']."', '".$data['trans_no']."', '"
    .$fa['user_login']."', CURRENT_TIMESTAMP, '', '".$data['fiscal_year']."', '"
    .date('Y-m-d')."', '0')";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
}
function insert_bank_deposit($data, $payload){ 
 global $db, $fa; 

 if (isset($payload['Item Received'])){
   // deposit foreign currency
   $payload['Net'] = $payload['Quantity'];
 }

  $sql = "INSERT INTO `".$db['table_pref']."bank_trans` (`id`, `type`, "
    ."`trans_no`, `bank_act`, `ref`, `trans_date`, `amount`, `dimension_id`, "
    ."`dimension2_id`, `person_type_id`, `person_id`, `reconciled`) "
    ."VALUES (NULL, '".$data['type']."', '".$data['trans_no']."', '"
    .$fa['bank_acct_name']."', '".$data['ref']."', '".date('Y-m-d')."', '"
    .$payload['Net']."', '0', '0', '".$data['person_type_id']."', '"
    .$data['person_id']."', NULL)";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
}

function insert_ledger_debit($data, $amount, $account){
  global $db, $fa;

  $sql = "INSERT INTO `".$db['table_pref']."gl_trans` (`counter`, `type`, "
    ."`type_no`, `tran_date`, `account`, `memo_`, `amount`, `dimension_id`, "
    ."`dimension2_id`, `person_type_id`, `person_id`) "
    ."VALUES (NULL, '".$data['type']."', '".$data['trans_no']."', '"
    .date('Y-m-d')."', '".$account."', '".$data['memo_']."', '"
    .$amount."', '0', '0', NULL, NULL)";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
}

function insert_ledger_credit($data){
  global $db, $fa;

  $sql = "INSERT INTO `".$db['table_pref']."gl_trans` (`counter`, `type`, "
    ."`type_no`, `tran_date`, `account`, `memo_`, `amount`, `dimension_id`, "
    ."`dimension2_id`, `person_type_id`, `person_id`) "
    ."VALUES (NULL, '".$data['type']."', '".$data['trans_no']."', '"
    .date('Y-m-d')."', '".$fa['credit_acct']."', '".$data['memo_']."', '"
    .(-1*abs($data['amount']))."', '0', '0', '".$data['person_type_id']."', '"
    .$data['debtor_no']."')";

  //echo $sql.'<br><br>';
  post_sql_data($sql); 
}

function insert_deposit_credit($data){
  global $db, $fa;

  $sql = "INSERT INTO `".$db['table_pref']."gl_trans` (`counter`, `type`, "
    ."`type_no`, `tran_date`, `account`, `memo_`, `amount`, `dimension_id`, "
    ."`dimension2_id`, `person_type_id`, `person_id`) "
    ."VALUES (NULL, '".$data['type']."', '".$data['trans_no']."', '"
    .date('Y-m-d')."', '".$fa['credit_acct']."', '".$data['memo_']."', '"
    .(-1*abs($data['amount']))."', '0', '0', NULL, NULL)";

  //echo $sql.'<br><br>';
  post_sql_data($sql); 
}


function fa_payment_by_taxid($payload){
  global $fa, $db;

  date_default_timezone_set( $fa['timezone'] );

  // Get the data needed
  $fiscalyear_row = get_fa_fiscal_year();  
  $debtor_row = get_fa_debtor_by_taxid($payload['Reference']);
  
  // Check the data is there
  if (empty($debtor_row[0]['debtor_no'])){
    error_log("Couldn't find tax id ".$payload['Reference']." in the database");
    fa_bank_deposit($payload['Amount']);
    return;
  }

  $branch_row = get_fa_branch_by_debtor($debtor_row);
  if (empty($branch_row[0]['branch_code'])){
    error_log("Couldn't find a branch for customer with tax id "
      .$payload['Reference']." in the database");
    fa_bank_deposit($payload['Amount']);
    return;
  }

  $debttran_row = get_last_debtor_trans();
  if (empty($debttran_row[0]['trans_no'])){
    error_log("Warning: Couldn't find a prior customer payment in the database."
    ." will be 1");
  }
  // clean it up
  $data = array(
    'ref' => date('ymdHis'),
    'fiscal_year' => $fiscalyear_row[0]['id'],
    'debtor_no' => $debtor_row[0]['debtor_no'],
    'branch_code' => $branch_row[0]['branch_code'],
    'trans_no' => ($debttran_row[0]['trans_no']+1),
    'amount' => $payload['Amount'],
    'type' => '12',
    'person_id' => $debtor_row[0]['debtor_no'],
    'person_type_id' => '2',
    'memo_' => 'StrikeOut',
  );

  insert_debtor_trans($data);
  insert_trans_ref($data);
  insert_audit_trail($data);
  insert_bank_deposit($data, $payload);
  insert_ledger_debit($data, $payload['Net'], $fa['debit_acct']);
  insert_ledger_credit($data);
  if ($payload['Fee'] != 0){
    // Account fee if there was one
    insert_ledger_debit($data, $payload['Fee'], $fa['fee_acct']);
  }
}

function fa_payment_by_debtor($payload){
  global $fa, $db;

  date_default_timezone_set( $fa['timezone'] );

  // Get the data needed
  $fiscalyear_row = get_fa_fiscal_year();
  $debtor_row = get_fa_debtor_by_debtor($payload['Reference']);
  
  // Check the data is there
  if (empty($debtor_row[0]['debtor_no'])){
    error_log("Couldn't find debtor ".$payload['Reference']." in the database");
    fa_bank_deposit($payload['Amount']);
    return;
  }

  $branch_row = get_fa_branch_by_debtor($debtor_row);
  if (empty($branch_row[0]['branch_code'])){
    error_log("Couldn't find a branch for customer with debtor no "
      .$payload['Reference']." in the database");
    fa_bank_deposit($payload['Amount']);
    return;
  }
    
  $debttran_row = get_last_debtor_trans();
  if (empty($debttran_row[0]['trans_no'])){
    error_log("Warning: Couldn't find a prior customer payment in the database."
    ." will be 1");
  }
  // clean it up
  $data = array(
    'ref' => date('ymdHis'),
    'fiscal_year' => $fiscalyear_row[0]['id'],
    'debtor_no' => $debtor_row[0]['debtor_no'],
    'branch_code' => $branch_row[0]['branch_code'],
    'trans_no' => ($debttran_row[0]['trans_no']+1),
    'amount' => $payload['Amount'],
    'type' => '12',
    'person_id' => $debtor_row[0]['debtor_no'],
    'person_type_id' => '2',
    'memo_' => 'StrikeOut'
  );

  insert_debtor_trans($data);
  insert_trans_ref($data);
  insert_audit_trail($data);
  insert_bank_deposit($data, $payload);
  insert_ledger_debit($data, $payload['Net'], $fa['debit_acct']);
  insert_ledger_credit($data);
  if ($payload['Fee'] != 0){
    // Account fee if there was one
    insert_ledger_debit($data, $payload['Fee'], $fa['fee_acct']);
  }
}

function fa_payment_by_invoice($payload){
  global $fa, $db;

  date_default_timezone_set( $fa['timezone'] );

  // Get the data needed and verify its there
  $fiscalyear_row = get_fa_fiscal_year();
  $invoice_row = get_fa_invoice_by_no($payload['Reference']);
  
  if (empty($invoice_row[0]['debtor_no'])){
    error_log("Couldn't find invoice ".$payload['Reference']." in the database");
    fa_bank_deposit($payload['Amount']);
    return;
  }

  $debtor_row = get_fa_debtor_by_debtor($invoice_row[0]['debtor_no']);
  if (empty($debtor_row[0]['debtor_no'])){
    error_log("Couldn't find debtor ".$debtor_no." in the database");
    fa_bank_deposit($payload['Amount']);
    return;
  }

  $branch_row = get_fa_branch_by_debtor($debtor_row);
  if (empty($branch_row[0]['branch_code'])){
    error_log("Couldn't find a branch for customer with debtor no "
      .$debtor_no." in the database");
    fa_bank_deposit($payload['Amount']);
    return;
  }

  $debttran_row = get_last_debtor_trans();
  if (empty($debttran_row[0]['trans_no'])){
    error_log("Warning: Couldn't find a prior customer payment in the database."
    ." will be 1");
  }

  // clean it up
  $data = array(
    'ref' => date('ymdHis'),
    'fiscal_year' => $fiscalyear_row[0]['id'],
    'debtor_no' => $debtor_row[0]['debtor_no'],
    'branch_code' => $branch_row[0]['branch_code'],
    'trans_no' => ($debttran_row[0]['trans_no']+1),
    'amount' => $payload['Amount'],
    'type' => '12',
    'person_id' => $debtor_row[0]['debtor_no'],
    'person_type_id' => '2',
    'memo_' => 'StrikeOut'
  );

  insert_debtor_trans($data);
  insert_trans_ref($data);
  insert_audit_trail($data);
  insert_bank_deposit($data, $payload);
  insert_ledger_debit($data, $payload['Net'], $fa['debit_acct']);
  insert_ledger_credit($data);
  if ($payload['Fee'] != 0){
    // Account fee if there was one
    insert_ledger_debit($data, $payload['Fee'], $fa['fee_acct']);
  }
}

function fa_bank_deposit($payload){
  global $fa, $db;

  date_default_timezone_set( $fa['timezone'] );

  // Get the data needed
  $fiscalyear_row = get_fa_fiscal_year();
  $banktran_row = get_last_bank_trans();

  // check data
  if (empty($banktran_row[0]['trans_no'])){
    error_log("Warning: Couldn't find a prior deposit in the database."
    ." will be 1");
  }

  // clean it up
  $data = array(
    'ref' => date('ymdHis'),
    'fiscal_year' => $fiscalyear_row[0]['id'],
    'debtor_no' => 'NULL', 
    'trans_no' => ($banktran_row[0]['trans_no']+1),
    'amount' => $payload['Amount'],
    'type' => '2',
    'person_id' => 'StrikeOut',
    'person_type_id' => '0',
    'memo_' => 'StrikeOut'
  );

  insert_audit_trail($data);
  insert_trans_ref($data);
  insert_bank_deposit($data, $payload);
  insert_ledger_debit($data, $payload['Net'], $fa['debit_acct']);
  insert_deposit_credit($data);
  if ($payload['Fee'] != 0){
    // Account fee if there was one
    insert_ledger_debit($data, $payload['Fee'], $fa['fee_acct']);
  }
}

?>
