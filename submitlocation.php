<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don�t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn�t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}

 $locationid = $_POST["locationid"];
 $location = $_POST["location"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Modify':
      if (Trim($locationid) != "")
      {
        $query_update = "UPDATE `location` SET `Location_id`='$locationid',`Location` = '$location' WHERE `Location_id` = '$locationid'";
        $result_update = mysqli_query($conn,$query_update) or die(mysqli_error());

        $val="Location";
        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Location before updating.";
        header("location:tableupdates.php?cmbTable=$val&id=" . $locationid . "&adtx=1&redirect=$redirect");
      }
      break;
     case 'Add':
      if (Trim($locationid) != "")
      { 
        $query_insert = "Insert into `location` (`Location_id`,`Location`) 
               VALUES ('$locationid','$location')";
        $result_insert = mysqli_query($conn,$query_insert) or die(mysqli_error());

        $val="Location";
        $tval="Your record has been saved.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Location before updating.";
        header("location:tableupdates.php?cmbTable=$val&id=" . $locationid . "&adtx=1&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `location` WHERE `Location_id` = '$locationid'";
       $result_delete = mysqli_query($conn,$query_delete) or die(mysqli_error());

        $val="Location";
        $tval="Your record has been deleted.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>