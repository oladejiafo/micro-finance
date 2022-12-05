<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & $_SESSION['access_lvl'] != 5) 
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}

 require_once 'header2.php';
 require_once 'conn.php';
 require_once 'style.php';

@$id=$_REQUEST['id'];
@$tval=$_REQUEST['tval'];


$sql="SELECT * FROM `loan application` WHERE `ID`='$id'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);

?>
<link rel="stylesheet" href="css/refreshform.css" />
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

<div align="center">
	<table border="0" bordercolor='#003300' width="100%" cellspacing="1" bgcolor="#EFEFEF" id="table1" style="background: url(images/bggx4.png) no-repeat center; background-color:#EFEFEF"">
		<tr align='center'>
 <td bgcolor="#000000"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Loan Application Manager</font></b>
 </td>
</tr>
		<tr>
			<td>

<fieldset style="padding: 2">
<br>
<b><font color="#FF0000" style="font-size: 9pt"><?php echo $tval ; ?></font></b>	

<form method="post" action="lnhandle.php">
<div align="center">
<fieldset style="padding: 2; width:750; align:center;">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Personal Information</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        First Name:<br>
        <input type="textt" readonly="readonly" name="fname" size="15" value="<?php echo $row['First Name']; ?>">
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Middle Name(s):<br>
        <input type="textt" readonly="readonly" name="mname" size="15" value="<?php echo $row['Middle Name']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Surname:<br>
        <input type="textt" readonly="readonly" name="sname" size="15" value="<?php echo $row['Surname']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Maiden Name:<br>
        <input type="textt" readonly="readonly" name="oname" size="15" value="<?php echo $row['Maiden Name']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Marital Status:<br>
        <input type="textt" readonly="readonly" size="15"  name="mstatus" value="<?php echo $row['Marital Status']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Gender:<br>
        <input type="textt" readonly="readonly" name="gender" value="<?php echo $row['Gender']; ?>">  
      </td>
    </tr>
    <tr>
      <td height="40" style="height:80; font-size: 13pt">
        Date of Birth:<br>
       <input type="textt" readonly="readonly" size="15" name="dob" value="<?php echo $row['DoB']; ?>">
      </td>
      <td height="40" style="height:80; font-size: 13pt">
        Mobile Number:<br>
        <input type="textt" readonly="readonly" name="mobileno" size="15" value="<?php echo $row['Mobile Number']; ?>">  
      </td>
      <td height="40" style="height:80; font-size: 13pt">
        Contact Number:<br>
        <input type="textt" readonly="readonly" name="contactno" size="15" value="<?php echo $row['Contact Number']; ?>">  
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Means of Identification:<br>
        <input type="textt" readonly="readonly" name="idtype" value="<?php echo $row['Identification Type']; ?>">  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        e-Mail Address:<br>
        <input type="textt" readonly="readonly" id="email" name="email" size="15" value="<?php echo $row['email']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        No of Children:<br>
        <input type="textt" readonly="readonly" name="children" size="15" value="<?php echo $row['Children']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        No in Household:<br>
        <input type="textt" readonly="readonly" name="household" size="15" value="<?php echo $row['Household']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Residential Status:<br>
        <input type="textt" readonly="readonly" name="restatus" value="<?php echo $row['Residential Status']; ?>">  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Home Address:<br>
        <input type="textt" readonly="readonly" name="address" value="<?php echo $row['Address']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Previous Address:<br>
        <input type="textt" readonly="readonly" name="prevaddress" value="<?php echo $row['Previous Address']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Duration at Cur Address:<br>
        <input type="textt" readonly="readonly" name="homeduration" size="15" value="<?php echo $row['Home Duration']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Local Govt Area:<br>
        <input type="textt" readonly="readonly" name="lga" size="1" value="<?php echo @$row['LGA']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        State:<br>
        <input type="textt" readonly="readonly" name="state" size="1" value="<?php echo @$row['State']; ?>">
      </td>
      <td height="40" style="height:80; font-size: 13pt">
        Nearest Landmark:<br>
       <input type="textt" readonly="readonly" size="15" name="landmark" value="<?php echo $row['Landmark']; ?>">
      </td>
      <td height="40" style="height:80; font-size: 13pt">
        Nearest Bus Stop:<br>
        <input type="textt" readonly="readonly" name="busstop" size="15" value="<?php echo $row['Bus Stop']; ?>">  
      </td>
    </tr>
    <tr>
      <td height="40" style="height:80; font-size: 13pt">
        Av. Monthly Expense:<br>
        <input type="textt" readonly="readonly" name="monthlyexp" size="15" value="<?php echo $row['Monthly Expenses']; ?>">  
      </td>
      <td align='left' height='80'> 
       <font color='red'>Personal Info Remarks:</font>
      </td>
      <td align='left' height='80'> 
       <textarea name="personal_remark"><?php echo $row['Personal_Remark']; ?></textarea>
      </td>
    </tr>
  </table>
 </fieldset>
