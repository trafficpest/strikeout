<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>


<body class="bg-dark">

<div class="container bg-light shadow rounded mt-5 w-50">

<form class="p-3" 
  action="<?=$path_to_root.'/index.php'?>" method="post">
  <h1>Strikeout Access</h1>
  <div class="mb-3">
    <label for="username" class="form-label">User:</label>
    <input type="text" class="form-control" id="username" name="username" readonly
      value="<?=$config['payee_name']?>">
  </div>
  <div class="mb-3">
    <label for="username" class="form-label">User:</label>
    <label for="password" class="form-label">Password:</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
    <input type="hidden" id="login" name="login" value="true" >
  <div class="mb-3">
    <button type="submit" class="btn btn-success" value="Submit">Login
    </button>
  </div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

