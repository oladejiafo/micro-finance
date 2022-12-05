<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 7))
{
 if ($_SESSION['access_lvl'] != 5){
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

@$Tit=$_SESSION['Tit'];
@$acctno=$_REQUEST['acctno'];
@$id=$_REQUEST['id'];
@$tval=$_REQUEST['tval'];
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
		<tr align='center'>
 <td bgcolor="#00CC99"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Contributions</font></b>
 </td>
</tr>		
   <tr>
	<td>
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'custheader.php'; ?>
</font></i></b></legend>
<br>
<form action="contribution.php" method="post">	
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="65%" id="AutoNumber1">
    <tr>
      <td>
        Enter Account Number:
      </td>
      <td>
        <input type="text" name="acctno" size="25" value="<?php echo @$row['Account Number']; ?>">  
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
<form action="submitcontri.php" method="post">
<?php
 @$id=$_REQUEST["id"];
 @$acctno=$_REQUEST["acctno"];
$sql="SELECT * FROM `contributions` WHERE `ID`='$id'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);

$sql2="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
$result2 = mysql_query($sql2,$conn) or die('Could not look up user data; ' . mysql_error());
$row2 = mysql_fetch_array($result2); 
?>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1" height="70">
    <tr>
      <td width="17%" height="28">
        First Name:
      </td>
      <td width="31%" height="28">
       <input type="hidden" name="fname" size="25" value="<?php echo @$row2['First Name']; ?>"><?php echo @$row2['First Name']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Surname:
      </td>
      <td width="34%" height="28">
          <input type="hidden" size="25" name="sname" value="<?php echo @$row2['Surname']; ?>"><?php echo @$row2['Surname']; ?>
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Account Number:
      </td>
      <td width="31%" height="28">
        <input type="hidden" name="id" size="31" value="<?php echo @$row['ID']; ?>">
        <input type="hidden" name="acctno" size="25" value="<?php echo @$row2['Account Number']; ?>"><?php echo @$row2['Account Number']; ?> &nbsp; 
		<input type="hidden" name="type" size="15" value="<?php echo @$row2['Account Type']; ?>"> <?php echo @$row2['Account Type']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Entered By:
      </td>
      <td width="34%" height="28">
	<?php echo strtoupper($_SESSION['name']); ?>
        <input type="hidden" name="enteredby" size="25" value="<?php echo strtoupper($_SESSION['name']); ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Amount:
      </td>
      <td width="31%" height="28">
        <input id="numbersOnly" pattern="[0-9.]+" type="text" name="amount" size="25" value="<?php echo @$row['Amount']; ?>" onkeypress="return isNumber(event)" required> 

      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Agent:
      </td>
      <td width="34%" height="28">
         <select name="agent" size="1" value="<?php echo @$row['Agent']; ?>" required>
          <option selected><?php echo @$row['Agent']; ?></option>
          <?php  
         	$sqlt = "SELECT `Agent` FROM `agents` ORDER BY Agent;";
        	$resultt = mysql_query($sqlt) or die('Invalid query: ' . mysql_error());
        	while ($rows = mysql_fetch_array($resultt))
			{
			  echo " <option>" . $rows['Agent'] . "</option>\n";
			}
          ?> 
         </select>
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
       Contribution Date:
      </td>
      <td width="34%" height="28">
        <input id="inputField" type="text" size="25" name="date" value="<?php echo date('d-m-Y'); ?>">
        <?php 
          $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultb = mysql_query($sqlb,$conn) or die('Could not look up user data; ' . mysql_error());
          $rowb = mysql_fetch_array($resultb); 
        ?>
         <input type="hidden" name="balance" size="25" value="<?php echo $rowb['Balance']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Payment Mode:
      </td>
      <td width="34%" height="28">
         <select name="paymode" size="1" value="<?php echo @$row['Pay Mode']; ?>">
          <?php  
           echo '<option selected>Cash</option>';
           echo '<option>Cheque</option>';
           echo '<option>Bank Transfer</option>';
          ?> 
         </select>
      </td>
    </tr>

<tr align='center'>
 <td colspan="5" bgcolor="#008000"> </td>
</tr>
  </table>
    <p>

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
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#00CC99" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5" bgcolor="#00CC99"> </td>
</tr>
  </table>
			</td>
		</tr>
<tr><td align="right">
<form action="contribution.php" method="post">
 <select name="cmbFilter">
  <?php  
   echo '<option selected>All Transactions</option>';
   echo '<option>Cash</option>';
   echo '<option>Cheque</option>';
   echo '<option>Entered By</option>';
   echo '<option>By Agent</option>';
  ?> 
 </select> &nbsp;
       <input type="text" name="filter"> &nbsp;
       <input type="submit" value="Filter" name="submit">&nbsp;&nbsp;&nbsp;
</form>
<TABLE width='98%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#00CC99" id="table2">
 <?php
 @$tval=$_GET['tval'];
 $limit      = 35;
 @$page=$_GET['page'];

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 
 echo "<a target='_blank' href='mydailysales.php?cmbFilter=" . $cmbFilter . "&filter=" . $filter . "'><font color='#009900' style='font-size: 10pt font-align: right'>Print This As A Report &nbsp;&nbsp;&nbsp;</font></a>";

  if ($cmbFilter=="" or $cmbFilter=="All Transactions" or empty($cmbFilter))
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and (`Entered By` like '" . strtoupper($_SESSION['name']) . "%' or `Agent` like '" . strtoupper($_SESSION['name']) . "%')";
  }
  else if ($cmbFilter=="Entered By")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and `Entered By` like '%" . $filter . "%'";
  }
  else if ($cmbFilter=="By Agent")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and `Agent` like '%" . $filter . "%'";
  }
  else if ($cmbFilter=="Cash")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and `Pay Mode` ='Cash'";
  }
  else if ($cmbFilter=="Cheque")
  {  
   $query_count = "SELECT * FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and `Pay Mode` ='Cheque'";
  }
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

  echo "<tr><td colspan=10 align='center'><b><font color='#FF0000' style='font-size: 10pt'>Today's Contributions " . $cmbFilter . ": " . $filter . " (" . $totalrows . ")</font></b></td></tr>";
    echo "<TR><TH><b><u>S/No </b></u>&nbsp;</TH><TH align='left'><b><u>Account Number</b></u>&nbsp;</TH><TH align='left'><b><u>Customer Name </b></u>&nbsp;</TH><TH align='right'><b><u>Amount </b></u>&nbsp;</TH><TH align='right'><b><u>Account Balance </b></u>&nbsp;</TH></TR>";

  if ($cmbFilter=="" or $cmbFilter=="All Transactions" or empty($cmbFilter))
  {  
   $query = "SELECT `ID`,`Date`,`Agent`,`Account Number`,`First Name`,`Surname`,`Amount` FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and (`Entered By` like '" . strtoupper($_SESSION['name']) . "%' or `Agent` like '" . strtoupper($_SESSION['name']) . "%') order by `ID` desc LIMIT 0, $limit";
  }
  else if ($cmbFilter=="Entered By")
  {  
   $query = "SELECT `ID`,`Date`,`Agent`,`Account Number`,`First Name`,`Surname`,`Amount` FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and `Entered By` like '%" . $filter . "%' order by `ID` desc LIMIT 0, $limit";
  }
  else if ($cmbFilter=="By Agent")
  {  
   $query = "SELECT `ID`,`Date`,`Agent`,`Account Number`,`First Name`,`Surname`,`Amount` FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and `Agent` like '%" . $filter . "%' order by `ID` desc LIMIT 0, $limit";
  }
  else if ($cmbFilter=="Cash")
  {  
   $query = "SELECT `ID`,`Date`,`Agent`,`Account Number`,`First Name`,`Surname`,`Amount` FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and `Pay Mode` ='Cash' order by `ID` desc LIMIT 0, $limit";
  }
  else if ($cmbFilter=="Cheque")
  {  
   $query = "SELECT `ID`,`Date`,`Agent`,`Account Number`,`First Name`,`Surname`,`Amount` FROM `contributions` WHERE `Date`='" . date('Y-m-d') . "' and `Pay Mode` ='Cheque' order by `ID` desc LIMIT 0, $limit";
  }
   $resultp=mysql_query($query);



