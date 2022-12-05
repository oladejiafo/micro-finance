<?php
session_start();

 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];

@$Tit=$_SESSION['Tit'];
@$acctno=$_REQUEST['acctno'];
@$id=$_REQUEST['id'];
@$tval=$_REQUEST['tval'];


 $filename = "daily_mobi_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>

<table width='450'>
<tr><td width='260'><font style='font-size: 14pt;color:red'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td colspan=2><h2><left>Daily Mobilization Report</left></h2></td></tr>
</table>

<div align="left">

	<table border="0" width="90%" cellspacing="1" bgcolor="#FFFFFF" id="table1">

<tr><td align="right">

<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#000000" id="table2">
 <?php
 $tval=$_GET['tval'];
 $limit      = 50;
 $page=$_GET['page'];

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];
 $filter2=$_REQUEST["filter2"];
 
$qry = "SELECT distinct `Agent` FROM `contributions`";
$reslt=mysqli_query($conn,$qry);
$j=0;
    echo "<tr><td colspan=6 align='center'><b><font color='#FF0000' style='font-size: 10pt'>" . date('Y-m-d') . "</font></b></td></tr>";
    echo "<TR><TH><b><u>S/No </b></u>&nbsp;</TH><TH align='left'><b><u>Agent Name</b></u>&nbsp;</TH><TH align='right'><b><u>Total Customer</b></u>&nbsp;</TH><TH align='right'><b><u>Customers Today </b></u>&nbsp;</TH><TH align='right'><b><u>New Customers </b></u>&nbsp;</TH><TH align='right'><b><u>No of Products </b></u>&nbsp;</TH></TR>";
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


</div>

