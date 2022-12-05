<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 6))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}
}

 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysql_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];
 @$cmbFilt=$_REQUEST["cmbFilt"];
 @$filt=$_REQUEST["filt"];

 $filename = "Loan_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
$cmbReport="Loans Report";
?>

<table align="center" width:100%>
<tr>
<td colspan=3>
<font style='font-size: 14pt'><b><?php echo $coy; ?></b></font><br>
<font style='font-size: 13pt'><b><?php echo $addy; ?></b></font><br>
<font style='font-size: 13pt'><b><?php echo $phn; ?></b></font>
</td></tr>
<tr>
<td colspan=3 align="center" width="100%"><h3><left>OUTSTANDING LOANS REPORT</left></h3></td>
</tr>

 <?php
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

?>
<tr><td colspan=3>
  <table style="font-weight:bold" width="100%">
   <tr>
    <td class="cell" style='width:10%;background-color:#cbd9d9'>Account Number</td>
    <td class="cell" style='width:10%;background-color:#cbd9d9'>Name</td>
    <td class="cell" style='width:10%;background-color:#cbd9d9'>Phone</td>
    <td class="cell" style='width:10%;background-color:#cbd9d9'>Address</td>
    <td class="cell" style='width:8%;background-color:#cbd9d9'>Loan Date</td>
    <td  class="cell" style='width:10%;background-color:#cbd9d9'>Loan Type</td>
    <td  class="cell" style='width:10%;background-color:#cbd9d9'>Loan Duration</td>
    <td  class="cell" style='width:10%;background-color:#cbd9d9'>Loan Amount</td>
    <td  class="cell" style='width:10%;background-color:#cbd9d9'>Payback To-Date</td>
    <td  class="cell" style='width:10%;background-color:#cbd9d9'>Balance</td>
    <td  class="cell" style='width:10%;background-color:#cbd9d9'>Branch</td>
    <td  class="cell" style='width:10%;background-color:#cbd9d9'>Loan Officer</td>
  </tr>

<?php 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

   $samtt=0;
   $sptdt=0;
   $sbalt=0;
   while(list($id,$acctno,$lamount,$ltype,$ldate,$lduration,$ptd,$bal)=mysqli_fetch_row($result)) 
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
        <tr> 
        <td  class="cell" style="width:10%">' .$acctno. '</td>
        <td  class="cell" style="width:10%">' .$name. '</td>
        <td  class="cell" style="width:10%">' .$phone. '</td>
        <td  class="cell" style="width:10%">' .$addy. '</td>
        <td  class="cell" style="width:8%">' .$ldate. '</td>
        <td  class="cell" style="width:10%">' .$ltype. '</td>
        <td  class="cell" style="width:10%">' .$lduration. '</td>
        <td  class="cell" style="width:10%" align="right">' .$amtt. '</td>
        <td  class="cell" style="width:10%" align="right">' .$ptdt. '</td>
        <td  class="cell" style="width:10%" align="right">' .$balt. '</td>
        <td  class="cell" style="width:10%">' .$branch. '</td>
        <td  class="cell" style="width:10%">' .$agent. '</td>
      </tr>';
   }
 
   $samtt=number_format($samtt,2);
   $sptdt=number_format($sptdt,2);
   $sbalt=number_format($sbalt,2);
     echo '	
        <tr style="font-weight:bold"> 
        <td colspan="6" class="cell" style="width:49.8%">TOTAL</td>
        <td class="cell" style="width:10%" align="right">' .$samtt. '</td>
        <td  class="cell" style="width:10%" align="right">' .$sptdt. '</td>
        <td  class="cell" style="width:10%" align="right">' .$sbalt. '</td>
        <td  class="cell" style="width:20%"></td>
      </tr>';
?>
</table>
</td></tr>
</table>

