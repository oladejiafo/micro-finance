<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 6))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}

 $lid = $_POST["lid"];
 $id = $_POST["id"];
 $guarantor = $_POST["guarantor"];
 $acctno = $_POST["acctno"];
 $contact = $_POST["contact"];
 $occupation = $_POST["occupation"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($lid) != "" and Trim($guarantor) != "")
      {
        $query_update = "UPDATE `loan guarantor` SET `Guarantor`='$guarantor',`Loan_ID` = '$lid',`Contact` = '$contact',`Occupation` = '$occupation' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

#######
if (!empty($_FILES['sign_filename']['name'])){
if (file_exists("images/sign/gr_" . $id . ".jpg")==1)
{
   $signNam = "images/sign/gr_" . $id . ".jpg";
   $newsignnam = "images/sign/gr_" . date("Y-m-d") . "_" . $id . ".jpg";
   rename($signNam, $newsignnam);
}
   //make variables available
   $sign_userid = $id;
   $sign_tempname = $_FILES['sign_filename']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir ="images/sign/";
   $signName = $signDir . $sign_tempname;
   if (move_uploaded_file($_FILES['sign_filename']['tmp_name'],$signName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName);
 
    $ext = ".jpg";

    $newsignname = $signDir . "gr_" . $id . $ext;
    rename($signName, $newsignname);

}}
###### 

        $tval="Your record has been updated.";
        header("location:loans.php?acctno=$acctno&view=1&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Basic details before updating.";
        header("location:loans.php?acctno=$acctno&view=1&trans=1&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($lid) != "" and Trim($guarantor) != "")
      { 
        $query_insert = "Insert into `loan guarantor` (`Guarantor`,`Loan_ID`,`Contact`,`Occupation`) 
                                               VALUES ('$guarantor','$lid','$contact','$occupation')";
        $result_insert = mysqli_query($conn,$query_insert);

#######
if (!empty($_FILES['sign_filename']['name'])){
if (file_exists("images/sign/gr_" . $id . ".jpg")==1)
{
   $signNam = "images/sign/gr_" . $id . ".jpg";
   $newsignnam = "images/sign/gr_" . date("Y-m-d") . "_" . $id . ".jpg";
   rename($signNam, $newsignnam);
}
   //make variables available
   $sign_userid = $id;
   $sign_tempname = $_FILES['sign_filename']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir ="images/sign/";
   $signName = $signDir . $sign_tempname;
   if (move_uploaded_file($_FILES['sign_filename']['tmp_name'],$signName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName);
 
    $ext = ".jpg";

    $newsignname = $signDir . "gr_" . $id . $ext;
    rename($signName, $newsignname);

}}
###### 

        $tval="Your record has been updated.";
        header("location:loans.php?acctno=$acctno&view=1&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Basic details before saving.";
        header("location:loans.php?acctno=$acctno&view=1&trans=1&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `loan guarantor` WHERE `ID` = '$id'";
       $result_delete = mysqli_query($conn,$query_delete);          

        $tval="Your record has been deleted.";
        header("location:loans.php?acctno=$acctno&view=1&trans=1&tval=$tval&redirect=$redirect");
      }
      break;   

   }
 }
?>