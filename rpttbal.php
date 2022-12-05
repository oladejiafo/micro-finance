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
<tr><td colspan=1 width='460'><h2><left>TRIAL BALANCE REPORT</left></h2></td></tr>
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
$yr1=date('Y', strtotime($filter));
$yr2=$yr1-1;

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> </b></font></tr>";
   echo "<TR bgcolor='#C0C0C0'><TH width ='50%'>Description </TH><TH colspan=1 width ='25%' align='right'> DR (N)</TH><TH colspan=1 width ='25%' align='right'> CR (N)</TH></TR>";

   $queryDR="SELECT distinct `Category`,`Code`,`Description` FROM `heads` where `Category` in (
'Interest Income Expense', 'Non-Interest Expenses', 'General and Administrative Expenses', 'Loan Servicing Expenses', 'Supervision and Licensing Fees', 'Promotional Expenses', 'Taxes and Licenses', 
'Cashier Shortage and Overage', 'Tax on Profit or Loss', 'Other Charges', 'Loans and Advances', 'Property and Equipment', 'Prepayments and Other Receivables', 'Investments', 'Accounts with Banks and other Financial Institutions', 'Cash, Cheques and Other Cash Items'
) group by `Category` order by `Category` desc";
    $resultDR=mysqli_query($conn,$queryDR);

    $sumDR=0;
    while(list($catr,$coder,$descrr)=mysqli_fetch_row($resultDR))
    { 
      ############## DEBIT ##############
     
       $sqlr="SELECT sum(`Amount`) as dr FROM `cash` where `Classification` = '$descrr' group by `Classification`";
       $resultr = mysqli_query($conn,$sqlr) or die('Could not look up user data; ' . mysqli_error());
       $rowDR=mysqli_fetch_array($resultr);
       $DRamt=$rowDR['dr'];
       if($DRamt) { $DRamt1=number_format($DRamt,2); } else { $DRamt1="0.00"; }

       $sumDR=$sumDR+$DRamt; 
       echo "<TR align='left'><TH> $descrr </TH><TH align='right'>$DRamt1</TH><TH align='right'></TH></TR>";
    }

   $queryCR="SELECT `Code`,`Category`,`Description` FROM `heads` where `Category` in ('Interest Income on Loans and Advances', 'Interest Income other than on Loans and Advances'
,'Fees and Charges', 'Loan and Interest Loss reserves','Cashier Shortage and Overage', 'Other Income Accounts','Reserves for Possible Losses', 'Customers Deposits'
,'Interest Payable', 'Accounts Payable', 'Taxes Payable','Deferred Revenue', 'Suspense and/or Clearing Accounts','Other Liability Accounts', 'Capital', 'Retained Earnings/ (Deficit)', 'Net Income (Loss)', 'Dividends Declared') group by `Category` order by `Category` desc";
    $resultCR=mysqli_query($conn,$queryCR);

    $sumCR=0;
    while(list($code,$cat,$descr)=mysqli_fetch_row($resultCR))
    { 
       ############## CREDIT ##############
      #while(list($CRdet,$CRamt)=mysqli_fetch_row($resultt))
      { 
       $sqlt="SELECT sum(`Amount`) as cr FROM `cash` where `Classification` = '$descr' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowCR=mysqli_fetch_array($resultt);
       $CRamt=$rowCR['cr'];
       if($CRamt) { $CRamt1=number_format($CRamt,2); } else { $CRamt1="0.00"; }
       $sumCR=$sumCR+$CRamt;
       echo "<TR align='left'><TH> $descr </TH><TH align='right'></TH><TH align='right'>$CRamt1</TH></TR>";
      }
    }

    echo "<TR><TH colspan='3'></TH></TR>";
       $sumCR=number_format($sumCR+$CRamt,2);
       $sumDR=number_format($sumDR+$DRamt,2);
    echo "<TR bgcolor='#C0C0C0'><TH colspan='1' align='right'></TH><TH align='right'><font style='font-size: 13pt'><b>$sumDR</b></font></TH><TH align='right'><font style='font-size: 13pt'><b>$sumCR</b></font></TH></TR>";

 ?>
</TABLE>
</fieldset>
</td></tr>
	</table>


</div>

