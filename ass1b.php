<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Results by groups</title>
</head>
<body>

<h2>Assessment results</h2>
<?php

require_once "includes\menu.php";
getMenu();

echo "<form method='post' action='ass1b.php'>";

require "includes\droplists.php";

echo "</form>";

session_start();

if(!isset($_SESSION['logged'])) {
  header('Location: index.php');
  exit();
}

  require_once 'connect.php';

  mysqli_report(MYSQLI_REPORT_STRICT);

  try
  {
    $connect = new mysqli($host, $user, $pass, $db_name);
    if($connect->connect_errno!=0)
    {
      throw new Exception(mysqli_connect_errno());
    } else {
      if(isset($_POST['teacher']))
      {
          $teacher = $_POST['teacher'];
          $day = $_POST['day'];
          $time = $_POST['class_time'];



          $query = $connect->query("SELECT *
          FROM by_topics1b
          INNER JOIN 2hr_group
          ON by_topics1b.student_id = 2hr_group.student_id
          INNER JOIN results_ass_1b
          ON by_topics1b.student_id = results_ass_1b.student_id
          WHERE teacher ='$teacher' AND day = '$day' AND class_time = '$time'
          ");

      if ($query-> num_rows >0) {
        echo "<table border='1'>
          <tr>
            <td><b>Student ID</b></td>
            <td><b>Name</b></td>
            <td><b>Department</b></td>
            <td><b>FDP CONVERSION</b></td>
            <td><b>Factors, multiples, primes</b></td>
            <td><b>Simplifying fractions, ratio</b></td>
            <td><b>Fractions of numbers</b></td>
            <td><b>Share in ratio</b></td>
            <td><b>Reverse ratio</b></td>
            <td><b>Compound intrest</b></td>
            <td><b>Problem Solving</b></td>
          </tr>";

          while ($row = $query->fetch_assoc()) {



            $fn = $row['forename'];
            $sn = $row['surname'];
            $dep = $row['dept'];
            $sid = $row['student_id'];
            $fdp = round($row['fdp_convb']/3*100)."%";
            $fact= round($row['factorsb']/10*100)."%";
            $sim = round($row['simpb']/3*100)."%";
            $fon = round($row['fractions_of_numb']/2*100)."%";
            $sir = round($row['share_in_ratb']/9*100)."%";
            $rr = round($row['reverse_ratb']/7*100)."%";
            $ci = round($row['compound_intrb']/3*100)."%";
            $ps = round($row['problem_solvb']/3*100)."%";

            echo "<tr><td>".$sid."</td><td>".$fn." ".$sn."</td><td>"
            .$dep."</td><td>".$fdp."</td><td>"
            .$fact."</td><td>".$sim."</td><td>".$fon."</td><td>".$sir."</td><td>"
            .$rr."</td><td>".$ci."</td><td>".$ps."</td></tr>";

          }
          echo "</table></br></br></br>";
        }

    } else {
    echo "Please choose the group";
  }

}
    }
   catch(Exception $e)
  {
    echo '<span style="color:red;">Server error</span>';
    echo '<br>Developer Information: '.$e;
  }

 ?>

</body>
</html>
