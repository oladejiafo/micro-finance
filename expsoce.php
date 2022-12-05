<?php
session_start();

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

 $filename = "soce_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>
<table width='450'>
<tr><td width='260'><font style='font-size: 14pt'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td colspan=1 width='260'><h2><left>STATEMENT OF CHANGES IN EQUITY REPORT</left></h2></td></tr>
</table>
<div align="left">

<table border="0" width="85%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='left'>
 <td>
     <h4><left>FROM: <font color='red'><?php echo date('d F, Y',strtotime($filter)); ?></font> TO <font color='red'><?php echo date('d F, Y',strtotime($filter2)); ?></font> </left></h4>
 </td>
</tr>

<tr><td align="right">
<TABLE width='99%' border='1' cellpadding='0' cellspacing='0' align='center' id="table3">
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
</TABLE>
</fieldset>
</td></tr>
	</table>


</div>

