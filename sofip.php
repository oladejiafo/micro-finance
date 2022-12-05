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
   <input type="hidden" name="cmbReport" size="12" value="Statement of Financial Position">
&nbsp;
  Enter Date Range (Ending): 
   <input type="text" id="inputFieldB" name="filter2" value="2015-12-31" size="8">
&nbsp;
     <input type="submit" value="Generate" name="submit">
     <br>
</form>
</div>

<div>
     <h3><center><u>STATEMENT OF FINANCIAL POSITION REPORT</u></center></h3>
     <h4><center>FROM: <font color='red'><?php echo date('d F, Y',strtotime($filter)); ?></font> TO <font color='red'><?php echo date('d F, Y',strtotime($filter2)); ?></font> </center></h4>
 </div>

 <?php
   $limit      = 50; 
   @$page=$_GET['page'];
   $query_count    = "SELECT * FROM `heads` where `Category` in ('Cash, Cheques and Other Cash Items','Accounts with Banks and other Financial Institutions','Loans and Advances','Prepayments and Other Receivables','Property and Equipment','Investments')";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  
$yr1=date('Y', strtotime($filter));
$yr2=$yr1-1;
   echo " <div><font face='Verdana' color='#000000' style='font-size: 11pt'><b> </b></font></div>";
  ?>
  <div class="tab-row" style="font-weight:bold; font-size:16px">
    <div  class="cell" style='width:50%; background-color:#c0c0c0'><b>Description</b></div>
    <div  class="cell" style='width:50%; background-color:#c0c0c0'><b>Amount(N)</b></div>
  </div>
<?php
########ASSETS
       $sqlt="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Cash on Hand','Petty Cash', 'Vault Cash', 'Cheques in Transit', 'Other Cash Accounts') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
       $amtA1=$rowt['amount1'];
 
       $sqlt2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Cash on Hand','Petty Cash','Vault Cash','Cheques in Transit', 'Other Cash Accounts') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
       $amtA2=$rowt2['amount2'];

       $sqlt3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('Consumer Loans to Clients','Business Loans to Clients','Agricultural Loans to Clients','Real Estate Loans to Clients','Savings and Deposit Secured Loans to Clients','Other Short-term Clients Loans','Current and Outstanding Loans to Non-Clients','Restructured Loans to Clients','Restructured Loans to Non-Clients','Past Due Non-Performing Loans (NPL) Account') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
       $amtA3=$rowt3['amount3'];

       $sqlt3A2="SELECT sum(`Amount`) as amount31 FROM `cash` where `Classification` in ('Held to maturity financial asset') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3A2 = mysqli_query($conn,$sqlt3A2) or die('Could not look up user data; ' . mysqli_error());
       $rowt3A2 = mysqli_fetch_array($resultt3A2);
       $amtA31=$rowt3A2['amount31'];

       $sqlt4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Prepayments','Short-term Receivables') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
       $amtA4=$rowt4['amount4'];

       $sqlt5="SELECT sum(`Amount`) as amount5 FROM `cash` where `Classification` in ('Receivables') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt5 = mysqli_query($conn,$sqlt5) or die('Could not look up user data; ' . mysqli_error());
       $rowt5 = mysqli_fetch_array($resultt5);
       $amtA5=$rowt5['amount5'];

       $sqlt6="SELECT sum(`Amount`) as amount6 FROM `cash` where `Classification` in ('Land and Buildings','Office Equipment','Plant and Machinery','Vehicles','Furniture and Fixture','Computer and other Equipment','Intangible Assets','Other Fixed Assets','Accumulated Amortisation and Depreciation') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt6 = mysqli_query($conn,$sqlt6) or die('Could not look up user data; ' . mysqli_error());
       $rowt6 = mysqli_fetch_array($resultt6);
       $amtA6=$rowt6['amount6'];

       $sqlt7="SELECT sum(`Amount`) as amount7 FROM `cash` where `Classification` in ('Investment in CBN Approved Government Securities','Loans to other MFBs','Other Investments') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt7 = mysqli_query($conn,$sqlt7) or die('Could not look up user data; ' . mysqli_error());
       $rowt7 = mysqli_fetch_array($resultt7);
       $amtA7=$rowt7['amount7'];

       $sqlt8="SELECT sum(`Amount`) as amount8 FROM `cash` where `Classification` in ('Deffered tax asset') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt8 = mysqli_query($conn,$sqlt8) or die('Could not look up user data; ' . mysqli_error());
       $rowt8 = mysqli_fetch_array($resultt8);
       $amtA8=$rowt8['amount8'];

       $sqlt9="SELECT sum(`Amount`) as amount9 FROM `cash` where `Classification` in ('Intangible assets') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt9 = mysqli_query($conn,$sqlt9) or die('Could not look up user data; ' . mysqli_error());
       $rowt9 = mysqli_fetch_array($resultt9);
       $amtA9=$rowt9['amount9'];

       $sqlt9i="SELECT sum(`Amount`) as amount9i FROM `cash` where `Classification` in ('Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)', 'Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt9i = mysqli_query($conn,$sqlt9i) or die('Could not look up user data; ' . mysqli_error());
       $rowt9i = mysqli_fetch_array($resultt9i);
       $amtA9i=$rowt9i['amount9i'];

       $sqlt10="SELECT sum(`Amount`) as amount10 FROM `cash` where `Classification` in ('Deferred Grant Revenue','Deferred Revenue due to Donated Fixed Assets','Other Deferred Revenue Items') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt10 = mysqli_query($conn,$sqlt10) or die('Could not look up user data; ' . mysqli_error());
       $rowt10 = mysqli_fetch_array($resultt10);
       $amtA10=$rowt10['amount10'];

