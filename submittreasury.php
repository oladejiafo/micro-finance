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

 $idd = $_POST["idd"];
 $cashier = $_POST["cashier"];
 $curnote = $_POST["curnote"];
 $curamt = $_POST["curamt"];
 $giver = $_POST["giver"];

 $ide = $_POST["ide"];
 $cashier2 = $_POST["cashier2"];
 $curnote2 = $_POST["curnote2"];
 $curamt2 = $_POST["curamt2"];
 $giver2 = $_POST["giver2"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Edit':
      if (Trim($curnote) != "" and Trim($curamt) != "" or (Trim($curnote2) != "" and Trim($curamt2) != ""))
      {
        if(!$curnote)
        {
          $query_update = "UPDATE `treasury` SET `ID`='$ide',`Amount`='$curamt2',`Note`='$curnote2',`Given To`='$cashier2',`Given By`='$giver2',`Date`='" . date('Y-m-d') . "' WHERE `ID` = '$ide'";
         } else {
         $query_update = "UPDATE `treasury` SET `ID`='$idd',`Amount`='$curamt2',`Note`='$curnote2',`Given To`='$cashier2',`Given By`='$giver2',`Date`='" . date('Y-m-d') . "' WHERE `ID` = '$idd'";
        } 
        $result_update = mysql_query($query_update);
        header("location:treasury.php?tval=$tval&redirect=$redirect");
      }
      else
      {
        $cval="ERROR: Please enter Note and Amount!.";
        header("location:treasury.php?idd=$idd&ide=$ide&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Add':
      if ((Trim($curnote) != "" and Trim($curamt) != "") or (Trim($curnote2) != "" and Trim($curamt2) != ""))
      { 
        if(!$curnote)
        {
          $query_insert = "Insert into `treasury` (`ID`,`Date`,`Amount`,`Note`,`Given To`,`Given By`,`Direction`) 
                                         VALUES ('$ide','" . date('Y-m-d') . "','$curamt2','$curnote2','$cashier2','$giver2','In')";
        } else {
          $query_insert = "Insert into `treasury` (`ID`,`Date`,`Amount`,`Note`,`Given To`,`Given By`,`Direction`) 
                                         VALUES ('$idd','" . date('Y-m-d') . "','$curamt','$curnote','$cashier','$giver','Out')";
        }
        $result_insert = mysql_query($query_insert);
        header("location:treasury.php?tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="ERROR: Please enter Note and Amount!";
        header("location:treasury.php?idd=$idd&tval=$tval&redirect=$redirect");
      }
      break;
     case 'X':
      {
        if(!$idd)
        {
          $query_delete = "DELETE FROM `treasury` WHERE `ID` = '$ide'";
        } else {
          $query_delete = "DELETE FROM `treasury` WHERE `ID` = '$idd'";
        } 
        $result_delete = mysql_query($query_delete);
        header("location:treasury.php?tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>