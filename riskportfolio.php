<?php
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

$cmbReport="Portfolio At Risk";
?>
<div align="center">

 <div><b>
     <h3><center><u>LOANS PORTFOLIO AT RISK</u></center></h3></b>
 </div>

 <?php
   $limit      = 50; 
   @$page=$_GET['page'];
   $query_count    = "SELECT * FROM `loan` where `Balance` > 0 and `Loan Status`='Active'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo "<TR bgcolor='#C0C0C0'><TH><b> </b></TH><TH><b> </b></TH>
<TH><b> </b></TH><TH><b>  </b></TH>
<TH><b> </b></TH><TH><b> </b></TH><TH><b> </b></TH>
<TH><b> </b></TH></TR>";
 ?>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:12.5%; background-color:#cbd9d9'><b>Days in Arrears</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Number of Loans</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Outstanding Balances of Loans</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Amount in Arrears</b></div>

    <div  class="cell"  style='width:12.5%; background-color:#cbd9d9'><b>Arrears Rate</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Portfolio At Risk</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Reserve Rate</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Reserve Amount</b></div>
  </div>
<?php
#   $result = mysql_query ("SELECT `ID`,`Account Number`, `Loan Amount`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Total Interest` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' LIMIT $limitvalue, $limit"); 
 

   $samtt=0;
   $sptdt=0;
   $sbalt=0;
   $samt01=0;
   $samt02=0;
   $samt03=0;
   $samt04=0;
   $samt05=0;
   $stint=0;
