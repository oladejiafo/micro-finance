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
$addy=$rw['Address'];
$phn=$rw['Phone'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];
?>
<table width='650'>
<tr><td rowspan='5' valign='top'>
<img src='images/logo.jpg' width='120' height='140'></td></tr>
<tr><td width='460'><font style='font-size: 14pt'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='460'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='460'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td colspan=1 width='460'><h2><left>STATEMENT OF FINANCIAL POSITION REPORT</left></h2></td></tr>
</table>
<div align="left">

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="85%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5"> </td>
</tr>
  </table>

<table border="0" width="85%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='left'>
 <td>
     <h4><left>FROM: <font color='red'><?php echo date('d F, Y',strtotime($filter)); ?></font> TO <font color='red'><?php echo date('d F, Y',strtotime($filter2)); ?></font> </left></h4>
 </td>
</tr>

<tr><td align="right">
<TABLE width='99%' border='1' cellpadding='0' cellspacing='0' align='center' id="table3">
<?php
   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> </b></font></tr>";
   echo "<TR bgcolor='#C0C0C0'><TH width ='50%'>Description </TH><TH colspan=1 width ='50%' align='right'> Amount(N)</TH></TR>";

########ASSETS
       $sqlt="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Cash on Hand','Petty Cash', 'Vault Cash', 'Cheques in Transit', 'Other Cash Accounts') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
       $amtA1=$rowt['amount1'];
 
       $sqlt2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Cash on Hand','Petty Cash','Vault Cash','Cheques in Transit', 'Other Cash Accounts') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
       $amtA2=$rowt2['amount2'];

       $sqlt3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('Consumer Loans to Clients','Business Loans to Clients','Agricultural Loans to Clients','Real Estate Loans to Clients','Savings and Deposit Secured Loans to Clients','Other Short-term Clients Loans','Current and Outstanding Loans to Non-Clients','Restructured Loans to Clients','Restructured Loans to Non-Clients','Past Due Non-Performing Loans (NPL) Account') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
       $amtA3=$rowt3['amount3'];

       $sqlt3A2="SELECT sum(`Amount`) as amount31 FROM `cash` where `Classification` in ('Held to maturity financial asset') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3A2 = mysqli_query($conn,$sqlt3A2) or die('Could not look up user data; ' . mysqli_error());
       $rowt3A2 = mysqli_fetch_array($resultt3A2);
       $amtA31=$rowt3A2['amount31'];

       $sqlt4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Prepayments','Short-term Receivables') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
       $amtA4=$rowt4['amount4'];

       $sqlt5="SELECT sum(`Amount`) as amount5 FROM `cash` where `Classification` in ('Receivables') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt5 = mysqli_query($conn,$sqlt5) or die('Could not look up user data; ' . mysqli_error());
       $rowt5 = mysqli_fetch_array($resultt5);
       $amtA5=$rowt5['amount5'];

       $sqlt6="SELECT sum(`Amount`) as amount6 FROM `cash` where `Classification` in ('Land and Buildings','Office Equipment','Plant and Machinery','Vehicles','Furniture and Fixture','Computer and other Equipment','Intangible Assets','Other Fixed Assets','Accumulated Amortisation and Depreciation') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt6 = mysqli_query($conn,$sqlt6) or die('Could not look up user data; ' . mysqli_error());
       $rowt6 = mysqli_fetch_array($resultt6);
       $amtA6=$rowt6['amount6'];

       $sqlt7="SELECT sum(`Amount`) as amount7 FROM `cash` where `Classification` in ('Investment in CBN Approved Government Securities','Loans to other MFBs','Other Investments') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt7 = mysqli_query($conn,$sqlt7) or die('Could not look up user data; ' . mysqli_error());
       $rowt7 = mysqli_fetch_array($resultt7);
       $amtA7=$rowt7['amount7'];

       $sqlt8="SELECT sum(`Amount`) as amount8 FROM `cash` where `Classification` in ('Deffered tax asset') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt8 = mysqli_query($conn,$sqlt8) or die('Could not look up user data; ' . mysqli_error());
       $rowt8 = mysqli_fetch_array($resultt8);
       $amtA8=$rowt8['amount8'];

       $sqlt9="SELECT sum(`Amount`) as amount9 FROM `cash` where `Classification` in ('Intangible assets') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt9 = mysqli_query($conn,$sqlt9) or die('Could not look up user data; ' . mysqli_error());
       $rowt9 = mysqli_fetch_array($resultt9);
       $amtA9=$rowt9['amount9'];

       $sqlt9i="SELECT sum(`Amount`) as amount9i FROM `cash` where `Classification` in ('Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)', 'Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt9i = mysqli_query($conn,$sqlt9i) or die('Could not look up user data; ' . mysqli_error());
       $rowt9i = mysqli_fetch_array($resultt9i);
       $amtA9i=$rowt9i['amount9i'];

       $sqlt10="SELECT sum(`Amount`) as amount10 FROM `cash` where `Classification` in ('Deferred Grant Revenue','Deferred Revenue due to Donated Fixed Assets','Other Deferred Revenue Items') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt10 = mysqli_query($conn,$sqlt10) or die('Could not look up user data; ' . mysqli_error());
       $rowt10 = mysqli_fetch_array($resultt10);
       $amtA10=$rowt10['amount10'];

