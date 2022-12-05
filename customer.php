<?php 
session_start();

//check to see if user has logged in with a valid password
if (!isset($_SESSION['user_id']) & ($_SESSION['access_lvl'] != 5) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 2){
#$tval="Sorry, but you don’t have permission to view this page! Login pls";
header("location:index.php?tval=$tval&redirect=$redirect");
}
}
 require_once 'header.php';
 require_once 'conn.php';
 require_once 'style.php';
@$acctno=$_REQUEST['acctno'];
@$tval=$_REQUEST['tval'];

@$codd=$_REQUEST["code"];

#################################
@list($code, $dash, $name) = explode(' ', $codd);

if (!$acctno)
{
 $sql="SELECT * FROM `customer` WHERE `Account Number`='$code'";
 #$sql="SELECT * FROM stock WHERE `Stock Code` = '$code'";
 $codd=empty($codd);
} else {
  list($nam1,$dash, $nam2) = explode(' ', $acctn);
# or (`Surname` like '%$acctno%' or `First Name` like '%$acctno%' or `First Name` like '%$nam1%'  or `First Name` like '%$nam2%'  or `Surname` like '%$nam1%' or `surname` like '%$nam2%')
  $sql="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
}
#################################
#$sql="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
$totrows  = mysqli_num_rows($result);
?>
<script language="JavaScript" type="text/javascript">
<!--

function filtery(pattern, list){

  if (!list.bak){

    list.bak = new Array();
    for (n=0;n<list.length;n++){
      list.bak[list.bak.length] = new Array(list[n].value, list[n].text);
    }
  }

  match = new Array();
  nomatch = new Array();
  for (n=0;n<list.bak.length;n++){
    if(list.bak[n][1].toLowerCase().indexOf(pattern.toLowerCase())!=-1){
      match[match.length] = new Array(list.bak[n][0], list.bak[n][1]);
    }else{
      nomatch[nomatch.length] = new Array(list.bak[n][0], list.bak[n][1]);
    }
  }

  for (n=0;n<match.length;n++){
    list[n].value = match[n][0];
    list[n].text = match[n][1];
  }
  for (n=0;n<nomatch.length;n++){
    list[n+match.length].value = nomatch[n][0];
    list[n+match.length].text = nomatch[n][1];
  }

  list.selectedIndex=0;
}
// -->
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
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Customer Service</font></b>
 </div>
<br>

<div id=register align="center">
<body onload="document.customer.acctno.focus()" onfocus="document.customer.acctno.focus()">
<form name="customer" action="customer.php" method="post">
        Enter Account No. or Name: <br>
        <input type="text" autocomplete="off" size="15" name="acctno" onBlur="filtery(this.value,this.form.code)" style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
&nbsp;
       <input name="go" type="submit" value="Search" align="top" style="height:35; color:#008000; font-size: 15pt">
<input type="hidden" name="id" size="31" value="<?php echo $row['ID']; ?>">
</form>

<?php
if($totrows==0 and !empty($acctno))
{
?>
<form name="customer" action="customer.php" method="post">
<div align="center">
<div align="leftt" style="margin-left:20px;" class="agileinfo_mail_grids">
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span style="margin-left:10px" class="input__label-content input__label-content--chisato">Select Name</span>
	</label>   
        <select class="input__field input__field--chisato" placeholder=" " name="code" width="31" style="height:45px;width:300px;color:#000">  
          <?php  
           echo '<option selected></option>';
           if (!is_numeric($acctno))
           {
             $sql = "SELECT `Account Number`,`Surname`,`First Name` FROM `customer` where `First Name` like '%$acctno%' or `Surname` like '%$acctno%' or `Contact Number` like '%$acctno%' or `Mobile Number` like '%$acctno%' order by `Account Number`";
             $result_c = mysqli_query($conn,$sql) or die('Could not list value; ' . mysqli_error());
             while ($rows = mysqli_fetch_array($result_c)) 
             {
               echo '<option>' . $rows['Account Number'] . ' - ' . $rows['First Name'] . ' ' . $rows['Surname'] . '</option>';
             }
           }
          ?> 
         </select> &nbsp;
       <input name="submit" type="submit" value="Select" align="top"> 
</span>

</form>
<?php
}
?>
</body>

