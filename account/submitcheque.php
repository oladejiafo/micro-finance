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
 $bank = $_POST["bank"];
 $particulars = $_POST["particulars"];
 $amount = $_POST["amount"];
 $date = $_POST["date"];
 $chqno = $_POST["chqno"];
 $status = $_POST["status"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($ID) != "" && Trim($type) != "")
      {
        $query_update = "UPDATE `cheque` SET `Type` = '$type',`Bank`='$bank', `Particulars`='$particulars',`Amount`='$amount',
          `Cheque No`='$chqno',`Status`='$status',`Date`='$date' WHERE `ID` = '$ID'";
        $result_update = mysql_query($query_update);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Daily Cash','Modified Daily Cash record for : " . $type . ", classification: " . $classification . "')";

            $result_update_Log = mysql_query($query_update_Log);
            ###### 

        $tval="Your record has been updated.";
        header("location:bankbook.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the Transaction Type before updating.";
        header("location:cheque.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($type) != "")
      { 
        $query_insert = "Insert into `cheque` (`Type`,`Bank`, `Particulars`,`Amount`,`Cheque No`,`Status`,`Date`) 
               VALUES ('$type','$bank', '$particulars','$amount','$chqno','$status','$date')";
        $result_insert = mysql_query($query_insert);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Daily Cash','Added Daily Cash record for: " . $type . ", classification: " . $classification . "')";

            $result_insert_Log = mysql_query($query_insert_Log);
            ###### 

        $tval="Your record has been saved.";
        header("location:bankbook.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the Transaction Type before saving.";
        header("location:cheque.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `cheque` WHERE `ID` = '$ID'";

       $result_delete = mysql_query($query_delete);          


            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`,`company`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Daily Cash','Deleted Daily Cash record for: " . $type . ", classification: " . $classification . "')";

            $result_delete_Log = mysql_query($query_delete_Log);
            ###### 

        $tval="Your record has been deleted.";
        header("location:bankbook.php?ID=$ID&tval=$tval&redirect=$redirect");
      }
      break;     
   }
 }
?>