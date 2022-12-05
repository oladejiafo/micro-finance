<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & $_SESSION['access_lvl'] != 5) 
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
#exit();

}

require_once 'conn.php';
require_once 'header.php';
require_once 'style.php';

@$UID=$_REQUEST['UID'];
@$tval=$_REQUEST['tval'];

$user_id = '';
$name = '';
$email = '';
$password = '';
$accesslvl = '';
if (isset($_GET['UID'])) {
$sql = "SELECT * FROM login WHERE user_id=" . $_GET['UID'];
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
$user_id = $_GET['UID'];
$name = $row['username'];
$email = $row['email'];
$accesslvl = $row['access_lvl'];
}
?>

<script language="JavaScript">
function checkForm()
{
   var cbillamt, camount, cdeduction;
   with(window.document.form1)
   {
      cbillamt   = billamt;
      camount    = amount;
      cdeduction = deduction;
   }

   if(!isNumeric(trim(camount.value)))
   {
      alert('Invalid amount. Do not put a coma');
      camount.focus();
      return false;
   }   
   else if(!isNumeric(trim(cbillamt.value)))
   {
      alert('Invalid amount. Do not put a coma');
      cbillamt.focus();
      return false;
   }
   else if(!isNumeric(trim(cdeduction.value)))
   {
      alert('Invalid amount. Do not put a coma');
      cdeduction.focus();
      return false;
   }
   else
   {
      return true;
   }
}

function trim(str)
{
   return str.replace(/^\s+|\s+$/g,'');
}

function isEmail(str)
{
   var regex = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;

return regex.test(str);
}

	function isNumeric(sText, decimalAllowed) {
		if (sText.length == 0) return false;
		var validChars = "";
		if (decimalAllowed) {
			validChars = "0123456789.";
		} else {
			validChars = "0123456789";
		}
		var isNumber = true;
		var charA;
		var decimalCount = 0;
		for (i = 0; i < sText.length && isNumber == true && decimalCount < 2; i++) {
			charA = sText.charAt(i); 
			if (charA == ".") { 
				decimalCount += 1;
			}
			if (validChars.indexOf(charA) == -1) {
			isNumber = false;
			}
		}
		return isNumber;
	}

function validateNumber(evt) {
    var e = evt || window.event;
    var key = e.charCode || e.keyCode || e.which;

    if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
    // numbers   
    key >= 48 && key <= 57 ||
    // Numeric keypad
    key >= 96 && key <= 105 ||
    // Backspace and Tab and Enter
    key == 8 || key == 9 || key == 13 ||
    // Home and End
    key == 35 || key == 36 ||
    // left and right arrows
    key == 37 || key == 39 ||
    // Del and Ins
    key == 46 || key == 45 || key == 47 || key == '.') {
        // input is VALID
    }
    else {
        // input is INVALID
        e.returnValue = false;
        if (e.preventDefault) e.preventDefault();
    }
}

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

<script src="../lib/jquery.js"></script>
<script src="../dist/jquery.validate.js"></script>

<script>


$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();

});
</script>
<style type="text/css">
#contained > div
{
    display: inline-block;
   // border: solid 1px #000;
}
#contained
{
    border: solid 1px #cccccc;
    text-align: center;
    margin: 0px auto;
//    width: 40%;
}   
 @media only screen and (max-width: 460px) {
#contained > div
{
  //  display: inline-block;
}
#contained
{
    border: solid 1px #cccccc;
    text-align: center;
    margin: 0px auto;
} 
}
</style>
<!-- load jquery ui css-->
<link href="js/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<!-- load jquery library -->
<script src="js/jquery-1.9.1.js"></script>
<!-- load jquery ui js file -->
<script src="js/jquery-ui.min.js"></script>

<style type="text/css">
.div-table {
    width: 100%;
    //border: 1px dashed #ff0000;
    float: left;
   // padding:10px;
}

.tab-row {
	background-color: #EEEEEE;
	float: left;
	width: 100%;
//	height:45px;
}

.cell {
    padding: 1px;
    border: 1px solid #e9e9e9;
    float: left;
    padding: 5px; 
    background-color: #f5f5f5;
    width: 50%;
//    height:45px;
    font-size:12px;
}
</style>
<div class="services">
	<div class="container"  style="width:95%">

 <h4 style="background-color:#87B8D6;text-align:center"><b>
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">
<?php
if ($UID) {
echo "<h2>Modify Account</h2>\n";

} else {

echo "<h2>Create Account</h2>\n";
}
echo "</font></h4>";
echo "<font color='#FF0000' style='font-size: 8pt'>" . $tval . "</font>";
?>

<div class="div-table">
  <div class="tab-row" style="font-weight:bold">
   <div  class="cell"  style='width:60%'>
<div align="left">
<?php
 echo "<form method=\"post\" action=\"transact-user.php\">\n";
?>
<div align="left" class="agileinfo_mail_grids">
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato" data-content="User Name">User Name</span>
	</label>
	<input class="input__field input__field--chisato" placeholder=" " style="width:180px" type="text" name="name" maxlength="50" value="<?php echo $row['username']; ?>" required="">
      </span> 
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato" data-content="E-mail Address">E-mail Address</span>
	</label>
	<input class="input__field input__field--chisato" placeholder=" " style="width:180px" type="text" class="txtinput" name="e-mail" maxlength="255" value="<?php echo htmlspecialchars($email); ?>" required="">
      </span> 
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato" data-content="Password">Password</span>
	</label>
	<input class="input__field input__field--chisato" placeholder=" " style="width:180px" type="password" id="passwd" name="passwd" maxlength="50" value="<?php #echo $row['password']; ?>" required="" />
      </span> 
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato" data-content="Password">Password (Again)</span>
	</label>
	<input class="input__field input__field--chisato" placeholder=" " style="width:180px" type="password" id="passwd2" name="passwd2" maxlength="50" value="<?php #echo $row['password']; ?>" required="" />
      </span> 
</div></div>
   </div>
   <div  class="cell"  style='width:40%'>
<div id="contained" align="left" class="agileinfo_mail_grids">
<legend><b>Access Level</b></legend>
<?php
$sqlh = "SELECT `access_lvl`,`access_name` FROM `cms_access_levels` ORDER BY access_lvl";
$resulth = mysqli_query($conn,$sqlh);

echo "<div align='left' class='radioGroup'>";
while ($row = mysqli_fetch_array($resulth)) 
{
 echo '<input type="radio" align="left" id="acl_' . $row['access_lvl'] . '" name="accesslvl" value="' . $row['access_lvl'] . '" ';
 if ($row['access_lvl'] == $accesslvl) 
 {
   echo 'checked="checked" ';
 }

 $coll="#000000";

 echo ' required/><label><font color="' . $coll . '">' . $row['access_name'] . "</font></label><br />\n";

#echo "</fieldset>";

}
echo "</div></span>";

?>
</fieldset>
</div>
</div>


 </div>
</div>
</fieldset>

<div align="center">
<?php 

if ($UID) 
{ 
?>

<input type="hidden" name="user_id" value="<?php echo $UID; ?>" />
<input type="submit" class="submit" name="action" value="Modify Account" style="height:35px" />
<input type="submit" class="submit" onclick="return confirm('Are you sure you want to Delete?');" name="action" value="Delete Account" style="height:35px" />
<?php
 }
 else 
 {
 ?>

<input type="submit" class="submit" name="action" value="Create Account" style="height:35px" />
<?php
}
?>
</div>
</form>

</div>

<p align="right" style="margin-right:20px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
 &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>

</div>