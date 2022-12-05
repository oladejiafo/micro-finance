<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
}

 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

$cmbReport="Loans Report";
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
     <h3><center><u>INCOME REPORT</u></center></h3>
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

   $limit      = 50; 
   @$page=$_GET['page'];
  if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $query_count    = "SELECT * FROM `sundry` where `Date` = '" . date('Y-m-d') . "' and `Type`='Income'";
  }
  else if ($cmbFilter=="All")
  {  
   $query_count    = "SELECT * FROM `sundry` where `Type`='Income'";
  }
  else if ($cmbFilter=="Date Range")
  {  
   $query_count    = "SELECT * FROM `sundry` where (`Date` between '" . $filter . "' and '" . $filter2 . "') and `Type`='Income'"; 
  }
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> For: $cmbFilter</b></font></tr>";
   echo "<TR bgcolor='#ccffff'><TH><b> Category </b>&nbsp;</TH><TH><b> Particulars </b>&nbsp;</TH><TH><b> Customer Name</b>&nbsp;</TH><TH><b> Customer Number </b>&nbsp;</TH><TH><b> Cashier Name </b>&nbsp;</TH><TH><b> Loan Officer </b>&nbsp;</TH><TH><b> Branch </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH></TR>";

  if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Note`, `Date`,`Amount`,`Account Number` FROM `sundry` where `Date` = '" . date('Y-m-d') . "' and `Type`='Income' order by `Date` desc"); 
  }
  else if ($cmbFilter=="All")
  {
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Note`, `Date`,`Amount`,`Account Number` FROM `sundry` where `Type`='Income' order by `Date` desc");   
  }
  else if ($cmbFilter=="Date Range")
  {  
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Note`, `Date`,`Amount`,`Account Number` FROM `sundry` where (`Date` between '" . $filter . "' and '" . $filter2 . "') and `Type`='Income' order by `Date` desc"); 
  }
  else if ($cmbFilter=="Account Number")
  {  
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Note`, `Date`,`Amount`,`Account Number` FROM `sundry` where (`Account Number` = '" . $filter . "' or `Account Number` = '" . $filter2 . "') and `Type`='Income' order by `Date` desc"); 
  }
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

   $amtt=0;
   while(list($id,$cat,$det,$date,$amt,$acctno)=mysqli_fetch_row($result)) 
   {	
       $amtt=$amtt+$amt;
       $lamtt=number_format($amt,2);
      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysqli_error());
      $roww = mysqli_fetch_array($resultw); 

      $fn=$roww['First Name'];  
      $sn=$roww['Surname'];
      $name=$fn . ' ' . $sn;
      $cashier=$roww['Officer'];  
      $acofficer=$roww['Account Officer'];  
      $branch=$roww['Branch'];  
       echo "<TR align='left'><TH>$cat </TH><TH>$det </TH><TH>$name </TH><TH>$acctno </TH><TH>$cashier </TH><TH>$acofficer </TH><TH>$branch </TH><TH align='right'>$lamtt </TH><TH>$date </TH></TR>";
   }
   echo "<TR><TH colspan='9'></TH></TR>";
 
   $samtt=number_format($amtt,2);
   echo "<TR align='left'><TH colspan='7' bgcolor='#C0C0C0'> </TH><TH align='right' bgcolor='#C0C0C0'><font color='red'; size='3'>$samtt </font></TH><TH align='right' bgcolor='#C0C0C0'><font color='red'; size='3'></font></TH></TR>";
?>
</table>
</td></tr>
	</table>

</div>

