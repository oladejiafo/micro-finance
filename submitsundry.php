<?php
 $date = $_POST["date"];
 $id = $_POST["id"];
 $type = $_POST["type"];
 $source = $_POST["source"];
 $amount = $_POST["amount"];
 $acctno = $_POST["acctno"];
 $note = $_POST["note"];
 
 require_once 'conn.php';
 

if ($_POST['date'] !='0000-00-00' and $_POST['date'] !='')
{
  $rsdate = $_POST['date'];
  list($dayy, $monthh, $yearr) = explode('-', $rsdate);
  $date = $yearr . '-' . $monthh . '-' . $dayy;
}


 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($date) != "" and Trim($id) != "")
      {
        $query_update = "UPDATE `sundry` SET `Amount`='$amount',`Type`='$type',`Note`='$note',`Date`='$date',`Source`='$source',`Account Number`='$acctno' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);
        header("location:sundry.php?tval=$tval&redirect=$redirect");
      }
      else
      {
        $cval="ERROR: Please enter Date and Amount!.";
        header("location:sundry.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($date) != "" and Trim($source) != "")
      { 
        $query_insert = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
                                       VALUES ('$amount','$note','$date','$source','$acctno','" . ucfirst($_SESSION['name']) . "','$type')";
        $result_insert = mysqli_query($conn,$query_insert);

        $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
        $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysqli_error());
        $rowb = mysqli_fetch_array($resultb); 

        $balance= $rowb['Balance']; 
         $bal=$balance-$amount;
         $query_insert = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctno','$amount','HQ Auto Transaction','','" . ucfirst($_SESSION['name']) . "','$date','Withdrawal','$source','$bal')";
         $result_insert = mysqli_query($conn,$query_insert);

        if($source !="Overages")
        {
          $query_ins = "Insert into cash (`Type`,Classification, Particulars,Amount,`Date`,`Source`,`Account`,`Recipient`,`Bank`,`Paid`) 
                VALUES ('Income','Other Charges','$source from $acctno','$amount','$date','','','','','Paid')";
          $result_ins = mysqli_query($conn,$query_ins);
        }
        header("location:sundry.php?tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="ERROR: Please enter all details!";
        header("location:sundry.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `sundry` WHERE `ID` = '$id'";
       $result_delete = mysqli_query($conn,$query_delete);
       header("location:sundry.php?tval=$tval&redirect=$redirect");
      }
      break;   
   }
 }
?>