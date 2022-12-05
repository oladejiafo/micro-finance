<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & $_SESSION['access_lvl'] != 3) 
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}

require_once 'conn.php';
require_once 'header.php';
require_once 'style.php';

$a_users = array(1 => "Administrator", "Stores");
function echoUserList($lvl) {
global $a_users;
$sql = "SELECT user_id, username, email FROM login " .
"WHERE access_lvl = $lvl ORDER BY username";
$result = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($result) == 0) {
echo "<em>No " . $a_users[$lvl] . " created.</em>";
} else {
while ($row = mysql_fetch_array($result)) {
if ($row['user_id'] == $_SESSION['user_id']) {
echo htmlspecialchars($row['username']) . "<br />\n";
} else {
echo '<a href="useraccount.php?user_id=' . $row['user_id'] .
'" title="' . htmlspecialchars($row['email']) . '">' .
htmlspecialchars($row['username']) . "</a><br />\n";
}
}
}
}
?>
<style type="text/css">
<!--
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
	<table border="0" width="100%" height="250" id="table1" bgcolor="#e8e7e6" cellspacing="0" cellpadding="0">
		<tr>
			<td style="text-align: left; margin-left: 10"><b>
			<font face="Verdana" size="4" color="#006633">&nbsp;Administration Area</font></b></td>
		</tr>
		<tr>
			<td bgcolor="#006633">
			<img border="0" src="../images/spacer.gif" width="1" height="1"></td>
		</tr>
		<tr>
			<td style="text-align: left; margin-left: 20; padding-left: 20px">
			<table border="1" width="95%" id="table2">
				<tr>
					<td width="25%" bordercolor="#009900" bgcolor="#F0FFC1">&nbsp;</td>
					<td width="25%" bordercolor="#009900" bgcolor="#F0FFC1">&nbsp;</td>
					<td width="25%" bordercolor="#009900" bgcolor="#F0FFC1">&nbsp;</td>
				</tr>
				<tr>
					<td bordercolor="#003300" bgcolor="#003300"><span class="style3">Create User Accounts </span></td>
					<td bordercolor="#009900" bgcolor="#99CC00"><span class="style1">Modify User Accounts </span></td>
					<td bordercolor="#009900" bgcolor="#CCCC00"><span class="style1">Update Tables </span></td>
				</tr>
				<tr>
				  <td bordercolor="#009900" bgcolor="#F0FFC1" valign="top">
					<div align="center">
						<table border="0" width="95%" cellspacing="1" id="table3">
							<tr>
								<td width="17%">
								<img border="0" src="images/icon_network.gif" width="47" height="50"></td>
								<td valign="top">
								<p style="line-height: 18px">
								<font face="Verdana" style="font-size: 9pt">
								Create new users' Accounts and assign priviledges here.</font></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><?php
  echo '<h5><a href ="useraccount.php"> Add User </a></h5>';
?></td>
							</tr>
						</table>
					</div>				  </td>
				  <td bordercolor="#009900" bgcolor="#F0FFC1" valign="top">
					<div align="center">
						<table border="0" width="95%" cellspacing="1" id="table4">
							<tr>
								<td width="17%" valign="top">
								<p style="line-height: 22px">
								<font face="Verdana" style="font-size: 9pt">
								<img border="0" src="images/43be6322e6.gif" width="32" height="32"></font></td>
								<td width="80%" valign="top">
								<p style="line-height: 22px">
								<font face="Verdana" style="font-size: 9pt">
								Modify users' accounts, delete 
								users and privileges.</font></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><?php
  echo "<h5><a href ='listing.php'> List of Users </a></h5>";
?></td>
							</tr>
						</table>
					</div>				  </td>
					<td bordercolor="#009900" bgcolor="#F0FFC1" valign="top">
					<div align="center">
						<table border="0" width="95%" cellspacing="1" id="table5">
							<tr>
								<td width="25%" valign="top">
								<p style="line-height: 22px">
								<img border="0" src="images/coreserv.gif" width="50" height="50"></td>
								<td width="70%" valign="top">
								<p style="line-height: 22px">
								<font style="font-size: 9pt" face="Verdana">
								Update and delete 
								table contents.</font></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><?php
   echo "<h5><a href ='tableupdates.php'> Tables Update </a></h5>";
?></td>
							</tr>
						</table>
					</div>				  </td>

				</tr>
			</table>

			</td>
<?php 

			  require_once 'footr.php'; 
			  require_once 'footer.php'; 
			  ?>
		</tr>
	</table>
</div>
