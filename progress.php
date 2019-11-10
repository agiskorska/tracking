
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <title>Results by groups</title>
</head>
<body>

<h1>Progress Measured</h1>

<?php

include "includes\menu.php";
getMenu();

echo "<form method='post' action='progress.php'>";

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

          $query = $connect->query("SELECT * FROM `by_topics`
INNER JOIN by_topics1b
ON by_topics1b.student_id = by_topics.student_id
INNER JOIN 2hr_group
ON 2hr_group.student_id = by_topics.student_id
WHERE teacher = '$teacher' AND day = '$day' AND class_time = '$time'");

$num_row=$query-> num_rows;

if ($query-> num_rows >0) {
  #the top of the table
  echo "<table border='1'>
    <tr>
      <td><b>Student ID</b></td>
      <td><b>Name</b></td>
      <td><b>FDP CONVERSION</b></td>
      <td><b>Factors, multiples, primes</b></td>
      <td><b>Simplifying fractions, ratio</b></td>
      <td><b>Fractions of numbers</b></td>
      <td><b>Share in ratio</b></td>
      <td><b>Reverse ratio</b></td>
      <td><b>Compound intrest</b></td>
      <td><b>Problem Solving</b></td>
    </tr>";
  #data input for the table
for($i=1; $i<=8; $i++){
  ${"up$i"}=0;
  ${"same$i"}=0;
  ${"down$i"}=0;
  ${"master$i"}=0;
  ${"zero$i"}=0;
}
    while ($row = $query->fetch_assoc()) {



      $fn = $row['forename'];
      $sn = $row['surname'];
      $sid = $row['student_id'];
      $fdp = $row['fdp_conv'];
      $fact= $row['factors'];
      $sim = $row['simp'];
      $fon = $row['fractions_of_num'];
      $sir = $row['share_in_rat'];
      $rr = $row['reverse_rat'];
      $ci = $row['compound_intr'];
      $ps = $row['problem_solv'];

      $fdpb = $row['fdp_convb'];
      $factb= $row['factorsb'];
      $simb = $row['simpb'];
      $fonb = $row['fractions_of_numb'];
      $sirb = $row['share_in_ratb'];
      $rrb = $row['reverse_ratb'];
      $cib = $row['compound_intrb'];
      $psb = $row['problem_solvb'];




      //This code compares progress for CONVERSION between Fractions, %, decim.
      $fdp1 = $fdpb - $fdp;

      if ($fdpb==3) {
        $fdp1 = "<td bgcolor='#034303'><center>&#127775;</center></td>";
        $master1++;

      }else if ($fdp1 >0) {
        $fdp1 = "<td bgcolor='#00ff00'><center>$fdp1</center></td>";
        $up1++;

      } else if ($fdp1<0) {
          $fdp1 = "<td bgcolor='#FF0000'><center>$fdp1</center></td>";
          $down1++;

      } else if ($fdpb==0 && $fdp==0) {
          $fdp1 = "<td bgcolor='#1E0104' style='color:white'><center>$fdp1</center></td>";
          $zero1++;

      } else {
      $fdp1 = "<td bgcolor='#ffff00'><center>$fdp1</center></td>";

      }

      //This code compares progress for Factors, multiples and primes

      $fact1 = $factb - $fact;
      if ($factb==10) {
          $master2++;
          $fact1 = "<td bgcolor='#034303'><center>&#127775;</center></td>";
      }else if ($fact1>0) {
          $up2++;
          $fact1 = "<td bgcolor='#00ff00'><center>$fact1</center></td>";
      } else if ($fact1<0) {
          $down2++;
          $fact1 = "<td bgcolor='#FF0000'><center>$fact1</center></td>";

      } else if ($factb==0 && $fact==0) {
          $zero2++;
          $fact1 = "<td bgcolor='#1E0104' style='color:white'><center>$fact1</center></td>";

      } else {
          $fact1 = "<td bgcolor='#ffff00'><center>$fact1</center></td>";

      }


      //This code compares progress for Simplifying fractions

      $sim1 = $simb - $sim;

      if ($simb==3) {
          $master3++;
          $sim1 = "<td bgcolor='#034303'><center>&#127775;</center></td>";

      }else if ($sim1 >0) {
          $up3++;
          $sim1 = "<td bgcolor='#00ff00'><center>$sim1</center></td>";

      } else if ($sim1<0) {
          $down3++;
          $sim1 = "<td bgcolor='#FF0000'><center>$sim1</center></td>";

      } else if ($simb==0 && $sim==0) {
          $zero3++;
          $sim1 = "<td bgcolor='#1E0104' style='color:white'><center>$sim1</center></td>";

      } else {
          $sim1 = "<td bgcolor='#ffff00'><center>$sim1</center></td>";

      }


      //This code compares progress for Fractions of numbers

      $fon1 = $fonb - $fon;
      if ($fonb==2) {
          $master4++;
          $fon1 = "<td bgcolor='#034303'><center>&#127775;</center></td>";

      }else if ($fon1 >0) {
          $up4++;
          $fon1 = "<td bgcolor='#00ff00'><center>$fon1</center></td>";

      } else if ($fon1<0) {
          $down4++;
          $fon1 = "<td bgcolor='#FF0000'><center>$fon1</center></td>";

      } else if ($fonb==0 && $fon==0) {
          $zero4++;
          $fon1 = "<td bgcolor='#1E0104' style='color:white'><center>$fon1</center></td>";

      } else {
          $fon1 = "<td bgcolor='#ffff00'><center>$fon1</center></td>";

      }

      //This code compares progress for Sharing in ratio

      $sir1 = $sirb - $sir;
      if ($sirb==9) {
          $master5++;
          $sir1 = "<td bgcolor='#034303'><center>&#127775;</center></td>";
      } else if ($sir1 >0 || $sirb==9) {
          $up5++;
          $sir1 = "<td bgcolor='#00ff00'><center>$sir1</center></td>";
      } else if ($sir1 <0) {
          $down5++;
          $sir1 = "<td bgcolor='#FF0000'><center>$sir1</center></td>";

      } else if ($sirb==0 && $sir==0) {
          $zero5++;
          $sir1 = "<td bgcolor='#1E0104' style='color:white'><center>$sir1</center></td>";

      } else {
          $sir1 = "<td bgcolor='#ffff00'><center>$sir1</center></td>";

      }


      //This code compares progress for Reverse ratio

      $rr1 = $rrb - $rr;
      if ($rrb==7) {
          $master6++;
          $rr1 = "<td bgcolor='#034303'><center>&#127775;</center></td>";
      } else if ($rr1 >0) {
          $up6++;
          $rr1 = "<td bgcolor='#00ff00'><center>$rr1</center></td>";
      } else if ($rr1 <0) {
          $down6++;
          $rr1 = "<td bgcolor='#FF0000'><center>$rr1</center></td>";

      } else if ($rrb==0 && $rr==0) {
          $zero6++;
          $rr1 = "<td bgcolor='#1E0104' style='color:white'><center>$rr1</center></td>";

      } else {
          $rr1 = "<td bgcolor='#ffff00'><center>$rr1</center></td>";

      }


      //This code compares progress for Compound Interest

      $ci1 = $cib - $ci;
      if ($cib==3) {
          $master7++;
          $ci1 = "<td bgcolor='#034303'><center>&#127775;</center></td>";

      } else if ($ci1 >0) {
          $up7++;
          $ci1 = "<td bgcolor='#00ff00'><center>$ci1</center></td>";

      } else if ($ci1 <0) {
          $down7++;
          $ci1 = "<td bgcolor='#FF0000'><center>$ci1</center></td>";

      } else if ($cib ==0 && $ci==0) {
          $zero7++;
          $ci1 = "<td bgcolor='#1E0104' style='color:white'><center>$ci1</center></td>";

      } else {
          $ci1 = "<td bgcolor='#ffff00'><center>$ci1</center></td>";

      }


      //This code compares progress for Problem-solving
      $ps1 = $psb - $ps;
      if ($psb==3) {
            $master8++;
            $ps1 = "<td bgcolor='#034303'><center>&#127775;</center></td>";

      } else if ($ps1 >0) {

            $up8++;
            $ps1 = "<td bgcolor='#00ff00'><center>$ps1</center></td>";
      } else if ($ps1 <0) {
            $down8++;
            $ps1 = "<td bgcolor='#FF0000'><center>$ps1</center></td>";

      } else if ($psb == 0 && $ps==0) {
            $zero8++;
            $ps1 = "<td bgcolor='#1E0104' style='color:white'><center>$ps1</center></td>";

      } else {
          $ps1 = "<td bgcolor='#ffff00'><center>$ps1</center></td>";

      }


      echo "<tr><td>".$sid."</td><td>".$fn." ".$sn.
      "</td>".$fdp1,$fact1,$sim1,$fon1,$sir1,$rr1,$ci1,$ps1."</tr>";

    }
    for($i=1; $i<=8; $i++){
      ${"up$i"}=round((${"up$i"}/$num_row*100), 0); #the number of students who went up
      ${"same$i"}=round((${"same$i"}/$num_row*100), 0); #the number of students who stayed the same
      ${"down$i"}=round((${"down$i"}/$num_row*100), 0); #the number of students who went down
      ${"master$i"}=round((${"master$i"}/$num_row*100), 0); #the number of students who stayed the same but got max in both
      ${"prog$i"}=${"master$i"}+${"up$i"}; #the number of students who went up or mastered
      ${"zero$i"}=round((${"zero$i"}/$num_row*100), 0); #the number of students who did not progress and got 0 in both assessments
      ${"reg$i"}=${"down$i"}+${"zero$i"}; #the number of students who went down or didn't get anything in both assessments.
    }
    $avg_up=round(($up1+$up2+$up3+$up4+$up5+$up6+$up7+$up8)/8);
    $avg_down=round(($down1+$down2+$down3+$down4+$down5+$down6+$down7+$down8)/8);
    $avg_master=round(($master1+$master2+$master3+$master4+$master5+$master6+$master7+$master8)/8);
    $avg_zero=round(($zero1+$zero2+$zero3+$zero4+$zero5+$zero6+$zero7+$zero8)/8);
    $avg_prog=$avg_up+$avg_master;
    $avg_reg=$avg_down+$avg_zero;
#the part of the table with percentages per breakdown
  echo "<tr bgcolor='#00ff00'>
    <td>Total UP</td><td><b>".$avg_up."%<b></td><td>".$up1."</td><td>".$up2."</td><td>".$up3.
    "</td><td>".$up4."</td><td>".$up5."</td><td>".$up6."</td><td>".$up7."</td><td>".$up8."</td>
    </tr>
    <tr bgcolor='#FF0000'>
    <td>Total DOWN</td><td><b>".$avg_down."%<b></td><td>".$down1."</td><td>".$down2.
    "</td><td>".$down3."</td><td>".$down4."</td><td>".$down5."</td><td>".$down6."</td><td>"
    .$down7."</td><td>".$down8."</td>
    </tr>
    <tr bgcolor='#034303'>
    <td>Total MASTER</td><td><b>".$avg_master."%<b></td><td>".$master1."</td><td>".$master2.
    "</td><td>".$master3."</td><td>".$master4."</td><td>".$master5."</td><td>".$master6."</td><td>"
    .$master7."</td><td>".$master8."</td>
    </tr>
    <tr bgcolor='#0B16D3'>
    <td>Stayed @ 0</td><td><b>".$avg_zero."%</b></td><td>".$zero1."</td><td>".$zero2.
    "</td><td>".$zero3."</td><td>".$zero4."</td><td>".$zero5."</td><td>".$zero6."</td><td>"
    .$zero7."</td><td>".$zero8."</td>
    </tr>
    <tr bgcolor='#03085B' style='color:white'>
    <td>Went down or stayed @ 0</td><td><b>".$avg_reg."%</b></td><td>".$reg1."</td><td>".$reg2.
    "</td><td>".$reg3."</td><td>".$reg4."</td><td>".$reg5."</td><td>".$reg6."</td><td>"
    .$reg7."</td><td>".$reg8."</td>
    </tr>
    <tr bgcolor='#D30BBD' style='color:white'>
    <td>Total Progress</td><td><b>".$avg_prog."%</b></td><td>".$prog1."</td><td>".$prog2.
    "</td><td>".$prog3."</td><td>".$prog4."</td><td>".$prog5."</td><td>".$prog6."</td><td>"
    .$prog7."</td><td>".$prog8."</td>
    </tr>
    </table></br></br></br>";
  }

#this piece of code will choose 3 lowest areas for the class
#this is a very weak code - problems so far: if more topics have the same value, all are excluded from the array in the first go.
#I have to come up with more reasonable code for this
$highest1=0;
for ($i=1; $i<=7; $i++) {
  if ($highest1<=${"reg$i"}) {
$highest1 = ${"reg$i"};
  }
}

$highest2=0;
for ($i=1; $i<=7; $i++) {
  if ($highest2<=${"reg$i"} && ${"reg$i"}!=$highest1) {
$highest2 = ${"reg$i"};
  }
}

$highest3=0;
for ($i=1; $i<=7; $i++) {
  if ($highest3<=${"reg$i"} && ${"reg$i"}!=$highest1 && ${"reg$i"}!=$highest2) {
$highest3 = ${"reg$i"};
  }
}

#if any $reg.. are the same this chain will stop at the first met requirement for if. So if there are two areas with the same number only one will be shown!
  if ($highest1 == $reg1) {
    $area1= "Fractions, %, decim";
  } elseif ($highest1 == $reg2) {
    $area1= "Factors";
  } elseif ($highest1 == $reg3) {
    $area1= "Simplifying";
  } elseif ($highest1 == $reg4) {
    $area1= "Fractions of numbers";
  } elseif ($highest1 == $reg5) {
    $area1= "Share in ratio";
  } elseif ($highest1 == $reg6) {
    $area1= "Reverse Ratio";
  }  elseif ($highest1 == $reg7) {
    $area1= "Compound interest";
  }  elseif ($highest1 == $reg8) {
    $area1= "Problem Solving";
  } else {
    $area1= "Something went wrong";
  }

  if ($highest2 == $reg1) {
    $area2= "Fractions, %, decim";
  } elseif ($highest2 == $reg2) {
    $area2= "Factors";
  } elseif ($highest2 == $reg3) {
    $area2= "Simplifying";
  } elseif ($highest2 == $reg4) {
    $area2= "Fractions of numbers";
  } elseif ($highest2 == $reg5) {
    $area2= "Share in ratio";
  } elseif ($highest2 == $reg6) {
    $area2= "Reverse Ratio";
  }  elseif ($highest2 == $reg7) {
    $area2= "Compound interest";
  }  elseif ($highest2 == $reg8) {
    $area2= "Problem Solving";
  } else {
    $area2= "Something went wrong";
  }

  if ($highest3 == $reg1) {
    $area3= "Fractions, %, decim";
  } elseif ($highest3 == $reg2) {
    $area3= "Factors";
  } elseif ($highest3 == $reg3) {
    $area3= "Simplifying";
  } elseif ($highest3 == $reg4) {
    $area3= "Fractions of numbers";
  } elseif ($highest3 == $reg5) {
    $area3= "Share in ratio";
  } elseif ($highest3 == $reg6) {
    $area3= "Reverse Ratio";
  }  elseif ($highest3 == $reg7) {
    $area3= "Compound interest";
  }  elseif ($highest3 == $reg8) {
    $area3= "Problem Solving";
  } else {
    $area3= "Something went wrong";
  }

Echo "<h3>The areas for development for this class are as follows:</h3><h2>".$area1."<br>".$area2."<br>".$area3."</h2>";
#
#this is the end of this crazy code. come up with something better. c'mon!
      }
    }
  }   catch(Exception $e)
      {
        echo '<span style="color:red;">Server error</span>';
        echo '<br>Developer Information: '.$e;
      }
