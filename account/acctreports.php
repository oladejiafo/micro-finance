<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3) & $_SESSION['access_lvl'] != 5)
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
 require_once 'conn.php';
 require_once 'header.php'; 
 require_once 'style.php';

 $cmbReport = $_POST["cmbReport"];
 $filter = $_POST["filter"];
?>
<table width='950'>
<tr align='center'>
 <td bgcolor="#008000"><b>
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Accounting Reports</font></b>
 </td>
</tr>
</table>
<fieldset style="padding: 2">
<p><legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'acctheader.php'; ?>
</p></font></i></b></legend>

<form  action="acctreports.php" method="GET">
 <body bgcolor="#0066FF">
&nbsp;Select a Report:&nbsp;
 <select size="1" name="cmbReport">
  <option selected>- Select Report-</option>
  <option>Analysis</option>
  <option>Balance Sheet</option>
  <option>Profit & Loss</option>
  <option>Trial Balance</option>
  <option>Daily Cash</option>
  <option>Weekly Cash</option>
  <option>Monthly Cash Summary</option>
  <option>Yearly Cash Summary</option>
  <option>Monthly Expenditure</option>
 </select>
   &nbsp;
   <input type="submit" value="Open" name="submit">
     <br>
 </body>
</form>
 
<TABLE width='925' border='1' cellpadding='1' cellspacing='1' align='center' id="table3">
<?php
 $cmbReport = $_REQUEST["cmbReport"];
 $cmbTable=$_REQUEST['cmbTable']; 
 $filter=$_REQUEST['filter']; 

if (trim($cmbReport) == "- Select Report-")
{
  echo "<b>Please Select a Report from the drop-down box and click 'Open'.<b>";        
}
else if (trim($cmbReport)=="Monthly Expenditure")
{
   $limit      = 25; 
   $page=$_GET['page'];
   $query_count    = "SELECT * FROM `cash`";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> [Monthly Expenditure Report]</b></font></tr>";
   echo "<TR bgcolor='#008000'><TH colspan='5'><b> EXPENDITURE</TH></TR>";
   echo "<TR bgcolor='#ccffff'><TH><b> Item </b>&nbsp;</TH><TH><b> Budget </b>&nbsp;</TH><TH><b> Actual </b>&nbsp;</TH><TH><b> Variance </b>&nbsp;</TH><TH><b> Remark </b>&nbsp;</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT `Classification`,`Budget`,sum(`Amount`) as amt, `Particulars` FROM `cash` inner join `budget` on `cash`.`Classification`=`budget`.`Class` where month(`cash`.`Date`)=month(`budget`.`Month`) group by `Classification` LIMIT $limitvalue, $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($classi,$budget,$amt,$remark)=mysqli_fetch_row($result)) 
    {	
      $variance=$budget-$amt;
      $variance=number_format($variance,2);
      $budget=number_format($budget,2);
      $amt=number_format($amt,2);
      echo "<TR><TH>$classi </TH><TH align='right'>$budget</TH><TH align='right'>$amt</TH><TH align='right'>$variance</TH><TH>$remark </TH></TR>";
    }
   echo "<TR><TH colspan='5'></TH></TR>";

   $res = mysqli_query ($conn,"SELECT sum(`Budget`) as budgeti,sum(`Amount`) as amti,(sum(`Budget`)-sum(`Amount`)) as vari FROM `cash` inner join `budget` on `cash`.`Classification`=`budget`.`Class` where month(`cash`.`Date`)=month(`budget`.`Month`) group by `Classification`"); 
   $rowsum = mysqli_fetch_array($res);
   $amti=$rowsum['amti'];
   $amti=number_format($amti,2);
   $budgeti=$rowsum['budgeti'];
   $budgeti=number_format($budgeti,2);
   $vari=$rowsum['vari'];
   $vari=number_format($vari,2);
   echo "<TR><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $budgeti</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $amti</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $vari</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> &nbsp;</b></font></TH></TR>";

    $val='Monthly Expenditure';

    if($page != 1)
    {  
       $pageprev = $page-1;       
       echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$pageprev\">PREV PAGE</a>  ");
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
            echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$i\">$i</a>  ");  
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
            echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$i\">$i</a>  "); 
        } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1; 
          
        echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$pagenext\">NEXT PAGE</a>");  
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
 echo "<a target='blank' href='rptacctreports.php?cmbReport=$cmbReport&cmbTable=$cmbTable&filter=$filter'> Print this Report</a> &nbsp;";
