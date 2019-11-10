<?php
session_start();

if(isset($_POST['email']))
{
  //Validation successfull? Let's assume, yes!
  $evrthng_OK=true;

  //Check validation of username
  $login = $_POST['login'];

  //Check length of username
  if ((strlen($login)<3) || (strlen($login)>20)) {
    $evrthng_OK=false;
    $_SESSION['e_user']="Username has to be between 3-20 characters";
  }
  if (ctype_alnum($login)==false)
  {
      $evrthng_OK=false;
      $_SESSION['e_user']="Username can only contain numbers & letters";
  }
  //check if email is correct
  $email = $_POST['email'];
  $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);


  if((filter_var($emailS, FILTER_VALIDATE_EMAIL)==false) || ($emailS!=$email))
  {
    $evrthng_OK=false;
    $_SESSION['e_email'] = "Provide correct e-mail address";
  }

  //check if password correct

  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];

  if (strlen($pass1)<6 || (strlen($pass2)>20))
  {
    $evrthng_OK=false;
    $_SESSION['e_pass'] = "Password has to be between 6-20 characters";

  }

  if ($pass1!=$pass2)
  {
    $evrthng_OK=false;
    $_SESSION['e_pass'] = "Provided passwords are different!";
  }


  $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);


  //Ts&Cs accepted?
  if (!isset($_POST['T&Cs']))
  {
    $evrthng_OK=false;
    $_SESSION['e_terms'] = "Please accept the Ts & Cs";
  }

  //BOt or not
  $secret = "6LfRlr0UAAAAAF78n61AbIu1CbP1tafPRGIcwsbF";
  $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
  $resp = json_decode($check);

  if ($resp->success==false)
  {
    $evrthng_OK=false;
    $_SESSION['e_bot'] = "Confirm that you are a human";
  }

  require_once "connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);
  try
  {
  $connect = new mysqli($host, $user, $pass, $db_name);
  if ($connect->connect_errno!=0)
    {
      throw new Exception(mysqli_connect_errno());
    } else {
    //check if username is not already taken
    $result=$connect->query("SELECT login FROM logins WHERE login='$login'");

      if (!$result) throw new Exception($connect->error);

      $how_many_users = $result->num_rows;
          if($how_many_users>0)
          {
            $evrthng_OK=false;
            $_SESSION['e_user']="Username has been taken";
          }

      $connect->close();
      }
    }
  catch(Exception $e)
  {
    echo '<span style="color:red;">Server error</span>';
    echo '<br>Developer Information: '.$e;
  }
  if ($evrthng_OK==true)
  {
    //All tests completed, adding user to the db
  require_once "connect.php";
  $connect=mysqli_report(MYSQLI_REPORT_STRICT);
  try {
    $connect= new mysqli($host, $user, $pass, $db_name);
    if ($connect->connect_errno!=0) {
      throw new Exception(mysqli_connect_errno());
    } else {
      //insert user into database.
      if ($connect->query("INSERT INTO logins (user_id, login, password, email) VALUES (NULL, '$login', '$pass_hash', '$email')"))
      {
        $_SESSION['registrationComplete']=true;
        header('Location: welcome.php');
      } else {
        throw new Exception($connect->error);
      }
    }

  } catch (Exception $e) {
    echo '<span style="color:red;">Server error</span>';
    echo '<br>Developer Information: '.$e;
  }


    exit;
  }

}

?>


<!DOCTYPE>
<html>
<head>
  <meta charset="utf-8">
  <title>Sign up!</title>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <style>
  .error
  {
    color:red;
    margin-top: 10px
    margin-bottom: 10px
  }
  </style>

</head>
<body>
  <form method="post">
    First name:  <input name="login" type="text" /></br>
    <?php
    if (isset($_SESSION['e_user']))
    {
      echo '<div class="error">'.$_SESSION['e_user'].'</div>';
      unset($_SESSION['e_user']);
    }
     ?>
    E-mail:  <input name="email" type="text" /></br>
    <?php
    if (isset($_SESSION['e_email']))
    {
      echo '<div class="error">'.$_SESSION['e_email'].'</div>';
      unset($_SESSION['e_email']);
    }
     ?>
    Password: <input name="pass1" type="password" /></br>
    Repeat password: <input name="pass2" type="password" /></br>
    <?php
    if (isset($_SESSION['e_pass']))
    {
      echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
      unset($_SESSION['e_pass']);
    }
     ?>
    <label>
        <input name="T&Cs" type="checkbox" />I read the Ts&Cs
    </label>

    <?php
    if (isset($_SESSION['e_terms'])) {
      echo '<div class="error">'.$_SESSION['e_terms'].'</div>';
      unset($_SESSION['e_terms']);
    }
     ?>
    <div class="g-recaptcha" data-sitekey="6LfRlr0UAAAAAPb44d2-pvSJtJd5uXPZGiGBTeqh
    "></div>
    <?php
    if (isset($_SESSION['e_bot']))
    {
      echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
      unset($_SESSION['e_bot']);
    }
     ?>
    <input type="submit" value="SUBMIT" />
  </form>
</body>
</html>
