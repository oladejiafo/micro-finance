<?php
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 1; URL=index.php?redirect=$redirect");
 require_once 'header.php'; 
 require_once 'style.php';
?>

<div align="center">
	<table border="0" width="100%" cellspacing="0" cellpadding="0" id="table1">
		<tr>
			<td>
			<div align="center">
				<table border="0" width="95%" cellspacing="11" cellpadding="10" id="table2" bgcolor="#e8e7e6">
					<tr>
						<td>
						<fieldset style="border: 1px solid #006633; padding-left: 4px; padding-right: 4px; padding-top: 1px; padding-bottom: 1px" >
						<legend>
						<font style="font-size: 16pt; font-weight: 700" face="Verdana" color="#006633">User Login</font></legend>

<form method="post" action="transact-user.php">

<p style="line-height: 18px; margin-left: 20px">
<font face="Verdana"><span style="font-size: 9pt"><b>User Name:<br />
</b>
<input name="uname" maxlength="255" style="font-weight: 700" /><b> </b></span>
</font>
</p>
<p style="line-height: 18px; margin-left: 20px">
<font face="Verdana"><span style="font-size: 9pt; font-weight: 700">Password:<br />
</span>
<input type="password" name="passwd" maxlength="50" />
</font>
</p>
<p style="margin-left: 20px">
<input type="submit" class="submit" name="action" value="Login" />
</p>
<p style="margin-left: 20px">
<font face="Verdana" style="font-size: 9pt; font-weight: 700">
<?php
#echo "<a href="forgotpass.php">Forgot your password?</a>";
?>
</font>
</p>
</form>

						<p>&nbsp;</p>
						</fieldset><p>&nbsp;</td>
					</tr>
				</table>
			</div>
			<p>&nbsp;</td>
		</tr>
	</table>
</div>

<?php 
 require_once 'footr.php'; 
 require_once 'footer.php';
 ?>