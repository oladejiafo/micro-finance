<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
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

$sql="SELECT `ID`,`Code`,`Description`,`Remarks`,`Category` FROM `heads` WHERE `ID`='$ID'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
?>

<div align="center">
	<table border="0" width="807" cellspacing="1" bgcolor="#FFFFFF" id="table1">
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>

<form action="submitheads.php" method="post">
<p><b><font face="Verdana" color="#008000" style="font-size: 16pt">Accounts Heads Update</font></b></p>

<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="table2" height="70">
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Code:
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="code" size="31" value="<?php echo $row['Code']; ?>">
        <input type="hidden" name="ID" size="31" value="<?php echo $row['ID']; ?>">
      	</span></font>
      </td>
      <td width="1%" height="28"></td>
    </tr>
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Category:
      </font>
      </td>
      <td width="34%" height="28">
        <span style="font-size: 9pt">
         <select name="category" size="1" value="<?php echo $row['Category']; ?>">
          <option selected><?php echo @$row['Category']; ?></option>
          <option>Administrative Expenses</option>
          <option>Current Assets</option>
          <option>Fixed Assets</option>
          <option>Turnover</option>	
          <option>Others</option>
         </select>
      	</span>
      </td>
      <td width="1%" height="28"></td>
     </tr>
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Description:
      </font>
      </td>
      <td width="34%" height="28">
        <span style="font-size: 9pt">
        <input type="text" name="description" size="31" value="<?php echo $row['Description']; ?>">
      	</span>
      </td>
      <td width="1%" height="28"></td>
     </tr>
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Remarks:
      </font>
      </td>
      <td width="34%" height="28">
        <span style="font-size: 9pt">
        <input type="text" name="remarks" size="31" value="<?php echo $row['Remarks']; ?>">
      	</span>
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
</td>
			</tr>
		</table>
		</div>