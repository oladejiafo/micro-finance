<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 1; URL=index.php?redirect=$redirect");

}
}

 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

$cmbReport="Classifications Reports";
?>
<div align="left">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5"> </td>
</tr>
  </table>

<table border="0" width="95%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='center'>
 <td colspan="5" bgcolor="#ffffff"> 
     <h2><center><u><?php echo $coy; ?></u></center></h2>
     <h3><center><u><?php echo $cmbFilter; ?> Reports</u></center></h3>
</td>
</tr>
<tr>
	<td>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5"> </td>
</tr>
  </table>
			</td>
		</tr>
<tr><td align="right">
<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#ccCCcc" id="table2">
 <?php
 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

 if ($filter=="" or $filter2=="" or empty($filter) or empty($filter2))
 {
   $filter='2010-01-01';
   $filter2='2020-12-31';
 }
 
  if ($cmbFilter=="" or $cmbFilter=="- Select Classification to Filter -" or empty($cmbFilter))
  {  
   $query_count = "SELECT * FROM `cash`";
  } else { 

   $query_count = "SELECT * FROM `cash` WHERE `Classification` = '" . $cmbFilter . "' and `Date` between '$filter' and '$filter2'";
  }
  $result_count   = mysqli_query($conn,$query_count);     
  $totalrows  = mysqli_num_rows($result_count);

  if ($cmbFilter=="" or $cmbFilter=="- Select Classification to Filter -" or empty($cmbFilter))
  {
  
  } else {  
   echo "<tr><td colspan=4 align='center'><b><font color='#FF0000' style='font-size: 10pt'>" . $cmbFilter . " between " . $filter . " and " . $filter2 . "</font></b></td></tr>";
  }
  echo "<TR bgcolor='#cecece'><TH><b><u>Date </b></u>&nbsp;</TH><TH align='left'><b><u>Particulars</b></u>&nbsp;</TH><TH align='right'><b><u>Amount </b></u>&nbsp;</TH><TH align='left'><b><u>Type</b></u>&nbsp;</TH></TR>";

  if ($cmbFilter=="" or $cmbFilter=="- Select Classification to Filter -" or empty($cmbFilter))
  {  
   $query = "SELECT `ID`,`Date`,`Particulars`,`Classification`,`Amount`,`Type` FROM `cash` order by `ID` desc";
  }
  else
  {  
   if ($filter=="" or $filter2=="" or empty($filter) or empty($filter2))
   {
     $filter='2010-01-01';
     $filter2='2020-12-31';
   }
   $query = "SELECT `ID`,`Date`,`Particulars`,`Classification`,`Amount`,`Type` FROM `cash` WHERE `Classification` = '" . $cmbFilter . "' and `Date` between '$filter' and '$filter2'";
  }
   $resultp=mysqli_query($conn,$query);

$samt =0; 
$i=0;
    while(list($id,$date,$part,$clas,$amt,$typ)=mysqli_fetch_row($resultp))
    {
      $i=$i+1;
      $samt=$samt+$amt;
      $amount=number_format($amt,2);
      echo "<TR><TH>$date </TH><TH align='left'>$part</TH><TH align='right'> $amount </TH><TH align='left'>$typ</TH></TR>";
    }
    @$samount=number_format($samt,2);

    echo "<TR><TH colspan='2'>TOTAL</TH><TH align='right'>$samount </TH><TH>&nbsp;</TH></TR>";  
?>
</table>
</td></tr>
	</table>

</div>

