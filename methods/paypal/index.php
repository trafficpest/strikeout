<?php

$path_to_root = '../..';
$path_to_pp = '.';

require_once $path_to_pp.'/inc/paypal.php';
$strikeout = load_strikeout_config($path_to_root.'/config/config.php');

// Set Action Url from default config if not set
if (empty($_POST['action_url'])){$_POST['action_url']=$strikeout['action_url'];}

//Use url variables first if available
if ( isset($_GET['amount']) ){ $_POST['amount'] = $_GET['amount']; }
if ( isset($_GET['name']) ) {$_POST['name'] = $_GET['name']; }
if ( isset($_GET['custId']) ) {$_POST['custId'] = $_GET['custId']; }
if ( isset($_GET['action_url']) ) {$_POST['action_url'] = $_GET['action_url']; }

// error if amount wasn't set
if ( empty( $_POST['amount'] ) ){
  echo '<center><h2>No invoice amount was set!</h2></center>';
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <!-- Replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>
    <script>
      paypal.Buttons({
        // Order is created on the server and the order id is returned
        createOrder() {
          return fetch("./assets/listeners/create-paypal-order.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            // use the "body" param to optionally pass additional order information
            // like product skus and quantities
            body: JSON.stringify({
              strikeout: {
                amount: "<?=$_POST['amount']?>",
                custId: "<?=$_POST['custId']?>",
                name: "<?=$_POST['name']?>",
                action_url: "<?=$_POST['action_url']?>"
                },
            }),
          })
          .then((response) => response.json())
          .then((order) => order.id);
        },
        // Finalize the transaction on the server after payer approval
        onApprove(data) {
          return fetch("./assets/listeners/capture-paypal-order.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              orderID: data.orderID
            })
          })
          .then((response) => response.json())
          .then((orderData) => {
            // Successful capture! For dev/demo purposes:
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            //alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '<center><h3>Thank you for your payment!</h3>'
              + '<a href="<?=$_POST['action_url']?>">Continue</a>';
          });
        }
      }).render('#paypal-button-container');
    </script>
  </body>
</html>