#   while(list($id,$acctno,$lamount,$ldate,$lduration,$ptd,$bal,$int)=mysql_fetch_row($result)) 
   {	
       $sqlt="SELECT count(`ID`) as nos FROM `loan` where `Balance`>0";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
     
       if ($rowt['nos']>0)
       {
        $lnos=number_format($rowt['nos'],0);
       } else {
        $lnos=0;
       }

       $valCL1="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-31 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt1="SELECT count(`ID`) as nos FROM `loan` where `Balance`>0 and $valCL1";
       $resultt1 = mysqli_query($conn,$sqlt1) or die('Could not look up user data; ' . mysqli_error());
       $rowt1 = mysqli_fetch_array($resultt1);
     
       if ($rowt1['nos']>0)
       {
        $lnos1=number_format($rowt1['nos'],0);
       } else {
        $lnos1=0;
       }

       $valCL2="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-30 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-61 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt2="SELECT count(`ID`) as nos2 FROM `loan` where `Balance`>0 and $valCL2";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
     
       if ($rowt2['nos2']>0)
       {
        $lnos2=number_format($rowt2['nos2'],0);
       } else {
        $lnos2=0;
       }

       $valCL3="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-60 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-91 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt3="SELECT count(`ID`) as nos3 FROM `loan` where `Balance`>0 and $valCL3";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
     
       if ($rowt3['nos3']>0)
       {
        $lnos3=number_format($rowt3['nos3'],0);
       } else {
        $lnos3=0;
       }

       $valCL4="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-90 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-180 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt4="SELECT count(`ID`) as nos4 FROM `loan` where `Balance`>0 and $valCL4";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
     
       if ($rowt4['nos4']>0)
       {
        $lnos4=number_format($rowt4['nos4'],0);
       } else {
        $lnos4=0;
       }

       $valCL5="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-181 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt5="SELECT count(`ID`) as nos FROM `loan` where `Balance`>0 and $valCL5";
       $resultt5 = mysqli_query($conn,$sqlt5) or die('Could not look up user data; ' . mysqli_error());
       $rowt5 = mysqli_fetch_array($resultt5);
     
       if ($rowt5['nos']>0)
       {
        $lnos5=number_format($rowt5['nos'],0);
       } else {
        $lnos5=0;
       }

################################################################################################
       $sqlt="SELECT sum(`Balance`) as balance FROM `loan` where `Balance`>0";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
     
       if ($rowt['balance']>0)
       {
        $balance=number_format($rowt['balance'],2);
       } else {
        $balance=0.00;
       }

       $valCLB1="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-31 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt1="SELECT sum(`Balance`) as balance1 FROM `loan` where `Balance`>0 and $valCLB1";
       $resultt1 = mysqli_query($conn,$sqlt1) or die('Could not look up user data; ' . mysqli_error());
       $rowt1 = mysqli_fetch_array($resultt1);
     
       if ($rowt1['balance1']>0)
       {
        $balance1=number_format($rowt1['balance1'],2);
       } else {
        $balance1=0.00;
       }

       $valCLB2="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-30 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-61 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt2="SELECT sum(`Balance`) as balance2 FROM `loan` where `Balance`>0 and $valCLB2";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
     
       if ($rowt2['balance2']>0)
       {
        $balance2=number_format($rowt2['balance2'],2);
       } else {
        $balance2=0.00;
       }

       $valCLB3="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-60 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-91 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt3="SELECT sum(`Balance`) as balance3 FROM `loan` where `Balance`>0 and $valCLB3";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
     
       if ($rowt3['balance3']>0)
       {
        $balance3=number_format($rowt3['balance3'],2);
       } else {
        $balance3=0.00;
       }

       $valCLB4="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-90 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-180 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt4="SELECT sum(`Balance`) as balance4 FROM `loan` where `Balance`>0 and $valCLB4";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
     
       if ($rowt4['balance4']>0)
       {
        $balance4=number_format($rowt4['balance4'],2);
       } else {
        $balance4=0.00;
       }

       $valCLB5="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-181 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt5="SELECT sum(`Balance`) as balance5 FROM `loan` where `Balance`>0 and $valCLB5";
       $resultt5 = mysqli_query($conn,$sqlt5) or die('Could not look up user data; ' . mysqli_error());
       $rowt5 = mysqli_fetch_array($resultt5);
     
       if ($rowt5['balance5']>0)
       {
        $balance5=number_format($rowt5['balance5'],2);
       } else {
        $balance5=0.00;
       }


################################################################################################
       $sqlt="SELECT sum(`PBalance`) as lamt FROM `loan` where `Balance`>0";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
     
       if ($rowt['lamt']>0)
       {
        $lamt=number_format($rowt['lamt'],2);
       } else {
        $lamt="-";
       }

       $valCLA1="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-31 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt1="SELECT sum(`PBalance`) as lamt1 FROM `loan` where `Balance`>0 and $valCLA1";
       $resultt1 = mysqli_query($conn,$sqlt1) or die('Could not look up user data; ' . mysqli_error());
       $rowt1 = mysqli_fetch_array($resultt1);
     
       if ($rowt1['lamt1']>0)
       {
        $pr1=($rowt1['lamt1']/$rowt['lamt'])*100;
        $lamt1=number_format($pr1,2);
       } else {
        $lamt1="-";
       }

       $valCLA2="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-30 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-61 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt2="SELECT sum(`PBalance`) as lamt2 FROM `loan` where `Balance`>0 and $valCLA2";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
     
       if ($rowt2['lamt2']>0)
       {
        $pr2=($rowt2['lamt2']/$rowt['lamt'])*100;
        $lamt2=number_format($pr2,2);
       } else {
        $lamt2="-";
       }

       $valCLA3="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-60 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-91 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt3="SELECT sum(`PBalance`) as lamt3 FROM `loan` where `Balance`>0 and $valCLA3";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
     
       if ($rowt3['lamt3']>0)
       {
        $pr3=($rowt3['lamt3']/$rowt['lamt'])*100;
        $lamt3=number_format($pr3,2);
       } else {
        $lamt3="-";
       }

       $valCLA4="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-90 day',strtotime(date('Y-m-d')))) . "' and date(`Loan Date`) >'" . date('Y-m-d', strtotime('-180 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt4="SELECT sum(`PBalance`) as lamt4 FROM `loan` where `Balance`>0 and $valCLA4";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
     
       if ($rowt4['lamt4']>0)
       {
        $pr4=($rowt4['lamt4']/$rowt['lamt'])*100;
        $lamt4=number_format($pr4,2);
       } else {
        $lamt4="-";
       }

       $valCLA5="date(`Loan Date`) <'" . date('Y-m-d', strtotime('-181 day',strtotime(date('Y-m-d')))) . "'";

       $sqlt5="SELECT sum(`PBalance`) as lamt5 FROM `loan` where `Balance`>0 and $valCLA5";
       $resultt5 = mysqli_query($conn,$sqlt5) or die('Could not look up user data; ' . mysqli_error());
       $rowt5 = mysqli_fetch_array($resultt5);
     
       if ($rowt5['lamt5']>0)
       {
        $pr5=($rowt5['lamt5']/$rowt['lamt'])*100;
        $lamt5=number_format($pr5,2);
       } else {
        $lamt5="-";
       }
       $duedate=date('Y-m-d', strtotime('+' . $lduration . ' month',strtotime($ldate)));

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%"><a href="report.php?cmbReport=Risky Portfolio" title="View Details of all Loans">Current Loans </a></div>
        <div  class="cell" style="width:12.5%">' .$lnos. '</div>
        <div  class="cell" style="width:12.5%">' .$balance. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
      </div>';

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%"> < 31 Days </div>
        <div  class="cell" style="width:12.5%">' .$lnos1. '</div>
        <div  class="cell" style="width:12.5%">' .$balance1. '</div>
        <div  class="cell" style="width:12.5%">' .$balance1. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">' .$lamt1. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
      </div>';

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%"> 31-60 Days </div>
        <div  class="cell" style="width:12.5%">' .$lnos2. '</div>
        <div  class="cell" style="width:12.5%">' .$balance2. '</div>
        <div  class="cell" style="width:12.5%">' .$balance2. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">' .$lamt2. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
      </div>';

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%"> 61-90 Days </div>
        <div  class="cell" style="width:12.5%">' .$lnos3. '</div>
        <div  class="cell" style="width:12.5%">' .$balance3. '</div>
        <div  class="cell" style="width:12.5%">' .$balance3. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">' .$lamt3. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
      </div>';

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%"> 91-180 Days </div>
        <div  class="cell" style="width:12.5%">' .$lnos4. '</div>
        <div  class="cell" style="width:12.5%">' .$balance4. '</div>
        <div  class="cell" style="width:12.5%">' .$balance4. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">' .$lamt4. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
      </div>';

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%"> > 180 Days </div>
        <div  class="cell" style="width:12.5%">' .$lnos5. '</div>
        <div  class="cell" style="width:12.5%">' .$balance5. '</div>
        <div  class="cell" style="width:12.5%">' .$balance5. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">' .$lamt5. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
      </div>';
   }

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">TOTAL</div>
        <div  class="cell" style="width:12.5%">' .$lnos. '</div>
        <div  class="cell" style="width:12.5%">' .$balance. '</div>
        <div  class="cell" style="width:12.5%">' .$balance. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
      </div>';
?>
</div>
</fieldset>

<div>
<?php
echo "<a target='blank' href='rptriskportfolio.php'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='expriskportfolio.php?cmbFilter=$cmbFilter&filter=$filter'> Export this Report</a> &nbsp; ";
?>
</div>
</div>
