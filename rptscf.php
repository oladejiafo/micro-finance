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
<tr><td colspan=1 width='460'><h2><left>STATEMENT OF CASH FLOWS REPORT</left></h2></td></tr>
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
   $limit      = 50; 
   @$page=$_GET['page'];
   $query_count    = "SELECT * FROM `heads` where `Category` in ('Cash, Cheques and Other Cash Items','Accounts with Banks and other Financial Institutions','Loans and Advances','Prepayments and Other Receivables','Property and Equipment','Investments')";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  
$yr1=date('Y', strtotime($filter));
$yr2=$yr1-1;
   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> </b></font></tr>";
   echo "<TR bgcolor='#C0C0C0'><TH width ='50%'>Description </TH><TH colspan=1 width ='50%' align='right'> Amount(N)</TH></TR>";
 
############################
       $sqlt="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Interest Income on Loans to Clients','Interest Income on Loans to Non-Clients','Interest Income from Balances','Interest Income from Accounts with Banks and other','Interest Income from Approved Investments','Other Interest Income') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
       $amtt1=$rowt['amount1'];
 
       $sqlt2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Interest Income Expense on Clients Deposits','Interest Income Expense on Clients Voluntary Savings','Interest Income Expense on Deposits of Non-Clients','Interest Income Expense on Deposits of Non-Clients','Interest Income Expense on Short-term Loans','Interest Income Expense on Long-term Loans','Interest Income Expense on other Borrowings','Fees Paid for Loans form Banks and other Organization','Commissions Paid for Loans from Banks and other Organizations') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
       $amtt2=$rowt2['amount2'];

       $sqlt3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('Client Fees Paid','Client Penalties','Fee from Payment services and Intra-country Transfers','Fee from Offering Insurance Products as Agent','Other Operating Income') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
       $amtt3=$rowt3['amount3'];

       $sqlt4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Gain on Foreign Exchange','Gain on Disposal of Property and Equipment','Gain on Sale of Investments','Rental Income','Reversal of Provisions for Liabilities and Charges','Write-back of Principal Received on Loans Previously Written Off','Write-back of Interest Received on Loans Previously Written Off','Other Income Items') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
       $amtt4=$rowt4['amount4'];

       $sqlt5="SELECT sum(`Amount`) as amount5 FROM `cash` where `Classification` in ('Loss on Foreign Exchange',
'Loss on Sale of Property and Equipment',
'Loss on Sale or Disposal of Investments',
'Provision for Major Repairs and Maintenance',
'Provision for Off-balance Sheet Commitments',
'Provision for Claims/Litigation',
'Other Charges',
'Employee Personnel Expenses',
'Office Expenses',
'Professional Expenses',
'Occupancy Expenses - Rent',
'Occupancy Expenses - Utilities/Electricity',
'Occupancy Expenses - Others',
'Employee Travel Expenses',
'Depreciation and Amortisation',
'Governance Expense',
'Loan Collection Expenses',
'Lien Recording',
'Credit history Investigation',
'Other Loan Servicing Expenses',
'Supervision Fee',
'Licensing Fee',
'Advertising Expenses',
'Publicity and Promotion',
'Published Materials',
'Other Promotional Expenses',
'Business License and other Local Taxes',
'Property Tax',
'Municipal/LGA Tax',
'Capital Tax',
'Registration Duty, Stamp Duty and their Equivalent',
'Other Indirect and Miscellaneous Taxes') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt5 = mysqli_query($conn,$sqlt5) or die('Could not look up user data; ' . mysqli_error());
       $rowt5 = mysqli_fetch_array($resultt5);
       $amtt5=$rowt5['amount5'];


       $sqlt6="SELECT sum(`Amount`) as amount6 FROM `cash` where `Classification` in ('Income Tax') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt6 = mysqli_query($conn,$sqlt6) or die('Could not look up user data; ' . mysqli_error());
       $rowt6 = mysqli_fetch_array($resultt6);
       $amtt6=$rowt6['amount6'];
       $netii=$amtt1-$amtt2;
       $pl=$netii+$amtt3+$amtt4+$amtt5;
       $cip=$pl-$amtt6;
       $cip1=$cip;

       $cip=number_format($cip,2);
############################

########ADJUSTMENTS
       $sqlt="SELECT sum(`Amount`) as dep FROM `cash` where `Classification` in ('Depreciation and Amortisation') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
       $amtDep=$rowt['dep'];
 
       $sqlt2="SELECT sum(`Amount`) as armo FROM `cash` where `Classification` in ('Accumulated Amortisation and Depreciation') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
       $amtAmor=$rowt2['armo'];

       $sqlt3="SELECT sum(`Amount`) as gdisp FROM `cash` where `Classification` in ('Gain on Disposal of Property and Equipment') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
       $amtGDisp=$rowt3['gdisp'];

       $sqlt3A2="SELECT sum(`Amount`) as ldisp FROM `cash` where `Classification` in ('Loss on Sale of Property and Equipment') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3A2 = mysqli_query($conn,$sqlt3A2) or die('Could not look up user data; ' . mysqli_error());
       $rowt3A2 = mysqli_fetch_array($resultt3A2);
       $amtLDisp=$rowt3A2['ldisp'];

       $sqlt4="SELECT sum(`Amount`) as rev FROM `cash` where `Classification` like 'Revaluation%' and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
       $amtRev=$rowt4['rev'];

       $totAdj=$amtDep+$amtAmor+$amtGDisp+$amtLDisp+$amtRev;