########LIABILITIES
       $sqlL="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Deposit from banks') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL = mysqli_query($conn,$sqlL) or die('Could not look up user data; ' . mysqli_error());
       $rowL = mysqli_fetch_array($resultL);
       $amtL1=$rowL['amount1'];
 
       $sqlL2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Customers Deposits','Term Deposits') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL2 = mysqli_query($conn,$sqlL2) or die('Could not look up user data; ' . mysqli_error());
       $rowL2 = mysqli_fetch_array($resultL2);
       $amtL2=$rowL2['amount2'];

       $sqlL3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('Income Tax') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL3 = mysqli_query($conn,$sqlL3) or die('Could not look up user data; ' . mysqli_error());
       $rowL3 = mysqli_fetch_array($resultL3);
       $amtL3=$rowL3['amount3'];

       $sqlL31="SELECT sum(`Amount`) as amount31 FROM `cash` where `Classification` in ('Interest Payable on Short-term Bank Loans','Interest Payable on Long-term Bank Loans','Interest Payable on Other Borrowings') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL31 = mysqli_query($conn,$sqlL31) or die('Could not look up user data; ' . mysqli_error());
       $rowL31 = mysqli_fetch_array($resultL31);
       $amtL31=$rowL31['amount31'];

       $sqlL4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` like '%Audit%' and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL4 = mysqli_query($conn,$sqlL4) or die('Could not look up user data; ' . mysqli_error());
       $rowL4 = mysqli_fetch_array($resultL4);
       $amtL4=$rowL4['amount4'];

       $sqlL5="SELECT sum(`Amount`) as amount5 FROM `cash` where `Classification` in ('Interest Payable on Savings Deposits', 'Interest Payable on Term Deposits', 'Accounts Payable', 'Withholding Tax','Social security Tax', 'Profit Tax', 'Minimum Tax', 'Other Taxes', 'Suspense Items (unidentified)', 'Clearing Account', 'Other Liabilities') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL5 = mysqli_query($conn,$sqlL5) or die('Could not look up user data; ' . mysqli_error());
       $rowL5 = mysqli_fetch_array($resultL5);
       $amtL5=$rowL5['amount5'];

########EQUITY
       $sqlE="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Share Capital') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE = mysqli_query($conn,$sqlE) or die('Could not look up user data; ' . mysqli_error());
       $rowE = mysqli_fetch_array($resultE);
       $amtE1=$rowE['amount1'];
 
       $sqlE2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Specific Reserve Expense') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE2 = mysqli_query($conn,$sqlE2) or die('Could not look up user data; ' . mysqli_error());
       $rowE2 = mysqli_fetch_array($resultE2);
       $amtE2=$rowE2['amount2'];

       $sqlE3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('General Reserve Expense', 'Provision for Loss on Investments and Loans to other Organizations','Provision for Loss on Assets Acquired in Liquidation', 'General Reserves') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE3 = mysqli_query($conn,$sqlE3) or die('Could not look up user data; ' . mysqli_error());
       $rowE3 = mysqli_fetch_array($resultE3);
       $amtE3=$rowE3['amount3'];

       $sqlE4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Retained Earnings','Net Income (Loss) for the Current Year','Dividends Declared') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE4 = mysqli_query($conn,$sqlE4) or die('Could not look up user data; ' . mysqli_error());
       $rowE4 = mysqli_fetch_array($resultE4);
       $amtE4=$rowE4['amount4'];

       $totA=$amtA1+$amtA2+$amtA3+$amtA31+$amtA4+$amtA5+$amtA6+$amtA7+$amtA8+$amtA9+$amtA9i+$amtA10;
       $totL=$amtL1+$amtL2+$amtL3+$amtL31+$amtL4+$amtL5;
       $totE=$amtE1+$amtE2+$amtE3-$amtE4;

       $totLE=$totL+$totE;

       $totA1=$totA;
       $totL1=$totL;
       $totE1=$totE;
       $totLE1=$totLE;

       $amtA1=number_format($amtA1,2);
       $amtA2=number_format($amtA2,2);
       $amtA3=number_format($amtA3,2);
       $amtA31=number_format($amtA31,2);
       $amtA4=number_format($amtA4,2);
       $amtA5=number_format($amtA5,2);
       $amtA6=number_format($amtA6,2);
       $amtA7=number_format($amtA7,2);
       $amtA8=number_format($amtA8,2);
       $amtA9=number_format($amtA9,2);
       $amtA9i=number_format($amtA9i,2);
       $amtA10=number_format($amtA10,2);

       $amtL1=number_format($amtL1,2);
       $amtL2=number_format($amtL2,2);
       $amtL3=number_format($amtL3,2);
       $amtL31=number_format($amtL31,2);
       $amtL4=number_format($amtL4,2);
       $amtL5=number_format($amtL5,2);

       $amtE1=number_format($amtE1,2);
       $amtE2=number_format($amtE2,2);
       $amtE3=number_format($amtE3,2);
       $amtE4=number_format($amtE4,2);

       $totA=number_format($totA,2);
       $totL=number_format($totL,2);
       $totE=number_format($totE,2);
       $totLE=number_format($totLE,2);

       echo "<TR align='left'><TH height ='35'>ASSETS</TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Cash and bank balances </TH><TH align='right'>$amtA1</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Due from other banks </TH><TH align='right'>$amtA2</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Loans and advances to customers </TH><TH align='right'>$amtA3</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Held to maturity financial assets </TH><TH align='right'>$amtA31</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Prepayment and other assets </TH><TH align='right'>$amtA4</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Receivables </TH><TH align='right'>$amtA5</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Property, Plant & Equipment </TH><TH align='right'>$amtA6</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Investment Property </TH><TH align='right'>$amtA7</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Deffered tax asset </TH><TH align='right'>$amtA8</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Intangible assets </TH><TH align='right'>$amtA9</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Provisions </TH><TH align='right'>$amtA9i</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Other assets </TH><TH align='right'>$amtA10</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>TOTAL ASSETS </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totA1<0) { echo "<font color ='red'>(" . number_format((-1)*$totA1,2) . ")</font>"; } else if($totA1>0) { echo "<font color ='green'>" . $totA . "</font>"; } else { echo $totA; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH height ='35'>LIABILITIES</TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Deposit from banks </TH><TH align='right'>$amtL1</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Deposit from customers </TH><TH align='right'>$amtL2</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Bank Borrowings/Overdrafts </TH><TH align='right'>$amtL31</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Current income tax liability </TH><TH align='right'>$amtL3</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Accrued audit fees </TH><TH align='right'>$amtL4</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Other Liabilities </TH><TH align='right'>$amtL5</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>TOTAL LIABILITIES </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totL1<0) { echo "<font color ='red'>(" . number_format((-1)*$totL1,2) . ")</font>"; } else if($totL1>0) { echo "<font color ='green'>" . $totL . "</font>"; } else { echo $totL; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH height ='35'>EQUITY</TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Share capital </TH><TH align='right'>$amtE1</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Statutory reserve </TH><TH align='right'>$amtE2</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Statutory credit reserve </TH><TH align='right'>$amtE3</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Retained Earnings </TH><TH align='right'>$amtE4</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>TOTAL EQUITY </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totE1<0) { echo "<font color ='red'>(" . number_format((-1)*$totE1,2) . ")</font>"; } else if($totE1>0) { echo "<font color ='green'>" . $totE . "</font>"; } else { echo $totE; }
       echo "</font></TH></TR>";
       echo "<TR align='left'><TH height ='35'><b>TOTAL EQUITY  AND LIABILITIES</b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totLE1<0) { echo "<font color ='red'>(" . number_format((-1)*$totLE1,2) . ")</font>"; } else if($totLE1>0) { echo "<font color ='green'>" . $totLE . "</font>"; } else { echo $totLE; }
       echo "</font></TH></TR>";
 #   }
     echo "<TR><TH colspan='2'></TH></TR>";
     echo "<TR align='center'><TH colspan='2'>The financial statements were approved by the Board of Directors on _______________, ____ and signed on its behalf by:</TH></TR>";
     echo "<TR align='center'><TH colspan='2'>________________________________</TH></TR>";
     echo "<TR align='center'><TH colspan='2'>________________________________</TH></TR>";
  echo "<TR><TH bgcolor='#C0C0C0' colspan='1' align='right'><font style='font-size: 13pt'><b> </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 13pt'><b> </b></font></TH></TR>";

 ?>
</TABLE>
</fieldset>
</td></tr>
	</table>


</div>

