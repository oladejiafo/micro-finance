<?php
session_start();
//check to see if user has logged in with a valid password

 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];

@$Tit=$_SESSION['Tit'];
@$acctno=$_REQUEST['acctno'];
@$tval=$_REQUEST['tval'];
@$tvalg=$_REQUEST['tvalg'];
@$grp=$_REQUEST['grp'];
@$id=$_SESSION['idx'];

$sql="SELECT * FROM `loan application` WHERE `ID`='$id'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
$_SESSION['idx']="";
?>
<link rel="stylesheet" href="css/refreshform.css" />
    <title>Sarcen Loan Application</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<!-- 	
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.css" />
   <link rel="shortcut icon" href="favicon.ico">
-->
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%m-%Y"

		});
		new JsDatePick({
			useMode:2,
			target:"inputField2",
			dateFormat:"%d-%m-%Y"

		});
		new JsDatePick({
			useMode:2,
			target:"inputField3",
			dateFormat:"%d-%m-%Y"

		});
	};
</script>
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

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    console.log(charCode)
    if (charCode == 45 || charCode == 46 || charCode == 37 || charCode == 39) {
        return true;
    } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function()
{
$("#email").change(function() 
{ //if theres a change in the email textbox
 
var email = $("#email").val();//Get the value in the email textbox
if(email.length > 3)//if the lenght greater than 3 characters
{
$("#availability_status").html('Checking availability...');
//Add a loading image in the span id="availability_status"
 
$.ajax({  //Make the Ajax Request
    type: "POST",  
    url: "ajax_check_username.php",  //file name
    data: "email="+$(this).attr("value"),  //data
    success: function(server_response){  
    
   $("#availability_status").ajaxComplete(function(event, request){ 
 
    if(server_response == '0')//if ajax_check_username.php return value "0"
    { 
    $("#availability_status").html('<font color="Green"> </font>  ');
    //add this image to the span with id "availability_status"
    }  
    else  if(server_response == '1')//if it returns "1"
    {  
     $("#availability_status").html('<font color="red">Already Registered </font>');
    }  
    else  if(server_response == '2')//if it returns "1"
    {  
     $("#availability_status").html('<font color="red">Not existing </font>');
    }      
   });
   } 
    
  }); 
 
}
else
{
 
$("#availability_status").html('<font color="#cc0000">Invalid</font>');
//if in case the username is less than or equal 3 characters only 
}
  
return false;
});

$("#mobileno").change(function() 
{ 
var mobileno = $("#mobileno").val();
if(mobileno.length > 7)
{
$("#availability_statuss").html('Checking availability...');
 
$.ajax({  
    type: "POST",  
    url: "ajax_check_mobileno.php", 
    data: "mobileno="+$(this).attr("value"), 
    success: function(server_responses){  
    
   $("#availability_statuss").ajaxComplete(function(event, request){ 
 
    if(server_responses == '0')
    { 
     $("#availability_statuss").html('<font color="Green"> </font>  ');
    }  
    else  if(server_responses == '1')
    {  
     $("#availability_statuss").html('<font color="red">Already Registered </font>');
    }  
   });
   } 
    
  }); 
 
}
else
{
 
$("#availability_statuss").html('<font color="#cc0000">Invalid Mobile No</font>');
}
  
return false;
});

});
</script>
<style type="text/css">
body {
    font-family:Arial, Helvetica, sans-serif
}
#availability_status {
    font-size:11px;
    margin-left:10px;
}
</style>

<table width='100%' bgcolor='#EFEFEF'>
<tr><td rowspan='5' valign='top' width='150'>
<img src='images/logo.jpg' width='120' height='140'></td></tr>
<tr><td width='460' align='left'><font style='font-size: 15pt'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='460'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td><td></td></tr>
<tr><td width='460'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td><td></td></tr>

</table>

