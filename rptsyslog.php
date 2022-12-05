<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 4))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
 require_once 'conn.php';

$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];
?>

     <h1><b><center><?php echo $coy; ?></center></b></h1>
     <h3><center><u>SYSTEM AUTO-LOG PRINTOUT</u></center></h3>

<TABLE width='100%' border='1' cellpadding='0' cellspacing='0' align='center' id="table3">
<?php

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];

   echo "Filtered using: " . $cmbFilter . "=" . $filter;
   echo "<TR bgcolor='#D2DD8F'><TH><b> User Category </b>&nbsp;</TH><TH><b> User Name </b>&nbsp;</TH><TH><b> Date Logged </b>&nbsp;&nbsp;</TH><TH><b> Time Logged </b>&nbsp;</TH> <TH><b> File Used </b>&nbsp;</TH> <TH><b> Details </b>&nbsp;</TH></TR>";

  if (trim(empty($cmbFilter)))
  {
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details` From Monitor order by `Date Logged on` desc, `Time Logged On` desc"); 
  } 
  else if (trim($cmbFilter)=="Show All (Asc)")
  {
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details` From Monitor order by `Date Logged on` asc, `Time Logged On` asc"); 
  }
  else if (trim($cmbFilter)=="" or trim($cmbFilter)=="Show All (Desc)")
  {
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details` From Monitor order by `Date Logged on` desc, `Time Logged On` desc"); 
  }
  else if (trim($cmbFilter)=="User Category")
  {  
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details` From `Monitor` WHERE `User Category`='" . $filter . "' order by `Date Logged On` Desc, `Time Logged On` desc");    
  }
  else if (trim($cmbFilter)=="User Name")
  {  
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details` From `Monitor` WHERE `User Name`='" . $filter . "' order by `Date Logged On` Desc, `Time Logged On` desc");
  }
  else if (trim($cmbFilter)=="Date Logged")
  {  
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details` From `Monitor` WHERE `Date Logged On`='" . $filter . "' order by `Date Logged On` Desc, `Time Logged On` desc");
  }

  while(list($cat, $name,$datel, $timel, $fileu, $det)=mysqli_fetch_row($result)) 
   {	
      echo "<TR><TH> $cat &nbsp;</TH><TH> $name &nbsp;</TH><TH> $datel &nbsp;</TH> <TH> $timel &nbsp;</TH> <TH> $fileu &nbsp;</TH>
      <TH> $det &nbsp;</TH></TR>";
   }

?>
</TABLE>
<br>
