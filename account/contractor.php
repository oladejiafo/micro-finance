<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=../index.php?redirect=$redirect");
}
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';
 @$tval=$_GET['tval'];
@$ID=$_REQUEST['ID'];

$sql="SELECT * FROM `contract` WHERE `ID`='$ID'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);

 echo "<p><font color='#FF0000' style='font-size: 9pt'>" . $tval . "</font></p>";
?>

<link rel="stylesheet" type="text/css" media="all" href="../jsDatePick_ltr.min.css" />
<!-- 	
<link rel="stylesheet" type="text/css" media="all" href="../jsDatePick_ltr.css" />
   <link rel="shortcut icon" href="favicon.ico">
-->
<script type="text/javascript" src="../jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%Y-%m-%d"

		});
	};
</script>

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
<!-- load jquery ui css-->
<link href="../js/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<!-- load jquery library -->
<script src="../js/jquery-1.9.1.js"></script>
<!-- load jquery ui js file -->
<script src="../js/jquery-ui.min.js"></script>

<style type="text/css">
.div-table {
    width: 100%;
//    border: 1px dashed #ff0000;
    float: left;
    padding:10px;
}

.tab-row {
	background-color: #EEEEEE;
	float: left;
	width: 100%;
	height:45px;
}

.cell {
    padding: 1px;
    border: 1px solid #e9e9e9;
    float: left;
    padding: 5px; 
    background-color: #f5f5f5;
    width: 50%;
    height:45px;
    font-size:12px;
}
</style>

<div align="center">
<div class='row' style="background-color:#394247; width:100%" align="center"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Contractors' Schedule</font></b>
 </div>

<form action="submitcontract.php" method="post">
<div align="center">
<div align="leftt" style="margin-left:20px;" class="agileinfo_mail_grids">
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contract Category:</span>
	</label>
	<select  name="category"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contract Category']; ?>">  
          <?php  
           echo '<option selected>' . $row['Contract Category'] . '</option>';
           echo '<option>ICT</option>';
           echo '<option>Supplies</option>';
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contract Date:</span>
	</label>
        <input type="text" name="date" id="inputField" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contract Date']; ?>" required>
        <input type="hidden" name="ID" size="31" value="<?php echo $row['ID']; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contract Title:</span>
	</label>
        <input type="text" name="ctitle" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contract Title']; ?>" required>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contractor Name:</span>
	</label>
        <input type="text" name="cname" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contractor']; ?>" required>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contractor Address:</span>
	</label>
        <input type="text" name="caddress" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contractor Address']; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contract Amount:</span>
	</label>
        <input type="text" name="amount" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Amount']; ?>" onkeypress="return isNumber(event)">
     </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Amount Paid:</span>
	</label>
        <input type="text" name="amountpaid" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Amount Paid']; ?>" onkeypress="return isNumber(event)">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contract Status:</span>
	</label>
	<select  name="status" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contract Status']; ?>" required>  
          <?php  
           echo '<option selected>' . $row['Contract Status'] . '</option>';
           echo '<option>Completed</option>';
           echo '<option>In Progress</option>';
           echo '<option>Abandoned</option>';
           echo '<option>Canceled</option>';
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contact Person:</span>
	</label>
        <input type="text" name="contact" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contact']; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Payment Status:</span>
	</label>
	<select  name="paid" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Paid']; ?>">  
          <?php  
           echo '<option selected>' . $row['Paid'] . '</option>';
           echo '<option>Paid</option>';
           echo '<option>Part Payment</option>';
           echo '<option>Unpaid</option>';
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contact Person's Phone:</span>
	</label>
	<input type="text" name="cphone" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contact Phone']; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contractor's Bank:</span>
	</label>
        <select  name="bank" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Bank']; ?>">  
          <?php  
           echo '<option selected>' . $row['Bank'] . '</option>';
           $sql = "SELECT * FROM `bank`";
           $result_bank = mysqli_query($conn,$sql) or die('Could not list value; ' . mysqli_error());
           while ($rows = mysqli_fetch_array($result_bank)) 
           {
             echo '<option>' . @$rows['Bank'] . '</option>';
           }
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Contactor's Account #:</span>
	</label>
	<input type="text" name="account" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Account']; ?>">
      </span>
      <span class="input input--chisato">
      </span>
      <span class="input input--chisato">
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
  </span>
  </div>
</form>

<div>
<?php 
 echo "<a href='contract.php'>Click here</a> to return to list.";
?>
</div>
<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>