</div>
<p>
<div align="center">
<fieldset style="padding: 2; width:750; align:center;">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Income Details</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Net Monthly Income:<br>
        <input type="textt" readonly="readonly" name="income" size="15" value="<?php echo $row['Income']; ?>">
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Other Income:<br>
        <input type="textt" readonly="readonly" name="otherincome" size="15" value="<?php echo $row['Other Income']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Pay Day:<br>
        <input type="textt" readonly="readonly" name="paydate" size="15" value="<?php echo @$row['Pay Date']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="120" style="height:90; font-size: 13pt">
        Running Loan (If Any):<br>
        <input type="textt" readonly="readonly" name="runningloan" size="15" value="<?php echo $row['Running Loan']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Unreflected Loans:<br>
        <input type="textt" readonly="readonly" name="otherloans" size="15" value="<?php echo $row['Other Loans']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Monthly Repayment:<br>
        <input type="textt" readonly="readonly" name="repayment" size="15" value="<?php echo $row['Monthly Repayment']; ?>">
      </td>
    </tr>

    <tr>
      <td align='left' height='80'> 
       <font color='red'>Income Info Remarks:</font>
      </td>
      <td align='left' height='80'> 
       <textarea name="income_remark"><?php echo $row['Income_Remark']; ?></textarea>
      </td>
    </tr>
  </table>
 </fieldset>
</div>
<p>

<div align="center">
<fieldset style="padding: 2; width:750; align:center;">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Employment/Education Details</font></i></b></legend>

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Employment Type:<br>
        <input type="textt" readonly="readonly" name="employment" value="<?php echo $row['Employment Type']; ?>">  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Current Employer:<br>
        <input type="textt" readonly="readonly" name="employer" size="15" value="<?php echo $row['Current Employer']; ?>">
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Employment Date:<br>
        <input type="textt" readonly="readonly" name="empdate" size="15" value="<?php echo $row['Employment Date']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Staff ID#:<br>
        <input type="textt" readonly="readonly" name="staffid" size="15" value="<?php echo $row['Staff ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Job Title/Position:<br>
        <input type="textt" readonly="readonly" name="jobtitle" size="15" value="<?php echo $row['Job Title']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Employer's Phone (HR):<br>
        <input type="textt" readonly="readonly" name="empphone" size="15" value="<?php echo $row['Employer Phone']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Office Address:<br>
        <input type="textt" readonly="readonly" name="officeaddress" value="<?php echo $row['Office Address']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Office LGA:<br>
        <input type="textt" readonly="readonly" name="officelga" value="<?php echo @$row['Office LGA']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Office Location (State):<br>
        <input type="textt" readonly="readonly" name="officestate" value="<?php echo @$row['Office State']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Official Email:<br>
        <input type="textt" readonly="readonly" name="officialemail" size="15" value="<?php echo $row['Official Email']; ?>">
        <input type="hidden" name="id" size="15" value="<?php echo $row['ID']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Industry/Sector Type:<br>
        <input type="textt" readonly="readonly" name="industrytype" size="15" value="<?php echo $row['Industry Type']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Prev Employment Duration:<br>
        <input type="textt" readonly="readonly" name="prevdur" size="15" value="<?php echo $row['Previous Duration']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Total Past Employers:<br>
        <input type="textt" readonly="readonly" name="pastemployers" size="15" value="<?php echo $row['Past Employers']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Education Level:<br>
        <input type="textt" readonly="readonly" name="edulevel" value="<?php echo $row['Education Level']; ?>">  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Last Institution:<br>
        <input type="textt" readonly="readonly" name="institution" size="15" value="<?php echo $row['Institution']; ?>">
      </td>
    </tr>
    <tr>
      <td align='left' height='80'> 
       <font color='red'>Employment Info Remarks:</font>
      </td>
      <td align='left' height='80'> 
       <textarea name="employment_remark"><?php echo $row['Employment_Remark']; ?></textarea>
      </td>
    </tr>
  </table>
 </fieldset>
</div>
<p>

