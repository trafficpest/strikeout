function copyInvoice() {
  var copyInvoice = document.getElementById("lnInvoice").value;
 
  navigator.clipboard.writeText(copyInvoice)
    .then(() => {
      alert("successfully copied");
     })
    .catch(() => {
      alert("something went wrong");
    });
             
}