?>
</td>
</tr>
</Table
</form>
<?php
}
else if (trim($cmbReport)=="Monthly Sales")
{
   $limit      = 25; 
   $page=$_GET['page'];
   $query_count    = "SELECT * FROM `sales`";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> [Monthly Sales Report]</b></font></tr>";
   echo "<TR bgcolor='#008000'><TH colspan='4'><b> </TH><TH colspan='3'><b> BANK</TH><TH colspan='3'><b> IMPREST</TH><TH colspan='1'><b> REMARK</TH></TR>";
   echo "<TR bgcolor='#ccffff'><TH><b> Date </b>&nbsp;</TH><TH><b> Source </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH><TH><b> Reciept No </b>&nbsp;</TH><TH><b> Amount (Bank) </b>&nbsp;</TH>
         <TH><b> Bank Name </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount (Imp) </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Slip No </b>&nbsp;</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT `Sales Date`,`Sold Name`,`Total Cost`, `Receipt`,`Bank Amount`,`Bank Name`,`Bank Date`,`Imprest Amount`,`Imprest Detail`,`Imprest Date`,`Slip No` FROM `sales` where month(`sales`.`Sales Date`)=month('" . Date('Y-m-d') . "') LIMIT $limitvalue, $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($sdate,$sname,$tcost,$receipt,$bamt,$bname,$bdate,$impamt,$impdet,$impdate,$slip)=mysqli_fetch_row($result)) 
    {	
      #$total=$budget-$amt;
      $tcost=number_format($tcost,2);
      $bamt=number_format($bamt,2);
      $impamt=number_format($impamt,2);
      echo "<TR><TH>$sdate </TH><TH>$sname</TH><TH align='right'>$tcost</TH><TH>$receipt</TH><TH>$bamt </TH><TH>$bname </TH><TH>$bdate</TH><TH align='right'>$impamt</TH><TH>$impdet</TH><TH>$impdate</TH><TH>$slip </TH></TR>";
    }
   echo "<TR><TH colspan='11'></TH></TR>";
 
   $res = mysqli_query ($conn,"SELECT sum(`Total Cost`) as tsoc, sum(`Bank Amount`) as amtb,sum(`Imprest Amount`) as amti FROM `sales` where month(`sales`.`Sales Date`)=month('" . Date('Y-m-d') . "')"); 
   $rowsum = mysqli_fetch_array($res);
   $amti=$rowsum['amti'];
   $amti=number_format($amti,2);
   $tsoc=$rowsum['tsoc'];
   $tsoc=number_format($tsoc,2);
   $amtb=$rowsum['amtb'];
   $amtb=number_format($amtb,2);
   echo "<TR><TH bgcolor='#C0C0C0' colspan='2' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tsoc</b></font></TH><TH bgcolor='#C0C0C0' colspan='2' align='right'><font style='font-size: 9pt'><b> $amtb</b></font></TH><TH bgcolor='#C0C0C0' colspan='3' align='right'><font style='font-size: 9pt'><b> $amti</b></font></TH><TH bgcolor='#C0C0C0' colspan='3' align='right'><font style='font-size: 9pt'><b> &nbsp;</b></font></TH></TR>";

    $val='Monthly Sales';

    if($page != 1)
    {  
       $pageprev = $page-1;       
       echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$pageprev\">PREV PAGE</a>  ");
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
            echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$i\">$i</a>  ");  
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
            echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$i\">$i</a>  "); 
        } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1; 
          
        echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$pagenext\">NEXT PAGE</a>");  
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
 echo "<a target='blank' href='rptacctreports.php?cmbReport=$cmbReport&cmbTable=$cmbTable&filter=$filter'> Print this Report</a> &nbsp;";
