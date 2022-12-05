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

 $ID = $_POST["id"];
 $code = $_POST["code"];
 $category = $_POST["category"];
 $description = $_POST["description"];
 $remarks = $_POST["remarks"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($ID) != "")
      {
        $query_update = "UPDATE `heads` SET `Code`='$code',`Category`='$category',`Description`='$description',`Remarks`='$remarks' WHERE `ID` = '$ID'";
        $result_update = mysqli_query($conn,$query_update);

        $val="Account Heads";
        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $val="Account Heads";
        $tval="Please enter the account code and description before updating.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($code) != "")
      { 
        $query_insert = "Insert into `heads` (`Code`, `Description`,`Remarks`,`Category`) 
               VALUES ('$code', '$description', '$remarks','$category')";
        $result_insert = mysqli_query($conn,$query_insert);

        $val="Account Heads";
        $tval="Your record has been saved.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $val="Account Heads";
        $tval="Please enter code and description before saving.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `heads` WHERE `ID` = '$ID'";
       $result_delete = mysqli_query($conn,$query_delete);
        $val="Account Heads";
        $tval="Your record has been deleted.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>