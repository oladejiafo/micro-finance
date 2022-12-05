<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] !=5) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];

 @$cmbReport = $_REQUEST["cmbReport"];
 @$cmbTable=$_REQUEST['cmbTable']; 
 @$filter=$_REQUEST['filter']; 
 @$filter2=$_REQUEST['filter2']; 
 @$year=$_REQUEST["year"];

?>
<table width='650'>
<tr><td rowspan='5' valign='top'>
<img src='images/logo.jpg' width='120' height='140'></td></tr>
<tr><td width='460'><font style='font-size: 14pt'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='460'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='460'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td colspan=1><h2><left><?php echo $cmbReport; ?></left></h2></td></tr>
</table>

<TABLE width='100%' bordercolor=green border='1' cellpadding='1' cellspacing='1' align='center' id="table3">
<?php

  if ($filter=="January")
  {
   $filter=01;
  }
  else if ($filter=="February")
  {
   $filter=02;
  }
  else if ($filter=="March")
  {
   $filter=03;
  }
  else if ($filter=="April")
  {
   $filter=04;
  }
  else if ($filter=="May")
  {
   $filter=05;
  }
  else if ($filter=="June")
  {
   $filter=06;
  }
  else if ($filter=="July")
  {
   $filter=07;
  }
  else if ($filter=="August")
  {
   $filter=08;
  }
  else if ($filter=="September")
  {
   $filter=09;
  }
  else if ($filter=="October")
  {
   $filter=10;
  }
  else if ($filter=="November")
  {
   $filter=11;
  }
  else if ($filter=="December")
  {
   $filter=12;
  }
  else if ($filter=="")
  {
   $filter=date('m');
  }
  else if (empty($filter))
  {
   $filter=date('m');
  }

