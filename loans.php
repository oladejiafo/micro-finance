<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3) & ($_SESSION['access_lvl'] != 6))
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
@$acctno=$_REQUEST['acctno'];
@$id=$_REQUEST['id'];
@$tval=$_REQUEST['tval'];
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

<!-- load jquery ui css-->
<link href="js/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<!-- load jquery library -->
<script src="js/jquery-1.9.1.js"></script>
<!-- load jquery ui js file -->
<script src="js/jquery-ui.min.js"></script>

<style type="text/css">
.div-table {
    width: 100%;
 //   border: 1px dashed #ff0000;
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
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Loans</font></b>
 </div>
<div align="center" style="margin-top:10px;margin-bottom:10px">
<form action="loans.php" method="post">	
<div id=register align="center">
        Enter Account Number:
&nbsp;
        <input type="text" autocomplete="off" size="15" name="acctno" onBlur="filtery(this.value,this.form.code)" style="height:35; background-color:#E9FCFE; font-size: 15pt">
        <input type="hidden" name="view" size="15" value="1">  		
&nbsp;
       <input name="go" type="submit" value="Search" align="top" style="height:35; color:#008000; font-size: 15pt">
</div>
</form>	
</div>

<div align="center" style="margin-top:10px;margin-bottom:10px">
<fieldset>
<legend> <i>
<?php echo "<a href='loans.php?acctno=$acctno&view=1&edit=0'>View</a>"; ?>
 || <?php echo "<a href='loans.php?acctno=$acctno&view=0&edit=1'>Edit</a>"; ?> 
   <?php 
       if($_SESSION['access_lvl'] == 5)
       {
         echo " || <a href='loansappr.php'>Loan Approvals</a>"; 
       }
   ?> 
</i></legend>
</div>
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

<div align="center">
<div align="leftt" style="margin-left:20px;" class="agileinfo_mail_grids">
<form  name='form1' id='myform' action="submitloans.php" method="post">
<?php
 @$id=$_REQUEST["id"];
 @$acctno=$_REQUEST["acctno"];
 #@$acctn=$_REQUEST["acctn"]; 
 @$view=$_REQUEST["view"];
 @$edit=$_REQUEST["edit"];
 @$confirm=$_REQUEST["confirm"]; 
 
$sql="SELECT * FROM `loan` WHERE `Account Number`='$acctno' and `Loan Status`='Active'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysql_error());
$row = mysqli_fetch_array($result);
$acctn=$row['Account Number'];

$sql2="SELECT * FROM `customer` WHERE `Account Number`='$acctno' and `Status`='Active'";
$result2 = mysqli_query($conn,$sql2) or die('Could not look up user data; ' . mysql_error());
$row2 = mysqli_fetch_array($result2); 
?>

<fieldset>
      <span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
 <?php
  if (file_exists("images/pics/" . $row2['ID'] . ".jpg")==1)
  { 
?>
              <img border="1" src="images/pics/<?php echo $row2['ID']; ?>.jpg" width="100" height="120">
<?php
  } else { 
?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
<?php
  } 
?>
</span>
</div>
</span>

      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Account:</span>
	</label>
<?php
if (!$row['Loan Account'])
{
  $sqlz = "SELECT `Branch Code` FROM `branch` Where `Branch`='$brch'";
  $resultz = mysqli_query($conn,$sqlz);
  $rowz = mysqli_fetch_array($resultz);
  $bcd=$rowz['Branch Code'];

  $sqlx = "SELECT `Loan Account` FROM `loan` order by `ID` desc";
  $resultx = mysqli_query($conn,$sqlx);
  $rowx = mysqli_fetch_array($resultx);
  $ann=$rowx['Account Number'];

  $ann=$ann+1;   
  $accNum=$bcd . $ann;

?>
        <input type="text" name="loanacct" size="10"  value="<?php echo @$accNum; ?>" class="input__field input__field--chisato" placeholder=" ">
<?php
} else {
?>
        <input type="text" name="loanacct" size="10"  value="<?php echo @$row['Loan Account']; ?>" class="input__field input__field--chisato" placeholder=" ">
<?php  
}
?>
</span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">First Name:</span>
	</label>
       <input type="text" name="fname" size="15" value="<?php echo @$row2['First Name']; ?>"  class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Surname:</span>
	</label>
          <input type="text" size="15" name="sname" value="<?php echo @$row2['Surname']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Number:</span>
	</label>
        <input type="hidden" name="id" size="31" value="<?php echo @$row['ID']; ?>">
        <input type="text" name="acctnum" size="15" value="<?php echo @$row2['Account Number']; ?>"  class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Type:</span>
	</label>
        <input type="text" name="type" size="15" value="<?php echo @$row2['Account Type']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Officer:</span>
	</label>
	<?php if(!$row['Officer']) { ?>
        <input type="text" name="officer" size="15" value="<?php echo strtoupper($_SESSION['name']); ?>" class="input__field input__field--chisato" placeholder=" ">
	<?php } else { ?>
        <input type="text" name="officer" size="15" value="<?php echo $row['Officer']; ?>" class="input__field input__field--chisato" placeholder=" ">
	<?php }?>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Amount:</span>
	</label>
        <?php 
          $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysql_error());
          $rowb = mysqli_fetch_array($resultb); 
        ?>
        <input type="hidden" name="balance" id="balance" size="15" value="<?php echo $rowb['Balance']; ?>"> 
        <input type="text" name="amount" id="amount" size="15" value="<?php echo @$row['Loan Amount']; ?>"  class="input__field input__field--chisato" placeholder=" " onkeypress="return isNumber(event)" required> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Type:</span>
	</label>
         <select name="loantype" size="1" value="<?php echo @$row['Loan Type']; ?>" class="input__field input__field--chisato" placeholder=" " required>
          <option selected><?php echo @$row['Loan Type']; ?></option>
          <?php  
         	$sqlt = "SELECT `Type` FROM `loan type` ORDER BY Type;";
        	$resultt = mysqli_query($conn,$sqlt) or die('Invalid query: ' . mysql_error());
        	while ($rows = mysqli_fetch_array($resultt))
	{
	  echo " <option>" . $rows['Type'] . "</option>\n";
	}
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Int. Rate:</span>
	</label>
