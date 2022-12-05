<?php
#session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
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

$cmbReport="Loans Report";
?>
<div align="center">
<form  action="report.php" method="POST">
   <select name="cmbFilter" style="height:35px;width:120px">
  <?php  
   echo '<option selected>Today</option>';
   echo '<option>All</option>';
   echo '<option>Date Range</option>';
   echo '<option>Account Number</option>';
  ?> 
 </select>
   <input type="hidden" name="cmbReport" size="12" value="Income Report">
&nbsp;
  <input type="text" name="filter" style="height:35px;width:120px">
&nbsp
  <input type="text" name="filter2" style="height:35px;width:120px">
&nbsp
     <input type="submit" value="Generate" name="submit" style="height:35px;width:100px">
</form>
</div>

 <div align="center"><b>
     <h3><center><u>INCOME REPORT</u></center></h3>
 </div>

 <?php
 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

   $limit      = 50; 
   @$page=$_GET['page'];
  if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $query_count    = "SELECT * FROM `sundry` where `Date` = '" . date('Y-m-d') . "' and `Type`='Income'";
  }
  else if ($cmbFilter=="All")
  {  
   $query_count    = "SELECT * FROM `sundry` where `Type`='Income'";
  }
  else if ($cmbFilter=="Date Range")
  {  
   $query_count    = "SELECT * FROM `sundry` where (`Date` between '" . $filter . "' and '" . $filter2 . "') and `Type`='Income'"; 
  }
  else if ($cmbFilter=="Account Number")
  {  
   $query_count    = "SELECT * FROM `sundry` where (`Account Number` = '" . $filter . "' or `Account Number` = '" . $filter2 . "') and `Type`='Income'"; 
  }
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <div><font face='Verdana' color='#000000' style='font-size: 11pt'><b> For: $cmbFilter</b></font></div>";
 ?>
  <div class="tab-row" style="font-weight:bold; font-size:16px">
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Category </b></div>
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Particulars</b></div>
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Customer Name</b></div>
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Customer Number</b></div>
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Cashier Name</b></div>
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Loan Officer</b></div>
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Branch</b></div>
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Amount</b></div>
    <div  class="cell" style='width:11.1%; background-color:#c0c0c0'><b> Date</b></div>
  </div>
<?php
  if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Note`, `Date`,`Amount`,`Account Number` FROM `sundry` where `Date` = '" . date('Y-m-d') . "' and `Type`='Income' order by `Date` desc LIMIT $limitvalue, $limit"); 
  }
  else if ($cmbFilter=="All")
  {
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Note`, `Date`,`Amount`,`Account Number` FROM `sundry` where `Type`='Income' order by `Date` desc LIMIT $limitvalue, $limit");   
  }
  else if ($cmbFilter=="Date Range")
  {  
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Note`, `Date`,`Amount`,`Account Number` FROM `sundry` where (`Date` between '" . $filter . "' and '" . $filter2 . "') and `Type`='Income' order by `Date` desc LIMIT $limitvalue, $limit"); 
  }
  else if ($cmbFilter=="Account Number")
  {  
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Note`, `Date`,`Amount`,`Account Number` FROM `sundry` where (`Account Number` = '" . $filter . "' or `Account Number` = '" . $filter2 . "') and `Type`='Income' order by `Date` desc LIMIT $limitvalue, $limit"); 
  }
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

   $amtt=0;
   while(list($id,$cat,$det,$date,$amt,$acctno)=mysqli_fetch_row($result)) 
   {	
       $amtt=$amtt+$amt;
       $lamtt=number_format($amt,2);
      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysqli_error());
      $roww = mysqli_fetch_array($resultw); 

      $fn=$roww['First Name'];  
      $sn=$roww['Surname'];
      $name=$fn . ' ' . $sn;
      $cashier=$roww['Officer'];  
      $acofficer=$roww['Account Officer'];  
      $branch=$roww['Branch'];  
   
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:11.1%">' .$cat . '</div>
        <div  class="cell" style="width:11.1%">' .$det. '</div>
        <div  class="cell" style="width:11.1%">' .$name. '</div>
        <div  class="cell" style="width:11.1%">' .$acctno. '</div>
        <div  class="cell" style="width:11.1%">' .$cashier. '</div>
        <div  class="cell" style="width:11.1%">' .$acofficer. '</div>
        <div  class="cell" style="width:11.1%">' .$branch. '</div>
        <div  class="cell" style="width:11.1%">' .$lamtt. '</div>
        <div  class="cell" style="width:11.1%">' .$date. '</div>
      </div>';
   }
 
   $samtt=number_format($amtt,2);
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:77.7%; background-color:#c0c0c0">&nbsp;</div>
        <div  class="cell" style="width:11.1%; background-color:#c0c0c0">' .$samtt. '</div>
        <div  class="cell" style="width:11.1%; background-color:#c0c0c0"></div>
      </div>';
?>

<div>
<?php
echo "<a target='blank' href='rptincome.php?cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2&acctno=$acctno'> Print this Report</a> &nbsp;";
echo "<a target='blank' href='expincome.php?cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2&acctno=$acctno'> Export this Report</a> &nbsp;";
?>
</div>

</div>

