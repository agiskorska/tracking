<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Results by groups</title>
</head>
<body>


<?php
include "includes\menu.php";
getMenu();
require_once "connect.php";
$connect = new mysqli($host, $user, $pass, $db_name);

echo "<form action='smart-targets.php' method='post'>";
include "includes\droplists.php";
echo "</form>";



if(isset($_POST['teacher'])) {
  for ($i = 1; $i <= 14; $i++) {
    ${"s$i"} = 0;
  }


  $teacher = $_POST['teacher'];
  $day = $_POST['day'];
  $time = $_POST['class_time'];

$query = $connect->query("SELECT 2hr_group.student_id, full_name,
q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14
FROM results_ass_1b
INNER JOIN 2hr_group
ON results_ass_1b.student_id=2hr_group.student_id
WHERE teacher='$teacher'
AND day='$day'
AND class_time='$time'");

if($query-> num_rows >0)
{
  echo "<table border='1'>
    <tr>
      <td><b>Full Name</b></td>
      <td><b>Q1</b></td>
      <td><b>Q2</b></td>
      <td><b>Q3</b></td>
      <td><b>Q4</b></td>
      <td><b>Q5</b></td>
      <td><b>Q6</b></td>
      <td><b>Q7</b></td>
      <td><b>Q8</b></td>
      <td><b>Q9</b></td>
      <td><b>Q10</b></td>
      <td><b>Q11</b></td>
      <td><b>Q12</b></td>
      <td><b>Q13</b></td>
      <td><b>Q14</b></td>
    </tr>";
  while($row=$query->fetch_assoc())
  {
$fn = $row['full_name'];

for ($i = 1; $i <= 14; $i++) {
  ${"smt$i"} = '';
}


      for ($i = 1; $i <= 14; $i++) {
        ${"q$i"} = $row["q$i"];
      }

    if($q1==0) {
      $s1++;
      $smt1='&#127993';
    } else if($q2==0){
      $s2++;
      $smt2='&#127993';
    } else if($q3==0){
      $s3++;
      $smt3='&#127993';
    } else if($q4==0){
      $s4++;
      $smt4='&#127993';
    } else if($q5==0){
      $s5++;
      $smt5='&#127993';
    } else if($q6==0){
      $s6++;
      $smt6='&#127993';
    } else if($q7==0){
      $s7++;
      $smt7='&#127993';
    } else if($q8==0){
      $s8++;
      $smt8='&#127993';
    } else if($q9==0){
      $s9++;
      $smt9='&#127993';
    } else if($q10==0){
      $s10++;
      $smt10='&#127993';
    } else if($q11==0){
      $s11++;
      $smt11='&#127993';
    } else if($q12==0){
      $s12++;
      $smt12='&#127993';
    } else if($q13==0){
      $s13++;
      $smt13='&#127993';
    } else if($q14==0){
      $s14++;
      $smt14='&#127993';
    } else if($q1==1) {
      $s1++;
      $smt1='&#127993';
    } else if($q2==1){
      $s2++;
      $smt2='&#127993';
    } else if($q3==1){
      $s3++;
      $smt3='&#127993';
    } else if($q4==1){
      $s4++;
      $smt4='&#127993';
    } else if($q5==1){
      $s5++;
      $smt5='&#127993';
    } else if($q6==1){
      $s6++;
      $smt6='&#127993';
    } else if($q7==1){
      $s7++;
      $smt7='&#127993';
    } else if($q8==1){
      $s8++;
      $smt8='&#127993';
    } else if($q9==1){
      $s9++;
      $smt9='&#127993';
    } else if($q10==1){
      $s10++;
      $smt10='&#127993';
    } else if($q11==1){
      $s11++;
      $smt11='&#127993';
    } else if($q12==1){
      $s12++;
      $smt12='&#127993';
    } else if($q13==1){
      $s13++;
      $smt13='&#127993';
    } else if($q14==1){
      $s14++;
      $smt14='&#127993';
    } else {
      echo $row['student_id'];
    }



      echo "<tr>
      <td>$fn</td>
      <td>".$smt1."</td><td>"
      .$smt2."</td><td>"
      .$smt3."</td><td>"
      .$smt4."</td><td>"
      .$smt5."</td><td>"
      .$smt6."</td><td>"
      .$smt7."</td><td>"
      .$smt8."</td><td>"
      .$smt9."</td><td>"
      .$smt10."</td><td>"
      .$smt11."</td><td>"
      .$smt12."</td><td>"
      .$smt13."</td><td>"
      .$smt14."</td></tr>";

  }




    echo "<tr>
    <td></td>
    <td>".$s1."</td><td>"
    .$s2."</td><td>"
    .$s3."</td><td>"
    .$s4."</td><td>"
    .$s5."</td><td>"
    .$s6."</td><td>"
    .$s7."</td><td>"
    .$s8."</td><td>"
    .$s9."</td><td>"
    .$s10."</td><td>"
    .$s11."</td><td>"
    .$s12."</td><td>"
    .$s13."</td><td>"
    .$s14."</td></br></br></br></tr>";
  } else {
   echo "This group does not exist!";
  }
}



  ?>

</body>
</html>
