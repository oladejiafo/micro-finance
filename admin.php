<?php
session_start();
 require_once 'header.php';
 require_once 'conn.php';
 require_once 'style.php';

//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & $_SESSION['access_lvl'] != 5) 
{
 if ($_SESSION['access_lvl'] != 1 & $_SESSION['access_lvl'] != 2 & $_SESSION['access_lvl'] != 3 & $_SESSION['access_lvl'] != 4) 
 {
   $redirect = $_SERVER['PHP_SELF'];
   header("Refresh: 0; URL=index.php?redirect=$redirect");
 }
}

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
 .rounded-corners {
    -moz-border-radius: 30px 30px 30px 30px;
    -webkit-border-radius: 30px 30px 30px 30px;
    border-radius: 15px;
}	
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; color: #FFCC00; font-size: 14px; }
-->
</style>


<div align="center">
	<div class="services">
		<div class="container">
<font style="font-size:22px; font-weight:bolder; font-family:Arial, Helvetica, sans-serif; color: #CC0000">CONTROL PANEL</font>

				<div class="w3ls_address_mail_footer_grids">
				<div class="col-md-4 w3ls_footer_grid_left con" style="background-color:f9fbfd; height:120px">
					<div>
						<b class="fa fa-user">
						<font color="#000000"  style="font-size:16px;">Create User Accounts</font></b>
					</div>
					<p style="line-height: 22px"><font face="Verdana" style="font-size: 9pt">
					Create new users' Accounts and assign priviledges here.</font></p>
<?php
  echo '<h4><a href ="useraccount.php"><font  style="font-size:15px;"> Add User </font></a></h4>';
?>
				</div>
				<div class="col-md-4 w3ls_footer_grid_left con" style="background-color:ccff99; height:120px">
					<div>
						<b class="fa fa-pencil">
						<font color="#000000"  style="font-size:16px;">Modify User Accounts</font></b>
					</div>
					<p style="line-height: 22px"><font face="Verdana" style="font-size: 9pt">
					Modify users' accounts, delete users and privileges.</font></p>
<?php
  echo "<h2><a href ='listing.php'><font  style='font-size:15px;'> List of Users </font></a></h2>";
?>
				</div>
				<div class="col-md-4 w3ls_footer_grid_left con"  style="background-color:ff3300; height:120px">
					<div>
						<b class="fa fa-pencil">
						<font color="#000000"  style="font-size:16px;">General Settings</font></b>
					</div>
					<p style="line-height: 22px"><font color="#000000" style="font-size: 9pt" face="Verdana">
					Update and delete table contents.</font></p>
<?php
   echo "<br><h4><a href ='tableupdates.php'><font  style='font-size:15px;'> Settings </font></a></h4>";
?>
				</div>
				<div class="clearfix"> </div>
		  </div>
		</div>
<div height="40px">&nbsp;</div>

<p align="right" style="margin-right:20px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
 &copy 2011-<?php echo date('Y');?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>

</div>
</div>
</div>
