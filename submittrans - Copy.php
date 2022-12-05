<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 3))
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

 $id = $_POST["id"];
 $fname = $_POST["fname"];
 $sname = $_POST["sname"];
 $acctno = $_POST["acctno"];
 $trans = $_POST["trans"];
 $type = $_POST["type"];
 $gender = $_POST["gender"];
 $status = $_POST["status"];
 $acctofficer = $_POST["acctofficer"];
 $officer = $_POST["officer"];
 $date = $_POST["date"];
 $transtype = $_POST["transtype"];
 $amount = $_POST["amount"];
 $remark = $_POST["remark"];
 $transactor = $_POST["transactor"];
 $tcontact = $_POST["tcontact"];
 $balance = $_POST["balance"];

 $initamt = $_POST["initamt"];

if ($_POST['date'] !='0000-00-00' and $_POST['date'] !='')
{
  $rsdate = $_POST['date'];
  list($dayy, $monthh, $yearr) = explode('-', $rsdate);
  $date = $yearr . '-' . $monthh . '-' . $dayy;
}


##########################################
function strleft($leftstring, $length) {
  return(substr($leftstring, 0, $length));
}
 
function strright($rightstring, $length) {
  return(substr($rightstring, -$length));
}
$myacct = $acctno;
 
$lacct= strleft($myacct,3);  //result "John M" 
 
$racct= strright($myacct,4); //result "Miller"