$i=0;
    while(list($id,$date,$agent,$acct,$fname,$sname,$amt)=mysql_fetch_row($resultp))
    {
      $sqlw="SELECT * FROM `transactions` WHERE `Account Number`='$acct' order by `ID` desc";
      $resultw = mysql_query($sqlw,$conn) or die('Could not look up user data; ' . mysql_error());
      $roww = mysql_fetch_array($resultw); 
     $bal=number_format($roww['Balance'],2);
     $amount=number_format($amt,2);
     $i=$i+1;
	 $name=$fname . ' ' . $sname;
     echo "<TR><TH>$i &nbsp;</TH><TH align='left'><a href = 'contribution.php?id=$id&acctno=$acct'>$acct</a></TH><TH align='left'> $name &nbsp;</TH><TH align='right'>$amount &nbsp;</TH><TH align='right'> $bal &nbsp;</TH></TR>";
	 $totalamt += $amt;
    }
    @$totalamt=number_format($totalamt,2);

    echo "<TR><TH colspan='3'>MY DAILY TOTAL</TH><TH align='right'>$totalamt &nbsp;</TH><TH></TH></TR>";  
?>
</table>
</td></tr>
<tr><td align="right"><br>
<?php 
 require_once 'footr.php';
 require_once 'footer.php';
?></td></tr>
	</table>
</div>

