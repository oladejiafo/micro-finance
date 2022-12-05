<?php
 require_once 'conn.php';

@$acctno=$_REQUEST['acctno'];
@$id=$_REQUEST['id'];

$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];
?>
<style type="text/css">
.div-table {
    width: 100%;
//    border: 1px solid;
    float: left;
    padding:30px;
}

.tab-row {
	background-color: #EEEEEE;
	float: left;
	width: 100%;
                 font-size:16px;
}

.cell {
    padding: 5px;
    border: 1px solid #e9e9e9;
    float: left;
    padding: 5px; 
    background-color: #f5f5f5;
    width: 10%;
    max-height: auto;
    font-size:12px;
    word-wrap: break-word;
}

@media (max-width: 480px){
.tab-row {
	background-color: #EEEEEE;
	float: left;
	width: 100%;
	height:5.5em;
}

.cell {
    padding: 1px;
    border: 1px solid #e9e9e9;
    float: left;
    padding: 5px; 
    background-color: #f5f5f5;
    width: 10%;
    height:5.3em;
//    font-size:9px;
    word-wrap: break-word;
}
}
</style>
<div align="center" width="100%">
<img src='images/logo.jpg' width='120' height='140'><br>
<font style='font-size: 14pt'><b><?php echo $coy; ?></b></font><br>
<font style='font-size: 13pt'><b><?php echo $addy; ?></b></font><br>
<font style='font-size: 13pt'><b><?php echo $phn; ?></b></font>

<div width="100%"> 
<h2><left>Transactions Report</left></h2>
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
     $cmbFilt="ID";
     $filt="%";
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
     $cmbFilt="Branch";
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
     $cmbFilt="Officer";
     $filt="%";
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
<div class="div-table">
  <div class="tab-row" style="font-weight:bold">
    <div align="center" class="cell"  style='width:99%;background-color:#cbd9d9'><b><font color='#FF0000' style='font-size: 11px'><?php echo $cmbFilter . ": " . $filter . " (" . $totalrows . ")"; ?></font></b></div>
  </div>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:10.1%;'>Date</div>
    <div  class="cell" style='width:10.1%;'>Account Number</div>
    <div  class="cell" style='width:10.1%;'>Customer Name</div>
    <div  class="cell" style='width:10.1%;'>Deposit Amount</div>
    <div  class="cell" style='width:10.1%;'>Withdrawal Amount</div>
    <div  class="cell" style='width:10.1%;'>Account Balance</div>
    <div  class="cell" style='width:10.1%;'>Branch</div>
    <div  class="cell" style='width:10.1%;'>Agent/Cashier</div>
    <div  class="cell"  style='width:10.1%;'>Loan Officer</div>
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
      $resultZ = mysqli_query($conn,$sqlZ) or die('Could not look up user data; ' . mysqli_error());
      $rowZ = mysqli_fetch_array($resultZ); 
      $lofficer=$rowZ['Officer'];

      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acct' order by `ID` desc";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysqli_error());
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
        <div  class="cell" style="width:10.1%">' .$date. '</div>
        <div  class="cell" style="width:10.1%">' .$acct. '</div>
        <div  class="cell" style="width:10.1%">' .$name. '</div>
        <div  class="cell" style="width:10.1%" align="right">' .$damount. '</div>
        <div  class="cell" style="width:10.1%" align="right">' .$wamount. '</div>
        <div  class="cell" style="width:10.1%" align="right">' .$ball. '</div>
        <div  class="cell" style="width:10.1%">' .$branch. '</div>
        <div  class="cell" style="width:10.1%">' .$agent. '</div>
        <div  class="cell" style="width:10.1%">' .$lofficer. '</div>
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
        <div  class="cell" style="width:33.3%">TOTAL</div>
        <div  class="cell" style="width:11.1%" align="right">' .$sdamount. '</div>
        <div  class="cell" style="width:11.1%" align="right">' .$swamount. '</div>
        <div  class="cell" style="width:11.1%" align="right">' .$sball. '</div>
        <div  class="cell" style="width:22.2%"></div>
      </div>';
?>

</div>
</div>
