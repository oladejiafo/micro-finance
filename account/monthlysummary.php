<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
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
?>
   <div align="center">
	<table border="0" width="800" id="table1" bgcolor="#FFFFFF">
		<tr>
			<td>
			<div align="center">
				<table border="0" width="800" id="table2">
					<tr>
						<td>

<TABLE width='795' border='1' cellpadding='1' cellspacing='1' align='center' id="table3">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="75%" id="AutoNumber2">
<?php

  echo"<h2><center>Monthly Summary Report</center></h2> ";

  $sql_d = "SELECT * FROM `pay`";
  $result_d = mysql_query($sql_d,$conn) or die('Could not list value; ' . mysql_error());
  $row = mysql_fetch_array($result_d);
  $mnth=$row['Month'];

  $result_01 = mysql_query ("SELECT left( `Grade Level` , 2 ) , count( `pay`.`Staff Number` ) AS cnt FROM `pay` GROUP BY left( `Grade Level` , 2 ) ORDER BY left( `Grade Level` , 2 ) DESC "); 

#  $result = mysql_query ("SELECT  sum( `payr`.`Amount`) AS amt,`payr`.`description`,`payr`.`amount` FROM `pay` left join `payr` on `pay`.`Staff Number`=`payr`.`Staff Number` where `pay`.`Bank`='$filter' group by `description`"); 

  echo "<font style='font-size: 8pt'><b>For the Month: " . $mnth . "</b></font>";
  echo "<TR><TH align='left' bgcolor='#C0C0C0' width='30%'> <font style='font-size: 9pt'> Staff Grade Level</font>&nbsp;</TH><TH align='right' bgcolor='#C0C0C0' width='20%'><font style='font-size: 9pt'>Number of Staff</font>&nbsp;</TH></TR>";
  while(list($gl,$cnt)=mysql_fetch_row($result_01)) 
   {
       $cnt=number_format($cnt);
      echo "<TR><TH align='left' width='30%'> <font style='font-size: 8pt'>Number of Staff on Grade Level $gl  </font>&nbsp;</TH><TH align='right' width='20%'><font style='font-size: 8pt'>$cnt</font>&nbsp;</TH></TR>";
   }
  $result_02 = mysql_query ("SELECT count( `pay`.`Staff Number` ) AS cnth FROM `pay`"); 
  $rowt = mysql_fetch_array($result_02);
  $cnth=$rowt['cnth'];
  $cnth=number_format($cnth);
   echo "<TR><TH>&nbsp;</TH><TH>&nbsp;</TH></TR>"; 
   echo "<TR><TH width='30%' bgcolor='#EAEAEA' align='left'><font style='font-size: 9pt'><b>Total Number of Staff</b></font></TH><TH width='20%' bgcolor='#EAEAEA' align='right'><font style='font-size: 9pt'><b>$cnth</b></font></TH></TR><p>";

?>
</table>
<br>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="75%" id="AutoNumber2">
<?php
#########
  $result_03 = mysql_query ("SELECT `Type`,`Description` ,sum( `payr`.`amount` ) AS amt FROM `payr` GROUP BY `Type`,`Description` ORDER BY `sortorder`"); 

  echo "<TR><TH align='left' bgcolor='#C0C0C0' width='30%'> <font style='font-size: 9pt'> Category</font>&nbsp;</TH><TH align='left' bgcolor='#C0C0C0' width='30%'> <font style='font-size: 9pt'> Pay Item Type</font>&nbsp;</TH><TH align='right' bgcolor='#C0C0C0' width='20%'><font style='font-size: 9pt'>Total Amount</font>&nbsp;</TH></TR>";
  while(list($type,$descr,$amt)=mysql_fetch_row($result_03)) 
   {
     if ($type=="B")
     {
       $type="BASIC SALARY";
     }
     else if ($type=="A")
     {
       $type="ALLOWANCES";
     }
     else if ($type=="D")
     {
       $type="DEDUCTIONS";
     }
     $amt=number_format($amt,2);
      echo "<TR><TH align='left' width='30%'> <font style='font-size: 8pt'></font>&nbsp;</TH><TR>";
      echo "<TR><TH align='left' width='30%'> <font style='font-size: 8pt'>$type  </font>&nbsp;</TH><TH align='left' width='30%'> <font style='font-size: 8pt'>Total $descr  </font>&nbsp;</TH><TH align='right' width='20%'><font style='font-size: 8pt'>$amt</font>&nbsp;</TH></TR>";
   }
  $result_04 = mysql_query ("SELECT sum( `payr`.`Amount` ) AS amth FROM `payr`"); 
  $rowt1 = mysql_fetch_array($result_04);
  $amth=$rowt1['amth'];
  $amth=number_format($amth,2);
   echo "<TR><TH>&nbsp;</TH><TH>&nbsp;</TH></TR>"; 
   echo "<TR><TH>&nbsp;</TH><TH width='30%' bgcolor='#EAEAEA' align='left'><font style='font-size: 9pt'><b>Total Salary</b></font></TH><TH width='20%' bgcolor='#EAEAEA' align='right'><font style='font-size: 9pt'><b>$amth</b></font></TH></TR><p>";

?>
</table>

</table>

<br>
<form>
<Table>
<tr>
<td>

<?php
 echo "<a target='blank' href='rptmonthlysummary.php'> Print Monthly Summary</a> &nbsp; ";
?>
</td>
</tr>
</Table
</form>
<?php
 require_once 'footr.php';
 require_once 'footer.php';
?>
			</td>
					</tr>
			
				</table>
			</div>
			</td>
		</tr>
	</table>
</div>