########Changes in Working Capital
       $sqlL="SELECT sum(`Amount`) as rec FROM `cash` where `Classification` in ('Short-term Receivables') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL = mysqli_query($conn,$sqlL) or die('Could not look up user data; ' . mysqli_error());
       $rowL = mysqli_fetch_array($resultL);
       $amtRec=$rowL['rec'];
 
       $sqlL2="SELECT sum(`Amount`) as prep FROM `cash` where `Classification` in ('Prepayments') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL2 = mysqli_query($conn,$sqlL2) or die('Could not look up user data; ' . mysqli_error());
       $rowL2 = mysqli_fetch_array($resultL2);
       $amtPrep=$rowL2['prep'];

       $sqlL3="SELECT sum(`Amount`) as oass FROM `cash` where `Classification` in ('Other Fixed Assets') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL3 = mysqli_query($conn,$sqlL3) or die('Could not look up user data; ' . mysqli_error());
       $rowL3 = mysqli_fetch_array($resultL3);
       $amtOAss=$rowL3['oass'];

       $sqlL31="SELECT sum(`Amount`) as trad FROM `cash` where `Classification` in ('Accounts Payable') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL31 = mysqli_query($conn,$sqlL31) or die('Could not look up user data; ' . mysqli_error());
       $rowL31 = mysqli_fetch_array($resultL31);
       $amtTrad=$rowL31['trad'];

       $sqlL4="SELECT sum(`Amount`) as olib FROM `cash` where `Classification` like '%Other Liabilities%' and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL4 = mysqli_query($conn,$sqlL4) or die('Could not look up user data; ' . mysqli_error());
       $rowL4 = mysqli_fetch_array($resultL4);
       $amtOLib=$rowL4['olib'];

       $sqlL5="SELECT sum(`Amount`) as otax FROM `cash` where `Classification` in ('Other Indirect and Miscellaneous Taxes') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL5 = mysqli_query($conn,$sqlL5) or die('Could not look up user data; ' . mysqli_error());
       $rowL5 = mysqli_fetch_array($resultL5);
       $amtOTax=$rowL5['otax'];

       $sqlL6="SELECT sum(`Amount`) as itax FROM `cash` where `Classification` in ('Income Tax') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL6 = mysqli_query($conn,$sqlL6) or die('Could not look up user data; ' . mysqli_error());
       $rowL6 = mysqli_fetch_array($resultL6);
       $amtITax=$rowL6['itax'];

       $totCWC=$amtRec+$amtPrep+$amtOAss+$amtTrad+$amtOLib+$amtOTax;
       $totNCash=$amtAdj+$amtCWC+$amtITax;

