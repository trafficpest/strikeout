<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="./assets/css/style.css">
</head>


<body>

<div class="container">
<h1>Strike API test page</h1>

<form action="./start.php" method="post">
  <label for="name">Your Name:</label>
  <input type="text" id="name" name="name">
  <label for="custId">Cusomer ID:</label>
  <input type="text" id="custId" name="custId" >
  <label for="amount">Amount:</label>
  <input type="text" id="amount" name="amount" required>
  <input type="submit" value="Submit">  
</form>
</div>

</body>
</html>

