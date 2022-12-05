<?php
session_start();

if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2))
{
 if ($_SESSION['access_lvl'] != 1){

$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=logins.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
#exit();
}
}
 require_once 'header.php';
 require_once 'style.php';
?>

 <div align="center">
	<table border="0" width="601" id="table1" bgcolor="#DFDFA2">
		<tr align='center'>
 <td bgcolor="#87ceff"><b>
<font face="Verdana" color="#dfdfa2" style="font-size: 16pt">Our Other Activities</font></b>
 </td>
</tr>
<tr>
  <td>
   <div align="center">
    <table border="0" height="400" width="601" id="table2">
      <tr>
	 <td align="center">
           <font face="Verdana" color="#000000" style="font-size: 22pt">COMING SOON! </font>
         </td>
      </tr>
    </table>
   </div>
  </td>
</tr>
	</table>
</div>


<?php 
 require_once 'footr.php';
 require_once 'footer.php';
?>