<?php
if (!$acctn)
{

} 
if (!empty($acctn) and $confirm==1)
{
?>  
        <input type="text" size="8" name="intrate" value="<?php echo @$row['Interest Rate']; ?>" class="input__field input__field--chisato" placeholder=" ">
<?php
 }
  if (!empty($acctn) and $edit==1)
 { 
?>
        <input type="text" size="8" name="intrate" value="<?php echo @$row['Interest Rate']; ?>" class="input__field input__field--chisato" placeholder=" ">
<?php
 } 

  if (!empty($acctn) and $view==1)
{ ?>
        <input type="text" size="8" name="intrate" value="<?php echo @$row['Interest Rate']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
<?php
 } 
?>
   </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Date:</span>
	</label>
	  <?php if (!$row['Loan Date'])
	  { ?>
        <input id="inputField" type="text" size="15" name="date" value="<?php echo date('d-m-Y'); ?>" class="input__field input__field--chisato" placeholder=" " required>
	  <?php } else { ?>
        <input id="inputField" type="text" size="15" name="date" value="<?php echo date('d-m-Y',strtotime($row['Loan Date'])); ?>" class="input__field input__field--chisato" placeholder=" " required>
	  <?php } ?>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan No:</span>
	</label>
        <input type="text" size="15" name="loanno" value="<?php echo @$row['Loan No']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Status:</span>
	</label>
<?php
if (!$acctn)
{

} 
if (!empty($acctn) and $confirm==1)
{
?>  
         <select name="loanstatus" size="1" value="<?php echo @$row['Loan Status']; ?>" class="input__field input__field--chisato" placeholder=" ">
          <?php  
           echo '<option selected>Active</option>';
           echo '<option>Suspended</option>';
           echo '<option>Paid</option>';
          ?> 
         </select>
<?php }
  if (!empty($acctn) and $edit==1)
{ ?>
         <select name="loanstatus" size="1" value="<?php echo @$row['Loan Status']; ?>" class="input__field input__field--chisato" placeholder=" ">
          <?php  
           echo '<option selected>Active</option>';
           echo '<option>Suspended</option>';
           echo '<option>Paid</option>';
          ?> 
         </select>
<?php
 } 
  if (!empty($acctn) and $view==1)
{ 
?>
        <input type="text" size="15" name="loanstatus" value="<?php echo @$row['Loan Status']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
<?php
 } 
