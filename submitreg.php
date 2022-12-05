<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['user_id']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 6) & ($_SESSION['access_lvl'] != 7) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 2){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}
}

 $id = $_POST["id"];
 $idg = $_POST["idg"];
 $acctno = $_POST["acctno"];
 $type = $_POST["type"];
 $regdate = $_POST["regdate"];
 $fname = $_POST["fname"];
 $sname = $_POST["sname"];
 $acctofficer = $_POST["acctofficer"];
 $idtype = $_POST["idtype"];
 $idnumber = $_POST["idnumber"];
 $gender = $_POST["gender"];
 $age = $_POST["age"];
 $mstatus = $_POST["mstatus"];
 $email = $_POST["email"];
 $occupation = $_POST["occupation"];
 $employer = $_POST["employer"];
 $bvn = $_POST["bvn"];
 $officeaddress = $_POST["officeaddress"];
 $position = $_POST["position"];
 $contactno = $_POST["contactno"];
 $mobileno = $_POST["mobileno"];
 $homeaddress = $_POST["homeaddress"];
 $postaladdress = $_POST["postaladdress"];

 $nkin = $_POST["nkin"];
 $nkcontact = $_POST["nkcontact"];
 $relationship = $_POST["relationship"];
 $nkphone = $_POST["nkphone"];
 $status = $_POST["status"];
 $reason = $_POST["reason"];
 $closedate = $_POST["closedate"];

 $group = $_POST["group"];
 $brch = $_POST["brch"];
 $branch = $_POST["branch"];
 $customercategory = $_POST["customercategory"];
 $sms = $_POST["sms"];
 $emailalert = $_POST["emailalert"];

 $dob = $_POST["dob"];
 $vpremium = $_POST["vpremium"];
 $vmature = $_POST["vmature"];
 $durr = $_POST["durr"];
 $duedate = $_POST["duedate"];
################################################

 $gname = $_POST["gname"];

 $name1 = $_POST["name1"];
 $position1 = $_POST["position1"];
 $contactno1 = $_POST["contactno1"];
 $mobileno1 = $_POST["mobileno1"];
 $officeaddress1 = $_POST["officeaddress1"];
 $homeaddress1 = $_POST["homeaddress1"];
 $mstatus1 = $_POST["mstatus1"];
 $gender1 = $_POST["gender1"];
 $age1 = $_POST["age1"];
 $email1 = $_POST["email1"];
 $occupation1 = $_POST["occupation1"];
 $employer1 = $_POST["employer1"];
 $nkin1 = $_POST["nkin1"];
 $relationship1 = $_POST["relationship1"];
 $nkcontact1 = $_POST["nkcontact1"];

 $name2 = $_POST["name2"];
 $position2 = $_POST["position2"];
 $contactno2 = $_POST["contactno2"];
 $mobileno2 = $_POST["mobileno2"];
 $officeaddress2 = $_POST["officeaddress2"];
 $homeaddress2 = $_POST["homeaddress2"];
 $mstatus2 = $_POST["mstatus2"];
 $gender2 = $_POST["gender2"];
 $age2 = $_POST["age2"];
 $email2 = $_POST["email2"];
 $occupation2 = $_POST["occupation2"];
 $employer2 = $_POST["employer2"];
 $nkin2 = $_POST["nkin2"];
 $relationship2 = $_POST["relationship2"];
 $nkcontact2 = $_POST["nkcontact2"];

 $name3 = $_POST["name3"];
 $position3 = $_POST["position3"];
 $contactno3 = $_POST["contactno3"];
 $mobileno3 = $_POST["mobileno3"];
 $officeaddress3 = $_POST["officeaddress3"];
 $homeaddress3 = $_POST["homeaddress3"];
 $mstatus3 = $_POST["mstatus3"];
 $gender3 = $_POST["gender3"];
 $age3 = $_POST["age3"];
 $email3 = $_POST["email3"];
 $occupation3 = $_POST["occupation3"];
 $employer3 = $_POST["employer3"];
 $nkin3 = $_POST["nkin3"];
 $relationship3 = $_POST["relationship3"];
 $nkcontact3 = $_POST["nkcontact3"];

 $contrib = $_POST["contrib"];
 $passbk = $_POST["passbk"];