########Cash flows from investing
       $sqlE="SELECT sum(`Amount`) as irec FROM `cash` where `Classification` in ('Interest Income from Approved Investments') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE = mysqli_query($conn,$sqlE) or die('Could not look up user data; ' . mysqli_error());
       $rowE = mysqli_fetch_array($resultE);
       $amtIRec=$rowE['irec'];
 
       $sqlE2="SELECT sum(`Amount`) as devd FROM `cash` where `Classification` in ('Dividends Declared') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE2 = mysqli_query($conn,$sqlE2) or die('Could not look up user data; ' . mysqli_error());
       $rowE2 = mysqli_fetch_array($resultE2);
       $amtDevD=$rowE2['devd'];

       $sqlE3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('General Reserve Expense', 'Provision for Loss on Investments and Loans to other Organizations','Provision for Loss on Assets Acquired in Liquidation', 'General Reserves', 'Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)', 'Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE3 = mysqli_query($conn,$sqlE3) or die('Could not look up user data; ' . mysqli_error());
       $rowE3 = mysqli_fetch_array($resultE3);
       $amtE3=$rowE3['amount3'];

       $sqlE4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Retained Earnings','Net Income (Loss) for the Current Year','Dividends Declared') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE4 = mysqli_query($conn,$sqlE4) or die('Could not look up user data; ' . mysqli_error());
       $rowE4 = mysqli_fetch_array($resultE4);
       $amtE4=$rowE4['amount4'];

       $totNCU=$amtIRec+$amtDevD+$amtE3X-$amtE4X;

       $totNET=$totNCash+$totNCU;

       $totAdj1=$totAdj;
       $totCWC1=$totCWC;
       $totNCash1=$totNCash;
       $totNCU1=$totNCU;
       $totNET1=$totNET;

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

       $totAdj=number_format($totAdj,2);
       $totCWC=number_format($totCWC,2);
       $totNCash=number_format($totNCash,2);
       $totNCU=number_format($totNCU,2);
       $totNET=number_format($totNET,2);

       echo "<TR align='left'><TH height ='35'>CASH FLOWS FROM OPERATING ACTIVITIES:</TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Profit (/Loss) for the year </TH><TH align='right'>";
       if($cip1<0) { echo "<font color ='red'>(" . number_format((-1)*$cip1,2) . ")</font>"; } else if($cip1>0) { echo "<font color ='green'>" . $cip . "</font>"; } else { echo $cip; }
       echo "</TH></TR>";

       echo "<TR align='left'><TH height ='35'>ADJUSTMENTS FOR ITEMS NOT INVOLVING MOVEMENT OF FUNDS:</TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Depreciation </TH><TH align='right'>$amtDep</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Armotization </TH><TH align='right'>$amtAmor</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Gain on Disposal of property, plant and Equipment </TH><TH align='right'>$amtGDisp</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Loss on Disposal of property, plant and Equipment </TH><TH align='right'>$amtLDisp</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Revaluation of PPE </TH><TH align='right'>$amtRev</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b> </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totAdj1<0) { echo "<font color ='red'>(" . number_format((-1)*$totAdj1,2) . ")</font>"; } else if($totAdj1>0) { echo "<font color ='green'>" . $totAdj . "</font>"; } else { echo $totAdj; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH height ='35'>CHANGES IN WORKING CAPITAL:</TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Receivables from customers </TH><TH align='right'>$amRec</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Prepayments </TH><TH align='right'>$amtPrep</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Other assets </TH><TH align='right'>$amtOAss</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Trade and other payables </TH><TH align='right'>$amtTrad</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Other liabilities </TH><TH align='right'>$amtOLib</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Tax effects of prior year adjustment </TH><TH align='right'>$amtOTax</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>CASH GENERATED/USED from operating activities </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totCWC1<0) { echo "<font color ='red'>(" . number_format((-1)*$totCWC1,2) . ")</font>"; } else if($totCWC1>0) { echo "<font color ='green'>" . $totCWC . "</font>"; } else { echo $totCWC; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Income taxes paid </TH><TH align='right'>$amtITax</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>NET CASH GENERATED/USED from operating activities </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totNCash1<0) { echo "<font color ='red'>(" . number_format((-1)*$totNCash1,2) . ")</font>"; } else if($totNCash1>0) { echo "<font color ='green'>" . $totNCash . "</font>"; } else { echo $totNCash; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH height ='35'>CASH FLOWS FROM INVESTING ACTIVITIES</TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Interest received </TH><TH align='right'>$amtIRec</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Acquisition of subsidiaries, net cash acquired </TH><TH align='right'>$amtASub</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Acquisition of intangible asset </TH><TH align='right'>$amtAIAss</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Proceeds from disposal of PPE </TH><TH align='right'>$amtProD</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Dividend paid </TH><TH align='right'>$amtDevD</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Changes in Equity </TH><TH align='right'>$amtChEq</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>NET CASH USED IN INVESTING ACTIVITIES </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totNCU1<0) { echo "<font color ='red'>(" . number_format((-1)*$totNCU1,2) . ")</font>"; } else if($totNCU1>0) { echo "<font color ='green'>" . $totNCU . "</font>"; } else { echo $totNCU; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH height ='35'>CASH FLOWS FROM FINANCING ACTIVITIES</TH><TH align='right'></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Ordinary share capital </TH><TH align='right'>$amtE1X</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Proceeds from bank loans </TH><TH align='right'>$amtE2X</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Repayment of bank loans </TH><TH align='right'>$amtE3X</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Prior year adjustments </TH><TH align='right'>$amtE4X</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Interest and similar charges </TH><TH align='right'>$amtE4X</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>NET CASH USED/FROM FINANCING ACTIVITIES </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totE1<0) { echo "<font color ='red'>(" . number_format((-1)*$totE1,2) . ")</font>"; } else if($totE1>0) { echo "<font color ='green'>" . $totE . "</font>"; } else { echo $totE; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;NET Change in cash and cash equivalents</TH><TH align='right'>$amtNET</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Cash and cash equivalents as at $filter</TH><TH align='right'>-</TH></TR>";

       echo "<TR align='left'><TH height ='35'><b>CASH AND CASH EQUIVALENTS AS AT $filter2</b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($totNET1<0) { echo "<font color ='red'>(" . number_format((-1)*$totNET1,2) . ")</font>"; } else if($totNET1>0) { echo "<font color ='green'>" . $totNET . "</font>"; } else { echo $totNET; }
       echo "</font></TH></TR>";
 #   }
     echo "<TR><TH colspan='2'></TH></TR>";
  echo "<TR><TH bgcolor='#C0C0C0' colspan='1' align='right'><font style='font-size: 13pt'><b> </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 13pt'><b> </b></font></TH></TR>";

 ?>
</TABLE>
</fieldset>
</td></tr>
	</table>


</div>

