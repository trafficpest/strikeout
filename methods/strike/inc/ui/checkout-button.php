<div id="strike-button-container">
<form action="<?=$path_to_root.'/methods/strike'?>" 
  method="get">
    <input type="hidden" id="name" name="name" value="<?=$_POST['name']?>">
    <input type="hidden" id="custId" name="custId" value="<?=$_POST['custId']?>">
    <input type="hidden" id="action_url" name="action_url" 
      value="<?=$_POST['action_url']?>">
    <input type="hidden" id="amount" name="amount" 
      value="<?=$_POST['amount']?>">
    <div class="d-grid gap-3 mb-3" style="max-width: 749px;">
    <button class="btn btn-success p-3" type="submit">
      <img 
        src="<?=$path_to_root?>/methods/strike/assets/images/btc-lightning.png" 
        height="24px" alt="Bitcoin"></button>  
    <p class="text-center fst-italic fw-lighter fs-6">Powered by <strong>Strike</strong></p>
    </div>
</form>
</div>
