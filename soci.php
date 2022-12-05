<?php
#session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
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

if ($filter=="" or empty($filter))
{
 $filter="2015-01-01";
 $filter2="2025-12-31";
}
?>
<div align="center">
<form  action="report.php" method="POST">
  Enter Date Range (Starting): 
  <input type="text" id="inputFieldA" name="filter" value="2015-01-01" size="8">
   <input type="hidden" name="cmbReport" size="12" value="Statement of Comprehensive Income">
 &nbsp;
  Enter Date Range (Ending): 
   <input type="text" id="inputFieldB" name="filter2" value="2015-12-31" size="8">
&nbsp;
     <input type="submit" value="Generate" name="submit">
     <br>
</form>
</div>


 <div>
     <h3><center><u>STATEMENT OF COMPREHENSIVE INCOME REPORT</u></center></h3>
     <h4><center>FROM: <font color='red'><?php echo date('d F, Y',strtotime($filter)); ?></font> TO <font color='red'><?php echo date('d F, Y',strtotime($filter2)); ?></font> </center></h4>
 </div>

 <?php
   $limit      = 50; 
   @$page=$_GET['page'];
   $query_count    = "SELECT * FROM `heads` where `Category` in ('Interest Income','Interest Expense','Fee and commission Income','Finance Income','Operating Expenses','Tax on Profit')";
   $result_count   = mysqli_query($conn,$query_count); 
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  
$yr1=date('Y', strtotime($filter));
$yr2=$yr1-1;

 ?>
  <div class="tab-row" style="font-weight:bold; font-size:16px">
    <div  class="cell" style='width:50%; background-color:#c0c0c0'><b>Description </b></div>
    <div  class="cell" style='width:50%; background-color:#c0c0c0'><b> Amount (N)</b></div>
  </div>
