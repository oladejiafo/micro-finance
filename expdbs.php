<?php
session_start();

 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];

@$Tit=$_SESSION['Tit'];
@$acctno=$_REQUEST['acctno'];
@$id=$_REQUEST['id'];
@$tval=$_REQUEST['tval'];

 $filename = "DBS_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>


<div align="left">

	<table border="0" width="97%" cellspacing="1" bgcolor="#FFFFFF" id="table1">

   <tr>
	<td>

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td><b>
     <h2><center><u><?php echo $coy; ?></u></center></h2>
     <h3><center><u>DAILY BALANCING SUMMARY</u></center></h3>
 </td>
</tr>
  </table>
			</td>
		</tr>
<tr><td align="right">

<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#000000" id="table2">
 <?php

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];
 
  if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $query_count = "SELECT * FROM `transactions` WHERE (`Date` = '" . date('Y-m-d') . "')";
  }
  else if ($cmbFilter=="In")
  {  
   $query_count = "SELECT * FROM `transactions` WHERE `Transaction Type` in ('Deposit','Charges')";
  }
  else if ($cmbFilter=="Out")
  {  
   $query_count = "SELECT * FROM `transactions` WHERE `Transaction Type` in ('Withdrawal','Commission')";
  }
  else if ($cmbFilter=="Account Number")
  {  
   $query_count = "SELECT * FROM `transactions` WHERE `Account Number` ='" . $filter . "'";
  }
  else if ($cmbFilter=="Date Range")
  {  
   $query_count = "SELECT * FROM `transactions` WHERE `Date` between '" . $filter . "' and " . $filter2 . "'";
  }
  else if ($cmbFilter=="By Cashier")
  {  
   $query_count = "SELECT * FROM `transactions` WHERE `Officer` like '%" . $filter . "%' or `Officer` like '%" . $filter2 . "%'";
  }
  else if ($cmbFilter=="COT")
  {  
   $query_count = "SELECT * FROM `transactions` WHERE (`Date` = '" . date('Y-m-d') . "') and `Transaction Type` in ('COT','Charges','Commission')";
  }
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

    echo "<tr><td colspan=10 align='center'><b><font color='#FF0000' style='font-size: 10pt'>" . $cmbFilter . ": " . $filter . " (" . $totalrows . ")</font></b></td></tr>";
    echo "<TR><TH><b><u>S/No </b></u>&nbsp;</TH><TH align='left'><b><u>Account Number</b></u>&nbsp;</TH><TH align='left'><b><u>Customer Name </b></u>&nbsp;</TH><TH align='right'><b><u>Amount IN</b></u>&nbsp;</TH><TH align='right'><b><u>Amount OUT </b></u>&nbsp;</TH></TR>";

  if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal` FROM `transactions` WHERE (`Date` = '" . date('Y-m-d') . "') order by `ID` desc";
  }
  else if ($cmbFilter=="In")
  {  
   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal` FROM `transactions` WHERE `Transaction Type` in ('Deposit','Charges')";
  }
  else if ($cmbFilter=="Out")
  {  
   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal` FROM `transactions` WHERE `Transaction Type` in ('Withdrawal','Commission')";
  }
  else if ($cmbFilter=="Account Number")
  {  
   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal` FROM `transactions` WHERE `Account Number` ='" . $filter . "'";
  }
  else if ($cmbFilter=="Date Range")
  {  
   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal` FROM `transactions` WHERE `Date` between '" . $filter . "' and " . $filter2 . "'";
  }
  else if ($cmbFilter=="By Cashier")
  {  
   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal` FROM `transactions` WHERE (`Date` = '" . date('Y-m-d') . "') and (`Officer` like '%" . $filter . "%' or `Officer` like '%" . $filter2 . "%')";
  }
  else if ($cmbFilter=="COT")
  {  
   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal` FROM `transactions` WHERE (`Date` = '" . date('Y-m-d') . "') and `Transaction Type` in ('COT','Charges','Commission')";
  }
   $resultp=mysqli_query($conn,$query);

$dep =0; 
$wit=0;
$i=0;
    while(list($id,$date,$acct,$dep,$wit)=mysqli_fetch_row($resultp))
    {
      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acct'";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysqli_error());
      $roww = mysqli_fetch_array($resultw); 

      $dep=number_format($dep,2);
      $wit=number_format($wit,2);

      $i=$i+1;
      $name=$roww['First Name'] . ' ' . $roww['Surname'];
      echo "<TR><TH>$i &nbsp;</TH><TH align='left'>$acct</TH><TH align='left'> $name &nbsp;</TH><TH align='right'>$dep &nbsp;</TH><TH align='right'> $wit &nbsp;</TH></TR>";
      @$totaldep += $dep;
      @$totalwit += $wit;
    }
    @$totaldep=number_format($totaldep,2);
    @$totalwit=number_format($totalwit,2);

    echo "<TR><TH colspan='3'>DAILY BALANCES</TH><TH align='right'>$totaldep &nbsp;</TH><TH align='right'>$totalwit &nbsp;</TH></TR>";  
?>
</table>
</td></tr>
	</table>

</div>

