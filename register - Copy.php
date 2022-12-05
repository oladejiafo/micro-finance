<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['user_id']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 4))
{
 if ($_SESSION['access_lvl'] != 2){
$tval="Sorry, but you don’t have permission to view this page! Login pls";
header("location:index.php?tval=$tval&redirect=$redirect");
}
}
 require_once 'header.php';
 require_once 'conn.php';
 require_once 'style.php';

@$Tit=$_SESSION['Tit'];
@$acctno=$_REQUEST['acctno'];
@$tval=$_REQUEST['tval'];
@$grp=$_REQUEST['grp'];
@$brch=$_REQUEST['brch'];

$sql="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);
@$id=$row['ID'];
?>
<script src="../lib/jquery.js"></script>
<script src="../dist/jquery.validate.js"></script>

<script>

$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();

	// validate signup form on keyup and submit
	$("#signupForm").validate({
		rules: {
			firstname: "required",
			lastname: "required",
			username: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			agree: "required"
		},
		messages: {
			firstname: "Please enter your firstname",
			lastname: "Please enter your lastname",
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			confirm_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			},
			email: "Please enter a valid email address",
			agree: "Please accept our policy"
		}
	});

	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});

	//code to hide topic selection, disable for demo
	var newsletter = $("#newsletter");
	// newsletter topics are optional, hide at first
	var inital = newsletter.is(":checked");
	var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
	var topicInputs = topics.find("input").attr("disabled", !inital);
	// show when newsletter is checked
	newsletter.click(function() {
		topics[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs.attr("disabled", !this.checked);
	});
});
</script>

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
<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="70%" id="AutoNumber1">
    <tr>
      <td>
        Enter Account Number:
      </td>
      <td>
        <input type="text" size="15" name="acctno" onBlur="filtery(this.value,this.form.code)" style="height:35; background-color:#E9FCFE; font-size: 15pt">
&nbsp;
       <input name="go" type="submit" value="Search" align="top" style="height:35; color:#008000; font-size: 15pt">
      </td>
    </tr>
</table>
</form>
<b><font color="#FF0000" style="font-size: 9pt"><?php echo $tval ; ?></font></b>	
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#00CC99" width="100%" id="AutoNumber1" height="1">
 <tr align='center'>
  <td colspan="5" bgcolor="#00CC99"> </td>
 </tr>
