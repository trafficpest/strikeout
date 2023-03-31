<?php

require './sql.php';
require '../db-config.php';

function enter_FA_payment($clientid, $amount){
  global $fa;

  date_default_timezone_set( $fa['timezone'] );

  $sql = "SELECT * FROM `".$db['table_pref']."users` WHERE `user_id` = `".$fa['user_login']."`";
  $user_row = get_sql_data( $sql );
  
  $sql = "SELECT * FROM `".$db['table_pref']."bank_accounts` WHERE `bank_account_name` = `"
    .$fa['bank_acct_name']."`";
  $bank_row = get_sql_data( $sql );

  $ref = date('ymdHis');
  
  // find the current fiscal year id
  $sql = "SELECT * FROM `".$db['table_pref']."fiscal_year` WHERE `begin` <= '"
         .date('Y-m-d')."' AND `end` >= '".date('Y-m-d')."'";
  $fiscalyear_row = get_sql_data( $sql );
  
      if (empty($fiscalyear_row[0]['id'])){
          Return 'Error: Fiscal Year Not Open';
      }
  // find the client in debtor_master table
  $sql = "SELECT * FROM `".$db['table_pref']."debtors_master` WHERE `tax_id` = `".$clientid."`";
  $debtor_row = get_sql_data( $sql );
  
  // find a branch_row for the client
  $sql = 'SELECT * FROM `'.$db['table_pref'].'cust_branch` WHERE `debtor_no`='
         .$debtor_row[0]['debtor_no'].' ORDER BY `branch_code` ASC Limit 1';
  $branch_row = get_sql_data( $sql ); 

  // get last payment trans_no used
  $sql =  "SELECT * FROM `".$db['table_pref']."debtor_trans` WHERE `type` = 12 ORDER BY "
          ."`trans_no` DESC Limit 1";
  $sodebttran_row = get_sql_data( $sql );    

  // insert debtor trans
  $sql = "INSERT INTO `".$db['table_pref']."debtor_trans` (`trans_no`, `type`, `version`, "
  ."`debtor_no`, `branch_code`, `tran_date`, `due_date`, `reference`, `tpe`, "
  ."`order_`, `ov_amount`, `ov_gst`, `ov_freight`, `ov_freight_tax`, "
  ."`ov_discount`, `alloc`, `prep_amount`, `rate`, `ship_via`, `dimension_id`, "
  ."`dimension2_id`, `payment_terms`, `tax_included`) "
  ."VALUES ('".($sodebttran_row[0]['trans_no']+1)."', '12', '0', '"
  .$debtor_row[0]['debtor_no']."', '".$branch_row[0]['branch_code']."', '"
  .date('Y-m-d')."', '0000-00-00', '".$ref."', '0', '0', '"
  .$amount."', '0', '0', '0', '0', '0', '0', '1', '0', "."'0', '0', NULL, '0')";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
  
  // enter the date time for ref number
  $sql = "INSERT INTO `".$db['table_pref']."refs` (`id`, `type`, `reference`) VALUES ('"
  .($sodebttran_row[0]['trans_no']+1)."', '12', '".$ref."')";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
  
  // audit trail 
  $sql = "INSERT INTO `".$db['table_pref']."audit_trail` (`id`, `type`, `trans_no`, `user`, "
  ."`stamp`, `description`, `fiscal_year`, `gl_date`, `gl_seq`) "
  ."VALUES (NULL, '12', '".($sodebttran_row[0]['trans_no']+1)
  ."', '".$user_row[0]['id']."', CURRENT_TIMESTAMP, '', '"
  .$fiscalyear_row[0]['id']."', '".date('Y-m-d')."', '0')";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
  
  // Bank Deposit (set to braintree)
  $sql = "INSERT INTO `".$db['table_pref']."bank_trans` (`id`, `type`, `trans_no`, `bank_act`, "
  ."`ref`, `trans_date`, `amount`, `dimension_id`, `dimension2_id`, "
  ."`person_type_id`, `person_id`, `reconciled`) VALUES (NULL, '12', '"
  .($sodebttran_row[0]['trans_no']+1)."', '".$bank_row[0]['id']."', '"
  .$ref."', '".date('Y-m-d')."', '".$amount."', '0', '0', '2', '"
  .$debtor_row[0]['debtor_no']."', '')";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
  
  //Ledger Postings (Set to 1080 deposit and 1200 Credit)
  $sql = "INSERT INTO `".$db['table_pref']."gl_trans` (`counter`, `type`, `type_no`, `tran_date`, "
  ."`account`, `memo_`, `amount`, `dimension_id`, `dimension2_id`, "
  ."`person_type_id`, `person_id`) VALUES (NULL, '12', '"
  .($sodebttran_row[0]['trans_no']+1)."', '".date('Y-m-d')."', '"
  .$fa['debit_acct']."', '', '".$amount."', '0', '0', NULL, NULL)";

  //echo $sql.'<br><br>';
  post_sql_data($sql);
  
  $sql = "INSERT INTO `".$db['table_pref']."gl_trans` (`counter`, `type`, `type_no`, `tran_date`, "
  ."`account`, `memo_`, `amount`, `dimension_id`, `dimension2_id`, "
  ."`person_type_id`, `person_id`) VALUES (NULL, '12', '"
  .($sodebttran_row[0]['trans_no']+1)."', '".date('Y-m-d')."', '"
  .$fa['credit_acct']."', '', '".(-1*abs($amount))."', '0', '0', '2', '"
  .$debtor_row[0]['debtor_no']."')";

  //echo $sql.'<br><br>';
  post_sql_data($sql); 

}
