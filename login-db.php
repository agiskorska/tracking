<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
  header('Location: index.php');
  exit();
}

require_once "connect.php";
$connect = @new mysqli($host, $user, $pass, $db_name);

if ($connect->connect_errno!=0) {
  echo "error:".$connect->connect_errno;
} else {

  $login = $_POST['login'];
  $password = $_POST['password'];

  $login = htmlentities($login, ENT_QUOTES, "UTF-8");




if ($query = @$connect->query(
  sprintf("SELECT * FROM logins WHERE login='%s'",
mysqli_real_escape_string($connect, $login))))
{
  $count_users = $query->num_rows;

  if ($count_users>0) {
  $row = $query->fetch_assoc();

  if (password_verify($password, $row['password'])==true)
  {
        $_SESSION['logged'] = true;

        $_SESSION['id'] = $row['user_id'];
        $_SESSION['login'] = $row['login'];
        $_SESSION['email'] = $row['email'];

        unset($_SESSION['error']);
        $query->close();
        header('Location: mainview.php');
    }  else {
    $_SESSION['error'] = '<span style="color:red">Wrong username or password!</span>';
    header('Location: index.php');
    }
  } else {
$_SESSION['error'] = '<span style="color:red">Wrong username or password!</span>';
header('Location: index.php');

  }
}
  $connect->close();
}


 ?>
