    <!-- Replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>
    <script>
      paypal.Buttons({
        // Order is created on the server and the order id is returned
        createOrder() {
          return fetch("<?=$path_to_root?>/methods/paypal/assets/listeners/create-paypal-order.php", {
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
          return fetch("<?=$path_to_root?>/methods/paypal/assets/listeners/capture-paypal-order.php", {
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
            const element = document.getElementById('strikeout-button-container');
            element.innerHTML = '<center><h3>Thank you for your payment!</h3>'
              + '<a href="<?=$_POST['action_url']?>">Continue</a>';
          });
        }
      }).render('#paypal-button-container');
    </script>

