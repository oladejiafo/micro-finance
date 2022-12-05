<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5))
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

$sql="SELECT `ID`,`Branch`,`Branch Code` FROM `branch` WHERE `ID`='$ID'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);
?>

<div align="center">
	<table border="0" width="807" cellspacing="1" bgcolor="#FFFFFF" id="table1">
		<tr>
			<td>

<form action="submitbranch.php" method="post">
<p><b><font face="Verdana" color="#000000" style="font-size: 16pt">Branch Update</font></b></p>

<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="table2" height="70">
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Branch:
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="branch" size="31" value="<?php echo $row['Branch']; ?>">
        <input type="hidden" name="id" size="31" value="<?php echo $row['ID']; ?>">
      	</span></font>
      </td>
      </tr><tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Branch Code:
      </font>
      </td>
      <td width="34%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="bcode" size="31" value="<?php echo $row['Branch Code']; ?>">
      	</span></font>
      </td>
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
 echo "<a href='tableupdates.php?cmbTable=Branch'>Click here</a> to return.";
?>
 </td>
 </tr>
</table>
<br>

<?php 
 require_once 'footr.php';
 require_once 'footer.php';
?>
  </p>
  </div>
</body>
 
</form>
<p>&nbsp;</td>
			</tr>
		</table>
		</div>