#echo $_POST['regdate'];
#echo date("Y-m-d",strtotime($regdate));

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($acctno) != "" && Trim($type) != "")
      {
        $rdate = $_POST['regdate'];
        list($day, $month, $year) = explode('-', $rdate);
        $regdate = $year . '-' . $month . '-' . $day;

        $rbdate = $_POST['dob'];
        list($dayb, $monthb, $yearb) = explode('-', $rbdate);
        $dob = $yearb . '-' . $monthb . '-' . $dayb;

        $rddate = $_POST['duedate'];
        list($dayd, $monthd, $yeard) = explode('-', $rddate);
        $duedate = $yeard . '-' . $monthd . '-' . $dayd;

        $query_update = "UPDATE `customer` SET `Account Number` = '$acctno',`Date Registered`='$regdate',`First Name`='$fname',`Surname`='$sname',`Account Type`='$type', `Age`='$age'
          ,`Marital status`='$mstatus',`Gender`='$gender',`Contact Number`='$contactno',`Home Address`='$homeaddress',`Next of Kin`='$nkin',`NKin Contact`='$nkcontact',`NK Phone`='$nkphone'
          ,`email alert`='$emailalert',`SMS`='$sms',`Position`='$position',`Occupation`='$occupation',`Postal Address`='$postaladdress',`Office Address`='$officeaddress',`Relationship`='$relationship',`Identification Type`='$idtype'
          ,`Identification Number`='$idnumber',`email`='$email',`Group`='$group',`Branch`='$branch',`Customer Category`='$customercategory',`Employer`='$employer',`Status`='$status',`Mobile Number`='$mobileno',`Account Officer`='$acctofficer'
          ,`Group Name`='$gname',`Name1`='$name1',`Position1`='$position1',`Contact Number1`='$contactno1',`Mobile Number1`='$mobileno1',`Office Address1`='$officeaddress1'
          ,`Home Address1`='$homeaddress1',`Marital status1`='$mstatus1',`Gender1`='$gender1',`Age1`='$age1',`email1`='$email1',`Occupation1`='$occupation1'
          ,`Employer1`='$employer1',`Next of Kin1`='$nkin1',`Relationship1`='$relationship1',`NKin Contact1`='$nkcontact1'
          ,`Name2`='$name2',`Position2`='$position2',`Contact Number2`='$contactno2',`Mobile Number2`='$mobileno2',`Office Address2`='$officeaddress2'
          ,`Home Address2`='$homeaddress2',`Marital status2`='$mstatus2',`Gender2`='$gender2',`Age2`='$age2',`email2`='$email2',`Occupation2`='$occupation2'
          ,`Employer2`='$employer2',`Next of Kin2`='$nkin2',`Relationship2`='$relationship2',`NKin Contact2`='$nkcontact2'
          ,`Name3`='$name3',`Position3`='$position3',`Contact Number3`='$contactno3',`Mobile Number3`='$mobileno3',`Office Address3`='$officeaddress3'
          ,`Home Address3`='$homeaddress3',`Marital status3`='$mstatus3',`Gender3`='$gender3',`Age3`='$age3',`email3`='$email3',`Occupation3`='$occupation3'
          ,`Employer3`='$employer3',`Next of Kin3`='$nkin3',`Relationship3`='$relationship3',`NKin Contact3`='$nkcontact3',`Date of Birth`='$dob',`BVN`='$bvn',`Contribution Charge`='$contrib',`Passbook Charge`='$passbk' WHERE `ID` = '$id'";

        $result_update = mysqli_query($conn,$query_update);
            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Customer Record','Modified Customer Record for: " . $acctno . ", " . $sname . "')";

            $result_update_Log = mysqli_query($conn,$query_update_Log);
            ###### 

if($group=="Group")
{
#######
if (!empty($_FILES['image_filename1']['name'])){
if (file_exists("images/pics/" . $_POST["id"] . "x1.jpg")==1)
{
   $ImageNam = "images/pics/" . $_POST["id"] . "x1.jpg";
   $newfilenam = "images/pics/" . date("Y-m-d") . "_" . $_POST["id"] . "x1.jpg";
   rename($ImageNam, $newfilenam);
}
   //make variables available
   $image_userid = $id;
   $image_tempname = $_FILES['image_filename1']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir ="images/pics/";
   $ImageName = $ImageDir . $image_tempname;
   if (move_uploaded_file($_FILES['image_filename1']['tmp_name'],$ImageName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName);
 
    $ext = ".jpg";

    $newfilename = $ImageDir . $_POST["id"] . "x1" . $ext;
    rename($ImageName, $newfilename);
  }
}

if (!empty($_FILES['sign_filename1']['name'])){
if (file_exists("images/sign/" . $_POST["id"] . "x1.jpg")==1)
{
   $signNam = "images/sign/" . $_POST["id"] . "x1.jpg";
   $newsignnam = "images/sign/" . date("Y-m-d") . "_" . $_POST["id"] . "x1.jpg";
   rename($signNam, $newsignnam);
}
   //make variables available
   $sign_userid = $id;
   $sign_tempname = $_FILES['sign_filename1']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir ="images/sign/";
   $signName = $signDir . $sign_tempname;
   if (move_uploaded_file($_FILES['sign_filename1']['tmp_name'],$signName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName);
 
    $ext = ".jpg";

    $newsignname = $signDir . $_POST["id"] . "x1" . $ext;
    rename($signName, $newsignname);
  }
}
######
#2nd
#######
if (!empty($_FILES['image_filename2']['name'])){
if (file_exists("images/pics/" . $_POST["id"] . "x2.jpg")==1)
{
   $ImageNam2 = "images/pics/" . $_POST["id"] . "x2.jpg";
   $newfilenam2 = "images/pics/" . date("Y-m-d") . "_" . $_POST["id"] . "x2.jpg";
   rename($ImageNam2, $newfilenam2);
}
   //make variables available
   $image_userid2 = $id;
   $image_tempname2 = $_FILES['image_filename2']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir2 ="images/pics/";
   $ImageName2 = $ImageDir2 . $image_tempname2;
   if (move_uploaded_file($_FILES['image_filename2']['tmp_name'],$ImageName2)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName2);
 
    $ext = ".jpg";

    $newfilename2 = $ImageDir2 . $_POST["id"] . "x2" . $ext;
    rename($ImageName2, $newfilename2);
  }
}

if (!empty($_FILES['sign_filename2']['name'])){
if (file_exists("images/sign/" . $_POST["id"] . "x2.jpg")==1)
{
   $signNam2 = "images/sign/" . $_POST["id"] . "x2.jpg";
   $newsignnam2 = "images/sign/" . date("Y-m-d") . "_" . $_POST["id"] . "x2.jpg";
   rename($signNam2, $newsignnam2);
}
   //make variables available
   $sign_userid2 = $id;
   $sign_tempname2 = $_FILES['sign_filename2']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir2 ="images/sign/";
   $signName2 = $signDir2 . $sign_tempname2;
   if (move_uploaded_file($_FILES['sign_filename2']['tmp_name'],$signName2)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName2);
 
    $ext = ".jpg";

    $newsignname2 = $signDir2 . $_POST["id"] . "x2" . $ext;
    rename($signName2, $newsignname2);
  }
}
######
#3rd
#######
if (!empty($_FILES['image_filename3']['name'])){
if (file_exists("images/pics/" . $_POST["id"] . "x3.jpg")==1)
{
   $ImageNam3 = "images/pics/" . $_POST["id"] . "x3.jpg";
   $newfilenam3 = "images/pics/" . date("Y-m-d") . "_" . $_POST["id"] . "x3.jpg";
   rename($ImageNam3, $newfilenam3);
}
   //make variables available
   $image_userid3 = $id;
   $image_tempname3 = $_FILES['image_filename3']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir3 ="images/pics/";
   $ImageName3 = $ImageDir3 . $image_tempname3;
   if (move_uploaded_file($_FILES['image_filename3']['tmp_name'],$ImageName3)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName3);
 
    $ext = ".jpg";

    $newfilename3 = $ImageDir3 . $_POST["id"] . "x3" . $ext;
    rename($ImageName3, $newfilename3);
  }
}

