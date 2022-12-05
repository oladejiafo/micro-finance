<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 4))
{
 if ($_SESSION['access_lvl'] != 2){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}
}
#############Stage 1
 $id = $_POST["id"];
 $personal_remark = $_POST["personal_remark"];
 $income_remark = $_POST["income_remark"];
 $employment_remark = $_POST["employment_remark"];
 $nk_remark = $_POST["nk_remark"];
 $bank_remark = $_POST["bank_remark"];


 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Approve Loan':
      if ($id)
      {
        $query_update = "UPDATE `loan application` SET `Status`='Approved',`Personal_Remark`='$personal_remark',`Income_Remark`='$income_remark',`Employment_Remark`='$employment_remark',`NK_Remark`='$nk_remark',`Bank_Remark`='$bank_remark' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $val="Loan Applications";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;

     case 'Disapprove Loan':
      if ($id)
      {
        $query_update = "UPDATE `loan application` SET `Status`='Disapproved',`Personal_Remark`='$personal_remark',`Income_Remark`='$income_remark',`Employment_Remark`='$employment_remark',`NK_Remark`='$nk_remark',`Bank_Remark`='$bank_remark' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $val="Loan Applications";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Close Form':
        $val="Loan Applications";
        header("location:tableupdates.php?cmbTable=$val&tval=$tval&redirect=$redirect");
      break;
     case 'SUBMIT':
      if ($_SESSION['stage']==9)
      {
        $_SESSION['stage']="";

        $dat=date('Y-m-d');
        $query_update = "UPDATE `lease application` SET `Authorize`='$authorize',`Terms`='$terms',`Application Date`='$dat' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $_SESSION['idx']="";
        $tval="Your Application Has Been Submitted. Thank you.";
        header("location:leaseapp.php?tval=$tval&redirect=$redirect");
      }
      break;

   }
 }
?>