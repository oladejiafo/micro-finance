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
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Treasury Details</font></b>
 </td>
</tr>
<tr>
	<td>
	<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'custheader.php'; ?>
</font></i></b></legend>
<br>
<form action="treasury.php" method="post">
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

$sql="SELECT * FROM `treasury` WHERE `Direction`='Out' and `ID`='$idd'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);

$sql2="SELECT * FROM `treasury` WHERE `Direction`='In' and `ID`='$ide'";
$result2 = mysql_query($sql2,$conn) or die('Could not look up user data; ' . mysql_error());
$row2 = mysql_fetch_array($result2); 

?>
<TABLE width='100%' border='1' cellpadding='1' cellspacing='8' align='center' bordercolor="#00CC99" id="table2" style="border:2px red dashed;">
<?php
  echo "<tr><td colspan=3 align='center'><b><font color='#FF0000' style='font-size: 10pt'> TREASURY OUT</font></b></td></tr>";
 @$idd=$_REQUEST["idd"];
 @$curnote=$_REQUEST["curnote"];
 @$curamt=$_REQUEST["curamt"];
?>
<tr><td colspan=3 align='center'>
<table width="100%">
<form action="submittreasury.php" method="post">
<tr>
      <td width="20%">
       Pick Currency:
      </td>
      <td width="20%">
       Enter Amount:
      </td>
      <td width="20%">
       Given to:
      </td>
      <td width="20%">
       Given By:
      </td>
      <td width="20%">

      </td>
    </tr>
<?php
 if (($_SESSION['access_lvl'] == 5) or ($_SESSION['access_lvl'] == 4))
 {
?>
    <tr>
      <td>
         <select name="curnote" size="1">
           <?php
           echo "<option selected>" . $row['Note'] . "</option>";
           $sql = "SELECT * FROM `currency`";
           $result_cur = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_cur)) 
           {
             echo "<option>" . $rows['Currency'] . "</option>";
           }
          ?> 
         </select>
      </td>
      <td>
        <input type="text" name="curamt" size="10" value="<?php echo $row['Amount']; ?>">
        <input type="hidden" name="idd" size="7" value="<?php echo @$idd; ?>">
      </td>
      <td>
        <select name="cashier" size="1">
           <?php
           echo "<option selected>" . $row['Given To'] . "</option>";
           $sql = "SELECT * FROM `login` where `access_lvl` in (1,2)";
           $result_cur = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_cur)) 
           {
             echo "<option>" . $rows['username'] . "</option>";
           }
          ?> 
         </select>
      </td>
      <td>
        <input type="text" name="giver" size="15" value="<?php echo ucfirst($_SESSION['name']); ?>">
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
<?php
}
?>
</form>
</table>
</td></tr>
 <?php
