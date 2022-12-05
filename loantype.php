<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

$ID=$_REQUEST['ID'];

$sql="SELECT `ID`,`Type`,`Rate`,`Late Rate` FROM `loan type` WHERE `ID`='$ID'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
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


<div align="center">
	<table border="0" width="100%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
		<tr align="center">
		 <td bgcolor="#006633"><b>
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Table Updates</font></b>
 </td>
		</tr>
		<tr>
			<td>

<form action="submitloantype.php" method="post">
<p><b><font face="Verdana" color="#008000" style="font-size: 16pt">Loan Type Update</font></b></p>

<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="table2" height="70">
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Loan Type:
      </font>
      </td>
      <td width="31%" height="28">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="type" size="31" value="<?php echo $row['Type']; ?>" required>
        <input type="hidden" name="ID" size="31" value="<?php echo $row['ID']; ?>">
      	</span></font>
      </td>
      <td width="1%" height="28"></td>
    </tr>
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Interest Rate:
      </font>
      </td>
      <td width="34%" height="28">
        <span style="font-size: 9pt">
        <input type="text" name="rate" size="31" value="<?php echo $row['Rate']; ?>" onkeypress="return isNumber(event)" required>
      	</span>
      </td>
     </tr>
    <tr>
      <td width="17%" height="28">
        <font face="Verdana" style="font-size: 9pt">Late Payment Rate:
      </font>
      </td>
      <td width="34%" height="28">
        <span style="font-size: 9pt">
        <input type="text" name="laterate" size="31" value="<?php echo $row['Late Rate']; ?>" onkeypress="return isNumber(event)">
      	</span>
      </td>
     </tr>

  </table>
<br>
<?php
if (!$ID){
?>
  <input type="submit" value="Save" name="submit"> &nbsp;
<?php } 
 else { ?>
  <input type="submit" value="Update" name="submit"> &nbsp; 
  <input type="submit" value="Delete" name="submit"> &nbsp; 
<br>
<br>
<?php
} 
 echo "<a href='tableupdates.php?cmbTable=Loan Type'>Click here</a> to return.";
?>
 </td>
 </tr>
</table>
<br>

<?php 

 require_once 'footr.php';
 require_once 'footer.php';
?>
  </p>
  </div>
</body>
 
</form>
</td>
			</tr>
		</table>
		</div>