#################
if (trim($cmbReport) == "- Select Report-" or trim($cmbTable) == "- Select Criteria -")
{
  echo "<b>Please Select a Report and a Criteria from the drop-down box and click 'Open'.<b>";        
}
else if (trim($cmbReport)=="Verification Report")
{
  if (trim($cmbTable)=="Daily")
  {
   @$val="`Sales Date`=date('$filter')";
  }
  else if (trim($cmbTable)=="Weekly")
  {
   @$val="date(`Sales Date`)>'" . date('Y-m-d', strtotime('-1 week')) . "' and date(`Sales Date`)<'" . date('Y-m-d', strtotime('+1 day')) . "'";
  }
  else if (trim($cmbTable)=="Monthly")
  {
   @$val="date(`Sales Date`)>'" . date('Y-m-d', strtotime('-1 month')) . "' and date(`Sales Date`)<'" . date('Y-m-d', strtotime('+1 day')) . "'";
  }
  else if (trim($cmbTable)=="Quarterly")
  {
   @$val="date(`Sales Date`)>'" . date('Y-m-d', strtotime('-3 month')) . "' and date(`Sales Date`)<'" . date('Y-m-d', strtotime('+1 day')) . "'";
  }
  else if (trim($cmbTable)=="Yearly")
  {
   @$val="date(`Sales Date`)=" . date('Y');
  }

   $limit      = 15; 
   $page=$_GET['page'];
   $query_count    = "SELECT * FROM `Sales` where " . $val;     
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><b> [$cmbTable Sales Report]</b><br></tr>";
   echo "<TR bgcolor='#008000'><TH><b> Stock Code </b>&nbsp;</TH><TH><b> Stock Name </b>&nbsp;</TH><TH><b> Sales Date </b>&nbsp;</TH><TH><b> Qnty Sold </b>&nbsp;</TH><TH><b> Unit Cost </b>&nbsp;</TH><TH><b> Total Cost </b>&nbsp;</TH><TH><b> Paid </b>&nbsp;</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT `Stock Code`, `Stock Name`,`Sales Date`, `Qnty Sold`, `Unit Cost`, `Total Cost`, `Paid` From `sales` where " . $val . " order by `Stock Code` LIMIT $limitvalue, $limit"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 
    $val='Daily';

    while(list($stockcode,$stockname,$salesdate,$qntysold,$unitcost,$totalcost,$paid)=mysqli_fetch_row($result)) 
    {	
      echo "<TR><TH>$stockcode </TH><TH>$stockname</TH><TH>$salesdate</TH><TH>$qntysold</TH><TH>$unitcost</TH><TH>$totalcost</TH><TH>$paid</TH></TR>";
    }

    if($page != 1)
    {  
       $pageprev = $page-1;       
       echo("<a href=\"$PHP_SELF?cmbTable=$val&page=$pageprev\">PREV PAGE</a>  ");
    }
    else 
       echo("PREV PAGE  ");  

    $numofpages = $totalrows / $limit;  
    for($i = 1; $i <= $numofpages; $i++)
    { 
        if($i == $page)
        { 
            echo($i."  "); 
        }else{ 
            echo("<a href=\"$PHP_SELF?cmbTable=$val&page=$i\">$i</a>  ");  
        }
    } 
    if(($totalrows % $limit) != 0)
    { 
        if($i == $page)
        { 
            echo($i."  "); 
        }
        else
        { 
            echo("<a href=\"$PHP_SELF?cmbTable=$val&page=$i\">$i</a>  "); 
        } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1; 
          
        echo("<a href=\"$PHP_SELF?cmbTable=$val&page=$pagenext\">NEXT PAGE</a>");  
    }
    else
    { 
        echo("NEXT PAGE");  
    } 
  
    mysqli_free_result($result);
?>
<br>
<form>
<Table align="center">
<tr>
<td>

<?php
 echo "<a target='blank' href='rptreport.php?cmbReport=$cmbReport&cmbTable=$cmbTable&filter=$filter'> Print this Report</a> &nbsp;";
# echo "| <a target='blank' href='expinv.php?cmbFilter=$cmbFilter&filter=$filter'> Export this Inventory</a> &nbsp; ";
?>
</td>
</tr>
</Table
</form>
<?php
 }
 else if ($cmbReport == "Individual Revenue Report")
 {
  if (trim($cmbTable)=="Daily")
  {
   $val="`DoB_Day`=date('d')";
  }
  else if (trim($cmbTable)=="Weekly")
  {
   $val="date(`Stock Date`)>'" . date('Y-m-d', strtotime('-1 week')) . "' and date(`Stock Date`)<'" . date('Y-m-d', strtotime('+1 day')) . "'";
  }
  else if (trim($cmbTable)=="Monthly")
  {
   $val="`DoB_Month`=" . $filter . " and `DoB_Year`=" . $year;
  }
  else if (trim($cmbTable)=="Quarterly")
  {
   $val="date(`Stock Date`)>'" . date('Y-m-d', strtotime('-3 month')) . "' and date(`Stock Date`)<'" . date('Y-m-d', strtotime('+1 day')) . "'";
  }
  else if (trim($cmbTable)=="Yearly")
  {
   $val="`DoB_Year`=" . $year;
  }

   echo " <tr><b> [$cmbTable Revenue Report for " . strtoupper($filter2) . "]</b><br></tr>";
   echo "<TR bgcolor='#008000'><TH><b> Date </b>&nbsp;</TH><TH><b> Amount Collected </b>&nbsp;</TH><TH><b> Amount Pending </b>&nbsp;</TH></TR>";
 
   $resul = mysqli_query ($conn,"SELECT DISTINCT concat(`Dob_Day`,'/',`DoB_Month`,'/',`DoB_Year`) as date From `revenue` where `Command`='" . $filter2 . "' and " . $val); 
   while(list($dat)=mysqli_fetch_row($resul)) 
   {	

   $result = mysqli_query ($conn,"SELECT `Amount`,`Pending` From `revenue` where (concat(`Dob_Day`,'/',`DoB_Month`,'/',`DoB_Year`))='" . $dat . "' and `Command`='" . $filter2 . "' and " . $val); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($amtpaid,$amtpend)=mysqli_fetch_row($result)) 
    {
      $amtpaid=number_format($amtpaid,2);
      $amtpend=number_format($amtpend,2);
      echo "<TR><TH align='left'><b>" . strtoupper($dat) . "</b></TH><TH>$amtpaid</TH><TH>$amtpend</TH></TR>";
    }
   }
      $rest = mysqli_query ($conn,"SELECT sum(`Amount`)as Amount,sum(`Pending`) as Pending From `revenue` where `Command`='" . $filter . "' and " . $val); 
      $row = mysqli_fetch_array($rest);
      echo "<TR><TH align='right'>Command Total:</TH><TH>" . number_format($row['Amount'],2) . "</TH><TH>" . number_format($row['Pending'],2) . "</TH></TR>";

    mysqli_free_result($resul);

 }
 else if ($cmbReport == "All Revenue Report")
 {
  if (trim($cmbTable)=="Daily")
  {
   $val="`DoB_Day`=date('d')";
  }
  else if (trim($cmbTable)=="Weekly")
  {
   $val="date(`Stock Date`)>'" . date('Y-m-d', strtotime('-1 week')) . "' and date(`Stock Date`)<'" . date('Y-m-d', strtotime('+1 day')) . "'";
  }
  else if (trim($cmbTable)=="Monthly")
  {
   $val="`DoB_Month`=" . $filter . " and `DoB_Year`=" . $year;
  }
  else if (trim($cmbTable)=="Quarterly")
  {
   $val="date(`Stock Date`)>'" . date('Y-m-d', strtotime('-3 month')) . "' and date(`Stock Date`)<'" . date('Y-m-d', strtotime('+1 day')) . "'";
  }
  else if (trim($cmbTable)=="Yearly")
  {
   $val="`DoB_Year`=" . $year;
  }

   echo " <tr><b> [$cmbTable Revenue Report]</b><br></tr>";
   echo "<TR bgcolor='#008000'><TH><b> Date </b>&nbsp;</TH><TH><b> Command </b>&nbsp;</TH><TH><b> Amount Collected </b>&nbsp;</TH><TH><b> Amount Pending </b>&nbsp;</TH></TR>";
 
   $resul = mysqli_query ($conn,"SELECT distinct concat(`Dob_Day`,'/',`DoB_Month`,'/',`DoB_Year`) as date From `revenue` where " . $val); 
   while(list($dat)=mysqli_fetch_row($resul)) 
   {	
      echo "<TR><TH align='left' colspan='5'><b>" . strtoupper($dat) . "</b></TH></TR>";

   $reslt = mysqli_query ($conn,"SELECT distinct `Command` From `revenue` where (concat(`Dob_Day`,'/',`DoB_Month`,'/',`DoB_Year`))='" . $dat . "' and " . $val); 
   while(list($cmd)=mysqli_fetch_row($reslt)) 
   {	      
   $result = mysqli_query ($conn,"SELECT `Amount`,`Pending` From `revenue` where `Command`='" . $cmd . "' and (concat(`Dob_Day`,'/',`DoB_Month`,'/',`DoB_Year`))='" . $dat . "' and " . $val); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($amtpaid,$amtpend)=mysqli_fetch_row($result)) 
    {
      $amtpaid=number_format($amtpaid,2);
      $amtpend=number_format($amtpend,2);
      echo "<TR><TH></TH><TH align='left'><b>" . strtoupper($cmd) . "</b></TH><TH>$amtpaid</TH><TH>$amtpend</TH></TR>";
    }
   }
      $rest = mysqli_query ($conn,"SELECT sum(`Amount`)as Amount,sum(`Pending`) as Pending From `revenue` where (concat(`Dob_Day`,'/',`DoB_Month`,'/',`DoB_Year`))='" . $dat . "' and " . $val); 
      $row = mysqli_fetch_array($rest);
      echo "<TR bgcolor='#e8e7e6'><TH></TH><TH align='right'>Date Total:</TH><TH>" . number_format($row['Amount'],2) . "</TH><TH>" . number_format($row['Pending'],2) . "</TH></TR>";
   }
      $rest2 = mysqli_query ($conn,"SELECT sum(`Amount`)as Amount,sum(`Pending`) as Pending From `revenue` where " . $val); 
      $rowt = mysqli_fetch_array($rest2);
      echo "<TR bgcolor='gray'><TH align='right'>All Command Total:</TH><TH>'</TH><TH>" . number_format($rowt['Amount'],2) . "</TH><TH>" . number_format($rowt['Pending'],2) . "</TH></TR>";
    mysqli_free_result($result);
 }
 else if ($cmbReport == "Analysis Report")
 {
 @$filter = $_REQUEST["filter"];
 @$filter2 = $_REQUEST["filter2"];

#############
   $query_delete ="delete from `analysis`";
   $result_delete = mysqli_query($conn,$query_delete) or die(mysqli_error());
##
   $query_insert_i ="insert into `analysis` (`iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount`) 
                     select `Source`,`Note`, `Date`,`Amount`,'-','-','-','-' from `sundry` where `Type`='Income'";
   $result_insert_i = mysqli_query($conn,$query_insert_i) or die(mysqli_error());

   $query_insert_e ="insert into `analysis` (`iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount`) 
                     select '-','-','-','-',`Source`,`Note`, `Date`,`Amount` from `sundry` where `Type`='Expenditure'";
   $result_insert_e = mysqli_query($conn,$query_insert_e) or die(mysqli_error());
###############
   echo "<TR bgcolor='#c0c0c0'><TH colspan='4'><b> INCOME </b>&nbsp;</TH><TH colspan='4'><b> EXPENDITURE</TH></TR>";
   echo "<TR bgcolor='#ccffff'><TH><b> Category </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH><TH><b> Category </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT `iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount` FROM `analysis`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<br>Nothing to Display!<br>"); 
   } 

    while(list($iclass,$idetails,$idate,$iamount,$eclass,$edetails,$edate,$eamount)=mysqli_fetch_row($result)) 
    {	
      echo "<TR><TH>$iclass </TH><TH>$idetails</TH><TH>$idate</TH><TH align='right'>$iamount</TH><TH>$eclass </TH><TH>$edetails</TH><TH>$edate</TH><TH align='right'>$eamount</TH></TR>";
    }
   echo "<TR><TH colspan='8'></TH></TR>";

   $res = mysqli_query ($conn,"SELECT sum(`iamount`) as iamt,sum(`eamount`) as eamt From `analysis`"); 
   $rowsum = mysqli_fetch_array($res);
   $iamt=$rowsum['iamt'];
   $iamt=number_format($iamt,2);
   $eamt=$rowsum['eamt'];
   $eamt=number_format($eamt,2);
   echo "<TR><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $iamt</b></font></TH><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $eamt</b></font></TH></TR>";

 }
 else if ($cmbReport == "Deposit/Withdrawal Analysis")
 {
 @$filter = $_REQUEST["filter"];
 @$filter2 = $_REQUEST["filter2"];

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> [Deposit/Withdrawal Analysis Report]</b></font></tr>";
#   echo "<TR bgcolor='#c0c0c0'><TH colspan='4'><b> DEPOSIT </b>&nbsp;</TH><TH colspan='1'><b> WITHDRAWAL</TH></TR>";
   echo "<TR bgcolor='#ccffff'><TH><b> Account Number </b>&nbsp;</TH><TH><b> Agent/Transactor </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Deposit Amount </b>&nbsp;</TH><TH><b> Withdrawal Amount </b>&nbsp;</TH></TR>";
 
if (empty($filter) or $filter =="" or empty($filter2) or $filter2 =="")
{
   $result = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Deposit`, `Withdrawal` FROM `transactions` order by `Date`"); 
   $result2 = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Withdrawal` FROM `transactions` where `Transaction Type`='Withdrawal' order by `Date`"); 
} else {
   $result = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Deposit`, `Withdrawal` FROM `transactions` where (`Date` between '" . $filter . "' and '" . $filter2 . "') order by `Date`"); 
   $result2 = mysqli_query ($conn,"SELECT `Account Number`,`Transactor`, `Date`, `Withdrawal` FROM `transactions` where `Transaction Type`='Withdrawal' and (`Date` between '" . $filter . "' and '" . $filter2 . "') order by `Date`"); 
}

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<br>No Deposit to Display!<br>"); 
   } 
   if(mysqli_num_rows($result2) == 0)
   { 
        echo("<br>No Withdrawal to Display!<br>"); 
   } 

    $iamt=0;
    $eamt=0;
    while(list($iclass,$idetails,$idate,$iamount,$eamount)=mysqli_fetch_row($result)) 
    {
    $eamt=$eamt+$eamount;		
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
      echo "<TR><TH>$iclass </TH><TH>$idetails</TH><TH>$idate</TH><TH align='right'>$iamount</TH><TH align='right'>$eamount</TH></TR>";
    }
/*
    while(list($eclass,$edetails,$edate,$eamount)=mysqli_fetch_row($result2)) 
    {
    $eamt=$eamt+$eamount;	
     echo "<TH>$eclass </TH><TH>$edetails</TH><TH>$edate</TH><TH align='right'>$eamount</TH></TR>";
    }
*/
   echo "<TR><TH colspan='5'></TH></TR>";

   $iamt=number_format($iamt,2);
   $eamt=number_format($eamt,2);
   echo "<TR><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $iamt</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $eamt</b></font></TH></TR>";


    $val='Deposit/Withdrawal Analysis';
  
    mysqli_free_result($result);
 }
 else if ($cmbReport == "Non-Moving Stock Report")
 {
  if (trim($cmbTable)=="Daily")
  {
   $val="`Sales Date`=date('$filter')";
  }
  else if (trim($cmbTable)=="Weekly")
  {
   $val="date(`Sales Date`)=" . date('W');
  }
  else if (trim($cmbTable)=="Monthly")
  {
   $val="date(`Sales Date`)=" . date('m');
  }
  else if (trim($cmbTable)=="Yearly")
  {
   $val="date(`Sales Date`)=" . date('Y');
  }

   echo "<TR bgcolor='#008000'><TH><b> Stock Code </b>&nbsp;</TH><TH><b> Stock Name </b>&nbsp;</TH><TH><b> Sales Date </b>&nbsp;</TH><TH><b> Qnty Sold </b>&nbsp;</TH><TH><b> Unit Cost </b>&nbsp;</TH><TH><b> Total Cost </b>&nbsp;</TH><TH><b> Paid </b>&nbsp;</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT `Stock Code`, `Stock Name`,`Sales Date`, `Qnty Sold`, `Unit Cost`, `Total Cost`, `Paid` From `sales` where " . $val . " order by `Stock Code`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 
    $val='Daily';

    while(list($stockcode,$stockname,$salesdate,$qntysold,$unitcost,$totalcost,$paid)=mysqli_fetch_row($result)) 
    {	
      echo "<TR><TH>$stockcode </TH><TH>$stockname</TH><TH>$salesdate</TH><TH>$qntysold</TH><TH>$unitcost</TH><TH>$totalcost</TH><TH>$paid</TH></TR>";
    }
 }
?>