<?php
if($row['Group'])
{
?>
  <div align="center">
    <b><font size="3" face="Tahoma"><?php echo strtoupper($row['Group']); ?> ACCOUNT</font></b>
  </div>

<?php
}
?>

<?php
if($row['Group']=="Group")
{
?>
<form method="post" action="submitreg.php" enctype="multipart/form-data">
<p>&nbsp;</p>
<fieldset>
<legend><b><i><font size="2" face="Tahoma" color="green">Account Information</font></i></b></legend>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo @$row['Account Number']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Type:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo @$row['Account Type']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Registration Date:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo date('d-m-Y',strtotime($row['Date Registered'])); ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Officer:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Account Officer']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Identification Type:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Identification Type']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Identification Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Identification Number']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Branch:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo @$row['Branch']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Customer Category:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Customer Category']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Status:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Status']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Balance:</span>
	</label>
        <?php 
          $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysqli_error());
          $rowb = mysqli_fetch_array($resultb); 
         
        ?>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $rowb['Balance']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">
		  <font color='Red'><b> Enable SMS Alert? </b></font></span>
	</label>
<div class="radioGroup">
        <font color='Red'><b>
        <?php
          $sqln = "SELECT `val`,`type` FROM `booln` ORDER BY `type` desc";
          $result_cn = mysqli_query($conn,$sqln) or die('Could not list; ' . mysqli_error());

          $cn=$row['SMS'];

          while ($rows = mysqli_fetch_array($result_cn)) 
          {
           echo ' <input type="radio" align="left" id="cn_' . $rows['val'] . '" name="sms" value="' . $rows['val'] . '" ';
           if ($rows['val'] == $cn) 
           {
             echo 'checked="checked" ';
           }
           echo '/><label>' . $rows['type'] . "</label>\n";
          }
        ?>
      </b></font>
      </div>
      </span>

      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">
		  <font color='Red'><b> Enable e-Mail Alert? </b></font></span>
	</label>
