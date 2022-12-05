<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 6) & ($_SESSION['access_lvl'] != 7))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

@$Tit=$_SESSION['Tit'];
@$tval=$_REQUEST['tval'];
 @$acctno=$_REQUEST["acctno"];
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
<script language="JavaScript">
function checkForm()
{
   var camount, cbalance, cloang;
   with(window.document.form1)
   {
      camount    = amount;
      cbalance 	 = balance;
      cloang 	 = balance*2;
   }

   if(!isNumeric(trim(camount.value)))
   {
      alert('Invalid amount. Do not put a coma');
      camount.focus();
      return false;
   }   
   else if(trim(camount.value)>trim(cloang.value))
   {
     // alert('You cannot give more than 200% of the customer balance as loan');
     // camount.focus();
     // return false;
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


<!-- load jquery ui css-->
<link href="js/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<!-- load jquery library -->
<script src="js/jquery-1.9.1.js"></script>
<!-- load jquery ui js file -->
<script src="js/jquery-ui.min.js"></script>

<style type="text/css">
.div-table {
    width: 100%;
    border: 1px dashed #ff0000;
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
<div class='row' style="background-color:#394247; width:100%" align="center">
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Transactions</font></b>
 </div>

<?php echo $_REQUEST['tval']; ?>
<br>
<form action="transactions.php" method="post">	
<div id=register align="center">
         <select name="trans" style="width:120px;height:35px">
          <?php  
           echo '<option>Withdrawal</option>';
           echo '<option>Deposit</option>';
          ?> 
         </select>
&nbsp;
        Enter Account Number:
&nbsp;
        <input type="text" name="acctno" style="width:120px;height:35px" autocomplete="off">  
       &nbsp;<input type="submit" name="go" value="Fetch Account" style="width:150px;height:35px" />
</div>
</form>

<div align="center">
<div align="leftt" style="margin-left:20px;" class="agileinfo_mail_grids">
 
<form action="submittrans.php" method="post" id="myform" name="form1">
<?php
 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];

$sql="SELECT * FROM `transactions` WHERE `ID`='$idd'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);

$sql2="SELECT * FROM `customer` WHERE `Account Number`='$acctno' and `Status`='Active'";
$result2 = mysqli_query($conn,$sql2) or die('Could not look up user data; ' . mysqli_error());
$row2 = mysqli_fetch_array($result2); 
$clt=$row2['Status'];  
if($clt=="Closed")
{ echo "ACCOUNT HAS BEEN CLOSED"; }

?>
      <span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
 <?php
  if (file_exists("images/pics/" . $row2['ID'] . ".jpg")==1)
  { 
?>
              <img border="1" src="images/pics/<?php echo $row2['ID']; ?>.jpg" width="100" height="120">&nbsp;&nbsp;
<?php
  } else { 
?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">&nbsp;&nbsp;
<?php
  } 
?>
</span>
</div>
</span>
      <span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
 <?php
  if (file_exists("images/sign/" . $row2['ID'] . ".jpg")==1)
  { 
?>
              <img border="1" src="images/sign/<?php echo $row2['ID']; ?>.jpg" width="130" height="90">
<?php
  } else { 
?>
              <img border="1" src="images/sign/sign.jpg" width="130" height="90">	 
<?php
  } 
?>			 
</span>
</div>
</span>

      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">First Name:</span>
	</label>
       <input type="text" name="fname" size="25" value="<?php echo @$row2['First Name']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Surname:</span>
	</label>
          <input type="text" size="25" name="sname" value="<?php echo @$row2['Surname']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Number:</span>
	</label>
        <input type="hidden" name="id" size="31" value="<?php echo @$row['ID']; ?>">
        <input type="hidden" name="trans" size="31" value="<?php echo @$trans; ?>">		
        <input type="text" name="acctnum" size="25" value="<?php echo $acctno; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Type:</span>
	</label>
        <input type="text" name="type" size="25" value="<?php echo $row2['Account Type']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
        <?php 
          $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysqli_error());
          $rowb = mysqli_fetch_array($resultb); 
        ?>
         <input type="hidden" name="balance" size="25" value="<?php echo $rowb['Balance']; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Gender:</span>
	</label>
        <input type="text" name="gender" size="25" value="<?php echo $row2['Gender']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Status:</span>
	</label>
        <input type="text" name="status" size="25" value="<?php echo $row2['Status']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Officer:</span>
	</label>
        <input type="text" name="acctofficer" size="25" value="<?php echo $row2['Account Officer']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Operating Staff:</span>
	</label>
        <input type="text" name="officer" size="25" value="<?php echo strtoupper($_SESSION['name']); ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Transaction Date:</span>
	</label>
        <input id="inputField" type="text" size="20" name="date" value="<?php echo date('d-m-Y'); ?>" class="input__field input__field--chisato" placeholder=" "  required>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Transaction Type:</span>
	</label>
         <select name="transtype" size="1" value="<?php echo @$trans; ?>" class="input__field input__field--chisato" placeholder=" " required>
           <option selected><?php echo @$trans; ?></option>
           <option>Deposit</option>
           <option>Withdrawal</option>
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Amount:</span>
	</label>
<?php
 if ($trans=="Deposit") 
{ 
?>
        <input type="hidden" name="initamt" size="25" value="<?php echo @$row['Deposit']; ?>"> 
        <input type="text" name="amount" size="20" value="<?php echo @$row['Deposit']; ?>" onkeypress="return isNumber(event)" class="input__field input__field--chisato" placeholder=" " required> 
<?php
 } else { 
          $sqlbb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultbb = mysqli_query($conn,$sqlbb) or die('Could not look up user data; ' . mysqli_error());
          $rowbb = mysqli_fetch_array($resultbb); 
        ?>

        <input type="hidden" name="initamt" size="25" value="<?php echo @$row['Withdrawal']; ?>"> 
        <input type="hidden" name="balance" id="balance" size="15" value="<?php echo $rowbb['Balance']; ?>"> 

<script language="JavaScript">
function checkamt()
{
   var frm=document.forms["myform"];
   var gbalance=(balance.value);
   if(amount.value > gbalance)
   {
      alert('You cannot withdraw more than the amount you have as balance!');
      frm.amount.focus();
      frm.amount.value='';
      return false;
   }   
   else
   {
      return true;
   }
}

</script>

        <input type="text" id="amount" name="amount" size="20" value="<?php echo @$row['Withdrawal']; ?>" onkeypress="return isNumber(event)" class="input__field input__field--chisato" placeholder=" " required> 
<?php 
      #  echo '<input type="hidden" id="amounttt" name="amounttt" size="20" value="' . $row['Withdrawal'] . '" onkeypress="return isNumber(event)" onblur="return checkamt()">'; 
} 
?>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Remark:</span>
	</label>
        <textarea class="input__field input__field--chisato" placeholder=" " name="remark" rows="2" cols="18" ><?php echo $row['Remark']; ?></textarea>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Depositor/Withdrawer:</span>
	</label>
        <input type="text" name="transactor" size="20" value="<?php echo $row['Transactor']; ?>" class="input__field input__field--chisato" placeholder=" " required>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Person Contact:</span>
	</label>
        <input type="text" name="tcontact" size="20" value="<?php echo $row['Transactor Contact']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Balance:</span>
	</label>
        <?php 
          $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysqli_error());
          $rowb = mysqli_fetch_array($resultb); 

         #echo "<b>" . $rowb['Balance'] . "</b>"; 
        ?>
        <input type="text" name="bal" size="20" value="<?php echo $rowb['Balance']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
