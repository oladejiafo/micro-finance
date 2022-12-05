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
 $agent = $_POST["agent"];
 $phone = $_POST["phone"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Modify':
      if (Trim($agent) != "")
      {
        $query_update = "UPDATE `agents` SET `Agent`='$agent',`Phone`='$phone' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $val="Agents";
        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the agent name before updating.";
        header("location:tableupdates.php?cmbTable=$val&id=" . $id . "&adtx=1&redirect=$redirect");
      }
      break;
     case 'Add':
      if (Trim($agent) != "")
      { 
        $query_insert = "Insert into `agents` (`Agent`,`Phone`) 
               VALUES ('$agent','$phone')";
        $result_insert = mysqli_query($conn,$query_insert);

        $val="Agents";
        $tval="Your record has been saved.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter agent name before saving.";
        header("location:tableupdates.php?cmbTable=$val&id=" . $id . "&adtx=1&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `agents` WHERE `ID` = '$id'";
       $result_delete = mysqli_query($conn,$query_delete);
        $val="Agents";
        $tval="Your record has been deleted.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>