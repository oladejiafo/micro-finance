<?php
#session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2)  & ($_SESSION['access_lvl'] != 6) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}
}

 require_once 'conn.php';
require_once 'tester.php';

$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysql_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

$cmbReport="Loans Report";
?>
<div align="center">

<div style="background-color:#C0C0C0"> 
     <h3><center><u>LOANS REPORT</u></center></h3>
</div>

<div align="left">
<form  action="report.php" method="POST">
 <body>
 <div align="center">
   <select name="cmbFilt" style="width:120px;height:30px">
  <?php  
   echo '<option selected>All Loans</option>';
   echo '<option>By Branch</option>';
   echo '<option>By Loan Officer</option>';
  ?> 
 </select>
   <input type="hidden" name="cmbReport" size="12" value="Loans Report">
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
 @$cmbFilt=$_REQUEST["cmbFilt"];
 @$filt=$_REQUEST["filt"];

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

 if ($cmbFilt=="" or $cmbFilt=="All Loans" or empty($cmbFilt))
  {  
     if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
    { 
       #$cmbFilter="All Loans Today";
       $query = "SELECT `ID`,`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Officer` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and `Loan Date`='" . date('Y-m-d') . "' order by `ID` desc";
       $query_count = "SELECT * FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date`='" . date('Y-m-d') . "'";
    }
    else if ($cmbFilter=="Date")
    {
      $query = "SELECT `ID`,`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Officer` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date` = '" . $filter . "' order by `ID` desc";
      $query_count = "SELECT * FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date` = '" . $filter . "'";
    }
    else if ($cmbFilter=="Date Range")
    {  
      $query = "SELECT `ID`,`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Officer` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date` between '" . $filter . "' and '" . $filter2 . "' order by `ID` desc";
      $query_count = "SELECT * FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date` between '" . $filter . "' and '" . $filter2 . "'";
    }
  }
  else if ($cmbFilt=="By Branch")
  {  
     if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
    {
       $query = "SELECT `loan`.`ID`,`loan`.`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`loan`.`Officer` FROM `loan`  inner join `customer` on `loan`.`Account Number`=`customer`.`Account Number` WHERE `Balance` > 0 and `Loan Status`='Active' and `Loan Date`='" . date('Y-m-d') . "' and `Branch` like '" .$filt. "%' order by `ID` desc";
       $query_count = "SELECT `loan`.`Account Number` FROM `loan`  inner join `customer` on `loan`.`Account Number`=`customer`.`Account Number` WHERE `Balance` > 0 and `Loan Status`='Active' and `Loan Date`='" . date('Y-m-d') . "' and `Branch` like '" .$filt. "%'";
    }
    else if ($cmbFilter=="Date")
    {
      $query = "SELECT  `loan`.`ID`,`loan`.`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`loan`.`Officer` FROM `loan`  inner join `customer` on `loan`.`Account Number`=`customer`.`Account Number` WHERE `Balance` > 0 and `Loan Status`='Active' and `Loan Date` = '" . $filter . "' and `Branch` like '" .$filt. "%' order by `ID` desc";
      $query_count = "SELECT `loan`.`Account Number` FROM `loan`  inner join `customer` on `loan`.`Account Number`=`customer`.`Account Number` WHERE `Balance` > 0 and `Loan Status`='Active' and `Loan Date` = '" . $filter . "' and `Branch` like '" .$filt. "%'";
    }
    else if ($cmbFilter=="Date Range")
    {  
      $query = "SELECT `loan`.`ID`,`loan`.`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`loan`.`Officer` FROM `loan`  inner join `customer` on `loan`.`Account Number`=`customer`.`Account Number` WHERE `Balance` > 0 and `Loan Status`='Active' and  (`Loan Date` between '" . $filter . "' and '" . $filter2 . "')  and `Branch` like '" .$filt. "%' order by `ID` desc";
      $query_count = "SELECT `loan`.`Account Number` FROM `loan`  inner join `customer` on `loan`.`Account Number`=`customer`.`Account Number` WHERE `Balance` > 0 and `Loan Status`='Active' and  (`Loan Date` between '" . $filter . "' and '" . $filter2 . "')  and `Branch` like '" .$filt. "%'";
    }
  }
  else if ($cmbFilt=="By Loan Officer")
  {
     if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
    { 
       $query = "SELECT `ID`,`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Officer` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date`='" . date('Y-m-d') . "' and `Officer` like '" .$filt. "%' order by `ID` desc";
       $query_count = "SELECT `Account Number` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date`='" . date('Y-m-d') . "' and `Officer` like '" .$filt. "%'";
    }
    else if ($cmbFilter=="Date")
    {
      $query = "SELECT  `ID`,`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Officer` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date` = '" . $filter . "' and `Officer` like '" .$filt. "%' order by `ID` desc";
      $query_count = "SELECT `Account Number` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  `Loan Date` = '" . $filter . "' and `Officer` like '" .$filt. "%'";
    }
    else if ($cmbFilter=="Date Range")
    {  
      $query = "SELECT  `ID`,`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Officer` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  (`Loan Date` between '" . $filter . "' and '" . $filter2 . "')  and `Officer` like '" .$filt. "%' order by `ID` desc";
      $query_count = "SELECT `Account Number` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' and  (`Loan Date` between '" . $filter . "' and '" . $filter2 . "')  and `Officer` like '" .$filt. "%'";
    }
  }
