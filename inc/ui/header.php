<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="<?=$path_to_root.'/assets/css/style.css'?>">
</head>


<body>

<a href="<?=$path_to_root.'/invoice.php'?>">Invoice</a>
<a href="<?=$path_to_root.'/webhooks.php'?>">Webhooks</a>
<a href="<?=$path_to_root.'/index.php'?>">Configure</a>
<a href="<?=strtok($_SERVER["REQUEST_URI"], '?').'?logout=true'?>">Logout</a>