if (!empty($_FILES['sign_filename3']['name'])){
if (file_exists("images/sign/" . $_POST["id"] . "x3.jpg")==1)
{
   $signNam3 = "images/sign/" . $_POST["id"] . "x3.jpg";
   $newsignnam3 = "images/sign/" . date("Y-m-d") . "_" . $_POST["id"] . "x3.jpg";
   rename($signNam3, $newsignnam3);
}
   //make variables available
   $sign_userid3 = $id;
   $sign_tempname3 = $_FILES['sign_filename3']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir3 ="images/sign/";
   $signName3 = $signDir3 . $sign_tempname3;
   if (move_uploaded_file($_FILES['sign_filename3']['tmp_name'],$signName3)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName3);
 
    $ext = ".jpg";

    $newsignname3 = $signDir3 . $_POST["id"] . "x3" . $ext;
    rename($signName3, $newsignname3);
  }
}
######

} else {
#######
if (!empty($_FILES['image_filename']['name'])){
if (file_exists("images/pics/" . $_POST["id"] . ".jpg")==1)
{
   $ImageNam = "images/pics/" . $_POST["id"] . ".jpg";
   $newfilenam = "images/pics/" . date("Y-m-d") . "_" . $_POST["id"] . ".jpg";
   rename($ImageNam, $newfilenam);
}
   //make variables available
   $image_userid = $id;
   $image_tempname = $_FILES['image_filename']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir ="images/pics/";
   $ImageName = $ImageDir . $image_tempname;
   if (move_uploaded_file($_FILES['image_filename']['tmp_name'],$ImageName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName);
 
    $ext = ".jpg";

    $newfilename = $ImageDir . $_POST["id"] . $ext;
    rename($ImageName, $newfilename);

}}
###### 

#######
if (!empty($_FILES['sign_filename']['name'])){
if (file_exists("images/sign/" . $_POST["id"] . ".jpg")==1)
{
   $signNam = "images/sign/" . $_POST["id"] . ".jpg";
   $newsignnam = "images/sign/" . date("Y-m-d") . "_" . $_POST["id"] . ".jpg";
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

    $newsignname = $signDir . $_POST["id"] . $ext;
    rename($signName, $newsignname);

}}
###### 
}

        $tval="Your record has been updated.";
        header("location:register.php?acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Details before updating.";
        header("location:register.php?acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($acctno) != "" && Trim($type) != "")
      { 
        $rdate = $_POST['regdate'];
        list($day, $month, $year) = explode('-', $rdate);
        $regdate = $year . '-' . $month . '-' . $day;

        $rbdate = $_POST['dob'];
        list($dayb, $monthb, $yearb) = explode('-', $rbdate);
        $dob = $yearb . '-' . $monthb . '-' . $dayb;

        $rddate = $_POST['duedate'];
        list($dayd, $monthd, $yeard) = explode('-', $rddate);
        $duedate = $yeard . '-' . $monthd . '-' . $dayd;

        if(empty($status)) { $status='Active'; }

        $sql = "SELECT * FROM `customer` Where `Account Number`='$acctno'";
        $result = mysqli_query($conn,$sql);
        $totrows  = mysqli_num_rows($result);
        if ($totrows==0)
        { 
        $query_insert = "Insert into `customer` (`Status`,`Account Number`,`Date Registered`,`First Name`,`Surname`,`Account Type`, `Age`
          ,`Marital status`,`Gender`,`Contact Number`,`Home Address`,`Next of Kin`,`NKin Contact`,`NK Phone`,`Position`,`Occupation`
          ,`Postal Address`,`Office Address`,`Relationship`,`Identification Type`,`Identification Number`,`email`,`Employer`,`Mobile Number`,`Account Officer`,`Group`,`Branch`,`Customer Category`
          ,`Group Name`,`Name1`,`Position1`,`Contact Number1`,`Mobile Number1`,`Office Address1`,`Home Address1`,`Marital status1`,`Gender1`,`Age1`,`email1`,`Occupation1`
          ,`Employer1`,`Next of Kin1`,`Relationship1`,`NKin Contact1`,`Name2`,`Position2`,`Contact Number2`,`Mobile Number2`,`Office Address2`
          ,`Home Address2`,`Marital status2`,`Gender2`,`Age2`,`email2`,`Occupation2`,`Employer2`,`Next of Kin2`,`Relationship2`,`NKin Contact2`
          ,`Name3`,`Position3`,`Contact Number3`,`Mobile Number3`,`Office Address3`,`Home Address3`,`Marital status3`,`Gender3`, `Age3`,`email3`,`Occupation3`
          ,`Employer3`,`Next of Kin3`,`Relationship3`,`NKin Contact3`,`Date of Birth`,`SMS`,`email alert`,`BVN`,`Contribution Charge`,`Passbook Charge`) 
        VALUES ('$status','$acctno','$regdate','$fname','$sname','$type', '$age'
          ,'$mstatus','$gender','$contactno','$homeaddress','$nkin','$nkcontact','$nkphone','$position','$occupation'
          ,'$postaladdress','$officeaddress','$relationship','$idtype','$idnumber','$email','$employer','$mobileno','$acctofficer','$group','$branch','$customercategory'
          ,'$gname','$name1','$position1','$contactno1','$mobileno1','$officeaddress1', '$homeaddress1','$mstatus1','$gender1','$age1','$email1','$occupation1'
          ,'$employer1','$nkin1','$relationship1','$nkcontact1','$name2','$position2','$contactno2','$mobileno2','$officeaddress2'
          ,'$homeaddress2','$mstatus2','$gender2','$age2','$email2','$occupation2','$employer2','$nkin2','$relationship2','$nkcontact2'
          ,'$name3','$position3','$contactno3','$mobileno3','$officeaddress3', '$homeaddress3','$mstatus3','$gender3','$age3','$email3','$occupation3'
          ,'$employer3','$nkin3','$relationship3','$nkcontact3','$dob','$sms','$emailalert','$bvn','$contrib','$passbk')";

        $result_insert = mysqli_query($conn,$query_insert);

#################################################################
if ($passbk>0)
{
        $query_insertP = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
                                       VALUES ('$passbk','Passbook Charge','$regdate','','$acctno','" . ucfirst($_SESSION['name']) . "','Income')";
        $result_insertP = mysqli_query($conn,$query_insertP);

        $sqlP="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
        $resultP = mysqli_query($conn,$sqlP) or die('Could not look up user data; ' . mysqli_error());
        $rowP = mysqli_fetch_array($resultP); 

        $balp= $rowP['Balance']; 
         $balP=$balp-$passbk;
         $query_insertP1 = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctno','$passbk','Auto Transaction','','" . ucfirst($_SESSION['name']) . "','$regdate','Withdrawal','Passbook Charge','$balP')";
         $result_insertP1 = mysqli_query($conn,$query_insertP1);
}
if ($contrib>0)
{
        $query_insertC = "Insert into `sundry` (`Amount`,`Note`,`Date`,`Source`,`Account Number`,`Officer`,`Type`) 
                                       VALUES ('$contrib','Contribution Charge','$regdate','','$acctno','" . ucfirst($_SESSION['name']) . "','Income')";
        $result_insertC = mysqli_query($conn,$query_insertC);

        $sqlC="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
        $resultC = mysqli_query($conn,$sqlC) or die('Could not look up user data; ' . mysqli_error());
        $rowC = mysqli_fetch_array($resultC); 

        $balc= $rowC['Balance']; 
         $balC=$balc-$contrib;
         $query_insertC1 = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Transactor`,`Transactor Contact`,`Officer`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
               VALUES ('$acctno','$contrib','Auto Transaction','','" . ucfirst($_SESSION['name']) . "','$regdate','Withdrawal','Contribution Charge','$balC')";
         $result_insertC1 = mysqli_query($conn,$query_insertC1);
}
#################################################################
            #######
            $sqlm = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $resultm = mysqli_query($conn,$sqlm);
            $rows = mysqli_fetch_array($resultm);

            $query_insert_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Customer Record','Added Customer Record for: " . $acctno . ", " . $sname . "')";

            $result_insert_Log = mysqli_query($conn,$query_insert_Log);
            ###### 


#######

$sqlx = "SELECT `ID` FROM `customer` Where `Account Number`='$acctno'";
$resultx = mysqli_query($conn,$sqlx);
$rowx = mysqli_fetch_array($resultx);

if($group=="Group")
{
#######
if (!empty($_FILES['image_filename1']['name'])){
if (file_exists("images/pics/" . $rowx['ID'] . "x1.jpg")==1)
{
   $ImageNam = "images/pics/" . $rowx['ID'] . "x1.jpg";
   $newfilenam = "images/pics/" . date("Y-m-d") . "_" . $rowx['ID'] . "x1.jpg";
   rename($ImageNam, $newfilenam);
}
   //make variables available
   $image_userid = $id;
   $image_tempname = $_FILES['image_filename1']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir ="images/pics/";
   $ImageName = $ImageDir . $image_tempname;
   if (move_uploaded_file($_FILES['image_filename1']['tmp_name'],$ImageName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName);
 
    $ext = ".jpg";

    $newfilename = $ImageDir . $rowx['ID'] . "x1" . $ext;
    rename($ImageName, $newfilename);
  }
}

if (!empty($_FILES['sign_filename1']['name'])){
if (file_exists("images/sign/" . $rowx['ID'] . "x1.jpg")==1)
{
   $signNam = "images/sign/" . $rowx['ID'] . "x1.jpg";
   $newsignnam = "images/sign/" . date("Y-m-d") . "_" . $rowx['ID'] . "x1.jpg";
   rename($signNam, $newsignnam);
}
   //make variables available
   $sign_userid = $id;
   $sign_tempname = $_FILES['sign_filename1']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir ="images/sign/";
   $signName = $signDir . $sign_tempname;
   if (move_uploaded_file($_FILES['sign_filename1']['tmp_name'],$signName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName);
 
    $ext = ".jpg";

    $newsignname = $signDir . $rowx['ID'] . "x1" . $ext;
    rename($signName, $newsignname);
  }
}
######
#2nd
#######
if (!empty($_FILES['image_filename2']['name'])){
if (file_exists("images/pics/" . $rowx['ID'] . "x2.jpg")==1)
{
   $ImageNam2 = "images/pics/" . $rowx['ID'] . "x2.jpg";
   $newfilenam2 = "images/pics/" . date("Y-m-d") . "_" . $rowx['ID'] . "x2.jpg";
   rename($ImageNam2, $newfilenam2);
}
   //make variables available
   $image_userid2 = $id;
   $image_tempname2 = $_FILES['image_filename2']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir2 ="images/pics/";
   $ImageName2 = $ImageDir2 . $image_tempname2;
   if (move_uploaded_file($_FILES['image_filename2']['tmp_name'],$ImageName2)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName2);
 
    $ext = ".jpg";

    $newfilename2 = $ImageDir2 . $rowx['ID'] . "x2" . $ext;
    rename($ImageName2, $newfilename2);
  }
}

if (!empty($_FILES['sign_filename2']['name'])){
if (file_exists("images/sign/" . $rowx['ID'] . "x2.jpg")==1)
{
   $signNam2 = "images/sign/" . $rowx['ID'] . "x2.jpg";
   $newsignnam2 = "images/sign/" . date("Y-m-d") . "_" . $rowx['ID'] . "x2.jpg";
   rename($signNam2, $newsignnam2);
}
   //make variables available
   $sign_userid2 = $id;
   $sign_tempname2 = $_FILES['sign_filename2']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir2 ="images/sign/";
   $signName2 = $signDir2 . $sign_tempname2;
   if (move_uploaded_file($_FILES['sign_filename2']['tmp_name'],$signName2)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName2);
 
    $ext = ".jpg";

    $newsignname2 = $signDir2 . $rowx['ID'] . "x2" . $ext;
    rename($signName2, $newsignname2);
  }
}
######
#3rd
#######
if (!empty($_FILES['image_filename3']['name'])){
if (file_exists("images/pics/" . $rowx['ID'] . "x3.jpg")==1)
{
   $ImageNam3 = "images/pics/" . $rowx['ID'] . "x3.jpg";
   $newfilenam3 = "images/pics/" . date("Y-m-d") . "_" . $rowx['ID'] . "x3.jpg";
   rename($ImageNam3, $newfilenam3);
}
   //make variables available
   $image_userid3 = $id;
   $image_tempname3 = $_FILES['image_filename3']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir3 ="images/pics/";
   $ImageName3 = $ImageDir3 . $image_tempname3;
   if (move_uploaded_file($_FILES['image_filename3']['tmp_name'],$ImageName3)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName3);
 
    $ext = ".jpg";

    $newfilename3 = $ImageDir3 . $rowx['ID'] . "x3" . $ext;
    rename($ImageName3, $newfilename3);
  }
}

if (!empty($_FILES['sign_filename3']['name'])){
if (file_exists("images/sign/" . $rowx['ID'] . "x3.jpg")==1)
{
   $signNam3 = "images/sign/" . $rowx['ID'] . "x3.jpg";
   $newsignnam3 = "images/sign/" . date("Y-m-d") . "_" . $rowx['ID'] . "x3.jpg";
   rename($signNam3, $newsignnam3);
}
   //make variables available
   $sign_userid3 = $id;
   $sign_tempname3 = $_FILES['sign_filename3']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir3 ="images/sign/";
   $signName3 = $signDir3 . $sign_tempname3;
   if (move_uploaded_file($_FILES['sign_filename3']['tmp_name'],$signName3)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName3);
 
    $ext = ".jpg";

    $newsignname3 = $signDir3 . $rowx['ID'] . "x3" . $ext;
    rename($signName3, $newsignname3);
  }
}
######

} else {
if (!empty($_FILES['image_filename']['name'])){
if (file_exists("images/pics/" . $rowx['ID'] . ".jpg")==1)
{
   $ImageNam = "images/pics/" . $rowx['ID'] . ".jpg";
   $newfilenam = "images/pics/old_" . $rowx['ID'] . ".jpg";
   rename($ImageNam, $newfilenam);
}
   //make variables available
   $image_userid = $id;
   $image_tempname = $_FILES['image_filename']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir ="images/pics/";
   $ImageName = $ImageDir . $image_tempname;
   if (move_uploaded_file($_FILES['image_filename']['tmp_name'],$ImageName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName);
 
    $ext = ".jpg";

    $newfilename = $ImageDir . $rowx['ID'] . $ext;
    rename($ImageName, $newfilename);

}}
###### 

#######
if (!empty($_FILES['sign_filename']['name'])){
if (file_exists("images/sign/" . $rowx['ID'] . ".jpg")==1)
{
   $signNam = "images/sign/" . $rowx['ID'] . ".jpg";
   $newsignnam = "images/sign/" . date("Y-m-d") . "_" . $rowx['ID'] . ".jpg";
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

    $newsignname = $signDir . $rowx['ID'] . $ext;
    rename($signName, $newsignname);

}}
###### 
}
if ($sms==1)
{
$msalt="Congratulations! You just opened IBBDS C-Thrift Account. Your account number is " . $acctno . ". Thank you for choosing IBBDs";
########SMSLIVE247#######
/* Variables with the values to be sent. */

$owneremail="dauda.bashorun@gmail.com";
$subacct="IBBDS CONSULTING"; /*IBBDs Consulting*/
$subacctpwd="07053737888"; /*07039220512 */
$sendto=$contactno; /* destination number */
$sender="IBBDS"; /* sender id iBBDs Co-Thrift*/
$message=$msalt;
/* message to be sent */

$url = "http://www.smslive247.com/http/index.aspx?"
. "cmd=sendquickmsg"
. "&owneremail=" . UrlEncode($owneremail)
. "&subacct=" . UrlEncode($subacct)
. "&subacctpwd=" . UrlEncode($subacctpwd)
. "&sendto=" . UrlEncode($sendto)
. "&message=" . UrlEncode($message)
. "&sender=" . UrlEncode($sender);
/* call the URL */
$time_start = microtime(true);
if ($f = @fopen($url, "r"))
{
$answer = fgets($f, 255);
#echo "[$answer]";
}
else
{
#echo "Error: URL could not be opened.";
}
#   echo "<br>"  ;
$time_end = microtime(true);
$time = $time_end - $time_start;

#echo "Finished in $time seconds\n";
##########################
}

        $tval="Your record has been saved.";
        header("location:register.php?acctno=$acctno&tval=$tval&redirect=$redirect");
       } else { 
        $tval="This account number has been registered";
        header("location:register.php?tval=$tval&redirect=$redirect");
       }
      }
      else
      {
        $tval="Please enter details before saving.";
        header("location:register.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Remove Pix':
      {
        if (file_exists("images/pics/" . $_POST["id"] . ".jpg")==1)
        {
          unlink("images/pics/" . $_POST["id"] . ".jpg");
        }
        header("location:register.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Remove Signature':
      {
        if (file_exists("images/sign/" . $_POST["id"] . ".jpg")==1)
        {
          unlink("images/sign/" . $_POST["id"] . ".jpg");
        }
        header("location:register.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM `customer` WHERE `ID` = '$id'";
       $result_delete = mysqli_query($conn,$query_delete);          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_delete_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Customer Record','Deleted Customer Record for: " . $acctno . ", " . $sname . "')";

            $result_delete_Log = mysqli_query($conn,$query_delete_Log);
            ###### 

        $tval="Your record has been deleted.";
        header("location:register.php?id=$id&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Close Account':
      if (Trim($closedate) != "" && Trim($acctno) != "" && Trim($reason) != "")
      {
        $rdate = $_POST['closedate'];
        list($day, $month, $year) = explode('-', $rdate);
        $closedate = $year . '-' . $month . '-' . $day;

        $query_update = "UPDATE `customer` SET `Closure Date` = '$closedate',`Closure Reason`='$reason',`Status`='Closed' WHERE `ID` = '$id'";

        $result_update = mysqli_query($conn,$query_update);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysqli_query($conn,$sql);
            $rows = mysqli_fetch_array($result);

            $query_update_Log = "Insert into `monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Customer Record','Modified Customer Record for: " . $acctno . ", " . $sname . "')";

            $result_update_Log = mysqli_query($conn,$query_update_Log);
            ###### 

#######
if (!empty($_FILES['sign_filename']['name'])){
if (file_exists("images/sign/cl_" . $_POST["id"] . ".jpg")==1)
{
   $signNam = "images/sign/cl_" . $_POST["id"] . ".jpg";
   $newsignnam = "images/sign/cl_" . date("Y-m-d") . "_" . $_POST["id"] . ".jpg";
   rename($signNam, $newsignnam);
}
   //make variables available
   $sign_userid = $id;
   $sign_tempname = $_FILES['sign_filename']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir ="images/sign/cl_";
   $signName = $signDir . $sign_tempname;
   if (move_uploaded_file($_FILES['sign_filename']['tmp_name'],$signName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName);
 
    $ext = ".jpg";

    $newsignname = $signDir . $_POST["id"] . $ext;
    rename($signName, $newsignname);

}}
###### 
        $tval="Account Closed.";
        header("location:closure.php?tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Details before closing.";
        header("location:closure.php?acctno=$acctno&tval=$tval&redirect=$redirect");
      }
      break;
##################################################################################

     case 'Modify':
      if (Trim($acctno) != "" && Trim($name1) != "")
      {
        $query_update = "UPDATE `group` SET `Account Number` = '$acctno'
          ,`Group Name`='$gname',`Name`='$name1',`Position`='$position1',`Contact Number`='$contactno1',`Mobile Number`='$mobileno1',`Office Address`='$officeaddress1'
          ,`Home Address`='$homeaddress1',`Marital Status`='$mstatus1',`Gender`='$gender1',`Age`='$age1',`email`='$email1',`Occupation`='$occupation1'
          ,`Employer`='$employer1',`Next of Kin`='$nkin1',`Relationship`='$relationship1',`NKin Contact`='$nkcontact1' WHERE `ID` = '$idg'";

        $result_update = mysqli_query($conn,$query_update);

#######
if (!empty($_FILES['image_filename1']['name'])){
if (file_exists("images/pics/" . $_POST["id"] . "_" . $idg . ".jpg")==1)
{
   $ImageNam = "images/pics/" . $_POST["id"] . "_" . $idg . ".jpg";
   $newfilenam = "images/pics/" . date("Y-m-d") . "_" . $_POST["id"] . "_" . $idg . ".jpg";
   rename($ImageNam, $newfilenam);
}
   //make variables available
   $image_userid = $id;
   $image_tempname = $_FILES['image_filename1']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir ="images/pics/";
   $ImageName = $ImageDir . $image_tempname;
   if (move_uploaded_file($_FILES['image_filename1']['tmp_name'],$ImageName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName);
 
    $ext = ".jpg";

    $newfilename = $ImageDir . $_POST["id"] . "_" . $idg . $ext;
    rename($ImageName, $newfilename);
  }
}

if (!empty($_FILES['sign_filename1']['name'])){
if (file_exists("images/sign/" . $_POST["id"] . "_" . $idg . ".jpg")==1)
{
   $signNam = "images/sign/" . $_POST["id"] . "_" . $idg . ".jpg";
   $newsignnam = "images/sign/" . date("Y-m-d") . "_" . $_POST["id"] . "_" . $idg . ".jpg";
   rename($signNam, $newsignnam);
}
   //make variables available
   $sign_userid = $id;
   $sign_tempname = $_FILES['sign_filename1']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir ="images/sign/";
   $signName = $signDir . $sign_tempname;
   if (move_uploaded_file($_FILES['sign_filename1']['tmp_name'],$signName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName);
 
    $ext = ".jpg";

    $newsignname = $signDir . $_POST["id"] . "_" . $idg . $ext;
    rename($signName, $newsignname);
  }
}
######


        $tval="Your record has been modified.";
        header("location:register.php?grp=$group&brch=$brch&acctno=$acctno&tvalg=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Details before modifying.";
        header("location:register.php?grp=$group&brch=$brch&idgx=1&idg=$idg&acctno=$acctno&tvalg=$tval&redirect=$redirect");
      }
      break;
     case 'Add':
      if (Trim($acctno) != "" && Trim($name1) != "")
      { 
        
        $query_insert = "Insert into `group` (`Account Number`
          ,`Group Name`,`Name`,`Position`,`Contact Number`,`Mobile Number`,`Office Address`,`Home Address`,`Marital Status`,`Gender`,`Age`,`email`,`Occupation`
          ,`Employer`,`Next of Kin`,`Relationship`,`NKin Contact`) 
        VALUES ('$acctno'
          ,'$gname','$name1','$position1','$contactno1','$mobileno1','$officeaddress1', '$homeaddress1','$mstatus1','$gender1','$age1','$email1','$occupation1'
          ,'$employer1','$nkin1','$relationship1','$nkcontact1')";

        $result_insert = mysqli_query($conn,$query_insert);

#######

$sqlx = "SELECT `ID` FROM `customer` Where `Account Number`='$acctno'";
$resultx = mysqli_query($conn,$sqlx);
$rowx = mysqli_fetch_array($resultx);

#######
if (!empty($_FILES['image_filename1']['name'])){
if (file_exists("images/pics/" . $rowx['ID'] . "_" . $idg . ".jpg")==1)
{
   $ImageNam = "images/pics/" . $rowx['ID'] . "_" . $idg . ".jpg";
   $newfilenam = "images/pics/" . date("Y-m-d") . "_" . $rowx['ID'] . "_" . $idg . ".jpg";
   rename($ImageNam, $newfilenam);
}
   //make variables available
   $image_userid = $id;
   $image_tempname = $_FILES['image_filename1']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $ImageDir ="images/pics/";
   $ImageName = $ImageDir . $image_tempname;
   if (move_uploaded_file($_FILES['image_filename1']['tmp_name'],$ImageName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($ImageName);
 
    $ext = ".jpg";

    $newfilename = $ImageDir . $rowx['ID'] . "_" . $idg . $ext;
    rename($ImageName, $newfilename);
  }
}

if (!empty($_FILES['sign_filename1']['name'])){
if (file_exists("images/sign/" . $rowx['ID'] . "_" . $idg . ".jpg")==1)
{
   $signNam = "images/sign/" . $rowx['ID'] . "_" . $idg . ".jpg";
   $newsignnam = "images/sign/" . date("Y-m-d") . "_" . $rowx['ID'] . "_" . $idg . ".jpg";
   rename($signNam, $newsignnam);
}
   //make variables available
   $sign_userid = $id;
   $sign_tempname = $_FILES['sign_filename1']['name'];
   $today = date("Y-m-d");

   //upload image and check for image type

   $signDir ="images/sign/";
   $signName = $signDir . $sign_tempname;
   if (move_uploaded_file($_FILES['sign_filename1']['tmp_name'],$signName)) 
   {
    //get info about the image being uploaded
    list($width, $height, $type, $attr) = getimagesize($signName);
 
    $ext = ".jpg";

    $newsignname = $signDir . $rowx['ID'] . "_" . $idg . $ext;
    rename($signName, $newsignname);
  }
}
######

        $tval="Your record has been saved.";
        header("location:register.php?grp=$group&brch=$brch&acctno=$acctno&tvalg=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter details before saving.";
        header("location:register.php?acctno=$acctno&grp=$group&brch=$brch&id=$id&idg=$idg&idgx=1&tvalg=$tval&redirect=$redirect");
      }
      break;
     case 'Remove':
      {
       $query_delete = "DELETE FROM `group` WHERE `ID` = '$idg'";
       $result_delete = mysqli_query($conn,$query_delete);          

        $tval="Your record has been deleted.";
        header("location:register.php?acctno=$acctno&grp=$group&brch=$brch&id=$id&tvalg=$tval&redirect=$redirect");
      }
      break;

     case 'Cancel':
      {
        header("location:register.php?acctno=$acctno&grp=$group&brch=$brch&redirect=$redirect");
      }
      break;
##################################################################################


     case 'Continue':
      {
        header("location:register.php?grp=$group&brch=$brch&redirect=$redirect");
      }
      break;
   }
 }
?>