?>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Duration:</span>
	</label>
       <input type="text" size="15" name="loanduration" value="<?php echo @$row['Loan Duration']; ?>" class="input__field input__field--chisato" placeholder=" " required>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Payment Frequency:</span>
	</label>
         <select name="paymentfreq" size="1" value="<?php echo @$row['Payment Frequency']; ?>" class="input__field input__field--chisato" placeholder=" " required>
          <?php  
           echo '<option selected>Daily</option>';
           echo '<option>Weekly</option>';
           echo '<option>Monthly</option>';
           echo '<option>Quarterly</option>';
           echo '<option>Yearly</option>';
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato"># of Payment:</span>
	</label>
<?php
if (!$acctn)
{

} 
if (!empty($acctn) and $confirm==1)
{
?>  
        <input type="text" size="8" name="payments" value="<?php echo @$row['No of Payment']; ?>" class="input__field input__field--chisato" placeholder=" ">
<?php }
  if (!empty($acctn) and $edit==1)
{ ?>
        <input type="text" size="8" name="payments" value="<?php echo @$row['No of Payment']; ?>" class="input__field input__field--chisato" placeholder=" ">
<?php } 

  if (!empty($acctn) and $view==1)
{ ?>
        <input type="text" size="8" name="payments" value="<?php echo @$row['No of Payment']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
<?php
 } 
?>	  
   </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Payment Type:</span>
	</label>
         <select name="paymenttype" size="1" value="<?php echo @$row['Payment Type']; ?>" class="input__field input__field--chisato" placeholder=" " required>
          <?php  
           echo '<option selected>' . $row['Payment Type'] . '</option>';
           echo '<option>Flat Rate</option>';
           echo '<option>Compound Interest</option>';
           echo '<option>Reducing Balance</option>';
           echo '<option>Simple Interest</option>';
           echo '<option>Daily Simple Interest</option>';
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Grade:</span>
	</label>
         <select name="loangrade" size="1" value="<?php echo @$row['Loan Grade']; ?>" class="input__field input__field--chisato" placeholder=" ">
          <?php  
           echo '<option selected>High</option>';
           echo '<option>Low</option>';
          ?> 
         </select>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Late Rate:</span>
	</label>
<?php
if (!$acctn)
{

} 
if (!empty($acctn) and $confirm==1)
{
?>  
        <input type="text" size="8" name="latecharges" value="<?php echo @$row['Late Charge']; ?>" class="input__field input__field--chisato" placeholder=" ">
<?php }
  if (!empty($acctn) and $edit==1)
{ ?>
        <input type="text" size="8" name="latecharges" value="<?php echo @$row['Late Charge']; ?>" class="input__field input__field--chisato" placeholder=" ">
<?php } 

if (!empty($acctn) and $view==1)
{ 
?>
        <input type="text" size="8" name="latecharges" value="<?php echo @$row['Late Charge']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
<?php
 } 
?>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Purpose:</span>
	</label>
        <textarea cols="17" rows="2" name="purpose" class="input__field input__field--chisato" placeholder=" "><?php echo @$row['Purpose']; ?></textarea>
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Application Fee:</span>
	</label>
        <input type="text" name="applicationfee" id="applicationfee" size="15" value="<?php echo @$row['Application Fee']; ?>"  class="input__field input__field--chisato" placeholder=" " onkeypress="return isNumber(event)"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Processing Fee:</span>
	</label>
        <input type="text" name="processingfee" id="processingfee" size="15" value="<?php echo @$row['Processing Fee']; ?>"  class="input__field input__field--chisato" placeholder=" " onkeypress="return isNumber(event)"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Loan Insurance Fee:</span>
	</label>
        <input type="text" name="insurancefee" id="insurancefee" size="15" value="<?php echo @$row['Insurance Fee']; ?>"  class="input__field input__field--chisato" placeholder=" " onkeypress="return isNumber(event)"> 
      </span>
      <span class="input input--chisato">
      </span>
