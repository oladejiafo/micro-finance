<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 1))
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
?>
<div align="center">
<table border="0" width="100%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='center'>
 <td bgcolor="#00CC99"><b>
  <font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Transactions</font></b>
 </td>
</tr>
<tr>
	<td>
	<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'custheader.php'; ?>
</font></i></b></legend>
<br>
<form action="transactions.php" method="post">	
<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="50%" id="AutoNumber1">
    <tr>
      <td>
         <select name="trans" size="1">
          <?php  
           echo '<option selected>Deposit</option>';
           echo '<option>Withdrawal</option>';
          ?> 
         </select>
      </td>
      <td>
        Enter Account Number:
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
<form action="submittrans.php" method="post">
<?php
 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];

$sql="SELECT * FROM `transactions` WHERE `ID`='$idd'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);

$sql2="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
$result2 = mysql_query($sql2,$conn) or die('Could not look up user data; ' . mysql_error());
$row2 = mysql_fetch_array($result2); 

?>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1" height="70">
    <tr>
      <td width="12%" rowspan="6" valign="top"> 
	 <?php  if (file_exists("images/pics/" . $row2['ID'] . ".jpg")==1)
            { ?>
              <img border="1" src="images/pics/<?php echo $row2['ID']; ?>.jpg" width="100" height="120">
	 <?php  } else { ?>
              <img border="1" src="images/pics/pix.jpg" width="100" height="120">	 
	 <?php  } ?>			 
	  </td>
      <td width="17%" height="28">
        First Name:
      </td>
      <td width="25%" height="28">
       <input type="hidden" name="fname" size="25" value="<?php echo @$row2['First Name']; ?>"><?php echo @$row2['First Name']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Surname:
      </td>
      <td width="34%" height="28">
          <input type="hidden" size="25" name="sname" value="<?php echo @$row2['Surname']; ?>"><?php echo @$row2['Surname']; ?>
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Account Number:
      </td>
      <td width="25%" height="28">
        <input type="hidden" name="id" size="31" value="<?php echo @$row['ID']; ?>">
        <input type="hidden" name="trans" size="31" value="<?php echo @$trans; ?>">		
        <input type="hidden" name="acctno" size="25" value="<?php echo @$row2['Account Number']; ?>"><?php echo @$row2['Account Number']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Account Type:
      </td>
      <td width="34%" height="28">
        <input type="hidden" name="type" size="25" value="<?php echo $row2['Account Type']; ?>"><?php echo $row2['Account Type']; ?>
        <?php 
          $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultb = mysql_query($sqlb,$conn) or die('Could not look up user data; ' . mysql_error());
          $rowb = mysql_fetch_array($resultb); 
        ?>
         <input type="hidden" name="balance" size="25" value="<?php echo $rowb['Balance']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Gender:
      </td>
      <td width="25%" height="28">
        <input type="hidden" name="gender" size="25" value="<?php echo $row2['Gender']; ?>"><?php echo $row2['Gender']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Account Status:
      </td>
      <td width="34%" height="28">
	<?php echo $row2['Status']; ?>
        <input type="hidden" name="status" size="25" value="<?php echo $row2['Status']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Account Officer:
      </td>
      <td width="25%" height="28">
        <input type="hidden" name="acctofficer" size="25" value="<?php echo $row2['Account Officer']; ?>"><?php echo $row2['Account Officer']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Operating Staff:
      </td>
      <td width="34%" height="28">
	<?php echo strtoupper($_SESSION['name']); ?>
        <input type="hidden" name="officer" size="25" value="<?php echo strtoupper($_SESSION['name']); ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
       Transaction Date:
      </td>
      <td width="34%" height="28">
        <input id="inputField" type="text" size="25" name="date" value="<?php echo date('d-m-Y'); ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Transaction Type:
      </td>
      <td width="34%" height="28">
         <select name="transtype" size="1" value="<?php echo @$trans; ?>">
           <option selected><?php echo @$trans; ?></option>
           <option>Deposit</option>
           <option>Withdrawal</option>
         </select>
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Amount:
      </td>
      <td width="25%" height="28">
	  <?php if ($trans=="Deposit") { ?>
        <input type="text" name="amount" size="25" value="<?php echo @$row['Deposit']; ?>"> 
	  <?php } else { ?>
        <input type="text" name="amount" size="25" value="<?php echo @$row['Withdrawal']; ?>"> 
	  <?php } ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Remark:
      </td>
      <td width="34%" height="28">
        <textarea name="remark" rows="2" cols="21" ><?php echo $row['Remark']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td width="10%" height="28">
        
      </td>
      <td width="17%" height="28">
        Depositor/Withdrawer:
      </td>
      <td width="25%" height="28">
        <input type="text" name="transactor" size="25" value="<?php echo $row['Transactor']; ?>">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Person Contact:
      </td>
      <td width="34%" height="28">
        <input type="text" name="tcontact" size="25" value="<?php echo $row['Transactor Contact']; ?>">
      </td>
    </tr>
    <tr align='center'>
      <td colspan="5" bgcolor="#008000"> </td>
    </tr>
  </table>
    <p>
