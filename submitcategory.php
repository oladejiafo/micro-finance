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

 $catid = $_POST["catid"];
 $category = $_POST["category"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($catid) != "")
      {
        $query_update = "UPDATE `asset category` SET `ID`='$catid',`Category` = '$category' WHERE `ID` = '$catid'";
        $result_update = mysqli_query($conn,$query_update) or die(mysqli_error());

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql) or die('Could not fetch data; ' . mysqli_error());
            $rows = mysqli_fetch_array($result);

            $query_update_Log = "Insert into `Monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Asset Category Update','Modified Asset Category: " . $category . "')";
            $result_update_Log = mysqli_query($conn,$query_update_Log) or die(mysqli_error());
            ###### 
        $val="Asset Category";
        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter ID and Category before updating.";
        header("location:category.php?tval=$tval&redirect=$redirect&ID=$deptid");
      }
      break;
     case 'Save':
      if (Trim($catid) != "")
      { 
        $query_insert = "Insert into `asset category` (`ID`,`Category`) 
               VALUES ('$catid','$category')
               ";
        $result_insert = mysqli_query($conn,$query_insert) or die(mysqli_error());

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql) or die('Could not fetch data; ' . mysqli_error());
            $rows = mysqli_fetch_array($result);

            $query_insert_Log = "Insert into `Monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Asset Category Update','Added Asset Category: " . $category . "')";
            $result_insert_Log = mysqli_query($conn,$query_insert_Log) or die(mysqli_error());
            ###### 

        $val="Asset Category";
        $tval="Your record has been saved.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter ID and Category before saving.";
        header("location:category.php?tval=$tval&redirect=$redirect&ID=$deptid");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `asset category` WHERE `ID` = '$catid';";
       $result_delete = mysqli_query($conn,$query_delete) or die(mysqli_error());          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql) or die('Could not fetch data; ' . mysqli_error());
            $rows = mysqli_fetch_array($result);

            $query_delete_Log = "Insert into `Monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Asset Category Update','Deleted Asset Category: " . $category . "')";
            $result_delete_Log = mysqli_query($conn,$query_delete_Log) or die(mysqli_error());
            ###### 

        $val="Asset Category";
        $tval="Your record has been deleted.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;
   }
 }
?>