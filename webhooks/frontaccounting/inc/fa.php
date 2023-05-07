<?php

ini_set('error_log', $path_to_root.'/logs/frontaccounting.log');

require_once $path_to_fa.'/inc/sql.php';
require_once $path_to_root.'/inc/configure.php';

function get_fa_users(){
  global $db;
  $sql ='SELECT * FROM `'.$db['table_pref'].'users`';
  $sql_results = get_sql_data($sql);
  if ($sql_results[0] === 'ERROR' ||
      $sql_results === '0 results'){
    return $sql_results;
  }
   
  foreach ($sql_results as $result){
    $users[] = array(
      'id' => $result['id'],
      'user_id' => $result['user_id']
    );
  }
  return $users;
}


function get_fa_bank_accts(){
  global $db;
  $sql ='SELECT * FROM `'.$db['table_pref'].'bank_accounts`';
  $sql_results = get_sql_data($sql);
  if ($sql_results[0] === 'ERROR'){
    return $sql_results;
  }
  foreach ($sql_results as $result){
    $bank_accts[] = array(
      'id' => $result['id'],
      'account_code' => $result['account_code'],
      'bank_account_name' => $result['bank_account_name']
    );
  }
  return $bank_accts;
}

function get_fa_coa(){
  global $db;
  $sql ='SELECT * FROM `'.$db['table_pref'].'chart_master`';
  $sql_results = get_sql_data($sql);
  if ($sql_results[0] === 'ERROR'){
    return $sql_results;
  }
  
  foreach ($sql_results as $result){
    $coa[] = array (
    'account_code' => $result['account_code'],
    'account_name' => $result['account_name']
    );
  }
  return $coa;
}

function load_db_config($config_file){
  $db_default_config = array(
    'hostname' => 'localhost',
    'username' => 'sql user here',
    'password' => 'password here',
    'db_name' => 'sql db name',
    'table_pref' => '0_'
  );

  $db = load_config($config_file, $db_default_config);
  return $db;
}

function update_db_config($config_file){
  $db = array(
  'hostname' => $_POST['hostname'],
  'username' => $_POST['userName'],
  'password' => $_POST['password'],
  'db_name' => $_POST['dbName'],
  'table_pref' => $_POST['tablePref']
);
  
  update_config($config_file, $db);
  return $db;
}

function load_fa_config($config_file){
  global $strikeout;
  $fa_default_config = array(
    'user_login' => '',
    'bank_acct_name' => '',
    'debit_acct' => '',
    'credit_acct' => '',
    'timezone' => $strikeout['timezone'],
    'acct_option' => ''
    );

  $fa = load_config($config_file, $fa_default_config);
  return $fa;
}

function update_fa_config($config_file){
  global $strikeout;

  $fa = array(
    'user_login' => $_POST['userLogin'],
    'bank_acct_name' => $_POST['bankAcctName'],
    'debit_acct' => $_POST['debitAcct'],
    'credit_acct' => $_POST['creditAcct'],
    'timezone' => $strikeout['timezone'],
    'acct_option' => $_POST['acctOption']
  );
  
  update_config($config_file, $fa);
  return $fa;
}
?>
