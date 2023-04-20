<?php

$path_to_root=".";

ini_set('log_errors', 1);
ini_set('error_log', $path_to_root.'/logs/checkout.log');

include_once 'inc/strike.php';
include 'inc/phpqrcode/qrlib.php';

//Use url variables first if available
if ( isset($_GET['amount']) ){ $_POST['amount'] = $_GET['amount']; }
if ( isset($_GET['name']) ) {$_POST['name'] = $_GET['name']; }
if ( isset($_GET['custId']) ) {$_POST['custId'] = $_GET['custId']; }

// error if amount wasn't set
if ( empty( $_POST['amount'] ) ){
  echo '<center><h2>No invoice amount was set!</h2></center>';
  exit;
}
// null if empty
if ( empty($_POST['name']) ){$_POST['name'] = null;}
if ( empty($_POST['custId']) ){$_POST['custId'] = 'No Reference';}

$strike_invoice = issue_strike_invoice( 
  $_POST['amount'], 
  $_POST['name'], 
  $_POST['custId']
);

// error if strike didnt return a invoice
if ( !isset( $strike_invoice['invoiceId'] ) ){
  echo "
    <center><h2>There was an error</h2>
    <p>Bitcoin Lightning invoice was not generated<br>
    Check config is set correctly and post data was valid<br>
    The responce given was:<br><br></p></center>";

  print("<pre>".print_r($strike_invoice,true)."</pre>");
  exit;
}

$strike_quote = issue_strike_quote( $strike_invoice['invoiceId'] );

$file = $config['qr_img_dir'].'/'.uniqid().'.png';
QRcode::png( $strike_quote['lnInvoice'], $file, QR_ECLEVEL_L, 4 );

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
<div class="inv-container">
  <div class="strikeInvoice">

  <h3>Bitcoin Lightning Invoice</h3>

  <div class="description">
    <?=$strike_quote['description']?>
  </div>
  <div class="amount">
    $<?=$strike_quote['targetAmount']['amount']?>
  </div>
  <div class="qrcode">
    <img id="invoicePic" src="<?=$file?>" />
  </div>
  <div id="result">
    <div id="expirationLine">Expires in 
      <div id="secondsLeft"><?=$strike_quote['expirationInSec']?></div>
       seconds</div>
    <div class="copyInvoice">
      <input 
        type="text"
        value="<?=$strike_quote['lnInvoice']?>"
        readonly>
      <button
        onclick="copyInvoice()" 
        type="button" 
        value="<?=$strike_quote['lnInvoice']?>" 
        id="lnInvoice">Copy
      </button>
    </div>
      <button
        onclick="location.href='lightning:<?=$strike_quote['lnInvoice']?>';"
        type="button"
        id="openWallet">Open Wallet
        </button> 
    </div>
  </div>
  <p>Pay with any lightning wallet, while merchants receive dollars using 
  <a href="https://strike.me">Strike</a>.</p>
  <p><strong>Powered by 
  <a href="https://github.com/trafficpest/strikeout">Strikeout</a>
  </strong></p>
</div>

<script> 
  var path_to_root = "<?=$path_to_root?>";
  var action_url = "<?=$config['action_url']?>";
  var invoiceId = "<?=$strike_invoice['invoiceId']?>";
  var seconds = <?=$strike_quote['expirationInSec']?>;
</script>
<script src="<?=$path_to_root.'/assets/js/invoice.js'?>"></script>
<script src="<?=$path_to_root.'/assets/js/copyInvoice.js'?>"></script>

</body>
</html>
