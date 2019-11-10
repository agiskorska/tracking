<?php

session_start();

if(!isset($_SESSION['logged'])) {
  header('Location: index.php');
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
<?php
echo "<p>Welcome ".$_SESSION['login']."!";
echo "<a href='logout.php'>Log out</a>";
echo "<br />I hope you are having an amazing day!";
echo "<br />Your ID: ".$_SESSION['id']."<br />";
echo '<a href="'.$_SESSION['email'].'">'.$_SESSION['email'];

require_once "includes\menu.php";
getMenu();
?>
</body>
</html>
