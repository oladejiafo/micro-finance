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
     <h3><center><u>JOURNAL REGISTER</u></center></h3>

<TABLE width='90%' border='1' cellpadding='0' cellspacing='0' align='center' id="table3">
<?php

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];

 echo "Filtered using: " . $cmbFilter . "=" . $filter;
 echo "<p>";

    echo "<TR bgcolor='#c0c0c0'><TH><b><u>S/No </b></u>&nbsp;</TH><TH><b><u>Date </b></u>&nbsp;</TH><TH><b><u>Type </b></u>&nbsp;</TH><TH><b><u>Classification</b></u>&nbsp;</TH>
      <TH><b><u>Amount </b></u>&nbsp;</TH><TH><b><u>Particulars </b></u>&nbsp;</TH></TR>";

  if (!$cmbFilter=="")
  {  
   $query_count    = "SELECT * FROM `cash` WHERE `" . $cmbFilter . "` like '" . $filter . "%'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `ID`,`Date`,Type,Classification,Amount,`Particulars` FROM cash WHERE `" . $cmbFilter . "` like '" . $filter . "%' order by `Date` desc";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$i=0;
    while(list($id,$date,$type,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $i=$i+1;
     echo "<TR><TH>$i &nbsp;</TH><TH>$date  &nbsp;</TH><TH> $type &nbsp;</TH><TH>$classification &nbsp;</TH>
      <TH>$amount &nbsp;</TH><TH>$particulars &nbsp;</TH></TR>";
    }
  }
  else
  {
   $query_count    = "SELECT * FROM `cash`";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `ID`,`Date`,Type,Classification,Amount,`Particulars` FROM cash order by `Date` desc";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$i=0;
    while(list($id,$date,$type,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $i=$i+1;
     echo "<TR><TH>$i &nbsp;</TH><TH>$date &nbsp;</TH><TH>$type &nbsp;</TH><TH>$classification &nbsp;</TH>
      <TH>$amount &nbsp;</TH><TH>$particulars &nbsp;</TH></TR>";
    }

  }

 ?>
</TABLE>
<br>
