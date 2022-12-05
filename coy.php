<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 5))
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

$sql="SELECT * FROM `company info`";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
@$row = mysqli_fetch_array($result);
?>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<!-- 	
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.css" />
-->
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%Y-%m-%d"

		});
	};
</script>

</head>
<div align="center">
	<table border="0" width="100%" bgcolor="#FFFFFF" id="table1" valign="top">
		<tr align='center' valign="top">
 <td bgcolor="#cbd9d9" valign="top"><b>
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">COMPANY INFO</font></b>
 </td>
</tr>
		<tr>
			<td colspan="2">

<form action="submitcoy.php" method="post"  enctype='multipart/form-data'>
<fieldset style="padding: 2">
<div align="left">

  <table width="85%">
    <tr>
      <td width="15%" valign="top">
      <font face="Verdana" style="font-size: 9pt">Company Phone#:
      </font>
      </td>
      <td width="20%" valign="top">
        <font face="Verdana"><span style="font-size: 9pt">
        <textarea name="phone" cols="20" rows="2"><?php echo $row['Phone']; ?></textarea>
      	</span></font>
      </td>
      <td width="5"></td>
      <td width="12%" valign="top">
      <font face="Verdana" style="font-size: 9pt">e-mail:
      </font>
      </td>
      <td width="20%" valign="top">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="email" size="24" value="<?php echo $row['Email']; ?>">
      	</span></font> 
      </td>
      <td width="2"></td>
   <td width="23%" rowspan=3  valign="top">
    Browse & Upload Logo: <input name="image_filename" type="file" id="image_filename" size="15"><br>
	 <?php  if (file_exists("images/logo.jpg")==1)
            { ?>
              <img border="1" src="images/logo.jpg" width="150" height="100">
	 <?php  } else { ?>
              <img border="1" src="images/pixlogo.jpg" width="150" height="100">	 
	 <?php  } ?>			 

</td>
    </tr>
    <tr>
      <td width="8%" valign="top">
      <font face="Verdana" style="font-size: 9pt">City:
      </font>
      </td>
      <td width="10%" valign="top">
        <font face="Verdana"><span style="font-size: 9pt">
        <input type="text" name="city" size="10" value="<?php echo $row['City']; ?>">
      	</span></font> 
      </td>
      <td width="5"></td>
      <td width="15%" valign="top">
      <font face="Verdana" style="font-size: 9pt">Address:
      </font>
      </td>
      <td width="14%" valign="top">
        <font face="Verdana"><span style="font-size: 9pt">
        <textarea name="address" cols="20" rows="2"><?php echo $row['Address']; ?></textarea>
      	</span></font>
      </td>
</tr>
<tr>
      <td colspan="5" align="right">
        <input type="submit" value="Update" name="submit">
      </td>
    </tr>
</table>
</form>


			</td>
		</tr>
	
</div>
