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

 $id = $_POST["id"];
 $state = $_POST["state"];
 
 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Modify':
      if (Trim($state) != "")
      {
        $query_update = "UPDATE `state` SET `State`='$state' WHERE `State`='$state'";
        $result_update = mysqli_query($conn,$query_update) or die(mysqli_error());

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql) or die('Could not fetch data; ' . mysqli_error());
            $rows = mysqli_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','State Update','Modified State: " . $state . "')";
            $result_update_Log = mysqli_query($conn,$query_update_Log) or die(mysqli_error());
            ###### 
        $val="State";
        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter State before updating.";
        header("location:tableupdates.php?cmbTable=$val&id=" . $id . "&adtx=1&redirect=$redirect");
      }
      break;
     case 'Add':
      if (Trim($state) != "")
      { 
        $query_insert = "Insert into `state` (`State`) 
               VALUES ('$state')";
        $result_insert = mysqli_query($conn,$query_insert) or die(mysqli_error());

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql) or die('Could not fetch data; ' . mysqli_error());
            $rows = mysqli_fetch_array($result);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','State Update','Added State: " . $state . "')";
            $result_insert_Log = mysqli_query($conn,$query_insert_Log) or die(mysqli_error());
            ###### 

        $val="State";
        $tval="Your record has been saved.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter State before saving.";
        header("location:tableupdates.php?cmbTable=$val&id=" . $id . "&adtx=1&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `state` WHERE `State`='$state' ";
       $result_delete = mysqli_query($conn,$query_delete) or die(mysqli_error());          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql) or die('Could not fetch data; ' . mysqli_error());
            $rows = mysqli_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','State Update','Added State: " . $state . "')";
            $result_delete_Log = mysqli_query($conn,$query_delete_Log) or die(mysqli_error());
            ###### 

        $val="State";
        $tval="Your record has been deleted.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>