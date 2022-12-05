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

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

$sql="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Reg Number`='" . $_SESSION['Reg Number'] . "'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);

?>

 <div align="center">
	<table border="0" width="100%" id="table1" bgcolor="#e8e7e6">
		<tr align='center'>
 <td bgcolor="#87ceff"><b>
<font face="Verdana" color="#e8e7e6" style="font-size: 16pt">My Downlines</font></b>
 </td>
</tr>
		<tr>
			<td>
			<div align="center">
				<table border="0" width="801" id="table2">
					<tr>
						<td>
<form>
<fieldset style="padding: 2">

<div align="left">
<b><i><font size="2" face="Tahoma" color="#87ceff">My Details</font></i></b>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="750" id="AutoNumber1" height="70">
    <tr>
      <td width="17%" height="28">
        Registration Number
      </td>
      <td width="31%" height="28">
        <input type="text" name="regno" size="31" value="<?php echo $row['Reg Number']; ?>" style="border: 1px solid #dcdfdf;background-color: #dcdfdf">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        
      </td>
      <td width="34%" height="28">
        
      </td>
    </tr>
    <tr>
      <td width="17%" height="28">
        Surname
      </td>
      <td width="31%" height="28">
        <input type="text" name="surname" size="31" value="<?php echo $row['Surname']; ?>" style="border: 1px solid #dcdfdf;background-color: #dcdfdf">
      </td>
      <td width="1%" height="28"></td>
      <td width="17%" height="28">
        Firstname
      </td>
      <td width="34%" height="28">
        <input type="text" name="firstname" size="31" value="<?php echo $row['Firstname']; ?>" style="border: 1px solid #dcdfdf;background-color: #dcdfdf">
      </td>
    </tr>
  </table>

  </div>
</body>
 
</form>

<fieldset style="padding: 2">
<p><legend><b><i><font size="2" face="Tahoma" color="#87ceff">Dowlines</font></i></b></legend></p>
<TABLE width='750' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#000000">
<?php
    echo "<TR><TH colspan='4'><b><i>Level 0</i></b></TH></TR>";
    echo "<TR bgcolor='87ceff'><TH><b><u>Reg Number </b></u>&nbsp;</TH><TH><b><u>Surname </b></u>&nbsp;</TH><TH><b><u>Firstname </b></u>&nbsp;</TH><TH><b><u>Sponsor </b></u>&nbsp;</TH></TR>";

    $query="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $_SESSION['Reg Number'] . "' order by `Reg Number` Desc";
    $result=mysql_query($query);

    $qry1="SELECT count(`Reg Number`) as cnt FROM login WHERE `Sponsor`='" . $_SESSION['Reg Number'] . "'";
    $result1 = mysql_query($qry1,$conn) or die('Could not look up user data; ' . mysql_error());
    $row1 = mysql_fetch_array($result1);
    $cnt=$row1['cnt'];

    while(list($regno,$sname,$fname,$address,$Dreg,$sponsor)=mysql_fetch_row($result))
    {
     $reg=$regno;
     echo "<TR><TH>$regno &nbsp;</TH><TH>$sname &nbsp;</TH><TH>$fname &nbsp;</TH><TH>$sponsor &nbsp;</TH></TR>";
    }
    echo "<TR align='right'><TH colspan='4'>Total Level 0 Down lines = " . $cnt . "</TH></TR>";    

    echo "<TR><TH colspan='4'><b><i>Level 1</i></b></TH></TR>";
    echo "<TR bgcolor='87ceff'><TH><b><u>Reg Number </b></u>&nbsp;</TH><TH><b><u>Surname </b></u>&nbsp;</TH><TH><b><u>Firstname </b></u>&nbsp;</TH><TH><b><u>Sponsor </b></u>&nbsp;</TH></TR>";

    $query="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $_SESSION['Reg Number'] . "' order by `Reg Number` Desc";
    $result=mysql_query($query);
