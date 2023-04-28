<?php
if ( isset($_POST['staticInvoice']) ){

$checkout_url = 'https://'.$_SERVER['HTTP_HOST']
  .strtok($_SERVER['REQUEST_URI'], '?');

$checkout_url = str_replace(
  'pages/invoice.php',
  'checkout.php',
  $checkout_url);

$query = '?amount='.urlencode($_POST['amount'])
  .'&name='.urlencode($_POST['name'])
  .'&custId='.urlencode($_POST['custId'])
  .'&action_url='.urlencode($_POST['action_url']);

$file = $path_to_root.'/'.$config['qr_img_dir'].'/static_l.png';
QRcode::png( $checkout_url.$query, $file, QR_ECLEVEL_L);
?>

<div class="container">
<div class="bg-light shadow rounded mt-3 mx-1">
  <h3 class="ps-3 pt-3">Static Invoice</h3>
  <p class="ms-3">Copy and paste this URL or image anywhere you want. For 
    example, paper invoices, in store, or emails.</p>
  <div class="row">
    <div class="col-12 text-center">
      <img id="invoicePic" src="<?=$file?>" />
    </div>
    <div class="col-10">
      <input
        class="form-control mb-3"
        type="text"
        id="staticUrl"
        name="staticUrl"
        value="<?=$checkout_url.$query?>"
        readonly>
    </div>
    <div class="col-2">
      <button
        onclick="copyInvoice()" 
        class="btn btn-warning"
        type="button" 
        value="<?=$checkout_url.$query?>" 
        id="lnInvoice">Copy
      </button>
    </div>
  </div>
</div>
</div>
<script src="<?=$path_to_root?>/assets/js/copyInvoice.js"></script>

<?php
}

?>
