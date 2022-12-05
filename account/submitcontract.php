<?php
 session_start();
 require_once 'conn.php';

 $ID = $_POST["ID"];
 $category = $_POST["category"];
 $date = $_POST["date"];
 $ctitle = $_POST["ctitle"];
 $cname = $_POST["cname"];
 $caddress = $_POST["caddress"];
 $amount = $_POST["amount"];
 $amountpaid = $_POST["amountpaid"];
 $contact = $_POST["contact"];
 $status = $_POST["status"];
 $bank= $_POST["bank"];
 $account  = $_POST["account"];
 $paid= $_POST["paid"];
 $cphone= $_POST["cphone"];
 $mda = $_POST["mda"];
 $month = $_POST["month"];

 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Modify':
      if (Trim($ID) != "" && Trim($date) != "")
      {
        $query_update = "UPDATE `contract` SET `Contract Category` = '$category',`Contract Date`='$date', `Contract Title`='$ctitle',`Contractor`='$cname',`Paid`='$paid',`MDA`='$mda',`Year`='$month',
                        `Account`='$account',`Bank`='$bank',`Contractor Address`='$caddress',`Contact Phone`='$cphone',`Amount`='$amount',`Amount Paid`='$amountpaid',`Contract Status`='$status',`Contact`='$contact' WHERE `ID` = '$ID'";
        $result_update = mysqli_query($conn,$query_update);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Contracts','Modified Contracts record for : " . $cname . ", Title: " . $ctitle . "')";
            $result_update_Log = mysqli_query($conn,$query_update_Log);
            ###### 

        $tval="Your record has been updated.";
        header("location:contract.php?ID=$ID&xxx=1&xtt=contract&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the Contract Date before updating.";
        header("location:contract.php?ID=$ID&xxx=1&xtt=contract&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($date) != "")
      { 
        $query_insert = "Insert into `contract` (`Contract Category`,`Contract Date`, `Contract Title`,`Contractor`,`Amount`,`Amount Paid`,`Contract Status`,`Contact`,`Account`,`Bank`,`Paid`,`Contractor Address`,`Contact Phone`,`MDA`,`Year`) 
               VALUES ('$category','$date','$ctitle','$cname','$amount','$amountpaid','$status','$contact','$account','$bank','$paid','$caddress','$cphone','$mda','$month')";
        $result_insert = mysqli_query($conn,$query_insert);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Contracts','Added Contracts record for : " . $cname . ", Title: " . $ctitle . "')";
            $result_insert_Log = mysqli_query($conn,$query_insert_Log);
            ###### 

        $tval="Your record has been saved.";
        header("location:contract.php?ID=$ID&xxx=1&xtt=contract&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter the Contract Date before saving.";
        header("location:contractor.php?ID=$ID&xxx=1&xtt=contract&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `contract` WHERE `ID` = '$ID'";
       $result_delete = mysqli_query($conn,$query_delete);          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`,`company`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Contracts','Deleted Contracts record for : " . $cname . ", Title: " . $ctitle . "')";
            $result_delete_Log = mysqli_query($conn,$query_delete_Log);
            ###### 

        $tval="Your record has been deleted.";
        header("location:contract.php?ID=$ID&xtt=contract&tval=$tval&redirect=$redirect");
      }
      break;     
   }
 }
?>