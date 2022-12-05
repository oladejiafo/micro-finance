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

 $ID = $_POST["ID"];
 $type = $_POST["type"];
 $intrate = $_POST["intrate"];
 $rmode = $_POST["rmode"];
 $effect = $_POST["effect"];
 $margintype = $_POST["margintype"];
 $margin = $_POST["margin"];
 $mindep = $_POST["mindep"];
 $remark = $_POST["remark"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Modify':
      if (Trim($type) != "")
      {
        $query_update = "UPDATE `account type` SET `Type`='$type',`Interest Rate`='$intrate',`Effect`='$effect',`Rate Mode`='$rmode',`Margin Type`='$margintype',`Margin`='$margin',`Minimum Deposit`='$mindep',`Remark`='$remark' WHERE `ID` = '$ID'";
        $result_update = mysqli_query($conn,$query_update);

        $val="Account Type";
        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $val="Account Type";
        $tval="Please enter the account type and others before updating.";
        header("location:tableupdates.php?cmbTable=$val&id=" . $id . "&adtx=1&redirect=$redirect");
      }
      break;
     case 'Add':
      if (Trim($type) != "")
      { 
        $query_insert = "Insert into `account type` (`Type`,`Interest Rate`,`Rate Mode`,`Effect`,`Margin Type`,`Margin`,`Minimum Deposit`,`Remark`) 
               VALUES ('$type','$intrate','$rmode','$effect','$margintype','$margin','$mindep','$remark')";
        $result_insert = mysqli_query($conn,$query_insert);

        $val="Account Type";
        $tval="Your record has been saved.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      else
      {
        $val="Account Type";
        $tval="Please enter type and others before saving.";
        header("location:tableupdates.php?cmbTable=$val&id=" . $id . "&adtx=1&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `account type` WHERE `ID` = '$ID'";
       $result_delete = mysqli_query($conn,$query_delete);
        $val="Account Type";
        $tval="Your record has been deleted.";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>