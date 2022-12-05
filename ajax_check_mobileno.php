<?php
include('conn.php');

if(isset($_POST['mobileno']))//If a username has been submitted 
{
$mobileno = mysqli_real_escape_string($_POST['mobileno']);//Some clean up :)
 
$check_for_mobileno = mysqli_query($conn,"SELECT `ID` FROM `loan application` WHERE `Mobile Number`='$mobileno' and `Status` in ('Pending','Approved')");
//Query to check if username is available or not 
 
if(mysqli_num_rows($check_for_mobileno))
{
echo '1';//If there is a  record match in the Database - Not Available
}
else
{
echo '0';//No Record Found - Username is available 
}

}
?>