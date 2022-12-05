<?php
#session_start();
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

if ($filter=="" or empty($filter))
{
 $filter="2015-01-01";
 $filter2="2025-12-31";
}
?>
<div align="left">
<table width="65%">
<form  action="report.php" method="POST">
 <body>
 <tr><td>
  Enter Date Range (Starting): 
  <input type="text" id="inputFieldA" name="filter" value="2015-01-01" size="8">
   <input type="hidden" name="cmbReport" size="12" value="Statement of Financial Position">
 </td>
 <td>
  Enter Date Range (Ending): 
   <input type="text" id="inputFieldB" name="filter2" value="2015-12-31" size="8">
 </td>
<td> 
     <input type="submit" value="Generate" name="submit">
     </td></tr>
     <br>
 </body>
</form>
</table>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5"> </td>
</tr>
  </table>

<table border="0" width="85%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='center'>
 <td>
     <h3><center><u>STATEMENT OF CHANGES IN EQUITY REPORT</u></center></h3>
     <h4><center>FROM: <font color='red'><?php echo date('d F, Y',strtotime($filter)); ?></font> TO <font color='red'><?php echo date('d F, Y',strtotime($filter2)); ?></font> </center></h4>
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

$yr1=date('Y', strtotime($filter));
$yr2=$yr1-1;

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> </b></font></tr>";
   echo "<TR bgcolor='#C0C0C0'><TH width ='30%'></TH><TH align='right'> Share Capital <br>(N)</TH><TH align='right'> Statutory Reserve <br>(N)</TH><TH align='right'> Retained Earnings <br>(N)</TH><TH align='right'> Statutory Credit Reserve <br>(N)</TH><TH align='right'> Total Equity <br>(N)</TH></TR>";
 
########EQUITY
       $sqlE="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Share Capital') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE = mysqli_query($conn,$sqlE) or die('Could not look up user data; ' . mysqli_error());
       $rowE = mysqli_fetch_array($resultE);
       $amtE1=$rowE['amount1']; //ShareCapital
 
       $sqlE2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Specific Reserve Expense') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE2 = mysqli_query($conn,$sqlE2) or die('Could not look up user data; ' . mysqli_error());
       $rowE2 = mysqli_fetch_array($resultE2);
       $amtE2=$rowE2['amount2']; //Statutory Reserve

       $sqlE3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('General Reserve Expense', 'Provision for Loss on Investments and Loans to other Organizations','Provision for Loss on Assets Acquired in Liquidation', 'General Reserves', 'Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)', 'Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE3 = mysqli_query($conn,$sqlE3) or die('Could not look up user data; ' . mysqli_error());
       $rowE3 = mysqli_fetch_array($resultE3);
       $amtE3=$rowE3['amount3']; // Credit Reserve

       $sqlE4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Retained Earnings','Net Income (Loss) for the Current Year','Dividends Declared') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE4 = mysqli_query($conn,$sqlE4) or die('Could not look up user data; ' . mysqli_error());
       $rowE4 = mysqli_fetch_array($resultE4);
       $amtE4=$rowE4['amount4']; //Retained Earnings

       $totE=$amtE1+$amtE2+$amtE3-$amtE4; //Total Equity
       $totE1=$totE;

       $amtE1=number_format($amtE1,2);
       $amtE2=number_format($amtE2,2);
       $amtE3=number_format($amtE3,2);
       $amtE4=number_format($amtE4,2);

       $totE=number_format($totE,2);

       echo "<TR align='left'><TH height ='35'>Balance as at $filter</TH><TH align='right'>$amtE1</TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'>$amtE1</TH></TR>";

       echo "<TR align='left'><TH height ='35'>Comprehensive Income for the period</TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH></TR>";
       echo "<TR align='left'><TH> - Profit/Loss for the period</TH><TH align='right'>$amtE1</TH><TH align='right'>$amtE2</TH><TH align='right'>$amtE4</TH><TH align='right'>$amtE3</TH><TH align='right'>$totE</TH></TR>";
       echo "<TR align='left'><TH> - Gains on revaluation of land and buildings</TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>TOTAL COMPREHENSIVE INCOME for the period </b></TH><TH align='right'>$amtE1</TH><TH align='right'>$amtE2</TH><TH align='right'>$amtE4</TH><TH align='right'>$amtE3</TH><TH align='right'><font style='font-size: 12pt'>";
       if($totE1<0) { echo "<font color ='red'>(" . number_format((-1)*$totE1,2) . ")</font>"; } else if($totE1>0) { echo "<font color ='green'>" . $totE . "</font>"; } else { echo $totE; }
       echo "</font></TH></TR>";

 #   }
     echo "<TR><TH colspan='2'></TH></TR>";
  echo "<TR><TH bgcolor='#C0C0C0' colspan='1' align='right'><font style='font-size: 13pt'><b> </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 13pt'><b> </b></font></TH></TR>";

?>
</table>
</fieldset>
</td></tr>
	</table>

<Table align="center">
<tr>
<td>
<?php
echo "<a target='blank' href='rptsoce.php?filter=$filter&filter2=$filter2'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='expsoce.php?filter=$filter&filter2=$filter2'> Export this Report</a> &nbsp; ";
?>
</td>
</tr>
</Table

</div>