if(empty($idd))
{
 $idd="999";
}

  echo "<TR><TH align='left'><b><u>Notes/Coins </b></u>&nbsp;</TH><TH align='right' colspan=2><b><u>Amount</b></u>&nbsp;</TH></TR>";

 if (($_SESSION['access_lvl'] == 5) or ($_SESSION['access_lvl'] == 4))
 {
   $querry = "SELECT `ID`,`Note`,`Amount` FROM `treasury` WHERE `Given By`='" . ucfirst($_SESSION['name']) . "' and `Date`='" . date('Y-m-d') . "' and `Direction`='Out' order by `Note` desc";
   $resultrp=mysql_query($querry);
 } else {
   $querry = "SELECT `ID`,`Note`,`Amount` FROM `treasury` WHERE `Given By`='Olazz' and `Date`='" . date('Y-m-d') . "' and `Direction`='Out' order by `Note` desc";
   $resultrp=mysql_query($querry);
 }
   $tamtr=0;
    while(list($idr,$note,$amtr)=mysql_fetch_row($resultrp))
    { 
     $tamtr=$tamtr+$amtr;
     $amtrr=number_format($amtr,2);
     echo "<TR><TH>$note </TH><TH align='right' colspan=2><a href = 'treasury.php?idd=$idr'>$amtrr &nbsp;</a></TH></TR>";
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
<tr><td colspan=3 align='center'>
<table width="100%">
<form action="submittreasury.php" method="post">
<tr>
      <td width="20%">
       Pick Currency:
      </td>
      <td width="20%">
       Enter Amount:
      </td>
      <td width="20%">
       Given to:
      </td>
      <td width="20%">
       Given By:
      </td>
      <td width="20%">

      </td>
    </tr>
<?php
 if (($_SESSION['access_lvl'] == 5) or ($_SESSION['access_lvl'] == 1))
 {
?>
    <tr>
      <td>
         <select name="curnote2" size="1">
           <?php
           echo "<option selected>" . $row2['Note'] . "</option>";
           $sql = "SELECT * FROM `currency`";
           $result_cur = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_cur)) 
           {
             echo "<option>" . $rows['Currency'] . "</option>";
           }
          ?> 
         </select>
      </td>
      <td>
        <input type="text" name="curamt2" size="10" value="<?php echo $row2['Amount']; ?>">
        <input type="hidden" name="ide" size="7" value="<?php echo @$ide; ?>">
      </td>
      <td>
        <select name="cashier2" size="1">
           <?php
           echo "<option selected>" . $row2['Given To'] . "</option>";
           $sql = "SELECT * FROM `login` where `access_lvl` in (1,2)";
           $result_cur = mysql_query($sql,$conn) or die('Could not list value; ' . mysql_error());
           while ($rows = mysql_fetch_array($result_cur)) 
           {
             echo "<option>" . $rows['username'] . "</option>";
           }
          ?> 
         </select>
      </td>
      <td>
        <input type="text" name="giver2" size="15" value="<?php echo ucfirst($_SESSION['name']); ?>">
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
}
?>
</form>
</table>
</td></tr>
 <?php
if(empty($ide))
{
 $ide="999";
}

  echo "<TR><TH align='left'><b><u>Notes/Coins </b></u>&nbsp;</TH><TH align='right' colspan=2><b><u>Amount</b></u>&nbsp;</TH></TR>";

 if (($_SESSION['access_lvl'] == 5) or ($_SESSION['access_lvl'] == 1))
 {
   $querry2 = "SELECT `ID`,`Note`,`Amount` FROM `treasury` WHERE `Given By`='" . ucfirst($_SESSION['name']) . "' and `Date`='" . date('Y-m-d') . "' and `Direction`='In' order by `Note` desc";
   $resultrp2=mysql_query($querry2);
 } else {
   $querry2 = "SELECT `ID`,`Note`,`Amount` FROM `treasury` WHERE `Given By`='olaxx' and `Date`='" . date('Y-m-d') . "' and `Direction`='In' order by `Note` desc";
   $resultrp2=mysql_query($querry2);
 }

   $tamtr2=0;
    while(list($idr2,$note2,$amtr2)=mysql_fetch_row($resultrp2))
    { 
     $tamtr2=$tamtr2+$amtr2;
     $amtrr2=number_format($amtr2,2);
     echo "<TR><TH>$note2 </TH><TH align='right' colspan=2><a href = 'treasury.php?ide=$idr2'>$amtrr2 &nbsp;</a></TH></TR>";
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
<tr><td>
<TABLE width='30%' border='1' cellpadding='1' cellspacing='0' align='center' bordercolor="#005B00" id="table6">
  <?php
     echo "<TR> <TH><a href ='rpttreasury.php' target='blank'> Daily Treasury Report </a>&nbsp;</TH></TR>"; 
  ?>
</TABLE>
</td></tr>
<tr><td align="right"><br>
<?php 
 require_once 'footr.php';
 require_once 'footer.php';
?></td></tr>
	</table>
</div>