<div class="radioGroup">
        <font color='Red'><b>
        <?php
          $sqlm = "SELECT `val`,`type` FROM `booln` ORDER BY `type` desc";
          $result_cm = mysqli_query($conn,$sqlm) or die('Could not list; ' . mysqli_error());

          $cm=$row['email alert'];

          while ($rows = mysqli_fetch_array($result_cm)) 
          {
           echo ' <input type="radio" align="left" id="cm_' . $rows['val'] . '" name="emailalert" value="' . $rows['val'] . '" ';
           if ($rows['val'] == $cm) 
           {
             echo 'checked="checked" ';
           }
           echo '/><label>' . $rows['type'] . "</label>\n";
          }
        ?>
      </b></font>
      </div>
    </span>
 </fieldset>
 <br>
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Group Information</font></i></b></legend>
<div align="left">
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Group Name:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Group Name']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>

 <fieldset style="padding: 2">
 <legend><b><i><font size="2" face="Tahoma" color="green">Principal Signatories #1</font></i></b></legend>
      <span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
	 <?php  if (file_exists("images/pics/" . $id . "x1.jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $id; ?>x1.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
</span>
</div>
</span>
<span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
	 <?php  if (file_exists("images/sign/" . $id . "x1.jpg")==1)
            { ?>
              <img border="1" src="images/sign/<?php echo $id; ?>x1.jpg" width="140" height="90">
	 <?php  } else { ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="90">	 
	 <?php  } ?>			 
</span>
</div>
</span>

      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Name:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Name1']; ?>" readonly="readonly" style="background-color:#eeeeee">        
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Position:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Position1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Contact Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contact Number1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Mobile Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Mobile Number1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Office Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Office Address1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Home Address1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Marital Status:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Marital Status1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Gender:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Gender1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Age:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Age1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 e-Mail:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['email1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Occupation:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Occupation1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Employer:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Employer1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Next of Kin:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Next of Kin1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Relationship:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Relationship1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#1 Next of Kin Contact/Phone:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['NKin Contact1']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
 </fieldset>
 <fieldset style="padding: 2">
 <legend><b><i><font size="2" face="Tahoma" color="green">Principal Signatories #2</font></i></b></legend>
      <span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
	 <?php  if (file_exists("images/pics/" . $id . "x2.jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $id; ?>x2.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
</span>
</div>
</span>
<span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
	 <?php  if (file_exists("images/sign/" . $id . "x2.jpg")==1)
            { ?>
              <img border="1" src="images/sign/<?php echo $id; ?>x2.jpg" width="140" height="90">
	 <?php  } else { ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="90">	 
	 <?php  } ?>			 
</span>
</div>
</span>

      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Name:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Name2']; ?>" readonly="readonly" style="background-color:#eeeeee">        
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Position:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Position2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Contact Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contact Number2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Mobile Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Mobile Number2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Office Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Office Address2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Home Address2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Marital Status:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Marital Status2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Gender:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Gender2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Age:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Age2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 e-Mail:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['email2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Occupation:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Occupation2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Employer:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Employer2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Next of Kin:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Next of Kin2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Relationship:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Relationship2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#2 Next of Kin Contact/Phone:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['NKin Contact2']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
 </fieldset>
 <fieldset style="padding: 2">
 <legend><b><i><font size="2" face="Tahoma" color="green">Principal Signatories #3</font></i></b></legend>
      <span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
	 <?php  if (file_exists("images/pics/" . $id . "x3.jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $id; ?>x3.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
</span>
</div>
</span>
<span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
	 <?php  if (file_exists("images/sign/" . $id . "x3.jpg")==1)
            { ?>
              <img border="1" src="images/sign/<?php echo $id; ?>x3.jpg" width="140" height="90">
	 <?php  } else { ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="90">	 
	 <?php  } ?>			 
</span>
</div>
</span>

      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Name:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Name3']; ?>" readonly="readonly" style="background-color:#eeeeee">        
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Position:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Position3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Contact Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contact Number3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Mobile Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Mobile Number3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Office Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Office Address3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Home Address3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Marital Status:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Marital Status3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Gender:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Gender3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Age:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Age3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 e-Mail:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['email3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Occupation:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Occupation3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Employer:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Employer3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Next of Kin:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Next of Kin3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Relationship:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Relationship3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">#3 Next of Kin Contact/Phone:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['NKin Contact3']; ?>" readonly="readonly" style="background-color:#eeeeee"> 
      </span>
 </fieldset>
 <br>

  </div>
</body>
</form>
<?php
} else {
?>
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Account Information</font></i></b></legend>
     <span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
	 <?php  if (file_exists("images/pics/" . $row['ID'] . ".jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $row['ID']; ?>.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
</span>
</div>
</span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo @$row['Account Number']; ?>" readonly="readonly" style="background-color:#eeeeee">
        <input type="hidden" name="id" size="31" value="<?php echo $row['ID']; ?>">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Type:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Account Type']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
<span class="input input--chisato" style="vertical-align:bottom">
<div style="vertical-align:bottom">
<span>
	 <?php  if (file_exists("images/sign/" . $row['ID'] . ".jpg")==1)
            { ?>
              <img border="1" src="images/sign/<?php echo $row['ID']; ?>.jpg" width="140" height="90">
	 <?php  } else { ?>
              <img border="1" src="images/sign/sign.jpg" width="140" height="90">	 
	 <?php  } ?>			 
</span>
</div>
</span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Registration Date:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo date('d-m-Y',strtotime($row['Date Registered'])); ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Officer:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Account Officer']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Identification Type:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Identification Type']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Identification Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Identification Number']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Status:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Status']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Account Balance:</span>
	</label>
        <?php 
          $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysqli_error());
          $rowb = mysqli_fetch_array($resultb); 
        ?>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $rowb['Balance']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Branch:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Branch']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">
		  <font color='Red'><b> Enable SMS Alert? </b></font></span>
	</label>
<div class="radioGroup">
        <font color='Red'><b>
        <?php
          $sqln = "SELECT `val`,`type` FROM `booln` ORDER BY `type` desc";
          $result_cn = mysqli_query($conn,$sqln) or die('Could not list; ' . mysqli_error());

          $cn=$row['SMS'];

          while ($rows = mysqli_fetch_array($result_cn)) 
          {
           echo ' <input type="radio" align="left" id="cn_' . $rows['val'] . '" name="sms" value="' . $rows['val'] . '" ';
           if ($rows['val'] == $cn) 
           {
             echo 'checked="checked" ';
           }
           echo '/><label>' . $rows['type'] . "</label>\n";
          }
        ?>
      </b></font>
      </div>
      </span>

      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">
		  <font color='Red'><b> Enable e-Mail Alert? </b></font></span>
	</label>
<div class="radioGroup">
        <font color='Red'><b>
        <?php
          $sqlm = "SELECT `val`,`type` FROM `booln` ORDER BY `type` desc";
          $result_cm = mysqli_query($conn,$sqlm) or die('Could not list; ' . mysqli_error());

          $cm=$row['email alert'];

          while ($rows = mysqli_fetch_array($result_cm)) 
          {
           echo ' <input type="radio" align="left" id="cm_' . $rows['val'] . '" name="emailalert" value="' . $rows['val'] . '" ';
           if ($rows['val'] == $cm) 
           {
             echo 'checked="checked" ';
           }
           echo '/><label>' . $rows['type'] . "</label>\n";
          }
        ?>
      </b></font>
      </div>
    </span>
 </fieldset>
 <br>
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Personal Information</font></i></b></legend>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">First Name:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['First Name']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Surname:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Surname']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Marital Status:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Marital Status']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Gender:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Gender']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Age:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Age']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">e-Mail:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['email']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Occupation:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Occupation']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Employer:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Employer']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Position:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Position']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Office Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Office Address']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Contact Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Contact Number']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Mobile Number:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Mobile Number']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Contact Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Home Address']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Postal Address:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Postal Address']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Date of Birth:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo date('d-m-Y',strtotime($row['Date of Birth'])); ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
 </fieldset>
 <br>
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Next of Kin Information</font></i></b></legend>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Next of Kin:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Next of Kin']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Relationship:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['Relationship']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Next of Kin Contact:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['NKin Contact']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
      <span class="input input--chisato">
	<label class="input__label input__label--chisato">
		<span class="input__label-content input__label-content--chisato">Next of Kin Phone:</span>
	</label>
       <input type="text" name="acctno"  class="input__field input__field--chisato" placeholder=" " value="<?php echo $row['NK Phone']; ?>" readonly="readonly" style="background-color:#eeeeee">
      </span>
 </fieldset>
<?php
}
?>
 <br>
<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="green">Transaction History</font></i></b></legend>
<p>&nbsp;</p>
<div class="div-table">
 <?php
 @$tval=$_GET['tval'];
 $limit      = 30;
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
    <div  class="cell"  style='width:14.2%'>S/NO</div>
    <div  class="cell" style='width:14.2%'>Transaction Date</div>
    <div  class="cell" style='width:14.2%'>Account Number</div>
    <div  class="cell" style='width:14.2%'>Customer Name</div>
    <div  class="cell" style='width:14.2%'>Deposit Amount</div>
    <div  class="cell" style='width:14.2%'>Withdrawal Amount</div>
    <div  class="cell" style='width:14.2%'>Note </div>
  </div>
<?php

   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal`,`Transaction Type`,`Remark` FROM `transactions` WHERE `Account Number`='" . $acctno . "' order by `ID` desc LIMIT 0, $limit";
   $resultp=mysqli_query($conn,$query);
   
$i=0;
    while(list($idd,$date,$acctno,$depamt,$wthamt,$transt,$remk)=mysqli_fetch_row($resultp))
    { 
      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysqli_error());
      $roww = mysqli_fetch_array($resultw); 

      $fn=$roww['First Name'];  
      $sn=$roww['Surname'];
      $name=$fn . ' ' . $sn;

     $deppamt=number_format($depamt,2);
     $wthhamt=number_format($wthamt,2);
     $i=$i+1;

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:14.2%">' .$i. '</div>
        <div  class="cell" style="width:14.2%">' .$date. '</div>
        <div  class="cell" style="width:14.2%">' .$acctno. '</div>
        <div  class="cell" style="width:14.2%">' .$name. '</div>
        <div  class="cell" style="width:14.2%">' .$deppamt. '</div>
        <div  class="cell" style="width:14.2%">' .$wthamt. '</div>
        <div  class="cell" style="width:14.2%">' .$transt. ' - ' .$remk. '</div>
      </div>';
    }
?>
</div>
<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>