<?php
if (!$acctn){
?>

<?php } 
if (!empty($acctn) and ($confirm==1 or $edit==1))
{
?>  
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Daily Interest:</span>
	</label>
        <input type="text" size="8" name="dailyinterest" value="<?php echo @$row['Daily Interest']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Daily Principal:</span>
	</label>
        <input type="text" size="15" name="dailyprincipal" value="<?php echo @$row['Daily Principal']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Daily Total Repay:</span>
	</label>
        <input type="text" size="10" name="dailyrepay" value="<?php echo @$row['Daily Repay']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Monthly Intr:</span>
	</label>
        <input type="text" size="8" name="monthlyinterest" value="<?php echo @$row['Monthly Interest']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Total Interest:</span>
	</label>
        <input type="text" size="15" name="totalinterest" value="<?php echo @$row['Total Interest']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Interest toDate:</span>
	</label>
        <input type="text" size="10" name="interesttodate" value="<?php echo @$row['Interest toDate']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Monthly Principal:</span>
	</label>
        <input type="text" size="8" name="monthlyprincipal" value="<?php echo @$row['Monthly Principal']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Principal toDate:</span>
	</label>
        <input type="text" size="15" name="ptodate" value="<?php echo @$row['PPayment todate']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Principal Balance Left:</span>
	</label>
        <input type="text" size="10" name="pbalance" value="<?php echo @$row['PBalance']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Monthly Repay:</span>
	</label>
        <input type="text" size="8" name="repayment" value="<?php echo @$row['Periodic Repayment']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Total toDate:</span>
	</label>
        <input type="text" size="8" name="todate" value="<?php echo @$row['Payment todate']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Total Balance Left:</span>
	</label>
        <input type="text" size="15" name="balance" value="<?php echo @$row['Balance']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>

<?php
 }
  if (!empty($acctn) and $view==1)
{ ?>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Daily Interest:</span>
	</label>
        <input type="text" size="8" name="dailyinterest" value="<?php echo @$row['Daily Interest']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Daily Principal:</span>
	</label>
        <input type="text" size="15" name="dailyprincipal" value="<?php echo @$row['Daily Principal']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Daily Total Repay:</span>
	</label>
        <input type="text" size="10" name="dailyrepay" value="<?php echo @$row['Daily Repay']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Monthly Intr:</span>
	</label>
        <input type="text" size="8" name="monthlyinterest" value="<?php echo @$row['Monthly Interest']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Total Interest:</span>
	</label>
        <input type="text" size="15" name="totalinterest" value="<?php echo @$row['Total Interest']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Interest toDate:</span>
	</label>
        <input type="text" size="10" name="interesttodate" value="<?php echo @$row['Interest toDate']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Monthly Principal:</span>
	</label>
        <input type="text" size="8" name="monthlyprincipal" value="<?php echo @$row['Monthly Principal']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Principal toDate:</span>
	</label>
        <input type="text" size="15" name="ptodate" value="<?php echo @$row['PPayment todate']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Principal Balance Left:</span>
	</label>
        <input type="text" size="10" name="pbalance" value="<?php echo @$row['PBalance']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Monthly Repay:</span>
	</label>
        <input type="text" size="8" name="repayment" value="<?php echo @$row['Periodic Repayment']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Total toDate:</span>
	</label>
        <input type="text" size="8" name="todate" value="<?php echo @$row['Payment todate']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Total Balance Left:</span>
	</label>
        <input type="text" size="15" name="balance" value="<?php echo @$row['Balance']; ?>" class="input__field input__field--chisato" placeholder=" " readonly="readonly" style="background-color:#eeeeee">
      </span>
<?php
 } 
?>
</fieldset>
       <span class="input input--chisato">
<?php
if($row2['Status']=="Active")
{
if (!$acctno){
?>
  <input type="submit" value="Add" name="submit" style="height:35; width:120; font-size: 13px;margin-top:-20px" onClick="return checkForm();"> &nbsp;
<?php
} if (!empty($acctno) and $confirm==1){
?>  
  <input type="submit" value="Confirm" name="submit" style="height:35; width:120;  font-size: 13px;margin-top:-20px" onClick="return checkForm();"> &nbsp;
<?php }  if (!empty($acctno) and $edit==1){ ?>
  <input type="submit" value="Update" name="submit" style="height:35; width:120;font-size: 13px;margin-top:-20px" onClick="return checkForm();"> &nbsp;  
  <input type="submit" value="Delete" name="submit" style="height:35; width:120; font-size: 13px;margin-top:-20px"  onclick="return confirm('Are you sure you want to Delete?');"> &nbsp;
<?php }} ?>
      </span>
</form>