<div align="center">
	<table border="0" bordercolor='#003300' width="100%" cellspacing="1" bgcolor="#EFEFEF" id="table1" style="background: url(images/bgg4x.png) no-repeat center; background-color:#EFEFEF">
		<tr align='center'>
 <td bgcolor="#000000" style="height: 90; background: url(images/loanns.png) no-repeat right;  background-color:#990000"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Loan Application</font></b>
 </td>
</tr>
		<tr>
			<td>

<fieldset style="padding: 2">
<br>
<b><font color="#FF0000" style="font-size: 9pt"><?php echo $tval ; ?></font></b>	
<?php
if(!isset($_SESSION['stage']) or $_SESSION['stage']=="")
{
 $_SESSION['stage']="1";
}

if(isset($_SESSION['stage']) and $_SESSION['stage']==1)
{
?>
<p>
<form method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:380">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Personal Information</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        First Name:<br>
        <input type="text" name="fname" size="15" value="<?php echo $row['First Name']; ?>" required>
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Middle Name(s):<br>
        <input type="text" name="mname" size="15" value="<?php echo $row['Middle Name']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Surname:<br>
        <input type="text" name="sname" size="15" value="<?php echo $row['Surname']; ?>" required>
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Maiden Name:<br>
        <input type="text" name="oname" size="15" value="<?php echo $row['Maiden Name']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Marital Status:<br>
        <select name="mstatus" value="<?php echo $row['Marital Status']; ?>" required>  
          <?php  
           echo '<option selected>' . $row['Marital Status'] . '</option>';
           echo '<option>Married</option>';
           echo '<option>Single</option>';
           echo '<option>Divorced</option>';
           echo '<option>Widowed</option>';
          ?> 
         </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Gender:<br>
        <select  name="gender" value="<?php echo $row['Gender']; ?>" required>  
          <?php  
           echo '<option selected>' . $row['Gender'] . '</option>';
           echo '<option>Female</option>';
           echo '<option>Male</option>';
          ?> 
         </select>
      </td>
    </tr>
    <tr>
      <td height="40" style="height:80; font-size: 13pt">
        Date of Birth:<br>
       <input id="inputField" type="text" size="15" name="dob" value="<?php echo $row['DoB']; ?>">
      </td>
      <td height="40" style="height:80; font-size: 13pt">
        Mobile Number:<br>
        <div><input type="text" name="mobileno" size="15" value="<?php echo $row['Mobile Number']; ?>" required>  
        <span id="availability_statuss"></span> </div>
      </td>
      <td height="40" style="height:80; font-size: 13pt">
        Contact Number:<br>
        <input type="text" name="contactno" size="15" value="<?php echo $row['Contact Number']; ?>">  
      </td>
    </tr>
    <tr>
      <td colspan=3 align='right' height='90'> <input name="submit" type="submit" value="Proceed to Stage 2 >>" align="top" style="height:35; color:#ffffff; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}

if(isset($_SESSION['stage']) and $_SESSION['stage']==2)
{
?>
<p>
<form id="formx" method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Personal Information (Cont'd)</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Means of Identification:<br>
        <select  name="idtype" value="<?php echo $row['Identification Type']; ?>" required>  
          <?php  
           echo '<option selected>' . $row['Identification Type'] . '</option>';
           echo '<option>Drivers Licence</option>';
           echo '<option>International Passport</option>';
           echo '<option>National ID Card</option>';
           echo '<option>Staff ID Card</option>';
           echo '<option>Others</option>';
          ?> 
         </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        e-Mail Address:<br>
        <input type="text" id="email" name="email" size="15" value="<?php echo $row['email']; ?>">
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
     <span id="availability_status"></span> </div>
      </td>

    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        No of Children:<br>
        <input type="text" name="children" size="15" value="<?php echo $row['Children']; ?>" onkeypress="return isNumber(event)">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        No in Household:<br>
        <input type="text" name="household" size="15" value="<?php echo $row['Household']; ?>" onkeypress="return isNumber(event)">
      </td>
    </tr>
    <tr>
      <td colspan=1 align='left' height='90'> <input name="submit" type="submit" value="<< Return to Stage 1" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
      <td colspan=1 align='left' height='90'> <input name="submit" type="submit" value="Proceed to Stage 3 >>" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}

if(isset($_SESSION['stage']) and $_SESSION['stage']==3)
{
?>
<p>
<form id="formx" method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Personal Information (Cont'd)</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Residential Status:<br>
        <select  name="restatus" value="<?php echo $row['Residential Status']; ?>" required>  
          <?php  
           echo '<option selected>' . $row['Residential Status'] . '</option>';
           echo '<option>Temporary Residence</option>';
           echo '<option>Family House</option>';
           echo '<option>Rented</option>';
           echo '<option>Owned</option>';
           echo '<option>Provided by Employer</option>';
          ?> 
         </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Home Address:<br>
        <textarea name="address"><?php echo $row['Address']; ?></textarea>
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Previous Address:<br>
        <textarea name="prevaddress"><?php echo $row['Previous Address']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Duration at Cur Address:<br>
        <input type="text" name="homeduration" size="15" value="<?php echo $row['Home Duration']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Local Govt Area:<br>
        <select name="lga" size="1" value="<?php echo @$row['LGA']; ?>">
          <option selected><?php echo @$row['LGA']; ?></option>
          <?php  
         	$sqlt = "SELECT `LGA` FROM `lga` ORDER BY `State`;";
        	$resultt = mysqli_query($conn,$sqlt) or die('Invalid query: ' . mysqli_error());
        	while ($rows = mysqli_fetch_array($resultt))
		{
		  echo " <option>" . $rows['LGA'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        State:<br>
        <select name="state" size="1" value="<?php echo @$row['State']; ?>">
          <option selected><?php echo @$row['State']; ?></option>
          <?php  
         	$sqlt = "SELECT `State` FROM `state` ORDER BY `State`;";
        	$resultt = mysqli_query($conn,$sqlt) or die('Invalid query: ' . mysqli_error());
        	while ($rows = mysqli_fetch_array($resultt))
		{
		  echo " <option>" . $rows['State'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
    </tr>
    <tr>
      <td height="40" style="height:80; font-size: 13pt">
        Nearest Landmark:<br>
       <input type="text" size="15" name="landmark" value="<?php echo $row['Landmark']; ?>">
      </td>
      <td height="40" style="height:80; font-size: 13pt">
        Nearest Bus Stop:<br>
        <input type="text" name="busstop" size="15" value="<?php echo $row['Bus Stop']; ?>">  
      </td>
      <td height="40" style="height:80; font-size: 13pt">
        Av. Monthly Expense:<br>
        <input type="text" name="monthlyexp" size="15" value="<?php echo $row['Monthly Expenses']; ?>" onkeypress="return isNumber(event)">  
      </td>
    </tr>
    <tr>
      <td colspan=2 align='left' height='90'> <input name="submit" type="submit" value="<< Return to Stage 2" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
      <td colspan=1 align='left' height='90'> <input name="submit" type="submit" value="Proceed to Stage 4 >>" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}

if(isset($_SESSION['stage']) and $_SESSION['stage']==4)
{
?>
<p>
<form id="formx" method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Income Details</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Net Monthly Income:<br>
        <input type="text" name="income" size="15" value="<?php echo $row['Income']; ?>" onkeypress="return isNumber(event)" required>
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Other Income:<br>
        <input type="text" name="otherincome" size="15" value="<?php echo $row['Other Income']; ?>" onkeypress="return isNumber(event)">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Pay Day:<br>
        <input type="text" name="paydate" size="15" value="<?php echo @$row['Pay Date']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="120" style="height:90; font-size: 13pt">
        Running Loan (If Any):<br>
        <input type="text" name="runningloan" size="15" value="<?php echo $row['Running Loan']; ?>" onkeypress="return isNumber(event)">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Unreflected Loans:<br>
        <input type="text" name="otherloans" size="15" value="<?php echo $row['Other Loans']; ?>" onkeypress="return isNumber(event)">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Monthly Repayment:<br>
        <input type="text" name="repayment" size="15" value="<?php echo $row['Monthly Repayment']; ?>" onkeypress="return isNumber(event)">
      </td>
    </tr>

    <tr>
      <td colspan=2 align='left' height='90'> <input name="submit" type="submit" value="<< Return to Stage 3" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
      <td colspan=1 align='left' height='90'> <input name="submit" type="submit" value="Proceed to Stage 5 >>" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}

if(isset($_SESSION['stage']) and $_SESSION['stage']==5)
{
?>
<p>
<form id="formx" method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Employment Details</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Employment Type:<br>
        <select name="employment" value="<?php echo $row['Employment Type']; ?>" required>  
          <?php  
           echo '<option selected>' . $row['Employment Type'] . '</option>';
           echo '<option>Permanent</option>';
           echo '<option>Temporary</option>';
           echo '<option>Contract</option>';
           echo '<option>Self Employed</option>';
           echo '<option>Unemployed</option>';
          ?> 
         </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Current Employer:<br>
        <input type="text" name="employer" size="15" value="<?php echo $row['Current Employer']; ?>" required>
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Employment Date:<br>
        <input id="inputField" type="text" name="empdate" size="15" value="<?php echo $row['Employment Date']; ?>" required>
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Staff ID#:<br>
        <input type="text" name="staffid" size="15" value="<?php echo $row['Staff ID']; ?>" required>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Job Title/Position:<br>
        <input type="text" name="jobtitle" size="15" value="<?php echo $row['Job Title']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Employer's Phone (HR):<br>
        <input type="text" name="empphone" size="15" value="<?php echo $row['Employer Phone']; ?>" required>
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Office Address:<br>
        <textarea name="officeaddress"><?php echo $row['Office Address']; ?></textarea>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Office LGA:<br>
        <select name="officelga" size="1" value="<?php echo @$row['Office LGA']; ?>">
          <option selected><?php echo @$row['Office LGA']; ?></option>
          <?php  
         	$sqlt = "SELECT `LGA` FROM `lga` ORDER BY `State`;";
        	$resultt = mysqli_query($conn,$sqlt) or die('Invalid query: ' . mysqli_error());
        	while ($rows = mysqli_fetch_array($resultt))
		{
		  echo " <option>" . $rows['LGA'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Office Location (State):<br>
        <select name="officestate" size="1" value="<?php echo @$row['Office State']; ?>">
          <option selected><?php echo @$row['Office State']; ?></option>
          <?php  
         	$sqlt = "SELECT `State` FROM `state` ORDER BY `State`;";
        	$resultt = mysqli_query($conn,$sqlt) or die('Invalid query: ' . mysqli_error());
        	while ($rows = mysqli_fetch_array($resultt))
		{
		  echo " <option>" . $rows['State'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
    </tr>

    <tr>
      <td colspan=2 align='left' height='90'> <input name="submit" type="submit" value="<< Return to Stage 4" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
      <td colspan=1 align='left' height='90'> <input name="submit" type="submit" value="Proceed to Stage 6 >>" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}
if(isset($_SESSION['stage']) and $_SESSION['stage']==6)
{
?>
<p>
<form id="formx" method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Employment/Education Details</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Official Email:<br>
        <input type="text" name="officialemail" size="15" value="<?php echo $row['Official Email']; ?>">
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Industry/Sector Type:<br>
        <input type="text" name="industrytype" size="15" value="<?php echo $row['Industry Type']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Prev Employment Duration:<br>
        <input type="text" name="prevdur" size="15" value="<?php echo $row['Previous Duration']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Total Past Employers:<br>
        <input type="text" name="pastemployers" size="15" value="<?php echo $row['Past Employers']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Education Level:<br>
        <select name="edulevel" value="<?php echo $row['Education Level']; ?>">  
          <?php  
           echo '<option selected>' . $row['Education Level'] . '</option>';
           echo '<option>Secondary</option>';
           echo '<option>Graduate</option>';
           echo '<option>Post-Graduate</option>';
           echo '<option>Doctorate</option>';
          ?> 
         </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Last Institution:<br>
        <input type="text" name="institution" size="15" value="<?php echo $row['Institution']; ?>" required>
      </td>
    </tr>

    <tr>
      <td colspan=2 align='left' height='90'> <input name="submit" type="submit" value="<< Return to Stage 5" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
      <td colspan=1 align='left' height='90'> <input name="submit" type="submit" value="Proceed to Stage 7 >>" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}
if(isset($_SESSION['stage']) and $_SESSION['stage']==7)
{
?>
<p>
<form id="formx" method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Next of Kin Info</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Next of Kin Name:<br>
        <input type="text" name="nkname" size="15" value="<?php echo $row['NK Name']; ?>" required>
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Relationship:<br>
        <input type="text" name="nkrelationship" value="<?php echo $row['NK Relationship']; ?>" required>  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Mobile Phone:<br>
        <input type="text" name="nkphone" size="15" value="<?php echo $row['NK Phone']; ?>" required>
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Address:<br>
        <textarea name="nkaddress"><?php echo $row['NK Address']; ?></textarea>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK LGA:<br>
        <select name="nklga" size="1" value="<?php echo @$row['NK LGA']; ?>">
          <option selected><?php echo @$row['NK LGA']; ?></option>
          <?php  
         	$sqlt = "SELECT `LGA` FROM `lga` ORDER BY `State`;";
        	$resultt = mysqli_query($conn,$sqlt) or die('Invalid query: ' . mysqli_error());
        	while ($rows = mysqli_fetch_array($resultt))
		{
		  echo " <option>" . $rows['LGA'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Location (State):<br>
        <select name="nkstate" size="1" value="<?php echo @$row['NK State']; ?>">
          <option selected><?php echo @$row['NK State']; ?></option>
          <?php  
         	$sqlt = "SELECT `State` FROM `state` ORDER BY `State`;";
        	$resultt = mysqli_query($conn,$sqlt) or die('Invalid query: ' . mysqli_error());
        	while ($rows = mysqli_fetch_array($resultt))
		{
		  echo " <option>" . $rows['State'] . "</option>\n";
		}
          ?> 
        </select>
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK e-Mail Address:<br>
        <input type="text" id="email" name="nkemail" size="15" value="<?php echo $row['NK email']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Employer:<br>
        <input type="text" name="nkemployer" value="<?php echo $row['NK Employer']; ?>">  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Job Title:<br>
        <input type="text" name="nkjobtitle" size="15" value="<?php echo $row['NK Job Title']; ?>" required>
      </td>
    </tr>

    <tr>
      <td colspan=2 align='left' height='90'> <input name="submit" type="submit" value="<< Return to Stage 6" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
      <td colspan=1 align='left' height='90'> <input name="submit" type="submit" value="Proceed to Stage 8 >>" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}
if(isset($_SESSION['stage']) and $_SESSION['stage']==8)
{
?>

<p>
<form id="formx" name="form" method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Bank/Loan Details</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Bank:<br>
        <input type="text" name="bank" size="15" value="<?php echo $row['Bank']; ?>" required>
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Account Number:<br>
        <input type="text" name="accountnum" value="<?php echo $row['Account Number']; ?>" required>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Account Name:<br>
        <input type="text" name="accountname" size="15" value="<?php echo $row['Account Name']; ?>" required>
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        BVN Number:<br>
        <input type="text" name="bvn" size="15" value="<?php echo $row['BVN']; ?>" onkeypress="return isNumber(event)" required>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Account Type:<br>
        <select name="accounttype" size="1" value="<?php echo @$row['Account Type']; ?>">
          <option selected><?php echo @$row['Account Type']; ?></option>
          <option>Current Account</option>
          <option>Saving Account</option>
        </select>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Bank Branch:<br>
        <input type="text" name="branch" size="15" value="<?php echo $row['Branch']; ?>">
      </td>
    </tr>
    <tr>
<script type="text/javascript" language="javascript">

$(document).ready (function() {
$('#tenor').keyup(function(){
      $('#repayment').text($('#loanamount').val()/$(#tenor).val());
      });
});
</script>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Requested Loan Amount:<br>
        <input type="text" name="loanamount" id="loanamount" size="15" value="<?php echo $row['Loan Amount']; ?>" onkeypress="return isNumber(event)" required>
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Loan Tenor (Month):<br>
        <input type="text" name="tenor" id="tenor" value="<?php echo $row['Tenor']; ?>" onkeypress="return isNumber(event)">  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Monthly Installment:<br>
        <span id="repayment"></span><input type="text" id="repayment" name="repayment" size="15" value="<?php echo $row['Repayment']; ?>" onkeypress="return isNumber(event)">
      </td>
    </tr>

    <tr>
      <td colspan=1 align='left' height='90'> &nbsp;<br><br><input name="submit" type="submit" value="<< Return to Stage 7" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Loan Purpose:<br>
        <input type="text" name="purpose" size="15" value="<?php echo $row['Purpose']; ?>">
      </td>
      <td colspan=1 align='left' height='90'> &nbsp;<br><br> <input name="submit" type="submit" value="Proceed to Finish >>" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}
if(isset($_SESSION['stage']) and $_SESSION['stage']==9)
{
?>
<p>
<form id="formx" method="post" action="submitlapp.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green"></font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="60%" colspan=2 height="80" style="height:80; font-size: 13pt">
<p align='justify'>
<font color='#000000'>
I hereby confirm my application for the above facility and certify that all imformation provided by me above and attached is correct and complete. I authorize 
YOU to make any enquiry you consider necessary and appropriate for the purpose of evaluating this application.
</font> 
</p>

      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt" valign='top' align='center'>
        <?php
          $sql = "SELECT `val`,`type` FROM `booln` ORDER BY `type` desc";
          $result_cn = mysqli_query($conn,$sql) or die('Could not list; ' . mysqli_error());

          $cn=$row['Authorize'];

          while ($rows = mysqli_fetch_array($result_cn)) 
          {
           echo ' <input type="radio" class="radio" align="left" id="cn_' . $rows['val'] . '" name="authorize" value="' . $rows['val'] . '" ';
           if ($rows['val'] == $cn) 
           {
             echo 'checked="checked" ';
           }
           echo '/><font color=#FF0000>' . $rows['type'] . "</font>\n";
          }
        ?>
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
    </tr>
    <tr>
      <td colspan=3 width="90%" height="10" style="height:10; font-size: 13pt">

      </td>
    </tr>
    <tr>
      <td width="60%" colspan=2 height="80" style="height:80; font-size: 13pt">
<p align='justify'>
<font color='#000000'>
I have read through the <a href='#'>Terms & Conditions</a> and hereby agree to the terms and conditions.
</font> 
</p>

      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt" valign='top' align='center'>
        <?php
          $sql = "SELECT `val`,`type` FROM `booln` ORDER BY `type` desc";
          $result_cn = mysqli_query($conn,$sql) or die('Could not list; ' . mysqli_error());

          $cn=$row['Terms'];

          while ($rows = mysqli_fetch_array($result_cn)) 
          {
           echo ' <input type="radio" class="radio" align="left" id="cn_' . $rows['val'] . '" name="terms" value="' . $rows['val'] . '" ';
           if ($rows['val'] == $cn) 
           {
             echo 'checked="checked" ';
           }
           echo '/><font color=#FF0000>' . $rows['type'] . "</font>\n";
          }
        ?>

      </td>

    </tr>

    <tr>
      <td colspan=1 align='left' height='90'> &nbsp;<br><br><input name="submit" type="submit" value="CANCEL" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">

      </td>
      <td colspan=1 align='left' height='90'> &nbsp;<br><br> <input name="submit" type="submit" value="SUBMIT" align="top" style="height:35; color:#FFFFFF; font-size: 15pt"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>
<?php
}
?>

			<p></td>
		</tr>
	</table>
</div>
