<?php 
session_start();
require_once 'header.php'; 
 require_once 'style.php';
?>

<div align="center">
<table border="0" width="100%" cellspacing="0" cellpadding="0" id="table1">
<tr>
<td>
<div align="center">
<table border="0" width="405" cellspacing="11" cellpadding="10" id="table2" bgcolor="#e8e7e6">
<tr>
<td>
<fieldset style="border: 1px solid #0099ff; padding-left: 4px; padding-right: 4px; padding-top: 1px; padding-bottom: 1px" >
<legend>
<font style="font-size: 16pt; font-weight: 700" face="Verdana" color="#0099ff">Contact Us</font></legend>

<form id="contact" name="contact" method="POST" action="submitfeedback.php">
  <p>Name:<br>
  <input id="name" style="WIDTH: 175px" maxLength="50" name="name"><br>
  Phone:<br>
  <input id="phone" style="WIDTH: 175px" maxLength="50" name="phone">
  <br>
  Email:<br>
  <input id="email" style="WIDTH: 175px" maxLength="50" name="email">
  <br>
  Comments/Questions:<br>
  <textarea id="comments" style="WIDTH: 250px" name="comment" rows="6" cols="30"></textarea>
  </p>
  <p>
  <input type="image" src="images/button_submit.gif" value="Submit" name="submit">
  </p>
</form>

<SCRIPT language=JavaScript type=text/javascript>
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("contact");
  frmvalidator.addValidation("name","req","Please enter your Name");
  frmvalidator.addValidation("name","maxlen=50","Max length for name is 50");
  frmvalidator.addValidation("name","alpha");
  
  frmvalidator.addValidation("email","req","Please enter your Email address");
  frmvalidator.addValidation("email","maxlen=100","Max length for email is 100");
  frmvalidator.addValidation("email","email");

  frmvalidator.addValidation("comments","req","Please enter your Comments");
  frmvalidator.addValidation("comments","maxlen=10000","Max length for comments is 10000 characters");
  frmvalidator.addValidation("comments","alphanum"); 
</SCRIPT>

	<p>&nbsp;</p>
	</fieldset><p>&nbsp;</td>
     </tr>
   </table>
  </div>
<p>&nbsp;</td>
</tr>
</table>
</div>

<?php 
 require_once 'footr.php'; 
 require_once 'footer.php';
?>