#   $result = mysql_query ("SELECT `ID`,`Account Number`, `Loan Amount`,`Loan Type`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Officer` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' LIMIT $limitvalue, $limit"); 

   $result=mysqli_query($conn,$query);
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   $limit      = 50; 
   @$page=$_GET['page'];
/*
   $query_count    = "SELECT * FROM `loan` where `Balance` > 0 and `Loan Status`='Active'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
*/
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  
?>
  <div class="tab-row" style="font-weight:bold">
    <div class="cell"  style='width:8.3%;background-color:#cbd9d9'>Account Number</div>
    <div class="cell"  style='width:8.3%;background-color:#cbd9d9'>Name</div>
    <div class="cell"  style='width:8.18%;background-color:#cbd9d9'>Phone #</div>
    <div class="cell"  style='width:8.18%;background-color:#cbd9d9'>Address</div>
    <div class="cell"  style='width:8%;background-color:#cbd9d9'>Loan Date</div>
    <div  class="cell" style='width:8.3%;background-color:#cbd9d9'>Loan Type</div>
    <div  class="cell" style='width:8.3%;background-color:#cbd9d9'>Loan Duration</div>
    <div  class="cell" style='width:8.3%;background-color:#cbd9d9'>Loan Amount</div>
    <div  class="cell" style='width:8.3%;background-color:#cbd9d9'>Payback To-Date</div>
    <div  class="cell" style='width:8.3%;background-color:#cbd9d9'>Balance</div>
    <div  class="cell" style='width:8.3%;background-color:#cbd9d9'>Branch</div>
    <div  class="cell" style='width:8.3%;background-color:#cbd9d9'>Loan Officer</div>
  </div>

<?php 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

   $samtt=0;
   $sptdt=0;
   $sbalt=0;
   while(list($id,$acctno,$lamount,$ltype,$ldate,$lduration,$ptd,$bal,$agent)=mysqli_fetch_row($result)) 
   {	
       $sqlt="SELECT `Surname`,`First Name`,`Branch`,`Home Address`,`Contact Number`  FROM `customer` where `Account Number`='$acctno'";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysql_error());
       $rowt = mysqli_fetch_array($resultt);
       $addy=$rowt['Home Address'];
       $phone=$rowt['Contact Number'];
       $branch=$rowt['Branch'];
       $sname=$rowt['Surname'];
       $fname=$rowt['First Name'];
       $name= $fname . ' ' . $sname;

       $samtt=$samtt+$lamount;
       $sptdt=$sptdt+$ptd;
       $sbalt=$sbalt+$bal;

       $lduration=$lduration . ' Months';
       $amtt=number_format($lamount,2);
       $ptdt=number_format($ptd,2);
       $balt=number_format($bal,2);

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:8.3%">' .$acctno. '</div>
        <div  class="cell" style="width:8.3%">' .$name. '</div>
        <div  class="cell" style="width:8.18%">' . $phone. '</div>
        <div  class="cell" style="width:8.18%">' .$addy. '</div>
        <div  class="cell" style="width:8%">' .$ldate. '</div>
        <div  class="cell" style="width:8.3%">' .$ltype. '</div>
        <div  class="cell" style="width:8.3%">' .$lduration. '</div>
        <div  class="cell" style="width:8.3%" align="right">' .$amtt. '</div>
        <div  class="cell" style="width:8.3%" align="right">' .$ptdt. '</div>
        <div  class="cell" style="width:8.3%" align="right">' .$balt. '</div>
        <div  class="cell" style="width:8.3%">' .$branch. '</div>
        <div  class="cell" style="width:8.3%">' .$agent. '</div>
      </div>';
   } 
   $samtt=number_format($samtt,2);
   $sptdt=number_format($sptdt,2);
   $sbalt=number_format($sbalt,2);

     echo '	
        <div class="tab-row" style="font-weight:bold"> 
        <div  class="cell" style="width:49.8%">TOTAL</div>
        <div  class="cell" style="width:8.3%" align="right">' .$samtt. '</div>
        <div  class="cell" style="width:8.3%" align="right">' .$sptdt. '</div>
        <div  class="cell" style="width:8.3%" align="right">' .$sbalt. '</div>
        <div  class="cell" style="width:18.18%"></div>
      </div>';
?>

<div align="center">
<?php
echo "<a target='blank' href='rptloan.php?cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2&cmbFilt=$cmbFilt&filt=$filt'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='exploan.php?cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2&cmbFilt=$cmbFilt&filt=$filt'> Export this Report</a> &nbsp; ";
?>
</div>

</div>

