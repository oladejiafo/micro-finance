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
 $filter2="2015-12-31";
}
?>
<div align="left">
<table width="50%">
<form  action="report.php" method="POST">
 <body>
 <tr><td>
  Enter Date Range (Starting): <br>
  [yyyy-mm-dd] <input type="text" name="filter" value="2015-01-01" size="8">
   <input type="hidden" name="cmbReport" size="12" value="Bank Financial Statement">
 </td>
 <td>
  Enter Date Range (Ending): <br>
   [yyyy-mm-dd] <input type="text" name="filter2" value="2015-12-31" size="8">
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
     <h3><center><u>FINANCIAL STATEMENT REPORT</u></center></h3>
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
   $query_count    = "SELECT * FROM `heads` where `Category` not in ('Fixed Assets','Current Assets','Current Liabilities')";
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
   echo "<TR bgcolor='#C0C0C0'><TH><b> </TH><TH colspan=1><b> $yr1</TH><TH colspan=1><b> $yr2</TH></TR>";
 #  echo "<TR bgcolor='#C0C0C0'><TH width='40%'><b> Description</TH><TH width='30%'><b> N</TH><TH width='30%'><b> N</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT distinct `Category`,`Remarks` FROM `heads` where `Category` not in ('Fixed Assets','Current Assets','Current Liabilities') LIMIT $limitvalue, $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$ttt=0;
$ttt2=0;

    while(list($cat,$rm)=mysqli_fetch_row($result)) 
    {	
      if ($rm=="Expense")
      { $rmm='Less '; } else { $rmm='';}
      echo "<TR align='center' bgcolor='#dcdfdf' colspan=1><font face='Verdana' color='#ccffff' style='font-size: 12pt'><TH width='40%'>" . $rmm . strtoupper($cat) . "</TH></font><TH colspan=2 width='30%'></TH></TR>";
      $result2 = mysqli_query ($conn,"SELECT `Description`,`Category`,`Remarks` FROM `heads` where `Category`= '$cat' LIMIT $limitvalue, $limit"); 
      while(list($descr,$cat1,$typ)=mysqli_fetch_row($result2)) 
      {	
       if ($typ=="Expense")
       { $sg='-1'; } else { $sg='1';}
       $sqlt="SELECT sum(`Amount`) as amount FROM `cash` where `Classification`='$descr' and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);

       $sqlt2="SELECT sum(`Amount`) as amount FROM `cash` where `Classification`='$descr' and `Date` between '$filter' and '$filter2' and year(`Date`) = '$yr2' group by `Classification`";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
     
       $amtt=$rowt['amount']*$sg;
       if ($amtt==0) { $amtt=0;}
       $ttt=$amtt+$ttt;
       $amtt=number_format($amtt,2);

       $amtt2=$rowt2['amount']*$sg;
       if ($amtt2==0) { $amtt2=0;}
       $ttt2=$amtt2+$ttt2;
       $amtt2=number_format($amtt2,2);

       echo "<TR align='left'><TH>$descr </TH><TH align='right'>$amtt</TH><TH align='right'>$amtt2</TH></TR>";
      }
    }
   echo "<TR><TH colspan='3'></TH></TR>";
 
#   $res = mysqli_query ($conn,"SELECT sum(`Total Cost`) as tsoc, sum(`Bank Amount`) as amtb,sum(`Imprest Amount`) as amti FROM `sales` where month(`sales`.`Sales Date`)=month('" . Date('Y-m-d') . "')"); 
#   $rowsum = mysqli_fetch_array($res);
#   $amti=$rowsum['amti'];
#   $amti=number_format($amti,2);
#   $tsoc=$rowsum['tsoc'];
#   $tsoc=number_format($tsoc,2);
#   $amtb=$rowsum['amtb'];
   $tt=number_format($ttt,2);
   $tt2=number_format($ttt2,2);
   echo "<TR><TH bgcolor='#C0C0C0' colspan='1' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tt</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tt2</b></font></TH></TR>";

?>
</table>
</fieldset>
</td></tr>
	</table>

<Table align="center">
<tr>
<td>
<?php
echo "<a target='blank' href='rptpnl.php?filter=$filter&filter2=$filter2'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='exppnl.php?filter=$filter&filter2=$filter2'> Export this Report</a> &nbsp; ";
?>
</td>
</tr>
</Table

</div>

