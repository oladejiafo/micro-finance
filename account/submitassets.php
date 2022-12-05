<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
   if ($_SESSION['access_lvl'] != 6){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
}
}

 $ID = $_POST["ID"];
 $location = $_POST["location"];
 $code = $_POST["code"];
 $category = $_POST["category"];
 $name = $_POST["name"];
 $description = $_POST["description"];
 $make = $_POST["make"];
 $status = $_POST["status"];
 $quantity = $_POST["quantity"];
 $dateacquired = $_POST["dateacquired"];
 $pprice = $_POST["pprice"];
 $serialno = $_POST["serialno"];
 $cvalue = $_POST["cvalue"];
 $depreciation = $_POST["depreciation"];
 $schedule = $_POST["schedule"];
 $comment = $_POST["comment"];
 $sold = $_POST["sold"];
 $datesold = $_POST["datesold"];
 $amountsold = $_POST["amountsold"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($ID) != "" && Trim($name) != "")
      {
        $query_update = "UPDATE `assets` SET `Location` = '$location',`Code`='$code',`Category`='$category',`Name`='$name',
          `Description`='$description',`Make`='$make',`Status`='$status',`Quantity`='$quantity',`Date Acquired`='$dateacquired'
	  ,`Purchase Price`='$pprice',`Serial No`='$serialno',`Current Value`='$cvalue',`Depreciation`='$depreciation',`Next Maintenance`='$schedule'
	  ,`Comment`='$comment',`Sold`='$sold',`Date Sold`='$datesold',`Amount Sold`='$amountsold' WHERE `ID` = '$ID'";
        $result_update = mysqli_query($conn,$query_update);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Assets Register','Modified Assets Register for: " . $name . ", Location: " . $location . "')";
            $result_update_Log = mysqli_query($conn,$query_update_Log);
            ###### 

        $tval="Your record has been updated.";
        header("location:fassets.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the Asset Name before updating.";
        header("location:assets.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($name) != "")
      { 
        $query_insert = "Insert into `assets` (`Location`,`Code`,`Category`,`Name`,`Description`,`Make`,`Status`,`Quantity`,`Date Acquired`,`Purchase Price`,`Serial No`,`Current Value`,`Depreciation`,`Next Maintenance`,`Comment`,`Sold`,`Date Sold`,`Amount Sold`) 
               VALUES ('$location','$code','$category','$name','$description','$make','$status','$quantity','$dateacquired','$pprice','$serialno','$cvalue','$depreciation','$schedule','$comment','$sold','$datesold','$amountsold')";
        $result_insert = mysqli_query($conn,$query_insert);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Assets Register','Added Assets Register for: " . $name . ", Location: " . $location . "')";
            $result_insert_Log = mysqli_query($conn,$query_insert_Log);
            ###### 

        $tval="Your record has been saved.";
        header("location:fassets.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the Asset Name before saving.";
        header("location:assets.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `assets` WHERE `ID` = '$ID'";
       $result_delete = mysqli_query($conn,$query_delete);          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`,`company`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Assets Register','Deleted Assets Register for: " . $name . ", Location: " . $location . "')";
            $result_delete_Log = mysqli_query($conn,$query_delete_Log);
            ###### 

        $tval="Your record has been deleted.";
        header("location:fassets.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;     
   }
 }
?>