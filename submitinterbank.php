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
 $rnarration = $_POST["rnarration"];
 $rofficer = $_POST["rofficer"];
 $ramount = $_POST["ramount"];
 $rbranch = $_POST["rbranch"];

 $ide = $_POST["ide"];
 $pnarration = $_POST["pnarration"];
 $pofficer = $_POST["pofficer"];
 $pamount = $_POST["pamount"];
 $pbranch = $_POST["pbranch"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Edit':
      if (Trim($rbranch) != "" and Trim($ramount) != "" or (Trim($pbranch) != "" and Trim($pamount) != ""))
      {
        if(!$rbranch)
        {
          $query_update = "UPDATE `interbank` SET `p_Amount`='$pamount',`p_Branch`='$pbranch',`p_Officer`='$pofficer',`p_Narration`='$pnarration',`p_Date`='" . date('Y-m-d') . "', `Paid By`='" . $_SESSION['name'] . "' WHERE `ID` = '$ide'";
         } else {
         $query_update = "UPDATE `interbank` SET `r_Amount`='$ramount',`r_Branch`='$rbranch',`r_Officer`='$rofficer',`r_Narration`='$rnarration',`r_Date`='" . date('Y-m-d') . "', `Received By`='" . $_SESSION['name'] . "' WHERE `ID` = '$idd'";
        } 
        $result_update = mysql_query($query_update);
        header("location:interbank.php?tval=$tval&redirect=$redirect");
      }
      else
      {
        $cval="ERROR: Please enter Branch and Amount!.";
        header("location:interbank.php?idd=$idd&ide=$ide&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Add':
      if (Trim($rbranch) != "" and Trim($ramount) != "" or (Trim($pbranch) != "" and Trim($pamount) != ""))
      { 
        if(!$rbranch)
        {
          $query_insert = "Insert into `interbank` (`ID`,`p_Amount`,`p_Branch`,`p_Officer`,`p_Narration`,`p_Date`, `Paid By`) 
                                         VALUES ('$ide','$pamount','$pbranch','$pofficer','$pnarration','" . date('Y-m-d') . "', '" . $_SESSION['name'] . "')";
        } else {
          $query_insert = "Insert into `interbank` (`ID`,`r_Amount`,`r_Branch`,`r_Officer`,`r_Narration`,`r_Date`, `Received By`) 
                                         VALUES ('$idd','$ramount','$rbranch','$rofficer','$rnarration','" . date('Y-m-d') . "', '" . $_SESSION['name'] . "')";
        }
        $result_insert = mysql_query($query_insert);
        header("location:interbank.php?tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="ERROR: Please enter Branch and Amount!";
        header("location:interbank.php?idd=$idd&tval=$tval&redirect=$redirect");
      }
      break;
     case 'X':
      {
        if(!$idd)
        {
          $query_delete = "DELETE FROM `interbank` WHERE `ID` = '$ide'";
        } else {
          $query_delete = "DELETE FROM `interbank` WHERE `ID` = '$idd'";
        } 
        $result_delete = mysql_query($query_delete);
        header("location:interbank.php?tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>