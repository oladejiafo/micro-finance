<?php
session_start();

 require_once 'conn.php';

$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

 $filename = "acct_stm_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>
<table width='450'>
<tr><td width='260'><font style='font-size: 15pt; color: red'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td  width='400' colspan=2><h2><left>STATEMENT OF ACCOUNT</left></h2></td></tr>
</table>

<div align="left">
<table border="0" width="85%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='left'>
 <td>
     <h4><left>FROM: <font color='red'><?php echo date('d F, Y',strtotime($filter)); ?></font> TO <font color='red'><?php echo date('d F, Y',strtotime($filter2)); ?></font> </left></h4>
 </td>
</tr>
<tr>
	<td>
<br>

<?php
$sql="SELECT * FROM `transactions` WHERE `ID`='$idd'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);

$sql2="SELECT * FROM `customer` WHERE `Account Number`='$acctno'";
$result2 = mysqli_query($conn,$sql2) or die('Could not look up user data; ' . mysqli_error());
$row2 = mysqli_fetch_array($result2); 

?>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="99%" id="AutoNumber1" height="70">
   
    <tr>
      <td width="22%" height="28">
       &nbsp; <b>First Name:</b>
      </td>
      <td width="25%" height="28">
       <input type="hidden" name="fname" size="25" value="<?php echo @$row2['First Name']; ?>"><?php echo @$row2['First Name']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="22%" height="28">
        <b>Surname:</b>
      </td>
      <td width="30%" height="28">
          <input type="hidden" size="25" name="sname" value="<?php echo @$row2['Surname']; ?>"><?php echo @$row2['Surname']; ?>
      </td>
    </tr>
    <tr>
      <td width="24%" height="28">
        &nbsp; <b>Account Number:</b>
      </td>
      <td width="25%" height="28">
        <input type="hidden" name="id" size="31" value="<?php echo @$row['ID']; ?>">
        <input type="hidden" name="trans" size="31" value="<?php echo @$trans; ?>">		
        <input type="hidden" name="acctno" size="25" value="<?php echo @$row2['Account Number']; ?>"><?php echo @$row2['Account Number']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        <b>Account Type:</b>
      </td>
      <td width="34%" height="28">
        <input type="hidden" name="type" size="25" value="<?php echo $row2['Account Type']; ?>"><?php echo $row2['Account Type']; ?>
        <?php 
          $sqlb="SELECT * FROM `transactions` WHERE `Account Number`='$acctno' order by `ID` desc";
          $resultb = mysqli_query($conn,$sqlb) or die('Could not look up user data; ' . mysqli_error());
          $rowb = mysqli_fetch_array($resultb); 
        ?>
         <input type="hidden" name="balance" size="25" value="<?php echo $rowb['Balance']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
       &nbsp; <b>Gender:</b>
      </td>
      <td width="25%" height="28">
        <input type="hidden" name="gender" size="25" value="<?php echo $row2['Gender']; ?>"><?php echo $row2['Gender']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        <b>Account Status:</b>
      </td>
      <td width="34%" height="28">
	<?php echo $row2['Status']; ?>
        <input type="hidden" name="status" size="25" value="<?php echo $row2['Status']; ?>">
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
       &nbsp; <b>Account Officer:</b>
      </td>
      <td width="25%" height="28">
        <input type="hidden" name="acctofficer" size="25" value="<?php echo $row2['Account Officer']; ?>"><?php echo $row2['Account Officer']; ?>
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        <b>Operating Staff:</b>
      </td>
      <td width="34%" height="28">
	<?php echo strtoupper($_SESSION['name']); ?>
        <input type="hidden" name="officer" size="25" value="<?php echo strtoupper($_SESSION['name']); ?>">
      </td>
    </tr>
  </table>
  </div>
</body>
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" id="AutoNumber1" height="1">
<tr align='center'>
 <td colspan="5"> </td>
</tr>
  </table>
			</td>
		</tr>
<tr><td align="right">
<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#ccCCcc" id="table2">
 <?php
 
   $query_count = "SELECT * FROM `transactions` WHERE `Account Number`='" . $acctno . "'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

  echo "<tr><td colspan=10 align='center'><b><font color='#000000' style='font-size: 10pt'> ACCOUNT TRANSACTIONS</font></b></td></tr>";
  echo "<TR><TH><b><u>S/No </b></u>&nbsp;</TH><TH align='right'><b><u>Transaction Date </b></u>&nbsp;</TH><TH align='right'><b><u>Deposit Amount </b></u>&nbsp;</TH><TH align='right'><b><u>Withdrawal Amount </b></u>&nbsp;</TH><TH align='center'><b><u>Details </b></u>&nbsp;</TH></TR>";

   $query = "SELECT `ID`,`Date`,`Account Number`,`Deposit`,`Withdrawal`,`Transaction Type`,`Transactor` FROM `transactions` WHERE `Account Number`='" . $acctno . "' and (`Date` between '" . $filter . "' and '" . $filter2 . "') order by `ID` desc";
   $resultp=mysqli_query($conn,$query);
   
$i=0;
    while(list($idd,$date,$acctn,$depamt,$wthamt,$transt,$tr)=mysqli_fetch_row($resultp))
    { 
      $sqlw="SELECT * FROM `customer` WHERE `Account Number`='$acctn'";
      $resultw = mysqli_query($conn,$sqlw) or die('Could not look up user data; ' . mysqli_error());
      $roww = mysqli_fetch_array($resultw); 

      $fn=$roww['First Name'];  
      $sn=$roww['Surname'];
      $name=$fn . ' ' . $sn;

     $deppamt=number_format($depamt,2);
     $wthhamt=number_format($wthamt,2);
     $i=$i+1;

     echo "<TR><TH>$i &nbsp;</TH><TH>$date </TH><TH align='right'>$deppamt &nbsp;</TH><TH align='right'> $wthhamt &nbsp;</TH><TH align='center'> $transt &nbsp;";
     if (!empty($tr)) { echo "by " . $tr; }
     echo "</TH></TR>";	 
    }
    $queryS = "SELECT `Account Number`,sum(`Deposit`) as sdep,sum(`Withdrawal`) as swit FROM `transactions` WHERE `Account Number`='" . $acctno . "' and (`Date` between '" . $filter . "' and '" . $filter2 . "') group by `Account Number`";
    $resultpS=mysqli_query($conn,$queryS);
    $rowS = mysqli_fetch_array($resultpS); 

    $sdp=$rowS['sdep'];  
    $swt=$rowS['swit'];  
    echo "<TR><TH> &nbsp;</TH><TH> </TH><TH align='right'>$sdp &nbsp;</TH><TH align='right'> $swt &nbsp;</TH><TH align='center'>  &nbsp;</TH></TR>";	 
?>
</table>
</fieldset>
</td></tr>
	</table>

</div>

