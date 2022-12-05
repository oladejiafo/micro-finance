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
 require_once 'header.php';
 require_once 'style.php';

@$Tit=$_SESSION['Tit'];
@$tval=$_REQUEST['tval'];
 @$idd=$_REQUEST["idd"];
 @$ide=$_REQUEST["ide"];
?>
<div align="center">
<table border="0" width="100%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='center'>
 <td bgcolor="#00CC99"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Interbank</font></b>
 </td>
</tr>
<tr>
	<td>
	<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'custheader.php'; ?></font></i></b></legend>
<br>
<form action="interbank.php" method="post">
<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="70%" id="AutoNumber1">
    <tr>
      <td>
        Enter Date to Search:
      </td>
      <td>
        <input type="text" name="acctno" size="25">  
		<input type="submit" name="go" value="Search" />
      </td>
    </tr>
</table>
</form>	

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
<?php

$sql="SELECT * FROM `interbank` WHERE `r_Date`='" . date('Y-m-d') . "' and `ID`='$idd'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);

$sql2="SELECT * FROM `treasury` WHERE `Direction`='In' and `ID`='$ide'";
$result2 = mysql_query($sql2,$conn) or die('Could not look up user data; ' . mysql_error());
$row2 = mysql_fetch_array($result2); 

?>
<TABLE width='100%' border='1' cellpadding='1' cellspacing='8' align='center' bordercolor="#00CC99" id="table2" style="border:2px red dashed;">
<?php
  echo "<tr><td colspan=4 align='center'><b><font color='#FF0000' style='font-size: 10pt'> RECIEPT</font></b></td></tr>";
 @$idd=$_REQUEST["idd"];
 @$curnote=$_REQUEST["curnote"];
 @$curamt=$_REQUEST["curamt"];
?>
<tr><td colspan=4 align='center'>
<table width="100%">
<form action="submitinterbank.php" method="post">
<tr>
      <td width="25%">
       Narration:
      </td>
      <td width="25%">
       Amount:
      </td>
      <td width="25%">
       Recieved From:
      </td>
      <td width="25%">
       Branch:
      </td>
    </tr>
    <tr>
      <td>
        <input type="text" name="rnarration" size="15" value="<?php echo $row['r_Narration']; ?>">
      </td>
      <td>
        <input type="text" name="ramount" size="10" value="<?php echo $row['r_Amount']; ?>">
        <input type="hidden" name="idd" size="7" value="<?php echo @$idd; ?>">
      </td>
      <td>
        <input type="text" name="rofficer" size="15" value="<?php echo $row['r_Officer']; ?>">
      </td>
      <td>
        <input type="text" name="rbranch" size="15" value="<?php echo $row['r_Branch']; ?>">
      </td>
      <td>
<?php
if (!$idd){
?>
  <input type="submit" value="Add" name="submit" title="Click to Add this record">
<?php } 
 else { ?>
  <input type="submit" value="Edit" name="submit" title="Click to Amend this record">  
  <input type="submit" value="X" name="submit" title="Click to Delete this record">

<?php
} ?>
      </td>
    </tr>

</form>
</table>
</td></tr>
<tr><td colspan=4 align='center'>
<table width="100%" border=1>
 <?php
if(empty($idd))
{
 $idd="999";
}

  #echo "<TR><TH align='left'><b><u>Notes/Coins </b></u>&nbsp;</TH><TH align='right' colspan=2><b><u>Amount</b></u>&nbsp;</TH></TR>";

 if (($_SESSION['access_lvl'] == 5) or ($_SESSION['access_lvl'] == 4))
 {
   $querry = "SELECT `ID`,`r_Narration`,`r_Amount`,`r_Officer`,`r_Branch`,`Received By` FROM `interbank` WHERE `r_Date`='" . date('Y-m-d') . "' order by `ID` desc";
   $resultrp=mysql_query($querry);
 } else {
   $querry = "SELECT `ID`,`r_Narration`,`r_Amount`,`r_Officer`,`r_Branch`,`Received By` FROM `interbank` WHERE `Received By`='" . ucfirst($_SESSION['name']) . "' and `r_Date`='" . date('Y-m-d') . "' order by `ID` desc";
   $resultrp=mysql_query($querry);
 }
   $tamtr=0;
