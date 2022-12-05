<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
}

 require_once 'conn.php';


$sqr="SELECT * FROM `company info`";
$reslt = mysql_query($sqr,$conn) or die('Could not look up user data; ' . mysql_error());
$rw = mysql_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];

 @$idd=$_REQUEST["idd"];
 @$ide=$_REQUEST["ide"];
?>
<table width='450'>
<tr><td rowspan='5' valign='top'>
<img src='images/logo.jpg' width='120' height='140'></td></tr>
<tr><td width='260'><font style='font-size: 14pt'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td colspan=1><h2><left>Daily Treasury Report</left></h2></td></tr>
</table>

<div align=left">
<table border="0" width="80%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='center'>
 <td bgcolor="#c0c0c0"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Treasury Details</font></b>
 </td>
</tr>
<tr>
	<td>
	
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#00CC99" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5" bgcolor="#00CC99"> </td>
</tr>
  </table>
<div align="left">
</td></tr>
<tr><td>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
<tr><td width="50%" valign="top">

<TABLE width='100%' border='1' cellpadding='1' cellspacing='8' align='center' bordercolor="#00CC99" id="table2" style="border:2px red dashed;">
<?php
  echo "<tr><td colspan=3 align='center'><b><font color='#FF0000' style='font-size: 10pt'> TREASURY OUT</font></b></td></tr>";
 @$idd=$_REQUEST["idd"];
 @$curnote=$_REQUEST["curnote"];
 @$curamt=$_REQUEST["curamt"];
?>
 <?php
if(empty($idd))
{
 $idd="999";
}

  echo "<TR><TH align='center'><b><u>Notes/Coins </b></u>&nbsp;</TH><TH align='right' colspan=2><b><u>Amount</b></u>&nbsp;</TH></TR>";

   $querry = "SELECT `ID`,`Note`,`Amount` FROM `treasury` WHERE `Date`='" . date('Y-m-d') . "' and `Direction`='Out' and (`Given By`='" . ucfirst($_SESSION['name']) . "' or `Given To`='" . ucfirst($_SESSION['name']) . "')  order by `Note` desc";
   $resultrp=mysql_query($querry);

   $tamtr=0;
    while(list($idr,$note,$amtr)=mysql_fetch_row($resultrp))
    { 
     $tamtr=$tamtr+$amtr;
     $amtrr=number_format($amtr,2);
     echo "<TR><TH>$note </TH><TH align='right' colspan=2>$amtrr &nbsp;</TH></TR>";
    }
     $tamtr=number_format($tamtr,2);
     echo "<TR><TH>TOTAL: </TH><TH align='right' colspan=2> $tamtr &nbsp;</TH></TR>";	 
?>
</table> 			 

</td><td width='50%' valign='top'>
<TABLE width='100%' border='1' cellpadding='1' cellspacing='8' align='center' bordercolor="#00CC99" id="table2" style="border:2px red dashed;">
<?php
  echo "<tr><td colspan=3 align='center'><b><font color='#FF0000' style='font-size: 10pt'> TREASURY IN</font></b></td></tr>";
?>
 <?php
if(empty($ide))
{
 $ide="999";
}

  echo "<TR><TH align='center'><b><u>Notes/Coins </b></u>&nbsp;</TH><TH align='right' colspan=2><b><u>Amount</b></u>&nbsp;</TH></TR>";

   $querry2 = "SELECT `ID`,`Note`,`Amount` FROM `treasury` WHERE `Date`='" . date('Y-m-d') . "' and `Direction`='In' and (`Given By`='" . ucfirst($_SESSION['name']) . "' or `Given To`='" . ucfirst($_SESSION['name']) . "') order by `Note` desc";
   $resultrp2=mysql_query($querry2);

   $tamtr2=0;
    while(list($idr2,$note2,$amtr2)=mysql_fetch_row($resultrp2))
    { 
     $tamtr2=$tamtr2+$amtr2;
     $amtrr2=number_format($amtr2,2);
     echo "<TR><TH>$note2 </TH><TH align='right' colspan=2>$amtrr2 &nbsp;</TH></TR>";
    }
     $tamtr2=number_format($tamtr2,2);
     echo "<TR><TH>TOTAL: </TH><TH align='right' colspan=2> $tamtr2 &nbsp;</TH></TR>";	 
?>
</table> 			 
</td></tr>
  </table>
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#00CC99" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5" bgcolor="#00CC99"> </td>
</tr>
  </table>
			</td>
		</tr>

</fieldset>

	</table>
</div>

