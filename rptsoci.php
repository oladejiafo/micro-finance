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
<tr><td colspan=1 width='460'><h2><left>STATEMENT OF COMPREHENSIVE INCOME REPORT</left></h2></td></tr>
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
 
   $result = mysqli_query ($conn,"SELECT distinct `Category`,`Description`,`Remarks` FROM `heads` where `Category` like 'Interest Income%' or `Category` like '%Interest%Expense%' or `Category` like 'Fee and Charges%' or `Category` like 'Other Income Accounts' or `Category` like 'Other Charges' or `Category` like 'General and Administrative Expenses' or `Category` like 'Loan Servicing%' or `Category` like 'Supervision and Licensing Fees%' or `Category` like 'Promotional Expenses%' or `Category` like 'Tax and Licenses%' group by `Description` order by `Category`"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$ttt=0;
$ttt2=0;
$ttt3=0;
$ttt4=0;
$ttt5=0;
/*
    while(list($cat,$desc,$rm)=mysqli_fetch_row($result)) 
    {	
*/
     # echo "<TR align='center' bgcolor='#dcdfdf' colspan=1><font face='Verdana' color='#ccffff' style='font-size: 12pt'><TH width='40%'>" . $rmm . strtoupper($desc) . "</TH></font><TH colspan=6 width='30%'></TH></TR>";

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
       $rati=$cip/20000000;

       $netii1=$netii;
       $pl1=$pl;
       $cip1=$cip;
       $rati1=$rati;

       $amtt1=number_format($amtt1,2);
       $amtt2=number_format($amtt2,2);
       $amtt3=number_format($amtt3,2);
       $amtt4=number_format($amtt4,2);
       $amtt5=number_format($amtt5,2);
       $amtt6=number_format($amtt6,2);
       $netii=number_format($netii,2);
       $pl=number_format($pl,2);
       $cip=number_format($cip,2);
       $rati=number_format($rati,2);

       echo "<TR align='left'><TH>&nbsp;Interest Income </TH><TH align='right'>$amtt1</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Interest Expense </TH><TH align='right'>($amtt2)</TH></TR>";
       echo "<TR align='left'><TH height ='35'><b>NET INTEREST INCOME </b></TH><TH align='right'><font style='font-size: 12pt'>";
       if($netii1<0) { echo "<font color ='red'>(" . number_format((-1)*$netii1,2) . ")</font>"; } else if($netii1>0) { echo "<font color ='green'>" . $netii . "</font>"; } else { echo $netii; }
       echo "</font></TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Fees and Commission Income </TH><TH align='right'>$amtt3</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Finance Income </TH><TH align='right'>$amtt4</TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Operating Expense </TH><TH align='right'>($amtt5)</TH></TR>";
       echo "<TR align='left'><TH height ='35'>PROFIT (/LOSS) before income tax </TH><TH align='right'><font style='font-size: 12pt'>";
       if($pl1<0) { echo "<font color ='red'>(" . number_format((-1)*$pl1,2) . ")</font>"; } else if($pl1>0) { echo "<font color ='green'>" . $pl . "</font>"; } else { echo $pl; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH>&nbsp;Tax on Profit  </TH><TH align='right'>$amtt6</TH></TR>";
       echo "<TR align='left'><TH height ='35'>COMPREHENSIVE INCOME for the period   </TH><TH align='right'><font style='font-size: 12pt'>";
       if($cip1<0) { echo "<font color ='red'>(" . number_format((-1)*$cip1,2) . ")</font>"; } else if($cip1>0) { echo "<font color ='green'>" . $cip . "</font>"; } else { echo $cip; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH height ='35'>OTHER COMPREHENSIVE INCOME </TH><TH align='right'><font style='font-size: 12pt'></font></TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Remeasurement of post employment benefits obligation </TH><TH align='right'></TH></TR>";
       echo "<TR align='left'><TH height ='35'>TOTAL COMPREHENSIVE INCOME for the period   </TH><TH align='right'><font style='font-size: 12pt'>";
       if($cip1<0) { echo "<font color ='red'>(" . number_format((-1)*$cip1,2) . ")</font>"; } else if($cip1>0) { echo "<font color ='green'>" . $cip . "</font>"; } else { echo $cip; }
       echo "</font></TH></TR>";

       echo "<TR align='left'><TH height ='35'>TOTAL COMPREHENSIVE INCOME attributable to:</TH><TH align='right'><font style='font-size: 12pt'></font></TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Owners of the parent </TH><TH align='right'>";
       if($cip1<0) { echo "<font color ='red'>(" . number_format((-1)*$cip1,2) . ")</font>"; } else if($cip1>0) { echo "<font color ='green'>" . $cip . "</font>"; } else { echo $cip; }
       echo "</TH></TR>";

       echo "<TR align='left'><TH height ='35'>EARNINGS (/LOSS) PER SHARE (Naira) </TH><TH align='right'><font style='font-size: 12pt'></font></TH></TR>";
       echo "<TR align='left'><TH>&nbsp;Basic earnings (/loss) per share </TH><TH align='right'>";
       if($rati1<0) { echo "<font color ='red'>(" . number_format((-1)*$rati1,2) . ")</font>"; } else if($rati1>0) { echo "<font color ='green'>" . $rati . "</font>"; } else { echo $rati; }
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

