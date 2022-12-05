<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 7))
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
 $type = $_POST["type"];
 $enteredby = $_POST["enteredby"];
 $amount = $_POST["amount"];
 $agent = $_POST["agent"];
 $date = $_POST["date"];
 $paymode = $_POST["paymode"];
 $balance = $_POST["balance"];

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
     case 'Update':
      if (Trim($acctno) != "" && Trim($amount) != "" && Trim($agent) != "")
      { $bal=$balance+$amount;

        $query_updated = "UPDATE `transactions` SET `Account Number` = '$acctno',`Deposit`='$amount',`Transactor`='$agent',
          `Officer`='$enteredby',`Date`='$date',`Transaction Type`='Deposit',`Balance`='$bal' WHERE `Account Number` = '$acctno'";
        $result_updated = mysqli_query($conn,$query_updated);

        $query_update = "UPDATE `contributions` SET `Account Number` = '$acctno',`First Name`='$fname',
          `Surname`='$sname',`Amount`='$amount',`Agent`='$agent',`Date`='$date',`Entered By`='$enteredby'
          ,`Pay Mode`='$paymode' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);


            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Contribution Record','Modified Contribution Record for Customer: " . $acctno . ", " . $amount . "')";
            $result_update_Log = mysqli_query($conn,$query_update_Log);
            ###### 

        $tval="Your record has been updated.";
        header("location:contribution.php?id=$id&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter all details before updating.";
        header("location:contribution.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($acctno) != "" && Trim($amount) != "" && Trim($agent) != "")
      {  $bal=$balance+$amount;

         $query_inserted = "Insert into `transactions` (`Account Number`,`Deposit`,`Transactor`,`Officer`,`Date`,`Transaction Type`,`Balance`) 
               VALUES ('$acctno','$amount','$agent','$enteredby','$date','Deposit','$bal')";
        $result_inserted = mysqli_query($conn,$query_inserted);

        $query_insert = "Insert into `contributions` (`Account Number`,`First Name`,`Surname`,`Amount`,`Agent`,`Date`,`Entered By`,`Pay Mode`) 
               VALUES ('$acctno','$fname','$sname','$amount','$agent','$date','$enteredby','$paymode')";
        $result_insert = mysqli_query($conn,$query_insert);

         $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
               VALUES ('Income','Customers Deposit','Customers Deposit for $acctno','$amount','$date','Contribution','$acctno','','','')";
         $result_ins = mysqli_query($conn,$query_ins);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Contribution Record','Added Contribution Record for Customer: " . $acctno . ", " . $amount . "')";
            $result_insert_Log = mysqli_query($conn,$query_insert_Log);
            ###### 

###########################################################################################
$sqlc="SELECT `Company Name` FROM `company info`";
$resultc = mysqli_query($conn,$sqlc) or die('Could not look up user data; ' . mysqli_error());
$rowc = mysqli_fetch_array($resultc);
$coy=$rowc['Company Name'];

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
$transtype=='Deposit';

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
 $ttval="No internet";
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
  $bodyZ ="ALERT: " . $name . ", Your account " . $dacct . " has been " . $trax . " with N" . $amount . ". Descr: By " . $byy . ", for Contribution. Your account balance is N" . $bal . ". Date: " . $date . "\n";
  $toZ=$email;
  mail($toZ,$subjectZ,$bodyZ,$fromZ);
   
 }
}
#####end email alert######


###
if ($sms==1)
{
$trax="credited"; 

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
   "text":"ALERT: ' . $name . ', Your account ' . $dacct . ' has been ' . $trax . ' with N' . $amount . '. Descr: By ' . $byy . ', for Contribution. Your account balance is N' . $bal . '. Date: ' . $date . '"
}');

try {
  $response = $request->send();
  
  #echo $response->getBody();
} catch (HttpException $ex) {
  #echo $ex;
}

##########################
$sqlX="SELECT `SMS Rate` FROM `sms tarrif`";
$resultX = mysqli_query($conn,$sqlX) or die('Could not look up user data; ' . mysqli_error());
$rowX = mysqli_fetch_array($resultX);
$smsamt=$rowX['SMS Rate'];

if ($transtype=='Withdrawal') 
{   
 $balX=($balance-$amount)-$smsamt;
} else {   
 $balX=($balance+$amount)-$smsamt;
}

 $query_insx = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctno','$smsamt','Auto Billing','','','$date','SMS Charges','SMS Charges','$balX')";
 $result_insx = mysqli_query($conn,$query_insx);

 $query_chas = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Other Charges','$date','SMS Alert Charges','$smsamt','$acctno')";
 $result_chas = mysqli_query($conn,$query_chas);
#############################
}
###
}
###
###########################################################################################


        $tval="Your record has been saved. " . $ttval;
        header("location:contribution.php?id=$id&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter all details before saving.";
        header("location:contribution.php?id=$id&acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `contributions` WHERE `ID` = '$id';";
       $result_delete = mysqli_query($conn,$query_delete);          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Contribution Record','Deleted Contribution Record for Customer: " . $acctno . ", " . $amount . "')";
            $result_delete_Log = mysqli_query($conn,$query_delete_Log);
            ###### 

        $tval="Your record has been deleted.";
        header("location:contribution.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;     
   }
 }
?>