<?php
#session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 6) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
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

$cmbReport="Loans Aging Analysis";
?>
<div align="left">

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5"> </td>
</tr>
  </table>

<table border="0" width="100%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='center'>
 <td><b>
     <h3><center><u>LOANS AGING ANALYSIS</u></center></h3>
 </td>
</tr>
<tr>
	<td>
<br>
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
   $limit      = 50; 
   @$page=$_GET['page'];
   $query_count    = "SELECT * FROM `loan` where `Balance` > 0 and `Loan Status`='Active'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><td colspan=6> &nbsp;</td><td colspan=5 align=center><font face='Verdana' color='#000000' style='font-size: 11pt'><b> Loans Days Range</b></font></td><td colspan=2>&nbsp;</td></tr>";
   echo "<TR bgcolor='#C0C0C0'><TH><b> Loan ID</b></TH><TH><b> Borrower Name</b></TH><TH><b> Original Principal</b></TH><TH><b> Loan Int </b></TH><TH><b> Loan Date</b></TH><TH><b> Due Date</b></TH><TH><b> 0 - 30</b></TH><TH><b> 31 - 60</b></TH><TH><b> 61 - 90</b></TH><TH><b> 91 - 120</b></TH><TH><b> 120+</b></TH><TH><b> Payback To-Date</b></TH><TH><b> Balance Left</b></TH></TR>";

   $result = mysqli_query ($conn,"SELECT `ID`,`Account Number`, `Loan Amount`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Total Interest` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' LIMIT $limitvalue, $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

   $samtt=0;
   $sptdt=0;
   $sbalt=0;
   $samt01=0;
   $samt02=0;
   $samt03=0;
   $samt04=0;
   $samt05=0;
   $stint=0;
   while(list($id,$acctno,$lamount,$ldate,$lduration,$ptd,$bal,$int)=mysqli_fetch_row($result)) 
   {	
       $sqlL="SELECT sum(`Amount`) AS PAYAMT  FROM `loan payment` where `Account Number`='$acctno' AND `Loan ID`='$id'";
       $resultL = mysqli_query($conn,$sqlL) or die('Could not look up user data; ' . mysqli_error());
       $rowL = mysqli_fetch_array($resultL);
       $paytd=$rowL['PAYAMT'];
       $baltd=$lamount - $paytd;

       $sqlt="SELECT `Surname`,`First Name`  FROM `customer` where `Account Number`='$acctno'";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
     
       $sname=$rowt['Surname'];
       $fname=$rowt['First Name'];
       $name= $fname . ' ' . $sname;

       $val01="date(`Date`) >'" . date('Y-m-d', strtotime('-1 day',strtotime($ldate))) . "' and date(`Date`) <'" . date('Y-m-d', strtotime('+31 day',strtotime($ldate))) . "'";
       $result01 = mysqli_query ($conn,"SELECT sum(`Amount`) as AMT01, `Date` FROM `loan payment` where ($val01) and `Loan ID` = '$id' and `Account Number`='$acctno' group by `Date`"); 
       $row01 = mysqli_fetch_array($result01);
       $amt01=$row01['AMT01'];


       $val02="date(`Date`) >'" . date('Y-m-d', strtotime('+30 day',strtotime($ldate))) . "' and date(`Date`) <'" . date('Y-m-d', strtotime('+61 day',strtotime($ldate))) . "'";
       $result02 = mysqli_query ($conn,"SELECT sum(`Amount`) as AMT02, `Date` FROM `loan payment` where ($val02) and `Loan ID` = '$id' and `Account Number`='$acctno' group by `Date`"); 
       $row02 = mysqli_fetch_array($result02);
       $amt02=$row02['AMT02'];

       $val03="date(`Date`) >'" . date('Y-m-d', strtotime('+60 day',strtotime($ldate))) . "' and date(`Date`) <'" . date('Y-m-d', strtotime('+91 day',strtotime($ldate))) . "'";
       $result03 = mysqli_query ($conn,"SELECT sum(`Amount`) as AMT03, `Date` FROM `loan payment` where ($val03) and `Loan ID` = '$id' and `Account Number`='$acctno' group by `Date`"); 
       $row03 = mysqli_fetch_array($result03);
       $amt03=$row03['AMT03'];

       $val04="date(`Date`) >'" . date('Y-m-d', strtotime('+90 day',strtotime($ldate))) . "' and date(`Date`) <'" . date('Y-m-d', strtotime('+121 day',strtotime($ldate))) . "'";
       $result04 = mysqli_query ($conn,"SELECT sum(`Amount`) as AMT04, `Date` FROM `loan payment` where ($val04) and `Loan ID` = '$id' and `Account Number`='$acctno' group by `Date`"); 
       $row04 = mysqli_fetch_array($result04);
       $amt04=$row04['AMT04'];

       $val05="date(`Date`) >'" . date('Y-m-d', strtotime('+120 day',strtotime($ldate))) . "'";
       $result05 = mysqli_query ($conn,"SELECT sum(`Amount`) as AMT05, `Date` FROM `loan payment` where ($val05) and `Loan ID` = '$id' and `Account Number`='$acctno' group by `Date`"); 
       $row05 = mysqli_fetch_array($result05);
       $amt05=$row05['AMT05'];


       $samtt=$samtt+$lamount;
       $sptdt=$sptdt+$paytd;
       $sbalt=$sbalt+$baltd;
       $samt01=$samt01+$amt01;
       $samt02=$samt01+$amt02;
       $samt03=$samt03+$amt03;
       $samt04=$samt04+$amt04;
       $samt05=$samt05+$amt05;
       $stint=$stint+$int;

       $duedate=date('Y-m-d', strtotime('+' . $lduration . ' month',strtotime($ldate)));

       $amtt=number_format($lamount,2);
       $ptdt=number_format($paytd,2);
       $balt=number_format($baltd,2);

       $amt01=number_format($amt01,2);
       $amt02=number_format($amt02,2);
       $amt03=number_format($amt03,2);
       $amt04=number_format($amt04,2);
       $amt05=number_format($amt05,2);

       echo "<TR align='left'><TH>$id </TH><TH>$name </TH><TH>$amtt </TH><TH>$int </TH><TH>$ldate </TH><TH>$duedate </TH><TH align='right'>$amt01 </TH><TH align='right'>$amt02 </TH><TH align='right'>$amt03 </TH><TH align='right'>$amt04 </TH><TH align='right'>$amt05 </TH><TH align='right'>$ptdt</TH><TH align='right'>$balt</TH></TR>";
   }
   echo "<TR><TH colspan='12'></TH></TR>";
 
   $samtt=number_format($samtt,2);
   $sptdt=number_format($sptdt,2);
   $sbalt=number_format($sbalt,2);
   $samt01=number_format($samt01,2);
   $samt02=number_format($samt02,2);
   $samt03=number_format($samt03,2);
   $samt04=number_format($samt04,2);
   $samt05=number_format($samt05,2);
   $stint=number_format($stint,2);
   echo "<TR align='left'><TH bgcolor='#C0C0C0' colspan=2> </TH><TH bgcolor='#C0C0C0'><font color='red'; size='3'>$samtt </font></TH><TH bgcolor='#C0C0C0'><font color='#000000';>$stint </font></TH><TH  bgcolor='#C0C0C0' colspan=2> </TH><TH align='right' bgcolor='#C0C0C0'>$samt01 </TH><TH align='right' bgcolor='#C0C0C0'>$samt02 </TH><TH align='right' bgcolor='#C0C0C0'>$samt03 </TH><TH align='right' bgcolor='#C0C0C0'>$samt04 </TH><TH align='right' bgcolor='#C0C0C0'>$samt05 </TH><TH align='right' bgcolor='#C0C0C0'>$sptdt</TH><TH align='right' bgcolor='#C0C0C0'>$sbalt</TH></TR>";

?>
</table>
</fieldset>
</td></tr>
	</table>

<Table align="center">
<tr>
<td>
<?php
echo "<a target='blank' href='rptloanaging.php'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='exploanaging.php?cmbFilter=$cmbFilter&filter=$filter'> Export this Report</a> &nbsp; ";
?>
</td>
</tr>
</Table

</div>

