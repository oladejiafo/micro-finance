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
$reslt = mysql_query($sqr,$conn) or die('Could not look up user data; ' . mysql_error());
$rw = mysql_fetch_array($reslt);
$coy=$rw['Company Name'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];
if (empty($filter) or empty($filter2))
{
 @$filter='2011-01-01';
 @$filter2=date('Y-m-d');
}
?>
<div align="left">
<table width="65%">
<form  action="report.php" method="POST">
 <body>
 <tr><td>
  Enter Date Range (Starting): <br>
  [yyyy-mm-dd] <input type="text" name="filter" size="8">
   <input type="hidden" name="cmbReport" size="12" value="Balance Sheet">
 </td>
 <td>
  Enter Date Range (Ending): <br>
   [yyyy-mm-dd] <input type="text" name="filter2" size="8">
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
 <td><b>
     <h3><center><u>BANK RECONCILIATION REPORT</u></center></h3>
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
   $limit      = 50; 
   @$page=$_GET['page'];
   $query_count    = "SELECT * FROM `cheque` where `Date` between '$filter' and '$filter2' group by `Type`, `Status`";
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> </b></font></tr>";
   echo "<TR bgcolor='#C0C0C0'><TH><b> </TH><TH><b>Reciept</TH><TH><b>Payment</TH><TH><b>Balance</TH></TR>";
 
   $result = mysql_query ("SELECT distinct `Particulars`,`Type`,`Status` FROM `cheque` where `Date` between '$filter' and '$filter2' group by `Type`, `Status` LIMIT $limitvalue, $limit"); 
 
   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 
$bpc=0;
$bpu=0;
$brc=0;
$bru=0;

$ttp=0;
$ttr=0;
$ttb=0;

    while(list($cat,$type,$stat)=mysql_fetch_row($result)) 
    {
       $sql_pc="SELECT sum(`Amount`) as amount_pc FROM `cheque` where `Type`='Payment' and `Status`='Cleared' and `Date` between '$filter' and '$filter2'";
       $result_pc = mysql_query($sql_pc,$conn) or die('Could not look up user data; ' . mysql_error());
       $rowpc = mysql_fetch_array($result_pc);
     
       $sql_pu="SELECT sum(`Amount`) as amount_pu FROM `cheque` where `Type`='Payment' and `Status`='Uncleared' and `Date` between '$filter' and '$filter2'";
       $result_pu = mysql_query($sql_pu,$conn) or die('Could not look up user data; ' . mysql_error());
       $rowpu = mysql_fetch_array($result_pu);

       $sql_rc="SELECT sum(`Amount`) as amount_rc FROM `cheque` where `Type`='Receipt' and `Status`='Cleared' and `Date` between '$filter' and '$filter2'";
       $result_rc = mysql_query($sql_rc,$conn) or die('Could not look up user data; ' . mysql_error());
       $rowrc = mysql_fetch_array($result_rc);

       $sql_ru="SELECT sum(`Amount`) as amount_ru FROM `cheque` where `Type`='Receipt' and `Status`='Cleared' and `Date` between '$filter' and '$filter2'";
       $result_ru = mysql_query($sql_ru,$conn) or die('Could not look up user data; ' . mysql_error());
       $rowru = mysql_fetch_array($result_ru);

       $amtpc=$rowpc['amount_pc'];
       $amtpu=$rowpu['amount_pu'];
       $amtrc=$rowrc['amount_rc'];
       $amtru=$rowru['amount_ru'];

       $bpc=$amtpc+$bpc-$amtrc;
       $bpu=$amtpu+$bpu-$amtru;

       $ttp=$amtpc+$amtpu;
       $ttr=$amtrc+$amtru;
       $ttb=$bpc+$bpu;

       $amtpc=number_format($amtpc,2);
       $amtpu=number_format($amtpu,2);
       $amtrc=number_format($amtrc,2);
       $amtru=number_format($amtru,2);

       $bpc=number_format($bpc,2);
       $bpu=number_format($bpu,2);
       $brc=number_format($brc,2);
       $bru=number_format($bru,2);

       echo "<TR align='left'><TH>$cat </TH><TH align='right'>&nbsp;</TH><TH align='right'>&nbsp;</TH><TH align='right'>&nbsp;</TH></TR>";
       echo "<TR align='left'><TH>Cleared </TH><TH align='right'>$amtrc</TH><TH align='right'>$amtpc</TH><TH align='right'>$bpc</TH></TR>";
       echo "<TR align='left'><TH>Uncleared </TH><TH align='right'>$amtru</TH><TH align='right'>$amtpu</TH><TH align='right'>$bpu</TH></TR>";
      }
 
   echo "<TR><TH colspan='4'></TH></TR>";
 
   $ttp=number_format($ttp,2);
   $ttr=number_format($ttr,2);
   $ttb=number_format($ttb,2);

   echo "<TR><TH bgcolor='#C0C0C0' colspan='1' align='right'><font style='font-size: 11pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 11pt'><b> $ttr</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 11pt'><b> $ttp</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 11pt'><b> $ttb</b></font></TH></TR>";

?>
</table>
</fieldset>
</td></tr>
	</table>

<Table align="center">
<tr>
<td>
<?php
echo "<a target='blank' href='rptbalsht.php?filter=$filter&filter2=$filter2'> Print this Report</a> &nbsp;";
# echo "| <a target='blank' href='expinv.php?cmbFilter=$cmbFilter&filter=$filter'> Export this Inventory</a> &nbsp; ";
?>
</td>
</tr>
</Table

</div>

