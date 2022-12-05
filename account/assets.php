<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5 & $_SESSION['access_lvl'] != 6){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=../index.php?redirect=$redirect");
}
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

@$ID=$_REQUEST['ID'];

$sql="SELECT * FROM `assets` WHERE `ID`='$ID'";
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
		new JsDatePick({
			useMode:2,
			target:"inputField2",
			dateFormat:"%Y-%m-%d"

		});
		new JsDatePick({
			useMode:2,
			target:"inputField3",
			dateFormat:"%Y-%m-%d"

		});
	};
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
  <font face="Verdana" color="#FFFFFF" style="font-size: 16px">Fixed Assets Register</font></b>
</div>

<form action="submitassets.php" method="post">
<div align="center">
<div align="leftt" style="margin-left:20px;font-size: 12px" class="agileinfo_mail_grids">
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Asset Location:</span>
	</label>
	<select  class="input__field input__field--chisato" placeholder=" " name="location" width="31" value="<?php echo $row['Location']; ?>">  
           <?php  
           echo '<option selected>' . $row['Location'] . '</option>';
           $sql = "SELECT * FROM `location`";
           $result_loc = mysqli_query($conn,$sql) or die('Could not list value; ' . mysqli_error());
           while ($rows = mysqli_fetch_array($result_loc)) 
           {
             echo '<option>' . $rows['Location'] . '</option>';
           }
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Asset Code:</span>
	</label>
        <input type="text" name="code"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Code']; ?>" required>
        <input type="hidden" name="ID" size="31" value="<?php echo $row['ID']; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Asset Category:</span>
	</label>
	<select  name="category" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Category']; ?>">  
          <?php
           echo '<option selected>' . $row['Category'] . '</option>';
           $sql = "SELECT * FROM `asset category`";
           $result_cat = mysqli_query($conn,$sql) or die('Could not list value; ' . mysqli_error());
           while ($rows = mysqli_fetch_array($result_cat)) 
           {
             echo '<option>' . $rows['Category'] . '</option>';
           }
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Asset Name:</span>
	</label>
	<input type="text" name="name" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Name']; ?>" required>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Asset Description:</span>
	</label>
	<input type="text" name="description" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Description']; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Asset Make:</span>
	</label>
	<input type="text" name="make" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Make']; ?>">  
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Asset Status:</span>
	</label>
	<select  name="status"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Status']; ?>" required>  
          <?php
           echo '<option selected>' . $row['Status'] . '</option>';
           $sql = "SELECT * FROM `asset status`";
           $result_st = mysqli_query($conn,$sql) or die('Could not list value; ' . mysqli_error());
           while ($rows = mysqli_fetch_array($result_st)) 
           {
             echo '<option>' . $rows['Status'] . '</option>';
           }
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Asset Quantity:</span>
	</label>
	<input type="text" name="quantity"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Quantity']; ?>" required>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Date Acquired:</span>
	</label>
	<input type="text" id="inputField3" name="dateacquired" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Date Acquired']; ?>" required>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Purchase Price:</span>
	</label>
	<input type="text" name="pprice" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Purchase Price']; ?>" onkeypress="return isNumber(event)">  
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Serial No:</span>
	</label>
	<input type="text" name="serialno" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Serial No']; ?>">  
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Current Value:</span>
	</label>
	<input type="text" name="cvalue" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Current Value']; ?>" onkeypress="return isNumber(event)">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Depreciation value:</span>
	</label>
	<input type="text" name="depreciation" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Depreciation']; ?>" onkeypress="return isNumber(event)">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Next Maintenance Schedule:</span>
	</label>
	<input type="text"  id="inputField2" name="schedule" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Next Maintenance']; ?>">  
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Note:</span>
	</label>
	<textarea name="comment" rows="2" cols="82" class="input__field input__field--chisato" placeholder=" "><?php echo $row['Comment']; ?></textarea>
      </span>

  <fieldset>
<legend><b><i><font size="2" face="Tahoma" color="#008000"> &nbsp;</font></i></b></legend>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Sold?:</span>
	</label>
<div class="radioGroup">
        <?php
          $sql = "SELECT `val`,`type` FROM `booln` ORDER BY `type` desc";
          $result_hy = mysqli_query($conn,$sql) or die('Could not list; ' . mysqli_error());
          $hy=$row['Sold'];
          while ($rows = mysqli_fetch_array($result_hy)) 
          {
           echo ' <input type="radio" align="left" id="hy_' . $rows['val'] . '" name="sold" value="' . $rows['val'] . '" ';
           if ($rows['val'] == $hy) 
           {
             echo 'checked="checked" ';
           }
           echo '/><label>' . $rows['type'] . "</label>\n";
          }
        ?>
     </div>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Date Sold:</span>
	</label>
	<input type="text" id="inputField" name="datesold" class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Date Sold']; ?>">  
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Amount Sold:</span>
	</label>
	<input type="text" name="amountsold"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Amount Sold']; ?>" onkeypress="return isNumber(event)">  
      </span>
  </fieldset>
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
 echo "<a href='fassets.php'>Click here</a> to return to list.";
?>
</div><p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>