?>
</td>
</tr>
</Table
</form>
<?php
}
else if (trim($cmbReport)=="Weekly Cash")
{
require_once 'weeklycash.php';
}
else if (trim($cmbReport)=="Profit & Loss")
{
 # $val='Profit & Loss';
#require_once 'reports/account/rptpandlctb.php';
echo "<a target='_blank' href='reports/account/rptpandlctb.php'>Profit & Loss</a>";
}
else if (trim($cmbReport)=="Balance Sheet")
{
#    $val='Balance Sheet';
#require_once 'reports/account/rptpandlctb.php';
echo "<a target='_blank' href='reports/account/rptbalsheetctb.php'>Balance Sheet</a>";
}
else if (trim($cmbReport)=="Trial Balance")
{
#require_once 'reports/account/rptpandlctb.php';
echo "<a target='_blank' href='reports/account/rpttrialbalctb.php'>Trial Balance</a>";
}
else if (trim($cmbReport)=="Daily Cash")
{
#$val="`Sales Date`=date('$filter')";
require_once 'dailycash.php';
}
else if ($cmbReport == "Monthly Cash Summary")
{
require_once 'monthlycash.php';
}
else if (trim($cmbReport)=="Yearly Cash Summary")
{
require_once 'yearlycash.php';
}
else if (trim($cmbReport)=="Daily Cheque")
{
require_once 'dailycheque.php';
}
else if (trim($cmbReport)=="Monthly Cheque")
{  
require_once 'monthlycheque.php';
}
else if (trim($cmbReport)=="Yearly Cheque")
{  
require_once 'yearlycheque.php';
}
else if (trim($cmbReport)=="Analysis")
{  
#require_once 'banksummary.php';

#   $val="`Stock Date`=date('$filter')";

   $limit      = 25; 
   $page=$_GET['page'];
   $query_count    = "SELECT * FROM `analysis`";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  
#############
   $query_delete ="delete from `analysis`";
   $result_delete = mysqli_query($conn,$query_delete) or die(mysqli_error());
##
   $query_insert_i ="insert into `analysis` (`iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount`) 
                     select `Classification`,`Particulars`, `Date`,`Amount`,'-','-','-','-' from `cash` where `Type`='Income'";
   $result_insert_i = mysqli_query($conn,$query_insert_i) or die(mysqli_error());

   $query_insert_e ="insert into `analysis` (`iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount`) 
                     select '-','-','-','-',`Classification`,`Particulars`, `Date`,`Amount` from `cash` where `Type`='Expenditure'";
   $result_insert_e = mysqli_query($conn,$query_insert_e) or die(mysqli_error());
###############
   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> [Analysis Report]</b></font></tr>";
   echo "<TR bgcolor='#008000'><TH colspan='4'><b> INCOME </b>&nbsp;</TH><TH colspan='4'><b> EXPENDITURE</TH></TR>";
   echo "<TR bgcolor='#ccffff'><TH><b> Category </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH><TH><b> Category </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT `iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount` FROM `analysis` LIMIT $limitvalue, $limit"); 
  # $result2= mysqli_query ($conn,"SELECT cash.`Classification` , cash.`Particulars` , cash.`Date` , cash.`Amount` FROM `cash` where `Type`='Expenditure' LIMIT $limitvalue, $limit"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($iclass,$idetails,$idate,$iamount,$eclass,$edetails,$edate,$eamount)=mysqli_fetch_row($result)) 
    {	
      echo "<TR><TH>$iclass </TH><TH>$idetails</TH><TH>$idate</TH><TH align='right'>$iamount</TH><TH>$eclass </TH><TH>$edetails</TH><TH>$edate</TH><TH align='right'>$eamount</TH></TR>";
    }
   echo "<TR><TH colspan='6'></TH></TR>";

   $res = mysqli_query($conn,"SELECT sum(`iamount`) as iamt,sum(`eamount`) as eamt From `analysis`"); 
   $rowsum = mysqli_fetch_array($res);
   $iamt=$rowsum['iamt'];
   $iamt=number_format($iamt,2);
   $eamt=$rowsum['eamt'];
   $eamt=number_format($eamt,2);
   echo "<TR><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $iamt</b></font></TH><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $eamt</b></font></TH></TR>";

    $val='Analysis';

#      while(list($eclass,$edetails,$edate,$eamount)=mysqli_fetch_row($result2)) 
#      {	
#        echo "<TH>$eclass </TH><TH>$edetails</TH><TH>$edate</TH><TH>$eamount</TH></TR>";
#      }

    if($page != 1)
    {  
       $pageprev = $page-1;       
       echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$pageprev\">PREV PAGE</a>  ");
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
            echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$i\">$i</a>  ");  
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
            echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$i\">$i</a>  "); 
        } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1; 
          
        echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$pagenext\">NEXT PAGE</a>");  
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
?>
</table>