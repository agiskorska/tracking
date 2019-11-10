<?php
session_start();

if (!isset($_SESSION['registrationComplete']))
{
  header('Location: signin.php');

}

 ?>


<!DOCTYPE>


<html>
<head>
 <meta charset="utf-8">
 <title>Registration Complete - welcome to our server!</title>
</head>
<body>
Congratulations. You have successfully created the account and you are not a total imbecile.
<br>
<br>
Now you can move on to the students data. If you know the password.<br>
If you don't know the password, you might be asked to leave
the peremises.
Your P45 is waiting on your desk. Thank you for your service.

It's a joke. There is no password. Go and track your students' progress.
Agi
<br>

<a href="index.php">Log in to the servis</a>

</body>
</html>
