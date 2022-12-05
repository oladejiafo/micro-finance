<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5))
{
  $redirect = $_SERVER['PHP_SELF'];
  header("Refresh: 0; URL=index.php?redirect=$redirect");
}

 $loanid = $_REQUEST["loanid"];
 $acctnum = $_REQUEST["acctnum"];

 require_once 'conn.php';
 
if($acctnum !="")
{
$query_update = "UPDATE `loan` SET `Approval`='Approved',`Loan Status`='Active' WHERE `ID` =" .$loanid. " and `Account Number`='" .$acctnum. "'";
$result_update = mysqli_query($conn,$query_update);

/*
         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Expense','Other Short-term Clients Loans','$loantype to Customer $acctnum','$amount','$date','','$acctnum','','','Paid')";
         $result_ins = mysqli_query($conn,$query_ins);

if($applicationfee>0)
{
         $query_insX1 = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Income','Income','Loan Application Fee','$applicationfee','$date','','$acctnum','','','Paid')";
         $result_insX1 = mysqli_query($conn,$query_insX1);
}
if($processingfee>0)
{
         $query_insX2 = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Income','Income','Loan Processing Fee','$processingfee','$date','','$acctnum','','','Paid')";
         $result_insX2 = mysqli_query($conn,$query_insX2);
}
if($insurancefee>0)
{
         $query_insX3 = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Income','Income','Loan Insurance Fee','$insurancefee','$date','','$acctnum','','','Paid')";
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
*/

        $tval="Your record has been updated.";
        header("location:loansappr.php?redirect=$redirect");
} else {
        $tval="Please enter Basic details before updating.";
        header("location:loansappr.php?redirect=$redirect");
}
?>