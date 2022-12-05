<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 4){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
}

 $id = $_REQUEST["id"];
 $bank = $_REQUEST["bank"];
 $confirm = $_REQUEST["confirm"];
 $conf = $_REQUEST["conf"];
 $amount = $_REQUEST["amount"];
 $dat = $_REQUEST["dat"];
 $page = $_REQUEST["page"];
 $filter = $_REQUEST["filter"];
 require_once 'conn.php';

 if ($confirm==0){
  $query_update = "update `revenue` set `Confirmed`=1 where `ID`='$id'";
  $result_update = mysql_query($query_update);
 
 # $query_insert = "insert into `remitance` (`Bank Remitance`,`Bank Confirm`,`Bank Date`,`Bank`) 
 #                 values ('$amount',1,'$dat','$bank')";
 # $result_insert = mysql_query($query_insert);

  $tval="Record has been Confirm.";
 }
 if ($confirm==1){
  $query_update = "update `revenue` set `Confirmed`=1 where `ID`='$id'";
  $result_update = mysql_query($query_update);
 
  $query_insert = "insert into `remitance` (`Bank Remitance`,`Bank Confirm`,`Bank Date`,`Bank`) 
                  values ('$amount',1,'$dat','$bank')";
  $result_insert = mysql_query($query_insert);
#  $query_insert = "insert into `remitance` (`CBN Remitance`,`CBN Confirm`,`CBN Date`,`Bank`) 
 #                 values ('$amount',1,'$dat','$bank')";
  #$result_insert = mysql_query($query_insert);

  $tval="Record has been Confirm.";
 }
 header("location:bank.php?id=$id&page=$page&bank=$bank&redirect=$redirect");
?>