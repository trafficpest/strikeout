<div class="container">
<h1>Configure Strikeout</h1>

<form action="<?=$path_to_root.'/index.php'?>" method="post">
  <label for="payeeName">Payee Name:</label>
  <input type="text" id="payeeName" name="payeeName"
    value="<?=$config['payee_name']?>" required>
  <label for="apiKey">Api Key:</label>
  <input type="text" id="apiKey" name="apiKey"
  value="<?=$config['api_key']?>" required>
  <label for="qrDir">QR Image Dir:</label>
  <input type="text" id="qrDir" name="qrDir"
    value="<?=$config['qr_img_dir']?>" >
  <label for="actionUrl">Redirect After Payment:</label>
  <input type="text" id="actionUrl" name="actionUrl" required
    value="<?=$config['action_url']?>" >
  <label for="timezone">Timezone:</label>
  <? include_once $path_to_root.'/inc/ui/timezones.php'; ?>
  <label for="secret">Webhook Secret & Password:</label>
  <input type="text" id="secret" name="secret" 
  value="<?=$config['secret']?>" required>
  <input type="hidden" id="configForm" name="configForm" 
  value="true" >
  <input type="submit" value="Submit">  
</form>
</div>

