// variables defined outside of file passed from php
// path_to_root, action_url, invoiceId, seconds

var secondsLeft = document.getElementById('secondsLeft');

function decreaseSeconds(){
  if (seconds <= 0){
    stopTimer();
    source.close();
  }else{
  seconds -= 1;
  secondsLeft.innerText = seconds;  
  }
}

var timerId = setInterval(decreaseSeconds, 1000);

function stopTimer(){
  document.getElementById('invoicePic').src = path_to_root
    + '/assets/images/expired.png';
  clearInterval(timerId);
  document.getElementById("result").innerHTML = "<h3>Expired</h3>"
    + `<button onclick="window.location.reload();">`
    + "Renew Invoice</button>";

}

if(typeof(EventSource) !== "undefined" ) {
  var source = new EventSource( path_to_root + "/inc/pay-status.php"
      + "?invoiceId=" + invoiceId );
  source.onmessage = function(event) {
    if (event.data == 'PAID'){
      stopTimer();
      source.close();
      document.getElementById('invoicePic').src = path_to_root
        + "/assets/images/paid.png" ;
      document.getElementById("result").innerHTML = "<h3>PAID</h3>"
        + `<button onclick="window.location.href= action_url;">`
        + "Continue</button>";
    }
  };
} else {
      document.getElementById("result").innerHTML = "Sorry, "
        + "your browser does not support server-sent events...";
  }  