<div align="center">
<fieldset style="padding: 2; width:750; align:center;">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Next of Kin Info</font></i></b></legend>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Next of Kin Name:<br>
        <input type="textt" readonly="readonly" name="nkname" size="15" value="<?php echo $row['NK Name']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Relationship:<br>
        <input type="textt" readonly="readonly" name="nkrelationship" value="<?php echo $row['NK Relationship']; ?>"> 
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Mobile Phone:<br>
        <input type="textt" readonly="readonly" name="nkphone" size="15" value="<?php echo $row['NK Phone']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Address:<br>
        <input type="textt" readonly="readonly" name="nkaddress" value="<?php echo $row['NK Address']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK LGA:<br>
        <input type="textt" readonly="readonly" name="nklga" size="1" value="<?php echo @$row['NK LGA']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Location (State):<br>
        <input type="textt" readonly="readonly" name="nkstate" size="1" value="<?php echo @$row['NK State']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK e-Mail Address:<br>
        <input type="textt" readonly="readonly" id="email" name="nkemail" size="15" value="<?php echo $row['NK email']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Employer:<br>
        <input type="textt" readonly="readonly" name="nkemployer" value="<?php echo $row['NK Employer']; ?>">  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        NK Job Title:<br>
        <input type="textt" readonly="readonly" name="nkjobtitle" size="15" value="<?php echo $row['NK Job Title']; ?>">
      </td>
    </tr>
    <tr>
      <td align='left' height='80'> 
       <font color='red'>Next of Kin Info Remarks:</font>
      </td>
      <td align='left' height='80'> 
       <textarea name="nk_remark"><?php echo $row['NK_Remark']; ?></textarea>
      </td>
    </tr>
  </table>
 </fieldset>
</div>
<p>

<div align="center">
<fieldset style="padding: 2; width:750; align:center; height:370">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green">Bank/Loan Details</font></i></b></legend>

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Bank:<br>
        <input type="textt" readonly="readonly" name="bank" size="15" value="<?php echo $row['Bank']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Account Number:<br>
        <input type="textt" readonly="readonly" name="accountnum" value="<?php echo $row['Account Number']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Account Name:<br>
        <input type="textt" readonly="readonly" name="accountname" size="15" value="<?php echo $row['Account Name']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        BVN Number:<br>
        <input type="textt" readonly="readonly" name="bvn" size="15" value="<?php echo $row['BVN']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Account Type:<br>
        <input type="textt" readonly="readonly" name="accounttype" size="1" value="<?php echo @$row['Account Type']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Bank Branch:<br>
        <input type="textt" readonly="readonly" name="branch" size="15" value="<?php echo $row['Branch']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Requested Loan Amount:<br>
        <input type="textt" readonly="readonly" name="loanamount" id="loanamount" size="15" value="<?php echo $row['Loan Amount']; ?>">
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Loan Tenor (Month):<br>
        <input type="textt" readonly="readonly" name="tenor" id="tenor" value="<?php echo $row['Tenor']; ?>">  
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Monthly Installment:<br>
        <input type="textt" readonly="readonly" id="repayment" name="repayment" size="15" value="<?php echo $row['Repayment']; ?>">
      </td>
    </tr>
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        Loan Purpose:<br>
        <input type="textt" readonly="readonly" name="purpose" size="15" value="<?php echo $row['Purpose']; ?>">
      </td>
      <td align='left' height='80'> 
       <font color='red'>Bank/Loan Info Remarks:</font>
      </td>
      <td align='left' height='80'> 
       <textarea name="bank_remark"><?php echo $row['Bank_Remark']; ?></textarea>
      </td>
    </tr>
  </table>
 </fieldset>
</div>
<p>
<div align="center">
<fieldset style="padding: 2; width:750; align:center;">
<legend><b><i><font style="height:35; font-size: 13pt" face="Tahoma" color="green"></font></i></b></legend>

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1">
    <tr>
      <td width="30%" height="80" style="height:80; font-size: 13pt" valign='top' align='center'>
       Authorization Approval?<br>
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
      </td>
      <td width="30%" height="80" style="height:80; font-size: 13pt" valign='top' align='center'>
        Accepted Term & Conditions? <br>
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
      <td width="30%" height="80" style="height:80; font-size: 13pt">
        <input name="submit" type="submit" value="Close Form" align="top" style="height:35; color:#008000; font-size: 15pt">
      </td>
      <td colspan=1 align='left' height='80'> <input name="submit" type="submit" value="Disapprove Loan" align="top" style="height:35; color:#008000; font-size: 15pt" onclick="return confirm('Are you sure you want to Disapprove?');"></td>
      <td colspan=1 align='left' height='80'> <input name="submit" type="submit" value="Approve Loan" align="top" style="height:35; color:#008000; font-size: 15pt" onclick="return confirm('Are you sure you want to Approve?');"></td>
    </tr>
  </table>
 </fieldset>
</div>
</form>


			<p></td>
		</tr>
<tr bgcolor='#000000'><td align="right"><font size="2">
&nbsp;
</td></tr>
	</table>
</div>