<?php
if (!$idd){
?>
  <input type="submit" value="Save" name="submit"> &nbsp;
<?php } 
 else { ?>
  <input type="submit" value="Modify" name="submit"> &nbsp;  
  <input type="submit" value="Delete" name="submit"> &nbsp;
  <input type="submit" value="Cancel" name="submit"> &nbsp;
<?php
} ?>
  </p>
  </div>
</body>
</form>
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#00CC99" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5" bgcolor="#00CC99"> </td>
</tr>
  </table>
			</td>
		</tr>
<tr><td align="right">
<TABLE width='98%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#00CC99" id="table2">
 <?php
 $tval=$_GET['tval'];
 $limit      = 3;
 $page=$_GET['page'];
 
    $query_count = "SELECT * FROM `transactions` WHERE `Account Number`='" . $acctno . "'";
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

  echo "<tr><td colspan=10 align='center'><b><font color='#FF0000' style='font-size: 10pt'> RECENT TRANSACTIONS</font></b></td></tr>";
  echo "<TR><TH><b><u>S/No </b></u>&nbsp;</TH><TH align='right'><b><u>Transaction Date </b></u>&nbsp;</TH><TH align='left'><b><u>Account Number</b></u>&nbsp;</TH><TH align='left'><b><u>Customer Name </b></u>&nbsp;</TH><TH align='right'><b><u>Deposit Amount </b></u>&nbsp;</TH><TH align='right'><b><u>Withdrawal Amount </b></u>&nbsp;</TH></TR>";

   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal`,`Transaction Type` FROM `transactions` WHERE `Account Number`='" . $acctno . "' order by `ID` desc LIMIT 0, $limit";
   $resultp=mysql_query($query);
   
$i=0;
    while(list($idd,$date,$acctno,$depamt,$wthamt,$transt)=mysql_fetch_row($resultp))
    { 
      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
      $resultw = mysql_query($sqlw,$conn) or die('Could not look up user data; ' . mysql_error());
      $roww = mysql_fetch_array($resultw); 

      $fn=$roww['First Name'];  
      $sn=$roww['Surname'];
      $name=$fn . ' ' . $sn;

     $deppamt=number_format($depamt,2);
     $wthhamt=number_format($wthamt,2);
     $i=$i+1;

     echo "<TR><TH>$i &nbsp;</TH><TH>$date </TH><TH align='left'><a href = 'transactions.php?idd=$idd&acctno=$acctno&trans=$transt'>$acctno</a></TH><TH align='left'> $name &nbsp;</TH><TH align='right'>$deppamt &nbsp;</TH><TH align='right'> $wthhamt &nbsp;</TH></TR>";	 
    }
?>
</table>
</fieldset>
</td></tr>
<tr><td align="right"><br>
<?php 
 require_once 'footr.php';
 require_once 'footer.php';
?></td></tr>
	</table>
</div>

