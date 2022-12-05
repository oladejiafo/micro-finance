<?php
#session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 7))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}
}

 require_once 'conn.php';
require_once 'tester.php';
@$Tit=$_SESSION['Tit'];
@$acctno=$_REQUEST['acctno'];
@$id=$_REQUEST['id'];
@$tval=$_REQUEST['tval'];
?>
<div style="background-color:#C0C0C0"> 
<h2><left>Transactions Report</left></h2>
</div>
<div align="left">
<form  action="report.php" method="POST">
 <body>
 <div align="center">
   <select name="cmbFilt" style="width:120px;height:30px">
  <?php  
   echo '<option selected>All Transactions</option>';
   echo '<option>By Branch</option>';
   echo '<option>By Agent/Cashier</option>';
   echo '<option hidden>Cash</option>';
   echo '<option hidden>Cheque</option>';
  ?> 
 </select>
   <input type="hidden" name="cmbReport" size="12" value="Transactions Report">
  <input type="text" name="filt" style="width:120px;height:30px">
&nbsp;
   <select name="cmbFilter" style="width:120px;height:30px">
  <?php  
   echo '<option selected>Today</option>';
   echo '<option>Date</option>';
   echo '<option>Date Range</option>';
  ?> 
 </select>
&nbsp;
  <input type="text" name="filter" onclick="setSens('todate','max')" id="fromdate"  style="width:120px;height:30px">
&nbsp;
  <input type="text" name="filter2" onclick="setSens('fromdate','min')" id="todate" style="width:120px;height:30px">
&nbsp;
     <input type="submit" value="Generate" name="submit" style="width:120px;height:30px">
</form>
</div>

 <?php
 @$tval=$_GET['tval'];
 $limit      = 50;
 @$page=$_GET['page'];

 @$cmbFilt=$_REQUEST["cmbFilt"];
 @$filt=$_REQUEST["filt"];

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];
 
  if ($cmbFilt=="" or $cmbFilt=="All Transactions" or empty($cmbFilt))
  {  
  #   $cmbFilt="ID";
    # $filt="%";
     if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
    { 
#       $cmbFilter="All Transactions Today";
       $query = "SELECT `ID`,`Date`,`Officer`,`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions` WHERE `Date`='" . date('Y-m-d') . "' order by `ID` desc";
       $query_count = "SELECT * FROM `transactions` WHERE `Date`='" . date('Y-m-d') . "'";
    }
    else if ($cmbFilter=="Date")
    {
      $query = "SELECT `ID`,`Date`,`Officer`,`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions` WHERE `Date` = '" . $filter . "' order by `ID` desc";
      $query_count = "SELECT * FROM `transactions` WHERE `Date` = '" . $filter . "'";
    }
    else if ($cmbFilter=="Date Range")
    {  
      $query = "SELECT `ID`,`Date`,`Officer`,`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions` WHERE `Date` between '" . $filter . "' and '" . $filter2 . "' order by `ID` desc";
      $query_count = "SELECT * FROM `transactions` WHERE `Date` between '" . $filter . "' and '" . $filter2 . "'";
    }
  }
  else if ($cmbFilt=="By Branch")
  {  
    # $cmbFilt="Branch";
     if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
    { 
       $query = "SELECT `transactions`.`ID`,`transactions`.`Date`,`transactions`.`Officer`,`transactions`.`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions`  inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` WHERE `Date`='" . date('Y-m-d') . "' and `Branch` like '" .$filt. "%' order by `ID` desc";
       $query_count = "SELECT `transactions`.`Account Number` FROM `transactions`  inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` WHERE `Date`='" . date('Y-m-d') . "' and `Branch` like '" .$filt. "%'";
    }
    else if ($cmbFilter=="Date")
    {
      $query = "SELECT  `transactions`.`ID`,`transactions`.`Date`,`transactions`.`Officer`,`transactions`.`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions`  inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` WHERE `Date` = '" . $filter . "' and `Branch` like '" .$filt. "%' order by `ID` desc";
      $query_count = "SELECT `transactions`.`Account Number` FROM `transactions`  inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` WHERE `Date` = '" . $filter . "' and `Branch` like '" .$filt. "%'";
    }
    else if ($cmbFilter=="Date Range")
    {  
      $query = "SELECT  `transactions`.`ID`,`transactions`.`Date`,`transactions`.`Officer`,`transactions`.`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions` inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` WHERE (`Date` between '" . $filter . "' and '" . $filter2 . "')  and `Branch` like '" .$filt. "%' order by `ID` desc";
      $query_count = "SELECT `transactions`.`Account Number` FROM `transactions` inner join `customer` on `transactions`.`Account Number`=`customer`.`Account Number` WHERE (`Date` between '" . $filter . "' and '" . $filter2 . "')  and `Branch` like '" .$filt. "%'";
    }
  }
  else if ($cmbFilt=="By Agent/Cashier")
  {  
    # $cmbFilt="Officer";
     #$filt="%";
     if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
    { 
       $query = "SELECT `transactions`.`ID`,`transactions`.`Date`,`transactions`.`Officer`,`transactions`.`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions` WHERE `Date`='" . date('Y-m-d') . "' and `Officer` like '" .$filt. "%' order by `ID` desc";
       $query_count = "SELECT `transactions`.`Account Number` FROM `transactions` WHERE `Date`='" . date('Y-m-d') . "' and `Officer` like '" .$filt. "%'";
    }
    else if ($cmbFilter=="Date")
    {
      $query = "SELECT  `transactions`.`ID`,`transactions`.`Date`,`transactions`.`Officer`,`transactions`.`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions` WHERE `Date` = '" . $filter . "' and `Officer` like '" .$filt. "%' order by `ID` desc";
      $query_count = "SELECT `transactions`.`Account Number` FROM `transactions` WHERE `Date` = '" . $filter . "' and `Officer` like '" .$filt. "%'";
    }
    else if ($cmbFilter=="Date Range")
    {  
      $query = "SELECT  `transactions`.`ID`,`transactions`.`Date`,`transactions`.`Officer`,`transactions`.`Account Number`,`Deposit`,`Withdrawal`,`Balance` FROM `transactions` WHERE (`Date` between '" . $filter . "' and '" . $filter2 . "')  and `Officer` like '" .$filt. "%' order by `ID` desc";
      $query_count = "SELECT `transactions`.`Account Number` FROM `transactions` WHERE (`Date` between '" . $filter . "' and '" . $filter2 . "')  and `Officer` like '" .$filt. "%'";
    }
  }
   $resultp=mysqli_query($conn,$query);
   $result_count   = mysqli_query($conn,$query_count);
   $totalrows  = mysqli_num_rows($result_count);