</table>
<?php
if(!$acctno and !$grp)
{
?>
<p>
<form method="post" action="submitreg.php">
<div align="center">
<fieldset style="padding: 2; width:700; align:center">
<legend><b><i><font size="3" face="Tahoma" color="green"></font></i></b></legend>
  <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="98%" id="AutoNumber1">
    <tr>
      <td width="30%" height="28">
       Account Type/Category:
      </td>
      <td width="30%" height="28">
        <select name="group" size="1" style="height:35; background-color:#E9FCFE; font-size: 15pt">
          <option selected>Individual</option>
	  <option>Group</option>
        </select>
      </td>
      <td width="10%" height="28">
       Branch:
      </td>
      <td width="30%" height="28">
        <select name="brch" size="1" style="height:35; background-color:#E9FCFE; font-size: 15pt">
          <option selected></option>
          <?php  
         	$sqlt = "SELECT `Branch` FROM `branch` ORDER BY branch;";
        	$resultt = mysql_query($sqlt) or die('Invalid query: ' . mysql_error());
        	while ($rows = mysql_fetch_array($resultt))
		{
		  echo " <option>" . $rows['Branch'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
      <td> <input name="submit" type="submit" value="Continue" align="top" style="height:35; color:#008000; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#00CC99" width="100%" id="AutoNumber1" height="1">
 <tr align='center'>
  <td colspan="5" bgcolor="#00CC99"> </td>
 </tr>
</table>
<?php
} else {
?>

<?php
if($row['Group'] or $grp)
{
 if($row['Group'])
 {
   $grpp=$row['Group'];
 } else {
   $grpp=$grp;
 }
?>
<table border="0" width="100%" id="table2" cellspacing="1" cellpadding="0">
 <tr align="center">
  <td>
    <b><font size="3" face="Tahoma"><?php echo strtoupper($grpp); ?> ACCOUNT</font></b>
  </td>
 </tr>
</table>
<?php
}
?>

<?php
if($row['Group']=="Group" or $grp=="Group")
{
?>
<form method="post" action="submitreg.php" enctype="multipart/form-data">
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Account Information</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="17%" height="28">
        Account Number:
      </td>
      <td width="31%" height="28">
<?php
if (!$row['Account Number'])
{
  $sqlz = "SELECT `Branch Code` FROM `branch` Where `Branch`='$brch'";
  $resultz = mysql_query($sqlz,$conn);
  $rowz = mysql_fetch_array($resultz);
  $bcd=$rowz['Branch Code'];

  $sqlx = "SELECT `Account Number` FROM `customer` order by `ID` desc";
  $resultx = mysql_query($sqlx,$conn);
  $rowx = mysql_fetch_array($resultx);
  $ann=$rowx['Account Number'];

  $ann=$ann+1;   
  $accNum=$bcd . $ann;

?>
        <input type="text" name="acctno" size="31"  value="<?php echo @$accNum; ?>" required>
<?php
} else {
?>
        <input type="text" name="acctno" size="31"  value="<?php echo @$row['Account Number']; ?>" required>
<?php  
}
?>
        <input type="hidden" name="id" size="31" value="<?php echo $row['ID']; ?>">
        <input type="hidden" name="group" size="31" value="<?php echo $grp; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
       Account Type:
      </td>
      <td width="34%" height="28">
        <select name="type" size="1" value="<?php echo @$row['Account Type']; ?>" required>
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
       <input id="inputField" type="text" size="31" name="regdate" value="<?php echo date('d-m-Y'); ?>" required>
<?php
} else 
{ ?>

       <input id="inputField" type="text" name="regdate" size="31" value="<?php echo date('d-m-Y',strtotime($row['Date Registered'])); ?>" required>
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
        Branch:
      </td>
      <td width="31%" height="28">
<?php
if ($_REQUEST['brch'])
{
?>
        <select name="branch" size="1" value="<?php echo $_REQUEST['brch']; ?>">
          <option selected><?php echo $_REQUEST['brch']; ?></option>
<?php
} else {
?>
        <select name="branch" size="1" value="<?php echo @$row['Branch']; ?>">
          <option selected><?php echo @$row['Branch']; ?></option>
          <?php  
}
         	$sqlt = "SELECT `Branch` FROM `branch` ORDER BY `Branch`;";
        	$resultt = mysql_query($sqlt) or die('Invalid query: ' . mysql_error());
        	while ($rows = mysql_fetch_array($resultt))
		{
		  echo " <option>" . $rows['Branch'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Customer Category:
      </td>
      <td width="34%" height="28">
        <select name="customercategory" width="31" value="<?php echo $row['Customer Category']; ?>">  
          <?php  
           echo '<option selected>' . $row['Customer Category'] . '</option>';
           echo '<option>Executive Class</option>';
           echo '<option>Middle Class</option>';
           echo '<option>General Class</option>';
          ?> 
         </select>
      </td>
    </tr>

    <tr>
      <td width="17%" height="28">
        Account Status:
      </td>
      <td width="31%" height="28">
        <select  name="status" width="31" value="<?php echo $row['Status']; ?>" required>  
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
<legend><b><i><font size="2" face="Tahoma" color="green">Group Information</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="17%" height="28">
        Group Name:
      </td>
      <td width="31%" height="28">
        <input type="text" name="gname" size="31" value="<?php echo $row['Group Name']; ?>" required>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        
      </td>
      <td width="34%" height="28">
        
      </td>
    </tr>
    <tr rowspan="2">
      <td width="17%" height="28" valign="top">
        Physical Address:
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
 <fieldset style="padding: 2">


 <legend><b><i><font size="2" face="Tahoma" color="green">Principal Signatories #1</font></i></b></legend>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
  <tr>
   <td width="20%">
	 <?php  if (file_exists("images/pics/" . $id . "x1.jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $id; ?>x1.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
   </td>
   <td width="16%">Browse Image:<br>
   <input name="image_filename1" type="file" id="image_filename1" size="15">
   <input type="hidden" name="id" value="<?php echo @$_REQUEST['id'];?>"></td>
   <td width="2%" height="28"></td>
   <td align='left' width="20%">
	 <?php  if (file_exists("images/sign/" . $id . "x1.jpg")==1)
            { ?>
              <img border="1" src="images/sign/<?php echo $id; ?>x1.jpg" width="140" height="90">
	 <?php  } else { ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="90">	 
	 <?php  } ?>			 
   </td>
   <td align='left' width="16%">Browse Signature:<br>
   <input name="sign_filename1" type="file" id="sign_filename1" size="15">
   <input type="hidden" name="id" value="<?php echo @$_REQUEST['id'];?>"></td>
   <td colspan="3" height="28"></td>
</tr>
    <tr>
      <td width="15%" height="28">
        #1 Name:
      </td>
      <td width="16%" height="28">
        <input type="text" name="name1" size="25" value="<?php echo $row['Name1']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #1 Position:
      </td>
      <td width="16%" height="28">
        <input type="text" name="position1" size="25" value="<?php echo $row['Position1']; ?>">        
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
       #1 Contact Number:
      </td>
      <td width="16%" height="28">
        <input type="text" name="contactno1" size="25" value="<?php echo $row['Contact Number1']; ?>">  
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
       #1 Mobile Number:
      </td>
      <td width="16%" height="28">
        <input type="text" name="mobileno1" size="25" value="<?php echo $row['Mobile Number1']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #1 Office Address:
      </td>
      <td width="16%" height="28">
        <textarea name="officeaddress1" rows="2" cols="18" ><?php echo $row['Office Address1']; ?></textarea>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28" valign="top">
        #1 Address:
      </td>
      <td width="16%" height="28">
      <textarea name="homeaddress1" rows="2" cols="18" ><?php echo $row['Home Address1']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #1 Marital Status:
      </td>
      <td width="16%" height="28">
        <select  name="mstatus1" width="31" value="<?php echo $row['Marital Status1']; ?>">  
          <?php  
           echo '<option selected>' . $row['Marital Status1'] . '</option>';
           echo '<option>Married</option>';
           echo '<option>Single</option>';
           echo '<option>Divorced</option>';
           echo '<option>Widowed</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #1 Gender:
      </td>
      <td width="16%" height="28">
        <select  name="gender1" width="31" value="<?php echo $row['Gender1']; ?>">  
          <?php  
           echo '<option selected>' . $row['Gender1'] . '</option>';
           echo '<option>Female</option>';
           echo '<option>Male</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #1 Age:
      </td>
      <td width="16%" height="28">
        <input type="text" name="age1" size="25" value="<?php echo $row['Age1']; ?>">  
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #1 e-Mail:
      </td>
      <td width="16%" height="28">
        <input type="text" name="email1" size="25" value="<?php echo $row['email1']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #1 Occupation:
      </td>
      <td width="16%" height="28"><input type="text" name="occupation1" size="25" value="<?php echo $row['Occupation1']; ?>" /></td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #1 Employer:
      </td>
      <td width="16%" height="28">
        <input type="text" name="employer1" size="25" value="<?php echo $row['Employer1']; ?>" />
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #1 Next of Kin:
      </td>
      <td width="16%" height="28">
        <input type="text" name="nkin1" size="25" value="<?php echo $row['Next of Kin1']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #1 Relationship:
      </td>
      <td width="16%" height="28">
        <select name="relationship1" width="31" value="<?php echo $row['Relationship1']; ?>">  
          <?php  
           echo '<option selected>' . $row['Relationship1'] . '</option>';
           echo '<option>Family</option>';
           echo '<option>Friend</option>';
           echo '<option>Associate</option>';
		   echo '<option>Employer</option>';
		   echo '<option>Others</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28" valign="top">
        #1 Next of Kin Contact/Phone:
      </td>
      <td width="16%" height="28">
      <textarea name="nkcontact1" rows="2" cols="18" ><?php echo $row['NKin Contact1']; ?></textarea>
      </td>
    </tr> 
  </table>
 </fieldset>
 <fieldset style="padding: 2">
 <legend><b><i><font size="2" face="Tahoma" color="green">Principal Signatories #2</font></i></b></legend>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
  <tr>
   <td width="20%">
	 <?php  if (file_exists("images/pics/" . $id . "x2.jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $id; ?>x2.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
   </td>
   <td width="16%">Browse Image:<br>
   <input name="image_filename2" type="file" id="image_filename2" size="15">
   <input type="hidden" name="id" value="<?php echo @$_REQUEST['id'];?>"></td>
   <td colspan="1" height="28"></td>
   <td align='left' width="20%">
	 <?php  if (file_exists("images/sign/" . $id . "x2.jpg")==1)
            { ?>
              <img border="1" src="images/sign/<?php echo $id; ?>x2.jpg" width="140" height="90">
	 <?php  } else { ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="90">	 
	 <?php  } ?>			 
   </td>
   <td align='left' width="16%">Browse Signature:<br>
   <input name="sign_filename2" type="file" id="sign_filename2" size="15">
   <input type="hidden" name="id" value="<?php echo @$_REQUEST['id'];?>"></td>
   <td colspan="3" height="28"></td>
</tr>
    <tr>
      <td width="15%" height="28">
        #2 Name:
      </td>
      <td width="16%" height="28">
        <input type="text" name="name2" size="25" value="<?php echo $row['Name2']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #2 Position:
      </td>
      <td width="16%" height="28">
        <input type="text" name="position2" size="25" value="<?php echo $row['Position2']; ?>">        
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
       #2 Contact Number:
      </td>
      <td width="16%" height="28">
        <input type="text" name="contactno2" size="25" value="<?php echo $row['Contact Number2']; ?>">  
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
       #2 Mobile Number:
      </td>
      <td width="16%" height="28">
        <input type="text" name="mobileno2" size="25" value="<?php echo $row['Mobile Number2']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #2 Office Address:
      </td>
      <td width="16%" height="28">
        <textarea name="officeaddress2" rows="2" cols="18" ><?php echo $row['Office Address2']; ?></textarea>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28" valign="top">
        #2 Address:
      </td>
      <td width="16%" height="28">
      <textarea name="homeaddress2" rows="2" cols="18" ><?php echo $row['Home Address2']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #2 Marital Status:
      </td>
      <td width="16%" height="28">
        <select  name="mstatus2" width="31" value="<?php echo $row['Marital Status2']; ?>">  
          <?php  
           echo '<option selected>' . $row['Marital Status2'] . '</option>';
           echo '<option>Married</option>';
           echo '<option>Single</option>';
           echo '<option>Divorced</option>';
           echo '<option>Widowed</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #2 Gender:
      </td>
      <td width="16%" height="28">
        <select  name="gender2" width="31" value="<?php echo $row['Gender2']; ?>">  
          <?php  
           echo '<option selected>' . $row['Gender2'] . '</option>';
           echo '<option>Female</option>';
           echo '<option>Male</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #2 Age:
      </td>
      <td width="16%" height="28">
        <input type="text" name="age2" size="25" value="<?php echo $row['Age2']; ?>">  
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #2 e-Mail:
      </td>
      <td width="16%" height="28">
        <input type="text" name="email2" size="25" value="<?php echo $row['email2']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #2 Occupation:
      </td>
      <td width="16%" height="28"><input type="text" name="occupation2" size="25" value="<?php echo $row['Occupation']; ?>" /></td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #2 Employer:
      </td>
      <td width="16%" height="28">
        <input type="text" name="employer2" size="25" value="<?php echo $row['Employer2']; ?>" />
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #2 Next of Kin:
      </td>
      <td width="16%" height="28">
        <input type="text" name="nkin2" size="25" value="<?php echo $row['Next of Kin2']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #2 Relationship:
      </td>
      <td width="16%" height="28">
        <select name="relationship2" width="31" value="<?php echo $row['Relationship2']; ?>">  
          <?php  
           echo '<option selected>' . $row['Relationship2'] . '</option>';
           echo '<option>Family</option>';
           echo '<option>Friend</option>';
           echo '<option>Associate</option>';
		   echo '<option>Employer</option>';
		   echo '<option>Others</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28" valign="top">
        #2 Next of Kin Contact/Phone:
      </td>
      <td width="16%" height="28">
      <textarea name="nkcontact2" rows="2" cols="18" ><?php echo $row['NKin Contact2']; ?></textarea>
      </td>
    </tr> 
  </table>
 </fieldset>
 <fieldset style="padding: 2">
 <legend><b><i><font size="2" face="Tahoma" color="green">Principal Signatories #3</font></i></b></legend>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
  <tr>
   <td width="20%">
	 <?php  if (file_exists("images/pics/" . $id . "x3.jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $id; ?>x3.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
   </td>
   <td width="16%">Browse Image:<br>
   <input name="image_filename3" type="file" id="image_filename3" size="15">
   <input type="hidden" name="id" value="<?php echo @$_REQUEST['id'];?>"></td>
   <td width="2%" height="28"></td>
   <td align='left' width="20%">
	 <?php  if (file_exists("images/sign/" . $id . "x3.jpg")==1)
            { ?>
              <img border="1" src="images/sign/<?php echo $id; ?>x3.jpg" width="140" height="90">
	 <?php  } else { ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="90">	 
	 <?php  } ?>			 
   </td>
   <td align='left' width="16%">Browse Signature:<br>
   <input name="sign_filename3" type="file" id="sign_filename3" size="15">
   <input type="hidden" name="id" value="<?php echo @$_REQUEST['id'];?>"></td>
   <td colspan="3" height="28"></td>
</tr>
    <tr>
      <td width="15%" height="28">
        #3 Name:
      </td>
      <td width="16%" height="28">
        <input type="text" name="name3" size="25" value="<?php echo $row['Name3']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #3 Position:
      </td>
      <td width="16%" height="28">
        <input type="text" name="position3" size="25" value="<?php echo $row['Position3']; ?>">        
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
       #3 Contact Number:
      </td>
      <td width="16%" height="28">
        <input type="text" name="contactno3" size="25" value="<?php echo $row['Contact Number3']; ?>">  
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
       #3 Mobile Number:
      </td>
      <td width="16%" height="28">
        <input type="text" name="mobileno3" size="25" value="<?php echo $row['Mobile Number3']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #3 Office Address:
      </td>
      <td width="16%" height="28">
        <textarea name="officeaddress3" rows="2" cols="18" ><?php echo $row['Office Address3']; ?></textarea>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28" valign="top">
        #3 Address:
      </td>
      <td width="16%" height="28">
      <textarea name="homeaddress3" rows="2" cols="18" ><?php echo $row['Home Address3']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #3 Marital Status:
      </td>
      <td width="16%" height="28">
        <select  name="mstatus3" width="31" value="<?php echo $row['Marital Status3']; ?>">  
          <?php  
           echo '<option selected>' . $row['Marital Status3'] . '</option>';
           echo '<option>Married</option>';
           echo '<option>Single</option>';
           echo '<option>Divorced</option>';
           echo '<option>Widowed</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #3 Gender:
      </td>
      <td width="16%" height="28">
        <select  name="gender3" width="31" value="<?php echo $row['Gender3']; ?>">  
          <?php  
           echo '<option selected>' . $row['Gender'] . '</option>';
           echo '<option>Female</option>';
           echo '<option>Male</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #3 Age:
      </td>
      <td width="16%" height="28">
        <input type="text" name="age3" size="25" value="<?php echo $row['Age3']; ?>">  
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #3 e-Mail:
      </td>
      <td width="16%" height="28">
        <input type="text" name="email3" size="25" value="<?php echo $row['email3']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #3 Occupation:
      </td>
      <td width="16%" height="28"><input type="text" name="occupation3" size="25" value="<?php echo $row['Occupation3']; ?>" /></td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #3 Employer:
      </td>
      <td width="16%" height="28">
        <input type="text" name="employer3" size="25" value="<?php echo $row['Employer3']; ?>" />
      </td>
    </tr>
    <tr>
      <td width="15%" height="28">
        #3 Next of Kin:
      </td>
      <td width="16%" height="28">
        <input type="text" name="nkin3" size="25" value="<?php echo $row['Next of Kin3']; ?>">  
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28">
        #3 Relationship:
      </td>
      <td width="16%" height="28">
        <select name="relationship3" width="31" value="<?php echo $row['Relationship3']; ?>">  
          <?php  
           echo '<option selected>' . $row['Relationship3'] . '</option>';
           echo '<option>Family</option>';
           echo '<option>Friend</option>';
           echo '<option>Associate</option>';
		   echo '<option>Employer</option>';
		   echo '<option>Others</option>';
          ?> 
         </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="15%" height="28" valign="top">
        #3 Next of Kin Contact/Phone:
      </td>
      <td width="16%" height="28">
      <textarea name="nkcontact3" rows="2" cols="18" ><?php echo $row['NKin Contact3']; ?></textarea>
      </td>
    </tr> 
  </table>
 </fieldset>
 <br>

<?php
 if (!$id){
?>
  <input type="submit" value="Save" name="submit" style="height:40;width:100; color:#008000; font-size: 14pt"> &nbsp;
<?php } 
 else { ?>
  <input type="submit" value="Update" name="submit" style="height:40;width:100; color:#008000; font-size: 14pt"> &nbsp;  
  <input type="submit" value="Delete" name="submit" style="height:40;width:100; color:#008000; font-size: 14pt" onclick="return confirm('Are you sure you want to Delete?');"> &nbsp;
<?php
} ?>
  </p>
  </div>
</body>
</form>
<?php
} else {
?>
<form method="post" action="submitreg.php" enctype="multipart/form-data">
<table border="0" cellpadding="5" id="table2" width='100%'>
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
<input type="hidden" name="id" value="<?php echo @$_REQUEST['id'];?>"></td>
<td align='right'>
	 <?php  if (file_exists("images/sign/" . $id . ".jpg")==1)
            { ?>
              <img border="1" src="images/sign/<?php echo $id; ?>.jpg" width="140" height="90">
	 <?php  } else { ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="90">	 
	 <?php  } ?>			 
</td>
<td align='right'>Upload Signature:</td>
<td align='right'><input name="sign_filename" type="file" id="sign_filename">
<input type="hidden" name="id" value="<?php echo @$_REQUEST['id'];?>"></td>

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
<?php
if (!$row['Account Number'])
{
  $sqlz = "SELECT `Branch Code` FROM `branch` Where `Branch`='$brch'";
  $resultz = mysql_query($sqlz,$conn);
  $rowz = mysql_fetch_array($resultz);
  $bcd=$rowz['Branch Code'];

  $sqlx = "SELECT `Account Number` FROM `customer` order by `ID` desc";
  $resultx = mysql_query($sqlx,$conn);
  $rowx = mysql_fetch_array($resultx);
  $ann=$rowx['Account Number'];

  $ann=$ann+1;   
  $accNum=$bcd . $ann;

?>
        <input type="text" name="acctno" size="31"  value="<?php echo @$accNum; ?>" required>
<?php
} else {
?>
        <input type="text" name="acctno" size="31"  value="<?php echo @$row['Account Number']; ?>" required>
<?php  
}
?>
        <input type="hidden" name="id" size="31" value="<?php echo $row['ID']; ?>">
        <input type="hidden" name="group" size="31" value="<?php echo $grp; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
       Account Type:
      </td>
      <td width="34%" height="28">
        <select name="type" size="1" value="<?php echo @$row['Account Type']; ?>" required>
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
       <input id="inputField" type="text" size="31" name="regdate" value="<?php echo date('d-m-Y'); ?>" required>
<?php
} else 
{ ?>

       <input id="inputField" type="text" name="regdate" size="31" value="<?php echo date('d-m-Y',strtotime($row['Date Registered'])); ?>" required>
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
        Branch:
      </td>
      <td width="31%" height="28">
<?php
if ($_REQUEST['brch'])
{
?>
        <select name="branch" size="1" value="<?php echo $_REQUEST['brch']; ?>">
          <option selected><?php echo $_REQUEST['brch']; ?></option>
<?php
} else {
?>
        <select name="branch" size="1" value="<?php echo @$row['Branch']; ?>">
          <option selected><?php echo @$row['Branch']; ?></option>
          <?php  
}
         	$sqlt = "SELECT `Branch` FROM `branch` ORDER BY `Branch`;";
        	$resultt = mysql_query($sqlt) or die('Invalid query: ' . mysql_error());
        	while ($rows = mysql_fetch_array($resultt))
		{
		  echo " <option>" . $rows['Branch'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Customer Category:
      </td>
      <td width="34%" height="28">
        <select name="customercategory" width="31" value="<?php echo $row['Customer Category']; ?>">  
          <?php  
           echo '<option selected>' . $row['Customer Category'] . '</option>';
           echo '<option>Executive Class</option>';
           echo '<option>Middle Class</option>';
           echo '<option>General Class</option>';
          ?> 
         </select>
      </td>
    </tr>

    <tr>
      <td width="17%" height="28">
        Account Status:
      </td>
      <td width="31%" height="28">
        <select  name="status" width="31" value="<?php echo $row['Status']; ?>" required>  
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
        <input type="text" name="fname" size="31" value="<?php echo $row['First Name']; ?>" required>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Surname:
      </td>
      <td width="34%" height="28">
        <input type="text" name="sname" size="31" value="<?php echo $row['Surname']; ?>" required>
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
        <select  name="gender" width="31" value="<?php echo $row['Gender']; ?>" required>  
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
  <input type="submit" value="Delete" name="submit"  onclick="return confirm('Are you sure you want to Delete?');"> &nbsp;
<?php
} ?>
  </p>
  </div>
</body>
</form>
<?php
 }
}
?>

			<p></td>
		</tr><tr><td align="right"><font size="2"><?php 
 require_once 'footr.php';
 require_once 'footer.php';
?></td></tr>
	</table>
</div>

