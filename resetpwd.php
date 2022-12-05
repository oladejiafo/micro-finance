<?php
 require_once 'header.php';
 require_once 'conn.php';
 require_once 'style.php';

@$epz=$_REQUEST['epz'];
@$id=md5($_REQUEST['id']);
@$tval=$_REQUEST['tval'];

$sql="SELECT * FROM `login` WHERE `email`='" . $epz . "'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
?>
<script src="../lib/jquery.js"></script>
<script src="../dist/jquery.validate.js"></script>

<script>


$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();

});
</script>
<link rel="stylesheet" href="css/refreshform.css" />

<fieldset style="padding: 2; height:330px;background:url(css/images/logo2.png) center;">
<legend align='right'>
<?php 
if($_SESSION['access_lvl'] == 1 or $_SESSION['access_lvl'] == 2 or $_SESSION['access_lvl'] == 3 or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44)
{
# require_once 'uheader.php'; 
} else {
# echo "<a href='index.php'>Go To Home Page</a>";
}
?>
</legend>
<div align="center">
<div class='row' style="background-color:#394247; width:100%;height:40px;padding-top:10px" align="center">
  <h2><b><font face="Verdana" color="#FFFFFF" style="font-size: 16px">My Password Reset</font></b></h2>
 </div>

<div align="center" style="width:80%;margin-top:20px">
<form method="post" action="submitreset.php" enctype="multipart/form-data">
<div align="center">
  <font color=red>New Password</font>:
<br>
  <input type="password" id="passwd" style="width:200px; height:35px" name="passwd" maxlength="50" value="" required>
  <input type="hidden" size="30" name="username" maxlength="50" value="<?php echo $_SESSION['name']; ?>">
</div>
<div align="center">
  <font color=red>Re-type Password</font>:
 <br>
  <input type="password" id="passwd2" style="width:200px; height:35px" name="passwd2" maxlength="50" value="" required>
</div>
<div align="center">
  <input type="submit" value="Submit" name="submit" style="margin-top:20px;width:200px; height:35px;margin-left:50px"> &nbsp;
</div>
</form>
</div>

