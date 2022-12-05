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
 $fname = $_POST["fname"];
 $sname = $_POST["sname"];
 $mname = $_POST["mname"];
 $oname = $_POST["oname"];
 $mstatus = $_POST["mstatus"];
 $gender = $_POST["gender"];
 $dob = $_POST["dob"];
 $mobileno = $_POST["mobileno"];
 $contactno = $_POST["contactno"];

#############Stage 2
 $idtype = $_POST["idtype"];
 $email = $_POST["email"];
 $children = $_POST["children"];
 $household = $_POST["household"];

#############Stage 3
 $restatus = $_POST["restatus"];
 $address = $_POST["address"];
 $prevaddress = $_POST["prevaddress"];
 $homeduration = $_POST["homeduration"];
 $lga = $_POST["lga"];
 $state = $_POST["state"];
 $landmark = $_POST["landmark"];
 $busstop = $_POST["busstop"];
 $monthlyexp = $_POST["monthlyexp"];

#############Stage 4
 $income = $_POST["income"];
 $otherincome = $_POST["otherincome"];
 $paydate = $_POST["paydate"];
 $runningloan = $_POST["runningloan"];
 $otherloans = $_POST["otherloans"];
 $repayment = $_POST["repayment"];

#############Stage 5
 $employment = $_POST["employment"];
 $employer = $_POST["employer"];
 $empdate = $_POST["empdate"];
 $staffid = $_POST["staffid"];
 $jobtitle = $_POST["jobtitle"];
 $empphone = $_POST["empphone"];
 $officeaddress = $_POST["officeaddress"];
 $officelga = $_POST["officelga"];
 $officestate = $_POST["officestate"];

#############Stage 6
 $officialemail = $_POST["officialemail"];
 $industrytype = $_POST["industrytype"];
 $prevdur = $_POST["prevdur"];
 $pastemployers = $_POST["pastemployers"];
 $edulevel = $_POST["edulevel"];
 $institution = $_POST["institution"];

#############Stage 7
 $nkname = $_POST["nkname"];
 $nkrelationship = $_POST["nkrelationship"];
 $nkphone = $_POST["nkphone"];
 $nkaddress = $_POST["nkaddress"];
 $nklga = $_POST["nklga"];
 $nkstate = $_POST["nkstate"];
 $nkemail = $_POST["nkemail"];
 $nkemployer = $_POST["nkemployer"];
 $nkjobtitle = $_POST["nkjobtitle"];

#############Stage 8
 $bank = $_POST["bank"];
 $accountnum = $_POST["accountnum"];
 $accountname = $_POST["accountname"];
 $bvn = $_POST["bvn"];
 $accounttype = $_POST["accounttype"];
 $branch = $_POST["branch"];
 $loanamount = $_POST["loanamount"];
 $tenor = $_POST["tenor"];
 $repayment = $_POST["repayment"];
 $purpose = $_POST["purpose"];

