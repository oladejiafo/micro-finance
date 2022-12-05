<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5))
{
 if ($_SESSION['access_lvl'] != 4 & $_SESSION['access_lvl'] != 2){
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
$acctno=$_REQUEST['acctno'];
$tval=$_REQUEST['tval'];

$sql="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);
$id=$row['ID'];
?>

<div align="center">
	<table border="1" width="100%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
		<tr align='center'>
 <td bgcolor="#00CC99"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Customer Record</font></b>
 </td>
</tr>
		<tr>
			<td>

<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'custheader.php'; ?>
</font></i></b></legend>
<br>
<form action="register.php" method="post">	
<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="45%" id="AutoNumber1">
    <tr>
      <td>
        Enter Account Number:
      </td>
      <td>
        <input type="text" name="acctno" size="25">  
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
<form method="post" action="submitreg.php" enctype="multipart/form-data">
<table border="0" cellpadding="5" id="table2">
<tr><td>&nbsp;</td><td>&nbsp;</td><td><b><font color="#FF0000" style="font-size: 9pt"><?php echo $tval ; ?></font></b> </td></tr>
<tr>
<td>
	 <?php  if (file_exists("images/pics/" . $id . ".jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $id; ?>.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
</td>
<td>Upload Image:</td>
<td><input name="image_filename" type="file" id="image_filename">
<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>"></td>
</tr>
</table>

<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Account Information</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="17%" height="28">
        Account Number:
      </td>
      <td width="31%" height="28">
        <input type="text" name="acctno" size="31"  value="<?php echo @$row['Account Number']; ?>">
        <input type="hidden" name="id" size="31" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
       Account Type:
      </td>
      <td width="34%" height="28">
        <select name="type" size="1" value="<?php echo @$row['Account Type']; ?>">
          <option selected><?php echo @$row['Account Type']; ?></option>
          <?php  
         	$sqlt = "SELECT `Type` FROM `account type` ORDER BY Type;";
        	$resultt = mysql_query($sqlt) or die('Invalid query: ' . mysql_error());
        	while ($rows = mysql_fetch_array($resultt))
		{
		  echo " <option>" . $rows['Type'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Registration Date:
      </td>
      <td width="31%" height="28"> 
<?php
if (!$id)
{ ?>
       <input id="inputField" type="text" size="31" name="regdate" value="<?php echo date('d-m-Y'); ?>">
<?php
} else 
{ ?>

       <input id="inputField" type="text" name="regdate" size="31" value="<?php echo date('d-m-Y',strtotime($row['Date Registered'])); ?>">
<?php } ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Account Officer:
      </td>
      <td width="34%" height="28">
        <input type="text" name="acctofficer" size="31" value="<?php echo $row['Account Officer']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Identification Type:
      </td>
      <td width="31%" height="28">
        <select  name="idtype" width="31" value="<?php echo $row['Identification Type']; ?>">  
          <?php  
           echo '<option selected>' . $row['Identification Type'] . '</option>';
           echo '<option>Drivers Licence</option>';
           echo '<option>International Passport</option>';
           echo '<option>National ID Card</option>';
           echo '<option>Others</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Identification Number:
      </td>
      <td width="34%" height="28">
        <input type="text" name="idnumber" size="31" value="<?php echo $row['Identification Number']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Account Status:
      </td>
      <td width="31%" height="28">
        <select  name="status" width="31" value="<?php echo $row['Status']; ?>">  
          <?php  
           echo '<option selected>' . $row['Status'] . '</option>';
           echo '<option>Active</option>';
           echo '<option>Dormant</option>';
           echo '<option>Closed</option>';
           echo '<option>Pending</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        
      </td>
      <td width="34%" height="28">
        
      </td>
    </tr>
  </table>
 </fieldset>
 <br>
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Personal Information</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="17%" height="28">
        First Name:
      </td>
      <td width="31%" height="28">
        <input type="text" name="fname" size="31" value="<?php echo $row['First Name']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Surname:
      </td>
      <td width="34%" height="28">
        <input type="text" name="sname" size="31" value="<?php echo $row['Surname']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Marital Status:
      </td>
      <td width="31%" height="28">
        <select  name="mstatus" width="31" value="<?php echo $row['Marital Status']; ?>">  
          <?php  
           echo '<option selected>' . $row['Marital Status'] . '</option>';
           echo '<option>Married</option>';
           echo '<option>Single</option>';
           echo '<option>Divorced</option>';
           echo '<option>Widowed</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Gender:
      </td>
      <td width="34%" height="28">
        <select  name="gender" width="31" value="<?php echo $row['Gender']; ?>">  
          <?php  
           echo '<option selected>' . $row['Gender'] . '</option>';
           echo '<option>Female</option>';
           echo '<option>Male</option>';
          ?> 
         </select>
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Age:
      </td>
      <td width="31%" height="28">
        <input type="text" name="age" size="31" value="<?php echo $row['Age']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        e-Mail:
      </td>
      <td width="34%" height="28">
        <input type="text" name="email" size="31" value="<?php echo $row['email']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Occupation:
      </td>
      <td width="31%" height="28"><input type="text" name="occupation" size="31" value="<?php echo $row['Occupation']; ?>" /></td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Employer:
      </td>
      <td width="34%" height="28">
        <input type="text" name="employer" size="31" value="<?php echo $row['Employer']; ?>" />
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Position:
      </td>
      <td width="31%" height="28">
	    <input type="text" name="position" size="31" value="<?php echo $row['Position']; ?>" />
	  </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Office Address:
      </td>
      <td width="34%" height="28">
        <textarea name="officeaddress" rows="2" cols="25" ><?php echo $row['Office Address']; ?></textarea>
	  </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Contact Number:
      </td>
      <td width="31%" height="28">
        <input type="text" name="contactno" size="31" value="<?php echo $row['Contact Number']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Mobile Number:
      </td>
      <td width="34%" height="28">
        <input type="text" name="mobileno" size="31" value="<?php echo $row['Mobile Number']; ?>">  
      </td>
    </tr>
    <tr rowspan="2">
      <td width="17%" height="28" valign="top">
        Contact Address:
      </td>
      <td width="31%" height="28">
      <textarea name="homeaddress" rows="2" cols="25" ><?php echo $row['Home Address']; ?></textarea>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28" valign="top">
        Postal Address:
      </td>
      <td width="34%" height="28" valign="top">
      <textarea name="postaladdress" rows="2" cols="25" ><?php echo $row['Postal Address']; ?></textarea>
      </td>
    </tr>
  </table>
 </fieldset>
 <br>
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Next of Kin Information</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1" height="70">
    <tr>
      <td width="17%" height="28">
        Next of Kin:
      </td>
      <td width="31%" height="28">
        <input type="text" name="nkin" size="31" value="<?php echo $row['Next of Kin']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Relationship:
      </td>
      <td width="34%" height="28">
        <select name="relationship" width="31" value="<?php echo $row['Relationship']; ?>">  
          <?php  
           echo '<option selected>' . $row['Relationship'] . '</option>';
           echo '<option>Family</option>';
           echo '<option>Friend</option>';
           echo '<option>Associate</option>';
		   echo '<option>Employer</option>';
		   echo '<option>Others</option>';
          ?> 
         </select>
      </td>
    </tr>
    <tr rowspan="2">
      <td width="17%" height="28" valign="top">
        Next of Kin Contact:
      </td>
      <td width="31%" height="28">
      <textarea name="nkcontact" rows="2" cols="25" ><?php echo $row['NKin Contact']; ?></textarea>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28" valign="top">
        Next of Kin Phone:
      </td>
      <td width="34%" height="28" valign="top">
	  <input type="text" name="nkphone" size="31" value="<?php echo $row['NK Phone']; ?>"> 
      </td>
    </tr> 
 </table>
 </fieldset>
 <br>

<?php
 if (!$id){
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
 require_once 'footr.php';
 require_once 'footer.php';
?></td></tr>
	</table>
</div>

