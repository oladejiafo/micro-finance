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

$cmbReport="Expired Loans";
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
     <h3><center><u>EXPIRED LOANS</u></center></h3>
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

   echo "<TR bgcolor='#C0C0C0'><TH><b> Loan ID</b></TH><TH><b> Borrower Name</b></TH><TH><b> Loan Amount</b></TH><TH><b> Loan Type</b></TH><TH><b> Disbursement Date</b></TH><TH><b> Due Date</b></TH><TH><b> Payback To-Date</b></TH><TH><b> Balance Left</b></TH></TR>";

   $resultX = mysqli_query ($conn,"SELECT distinct `Loan Date`,`ID`, `Loan Duration` FROM `loan` where `Due Date` < '" . date('Y-m-d') . "' and `Balance` > 0 and `Loan Status`='Active' group by `Account Number`"); 
/*
   $rowX = mysqli_fetch_array($resultX);
   $dateX=$rowX['Loan Date'];
   $durX=$rowX['Loan Duration'];
   $idX = $rowX['ID'];
*/
#   while(list($dateX,$idX,$durX)=mysqli_fetch_row($resultX)) 
   {	
/*
   $due=date('Y-m-d', strtotime('+' . $durX . ' month',strtotime($dateX)));

        $query_update = "UPDATE `loan` SET `Due Date`='$due' WHERE `ID` = '$idX'";
        $result_update = mysqli_query($conn,$query_update);


$d1= strtotime($due);
$d2= strtotime(date('Y-m-d'));
$mind=min($d1, $d2);
$maxd=max($d1, $d2);
$i=0;
while (($mind=strtotime(" +1 MONTH", $mind)) <= $maxd)
{
 $i++;
}

   $valt="`Loan Duration` <" . $i;
*/
   $valt="`Due Date` < '" . date('Y-m-d') . "'";
   $result = mysqli_query ($conn,"SELECT distinct `Account Number`,`ID`, `Loan Amount`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Loan Type` FROM `loan` where ($valt) and `Balance` > 0 and `Loan Status`='Active' group by `ID`"); 

   $samtt=0;
   $sptdt=0;
   $sbalt=0;

   while(list($acctno,$id,$lamount,$ldate,$lduration,$ptd,$bal,$ltype)=mysqli_fetch_row($result)) 
   {	

       $sqlt="SELECT `Surname`,`First Name`  FROM `customer` where `Account Number`='$acctno'";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
     
       $sname=$rowt['Surname'];
       $fname=$rowt['First Name'];
       $name= $fname . ' ' . $sname;

       $samtt=$samtt+$lamount;
       $sptdt=$sptdt+$ptd;
       $sbalt=$sbalt+$bal;

       $duedate=date('Y-m-d', strtotime('+' . $lduration . ' month',strtotime($ldate)));

       $amtt=number_format($lamount,2);
       $ptdt=number_format($ptd,2);
       $balt=number_format($bal,2);

       echo "<TR align='left'><TH>$id </TH><TH>$name </TH><TH>$amtt </TH><TH>$ltype </TH><TH>$ldate </TH><TH>$duedate </TH><TH align='right'>$ptdt</TH><TH align='right'>$balt</TH></TR>";
   }
}
   echo "<TR><TH colspan='12'></TH></TR>";
 
   $samtt=number_format($samtt,2);
   $sptdt=number_format($sptdt,2);
   $sbalt=number_format($sbalt,2);

   echo "<TR align='left'><TH bgcolor='#C0C0C0' colspan=2> </TH><TH bgcolor='#C0C0C0'><font color='red'; size='3'>$samtt </font></TH><TH  bgcolor='#C0C0C0' colspan=3> </TH><TH align='right' bgcolor='#C0C0C0'>$sptdt</TH><TH align='right' bgcolor='#C0C0C0'>$sbalt</TH></TR>";
#}
?>
</table>
</fieldset>
</td></tr>
	</table>

<Table align="center">
<tr>
<td>
<?php
echo "<a target='blank' href='rptexpiredloans.php'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='expexpiredloans.php'> Export this Report</a> &nbsp; ";
?>
</td>
</tr>
</Table

</div>

