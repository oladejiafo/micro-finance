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

 $filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

if ($filter=="" or empty($filter))
{
 $filter="2015-01-01";
 $filter2="2015-12-31";
}
?>
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<!-- 	
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.css" />
-->
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"filterv",
			dateFormat:"%Y-%m-%d"

		});
		new JsDatePick({
			useMode:2,
			target:"filter2",
			dateFormat:"%Y-%m-%d"

		});
	};
</script>

<table width="50%">
<form action="report.php" method="GET">
 <tr><td>
  Enter Date Range (Starting): <br>
  <input type="text" name="filter" size="8" value="2015-01-01" id="filter">{YYYY-MM-DD}
  <input type="hidden" name="cmbReport" size="12" value="Balance Sheet">
 </td>
 <td>
  Enter Date Range (Ending): <br>
  <input type="text" name="filter2" size="8" value="2015-12-30" id="filter2">{YYYY-MM-DD}
 </td>
<td> 
  <input type="submit" value="Generate" name="submit">
</td></tr>
<br>
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
     <h3><center><u>BALANCE SHEET REPORT</u></center></h3>
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
   $query_count    = "SELECT * FROM `heads` where `Category` in ('Fixed Assets','Current Assets','Current Liabilities')";
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
   echo "<TR bgcolor='#C0C0C0'><TH><b> </TH><TH colspan=2><b> $yr1</TH><TH colspan=2><b> $yr2</TH></TR>";
#   echo "<TR bgcolor='#C0C0C0'><TH width='40%'><b> Description</TH><TH width='15%'><b> N</TH><TH width='15%'><b> N</TH><TH width='15%'><b> N</TH><TH width='15%'><b> N</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT distinct `Category` FROM `heads` where `Category` in ('Fixed Assets','Current Assets','Current Liabilities') LIMIT $limitvalue, $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 
$ttt=0;
$ttt2=0;
$ttty2=0;
$ttt2y2=0;
    while(list($cat)=mysqli_fetch_row($result)) 
    {	
      echo "<TR align='left' bgcolor='#dcdfdf'><font face='Verdana' color='#ccffff' style='font-size: 12pt'><TH width='25%'>" . strtoupper($cat) . "</TH></font><TH colspan=4 width='75%'></TH></TR>";
      $result2 = mysqli_query ($conn,"SELECT `Description`,`Category` FROM `heads` where `Category`= '$cat' LIMIT $limitvalue, $limit"); 
      while(list($descr,$cat1)=mysqli_fetch_row($result2)) 
      {	
       $sqlt="SELECT sum(`Amount`) as amount FROM `cash` where `Classification`='$descr' and `Type`='Income' and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);

       $sqlt2="SELECT sum(`Amount`) as amount FROM `cash` where `Classification`='$descr' and `Type`='Expenditure' and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);     

       $sqlty2="SELECT sum(`Amount`) as amount FROM `cash` where `Classification`='$descr' and `Type`='Income' and year(`Date`) = '$yr2' group by `Classification`";
       $resultty2 = mysqli_query($conn,$sqlty2) or die('Could not look up user data; ' . mysqli_error());
       $rowty2 = mysqli_fetch_array($resultty2);

       $sqlt2y2="SELECT sum(`Amount`) as amount FROM `cash` where `Classification`='$descr' and `Type`='Expenditure' and year(`Date`) = '$yr2' group by `Classification`";
       $resultt2y2 = mysqli_query($conn,$sqlt2y2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2y2 = mysqli_fetch_array($resultt2y2);   

       $amtt=$rowt['amount'];
       if ($amtt==0) { $amtt=0;}
       $ttt=$amtt+$ttt;
       $amtt=number_format($amtt,2);

       $amtt2=$rowt2['amount'];
       if ($amtt2==0) { $amtt2=0;}
       $ttt2=$amtt2+$ttt2;
       $amtt2=number_format($amtt2,2);

       $amtty2=$rowty2['amount'];
       if ($amtty2==0) { $amtty2=0;}
       $ttty2=$amtty2+$ttty2;
       $amtty2=number_format($amtty2,2);

       $amtt2y2=$rowt2y2['amount'];
       if ($amtt2y2==0) { $amtt2y2=0;}
       $ttt2y2=$amtt2y2+$ttt2y2;
       $amtt2y2=number_format($amtt2y2,2);

       echo "<TR align='left'><TH>$descr </TH><TH align='right'>$amtt</TH><TH align='right'><b> $amtt2</TH><TH align='right'><b> $amtty2</TH><TH align='right'><b> $amtt2y2</TH></TR>";
      }
    }
   echo "<TR><TH colspan='5'></TH></TR>";
   $tt=number_format($ttt,2); 
   $tt2=number_format($ttt2,2);
   $tty2=number_format($ttty2,2); 
   $tt2y2=number_format($ttt2y2,2);
   echo "<TR><TH bgcolor='#C0C0C0' colspan='1' align='right'><font style='font-size: 11pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 11pt'><b> $tt</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 11pt'><b> $tt2</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 11pt'><b> $tty2</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 11pt'><b> $tt2y2</b></font></TH></TR>";

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
echo "| <a target='blank' href='expbalsht.php?filter=$filter&filter2=$filter2'> Export this Report</a> &nbsp; ";
?>
</td>
</tr>
</Table

</div>

