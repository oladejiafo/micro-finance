<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2 && $_SESSION['access_lvl'] != 5))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}

 $natid = $_POST["natid"];
 $nationality = $_POST["nationality"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($natid) != "")
      {
        $query_update = "UPDATE `nationality` SET `Nat_ID`='$natid', `Nationality`='$nationality' WHERE `Nat_ID` = '$natid'";
        $result_update = mysqli_query($conn,$query_update) or die(mysqli_error());

        $val="Nationality";
        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Nationality before updating.";
        header("location:nationupdate.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($natid) != "")
      { 
        $query_insert = "Insert into `nationality` (`Nat_ID`, `Nationality`) 
               VALUES ('$natid', '$nationality')";
        $result_insert = mysqli_query($conn,$query_insert) or die(mysqli_error());

        $val="Nationality";
        $tval="Your record has been saved.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Nationality before updating.";
        header("location:nationupdate.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `nationality` WHERE `Nat_ID` = '$natid';";
       $result_delete = mysqli_query($conn,$query_delete) or die(mysqli_error()); 

        $val="Nationality";
        $tval="Your record has been deleted.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>