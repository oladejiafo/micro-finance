<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2 && $_SESSION['access_lvl'] != 5))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

$ID=$_REQUEST['ID'];

$sql="SELECT `State` FROM `state` WHERE `State`='$ID'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
?>

<div align="center">
	<table border="0" width="807" cellspacing="1" bgcolor="#FFFFFF" id="table1">
		<tr>
			<td>

<form action="submitstate.php" method="post">
<p><b><font face="Verdana" color="#87ceff" style="font-size: 16pt">State Update</font></b></p>

<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="table2" height="70">
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">State:
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="hidden" name="id" size="31" value="<?php echo $row['id']; ?>">
        <input type="text" name="state" size="31" value="<?php echo $row['State']; ?>">
      	</span></font>
      </td>
      <td width="1%" height="28"></td>
    </tr>
  </table>
<br>
<?php
if (!$ID){
?>
  <input type="submit" value="Save" name="submit"> &nbsp;
<?php } 
 else { ?>
  <input type="submit" value="Update" name="submit"> &nbsp; 
  <input type="submit" value="Delete" name="submit"> &nbsp; 
<br>
<br>
<?php
} 
 echo "<a href='tableupdates.php'>Click here</a> to return.";
?>
 </td>
 </tr>
<tr><td>
<?php 

 require_once 'footr.php';
 require_once 'footer.php';
?>
</td></tr>
</table>
<br>

  </p>
  </div>

</form>
<p>&nbsp;</td>
			</tr>
		</table>
		</div>