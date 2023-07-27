<div id="lnbits-button-container">
<form action="<?=$path_to_root.'/methods/lnbits'?>" 
  method="get">
    <input type="hidden" id="name" name="name" value="<?=$_POST['name']?>">
    <input type="hidden" id="custId" name="custId" value="<?=$_POST['custId']?>">
    <input type="hidden" id="action_url" name="action_url" 
      value="<?=$_POST['action_url']?>">
    <input type="hidden" id="amount" name="amount" 
      value="<?=$_POST['amount']?>">
    <button type="submit">
      <img 
        src="<?=$path_to_root?>/methods/lnbits/assets/images/btc-lightning.png" 
        height="24px" alt="Bitcoin"></button>  
    <p>Powered by <a href="https://lnbits.com" target="_blank">LNbits</a></p>
</form>
</div>
