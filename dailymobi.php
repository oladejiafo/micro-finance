<?php
#session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
#exit();
}
}

 require_once 'conn.php';

@$Tit=$_SESSION['Tit'];
@$acctno=$_REQUEST['acctno'];
@$id=$_REQUEST['id'];
@$tval=$_REQUEST['tval'];
?>


<div align="left">
<table width="85%">
<form  action="report.php" method="POST">
 <body>
 <tr><td>
   <select name="cmbFilter">
  <?php  
   echo '<option selected>All Transactions</option>';
   echo '<option>Cash</option>';
   echo '<option>Cheque</option>';
   echo '<option>Entered By</option>';
   echo '<option>By Agent</option>';
   echo '<option>Date Range</option>';
  ?> 
 </select>
   <input type="hidden" name="cmbReport" size="12" value="Daily Mobilization Report">
 </td>
 <td>
  <input type="text" name="filter">
 </td>
 <td>
  <input type="text" name="filter2">
 </td>
 <td> 
     <input type="submit" value="Generate" name="submit">
 </td>
 </tr>
     <br>
 </body>
</form>
</table>
	<table border="0" width="90%" cellspacing="1" bgcolor="#FFFFFF" id="table1">

   <tr>
	<td>
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5" bgcolor="#00CC99"> </td>
</tr>
  </table>

  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5" bgcolor="#C0C0C0"> 
<h2><left>Daily Mobilization Report</left></h2>
</td>
</tr>
  </table>
			</td>
		</tr>
<tr><td align="right">

<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#000000" id="table2">
 <?php
 @$tval=$_GET['tval'];
 $limit      = 50;
 @$page=$_GET['page'];

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];
 
$qry = "SELECT distinct `Agent` FROM `contributions`";
$reslt=mysqli_query($conn,$qry);
$j=0;
    echo "<tr><td colspan=10 align='center'><b><font color='#FF0000' style='font-size: 10pt'>" . date('Y-m-d') . "</font></b></td></tr>";
    echo "<TR><TH><b><u>S/No </b></u>&nbsp;</TH><TH align='left'><b><u>Agent Name</b></u>&nbsp;</TH><TH align='right'><b><u>Total Customer</b></u>&nbsp;</TH><TH align='right'><b><u>Customers Today </b></u>&nbsp;</TH><TH align='right'><b><u>New Customers </b></u>&nbsp;</TH><TH align='right'><b><u>No of Products </b></u>&nbsp;</TH></TR>";

 $totalamt =0; 
 $amt =0;
while(list($agent)=mysqli_fetch_row($reslt))
{

  if ($cmbFilter=="" or $cmbFilter=="All Transactions" or empty($cmbFilter))
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%' and `Date`='" . date('Y-m-d') . "'";
   $query_tot = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%'";
   $query_new = "SELECT * FROM `customer` WHERE `Officer` like '" . $agent . "%' and `Date Registered`='" . date('Y-m-d') . "'";
   $query_pr = "SELECT distinct `Account Type` FROM `customer` WHERE `Officer` like '" . $agent . "%'";
  }
  else if ($cmbFilter=="Entered By")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%' and `Entered By` like '%" . $filter . "%' and `Date`='" . date('Y-m-d') . "'";
   $query_tot = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%'";
   $query_new = "SELECT * FROM `customer` WHERE `Officer` like '" . $agent . "%' and `Date Registered`='" . date('Y-m-d') . "'";
   $query_pr = "SELECT distinct `Account Type` FROM `customer` WHERE `Officer` like '" . $agent . "%'";
  }
  else if ($cmbFilter=="By Agent")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%' and `Date`='" . date('Y-m-d') . "'";
   $query_tot = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%'";
   $query_new = "SELECT * FROM `customer` WHERE `Officer` like '" . $agent . "%' and `Date Registered`='" . date('Y-m-d') . "'";
   $query_pr = "SELECT distinct `Account Type` FROM `customer` WHERE `Officer` like '" . $agent . "%'";
  }
  else if ($cmbFilter=="Cash")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%' and `Pay Mode` ='Cash' and `Date`='" . date('Y-m-d') . "'";
   $query_tot = "SELECT * FROM `contributions` WHERE `Pay Mode` ='Cash' and `Agent` like '" . $agent . "%'";
   $query_new = "SELECT * FROM `customer` WHERE `Officer` like '" . $agent . "%' and `Date Registered`='" . date('Y-m-d') . "'";
   $query_pr = "SELECT distinct `Account Type` FROM `customer` WHERE `Officer` like '" . $agent . "%'";
  }
  else if ($cmbFilter=="Cheque")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%' and `Pay Mode` ='Cheque' and `Date`='" . date('Y-m-d') . "'";
   $query_tot = "SELECT * FROM `contributions` WHERE `Pay Mode` ='Cheque' and `Agent` like '" . $agent . "%'";
   $query_new = "SELECT * FROM `customer` WHERE `Officer` like '" . $agent . "%' and `Date Registered`='" . date('Y-m-d') . "'";
   $query_pr = "SELECT distinct `Account Type` FROM `customer` WHERE `Officer` like '" . $agent . "%'";
  }
  else if ($cmbFilter=="Date Range")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Agent` like '" . $agent . "%' and  and (`Date` between '" . $filter . "' and '" . $filter2 . "')";
   $query_tot = "SELECT * FROM `contributions` WHERE `Pay Mode` ='Cheque' and `Agent` like '" . $agent . "%'";
   $query_new = "SELECT * FROM `customer` WHERE `Officer` like '" . $agent . "%' and (`Date Registered` between '" . $filter . "' and '" . $filter2 . "')";
   $query_pr = "SELECT distinct `Account Type` FROM `customer` WHERE `Officer` like '" . $agent . "%'";
  }
   $result_count   = mysqli_query($conn,$query_count);     
   $countrows  = mysqli_num_rows($result_count);

   $result_tot   = mysqli_query($conn,$query_tot);     
   $totalrows  = mysqli_num_rows($result_tot);

   $result_new   = mysqli_query($conn,$query_new);     
   $newrows  = mysqli_num_rows($result_new);

   $result_pr   = mysqli_query($conn,$query_pr);     
   $prrows  = mysqli_num_rows($result_pr);


   $j=$j+1;
	 
  echo "<TR><TH>$j &nbsp;</TH><TH align='left'>$agent</TH><TH align='right'> $totalrows &nbsp;</TH><TH align='right'>$countrows &nbsp;</TH><TH align='right'> $newrows &nbsp;</TH><TH align='right'> $prrows &nbsp;</TH></TR>";
	 $totalamt += $amt;
    }

?>
</table>
</td></tr>
	</table>

<Table align="center">
<tr>
<td>
<?php
echo "<a target='blank' href='rptmobi.php?cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2&acctno=$acctno'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='expmobi.php?cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2&acctno=$acctno'> Export this Report</a> &nbsp; ";
?>
</td>
</tr>
</Table
</div>