?>
  <div class="tab-row" style="font-weight:bold">
    <div align="center" class="cell"  style='width:100%;background-color:#cbd9d9'><b><font color='#FF0000' style='font-size: 11px'><?php echo $cmbFilter . ": " . $filter . " (" . $totalrows . ")"; ?></font></b></div>
  </div>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:11.1%;background-color:#cbd9d9'>Date</div>
    <div  class="cell" style='width:11.1%;background-color:#cbd9d9'>Account Number</div>
    <div  class="cell" style='width:11.1%;background-color:#cbd9d9'>Customer Name</div>
    <div  class="cell" style='width:11.1%;background-color:#cbd9d9'>Deposit Amount</div>
    <div  class="cell" style='width:11.1%;background-color:#cbd9d9'>Withdrawal Amount</div>
    <div  class="cell" style='width:11.1%;background-color:#cbd9d9'>Account Balance</div>
    <div  class="cell" style='width:11.1%;background-color:#cbd9d9'>Branch</div>
    <div  class="cell" style='width:11.1%;background-color:#cbd9d9'>Agent/Cashier</div>
    <div  class="cell"  style='width:11.1%;background-color:#cbd9d9'>Loan Officer</div>
  </div>
<?php

$sdep =0; 
$swit =0; 
$sbal=0;
$sdamount =0; 
$swamount =0; 
$sball=0;
$i=0;
   
    while(list($id,$date,$agent,$acct,$dep,$wit,$bal)=mysqli_fetch_row($resultp))
    {
      $sqlZ="SELECT `Officer` FROM `loan` WHERE `Account Number`='$acct' order by `ID` desc";
      $resultZ = mysqli_query($conn,$sqlZ) or die('Could not look up user data; ' . mysql_error());
      $rowZ = mysqli_fetch_array($resultZ); 
      $lofficer=$rowZ['Officer'];

      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acct' order by `ID` desc";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysql_error());
      $roww = mysqli_fetch_array($resultw); 
     $fname=$roww['First Name'];
     $sname=$roww['Surname'];
     $branch=$roww['Branch'];

     $damount=number_format($dep,2);
     $wamount=number_format($wit,2);
     $ball=number_format($bal,2);

     $i=$i+1;
     $name=$fname . ' ' . $sname;

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:11.1%">' .$date. '</div>
        <div  class="cell" style="width:11.1%">' .$acct. '</div>
        <div  class="cell" style="width:11.1%">' .$name. '</div>
        <div  class="cell" style="width:11.1%" align="right">' .$damount. '</div>
        <div  class="cell" style="width:11.1%" align="right">' .$wamount. '</div>
        <div  class="cell" style="width:11.1%" align="right">' .$ball. '</div>
        <div  class="cell" style="width:11.1%">' .$branch. '</div>
        <div  class="cell" style="width:11.1%">' .$agent. '</div>
        <div  class="cell" style="width:11.1%">' .$lofficer. '</div>
      </div>';
     $sbal += $bal;
     $sdep += $dep;
     $swit += $wit;
    }
    $sball=number_format($sbal,2);
    $sdamount=number_format($sdep,2);
    $swamount=number_format($swit,2);
     echo '	
        <div class="tab-row" style="font-weight:bold"> 
        <div  class="cell" style="width:44.4%">TOTAL</div>
        <div  class="cell" style="width:11.1%" align="right">' .$sdamount. '</div>
        <div  class="cell" style="width:11.1%" align="right">' .$swamount. '</div>
        <div  class="cell" style="width:11.1%" align="right">' .$sball. '</div>
        <div  class="cell" style="width:22.2%"></div>
      </div>';
?>

<div align="center">
<?php
echo "<a target='blank' href='rpttrans.php?cmbFilt=$cmbFilt&filt=$filt&cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2&acctno=$acctno'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='exptrans.php?cmbFilt=$cmbFilt&filt=$filt&cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2&acctno=$acctno'> Export this Report</a> &nbsp; ";
?>
</div>

</div>

