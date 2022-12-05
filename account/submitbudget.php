<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
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

 $ID = $_POST["ID"];
 $type = $_POST["type"];
 $class = $_POST["class"];
 $budget = $_POST["budget"];
 $month = $_POST["month"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($ID) != "" && Trim($type) != "")
      {
        $query_update = "UPDATE budget SET `Type` = '$type',Class='$class',Budget='$budget',
          `Month`='$month' WHERE `ID` = '$ID'";

        $result_update = mysql_query($query_update);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Budget','Modified Budget record for : " . $type . ", Class: " . $class . "')";

            $result_update_Log = mysql_query($query_update_Log);
            ###### 

        $tval="Your record has been updated.";
        header("location:budget.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the Budget Type before updating.";
        header("location:budgets.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($type) != "")
      { 
        $query_insert = "Insert into budget (`Type`,Class,Budget,`Month`) 
               VALUES ('$type','$class','$budget','$month')";

        $result_insert = mysql_query($query_insert);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Budget','Added Budget record for: " . $type . ", Class: " . $class . "')";

            $result_insert_Log = mysql_query($query_insert_Log);
            ###### 

        $tval="Your record has been saved.";
        header("location:budget.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the Transaction Type before saving.";
        header("location:budgets.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM budget WHERE `ID` = '$ID'";

       $result_delete = mysql_query($query_delete);          


            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Budget','Deleted Budget record for: " . $type . ", Class: " . $class . "')";

            $result_delete_Log = mysql_query($query_delete_Log);
            ###### 

        $tval="Your record has been deleted.";
        header("location:budget.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;     
   }
 }
?>