echo '
<tr>
      <td width="25%">
       Narration:
      </td>
      <td width="25%" align="right">
       Amount:
      </td>
      <td width="25%">
       Recieved By:
      </td>
      <td width="25%">
       Recieved From:
      </td>
    </tr>';
    while(list($idr,$rn,$ramt,$ro,$rb,$rby)=mysql_fetch_row($resultrp))
    { 
     $tamtr=$tamtr+$ramt;
     $amtrr=number_format($ramt,2);
     echo "<TR><TH width='25%' align='left'>$rn </TH><TH width='25%' align='right' colspan=1><a href = 'interbank.php?idd=$idr'>$amtrr &nbsp;</a></TH><TH width='25%' align='left'>$rby </TH><TH width='25%' align='left'>$ro , $rb branch</TH></TR>";
    }
     $tamtr=number_format($tamtr,2);
     echo "<TR><TH>TOTAL: </TH><TH align='right' colspan=1> $tamtr &nbsp;</TH><TH align='right' colspan=2>  &nbsp;</TH></TR>";	 
?>
</table>
</td></tr>

</table> 			 

</td><td width='50%' valign='top'>
<TABLE width='100%' border='1' cellpadding='1' cellspacing='8' align='center' bordercolor="#00CC99" id="table2" style="border:2px red dashed;">
<?php
  echo "<tr><td colspan=3 align='center'><b><font color='#FF0000' style='font-size: 10pt'> RE-PAYMENT</font></b></td></tr>";
?>
<tr><td colspan=3 align='center'>
<table width="100%">
<form action="submitinterbank.php" method="post">
<tr>
      <td width="25%">
       Narration:
      </td>
      <td width="25%">
       Amount:
      </td>
      <td width="25%">
       Paid By:
      </td>
      <td width="25%">
       Branch:
      </td>
    </tr>
    <tr>
      <td>
        <input type="text" name="pnarration" size="15" value="<?php echo $row['p_Narration']; ?>">
      </td>
      <td>
        <input type="text" name="pamount" size="10" value="<?php echo $row['p_Amount']; ?>">
        <input type="hidden" name="ide" size="7" value="<?php echo @$ide; ?>">
      </td>
      <td>
        <input type="text" name="pofficer" size="15" value="<?php echo $row['p_Officer']; ?>">
      </td>
      <td>
        <input type="text" name="pbranch" size="15" value="<?php echo $row['p_Brnch']; ?>">
      </td>
      <td>
<?php
if (!$ide){
?>
  <input type="submit" value="Add" name="submit" title="Click to Add this record">
<?php } 
 else { ?>
  <input type="submit" value="Edit" name="submit" title="Click to Amend this record">  
  <input type="submit" value="X" name="submit" title="Click to Delete this record">

<?php
} ?>
      </td>
    </tr>
<?php
#}
?>
</form>
</table>
</td></tr>
<tr><td colspan=4 align='center'>
<table width="100%" border=1>
 <?php
if(empty($ide))
{
 $ide="999";
}

#  echo "<TR><TH align='left'><b><u>Notes/Coins </b></u>&nbsp;</TH><TH align='right' colspan=2><b><u>Amount</b></u>&nbsp;</TH></TR>";

 if (($_SESSION['access_lvl'] == 5) or ($_SESSION['access_lvl'] == 4))
 {
   $querryp = "SELECT `ID`,`p_Narration`,`p_Amount`,`p_Officer`,`p_Branch`,`Paid By` FROM `interbank` WHERE `Received By`='" . ucfirst($_SESSION['name']) . "' and `p_Date`='" . date('Y-m-d') . "' order by `ID` desc";
   $resultpp=mysql_query($querryp);
 } else {
   $querryp = "SELECT `ID`,`p_Narration`,`p_Amount`,`p_Officer`,`p_Branch`,`Paid By` FROM `interbank` WHERE `p_Date`='" . date('Y-m-d') . "' order by `ID` desc";
   $resultpp=mysql_query($querryp);
 }
   $tamtp=0;
echo '
<tr>
      <td width="25%">
       Narration:
      </td>
      <td width="25%" align="right">
       Amount:
      </td>
      <td width="25%">
       Paid By:
      </td>
      <td width="25%">
       Paid To:
      </td>
    </tr>';
    while(list($idp,$pn,$pamt,$po,$pb,$pby)=mysql_fetch_row($resultpp))
    { 
     $tamtp=$tamtp+$pamt;
     $amtrp=number_format($pamt,2);
     echo "<TR><TH>$pn </TH><TH align='right' colspan=1><a href = 'interbank.php?ide=$idp'>$amtrp &nbsp;</a></TH><TH>$pby </TH><TH>$po, $pb branch</TH></TR>";
    }
     $tamtp=number_format($tamtp,2);
     echo "<TR><TH>TOTAL: </TH><TH align='right' colspan=1> $tamtp &nbsp;</TH><TH align='right' colspan=2>  &nbsp;</TH></TR>";	 
?>
</table>
</td></tr>
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
<tr><td align="right"><br>
<?php 
 require_once 'footr.php';
 require_once 'footer.php';
?></td></tr>
	</table>
</div>

