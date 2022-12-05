<?php
require_once 'conn.php';
?>
  <html>
  <head>
    <title>FinaSol Software</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
	};
</script>
  </head>
  <body bgcolor="#FFFFFF">

<div align="center">
	<table border="1" width="80%" bordercolor="#00CC99" bgcolor="#ffffff" id="table1">
	<tr>
			<td colspan="2">

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#dcdfdf" width="100%">
    <td width="100%" height="90" colspan="2">
    <img border="0" src="images/p_top.jpg" width="100%" height="90"></td>
</table>

   <div id="navright">
     
       <div id="maincolumn">
         <div align="right" id='navigation'>
<font size="3px" face="Arial">

    <?php
           echo '<a href="index.php">Home</a>';

           if (!isset($_SESSION['user_id'])) 
           {
            # echo ' | <a href="login.php">Login</a>';
           } 
           else 
           {
             if ($_SESSION['access_lvl'] == 2) 
             {
               ############# CUSTOMER SERVICE ###############
               echo ' | <a href="customer.php">Customer Service</a>';
               echo ' | <a href="report.php">Reports</a>';
             }
             if ($_SESSION['access_lvl'] == 1) 
             {
               ################# CASHIER ####################
               #echo ' | <a href="customer.php">Customer Service</a>';
               echo ' | <a href="transactions.php">Cashier</a>';
              # echo ' | <a href="report.php">Reports</a>';
             }
             if ($_SESSION['access_lvl'] == 3) 
             {
               ######## ACCOUNTS #########################
               echo ' | <a href="customer.php">Customer Service</a>';
               echo ' | <a href="loans.php">Loans</a>';
               echo ' | <a href="account/account.php">Accounts</a>';
               echo ' | <a href="report.php">Reports</a>';
             }
             if ($_SESSION['access_lvl'] == 4) 
             {
               ########### MANAGER #########################
               echo ' | <a href="customer.php">Customer Service</a>';
               #echo ' | <a href="cashier.php">Cashier</a>';
               echo ' | <a href="loans.php">Loans</a>';
               echo ' | <a href="account/account.php">Accounts</a>';
               echo ' | <a href="report.php">Reports</a>';
             }
             if ($_SESSION['access_lvl'] == 5) 
             {
               ##########ADMINISTRATOR/PROPRIETOR##############
               echo ' | <a href="customer.php">Customer Service</a>';
               #echo ' | <a href="cashier.php">Cashier</a>';
               echo ' | <a href="loans.php">Loans</a>';
               echo ' | <a href="account/account.php">Accounts</a>';
               echo ' | <a href="report.php">Reports</a>';
               echo ' | <a href="syslog.php">System Log</a>';
               echo ' | <a href="admin.php">Admin Center</a>';
             }
             if ($_SESSION['access_lvl'] == 6) 
             {
               ######## LOANS #########################
               echo ' | <a href="loans.php">Loans</a>';
             
             }
             require_once 'monthlycharges.php';
             echo ' | <a href="transact-user.php?action=Logout">Logout</a>';
           }
     

$sql="SELECT * FROM `company info`";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);
    ?>
<table border="1" cellpadding="1" cellspacing="0" style="border-collapse: collapse" bordercolor="#dcdfdf" width="100%" height="1">
    <td width="100%" height="1" colspan="2">
</td>
</table>
<table width="100%">
<tr><td width="50%" align="left">
    <?php  echo '<b><left>Licenced to <font color="red">' . strtoupper($row['Company Name']) . '</font></left></b>';?>
</td>
<td width="50%" align="right">
<?php
  if (isset($_SESSION['name'])) 
  {
    echo '<b>' . strtoupper($_SESSION['name']) . '</b> is Currently Logged in';
  }
require_once 'reps.php';
?>
</td>
</tr></table>
</font>

   </div>

 </div>
<div id="articles">