if(isset($query)){
  //barchart showing students' results as of per class
      $dataPoints1 = array(
        array("label"=> "Fractions, percentages, decimals", "y"=> $reg1),
        array("label"=> "Factors, multiples, primes", "y"=> $reg2),
        array("label"=> "Simplifying fractions, ratios", "y"=> $reg3),
        array("label"=> "Fractions of numbers", "y"=> $reg4),
        array("label"=> "Share in Ratio", "y"=> $reg5),
        array("label"=> "Reverse ratio", "y"=> $reg6),
        array("label"=> "Compound interest", "y"=> $reg7),
        array("label"=> "Problem solving", "y"=> $reg8)
      );
      $dataPoints2 = array(
        array("label"=> "Fractions, percentages, decimals", "y"=> $prog1),
        array("label"=> "Factors, multiples, primes", "y"=> $prog2),
        array("label"=> "Simplifying fractions, ratios", "y"=> $prog3),
        array("label"=> "Fractions of numbers", "y"=> $prog4),
        array("label"=> "Share in Ratio", "y"=> $prog5),
        array("label"=> "Reverse ratio", "y"=> $prog6),
        array("label"=> "Compound interest", "y"=> $prog7),
        array("label"=> "Problem solving", "y"=> $prog8)
      );



        #This is a part that is responsible for styles of the barchart

         echo "<div id='chartContainer' style='height: 370px; width: 100%;'></div>
         <script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
        }
 ?>
</body>
<head>

  <script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "dark1",
	title:{
		text: "Progress between Assessment 1 and 2"
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Students went up",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Students went down",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
</head>
</html>
