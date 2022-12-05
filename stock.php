<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2))
{
 if ($_SESSION['access_lvl'] != 1){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
#exit();
}
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

$Tit=$_SESSION['Tit'];
$code=$_REQUEST['code'];
$tval=$_REQUEST['tval'];

$sql="SELECT `stock`.`Stock Code`,`stock`.* FROM stock WHERE `stock`.`Stock Code`='$code'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);

?>
<div align="center">
	<table border="0" width="927" cellspacing="1" bgcolor="#FFFFFF" id="table1">
		<tr align='center'>
 <td bgcolor="#008000"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Stock Record</font></b>
 </td>
</tr>
		<tr>
			<td>

<form action="submitstock.php" method="post">
<fieldset style="padding: 2">
<p><legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'stkheader.php'; ?>
</p></font></i></b></legend>

<div align="left">
<b><i><font size="2" face="Tahoma" color="#008000"><u>STOCK</u></font></i></b>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1" height="70">
    <tr>
      <td width="17%" height="28">
        Stock Code
      </td>
      <td width="31%" height="28">
        <input type="text" name="code" size="31" value="<?php echo $code; ?>">
        <input type="hidden" name="id" size="31" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
       Stock Category 
      </td>
      <td width="34%" height="28">
          <select size="1" name="category" value="<?php echo $row['Category']; ?>">
          <?php  
           echo '<option selected>' . $row['Category'] . '</option>';
           $sql = "SELECT * FROM `stock category`";
           $result_status = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_status)) 
           {
             echo '<option>' . $rows['Category'] . '</option>';
           }
          ?> 
         </select>
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Brand Name
      </td>
      <td width="31%" height="28">
        <select name="brandname" size="1" value="<?php echo $row['Brand Name']; ?>">
          <?php  
           echo '<option selected>' . $row['Brand Name'] . '</option>';
           $sql = "SELECT * FROM `brand`";
           $result_status = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_status)) 
           {
             echo '<option>' . $rows['Brand Name'] . '</option>';
           }
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Stock Name
      </td>
      <td width="34%" height="28">
        <input type="text" name="stockname" size="31" value="<?php echo $row['Stock Name']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Description
      </td>
      <td width="31%" height="28">
        <input type="text" name="description" width="31" value="<?php echo $row['Description']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Manufacturer
      </td>
      <td width="34%" height="28">
        <input type="text" name="manufacturer" size="31" value="<?php echo $row['Manufacturer']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Supplier
      </td>
      <td width="31%" height="28">
        <select  name="supplier" width="31" value="<?php echo $row['Supplier']; ?>">  
          <?php  
           echo '<option selected>' . $row['Supplier'] . '</option>';
           $sql = "SELECT * FROM `supplier`";
           $result_cl = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_cl)) 
           {
             echo '<option>' . $rows['Supplier'] . '</option>';
           }
          ?> 
         </select> &nbsp;
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Stock Location
      </td>
      <td width="34%" height="28">
        <select  name="location" width="31" value="<?php echo $row['Location']; ?>">  
          <?php  
           echo '<option selected>' . $row['Location'] . '</option>';
           $sql = "SELECT * FROM `location`";
           $result_cl = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_cl)) 
           {
             echo '<option>' . $rows['Location'] . '</option>';
           }
          ?> 
         </select> &nbsp;
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Unit Cost Price
      </td>
      <td width="31%" height="28">
        <input type="text" name="unitcost" size="31" value="<?php echo $row['Unit Cost']; ?>">
      </td>
      <td width="1%" height="28"></td>

      <td width="17%" height="28">
        Unit Selling Price
      </td>
      <td width="34%" height="28">
        <input type="text" name="sellingprice" size="31" value="<?php echo $row['Selling Price']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Expiry Date
      </td>
      <td width="31%" height="28">
        <input type="text" name="expirydate" size="31" value="<?php echo $row['Expiry Date']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Reorder Level
      </td>
      <td width="34%" height="28">
        <input type="text" name="reorderlevel" width="31" value="<?php echo $row['Reorder Level']; ?>">  
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Units in Stock
      </td>
      <td width="31%" height="28">
        <input type="text" name="stockunit" width="31" value="<?php echo $row['Units in Stock']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Attributes
      </td>
      <td width="34%" height="28">
        <select name="weight" size="1" value="<?php echo $row['Weight']; ?>">
          <?php  
           echo '<option selected>' . $row['Weight'] . '</option>';
           $sql = "SELECT * FROM `attributes`";
           $result_gl = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rowt = mysql_fetch_array($result_gl)) 
           {
             echo '<option>' . $rowt['Attributes'] . '</option>';
           }
          ?> 
         </select> &nbsp;
      </td>
    </tr>
  </table>
    <p>

 </fieldset>
 <br>

<?php
if (!$code){
?>
  <input type="submit" value="Save" name="submit"> &nbsp;
<?php } 
 else { ?>
  <input type="submit" value="Update" name="submit"> &nbsp;  
  <input type="submit" value="Delete" name="submit"> &nbsp;
<?php
} ?>
  </p>
  </div>
</body>
</form>

			<p></td>
		</tr><tr><td align="right"><font size="2"><?php 
 echo "<a href='stocklist.php'>Click here</a> to return to list.</font>";
 require_once 'footr.php';
 require_once 'footer.php';
?></td></tr>
	</table>
</div>

