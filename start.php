<?php

$path_to_root=".";

include_once 'inc/strike.php';
include 'inc/phpqrcode/qrlib.php';

//print_r($_POST);

if ( empty( $_POST['amount'] ) ){
  echo '<center><h2>No invoice amount was set!</h2></center>';
  exit;
}

$strike_invoice = issue_strike_invoice( 
  $_POST['amount'], 
  $_POST['name'], 
  $_POST['custId']
);

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

$file = $config['qr_img_dir'].uniqid();
QRcode::png( $strike_quote['lnInvoice'], $file, QR_ECLEVEL_M );

?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<body>

<center>
  <?=$strike_quote['description']?><br>
  $<?=$strike_quote['targetAmount']['amount']?><br>
  <img id="invoicePic" src="<?=$file?>" /><br>
<div id="result">
  Expires in <div style="display:inline;" id="secondsLeft">
    <?=$strike_quote['expirationInSec']?></div> seconds<br>
  <input 
    type="text"
    value="<?=$strike_quote['lnInvoice']?>"
    readonly>
  <button
    onclick="copyInvoice()" 
    type="button" 
    value="<?=$strike_quote['lnInvoice']?>" 
    id="lnInvoice">Copy
  </button><br>
  <button
    onclick="location.href='lightning:<?=$strike_quote['lnInvoice']?>';"
    type="button"
    id="openWallet">Open Wallet
    </button> 
</div>
</center>

<script src="<?=$path_to_root.'/assets/js/copyInvoice.js'?>"></script>
<script> 
  var path_to_root = "<?=$path_to_root?>";
  var action_url = "<?=$config['action_url']?>";
  var invoiceId = "<?=$strike_invoice['invoiceId']?>";
  var seconds = <?=$strike_quote['expirationInSec']?>;
</script>
<script src="<?=$path_to_root.'/assets/js/invoice.js'?>"></script>

</body>
</html>