<?php
   $result = mysqli_query ($conn,"SELECT distinct `Category`,`Description`,`Remarks` FROM `heads` where `Category` like 'Interest Income%' or `Category` like '%Interest%Expense%' or `Category` like 'Fee and Charges%' or `Category` like 'Other Income Accounts' or `Category` like 'Other Charges' or `Category` like 'General and Administrative Expenses' or `Category` like 'Loan Servicing%' or `Category` like 'Supervision and Licensing Fees%' or `Category` like 'Promotional Expenses%' or `Category` like 'Tax and Licenses%' group by `Description` order by `Category` LIMIT $limitvalue, $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

$ttt=0;
$ttt2=0;
$ttt3=0;
$ttt4=0;
$ttt5=0;

       $sqlt="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Interest Income on Loans to Clients','Interest Income on Loans to Non-Clients','Interest Income from Balances','Interest Income from Accounts with Banks and other','Interest Income from Approved Investments','Other Interest Income') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
       $amtt1=$rowt['amount1'];
 
       $sqlt2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Interest Income Expense on Clients Deposits','Interest Income Expense on Clients Voluntary Savings','Interest Income Expense on Deposits of Non-Clients','Interest Income Expense on Deposits of Non-Clients','Interest Income Expense on Short-term Loans','Interest Income Expense on Long-term Loans','Interest Income Expense on other Borrowings','Fees Paid for Loans form Banks and other Organization','Commissions Paid for Loans from Banks and other Organizations') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
       $amtt2=$rowt2['amount2'];

       $sqlt3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('Client Fees Paid','Client Penalties','Fee from Payment services and Intra-country Transfers','Fee from Offering Insurance Products as Agent','Other Operating Income') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
       $amtt3=$rowt3['amount3'];

       $sqlt4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Gain on Foreign Exchange','Gain on Disposal of Property and Equipment','Gain on Sale of Investments','Rental Income','Reversal of Provisions for Liabilities and Charges','Write-back of Principal Received on Loans Previously Written Off','Write-back of Interest Received on Loans Previously Written Off','Other Income Items') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
       $amtt4=$rowt4['amount4'];

       $sqlt5="SELECT sum(`Amount`) as amount5 FROM `cash` where `Classification` in ('Loss on Foreign Exchange',
'Loss on Sale of Property and Equipment',
'Loss on Sale or Disposal of Investments',
'Provision for Major Repairs and Maintenance',
'Provision for Off-balance Sheet Commitments',
'Provision for Claims/Litigation',
'Other Charges',
'Employee Personnel Expenses',
'Office Expenses',
'Professional Expenses',
'Occupancy Expenses - Rent',
'Occupancy Expenses - Utilities/Electricity',
'Occupancy Expenses - Others',
'Employee Travel Expenses',
'Depreciation and Amortisation',
'Governance Expense',
'Loan Collection Expenses',
'Lien Recording',
'Credit history Investigation',
'Other Loan Servicing Expenses',
'Supervision Fee',
'Licensing Fee',
'Advertising Expenses',
'Publicity and Promotion',
'Published Materials',
'Other Promotional Expenses',
'Business License and other Local Taxes',
'Property Tax',
'Municipal/LGA Tax',
'Capital Tax',
'Registration Duty, Stamp Duty and their Equivalent',
'Other Indirect and Miscellaneous Taxes') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt5 = mysqli_query($conn,$sqlt5) or die('Could not look up user data; ' . mysqli_error());
       $rowt5 = mysqli_fetch_array($resultt5);
       $amtt5=$rowt5['amount5'];


       $sqlt6="SELECT sum(`Amount`) as amount6 FROM `cash` where `Classification` in ('Income Tax') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt6 = mysqli_query($conn,$sqlt6) or die('Could not look up user data; ' . mysqli_error());
       $rowt6 = mysqli_fetch_array($resultt6);
       $amtt6=$rowt6['amount6'];
       $netii=$amtt1-$amtt2;
       $pl=$netii+$amtt3+$amtt4+$amtt5;
       $cip=$pl-$amtt6;
       $rati=$cip/20000000;

       $netii1=$netii;
       $pl1=$pl;
       $cip1=$cip;
       $rati1=$rati;

       $amtt1=number_format($amtt1,2);
       $amtt2=number_format($amtt2,2);
       $amtt3=number_format($amtt3,2);
       $amtt4=number_format($amtt4,2);
       $amtt5=number_format($amtt5,2);
       $amtt6=number_format($amtt6,2);
       $netii=number_format($netii,2);
       $pl=number_format($pl,2);
       $cip=number_format($cip,2);
       $rati=number_format($rati,2);

      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Interest Income</div>
        <div  class="cell" style="width:50%">' .$amtt1. '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Interest Expense</div>
        <div  class="cell" style="width:50%">(' .$amtt2. ')</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px"><b>NET INTEREST INCOME </b></div>
        <div  class="cell" style="width:50%">';
           if($netii1<0) { echo "<font color ='red'>(" . number_format((-1)*$netii1,2) . ")</font>"; } else if($netii1>0) { echo "<font color ='green'>" . $netii . "</font>"; } else { echo $netii; }
       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Fees and Commission Income</div>
        <div  class="cell" style="width:50%">' .$amtt3. '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Finance Income</div>
        <div  class="cell" style="width:50%">' .$amtt4. '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Operating Expense</div>
        <div  class="cell" style="width:50%">(' .$amtt5. ')</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px">PROFIT (/LOSS) before income tax</div>
        <div  class="cell" style="width:50%">';
           if($pl1<0) { echo "<font color ='red'>(" . number_format((-1)*$pl1,2) . ")</font>"; } else if($pl1>0) { echo "<font color ='green'>" . $pl . "</font>"; } else { echo $pl; }
       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Tax on Profit</div>
        <div  class="cell" style="width:50%">' .$amtt6. '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px">COMPREHENSIVE INCOME for the period </div>
        <div  class="cell" style="width:50%">';
           if($cip1<0) { echo "<font color ='red'>(" . number_format((-1)*$cip1,2) . ")</font>"; } else if($cip1>0) { echo "<font color ='green'>" . $cip . "</font>"; } else { echo $cip; }
       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px">OTHER COMPREHENSIVE INCOME</div>
        <div  class="cell" style="width:50%">';

       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Remeasurement of post employment benefits obligation</div>
        <div  class="cell" style="width:50%">';

       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px">TOTAL COMPREHENSIVE INCOME for the period</div>
        <div  class="cell" style="width:50%">';
            if($cip1<0) { echo "<font color ='red'>(" . number_format((-1)*$cip1,2) . ")</font>"; } else if($cip1>0) { echo "<font color ='green'>" . $cip . "</font>"; } else { echo $cip; }
       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px">TOTAL COMPREHENSIVE INCOME attributable to:</div>
        <div  class="cell" style="width:50%">';

       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Owners of the parent </div>
        <div  class="cell" style="width:50%">';
            if($cip1<0) { echo "<font color ='red'>(" . number_format((-1)*$cip1,2) . ")</font>"; } else if($cip1>0) { echo "<font color ='green'>" . $cip . "</font>"; } else { echo $cip; }
       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px">EARNINGS (/LOSS) PER SHARE (Naira)</div>
        <div  class="cell" style="width:50%">';

       echo '</div>
      </div>';
      echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Basic earnings (/loss) per share</div>
        <div  class="cell" style="width:50%">';
           if($rati1<0) { echo "<font color ='red'>(" . number_format((-1)*$rati1,2) . ")</font>"; } else if($rati1>0) { echo "<font color ='green'>" . $rati . "</font>"; } else { echo $rati; }
       echo '</div>
      </div>';

?>
</fieldset>

<div align="center">
<?php
echo "<a target='blank' href='rptsoci.php?filter=$filter&filter2=$filter2'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='expsoci.php?filter=$filter&filter2=$filter2'> Export this Report</a> &nbsp; ";
?>
</div>

</div>

