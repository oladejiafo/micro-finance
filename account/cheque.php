<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';
 @$tval=$_GET['tval'];
 @$ID=$_REQUEST['ID'];

$sql="SELECT * FROM `cheque` WHERE `ID`='$ID' order by `Date` desc";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);

 echo "<font color='#FF0000' style='font-size: 9pt'>" . $tval . "</font>";
 echo "<p>";
?>

<div align="center">
	<table border="0" width="940" bgcolor="#FFFFFF" id="table1">
		<tr align='center'>
 <td bgcolor="#008000"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Cheque Register</font></b>
 </td>
</tr>
		<tr>
			<td>

<form action="submitcheque.php" method="post">
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'acctheader.php'; ?>
</font></i></b></legend>
<div align="left">

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="800px" id="table3" height="70">
    <tr>
      <td width="19%" height="28">
      <font face="Verdana" style="font-size: 9pt">Transaction Type:
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
	  <select  name="type" width="31" value="<?php echo $row['Type']; ?>">  
          <?php  
           echo '<option selected>' . $row['Type'] . '</option>';
           echo '<option>Payment</option>';
           echo '<option>Reciept</option>';
          ?> 
         </select>
      	</span></font>   
      </td>
      <td width="5%" height="28"></td>
      <td width="17%" height="28">
       <font face="Verdana" style="font-size: 9pt">Transaction Date:
      </font>   
      </td> 
      <td width="35%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="date" size="31" value="<?php echo $row['Date']; ?>">
        <input type="hidden" name="ID" size="31" value="<?php echo $row['ID']; ?>">
      	</span></font>
      </td>
    </tr>
    <tr><td colspan="6">
    <font face="Verdana" style="font-size: 9pt" color="#008000">
     ____________________________________________________________________________________________________________________
    </font>
    </td></tr>
    <tr>  
      <td width="17%" height="28">
      <font face="Verdana" style="font-size: 9pt">Bank:
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <select  name="bank" width="31" value="<?php echo $row['Bank']; ?>">  
          <?php  
           echo '<option selected>' . $row['Bank'] . '</option>';
           $sql = "SELECT * FROM `bank`";
           $result_bank = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_bank)) 
           {
             echo '<option>' . @$rows['Name'] . '</option>';
           }
          ?> 
         </select>
      	</span></font>   
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Cheque No
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="chqno" size="31" value="<?php echo $row['Cheque No']; ?>">
      	</span></font>
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Amount:
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="amount" size="31" value="<?php echo $row['Amount']; ?>">
      	</span></font>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Particulars
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="particulars" size="31" value="<?php echo $row['Particulars']; ?>">
      	</span></font>
      </td>
    </tr>
    <tr><td colspan="6">
    <font face="Verdana" style="font-size: 9pt" color="#ffffff">

    </font>
    </td></tr>
    <tr>
      <td width="17%" height="28">
      <font face="Verdana" style="font-size: 9pt">Payment Status:
      </font>
      </td> 
      <td width="35%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
	  <select  name="status" width="31" value="<?php echo $row['Status']; ?>">  
          <?php  
           echo '<option selected>' . $row['Status'] . '</option>';
           echo '<option>Cleared</option>';
           echo '<option>Uncleared</option>';
          ?> 
         </select>
      	</span></font>  
      </td>
      <td width="5%" height="28"></td>
      <td width="19%" height="28">
      <font face="Verdana" style="font-size: 9pt">
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        
      	</span></font>   
      </td>
    </tr>
  </table>
    <p>
<?php
if (!$ID){
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
	</tr><tr><td align="right">
<?php 
 echo "<a href='bankbook.php'>Click here</a> to return to list.";

 require_once 'footr.php';
 require_once 'footer.php';
?>
</td></tr>
	</table>
</div>