<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 7) & ($_SESSION['access_lvl'] != 6) & ($_SESSION['access_lvl'] != 2))
{
 if ($_SESSION['access_lvl'] != 1){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

 @$tval=$_GET['tval'];
 @$id=$_REQUEST['id'];
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
    //border: 1px dashed #ff0000;
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

<div align="center">
<div class='row' style="background-color:#394247; width:100%" align="center">
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Daily Transaction</font></b>
</div>

<br>
<p>&nbsp;</p>
<div class="div-table">

  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:100%'><b><font color='#FF0000' style='font-size: 13pt'>[My Deposit/Withdrawal Analysis Today]</font></b></div>
  </div>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:50%;background-color:#eeeeee'><b><font color='#000' style='font-size: 11pt'>DEPOSIT</font></b></div>
    <div  class="cell"  style='width:50%;background-color:#c0c0c0'><b><font color='#000' style='font-size: 11pt'>WITHDRAWAL</font></b></div>
  </div>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:12.5%'>Account Number</div>
    <div  class="cell" style='width:12.5%'>Agent/Transactor</div>
    <div  class="cell" style='width:12.5%'>Date</div>
    <div  class="cell" style='width:12.5%'>Amount</div>

    <div  class="cell"  style='width:12.5%'>Account Number</div>
    <div  class="cell" style='width:12.5%'>Agent/Transactor</div>
    <div  class="cell" style='width:12.5%'>Date</div>
    <div  class="cell" style='width:12.5%'>Amount</div>
  </div>
<?php 

   $result = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Deposit` FROM `transactions` where `Transaction Type`='Deposit' and `Date` = '" . date('Y-m-d') . "' and `Officer` ='" . $_SESSION['name'] . "' order by `ID`"); 
   $result2 = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Withdrawal` FROM `transactions` where `Transaction Type`='Withdrawal' and `Date` = '" . date('Y-m-d') . "' and `Officer` ='" . $_SESSION['name'] . "' order by `ID`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        #echo("<p>No Deposit to Display!</p>"); 
   } 
   if(mysqli_num_rows($result2) == 0)
   { 
      #  echo("<p>No Withdrawal to Display!</p>"); 
   } 

    $iamt=0;
    $eamt=0;
    while(list($iclass,$idetails,$idate,$iamount)=mysqli_fetch_row($result)) 
    {	
    $iamt=$iamt+$iamount;
if($idetails=="Self" or $idetails=="self")
{
$sqlH="SELECT * FROM `customer` WHERE `Account Number`='$iclass'";
$resultH = mysqli_query($conn,$sqlH) or die('Could not look up user data; ' . mysqli_error());
$rowH = mysqli_fetch_array($resultH);
@$sHname=$rowH['Surname'];
@$fHname=$rowH['First Name'];
$acctholder=$fHname . " " . $sHname;
  $idetails=$acctholder;
}
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">' .$iclass. '</div>
        <div  class="cell" style="width:12.5%">' .$idetails. '</div>
        <div  class="cell" style="width:12.5%">' .$idate. '</div>
        <div  class="cell" style="width:12.5%">' .$iamount. '</div>
      </div>';
    }
    while(list($eclass,$edetails,$edate,$eamount)=mysqli_fetch_row($result2)) 
    {
    $eamt=$eamt+$eamount;	
if($edetails=="Self" or $edetails=="self")
{
$sqlH1="SELECT * FROM `customer` WHERE `Account Number`='$eclass'";
$resultH1 = mysqli_query($conn,$sqlH1) or die('Could not look up user data; ' . mysqli_error());
$rowH1 = mysqli_fetch_array($resultH1);
@$sH1name=$rowH1['Surname'];
@$fH1name=$rowH1['First Name'];
$acctholder1=$fH1name . " " . $sH1name;
  $edetails=$acctholder1;
}
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">' .$eclass. '</div>
        <div  class="cell" style="width:12.5%">' .$edetails. '</div>
        <div  class="cell" style="width:12.5%">' .$edate. '</div>
        <div  class="cell" style="width:12.5%">' .$eamount. '</div>
      </div>';
    }

   $iamt=number_format($iamt,2);
   $eamt=number_format($eamt,2);
     echo '	
        <div class="tab-row" style="background-color:#cccccc"> 
        <div  class="cell" style="width:37.5%">TOTAL</div>
        <div  class="cell" style="width:12.5%">' .$iamt. '</div>
        <div  class="cell" style="width:37.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">' .$eamt. '</div>
      </div>';  
    mysqli_free_result($result);
    mysqli_free_result($result2);
?>

</div>

<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>