<?php
if($row2['Status']=="Active")
{
if (!$idd){
?>
  <input type="submit" value="Save" name="submit" style="height:40;width:120;  font-size: 13pt"> &nbsp;
<?php } 
 else { ?>
  <input type="submit" value="Modify" name="submit" style="height:40;width:80; font-size: 13pt"> &nbsp;  
  <input type="submit" value="Delete" name="submit" style="height:40;width:80;  font-size: 13pt" onclick="return confirm('Are you sure you want to Delete?');"> &nbsp;
  <input type="submit" value="Cancel" name="submit" style="height:40;width:80; font-size: 13pt"> &nbsp;
<?php
}} ?>                
      </span>
  </div>
</body>
</form>

<p>&nbsp;</p>
<div class="div-table">
 <?php
 @$tval=$_GET['tval'];
 $limit      = 3;
 @$page=$_GET['page'];
 if(empty($acctno) OR $acctno=="") 
{
  $acctno="XYZ0099";
}
   $query_count = "SELECT * FROM `transactions` WHERE `Account Number`='" . $acctno . "'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
?>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:100%'><b><font color='#FF0000' style='font-size: 10pt'> RECENT TRANSACTIONS</font></b></div>
  </div>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:14.2%'>S/No</div>
    <div  class="cell" style='width:14.2%'>Transaction Date</div>
    <div  class="cell" style='width:14.2%'>Account Number</div>
    <div  class="cell" style='width:14.2%'>Customer Name</div>
    <div  class="cell" style='width:14.2%'>Deposit Amount </div>
    <div  class="cell" style='width:14.2%'>Withdrawal Amount</div>
    <div  class="cell" style='width:14.2%'>Note</div>
  </div>
<?php
   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal`,`Transaction Type`,`Remark` FROM `transactions` WHERE `Account Number`='" . $acctno . "' order by `ID` desc LIMIT 0, $limit";
   $resultp=mysqli_query($conn,$query);
   
$i=0;
    while(list($idd,$date,$acctno,$depamt,$wthamt,$transt,$remk)=mysqli_fetch_row($resultp))
    { 
      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acctno' and `Status`='Active'";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysqli_error());
      $roww = mysqli_fetch_array($resultw); 
      $fn=$roww['First Name'];  
      $sn=$roww['Surname'];
      $name=$fn . ' ' . $sn;
    $cll=$roww['Status'];  
   if($cll=="Closed")
   { echo "ACCOUNT HAS BEEN CLOSED"; }

     $deppamt=number_format($depamt,2);
     $wthhamt=number_format($wthamt,2);
     $i=$i+1;

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:14.2%">' .$i. '</div>
        <div  class="cell" style="width:14.2%">' .$date. '</div>
        <div  class="cell" style="width:14.2%"><a href = "transactions.php?idd=' . $idd . '&trans=' .$transt. '&acctno=' .$acctno. '">' .$acctno. '</a></div>
        <div  class="cell" style="width:14.2%">' .$name. '</div>
        <div  class="cell" style="width:14.2%">' .$deppamt. '</div>
        <div  class="cell" style="width:14.2%">' .$wthhamt.  '</div>
        <div  class="cell" style="width:14.2%">' .$transt. ' - ' .$remk.  '</div>
      </div>';
    }
?>
</div>
</fieldset>
<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>

<?php
if($_REQUEST['tval']=="Your record has been saved.")
{
  echo "<script>alert('Transaction Successful!');</script>";
}
if($_REQUEST['tval']=="Your record has been updated.")
{
  echo "<script>alert('You Have Successfully Modified The Transaction');</script>";
}
?>