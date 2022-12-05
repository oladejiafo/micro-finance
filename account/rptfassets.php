<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3)  & ($_SESSION['access_lvl'] != 6) & ($_SESSION['access_lvl'] != 5))
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
?>

     <h1><b><center><?php echo $coy; ?></center></b></h1>
     <h3><center><u>FIXED ASSETS REGISTER</u></center></h3>

<TABLE width='90%' border='1' cellpadding='0' cellspacing='0' align='center' id="table3">
<?php

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];

  if ($cmbFilter =="Sold Assets")
  {
    $cmbFilter =="Sold";
    $filter ==1;
  }

 echo "<font color='#FF0000' style='font-size: 9pt'>" . $tval . "</font>";
 echo "Filtered using: " . $cmbFilter . "=" . $filter;
 echo "<p>";

    echo "<TR bgcolor='#dcdfdf'><TH><b><u>Asset Code </b></u>&nbsp;</TH><TH><b><u>Location </b></u>&nbsp;</TH><TH><b><u>Category </b></u>&nbsp;</TH><TH><b><u>Name</b></u>&nbsp;</TH>
      <TH><b><u>Quantity </b></u>&nbsp;</TH><TH><b><u>Status </b></u>&nbsp;</TH><TH><b><u>Serial No </b></u>&nbsp;</TH></TR>";

  if ($cmbFilter !="" & $cmbFilter !="All")
  {
   $query="SELECT `ID`,`Code`,`Location`,`Category`,`Name`,`Quantity`,`Status`,`Serial No` FROM `assets` WHERE `" . $cmbFilter . "` like '" . $filter . "%' order by `Code` desc";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($id,$code,$location,$category,$name,$quantity,$status, $serialno)=mysqli_fetch_row($result))
    {
     echo "<TR><TH>$code &nbsp;</TH><TH>$location &nbsp;</TH><TH>$category &nbsp;</TH><TH>$name &nbsp;</TH><TH>$quantity &nbsp;</TH><TH>$status &nbsp;</TH>
      <TH>$serialno &nbsp;</TH></TR>";
    }
  }
  else
  {
   $query="SELECT `ID`,`Code`,`Location`,`Category`,`Name`,`Quantity`,`Status`,`Serial No` FROM `assets` order by `Code` desc";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($id,$code,$location,$category,$name,$quantity,$status, $serialno)=mysqli_fetch_row($result))
    {
     echo "<TR><TH>$code &nbsp;</TH><TH>$location &nbsp;</TH><TH>$category &nbsp;</TH><TH>$name &nbsp;</TH><TH>$quantity &nbsp;</TH><TH>$status &nbsp;</TH>
      <TH>$serialno &nbsp;</TH></TR>";
    }
  }

 ?>
</TABLE>
<br>
