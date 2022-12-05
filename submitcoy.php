<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & $_SESSION['access_lvl'] != 5) 
{
  $redirect = $_SERVER['PHP_SELF'];
   header("Refresh: 5; URL=login.php?redirect=$redirect");
   echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
   echo "(If your browser doesn’t support this, " .
   "<a href=\"login.php?redirect=$redirect\">click here</a>)";
   die();

}

 $phone = $_POST["phone"];
 $email = $_POST["email"];
 $city = $_POST["city"];
 $address = $_POST["address"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($address) != "")
      {
        $query_update = "UPDATE `company info` SET `Phone`='$phone', `Email`='$email', `City`='$city', `Address`='$address'";
        $result_update = mysqli_query($conn,$query_update);

#######
if (!empty($_FILES['image_filename']['name'])){
if (file_exists("images/logo.jpg")==1)
{
   $ImageNam = "images/logo.jpg";
   $newfilenam = "images/" . date("Y-m-d-H-i") . "_logo.jpg";
   rename($ImageNam, $newfilenam);
}
   //make variables available
   $image_userid = $id;
   $image_tempname = $_FILES['image_filename']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir ="images/";
   $ImageName = $ImageDir . $image_tempname;
   if (move_uploaded_file($_FILES['image_filename']['tmp_name'],$ImageName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName);
 
    $ext = ".jpg";
    $log="logo";
    $newfilename = $ImageDir . $log . $ext;
    rename($ImageName, $newfilename);

}}
###### 

        $tval="Your record has been updated.";
        header("location:tableupdates.php?cmbTable=Company+Info&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter all info before updating.";
        header("location:tableupdates.php?cmbTable=Company+Info&tval=$tval&redirect=$redirect");
      }
      break;
   }
 }
?>