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

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

 $filename = "Product_Acct_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>

<div align="left">

<table border="0" width="97%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr>
 <td>
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
   <tr align='center'>
 <td colspan="5" bgcolor="#ffffff"> 
     <h2><center><u><?php echo $coy; ?></u></center></h2>
     <h3><center><u>Product Account Reconciliation</u></center></h3>
     <h5>{<?php if($cmbFilter=="All" or $cmbFilter=="Today") { echo "For " .$cmbFilter; } else { echo "Between " . $filter. " AND " . $filter2;}?> }</h5>
</td>
   </tr>
  </table>
 </td>
</tr>
<tr>
<td align="right">
 <?php
 @$tval=$_GET['tval'];
 $limit      = 50;
 @$page=$_GET['page'];


   $query_count = "SELECT * FROM `customer` group by `Account Type`";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
    echo"<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center'>";
    echo "<TR><TH><b><u>S/No </b></u>&nbsp;</TH><TH align='left'><b><u>Product Type</b></u>&nbsp;</TH><TH align='right'><b><u>Total Customer </b></u>&nbsp;</TH><TH align='right'><b><u>Amount IN</b></u>&nbsp;</TH><TH align='right'><b><u>Amount OUT </b></u>&nbsp;</TH></TR>";

   $queryQ = "SELECT `customer`.`Account Number`,`customer`.`Account Type` FROM `customer` group by `customer`.`Account Type`";
 # $queryQ = "SELECT `customer`.`Account Number`,`customer`.`Account Type` FROM `customer` where `Account Type` in ('Current','Savings') group by `customer`.`Account Type`";
 if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $queryQ  = "SELECT `customer`.`Account Number`,`customer`.`Account Type` FROM `customer` inner join `transactions` on `customer`.`Account Number`=`transactions`.`Account Number` where `customer`.`Account Type` in ('Current','Savings') and `Date` = '" . date('Y-m-d') . "' and (`Deposit` >0 OR `Withdrawal`>0) group by `customer`.`Account Type`";
  }
  else if ($cmbFilter=="All")
  {  
   $queryQ  = "SELECT `customer`.`Account Number`,`customer`.`Account Type` FROM `customer` inner join `transactions` on `customer`.`Account Number`=`transactions`.`Account Number` where `customer`.`Account Type` in ('Current','Savings') and (`Deposit` >0 OR `Withdrawal`>0) group by `customer`.`Account Type`";
  }
  else if ($cmbFilter=="Date Range")
  {  
   $queryQ  = "SELECT `customer`.`Account Number`,`customer`.`Account Type` FROM `customer` inner join `transactions` on `customer`.`Account Number`=`transactions`.`Account Number` where `customer`.`Account Type` in ('Current','Savings') and (`Date` between '" . $filter . "' and '" . $filter2 . "') and (`Deposit` >0 OR `Withdrawal`>0) group by `customer`.`Account Type`";
  }
   $resultQ=mysqli_query($conn,$queryQ);
   $totrw  = mysqli_num_rows($resultQ);
$i=0;
$sdep =0; 
$swit=0;

   while(list($acctno,$accttype)=mysqli_fetch_row($resultQ))
   {
    $queryQq = "SELECT `Account Number` FROM `customer` WHERE `Account Type`='$accttype'";
    $resultQq=mysqli_query($conn,$queryQq);
    $totrw  = mysqli_num_rows($resultQq);

 if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $queryct = "SELECT sum(`transactions`.`Deposit`) as sumdep, sum(`transactions`.`Withdrawal`) as sumwit FROM `transactions` inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` where `customer`.`Account Type`='$accttype' and `Date` = '" . date('Y-m-d') . "'"; 
   $cmbFilter="Today"; 
 }
  else if ($cmbFilter=="All")
  {  
   $queryct = "SELECT sum(`transactions`.`Deposit`) as sumdep, sum(`transactions`.`Withdrawal`) as sumwit FROM `transactions`  inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` where `customer`.`Account Type`='$accttype'";
  }
  else if ($cmbFilter=="Date Range")
  {  
   $queryct = "SELECT sum(`transactions`.`Deposit`) as sumdep, sum(`transactions`.`Withdrawal`) as sumwit FROM `transactions` inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` where `customer`.`Account Type`='$accttype' and (`Date` between '" . $filter . "' and '" . $filter2 . "')"; 
  }

   $resultct   = mysqli_query($conn,$queryct);     
   $rowct = mysqli_fetch_array($resultct);
   $sdep=$rowct['sumdep'];
   $swit=$rowct['sumwit'];

      @$totaldep += $sdep;
      @$totalwit += $swit;
      @$totalrw += $totrw;

      $totrw=number_format($totrw,0);
      $sdep=number_format($sdep,2);
      $swit=number_format($swit,2);

      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH align='left'>$accttype</TH><TH align='right'> $totrw &nbsp;</TH><TH align='right'>$sdep &nbsp;</TH><TH align='right'> $swit &nbsp;</TH></TR>";
    }
    @$totalrw=number_format($totalrw,0);
    @$totaldep=number_format($totaldep,2);
    @$totalwit=number_format($totalwit,2);

    echo "<TR><TH colspan='2'></TH><TH align='right'><b>$totalrw &nbsp;</b></TH><TH align='right'><b>$totaldep &nbsp;</b></TH><TH align='right'><b>$totalwit &nbsp;</b></TH></TR>";  
?>
</table>

</td></tr>
	</table>
</div>

