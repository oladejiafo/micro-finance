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

 $filename = "DepWitAnalysis_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>
<table width='450'>
<tr><td width='260' colspan=5><font style='font-size: 15pt; color: red'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='260' colspan=5><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='260' colspan=5><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td  width='400' colspan=5><h2><left>DEPOSIT/WITHDRAWAL ANALYSIS REPORT</left></h2></td></tr>
</table>

<div align="left">
<table border="1" width="85%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr>
	<td>

<?php
 @$filter = $_REQUEST["filter"];
 @$filter2 = $_REQUEST["filter2"];

   echo "<TR bgcolor='#c0c0c0'><TH colspan='4'><b> DEPOSIT </b>&nbsp;</TH><TH colspan='4'><b> WITHDRAWAL</TH></TR>";
   echo "<TR bgcolor='#ccffff'><TH><b> Account Number </b>&nbsp;</TH><TH><b> Transactor </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH><TH><b> Account Number </b>&nbsp;</TH><TH><b> Transactor </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH></TR>";
 
if (empty($filter) or $filter =="" or empty($filter2) or $filter2 =="")
{
   $result = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Deposit` FROM `transactions` where `Transaction Type`='Deposit' order by `Date`"); 
   $result2 = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Withdrawal` FROM `transactions` where `Transaction Type`='Withdrawal' order by `Date`"); 
} else {
   $result = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Deposit` FROM `transactions` where `Transaction Type`='Deposit' and (`Date` between '" . $filter . "' and '" . $filter2 . "') order by `Date`"); 
   $result2 = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Withdrawal` FROM `transactions` where `Transaction Type`='Withdrawal' and (`Date` between '" . $filter . "' and '" . $filter2 . "') order by `Date`"); 
}

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<br>No Deposit to Display!<br>"); 
   } 
   if(mysqli_num_rows($result2) == 0)
   { 
        echo("<br>No Withdrawal to Display!<br>"); 
   } 

    $iamt=0;
    $eamt=0;
    while(list($iclass,$idetails,$idate,$iamount)=mysqli_fetch_row($result)) 
    {	
    $iamt=$iamt+$iamount;
      echo "<TR><TH>$iclass </TH><TH>$idetails</TH><TH>$idate</TH><TH align='right'>$iamount</TH>";
    }
    while(list($eclass,$edetails,$edate,$eamount)=mysqli_fetch_row($result)) 
    {
    $eamt=$eamt+$eamount;	
      echo "<TH>$eclass </TH><TH>$edetails</TH><TH>$edate</TH><TH align='right'>$eamount</TH></TR>";
    }
   echo "<TR><TH colspan='8'></TH></TR>";

   $iamt=number_format($iamt,2);
   $eamt=number_format($eamt,2);
   echo "<TR><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $iamt</b></font></TH><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $eamt</b></font></TH></TR>";

    $val='Deposit/Withdrawal Analysis';
  
    mysqli_free_result($result);
?>

<form>

</table>
</fieldset>
</td></tr>
	</table>

</div>