<p>&nbsp;</p>
<fieldset>
<legend><b><i>Guarantor</i></b></legend>
<?php
$idxx=$_REQUEST['idx'];
$trans=$_REQUEST['trans'];

if($trans==1)
{
$sqlTX="SELECT `ID`,`Loan_ID`,`Guarantor`,`Contact`,`Occupation` FROM `loan guarantor` WHERE `ID`='$idxx'";
$resultTX = mysqli_query($conn,$sqlTX) or die('Could not look up user data; ' . mysql_error());
$rowTX = mysqli_fetch_array($resultTX);

?>
<form action="submitguarantor.php" method="post"  enctype="multipart/form-data">
<div align="left">
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Guarantor:</span>
	</label>
        <input type="text" name="guarantor" size="31" value="<?php echo $rowTX['Guarantor']; ?>" class="input__field input__field--chisato" placeholder=" ">
        <input type="hidden" name="id" size="31" value="<?php echo $rowTX['ID']; ?>">
        <input type="hidden" name="lid" size="31" value="<?php echo $row['ID']; ?>">
        <input type="hidden" name="acctno" size="31" value="<?php echo $acctno; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Phone/Address:</span>
	</label>
        <input type="text" name="contact" size="31" value="<?php echo $rowTX['Contact']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Occupation:</span>
	</label>
        <input type="text" name="occupation" size="31" value="<?php echo $rowTX['Occupation']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
<span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
 <?php
  if (file_exists("images/sign/gr_" . $idxx . ".jpg")==1)
  {
 ?>
              <img border="1" src="images/sign/gr_<?php echo $idxx; ?>.jpg" width="140" height="70">
 <?php
  } else {
 ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="70">	 
 <?php
  }
 ?>			 
</span>
<span>
Browse & Upload Image:<br>
<input name="sign_filename" type="file" id="sign_filename" size="15">
  </span>
</div>
</span>

      <span class="input input--chisato">
<?php
if (!$idxx){
?>
  <input type="submit" value="Save" name="submit"> &nbsp;
<?php } 
 else { ?>
  <input type="submit" value="Update" name="submit"> &nbsp; 
  <input type="submit" value="Delete" name="submit" onclick="return confirm('Are you sure you want to Delete?');"> &nbsp; 

<?php
}
?> 
</span>
</form>
</div>
<?php
}
?>
<p>&nbsp;</p>
<div class="div-table">

  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:25%'><b>Guarantor </b></div>
    <div  class="cell" style='width:25%'><b>Phone/Address </b></div>
    <div  class="cell" style='width:25%'><b>Occupation </b></div>
    <div  class="cell" style='width:25%'><b>Signature </b></div>
  </div>
