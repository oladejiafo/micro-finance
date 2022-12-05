<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 6))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}

 $loanid = $_POST["loanid"];
 $repay = $_POST["repay"];

 $id = $_POST["id"];
 $acctnum = $_POST["acctnum"];

 $amount = $_POST["amount"];
 $loantype = $_POST["loantype"];
 $loanduration = $_POST["loanduration"];
 $intrate = $_POST["intrate"];
 $officer = $_POST["officer"];

 $loanno = $_POST["loanno"];
 $date = $_POST["date"];
 $loanstatus = $_POST["loanstatus"];
 $paymenttype = $_POST["paymenttype"];
 $paymentfreq = $_POST["paymentfreq"];
 $payments = $_POST["payments"];
 $loangrade = $_POST["loangrade"];
 $repayment = $_POST["repayment"];
 $latecharges = $_POST["latecharges"];
 $purpose = $_POST["purpose"];
 $guarantor = $_POST["guarantor"];
 $guarantoroccupation = $_POST["guarantoroccupation"];
 $guarantorcontact = $_POST["guarantorcontact"];

 $monthlyprincipal = $_POST["monthlyprincipal"];
 $monthlyinterest = $_POST["monthlyinterest"];
 $totalinterest = $_POST["totalinterest"];
 $interesttodate = $_POST["interesttodate"];
 $ptodate = $_POST["ptodate"];
 $pbalance = $_POST["pbalance"];
 $todate = $_POST["todate"];
 $balance = $_POST["balance"];

 $collateral = $_POST["collateral"];
 $location = $_POST["location"];
 $value = $_POST["value"];
 $title = $_POST["title"];
 $description = $_POST["description"];

 $dailyrepay = $_POST["dailyrepay"];
 $dailyprincipal = $_POST["dailyprincipal"];
 $dailyinterest = $_POST["dailyinterest"];

 $loanacct = $_POST["loanacct"];
 $applicationfee = $_POST["applicationfee"];
 $processingfee = $_POST["processingfee"];
 $insurancefee = $_POST["insurancefee"];

 $rdate = $_POST['date'];
 list($day, $month, $year) = explode('-', $rdate);
 $date = $year . '-' . $month . '-' . $day;

 $due=date('Y-m-d', strtotime('+' . $loanduration . ' month',strtotime($date)));

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($acctnum) != "" and Trim($amount) != "")
      {
        $query_update = "UPDATE `loan` SET `Account Number`='$acctnum',`Loan Amount` = '$amount',`Loan Type` = '$loantype',`Loan Duration` = '$loanduration',`Interest Rate` = '$intrate',`Officer` = '$officer'
                         ,`Loan No` = '$loanno',`Loan Date` = '$date',`Due Date` = '$due',`Loan Status` = '$loanstatus',`Payment Type` = '$paymenttype',`Payment Frequency` = '$paymentfreq',`No of Payment` = '$payments',`Loan Grade` = '$loangrade'
                         ,`Monthly Principal`='$monthlyprincipal',`Periodic Repayment` = '$repayment',`Late Charge` = '$latecharge',`Purpose` = '$purpose',`Guarantor` = '$guarantor',`Monthly Interest` = '$monthlyinterest',`Total Interest` = '$totalinterest'
                         ,`Interest toDate` = '$interesttodate',`PPayment todate` = '$ptodate',`PBalance` = '$pbalance',`Payment todate` = '$todate',`Balance` = '$balance',`Collateral` = '$collateral',`Collateral Location` = '$location',`Guarantor Contact`='$guarantorcontact',`Guarantor Occupation`='$guarantoroccupation'
                         ,`Insurance Fee`='$insurancefee',`Processing Fee`='$processingfee',`Application Fee`='$applicationfee',`Loan Account`='$loanacct',`Collateral Value` = '$value',`Collateral Title` = '$title',`Collateral Description` = '$description',`Daily Interest`='$dailyinterest',`Daily Principal`='$dailyprincipal',`Daily Repay`='$dailyrepay' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $tval="Your record has been updated.";
        header("location:loans.php?acctno=$acctnum&view=1&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Basic details before updating.";
        header("location:loans.php?acctno=$acctnum&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Confirm':
      if (Trim($acctnum) != "" and Trim($amount) != "")
      {
        $query_update = "UPDATE `loan` SET `Account Number`='$acctnum',`Loan Amount` = '$amount',`Loan Type` = '$loantype',`Loan Duration` = '$loanduration',`Interest Rate` = '$intrate',`Officer` = '$officer'
                         ,`Loan No` = '$loanno',`Loan Date` = '$date',`Due Date` = '$due',`Loan Status` = 'Pending',`Payment Type` = '$paymenttype',`Payment Frequency` = '$paymentfreq',`No of Payment` = '$payments',`Loan Grade` = '$loangrade'
                         ,`Monthly Principal`='$monthlyprincipal',`Periodic Repayment` = '$repayment',`Late Charge` = '$latecharges',`Purpose` = '$purpose',`Guarantor` = '$guarantor',`Monthly Interest` = '$monthlyinterest',`Total Interest` = '$totalinterest'
                         ,`Interest toDate` = '$interesttodate',`PPayment todate` = '$ptodate',`PBalance` = '$pbalance',`Payment todate` = '$todate',`Balance` = '$balance',`Collateral` = '$collateral',`Collateral Location` = '$location',`Guarantor Contact`='$guarantorcontact',`Guarantor Occupation`='$guarantoroccupation'
                         ,`Approval`='Pending',`Insurance Fee`='$insurancefee',`Processing Fee`='$processingfee',`Application Fee`='$applicationfee',`Loan Account`='$loanacct',`Collateral Value` = '$value',`Collateral Title` = '$title',`Collateral Description` = '$description',`Daily Interest`='$dailyinterest',`Daily Principal`='$dailyprincipal',`Daily Repay`='$dailyrepay' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Expense','Other Short-term Clients Loans','$loantype to Customer $acctnum','$amount','$date','','$acctnum','','','Paid')";
         $result_ins = mysqli_query($conn,$query_ins);

if($applicationfee>0)
{
         $query_insX1 = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
               VALUES ('$applicationfee','Loan Application Fee','$date','Loan Application Fee','$acctnum','$officer','Income')";
         $result_insX1 = mysqli_query($conn,$query_insX1);
}
if($processingfee>0)
{
         $query_insX2 = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
               VALUES ('$processingfee','Loan Processing Fee','$date','Loan Processing Fee','$acctnum','$officer','Income')";
         $result_insX2 = mysqli_query($conn,$query_insX2);
}
if($insurancefee>0)
{
         $query_insX3 = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
               VALUES ('$insurancefee','Loan Insurance Fee','$date','Loan Insurance Fee','$acctnum','$officer','Income')";
         $result_insX3 = mysqli_query($conn,$query_insX3);
}

        $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctnum' order by `ID` desc";
        $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysql_error());
        $rowb = mysqli_fetch_array($resultb); 

        $balance= $rowb['Balance']; 
         $bal=$balance-$amount;
         $query_insert = "Insert into `transactions` (`Account Number`,`Deposit`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctnum','$amount','Loan Auto Transaction','','$officer','$date','Withdrawal','Loan Disbursement','$bal')";
         $result_insert = mysqli_query($conn,$query_insert);

/* AS WAS BEFORE
        $balance= $rowb['Balance']; 
         $bal=$balance+$amount;
         $query_insert = "Insert into `transactions` (`Account Number`,`Deposit`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctnum','$amount','HQ Auto Transaction','','$officer','$date','Deposit','Loan Disbursement','$bal')";
         $result_insert = mysqli_query($conn,$query_insert);
*/
        $tval="Your record has been updated.";
        header("location:loans.php?acctno=$acctnum&view=1&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Basic details before updating.";
        header("location:loans.php?acctno=$acctnum&confirm=1&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Add':
      if (Trim($acctnum) != "" and Trim($amount) != "")
      { 
        $qry_rate="Select `Rate`,`Late Rate` from `loan type` where `Type`='$loantype'";
        $result_rate = mysqli_query($conn,$qry_rate);
        $row_rate=mysqli_fetch_array($result_rate);
        $irate=$row_rate['Rate'];
        $lrate=$row_rate['Late Rate'];

        if ($paymentfreq=='Monthly')
        {
         $paym=$loanduration/1;
        }
        else if ($paymentfreq=='Quarterly')
        {
         $paym=$loanduration/3;
        }
        else if ($paymentfreq=='Yearly')
        {
         $paym=$loanduration/12;
        }

        if ($paymenttype=='Simple Interest')
        { 
         $intr=$amount*($irate/100);
if($loanduration>0)
{
         $mintr=$amount*($irate/100)/$loanduration;
} else {
         $mintr=0;
}
         $totintr=$intr;
        }
	else if ($paymenttype=='Flat Rate')
        { 
         $intr=$amount*($irate/100);
         $mintr=$amount*($irate/100);
         $totintr=$intr*$loanduration;
        } else if ($paymenttype=='Daily Simple Interest') { 
         $intr=$amount*($irate/100);
if($loanduration>0)
{
         $mintr=$amount*($irate/100)/$loanduration;
} else {
         $mintr=0;
}
if($loanduration>0)
{
         $dintr=$amount*($irate/100)/($loanduration*25);
         $dpay=($amount/($loanduration*25))+(($amount*($irate/100))/($loanduration*25));
         $dprinc=($amount/($loanduration*25));
         #$totintr=$amount*(($irate/100)/12)*$loanduration;
} else {
         $dintr=0;
         $dpay=0;
         $dprinc=0;
}
        } else if ($paymenttype=='Compound Interest') { 
         $aa=$amount*(1+$irate/100);
if($loanduration>0)
{
         $mintr=$aa/$loanduration;
} else {
         $mintr=0;
}
         $totintr=$aa;
        } else if ($paymenttype=='Reducing Balance') { 
         ###### Fetch Balance ######
        $qry_b="Select `Balance` from `loan` where `Account Number`='$acctnum' order by `ID` desc";
        $result_b = mysqli_query($conn,$qry_b);
        $row_b=mysqli_fetch_array($result_b);
        $bal=$row_rate['Balance'];

         if(empty($bal) or $bal==0)
         { $bal=$amount; }
         $mintr=$bal*($irate/100);

        /* $aa=$amount*(1+$irate/100);
         $mintr=$amount*$aa;
         $totintr=$mintr*$loanduration; */
        }

if($paym>0)
{
        $repay=($amount/$paym)+$mintr;
        $monthpay=($amount/$paym);
} else {
        $repay=($amount/1)+$mintr;
        $monthpay=($amount/1);
}
        $tbal=$amount+$totintr;

        $query_insert = "Insert into `loan` (`Account Number`,`Loan Amount`,`Loan Type`,`Loan Duration`,`Officer`,`Periodic Repayment`
                         ,`Loan No`,`Loan Date`,`Due Date`,`Payment Type`,`Payment Frequency`,`Loan Grade`,`Interest Rate`,`Interest toDate`,`PPayment todate`,`Payment todate`
                         ,`Purpose`,`Guarantor`,`Collateral`,`Collateral Location`,`No of Payment`,`PBalance`,`Balance`,`Daily Interest`,`Daily Principal`,`Daily Repay`
                         ,`Insurance Fee`, `Processing Fee`, `Application Fee`,`Loan Account`,`Collateral Value`,`Collateral Title`,`Collateral Description`,`Late Charge`,`Total Interest`,`Monthly Interest`,`Monthly Principal`,`Guarantor Contact`,`Guarantor Occupation`) 
               VALUES ('$acctnum','$amount','$loantype','$loanduration','$officer','$repay'
                         ,'$loanno','$date','$due','$paymenttype','$paymentfreq','$loangrade','$irate',0,0,0
                         ,'$purpose','$guarantor','$collateral','$location','$paym','$amount','$tbal','$dintr','$dprinc','$dpay'
                         ,'$insurancefee', '$processingfee', '$applicationfee','$loanacct','$value','$title','$description', '$lrate','$totintr','$mintr','$monthpay','$guarantorcontact','$guarantoroccupation')";
        $result_insert = mysqli_query($conn,$query_insert);

         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Expense','Other Short-term Clients Loans','$loantype to Customer $acctnum','$amount','$date','','$acctnum','','','Paid')";
         $result_ins = mysqli_query($conn,$query_ins);

if($applicationfee>0)
{
         $query_insX1 = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
               VALUES ('$applicationfee','Loan Application Fee','$date','Loan Application Fee','$acctnum','$officer','Income')";
         $result_insX1 = mysqli_query($conn,$query_insX1);
}
if($processingfee>0)
{
         $query_insX2 = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
               VALUES ('$processingfee','Loan Processing Fee','$date','Loan Processing Fee','$acctnum','$officer','Income')";
         $result_insX2 = mysqli_query($conn,$query_insX2);
}
if($insurancefee>0)
{
         $query_insX3 = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
               VALUES ('$insurancefee','Loan Insurance Fee','$date','Loan Insurance Fee','$acctnum','$officer','Income')";
         $result_insX3 = mysqli_query($conn,$query_insX3);
}

        $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctnum' order by `ID` desc";
        $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysql_error());
        $rowb = mysqli_fetch_array($resultb); 

        $balance= $rowb['Balance']; 
         $bal=$balance-$amount;
         $query_insert = "Insert into `transactions` (`Account Number`,`Deposit`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctnum','$amount','Loan Auto Transaction','','$officer','$date','Withdrawal','Loan Disbursement','$bal')";
         $result_insert = mysqli_query($conn,$query_insert);

#######
$qry_sig="Select `ID` from `customer` where `Account Number`='$acctnum'";
$result_sig = mysqli_query($conn,$qry_sig);
$row_sig=mysqli_fetch_array($result_sig);
$cid=$row_sig['ID'];

if (!empty($_FILES['sign_filename']['name'])){
if (file_exists("images/sign/gr_" . $cid . ".jpg")==1)
{
   $signNam = "images/sign/gr_" . $cid . ".jpg";
   $newsignnam = "images/sign/gr_" . date("Y-m-d") . "_" . $cid . ".jpg";
   rename($signNam, $newsignnam);
}
   //make variables available
   $sign_userid = $cid;
   $sign_tempname = $_FILES['sign_filename']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir ="images/sign/gr_";
   $signName = $signDir . $sign_tempname;
   if (move_uploaded_file($_FILES['sign_filename']['tmp_name'],$signName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName);
 
    $ext = ".jpg";

    $newsignname = $signDir . $cid . $ext;
    rename($signName, $newsignname);

}}
###### 

        $tval="Your record has been Saved.";
        header("location:loans.php?acctno=$acctnum&confirm=1&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Basic details before saving.";
        header("location:loans.php?tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `loan` WHERE `ID` = '$id'";
       $result_delete = mysqli_query($conn,$query_delete);          

        $tval="Your record has been deleted.";
        header("location:loans.php?tval=$tval&redirect=$redirect");
      }
      break;   

     case 'Update Payment':
      if (Trim($date) != "" and Trim($repay) != "")
      {
        $qry2="Select `Amount` from `loan payment` where `Account Number`='$acctnum' and `ID`='$id' ";
        $resl2 = mysqli_query($conn,$qry2);
        $rowe2=mysqli_fetch_array($resl2);
        $pt2=$rowe2['Amount'];

        $qry_insert2 = "update `loan` set `Payment todate`=(`Payment todate`-'$pt2'),`Balance`=(`Balance`+'$pt2') where `Account Number`='$acctnum' and `ID`='$loanid'";
        $res_insert2 = mysqli_query($conn,$qry_insert2);

        $qry="Select `PBalance`,`Payment todate`,`Balance`,`Interest toDate`,`PPayment todate`,`Monthly Interest` from `loan` where `Account Number`='$acctnum' and `ID`='$loanid'";
        $resl = mysqli_query($conn,$qry);
        $rowe=mysqli_fetch_array($resl);
        $ptd=$rowe['Payment todate'];
        $bl=$rowe['Balance'];
        $itd=$rowe['Interest toDate'];
        $prtd=$rowe['PPayment todate'];
        $mi=$rowe['Monthly Interest'];
        $pbal=$rowe['PBalance'];

        $paytd=$repay+$ptd;
        $balf=$bl-$repay;
        $prtdf=$prtd+($repay-$mi);
        $itdf=$itd+($mi);
        $pbl=$pbal-$ptd;

        $query_update = "UPDATE `loan payment` SET `Account Number`='$acctnum',`Loan ID` = '$loanid',`Date` = '$date',`Amount` = '$repay' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $qry_insert = "update `loan` set `PBalance`='$pbl',`Payment todate`='$paytd',`Balance`='$balf',`Interest toDate`='$itdf',`PPayment todate`='$prtdf' where `Account Number`='$acctnum' and `ID`='$loanid'";
        $res_insert = mysqli_query($conn,$qry_insert);

        $tval="Your record has been updated.";
        header("location:loans.php?acctno=$acctnum&view=1&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Basic details before updating.";
        header("location:loanpay.php?acct=$acctnum&loanidd=$loanid&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save Payment':
      if (Trim($date) != "" and Trim($repay) != "")
      { 
        $qry="Select `PBalance`,`Payment todate`,`Balance`,`Interest toDate`,`PPayment todate`,`Monthly Interest`,`Periodic Repayment` from `loan` where `Account Number`='$acctnum' and `ID`='$loanid'";
      # $qry="Select `Payment todate`,`Balance`,`Interest toDate`,`PPayment todate`,`Monthly Interest` from `loan` where `Account Number`='$acctnum' and `ID`='$loanid'";
        $resl = mysqli_query($conn,$qry);
        $rowe=mysqli_fetch_array($resl);
        $ptd=$rowe['Payment todate'];
        $bl=$rowe['Balance'];
        $itd=$rowe['Interest toDate'];
        $prtd=$rowe['PPayment todate'];
        $mi=$rowe['Monthly Interest'];
        $repay=$rowe['Periodic Repayment'];
        $pbal=$rowe['PBalance'];

        $paytd=$repay+$ptd;
        $balf=$bl-$repay;
        $prtdf=$prtd+($repay-$mi);
        #$itdf=$itd+($repay-$prtd);
        $itdf=$itd+($mi);
        $pbl=$pbal-$ptd;

        $query_insert = "Insert into `loan payment` (`Account Number`,`Loan ID`,`Date`,`Amount`) 
                                             VALUES ('$acctnum','$loanid','$date','$repay')";
        $result_insert = mysqli_query($conn,$query_insert);

        $qry_insert = "update `loan` set `Payment todate`='$paytd',`Balance`='$balf',`Interest toDate`='$itdf',`PPayment todate`='$prtdf' where `Account Number`='$acctnum' and `ID`='$loanid'";
        $res_insert = mysqli_query($conn,$qry_insert);

         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Income','Loan Collection Expenses','Periodic payback on loan for $acctnum','$repay','$date','','$acctnum','','','')";
         $result_ins = mysqli_query($conn,$query_ins);

        $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctnum' order by `ID` desc";
        $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysql_error());
        $rowb = mysqli_fetch_array($resultb); 

        $balance= $rowb['Balance']; 
        $bal=$balance-$repay;
        $query_trans = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctnum','$repay','Loan Auto Deduction','Auto','Auto','" . date('Y-m-d') . "','Withdrawal','Monthly Loan Deduction','$bal')";
        $result_trans = mysqli_query($conn,$query_trans);


        $tval="Your record has been updated.";
        header("location:loans.php?acctno=$acctnum&view=1&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Basic details before saving.";
        header("location:loanpay.php?acct=$acctnum&loanidd=$loanid&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete Payment':
      {
       $query_delete = "DELETE FROM `loan payment` WHERE `ID` = '$id'";
       $result_delete = mysqli_query($conn,$query_delete);          

        $tval="Your record has been deleted.";
        header("location:loans.php?acctno=$acctnum&view=1&tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>