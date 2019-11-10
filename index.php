<?php

session_start();
if (isset($_SESSION['logged']) && ($_SESSION['logged']==true)) {
  header('Location: mainview.php');
  exit();
}
?>
<!DOCTYPE>
<html>
<head>
  <meta charset="utf-8">
<title>Student server - assessment tracking</title>
</head>
<body>
  The devil exists in details...
</br> </br>
  <a href = "signin.php">Sign in</a>
  </ br></ br>
 <form method="post" action="login-db.php">
Login: <br /><input type="text" name="login" /><br />
Password: <br /><input type="Password" name="password" /><br /><br />
<input type="submit" value="SUBMIT" />
</form>
<?php
if (isset($_SESSION['error'])) {
echo $_SESSION['error'];
unset($_SESSION['error']);
}
 ?>
 <a href="login-db.php">Log in</a><br>
 <a href="signin.php">Not registered yet? Set up an account</a>
</body>
</html>
