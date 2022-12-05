<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 6))
{
 if ($_SESSION['access_lvl'] != 5){
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

@$id=$_REQUEST['id'];
@$acct=$_REQUEST['acct'];
@$loanidd=$_REQUEST['loanidd'];
@$tval=$_REQUEST['tval'];
?>
<div align="center">
	<table border="0" width="100%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
		<tr align='center'>
 <td bgcolor="#00CC99"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Loans Re-Payment</font></b>
 </td>
</tr>		
   <tr>
	<td>
<form action="loanpay.php" method="post">	
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="65%" id="AutoNumber1">
    <tr>
      <td>
        Enter Account Number:
      </td>
      <td>
        <input type="text" name="acct" size="15" value="<?php echo @$acct; ?>">    		
        <input type="submit" name="go" value="Search" />
      </td>
    </tr>
</table>
</form>	

  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#00CC99" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5" bgcolor="#00CC99"> </td>
</tr>
  </table>
<form action="submitloans.php" method="post">
<?php
$sql="SELECT * FROM `loan` WHERE `Account Number`='$acct' and `ID`='$loanidd'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);

$sql1="SELECT * FROM `loan payment` WHERE `Account Number`='$acct' and `ID`='$id'";
$result1 = mysqli_query($conn,$sql1) or die('Could not look up user data; ' . mysqli_error());
$row1 = mysqli_fetch_array($result1);

$sql2="SELECT * FROM `customer` WHERE `Account Number`='$acct'";
$result2 = mysqli_query($conn,$sql2) or die('Could not look up user data; ' . mysqli_error());
$row2 = mysqli_fetch_array($result2); 

?>
<div align="left">

<fieldset>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1" height="70">
    <tr>
      <td colspan='3' rowspan='3'>
         <?php  if (file_exists("images/pics/" . $row2['ID'] . ".jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $row2['ID']; ?>.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>
      </td>
      <td width="12%" height="28">
        First Name:
      </td>
      <td width="20%" height="28">
       <input type="hidden" name="fname" size="15" value="<?php echo @$row2['First Name']; ?>"><?php echo @$row2['First Name']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="23%" height="28">
        Surname:
      </td>
      <td width="20%" height="28">
          <input type="hidden" size="15" name="sname" value="<?php echo @$row2['Surname']; ?>"><?php echo @$row2['Surname']; ?>
      </td>
    </tr>
    <tr>
      <td width="12%" height="28">
        Account Number:
      </td>
      <td width="20%" height="28">
        <input type="hidden" name="id" size="31" value="<?php echo @$row1['ID']; ?>">
        <input type="hidden" name="loanid" size="31" value="<?php echo @$loanidd; ?>">
        <input type="hidden" name="acctnum" size="15" value="<?php echo @$row2['Account Number']; ?>"><?php echo @$row2['Account Number']; ?> &nbsp; 
	<input type="hidden" name="type" size="15" value="<?php echo @$row2['Account Type']; ?>"> <?php echo @$row2['Account Type']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="23%" height="28">
        Loan Officer:
      </td>
      <td width="20%" height="28">
	<?php if(!$row['Officer']) {
        echo strtoupper($_SESSION['name']); ?>
        <input type="hidden" name="officer" size="15" value="<?php echo strtoupper($_SESSION['name']); ?>">
	<?php } else {
        echo $row['Officer']; ?>
        <input type="hidden" name="officer" size="15" value="<?php echo $row['Officer']; ?>">
	<?php }?>
      </td>
    </tr>
    <tr>
      <td width="20%" height="28">
        Loan Amount:
      </td>
      <td width="20%" height="28">
        <input type="hidden" name="amount" size="15" value="<?php echo @$row['Loan Amount']; ?>"> <?php echo @$row['Loan Amount']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="23%" height="28">
        Balance Left:
      </td>
      <td width="20%" height="28">
        <input type="hidden" name="balance" size="15" value="<?php echo @$row['Balance']; ?>"> <?php echo @$row['Balance']; ?>
      </td>
    </tr>
    <tr>
      <td width="12%" height="28">

      </td>
      <td width="15%" height="28">

      </td>
      <td width="1%" height="28"></td>
      <td width="12%" height="28">
       Re-Payment Date:
      </td>
      <td width="20%" height="28">
	  <?php if (!$row1['Date'])
	  { ?>
        <input id="inputField" type="text" size="15" name="date" value="<?php echo date('d-m-Y'); ?>">
	  <?php } else { ?>
        <input id="inputField" type="text" size="15" name="date" value="<?php echo date('d-m-Y',strtotime($row1['Date'])); ?>">		
	  <?php } ?>
      </td>
      <td width="1%" height="28"></td>	
      <td width="12%" height="28">
       Re-Payment Amount:
      </td>
      <td width="20%" height="28">
<?php
if (!$id){
  if ($row['Payment Type']=="Daily Simple Interest")
  {
?>
        <input type="text" size="15" name="repay" value="<?php echo @$row['Daily Repay']; ?>">
<?php
  } else {
?>
        <input type="text" size="15" name="repay" value="<?php echo @$row['Periodic Repayment']; ?>">
<?php
  }
} else {
?>
        <input type="text" size="15" name="repay" value="<?php echo @$row1['Amount']; ?>">
<?php
}
?>
      </td>
    </tr>
</table>
</fieldset>
<tr align='center'>
 <td colspan="5" bgcolor="#00CC99"> </td>
</tr>
  </table>
  </div>
<?php
if (!$id){
?>
  <input type="submit" value="Save Payment" name="submit"> &nbsp;
<?php
} else {
?>  
  <input type="submit" value="Update Payment" name="submit"> &nbsp;  
  <input type="submit" value="Delete Payment" name="submit"> &nbsp;
<?php } ?>

</body>

</form>
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#00CC99" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5" bgcolor="#00CC99"> </td>
</tr>
  </table>
			</td>
		</tr>

<tr><td align="right"><br>
<?php 
 require_once 'footr.php';
 require_once 'footer.php';
?></td></tr>
	</table>
</div>

