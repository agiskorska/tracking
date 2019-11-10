<?php
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
    // pull out data from the database

    for ($i=1; $i<1000; $i++) {
      $result = $connect->query("SELECT * FROM results_ass_1 WHERE row_no='$i'");
      $row = $result->fetch_assoc();
      $rown= $row['row_no'];
      $sid = $row['student_id'];
      $fdp = $row['q1'] + $row['q8'];
      $fact= $row['q2'] + $row['q4'] + $row['q5'];
      $sim = $row['q3'];
      $fon = $row['q6'];
      $sir = $row['q7'] + $row['q9'] + $row['q10'];
      $rr = $row['q11'] + $row['q12'];
      $ci = $row['q13'];
      $ps = $row['q14'];

      $sql = $connect->query("SELECT student_id FROM by_topics WHERE student_id = '$sid'");
      $count_users = $sql->num_rows;
      if($count_users!=0)
      {
        $sql->close();
        echo "All data has been already processed";
      } else {

        $query = "INSERT INTO by_topics
        (row_no, student_id, fdp_conv, factors, simp ,fractions_of_num,
          share_in_rat, reverse_rat, compound_intr, problem_solv)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("iiiiiiiiii", $rown, $sid, $fdp, $fact, $sim, $fon, $sir, $rr, $ci, $ps);
        $stmt->execute();
      }



    }

  }
} catch(Exception $e)
{
  echo '<span style="color:red;">Server error</span>';
  echo '<br>Developer Information: '.$e;
}






 ?>
