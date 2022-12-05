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
     <h3><center><u>Suspense Items Report</u></center></h3>

<TABLE width='99%' border='1' cellpadding='0' cellspacing='0' align='center' id="table3">
<?php

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];

 echo "Filtered using: " . $cmbFilter . "=" . $filter;
 echo "<br>";

    echo "<TR bgcolor='#c0c0c0'><TH valign='top'><b><u>S/No </b></u>&nbsp;</TH><TH valign='top'><b><u>Date </b></u>&nbsp;</TH><TH valign='top'><b><u>Cashier Name </b></u>&nbsp;</TH>
            <TH valign='top'><b><u>Classification </b></u>&nbsp;</TH><TH valign='top'><b><u>Amount</b></u>&nbsp;</TH>
      <TH valign='top'><b><u>Details </b></u>&nbsp;</TH></TR>";

  if (!$cmbFilter=="")
  {  
   $query="SELECT distinct `Date`, `ID`,`Recipient`,`Classification`,`Amount`,`Particulars` FROM `cash` WHERE `" . $cmbFilter . "` like '" . $filter . "%' and `Classification` in ('Suspense Items (unidentified)') group by `Recipient`,`Date` order by `Date` desc";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($date,$id,$cust,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $i=$i+1;
     echo "<TR><TH>$i &nbsp;</TH><TH>$date &nbsp;</TH><TH>$cust &nbsp;</TH>
               <TH>$classification &nbsp;</TH><TH>$amount &nbsp;</TH><TH>$particulars &nbsp;</TH></TR>";
    }
  }
  else
  {
   $query="SELECT distinct `Date`,`ID`,`Recipient`,`Classification`,`Amount`,`Particulars` FROM `cash` WHERE `Classification` in ('Suspense Items (unidentified)') group by `Recipient`,`Date` order by `Date` desc";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($date,$id,$cust,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $i=$i+1;
     echo "<TR><TH>$i &nbsp;</TH><TH>$date &nbsp;</TH><TH>$cust &nbsp;</TH>
               <TH>$classification &nbsp;</TH><TH>$amount &nbsp;</TH><TH>$particulars &nbsp;</TH></TR>";
    }

  }

 ?>
</TABLE>
<br>