$sn=0;    
    while(list($regno,$sname,$fname,$address,$Dreg,$sponsor)=mysql_fetch_row($result))
    {
    $query1="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno . "'";
    $result1=mysql_query($query1);

    while(list($regno1,$sname1,$fname1,$address1,$Dreg1,$sponsor1)=mysql_fetch_row($result1))
    {

    $qry2="SELECT count(`Reg Number`) as cnt FROM login WHERE `Sponsor`='" . $regno . "'";
    $result2 = mysql_query($qry2,$conn) or die('Could not look up user data; ' . mysql_error());
    $row2 = mysql_fetch_array($result2);
    $cnt2=$row2['cnt'];
$sn=$sn+1;
     echo "<TR><TH>$regno1 &nbsp;</TH><TH>$sname1 &nbsp;</TH><TH>$fname1 &nbsp;</TH><TH>$sponsor1 &nbsp;</TH></TR>";
    }

    }

    echo "<TR align='right'><TH colspan='4'>Total Level 1 Down lines = " . $sn . "</TH></TR>";    
    
    echo "<TR><TH colspan='4'><b><i>Level 2</i></b></TH></TR>";
    echo "<TR bgcolor='87ceff'><TH><b><u>Reg Number </b></u>&nbsp;</TH><TH><b><u>Surname </b></u>&nbsp;</TH><TH><b><u>Firstname </b></u>&nbsp;</TH><TH><b><u>Sponsor </b></u>&nbsp;</TH></TR>";

    $query="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $_SESSION['Reg Number'] . "' order by `Reg Number` Desc";
    $result=mysql_query($query);
$sn2=0;  
    while(list($regno,$sname,$fname,$address,$Dreg,$sponsor)=mysql_fetch_row($result))
    {
    $query1="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno . "'";
    $result1=mysql_query($query1);
    
    while(list($regno1,$sname1,$fname1,$address1,$Dreg1,$sponsor1)=mysql_fetch_row($result1))
    {
    $query2="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno1 . "'";
    $result2=mysql_query($query2);

    $qry3="SELECT count(`Surname`) as cnt FROM login WHERE `Sponsor`='" . $regno1 . "'";
    $result3 = mysql_query($qry3,$conn) or die('Could not look up user data; ' . mysql_error());
    $row3 = mysql_fetch_array($result3);
    $cnt3=$row3['cnt'];
    
    while(list($regno2,$sname2,$fname2,$address2,$Dreg2,$sponsor2)=mysql_fetch_row($result2))
    {
     echo "<TR><TH>$regno2 &nbsp;</TH><TH>$sname2 &nbsp;</TH><TH>$fname2 &nbsp;</TH><TH>$sponsor2 &nbsp;</TH></TR>";
$sn2=$sn2+1;
    }
    }}
    echo "<TR align='right'><TH colspan='4'>Total Level 2 Down lines = " . $sn2 . "</TH></TR>";    

    echo "<TR><TH colspan='4'><b><i>Level 3</i></b></TH></TR>";
    echo "<TR bgcolor='87ceff'><TH><b><u>Reg Number </b></u>&nbsp;</TH><TH><b><u>Surname </b></u>&nbsp;</TH><TH><b><u>Firstname </b></u>&nbsp;</TH><TH><b><u>Sponsor </b></u>&nbsp;</TH></TR>";

    $query="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $_SESSION['Reg Number'] . "' order by `Reg Number` Desc";
    $result=mysql_query($query);
$sn3=0;
    while(list($regno,$sname,$fname,$address,$Dreg,$sponsor)=mysql_fetch_row($result))
    {
    $query1="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno . "'";
    $result1=mysql_query($query1);
    
    while(list($regno1,$sname1,$fname1,$address1,$Dreg1,$sponsor1)=mysql_fetch_row($result1))
    {
    $query2="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno1 . "'";
    $result2=mysql_query($query2);
    
    while(list($regno2,$sname2,$fname2,$address2,$Dreg2,$sponsor2)=mysql_fetch_row($result2))
    {
    $query2="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno2 . "'";
    $result2=mysql_query($query2);

    $qry4="SELECT count(`Surname`) as cnt FROM login WHERE `Sponsor`='" . $regno2 . "'";
    $result4 = mysql_query($qry4,$conn) or die('Could not look up user data; ' . mysql_error());
    $row4 = mysql_fetch_array($result4);
    $cnt4=$row4['cnt'];
    
    while(list($regno3,$sname3,$fname3,$address3,$Dreg3,$sponsor3)=mysql_fetch_row($result3))
    {
     echo "<TR><TH>$regno3 &nbsp;</TH><TH>$sname3 &nbsp;</TH><TH>$fname3 &nbsp;</TH><TH>$sponsor3 &nbsp;</TH></TR>";
$sn3=$sn3+1;
    }}
    }}
    echo "<TR align='right'><TH colspan='4'>Total Level 3 Down lines = " . $sn3 . "</TH></TR>";    

    echo "<TR><TH colspan='4'><b><i>Level 4</i></b></TH></TR>";
    echo "<TR bgcolor='87ceff'><TH><b><u>Reg Number </b></u>&nbsp;</TH><TH><b><u>Surname </b></u>&nbsp;</TH><TH><b><u>Firstname </b></u>&nbsp;</TH><TH><b><u>Sponsor </b></u>&nbsp;</TH></TR>";

    $query="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $_SESSION['Reg Number'] . "' order by `Reg Number` Desc";
    $result=mysql_query($query);