$dacct=$lacct . "***" . $racct;
##########################################
 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Modify':

      if (Trim($acctno) != "" && Trim($amount) != "" && Trim($transtype) != "")
      {
        if ($transtype=='Deposit')
        {
         $bal=$balance-$initamt+$amount;
         $query_update = "UPDATE `transactions` SET `Account Number` = '$acctno',`Deposit`='$amount',`Transactor`='$transactor',`Transactor Contact`='$tcontact',
          `Officer`='$officer',`Date`='$date',`Transaction Type`='$transtype',`Remark`='$remark',`Balance`='$bal' WHERE `ID` = '$id'";
        $result_update = mysql_query($query_update);
        } else {
         $bal=$balance+$initamt-$amount;

         $query_ch = "SELECT `Margin`,`Margin Type`,`Effect` FROM `account type` Where `Type`='" . $type ."'";
         $result_ch = mysql_query($query_ch,$conn);
         $rowch = mysql_fetch_array($result_ch);
         $margin=$rowch['Margin'];
         $margintype=$rowch['Margin Type'];
         $effect=$rowch['Effect'];
   
         if(!empty($margin) and $margin !=0)
         {
            $query_delins = "delete from `transactions` where `Account Number`='$acctno' and `Date`='$date' and `Transaction Type`='$margintype'"; 
            $result_delins = mysql_query($query_delins);

            $query_delchs = "delete from `cash` where `Type`='Income' and `Classification`='Charges' and `Date`='$date' and `Particulars`='$margintype' and `Remark`='$acctno'"; 
            $result_delchs = mysql_query($query_delchs);            
##################################################
            $amt=($amount *$margin)/100;

            $balt=$bal-$amt;
            $query_ins = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$amt','','','','$date','$margintype','','$balt')";
            $result_ins = mysql_query($query_ins);

            $query_chs = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Charges','$date','$margintype','$amt','$acctno')";
            $result_chs = mysql_query($query_chs);
         }

         $query_update = "UPDATE `transactions` SET `Account Number` = '$acctno',`Withdrawal`='$amount',`Transactor`='$transactor',`Transactor Contact`='$tcontact',
          `Officer`='$officer',`Date`='$date',`Transaction Type`='$transtype',`Remark`='$remark',`Balance`='$bal' WHERE `ID` = '$id'";
        $result_update = mysql_query($query_update);
        }


            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_update_Log = "Insert into `Monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Transactions Record','Modified Transactions Record for Customer: " . $acctno . ", " . $amount . ", " . $transtype . "')";
            $result_update_Log = mysql_query($query_update_Log);
            ###### 

        $tval="Your record has been updated.";
        header("location:transactions.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter all details before updating.";
        header("location:transactions.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($acctno) != "" && Trim($amount) != "" && Trim($transtype) != "")
      { 

        if ($transtype=='Deposit')
        {   
         $bal=$balance+$amount;
         $query_insert = "Insert into `transactions` (`Account Number`,`Deposit`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctno','$amount','$transactor','$tcontact','$officer','$date','$transtype','$remark','$bal')";
         $result_insert = mysql_query($query_insert);

         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Income','Customers Deposit','Customers Deposit for $acctno','$amount','$date','$transtype','$acctno','','','')";
         $result_ins = mysql_query($query_ins);

        } else {
         if($amount>$balance)
         {
          $tval="You cannot withdraw more than the amount you have as balance!";
          header("location:transactions.php?id=$id&acctno=$acctno&transtype=$transtype&tval=$tval&redirect=$redirect");
          break;
         } else {
         $bal=$balance-$amount;
         $query_insert = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctno','$amount','$transactor','$tcontact','$officer','$date','$transtype','$remark','$bal')";
         $result_insert = mysql_query($query_insert);

         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Expense','Accounts Payable','Customers cash withdrawal for $acctno','$amount','$date','$transtype','$acctno','','','')";
         $result_ins = mysql_query($query_ins);

         $query_ch = "SELECT `Margin`,`Margin Type`,`Effect` FROM `account type` Where `Type`='" . $type ."'";
         $result_ch = mysql_query($query_ch,$conn);
         $rowch = mysql_fetch_array($result_ch);
         $margin=$rowch['Margin'];
         $margintype=$rowch['Margin Type'];
         $effect=$rowch['Effect'];
   
         if(!empty($margin) and $margin !=0)
         {
            $amt=($amount *$margin)/100;
            $balt=$bal-$amt;
            $query_ins = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$amt','','','','$date','$margintype','','$balt')";
            $result_ins = mysql_query($query_ins);

            $query_chs = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Other Charges','$date','$margintype','$amt','$acctno')";
            $result_chs = mysql_query($query_chs);
         }

         if($transtype =='Normal Susu')
         {
            $dtt=(1 * $amount/30);
            $batt=$bal-$dtt;
            $query_ins = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$dtt','','','','$date','Charges','','$batt')";
            $result_ins = mysql_query($query_ins);

            $query_chs = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Other Charges','$date','Charges on Normal Susu','$dtt','$acctno')";
            $result_chs = mysql_query($query_chs);
         }
         }
        }

        if ($transtype=='Withdrawal')
        {   
         if($amount>$balance)
         {

         } else {

            $sqlz = "SELECT `ID` FROM `transactions` Where `Account Number`='$acctno' and `Date`='$date'";
            $rezult = mysql_query($sqlz,$conn);
            $rowz = mysql_fetch_array($rezult);
            $idz=$rowz['ID'];

            $query_upd = "UPDATE `currency detail` SET `TransID`='$idz' WHERE `Account No` = '$acctno' and `Date`='$date'";
            $result_upd = mysql_query($query_upd);
         }
        } else if ($transtype=='Deposit') {
            $sqlz = "SELECT `ID` FROM `transactions` Where `Account Number`='$acctno' and `Date`='$date'";
            $rezult = mysql_query($sqlz,$conn);
            $rowz = mysql_fetch_array($rezult);
            $idz=$rowz['ID'];

            $query_upd = "UPDATE `currency detail` SET `TransID`='$idz' WHERE `Account No` = '$acctno' and `Date`='$date'";
            $result_upd = mysql_query($query_upd);
        }
            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Transactions Record','Added Transactions Record for Customer: " . $acctno . ", " . $amount . ", " . $transtype . "')";
            $result_insert_Log = mysql_query($query_insert_Log);
            ###### 

###########################################################################################
$sqlc="SELECT `Company Name` FROM `company info`";
$resultc = mysql_query($sqlc,$conn) or die('Could not look up user data; ' . mysql_error());
$rowc = mysql_fetch_array($resultc);
$coy=$rowc['Company Name'];

$sql="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);
$sms=$row['SMS'];
$emailalert=$row['email alert'];
$email=$row['email'];
$phon=$row['Contact Number'];
$fname=$row['First Name'];
$sname=$row['Surname'];

$name= $fname . " " . $sname;

if($transactor)
{
  $byy=$transactor;
}  
else if($agent)
{
  $byy=$agent;
}

###
if (!$sock=@fsockopen('www.google.com',80,$num,$error,5))
{ 
 $ttval="No Internet Connection";
} else {
######email alert#######

if ($emailalert==1)
{
 if (Trim($email) != "")
 { 
  if ($transtype=='Deposit')
  {
   $trax="credited"; 
  } else {
   $trax="debited"; 
  }
  if($remark=="" or empty($remark))
  {
   $remark="***";
  }

  $subjectZ = $coy . ' ALERT';
  $fromZ ="From: " . $coy . "\r\n";
  $bodyZ ="ALERT: " . $name . ", Your account " . $dacct . " has been " . $trax . " with N" . $amount . ". Descr: By " . $byy . ", for " . $remark . ". Your account balance is N" . $bal . ". Date: " . $date . "\n";
  $toZ=$email;
  mail($toZ,$subjectZ,$bodyZ,$fromZ);
   
 }
}
#####end email alert######

### sms alert ###
if ($sms==1)
{

if ($transtype=='Deposit')
{
 $trax="credited"; 
} else {
 $trax="debited"; 
}
if($remark=="" or empty($remark))
{
 $remark="***";
}

$request = new HttpRequest();
$request->setUrl('https://api.infobip.com/sms/1/text/single');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'accept' => 'application/json',
  'content-type' => 'application/json',
  'authorization' => 'Basic Q3VzaGl0ZTpXaXNkb20hMjAxNQ=='
));

$request->setBody('{
   "from":"' . $coy . '",
   "to":"' . $phon . '",
   "text":"ALERT: ' . $name . ', Your account ' . $dacct . ' has been ' . $trax . ' with N' . $amount . '. Descr: By ' . $byy . ', for ' . $remark . '. Your account balance is N' . $bal . '. Date: ' . $date . '"
}');

try {
  $response = $request->send();
  
  #echo $response->getBody();
} catch (HttpException $ex) {
  #echo $ex;
}

##########################
$sqlX="SELECT `SMS Rate` FROM `sms tarrif`";
$resultX = mysql_query($sqlX,$conn) or die('Could not look up user data; ' . mysql_error());
$rowX = mysql_fetch_array($resultX);
$smsamt=$rowX['SMS Rate'];

if ($transtype=='Deposit')
{   
 $balX=($balance+$amount)-$smsamt;
} else if ($transtype=='Withdrawal') {   
 $balX=($balance-$amount)-$smsamt;
}
 $query_insx = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$smsamt','Auto Billing','','','$date','SMS Charges','SMS Charges','$balX')";
 $result_insx = mysql_query($query_insx);

 $query_chas = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Other Charges','$date','SMS Alert Charges','$smsamt','$acctno')";
 $result_chas = mysql_query($query_chas);
#############################

}
### end Sms alert ###
}
###
###########################################################################################

        $tval="Your record has been saved. " . $ttval;
        header("location:transactions.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter all details before saving.";
        header("location:transactions.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {

        if ($transtype=='Deposit')
        {
         $bal=$balance-$initamt;
         $query_update = "UPDATE `transactions` SET `Account Number` = '$acctno',`Deposit`='$amount',`Transactor`='$transactor',`Transactor Contact`='$tcontact',
          `Officer`='$officer',`Date`='$date',`Transaction Type`='$transtype',`Remark`='$remark',`Balance`='$bal' WHERE `ID` = '$id'";
        $result_update = mysql_query($query_update);
        } else {
         $bal=$balance+$initamt;
         $query_update = "UPDATE `transactions` SET `Account Number` = '$acctno',`Deposit`='$amount',`Transactor`='$transactor',`Transactor Contact`='$tcontact',
          `Officer`='$officer',`Date`='$date',`Transaction Type`='$transtype',`Remark`='$remark',`Balance`='$bal' WHERE `ID` = '$id'";
        $result_update = mysql_query($query_update);
        }

       $query_delete = "DELETE FROM `transactions` WHERE `ID` = '$id';";
       $result_delete = mysql_query($query_delete);          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Transactions Record','Deleted Transactions Record for Customer: " . $acctno . ", " . $amount . ", " . $transtype . "')";
            $result_delete_Log = mysql_query($query_delete_Log);
            ###### 

        $tval="Your record has been deleted.";
        header("location:transactions.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      break;     
     case 'Cancel':
      {
        header("location:transactions.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      break;     
   }
 }
?>