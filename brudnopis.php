<?
$reg1=10;
$reg2=8;
$reg3=0;
$reg4=100;
$reg5=9;
$reg6=200;
$reg7=100;
$reg8=200;

$highest=0;
for ($i=1, $i<=7, $i++) {
  if (${"reg$i"}<=${"reg$i++"}) {
$highest = ${"reg$i++"};
  }
  echo "THE HIGHEST IS".$highest;

  ?>
  if ($$highest3 == $reg1) {
    $area3= "Fractions, %, decim";
  } elseif ($$highest3 == $reg2) {
    $area3= "Factors";
  } elseif ($$highest3 == $reg3) {
    $area3= "Simplifying";
  } elseif ($$highest3 == $reg4) {
    $area3= "Fractions of numbers";
  } elseif ($$highest3 == $reg5) {
    $area3= "Share in ratio";
  } elseif ($$highest3 == $reg6) {
    $area3= "Reverse Ratio";
  }  elseif ($$highest3 == $reg7) {
    $area3= "Compound interest";
  }  elseif ($$highest3 == $reg8) {
    $area3= "Problem Solving";
  } else {
    $area3= "Something went wrong";
  }
