<?php
session_start();
//check to see if user has logged in with a valid password
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

@$Tit=$_SESSION['Tit'];
@$tval=$_REQUEST['tval'];
 @$acctno=$_REQUEST["acctno"];
?>

<!-- load jquery ui css-->
<link href="js/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<!-- load jquery library -->
<script src="js/jquery-1.9.1.js"></script>
<!-- load jquery ui js file -->
<script src="js/jquery-ui.min.js"></script>

<style type="text/css">
.div-table {
    width: 100%;
//    border: 1px dashed #ff0000;
    float: left;
    padding:10px;
}

.tab-row {
	background-color: #EEEEEE;
	float: left;
	width: 100%;
	height:45px;
}

.cell {
    padding: 1px;
    border: 1px solid #e9e9e9;
    float: left;
    padding: 5px; 
    background-color: #f5f5f5;
    width: 50%;
    height:45px;
    font-size:12px;
}
</style>


<p>&nbsp;</p>
<div class="div-table">
 <?php
 @$tval=$_GET['tval'];
 $limit      = 3;
 @$page=$_GET['page'];
 if(empty($acctno) OR $acctno=="") 
{
  $acctno="XYZ0099";
}
   $query_count = "SELECT * FROM `loan` WHERE `Approval`='Pending'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
?>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:100%'><b><font color='#FF0000' style='font-size: 10pt'> PENDING LOANS for APPROVAL</font></b></div>
  </div>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:9.09%'>S/No</div>
    <div  class="cell" style='width:9.09%'>Loan Request Date</div>
    <div  class="cell" style='width:9.09%'>Account Number</div>
    <div  class="cell" style='width:9.09%'>Customer Name</div>
    <div  class="cell" style='width:9.09%'>Loan Amount </div>
    <div  class="cell" style='width:9.09%'>Loan Type</div>
    <div  class="cell" style='width:9.09%'>Loan Duration (Months)</div>
    <div  class="cell" style='width:9.09%'>Interest Rate</div>
    <div  class="cell" style='width:9.09%'>Payment Type</div>
    <div  class="cell" style='width:9.09%'>Loan Officer</div>
    <div  class="cell" style='width:9.09%'>Approval</div>
  </div>
<?php
   $query = "SELECT `ID`,`Loan Date`,`Account Number`,`Loan Amount`,`Loan Type`,`Loan Duration`,`Interest Rate`,`Payment Type`,`Officer` FROM `loan` WHERE `Approval`='Pending' order by `Loan Date` desc LIMIT 0, $limit";
   $resultp=mysqli_query($conn,$query);
   
$i=0;
    while(list($idd,$date,$acctno,$amt,$type,$duration,$intrate,$ptype,$officer)=mysqli_fetch_row($resultp))
    {
      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acctno' and `Status`='Active'";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysqli_error());
      $roww = mysqli_fetch_array($resultw); 
      $fn=$roww['First Name'];  
      $sn=$roww['Surname'];
      $name=$fn . ' ' . $sn;
    $cll=$roww['Status'];  
   if($cll=="Closed")
   { echo "ACCOUNT HAS BEEN CLOSED"; }

     $amount=number_format($amt,2);

     $i=$i+1;

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:9.09%">' .$i. '</div>
        <div  class="cell" style="width:9.09%">' .$date. '</div>
        <div  class="cell" style="width:9.09%"><a href = "loans.php?acctno=' .$acctno. '" title="Click to open this loan record">' .$acctno. '</a></div>
        <div  class="cell" style="width:9.09%">' .$name. '</div>
        <div  class="cell" style="width:9.09%">' .$amount. '</div>
        <div  class="cell" style="width:9.09%">' .$type.  '</div>
        <div  class="cell" style="width:9.09%">' .$duration. ' Months</div>

        <div  class="cell" style="width:9.09%">' .$intrate.  '</div>
        <div  class="cell" style="width:9.09%">' .$ptype.  '</div>
        <div  class="cell" style="width:9.09%">' .$officer.  '</div>
        <div  class="cell" style="width:9.09%">';
    echo '<a href = "apploans.php?loanid=' . $idd . '&acctnum=' .$acctno. '" title="Click to open this loan record">Approve Now</a>';
    echo  '</div>
      </div>';
    }
?>
</div>
</fieldset>
<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>

<?php
if($_REQUEST['tval']=="Your record has been saved.")
{
  echo "<script>alert('Transaction Successful!');</script>";
}
if($_REQUEST['tval']=="Your record has been updated.")
{
  echo "<script>alert('You Have Successfully Modified The Transaction');</script>";
}
?>