<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 6) & ($_SESSION['access_lvl'] != 7))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}
}

 $id = $_POST["id"];
 $fname = $_POST["fname"];
 $sname = $_POST["sname"];
 $acctno = $_POST["acctnum"];
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
        $result_update = mysqli_query($conn,$query_update);
        } else {
         $bal=$balance+$initamt-$amount;

         $query_ch = "SELECT `Margin`,`Margin Type`,`Effect` FROM `account type` Where `Type`='" . $type ."'";
         $result_ch = mysqli_query($conn,$query_ch);
         $rowch = mysqli_fetch_array($result_ch);
         $margin=$rowch['Margin'];
         $margintype=$rowch['Margin Type'];
         $effect=$rowch['Effect'];
   
         if(!empty($margin) and $margin !=0)
         {
            $query_delins = "delete from `transactions` where `Account Number`='$acctno' and `Date`='$date' and `Transaction Type`='$margintype'"; 
            $result_delins = mysqli_query($conn,$query_delins);

            $query_delchs = "delete from `cash` where `Type`='Income' and `Classification`='Charges' and `Date`='$date' and `Particulars`='$margintype' and `Remark`='$acctno'"; 
            $result_delchs = mysqli_query($conn,$query_delchs);            
##################################################
            $amt=($amount *$margin)/100;

            $balt=$bal-$amt;
            $query_ins = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$amt','','','','$date','$margintype','','$balt')";
            $result_ins = mysqli_query($conn,$query_ins);

            $query_chs = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Charges','$date','$margintype','$amt','$acctno')";
            $result_chs = mysqli_query($conn,$query_chs);
         }

         $query_update = "UPDATE `transactions` SET `Account Number` = '$acctno',`Withdrawal`='$amount',`Transactor`='$transactor',`Transactor Contact`='$tcontact',
          `Officer`='$officer',`Date`='$date',`Transaction Type`='$transtype',`Remark`='$remark',`Balance`='$bal' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);
        }


            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Transactions Record','Modified Transactions Record for Customer: " . $acctno . ", " . $amount . ", " . $transtype . "')";
            $result_update_Log = mysqli_query($conn,$query_update_Log);
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
         $query_con = "SELECT `Account Number` FROM `transactions` Where `Transaction Type`='" . $transtype ."' and `Account Number`='" . $acctno ."' and `Date`='" . $date ."' and (`Deposit`=" . $amount ." OR `Withdrawal`=" . $amount .")";
         $result_con = mysqli_query($conn,$query_con);
         $totalcon  = mysqli_num_rows($result_con);
        if($totalcon>0)
       {
         $tval="This Transaction Looks Like A Repeat, Confirm Please.";
         header("location:transactions.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
        } else {
        if ($transtype=='Deposit')
        {   
         $bal=$balance+$amount;
         $query_insert = "Insert into `transactions` (`Account Number`,`Deposit`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctno','$amount','$transactor','$tcontact','$officer','$date','$transtype','$remark','$bal')";
         $result_insert = mysqli_query($conn,$query_insert);

         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Income','Customers Deposit','Customers Deposit for $acctno','$amount','$date','$transtype','$acctno','','','')";
         $result_ins = mysqli_query($conn,$query_ins);

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
         $result_insert = mysqli_query($conn,$query_insert);

         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Expense','Accounts Payable','Customers cash withdrawal for $acctno','$amount','$date','$transtype','$acctno','','','')";
         $result_ins = mysqli_query($conn,$query_ins);

         $query_ch = "SELECT `Margin`,`Margin Type`,`Effect` FROM `account type` Where `Type`='" . $type ."'";
         $result_ch = mysqli_query($conn,$query_ch);
         $rowch = mysqli_fetch_array($result_ch);
         $margin=$rowch['Margin'];
         $margintype=$rowch['Margin Type'];
         $effect=$rowch['Effect'];
   
         if(!empty($margin) and $margin !=0)
         {
            $amt=($amount *$margin)/100;
            $balt=$bal-$amt;
            $query_ins = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$amt','','','','$date','$margintype','','$balt')";
            $result_ins = mysqli_query($conn,$query_ins);

            $query_chs = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Other Charges','$date','$margintype','$amt','$acctno')";
            $result_chs = mysqli_query($conn,$query_chs);
         }

         if($transtype =='Normal Susu')
         {
            $dtt=(1 * $amount/30);
            $batt=$bal-$dtt;
            $query_ins = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$dtt','','','','$date','Charges','','$batt')";
            $result_ins = mysqli_query($conn,$query_ins);

            $query_chs = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Other Charges','$date','Charges on Normal Susu','$dtt','$acctno')";
            $result_chs = mysqli_query($conn,$query_chs);
         }
         }
        }

        if ($transtype=='Withdrawal')
        {   
         if($amount>$balance)
         {

         } else {

            $sqlz = "SELECT `ID` FROM `transactions` Where `Account Number`='$acctno' and `Date`='$date'";
            $rezult = mysqli_query($conn,$sqlz);
            $rowz = mysqli_fetch_array($rezult);
            $idz=$rowz['ID'];

            $query_upd = "UPDATE `currency detail` SET `TransID`='$idz' WHERE `Account No` = '$acctno' and `Date`='$date'";
            $result_upd = mysqli_query($conn,$query_upd);
         }
        } else if ($transtype=='Deposit') {
            $sqlz = "SELECT `ID` FROM `transactions` Where `Account Number`='$acctno' and `Date`='$date'";
            $rezult = mysqli_query($conn,$sqlz);
            $rowz = mysqli_fetch_array($rezult);
            $idz=$rowz['ID'];

            $query_upd = "UPDATE `currency detail` SET `TransID`='$idz' WHERE `Account No` = '$acctno' and `Date`='$date'";
            $result_upd = mysqli_query($conn,$query_upd);
        }
            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Transactions Record','Added Transactions Record for Customer: " . $acctno . ", " . $amount . ", " . $transtype . "')";
            $result_insert_Log = mysqli_query($conn,$query_insert_Log);
            ###### 

###########################################################################################
$sqlc="SELECT `Company Name` FROM `company info`";
$resultc = mysqli_query($conn,$sqlc) or die('Could not look up user data; ' . mysqli_error());
$rowc = mysqli_fetch_array($resultc);
$coys=$rowc['Company Name'];
$coy ="iBBDs Co-Thrift";

$sql="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
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
/*
###########INFOBID###########

$request = new HttpRequest();
$request->setUrl('https://api.infobip.com/sms/1/text/single');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'accept' => 'application/json',
  'content-type' => 'application/json',
  'authorization' => 'Basic V2FsdGVyZ2F0ZXM6b2xhZ2Vncw=='
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
*/
$msalt="ALERT: " . $name . ", Your account " . $dacct . " has been " . $trax . " with N" . $amount . ". Descr: By " . $byy . ", for " . $remark . ". Your account balance is N" . $bal . ". Date: " . $date;
########SMSLIVE247#######
/* Variables with the values to be sent. */

$owneremail="dauda.bashorun@gmail.com";
$subacct="IBBDS CONSULTING"; /*IBBDs Consulting*/
$subacctpwd="07053737888"; /*07039220512 */
$sendto=$phon; /* destination number */
$sender="IBBDS"; /* sender id iBBDs Co-Thrift*/
$message=$msalt;
/* message to be sent */

$url = "http://www.smslive247.com/http/index.aspx?"
. "cmd=sendquickmsg"
. "&owneremail=" . UrlEncode($owneremail)
. "&subacct=" . UrlEncode($subacct)
. "&subacctpwd=" . UrlEncode($subacctpwd)
. "&sendto=" . UrlEncode($sendto)
. "&message=" . UrlEncode($message)
. "&sender=" . UrlEncode($sender);
/* call the URL */
$time_start = microtime(true);
if ($f = @fopen($url, "r"))
{
$answer = fgets($f, 255);
#echo "[$answer]";
}
else
{
#echo "Error: URL could not be opened.";
}
#   echo "<br>"  ;
$time_end = microtime(true);
$time = $time_end - $time_start;

#echo "Finished in $time seconds\n";
##########################

##########################
$sqlX="SELECT `SMS Rate` FROM `sms tarrif`";
$resultX = mysqli_query($conn,$sqlX) or die('Could not look up user data; ' . mysqli_error());
$rowX = mysqli_fetch_array($resultX);
$smsamt=$rowX['SMS Rate'];

if ($transtype=='Deposit')
{   
 $balX=($balance+$amount)-$smsamt;
} else if ($transtype=='Withdrawal') {   
 $balX=($balance-$amount)-$smsamt;
}
/*
 $query_insx = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$smsamt','Auto Billing','','','$date','SMS Charges','SMS Charges','$balX')";
 $result_insx = mysqli_query($conn,$query_insx);

 $query_chas = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Other Charges','$date','SMS Alert Charges','$smsamt','$acctno')";
 $result_chas = mysqli_query($conn,$query_chas);
*/
#############################

}
### end Sms alert ###
}
###
###########################################################################################

        $tval="Your record has been saved.";
        header("location:transactions.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
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
        $result_update = mysqli_query($conn,$query_update);
        } else {
         $bal=$balance+$initamt;
         $query_update = "UPDATE `transactions` SET `Account Number` = '$acctno',`Deposit`='$amount',`Transactor`='$transactor',`Transactor Contact`='$tcontact',
          `Officer`='$officer',`Date`='$date',`Transaction Type`='$transtype',`Remark`='$remark',`Balance`='$bal' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);
        }

       $query_delete = "DELETE FROM `transactions` WHERE `ID` = '$id';";
       $result_delete = mysqli_query($conn,$query_delete);          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Transactions Record','Deleted Transactions Record for Customer: " . $acctno . ", " . $amount . ", " . $transtype . "')";
            $result_delete_Log = mysqli_query($conn,$query_delete_Log);
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