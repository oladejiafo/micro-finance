<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 6))
{
 $redirect = $_SERVER['PHP_SELF'];
 header("Refresh: 1; URL=index.php?redirect=$redirect");
}

 $loanidd = $_REQUEST["loanidd"];
 $acct = $_REQUEST["acct"];

 require_once 'conn.php';
 
      if (Trim($acct) != "" and Trim($loanidd) != "")
      { 
        $qry="Select `PBalance`,`Payment todate`,`Balance`,`Interest toDate`,`PPayment todate`,`Monthly Interest`,`Periodic Repayment` from `loan` where `Account Number`='$acct' and `ID`='$loanidd'";
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
        $itdf=$itd+($mi);
        $pbl=$pbal-$ptd;

        $query_insert = "Insert into `loan payment` (`Account Number`,`Loan ID`,`Date`,`Amount`) 
                                             VALUES ('$acct','$loanidd','" . date('Y-m-d') . "','$repay')";
        $result_insert = mysqli_query($conn,$query_insert);

        $qry_insert = "update `loan` set `PBalance`='$pbl',`Payment todate`='$paytd',`Balance`='$balf',`Interest toDate`='$itdf',`PPayment todate`='$prtdf' where `Account Number`='$acct' and `ID`='$loanidd'";
        $res_insert = mysqli_query($conn,$qry_insert);

        $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Income','Loan Collection Expenses','Loan Repayment by Customer $acct','$repay','" . date('Y-m-d') . "','','$acct','','','Paid')";
        $result_ins = mysqli_query($conn,$query_ins);

        $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acct' order by `ID` desc";
        $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysqli_error());
        $rowb = mysqli_fetch_array($resultb); 

        $balance= $rowb['Balance']; 
        $bal=$balance-$repay;
        $query_trans = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acct','$repay','Loan Auto Deduction','Auto','Auto','" . date('Y-m-d') . "','Withdrawal','Monthly Loan Deduction','$bal')";
        $result_trans = mysqli_query($conn,$query_trans);

        $tval="Your Payment Made and Customer Account Debitted.";
        header("location:loans.php?acctno=$acct&view=1&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Oppss! Something is wrong, no update done, please do manually!.";
        header("location:loans.php?acctno=$acct&view=1&tval=$tval&redirect=$redirect");
      }
?>