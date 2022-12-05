<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}

 $id = $_POST["id"];
 $branch = $_POST["branch"];
 $bcode = $_POST["bcode"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($branch) != "" and Trim($bcode) != "")
      {
        $query_update = "UPDATE `branch` SET `ID`='$id',`Branch` = '$branch',`Branch Code`='$bcode' WHERE `ID` = '$id'";
        $result_update = mysql_query($query_update);

        $val="Branch";
        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter all info before updating.";
        header("location:branch.php?tval=$tval&redirect=$redirect&ID=$id");
      }
      break;
     case 'Save':
      if (Trim($branch) != "" and Trim($bcode) != "")
      {
        $query_insert = "Insert into `branch` (`ID`,`Branch`,`Branch Code`) 
               VALUES ('$id','$branch','$bcode')";
        $result_insert = mysql_query($query_insert);

        $val="Branch";
        $tval="Your record has been saved.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter all info before saving.";
        header("location:branch.php?tval=$tval&redirect=$redirect&ID=$id");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `branch` WHERE `ID` = '$id'";
       $result_delete = mysql_query($query_delete);          

        $val="Branch";
        $tval="Your record has been deleted.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>