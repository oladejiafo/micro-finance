<?php
session_start();
 require_once 'header.php';
 require_once 'conn.php';
 require_once 'style.php';

$sql="SELECT * FROM `company info`";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);

$tot  = mysqli_num_rows($result);

if($tot==0)
{
  require_once 'registerr.php';
 // header("location:registerr.php?tval=$tval&redirect=$redirect");
} else {

?>
	
<?php
if (isset($_SESSION['user_id']))
{
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {font-size: 11px}
.style3 {color: #CCCCCC}
.chart {
  width: 100%; 
  min-height: 150px;
    -moz-border-radius: 30px 30px 30px 30px;
    -webkit-border-radius: 30px 30px 30px 30px;
    border-radius: 15px;
}
 .rounded-cornersx {
    -moz-border-radius: 30px 30px 30px 30px;
    -webkit-border-radius: 30px 30px 30px 30px;
    border-radius: 15px;
}	
 @media only screen and (max-width: 460px) {
.chart {
  width: 100%; 
  height: 50%;
}
}
-->
</style>
<div align="center">
	<div class="services">
		<div class="container">
<font style="font-size:22px; font-weight:bolder; font-family:Arial, Helvetica, sans-serif; color: #CC0000">WELCOME</font>
	<p><font face="Tahoma" color="#c0c0c9">&nbsp;This is the welcome screen of the FinaSol Software, A Financial Services Management System, a robust application for the management and automation of the operations of a financial services company.&nbsp; <br>
                    </font></p>

					

				<div class="w3ls_address_mail_footer_grids">
				<div class="col-md-4 w3ls_footer_grid_left con">
					<p><font color="#000000"  style="font-size:14px;"><a target="_blank" title="Click to Fill or Download the Lease Application Form" href="leaseapp.php" style="text-decoration: none"> <font face="Tahoma" size="4" color="#000000">
					</font>
					<img align="center" border="0" src="images/cust.png" width="100%"  align="left"></a></font></p>
				</div>
				<div class="col-md-4 w3ls_footer_grid_left con">
					<p><a target="_blank" title="Click to Fill or Download the Loans Application Form" href="loanapp.php" style="text-decoration: none"> <font face="Tahoma" size="4" color="#000000">
					</font> 
					<img align="center" border="0" src="images/loan.png" width="100%" align="left"></a></font></p>
				</div>
				<div class="col-md-4 w3ls_footer_grid_left con">
					<p><?php if (isset($_SESSION['user_id'])) { ?><a title="Click to go to contributions records" href="transactions.php" style="text-decoration: none"> <?php } ?><font face="Tahoma" size="4" color="#000000">
					</font> 
					<img align="center" border="0" src="images/contri.png" width="100%" align="left"></a></font></p>
				</div>
				<div class="clearfix"> </div>
		  </div>
		</div>
<?php
} else {
?>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<?php echo '<font style="font-size: 10pt; font-weight: 700" face="Verdana" color="#FF0000">' . $_REQUEST['tval'] . '</font>'; ?>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">
					<span class="login100-form-title-1">
						Staff Login
					</span>
				</div>

				<form class="login100-form validate-form" method="post" action="transact-user.php">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="uname" placeholder="Enter username" autocomplete="off">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="passwd" placeholder="Enter password">
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-30">
						<div class="contact100-form-checkbox">
						</div>

						<div>
							
						</div>
					</div>

					<div class="container-login100-form-btn">
					  <input type="submit" class="login100-form-btn" name="action" value="Login"/>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<?php
}
}
?>
<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>

