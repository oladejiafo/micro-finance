<?php
@$username = $_POST["username"];
@$passwd = $_POST["passwd"];
@$passwd2 = $_POST["passwd2"];
 
require_once 'conn.php';
 
if ($_POST['passwd'] !="" 
and $_POST['passwd2'] !="" 
and $_POST['passwd'] == $_POST['passwd2'] 
and $_POST['username'] !="" )
{
$sqlzz = "Update login set `password`='" . md5($passwd) . "' WHERE `username`='" . $_POST['username'] . "'";
mysqli_query($conn,$sqlzz);
#########################################
          $sqlt = "SELECT user_id,access_lvl, username,email " .
                 "FROM login " .
                 "WHERE `username`='" . $_POST['username'] . "'";
          $result = mysqli_query($conn,$sqlt) or die('Could not look up member information; ' . mysqli_error());

 $tval="Password Has Been Reset, Login";
## header("location:index.php?tval=$tval&redirect=$redirect");
 header("location:index.php?tval=$tval&redirect=$redirect");
#########################################
}
else
{
 $tval="Please fill in all parameters!";
 header("location:resetpwd.php?tval=$tval&redirect=$redirect");
}

?>
