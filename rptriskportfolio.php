<?php
session_start();
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
$addy=$rw['Address'];
$phn=$rw['Phone'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];
?>
<table width='650'>
<tr><td rowspan='5' valign='top'>
<img src='images/logo.jpg' width='120' height='140'></td></tr>
<tr><td width='460'><font style='font-size: 14pt'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='460'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='460'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td colspan=1 width='460'><h2><left>RISKY PORTFOLIO REPORT</left></h2></td></tr>
</table>
<div align="left">

<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#ccCCcc" id="table2">
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

   echo "<TR bgcolor='#C0C0C0'><TH><b> Days in Arrears</b></TH><TH><b> Number of Loans</b></TH><TH><b> Outstanding Balances<br>of Loans</b></TH><TH><b> Amount in Arrears </b></TH><TH><b> Arrears Rate</b></TH><TH><b> Portfolio <br>At Risk</b></TH><TH><b> Reserve Rate</b></TH><TH><b> Reserve Amount</b></TH></TR>";

#   $result = mysqli_query ($conn,"SELECT `ID`,`Account Number`, `Loan Amount`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Total Interest` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' LIMIT $limitvalue, $limit"); 
 

   $samtt=0;
   $sptdt=0;
   $sbalt=0;
   $samt01=0;
   $samt02=0;
   $samt03=0;
   $samt04=0;
   $samt05=0;
   $stint=0;
#   while(list($id,$acctno,$lamount,$ldate,$lduration,$ptd,$bal,$int)=mysqli_fetch_row($result)) 
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

       echo "<TR align='left'><TH>Current Loans </TH><TH align='center'>$lnos </TH><TH align='right'>$balance</TH><TH align='right'></TH><TH> </TH><TH> </TH><TH align='right'> </TH><TH align='right'> </TH></TR>";
       echo "<TR align='left'><TH> < 31 Days </TH><TH align='center'>$lnos1 </TH><TH align='right'>$balance1</TH><TH align='right'>$balance1</TH><TH> </TH><TH align='right'>$lamt1</TH><TH align='right'> </TH><TH align='right'> </TH></TR>";
       echo "<TR align='left'><TH>31-60 Days </TH><TH align='center'>$lnos2</TH><TH align='right'>$balance2</TH><TH align='right'>$balance2</TH><TH> </TH><TH align='right'>$lamt2</TH><TH align='right'> </TH><TH align='right'> </TH></TR>";
       echo "<TR align='left'><TH>61-90 Days </TH><TH align='center'>$lnos3</TH><TH align='right'>$balance3</TH><TH align='right'>$balance3</TH><TH> </TH><TH align='right'>$lamt3</TH><TH align='right'> </TH><TH align='right'> </TH></TR>";
       echo "<TR align='left'><TH>91-180 Days </TH><TH align='center'>$lnos4</TH><TH align='right'>$balance4</TH><TH align='right'>$balance4</TH><TH> </TH><TH align='right'>$lamt4</TH><TH align='right'> </TH><TH align='right'> </TH></TR>";
       echo "<TR align='left'><TH>>180 Days </TH><TH align='center'>$lnos5 </TH><TH align='right'>$balance5</TH><TH align='right'>$balance5</TH><TH> </TH><TH align='right'>$lamt5</TH><TH align='right'> </TH><TH align='right'> </TH></TR>";

   }
   echo "<TR><TH colspan='8'></TH></TR>";

   echo "<TR align='left' bgcolor='#C0C0C0'><TH height='35'>TOTAL</TH><TH align='center'>$lnos</TH><TH align='right'>$balance</TH><TH align='right'>$balance</TH><TH> </TH><TH> </TH><TH align='right'> </TH><TH align='right'> </TH></TR>";

?>
</table>
</fieldset>
</td></tr>
	</table>


</div>