#############Stage 9
 $authorize = $_POST["authorize"];
 $terms = $_POST["terms"];
 $dat=date('Y-m-d');

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Proceed to Stage 2 >>':
      if ($_SESSION['stage']==1)
      {
        $_SESSION['stage']=2;


        $query_insert = "Insert into `lease application` (`First Name`, `Surname`, `Middle Name`, `Maiden Name`, `Marital Status`,`Gender`, `DoB`, `Mobile Number`,`Contact Number`,`Application Date`,`Status`) 
        VALUES ('$fname', '$sname', '$mname', '$oname', '$mstatus','$gender', '$dob', '$mobileno','$contactno','$dat','Pending')";
        $result_insert = mysqli_query($conn,$query_insert);

        $sql="SELECT `ID` FROM `lease application` WHERE `First Name`='$fname' and `Surname`='$sname' and `Mobile Number`='$mobileno' order by `ID` desc";
        $result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
        $row = mysqli_fetch_array($result);

        $_SESSION['idx']=$row['ID'];
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
####
     case '<< Return to Stage 1':
      if ($_SESSION['stage']==2)
      {
        $_SESSION['stage']=1;

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;

     case 'Proceed to Stage 3 >>':
      if ($_SESSION['stage']==2)
      {
###############################################
require_once('smtp_validateEmail.class.php');

// the email to validate
#$email = 'dejigegs@waltergates.com';
// an optional sender
$sender = 'dejigegs@gmail.com';
// instantiate the class
$SMTP_Validator = new SMTP_validateEmail();
// turn on debugging if you want to view the SMTP transaction
$SMTP_Validator->debug = false;
// do the validation
$results = $SMTP_Validator->validate(array($email), $sender);
// view results
#echo $email.' '.($results[$email] ? 'Exists' : 'does not Exist')."\n";

// send email? 
if ($results[$email]) 
{

        $_SESSION['stage']=3;

        $query_update = "UPDATE `lease application` SET `Identification Type`='$idtype',`email`='$email',`Children`='$children',`Household`='$household' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
} else {
        $_SESSION['stage']=2;

        $_SESSION['idx']=$id;
	$tval= '...The email addresses you entered does not Exist';
        header("location:leaseapp.php?tval=$tval&&redirect=$redirect");
}
#####################################

      }
      break;
####
     case '<< Return to Stage 2':
      if ($_SESSION['stage']==3)
      {
        $_SESSION['stage']=2;

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;

     case 'Proceed to Stage 4 >>':
      if ($_SESSION['stage']==3)
      {
        $_SESSION['stage']=4;

        $query_update = "UPDATE `lease application` SET `Residential Status`='$restatus',`Address`='$address',`Previous Address`='$prevaddress',`Home Duration`='$homeduration',
         `LGA`='$lga',`State`='$state',`Landmark`='$landmark',`Bus Stop`='$busstop',`Monthly Expenses`='$monthlyexp' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
####
     case '<< Return to Stage 3':
      if ($_SESSION['stage']==4)
      {
        $_SESSION['stage']=3;

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
     case 'Proceed to Stage 5 >>':
      if ($_SESSION['stage']==4)
      {
        $_SESSION['stage']=5;

        $query_update = "UPDATE `lease application` SET `Income`='$income',`Other Income`='$otherincome',`Pay Date`='$paydate',`Running Loan`='$runningloan',`Other Loans`='$otherloans',
          `Monthly Repayment`='$repayment' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
#####
     case '<< Return to Stage 4':
      if ($_SESSION['stage']==5)
      {
        $_SESSION['stage']=4;

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
     case 'Proceed to Stage 6 >>':
      if ($_SESSION['stage']==5)
      {
        $_SESSION['stage']=6;

        $query_update = "UPDATE `lease application` SET `Employment Type`='$employment', `Current Employer`='$employer',`Employment Date`='$empdate',`Staff ID`='$staffid',`Job Title`='$jobtitle',`Employer Phone`='$empphone',`Office Address`='$officeaddress',
         `Office LGA`='$officelga',`Office State`='$officestate' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
#####
     case '<< Return to Stage 5':
      if ($_SESSION['stage']==6)
      {
        $_SESSION['stage']=5;

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
     case 'Proceed to Stage 7 >>':
      if ($_SESSION['stage']==6)
      {
        $_SESSION['stage']=7;

        $query_update = "UPDATE `lease application` SET `Official Email`='$officialemail',`Industry Type`='$industrytype',`Previous Duration`='$prevdur',`Past Employers`='$pastemployers',`Education Level`='$edulevel',`Institution`='$institution' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
#####
     case '<< Return to Stage 6':
      if ($_SESSION['stage']==7)
      {
        $_SESSION['stage']=6;

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
     case 'Proceed to Stage 8 >>':
      if ($_SESSION['stage']==7)
      {
        $_SESSION['stage']=8;

        $query_update = "UPDATE `lease application` SET `NK Name`='$nkname',`NK Relationship`='$nkrelationship',`NK Phone`='$nkphone',`NK Address`='$nkaddress', `NK LGA`='$nklga', `NK State`='$nkstate', `NK email`='$nkemail',`NK Employer`='$nkemployer', `NK Job Title`='$nkjobtitle' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
#####
     case '<< Return to Stage 7':
      if ($_SESSION['stage']==8)
      {
        $_SESSION['stage']=7;

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
     case 'Proceed to Finish >>':
      if ($_SESSION['stage']==8)
      {
        $_SESSION['stage']=9;

        $query_update = "UPDATE `lease application` SET `Bank`='$bank',
         `Account Number`='$accountnum',`Account Name`='$accountname',`BVN`='$bvn', `Account Type`='$accounttype',`Branch`='$branch',`Loan Amount`='$loanamount',`Tenor`='$tenor',`Repayment`='$repayment',`Purpose`='$purpose' WHERE `ID` = '$id'";
        $result_update = mysqli_query($conn,$query_update);

        $_SESSION['idx']=$id;
        header("location:leaseapp.php?redirect=$redirect");
      }
      break;
#####
     case 'CANCEL':
        $_SESSION['stage']="";

        #$tval="Your record has been updated.";
        header("location:index.php?redirect=$redirect");
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