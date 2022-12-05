<?php
require_once 'header.php';
require_once 'conn.php';
require_once 'style.php';

$UID=$_REQUEST['UID'];
$tval=$_REQUEST['tval'];
?>
<script src="../lib/jquery.js"></script>
<script src="../dist/jquery.validate.js"></script>
<link href='css/emailvalidation.css' rel='stylesheet' type='text/css'>

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
<!-- load jquery ui css-->
<link href="js/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<!-- load jquery library -->
<script src="js/jquery-1.9.1.js"></script>
<!-- load jquery ui js file -->
<script src="js/jquery-ui.min.js"></script>

<div align="center">
<div class='row' style="background-color:#394247; width:100%" align="center">
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Create Your Profile</font></b>
 </div>
<br>
<?php
echo "<font color='#FF0000' style='font-size: 12px'>" . $tval . "</font>";
?>
<div id=registers align="center" style="font-size:12px">
<body onload="document.form1.acctno.focus()" onfocus="document.form1.acctno.focus()">
<form  class='cmxform' id='signupForm' name='form1' method='post' action='transact-user.php'  enctype='multipart/form-data'>
<div align="leftt" style="margin-left:20px;font-size:12px" class="agileinfo_mail_grids">
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Enter Your Company Name</span>
	</label>   
       <input type="text" name="company" style="height:50px" class="input__field input__field--chisato" placeholder=" " value="" required> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Enter Your Company Address</span>
	</label>   
       <input type="text" name="address" style="height:50px" class="input__field input__field--chisato" placeholder=" " value="" required> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Enter Your Country</span>
	</label>   
       <input type="text" name="country" style="height:50px" class="input__field input__field--chisato" placeholder=" " value="Nigeria" required> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Enter Your Company Website</span>
	</label>   
       <input type="url" name="city" style="height:50px" class="input__field input__field--chisato" placeholder="http://www.wg.com" value=""> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Enter Your Company Phone</span>
	</label>   
       <input type="text" name="phone" style="height:50px" class="input__field input__field--chisato" placeholder=" " value="" required> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Enter Your Company EMail</span>
	</label>   
       <input type="email" name="e-mail" style="height:50px" id="cemail" class="input__field input__field--chisato" placeholder="Valid Email Address" value="" required> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Enter Your Admin Username</span>
	</label>   
       <input type="text" name="uname" style="height:50px" id="username" autocomplete="off" class="input__field input__field--chisato" placeholder=" " value="" required> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Enter Your Admin Password</span>
	</label>   
       <input type="password" name="passwd" style="height:50px" id="password" autocomplete="off" class="input__field input__field--chisato" placeholder=" " value="" required> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Repeat Password</span>
	</label>   
       <input type="password" name="passwd2" style="height:50px" id="confirm_password" autocomplete="off" class="input__field input__field--chisato" placeholder=" " value="" required> 
      </span>
      <span class="input input--chisato" style="vertical-align:bottom">
	<div style="vertical-align:bottom">
	<span style="margin-left:2px">
	  Upload Your Logo [.JPG only]:<br>
	  <img border="1" src="images/pics/pix.jpg" width="240" height="140"><br>	 
	  <input style="margin-left:50px" name="image_filename" type="file" id="image_filename">
	</span>
	</div>
      </span>
</div>
<?php 

if ($UID) 
{ 
?>

<input type="hidden" name="user_id" value="<?php echo $UID; ?>" />
<input type="submit" class="submit" name="action"
value="Modify Profile" />

<input type="submit" class="submit" name="action"
value="Delete Profile"  onclick="return confirm('Are you sure you want to Delete?');"/>
<?php
 }
 else 
 {
 ?>

<input type="submit" id='btnValidate' class="submit" name="action" value="Register Me" />
<?php
}
?>
</div>
</body>

		</div>
</form>
