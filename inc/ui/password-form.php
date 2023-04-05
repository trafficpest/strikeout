<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="<?=$path_to_root.'/assets/css/style.css'?>">
</head>


<body>

<div class="container">
<h1>Strikeout Access</h1>

<form action="<?=$path_to_root.'/index.php'?>" method="post">
  <label for="username">User:</label>
  <input type="text" id="username" name="username" readonly
    value="<?=$config['payee_name']?>" required>
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required>
  <input type="hidden" id="login" name="login" value="true" >
  <input type="submit" value="Submit">  
</form>
</div>

</body>
</html>