<?php
    $queryXX="SELECT `ID`,`Loan_ID`,`Guarantor`,`Contact`,`Occupation` FROM `loan guarantor` where `Loan_ID`='" . $row['ID'] . "' order by ID";
    $resultXX=mysqli_query($conn,$queryXX);

   if(mysqli_num_rows($resultXX) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

    while(list($idx,$lidx,$name,$contact,$occup)=mysqli_fetch_row($resultXX))
    {
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:25%"><a href = "loans.php?trans=1&acctno=' .$acctno. '&idx=' .$idx. '">' .$name. '</a></div>
        <div  class="cell" style="width:25%">' .$contact. '</div>
        <div  class="cell" style="width:25%">' .$occup. '</div>
        <div  class="cell" style="width:25%">'; 
      if (file_exists("images/sign/gr_" . $idx . ".jpg")==1)
      {
        echo '<img border="1" src="images/sign/gr_' . $idx . '.jpg" width="140" height="70">';
      } else {
        echo '<img border="1" src="images/sign/sign.jpg" width="140" height="70">';
      }
        echo '</div>
      </div>';
    }
echo "</div><div><a href ='loans.php?trans=1&acctno=$acctno&idx=$idx'>Add Guarantor </a></div>";

?>
</fieldset>
</body>
</fieldset>

<p>&nbsp;</p>
<fieldset>
<legend><b><i>Collateral</i></b></legend>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Collateral:</span>
	</label>
        <input type="text" size="15" name="collateral" value="<?php echo @$row['Collateral']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Location:</span>
	</label>
        <input type="text" size="15" name="location" value="<?php echo @$row['Collateral Location']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Value:</span>
	</label>
        <input type="text" size="15" name="value" value="<?php echo @$row['Collateral Value']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Title:</span>
	</label>
        <input type="text" size="15" name="title" value="<?php echo @$row['Collateral Title']; ?>" class="input__field input__field--chisato" placeholder=" ">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Description:</span>
	</label>
        <textarea cols="44" rows="2" name="description" class="input__field input__field--chisato" placeholder=" "><?php echo @$row['Collateral Description']; ?></textarea>
      </span>
</fieldset>
  <input type="submit" value="Add" name="submit" style="height:35; width:120; font-size: 13px;margin-top:-20px" onClick="return checkForm();"> &nbsp;  
     <span class="input input--chisato">
<?php
if($row2['Status']=="Active")
{
if (!$acctn){
?>
  <input type="submit" value="Add" name="submit" style="height:35; width:120; font-size: 13px;margin-top:-20px" onClick="return checkForm();"> &nbsp;
<?php
} if (!empty($acctn) and $confirm==1){
?>  
  <input type="submit" value="Confirm" name="submit" style="height:35; width:120;  font-size: 13px;margin-top:-20px" onClick="return checkForm();"> &nbsp;
<?php }  if (!empty($acctn) and $edit==1){ ?>
  <input type="submit" value="Update" name="submit" style="height:35; width:120;font-size: 13px;margin-top:-20px" onClick="return checkForm();"> &nbsp;  
  <input type="submit" value="Delete" name="submit" style="height:35; width:120; font-size: 13px;margin-top:-20px"  onclick="return confirm('Are you sure you want to Delete?');"> &nbsp;
<?php }} ?>
      </span>
</form>
</div>

<?php
if ($acctn)
{
?>
<p>&nbsp;</p>
<div class="div-table">
<fieldset>
<legend><b><font color='#FF0000' style='font-size: 12pt'>RE-PAYMENTS</font></b></legend>

 <?php
 $tval=$_GET['tval'];
 
   $query_count = "SELECT * FROM `loan payment` WHERE `Account Number`='" . $acctno . "' and `Loan ID` = '" . $row['ID'] . "'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
?>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell" style='width:33.3%;background-color:#c0c0c0'>S/No</div>
    <div  class="cell" style='width:33.3%;background-color:#c0c0c0'>Date</div>
    <div  class="cell" style='width:33.3%;background-color:#c0c0c0'>Amount </div>
  </div>
<?php
   $query = "SELECT `ID`,`Date`,`Amount`,`Account Number`,`Loan ID` FROM `loan payment` WHERE `Account Number`='" . $acctno . "' and `Loan ID` = '" . $row['ID'] . "' order by `ID` desc";
   $resultp=mysqli_query($conn,$query);

$i=0;
    while(list($id,$date,$amount,$acct,$loanid)=mysqli_fetch_row($resultp))
    {
     $amt=number_format($amount,2);
     $i=$i+1;
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:33.3%">' .$i. '</div>
        <div  class="cell" style="width:33.3%"><a href = "loanpay.php?id=' . $id . '&acct=' .$acct. '&loanidd=' .$row[ID]. '">' .$date. '</a></div>
        <div  class="cell" style="width:33.3%">' .$amount. '</div>
      </div>';
       $totalamt += $amount;
    }
    $totalamt=number_format($totalamt,2);

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:66.6%;background-color:#c0c0c0"><b>TOTAL</b></div>
        <div  class="cell" style="width:33.3%;background-color:#c0c0c0">' .$totalamt. '</div>
      </div>';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%"><a title="This will allow you to manually make repayment" href = "loanpay.php?acct=' .$acctno. '&loanidd=' . $row[ID] . '"><font color="#0e0000" style="font-size: 10pt">Add Payment</font></a></div>
        <div  class="cell" style="width:50%"><a  title="This will automatically make repayment of loan and debit customer account" href = "loanautopay.php?acct=' .$acctno. '&loanidd=' . $row['ID'] . '"><font color="#0e0000" style="font-size: 10pt">Auto-Payment</font></a></div>
      </div>';
?>
</div>
</fieldset>

<?php
 } 
?>
<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>
<?php
if($_REQUEST['tval']=="Your record has been saved.")
{
  echo "<script>alert('You Have Successfully Created The Account');</script>";
}
if($_REQUEST['tval']=="Your record has been updated.")
{
  echo "<script>alert('You Have Successfully Modified The Account');</script>";
}
?>