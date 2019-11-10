<?php

session_start();

if(!isset($_SESSION['logged'])) {
  header('Location: index.php');
  exit();
}

if(isset($_SESSION['entrySuccessfull'])) {
  echo "Entry was successfully updated in the database";
}



if(isset($_POST['student_id']))
{
  $everything_ok=true;

    if(strlen($_POST['student_id'])!==8)
    {
      $everything_ok=false;
      $_SESSION['e-sid']= "Enter correct student number!";
      unset($_POST['student_id']);
    } else if(strlen($_POST['fn']) == 0 || strlen($_POST['ln']) == 0 || strlen($_POST['dept']) == 0)
    {
      $everything_ok=false;
      $_SESSION['e-sin']="Enter correct student information!";
    } else if(!isset($_POST['1'])) {
      $everything_ok=false;
      $_SESSION['e-ass']="Choose the assessment";
    } else if($everything_ok){

        require_once "connect.php";

        $connect=mysqli_report(MYSQLI_REPORT_STRICT);
        try {
          $connect= new mysqli($host, $user, $pass, $db_name);
          if ($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno());
          } else {
            //insert user into database.
            $ass= "results_ass_1".$_POST['1'];
            $sid = $_POST['student_id'];
            $fn = $_POST['ln']." ".$_POST['fn'];
            $dep = $_POST['dept'];
            $q1 = $_POST['q1'];
            $q2 = $_POST['q2'];
            $q3 = $_POST['q3'];
            $q4 = $_POST['q4'];
            $q5 = $_POST['q5'];
            $q6 = $_POST['q6'];
            $q7 = $_POST['q7'];
            $q8 = $_POST['q8'];
            $q9 = $_POST['q9'];
            $q10 = $_POST['q10'];
            $q11 = $_POST['q11'];
            $q12 = $_POST['q12'];
            $q13 = $_POST['q13'];
            $q14 = $_POST['q14'];
            $tot = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9 + $q10 + $q11 + $q12 + $q13 + $q14;
            $perc = $tot/40*100;
            if ($connect->query(
              "INSERT INTO $ass (student_id, full_name, dept, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, total, percentage) VALUES
              ('$sid', '$fn', '$dep', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6', '$q7', '$q8',
                '$q9', '$q10', '$q11', '$q12', '$q13', '$q14', '$tot', '$perc')"))
            {
              $_SESSION['entrySuccessfull']=true;
              header('Location: enternew.php');

            } else {
              throw new Exception($connect->error);
            }
          }

        } catch (Exception $e) {
          echo '<span style="color:red;">Server error</span>';
          echo '<br>Developer Information: '.$e;
        }
      }


}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Enter New Record</title>
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
<h1>Enter the student's data</h1>

<?php require "includes\menu.php";
getMenu();

if (isset($_SESSION['e-sin']))
{
 echo "<div class='error'>".$_SESSION['e-sin']."</div>";
 unset($_SESSION['e-sin']);

}

?>

<form action="enternew.php" id="enternew" method="post">
Student ID:
<?php

 if (isset($_SESSION['e-sid']))
{
  echo "<div class='error'>".$_SESSION['e-sid']."</div>";
  unset($_SESSION['e-sid']);

}
?>
<input type="text" name="student_id" minlength="8" maxlength="8"><br>
First Name:



<input type="text" name="fn"><br>
Last Name:
<input type="text" name="ln"><br>
Department(in four letters):
<input type="text" name="dept" minlength="4" maxlength="4"><br>
Which assessment:<br>
<input type="radio" name="1" value="A">A<input type="radio" name="1" value="B">B<br>


<?php

 if (isset($_SESSION['e-ass']))
{
  echo "<div class='error'>".$_SESSION['e-ass']."</div>";
  unset($_SESSION['e-ass']);

}
?>
Q1:
<input type="number" maxlength="1" name="q1"><br>
Q2:
<input type="number" maxlength="1" name="q2"><br>
Q3:
<input type="number" maxlength="1" name="q3"><br>
Q4:
<input type="number" maxlength="1" name="q4"><br>
Q5:
<input type="number" maxlength="1" name="q5"><br>
Q6:
<input type="number" maxlength="1" name="q6"><br>
Q7:
<input type="number" maxlength="1" name="q7"><br>
Q8:
<input type="number" maxlength="1" name="q8"><br>
Q9:
<input type="number" maxlength="1" name="q9"><br>
Q10:
<input type="number" maxlength="1" name="q10"><br>
Q11:
<input type="number" maxlength="1" name="q11"><br>
Q12:
<input type="number" maxlength="1" name="q12"><br>
Q13:
<input type="number" maxlength="1" name="q13"><br>
Q14:
<input type="number" maxlength="1" name="q14"><br><br>


<input type="submit">
</form>

</body>
</html>