$sn4=0;
    while(list($regno,$sname,$fname,$address,$Dreg,$sponsor)=mysql_fetch_row($result))
    {
    $query1="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno . "'";
    $result1=mysql_query($query1);
    
    while(list($regno1,$sname1,$fname1,$address1,$Dreg1,$sponsor1)=mysql_fetch_row($result1))
    {
    $query2="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno1 . "'";
    $result2=mysql_query($query2);
    
    while(list($regno2,$sname2,$fname2,$address2,$Dreg2,$sponsor2)=mysql_fetch_row($result2))
    {
    $query2="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno2 . "'";
    $result2=mysql_query($query2);
    
    while(list($regno3,$sname3,$fname3,$address3,$Dreg3,$sponsor3)=mysql_fetch_row($result3))
    {
    $query2="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno3 . "'";
    $result2=mysql_query($query2);

    $qry5="SELECT count(`Surname`) as cnt FROM login WHERE `Sponsor`='" . $regno3 . "'";
    $result5 = mysql_query($qry5,$conn) or die('Could not look up user data; ' . mysql_error());
    $row5 = mysql_fetch_array($result5);
    $cnt5=$row5['cnt'];

    while(list($regno4,$sname4,$fname4,$address4,$Dreg4,$sponsor4)=mysql_fetch_row($result4))
    {
     echo "<TR><TH>$regno4 &nbsp;</TH><TH>$sname4 &nbsp;</TH><TH>$fname4 &nbsp;</TH><TH>$sponsor4 &nbsp;</TH></TR>";
$sn4=$sn4+1;
    }}}
    }}
    echo "<TR align='right'><TH colspan='4'>Total Level 4 Down lines = " . $sn4 . "</TH></TR>";    

    echo "<TR><TH colspan='4'><b><i>Level 5</i></b></TH></TR>";
    echo "<TR bgcolor='87ceff'><TH><b><u>Reg Number </b></u>&nbsp;</TH><TH><b><u>Surname </b></u>&nbsp;</TH><TH><b><u>Firstname </b></u>&nbsp;</TH><TH><b><u>Sponsor </b></u>&nbsp;</TH></TR>";

    $query="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $_SESSION['Reg Number'] . "' order by `Reg Number` Desc";
    $result=mysql_query($query);
$sn5=0;
    while(list($regno,$sname,$fname,$address,$Dreg,$sponsor)=mysql_fetch_row($result))
    {
    $query1="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno . "'";
    $result1=mysql_query($query1);
    
    while(list($regno1,$sname1,$fname1,$address1,$Dreg1,$sponsor1)=mysql_fetch_row($result1))
    {
    $query2="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno1 . "'";
    $result2=mysql_query($query2);
    
    while(list($regno2,$sname2,$fname2,$address2,$Dreg2,$sponsor2)=mysql_fetch_row($result2))
    {
    $query3="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno2 . "'";
    $result3=mysql_query($query3);
    
    while(list($regno3,$sname3,$fname3,$address3,$Dreg3,$sponsor3)=mysql_fetch_row($result3))
    {
    $query4="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno3 . "'";
    $result4=mysql_query($query4);

    while(list($regno4,$sname4,$fname4,$address4,$Dreg4,$sponsor4)=mysql_fetch_row($result4))
    {
    $query5="SELECT `Reg Number`,`Surname`,`Firstname`,`Address`,`City`,`Sponsor` FROM login WHERE `Sponsor`='" . $regno4 . "'";
    $result5=mysql_query($query5);

    $qry6="SELECT count(`Surname`) as cnt FROM login WHERE `Sponsor`='" . $regno4 . "'";
    $result6 = mysql_query($qry6,$conn) or die('Could not look up user data; ' . mysql_error());
    $row6 = mysql_fetch_array($result6);
    $cnt6=$row6['cnt'];

    while(list($regno5,$sname5,$fname5,$address5,$Dreg5,$sponsor5)=mysql_fetch_row($result5))
    {
     echo "<TR><TH>$regno5 &nbsp;</TH><TH>$sname5 &nbsp;</TH><TH>$fname5 &nbsp;</TH><TH>$sponsor5 &nbsp;</TH></TR>";
$sn5=$sn5+1;
    }}}
    }}}
    echo "<TR align='right'><TH colspan='4'>Total Level 5 Down lines = " . $sn5 . "</TH></TR>";    
 ?>
</Table>

 </fieldset>
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
