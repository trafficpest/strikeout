<?php
$fa_url = 'https://'.$_SERVER['HTTP_HOST']
  .strtok($_SERVER['REQUEST_URI'], '?');

//$fa_url = str_replace('pages/','',$fa_url);
?>
<div class="bg-light rounded p-3 mb-3">
<h3>FA Location</h3>
<p class="text-center">StrikeOut includes a modified FrontAccounting. 
You can find it clicking below.</p>
<a href="../../books">FrontAccounting</a>
</div>