########LIABILITIES
       $sqlL="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Deposit from banks') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL = mysqli_query($conn,$sqlL) or die('Could not look up user data; ' . mysqli_error());
       $rowL = mysqli_fetch_array($resultL);
       $amtL1=$rowL['amount1'];
 
       $sqlL2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Customers Deposits','Term Deposits') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL2 = mysqli_query($conn,$sqlL2) or die('Could not look up user data; ' . mysqli_error());
       $rowL2 = mysqli_fetch_array($resultL2);
       $amtL2=$rowL2['amount2'];

       $sqlL3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('Income Tax') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL3 = mysqli_query($conn,$sqlL3) or die('Could not look up user data; ' . mysqli_error());
       $rowL3 = mysqli_fetch_array($resultL3);
       $amtL3=$rowL3['amount3'];

       $sqlL31="SELECT sum(`Amount`) as amount31 FROM `cash` where `Classification` in ('Interest Payable on Short-term Bank Loans','Interest Payable on Long-term Bank Loans','Interest Payable on Other Borrowings') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL31 = mysqli_query($conn,$sqlL31) or die('Could not look up user data; ' . mysqli_error());
       $rowL31 = mysqli_fetch_array($resultL31);
       $amtL31=$rowL31['amount31'];

       $sqlL4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` like '%Audit%' and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL4 = mysqli_query($conn,$sqlL4) or die('Could not look up user data; ' . mysqli_error());
       $rowL4 = mysqli_fetch_array($resultL4);
       $amtL4=$rowL4['amount4'];

       $sqlL5="SELECT sum(`Amount`) as amount5 FROM `cash` where `Classification` in ('Interest Payable on Savings Deposits', 'Interest Payable on Term Deposits', 'Accounts Payable', 'Withholding Tax','Social security Tax', 'Profit Tax', 'Minimum Tax', 'Other Taxes', 'Suspense Items (unidentified)', 'Clearing Account', 'Other Liabilities') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultL5 = mysqli_query($conn,$sqlL5) or die('Could not look up user data; ' . mysqli_error());
       $rowL5 = mysqli_fetch_array($resultL5);
       $amtL5=$rowL5['amount5'];

########EQUITY
       $sqlE="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Share Capital') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE = mysqli_query($conn,$sqlE) or die('Could not look up user data; ' . mysqli_error());
       $rowE = mysqli_fetch_array($resultE);
       $amtE1=$rowE['amount1'];
 
       $sqlE2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Specific Reserve Expense') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE2 = mysqli_query($conn,$sqlE2) or die('Could not look up user data; ' . mysqli_error());
       $rowE2 = mysqli_fetch_array($resultE2);
       $amtE2=$rowE2['amount2'];

       $sqlE3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('General Reserve Expense', 'Provision for Loss on Investments and Loans to other Organizations','Provision for Loss on Assets Acquired in Liquidation', 'General Reserves') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE3 = mysqli_query($conn,$sqlE3) or die('Could not look up user data; ' . mysqli_error());
       $rowE3 = mysqli_fetch_array($resultE3);
       $amtE3=$rowE3['amount3'];

       $sqlE4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Retained Earnings','Net Income (Loss) for the Current Year','Dividends Declared') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultE4 = mysqli_query($conn,$sqlE4) or die('Could not look up user data; ' . mysqli_error());
       $rowE4 = mysqli_fetch_array($resultE4);
       $amtE4=$rowE4['amount4'];

       $totA=$amtA1+$amtA2+$amtA3+$amtA31+$amtA4+$amtA5+$amtA6+$amtA7+$amtA8+$amtA9+$amtA9i+$amtA10;
       $totL=$amtL1+$amtL2+$amtL3+$amtL31+$amtL4+$amtL5;
       $totE=$amtE1+$amtE2+$amtE3-$amtE4;

       $totLE=$totL+$totE;

       $totA1=$totA;
       $totL1=$totL;
       $totE1=$totE;
       $totLE1=$totLE;

       $amtA1=number_format($amtA1,2);
       $amtA2=number_format($amtA2,2);
       $amtA3=number_format($amtA3,2);
       $amtA31=number_format($amtA31,2);
       $amtA4=number_format($amtA4,2);
       $amtA5=number_format($amtA5,2);
       $amtA6=number_format($amtA6,2);
       $amtA7=number_format($amtA7,2);
       $amtA8=number_format($amtA8,2);
       $amtA9=number_format($amtA9,2);
       $amtA9i=number_format($amtA9i,2);
       $amtA10=number_format($amtA10,2);

       $amtL1=number_format($amtL1,2);
       $amtL2=number_format($amtL2,2);
       $amtL3=number_format($amtL3,2);
       $amtL31=number_format($amtL31,2);
       $amtL4=number_format($amtL4,2);
       $amtL5=number_format($amtL5,2);

       $amtE1=number_format($amtE1,2);
       $amtE2=number_format($amtE2,2);
       $amtE3=number_format($amtE3,2);
       $amtE4=number_format($amtE4,2);

       $totA=number_format($totA,2);
       $totL=number_format($totL,2);
       $totE=number_format($totE,2);
       $totLE=number_format($totLE,2);

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px">ASSETS</div>
        <div  class="cell" style="width:50%">&nbsp;</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Cash and bank balances</div>
        <div  class="cell" style="width:50%">' .$amtA1. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Due from other banks</div>
        <div  class="cell" style="width:50%">' .$amtA2. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Loans and advances to customers</div>
        <div  class="cell" style="width:50%">' .$amtA3. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Held to maturity financial assets</div>
        <div  class="cell" style="width:50%">' .$amtA31. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Prepayment and other assets</div>
        <div  class="cell" style="width:50%">' .$amtA4. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Receivables</div>
        <div  class="cell" style="width:50%">' .$amtA5. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Property, Plant & Equipment</div>
        <div  class="cell" style="width:50%">' .$amtA6. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Investment Property</div>
        <div  class="cell" style="width:50%">' .$amtA7. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Deffered tax asset</div>
        <div  class="cell" style="width:50%">' .$amtA8. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Intangible assets</div>
        <div  class="cell" style="width:50%">' .$amtA9. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Provisions</div>
        <div  class="cell" style="width:50%">' .$amtA9i. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Other assets</div>
        <div  class="cell" style="width:50%">' .$amtA10. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px"><b>TOTAL ASSETS </b></div>
        <div  class="cell" style="width:50%">';
           if($totA1<0) { echo "<font color ='red'>(" . number_format((-1)*$totA1,2) . ")</font>"; } else if($totA1>0) { echo "<font color ='green'>" . $totA . "</font>"; } else { echo $totA; }
      echo '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px"><b>LIABILITIES </b></div>
        <div  class="cell" style="width:50%">';

      echo '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Deposit from banks</div>
        <div  class="cell" style="width:50%">' .$amtL1. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Deposit from customers</div>
        <div  class="cell" style="width:50%">' .$amtL2. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Bank Borrowings/Overdrafts</div>
        <div  class="cell" style="width:50%">' .$amtL31. '</div>
      </div>';     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Current income tax liability</div>
        <div  class="cell" style="width:50%">' .$amtL3. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Accrued audit fees</div>
        <div  class="cell" style="width:50%">' .$amtL4. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Other Liabilities</div>
        <div  class="cell" style="width:50%">' .$amtL5. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px"><b>TOTAL LIABILITIES </b></div>
        <div  class="cell" style="width:50%">';
          if($totL1<0) { echo "<font color ='red'>(" . number_format((-1)*$totL1,2) . ")</font>"; } else if($totL1>0) { echo "<font color ='green'>" . $totL . "</font>"; } else { echo $totL; }
      echo '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px">EQUITY</div>
        <div  class="cell" style="width:50%">';

      echo '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Share capital</div>
        <div  class="cell" style="width:50%">' .$amtE1. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Statutory reserve</div>
        <div  class="cell" style="width:50%">' .$amtE2. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Statutory credit reserve</div>
        <div  class="cell" style="width:50%">' .$amtE3. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">&nbsp;Retained Earnings</div>
        <div  class="cell" style="width:50%">' .$amtE4. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px"><b>TOTAL EQUITY </b></div>
        <div  class="cell" style="width:50%">';
           if($totE1<0) { echo "<font color ='red'>(" . number_format((-1)*$totE1,2) . ")</font>"; } else if($totE1>0) { echo "<font color ='green'>" . $totE . "</font>"; } else { echo $totE; }
      echo '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%;height:35px"><b>TOTAL EQUITY  AND LIABILITIES</b></div>
        <div  class="cell" style="width:50%">';
          if($totLE1<0) { echo "<font color ='red'>(" . number_format((-1)*$totLE1,2) . ")</font>"; } else if($totLE1>0) { echo "<font color ='green'>" . $totLE . "</font>"; } else { echo $totLE; }
      echo '</div>
      </div>';
?>
</fieldset>

<div>
<?php
echo "<a target='blank' href='rptsofip.php?filter=$filter&filter2=$filter2'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='expsofip.php?filter=$filter&filter2=$filter2'> Export this Report</a> &nbsp; ";
?>
</div>

</div>