<?php
session_start();
require_once 'conn.php';
  require_once 'http.php';

if (isset($_SESSION['user_id'])) 
{
// set timeout period in seconds
$inactive = 1200;

// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
	$session_life = time() - $_SESSION['timeout'];
	if($session_life > $inactive)
        { 
		// go to login page when idle
		header("Location: transact-user.php?action=Logout"); 
	}
}
$_SESSION['timeout'] = time();
}
?>
  <html>
  <head>
    <title>MFB Software</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>

	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- font-awesome-icons -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- //font-awesome-icons -->


<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<!-- 	
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.css" />
   <link rel="shortcut icon" href="favicon.ico">
-->
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%m-%Y"

		});
		new JsDatePick({
			useMode:2,
			target:"inputField2",
			dateFormat:"%d-%m-%Y"

		});
		new JsDatePick({
			useMode:2,
			target:"inputField3",
			dateFormat:"%d-%m-%Y"

		});
		new JsDatePick({
			useMode:2,
			target:"inputField4",
			dateFormat:"%Y-%m-%d"

		});
		new JsDatePick({
			useMode:2,
			target:"inputField5",
			dateFormat:"%Y-%m-%d"

		});
	};
</script>
  </head>
   <link rel="shortcut icon" href="favicon.ico">
  <body bgcolor="#F7F7F7">
    <?php
$sql="SELECT * FROM `company info`";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
$tot  = mysqli_num_rows($result);

if($tot>0)
{

    ?>

<div align="center">
		<nav class="navbar navbar-default">
			<div class="navbar-header navbar-left">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
<?php  
echo '<h5 style="vertical-align:middle; margin-top:10px">Licenced to: <font color="#666666"><b>' . strtoupper($row['Company Name']) . '</b></font></h5>';
?>
<?php
      if (isset($_SESSION['name'])) 
      {
        echo '<b><i>' . strtoupper($_SESSION['name']) . '</b> is Currently Logged in</i>';
      }
?>
    <div>
     <a href="index.php"><img border="0" src="images/p_top.png" width="100%"></a>
   </div>	
			<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
					<nav>
						<ul class="nav navbar-nav">
							<li class="active"><a href="index.php" class="hvr-underline-from-center">Home</a></li>

<?php
           if (isset($_SESSION['user_id'])) 
           {
             if ($_SESSION['access_lvl'] == 1  or $_SESSION['access_lvl'] == 2  or $_SESSION['access_lvl'] == 3  or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 6) 
             { 
?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle hvr-underline-from-center" data-toggle="dropdown">Customer Service <b class="fa fa-caret-down"></b></a>
								<ul class="dropdown-menu agile_short_dropdown">
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="customer.php"><font style="font-size:11px">Customer Details</font></a></li>
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="register.php"><font style="font-size:11px">Customer Account (New/Modify)</font></a></li>
									<li style="text-align:left; margin-left:5px"><a href="closure.php"><font style="font-size:11px">Account Closure</font></a></li>

								</ul>
							</li>
           <?php
             }
             if ($_SESSION['access_lvl'] == 1 or $_SESSION['access_lvl'] == 2 or $_SESSION['access_lvl'] == 3 or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 7 or $_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 6) 
             { 
          ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle hvr-underline-from-center" data-toggle="dropdown">Transactions <b class="fa fa-caret-down"></b></a>
								<ul class="dropdown-menu agile_short_dropdown">
						           <?php
						             if ($_SESSION['access_lvl'] == 1 or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 6) 
						             { 
						          ?>
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="transactions.php"><font style="font-size:11px">Transactions</font></a></li>
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="sundry.php"><font style="font-size:11px">Sundry</font></a></li>
						           <?php
						             }
/*
						             if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 7 or $_SESSION['access_lvl'] == 5) 
						             { 
						          ?>
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="contribution.php"><font style="font-size:11px">Contributions</font></a></li>
						           <?php
						             }
*/
						          ?>
									<li style="text-align:left; margin-left:5px"><a href="dailytrans.php"><font style="font-size:11px">My Daily Report</font></a></li>
							    </ul>	
							</li>
          <?php
            }
             if ($_SESSION['access_lvl'] == 3 or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 6 or $_SESSION['access_lvl'] == 5) 
             { 
           ?>
							<li><a href="loans.php" class="hvr-underline-from-center">Loans</a></li>
<?php
}

             if ($_SESSION['access_lvl'] == 3 or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 5) 
             { 
?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle hvr-underline-from-center" data-toggle="dropdown">Accounts <b class="fa fa-caret-down"></b></a>
								<ul class="dropdown-menu agile_short_dropdown">
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="account/account.php"><font style="font-size:11px">Entry Journal</font></a></li>
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="account/suspense.php"><font style="font-size:11px">Suspense Accounts</font></a></li>
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="account/provisions.php"><font style="font-size:11px">Loans Provisions</font></a></li>
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="account/fassets.php"><font style="font-size:11px">Fixed Assets</font></a></li>
									<li style="text-align:left; margin-left:5px; margin-bottom:10px"><a href="account/contract.php"><font style="font-size:11px">Contractors</font></a></li>
									<li style="text-align:left; margin-left:5px"><a href="account/paysumm.php"><font style="font-size:11px">Payment Summary</font></a></li>
								 </ul>	
							</li>
<?php
            }
             if ($_SESSION['access_lvl'] == 3 or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 6) 
             { 
?>
							<li><a href="report.php" class="hvr-underline-from-center">Reports</a></li>
<?php
            }
             if ($_SESSION['access_lvl'] == 5) 
             { 
?>
							<li><a href="syslog.php" class="hvr-underline-from-center">System Log</a></li>
<?php
            }
             if ($_SESSION['access_lvl'] == 3 or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 5) 
             { 
?>
							<li><a href="admin.php" class="hvr-underline-from-center">Control Panel</a></li>
<?php
             }
?>
							<li><a href="resetpwd.php" class="hvr-underline-from-center">Change Your Password</a></li>
							<li><a href="transact-user.php?action=Logout" class="hvr-underline-from-center">Logout</a></li>
<?php
}
?>
						</ul>
					</nav>

				</div>
		<div class="clearfix"> </div>
		</nav>

<?php  
#require_once 'repss.php'; 
} else {
?>
    <div>
     <a href="index.php"><img border="0" src="images/p_top.png" width="100%"></a>
   </div>	
<?php
  require_once 'registerr.php';
}
?>
 </div>
	<!-- menu -->
	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/modernizr.custom.46884.js"></script>

	<!-- Stats -->
	<script src="js/waypoints.min.js"></script>
	<script src="js/counterup.min.js"></script>
	<script>
		jQuery(document).ready(function ($) {
			$('.counter').counterUp({
				delay: 10,
				time: 2000
			});
		});
	</script>
	<!-- //Stats -->
	<!-- for bootstrap working -->
	<script src="js/bootstrap.js"></script>
	<!-- //for bootstrap working -->

<div id="articles">