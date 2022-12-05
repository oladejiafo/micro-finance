<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 4)
 {
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

@$ID=$_REQUEST['ID'];
@$tval=$_REQUEST['tval'];

 $id = $_REQUEST["id"];
 $bank = $_REQUEST["bank"];
 $confirm = $_REQUEST["confirm"];
 $amount = $_REQUEST["amount"];
 $dat = $_REQUEST["dat"];
 $page = $_REQUEST["page"];
 $filter = $_REQUEST["filter"];

$sql="SELECT `ID`,`Bank`,`DoB_Day`,`DoB_Month`,`DoB_Year`,`Amount`,`Command`,`Location`,`Amount Remitted` FROM `Revenue` WHERE `ID`='$id'";
$result = mysql_query($sql,$conn) or die('Could not look up user data; ' . mysql_error());
$row = mysql_fetch_array($result);

?>
<div align="center">
	<table border="0" width="100%" cellspacing="1" bgcolor="#e8e7e6" id="table1">
		<tr align='center'>
</tr>
		<tr align="center">
			<td>
<?php
$ttt=1;
echo "<form method=\"post\" action=\"banksort.php\">\n";
 $id = $_REQUEST["id"];
 $bank = $_REQUEST["bank"];
 $dat = $_REQUEST["dat"];

echo "<h2>Bank Remitance to CBN</h2>\n";

echo "<font color='#FF0000' style='font-size: 12pt'>" . $tval . "</font>";
echo "<p>";
?>
<div align="left">
<Fieldset>
<table align="left">
<tr>
 <td width="5%">
  Date: 
 </td>
 <td width="10%">
  <select size="1" name="dob_day" value="<?php echo @$row['DoB_Day']; ?>">
   <?php  
     echo '<option selected>' . @$row['DoB_Day'] . '</option>';
     for($day=1; $day<=31; $day++)
     {
     echo '<option>' . $day . '</option>';
     }
   ?> 
  </select>
  <select size="1" name="dob_month" value="<?php echo @$row['DoB_Month']; ?>">
   <?php  
     echo '<option selected>' . @$row['DoB_Month'] . '</option>';
     #if $day=1 to 31
     echo '<option>01</option>';
     echo '<option>02</option>';
     echo '<option>03</option>';
     echo '<option>04</option>';
     echo '<option>05</option>';
     echo '<option>06</option>';
     echo '<option>07</option>';
     echo '<option>08</option>';
     echo '<option>09</option>';
     echo '<option>10</option>';
     echo '<option>11</option>';
     echo '<option>12</option>';
   ?> 
  </select>
  <select size="1" name="dob_year" value="<?php echo @$row['DoB_Year']; ?>">
   <?php  
     echo '<option selected>' . @$row['DoB_Year'] . '</option>';
     for($year=2018; $year>=1901; $year--)
     {
     echo '<option>' . $year . '</option>';
     }
   ?> 
  </select>
 </td>
 </td> 
 <td width="5%">
  Amount to Remit: 
 </td>
 <td width="30%">
  <input type="text" name="amount" value="<?php echo @$row['Amount']; ?>" >
  <input type="hidden" name="id" value="<?php echo @$row['ID']; ?>" >
 <input type="hidden" name="dat" value="<?php echo @$dat; ?>" >
 <input type="hidden" name="bank" value="<?php echo @$bank; ?>" >
 <input type="hidden" name="confirm" value="<?php echo @$confirm; ?>" >
 </td>
</tr>
</table>
</fieldset>
<br>
<?php 
if ($ID) 
{ 
?>
<input type="hidden" name="user_id" value="<?php echo $UID; ?>" />
<input type="submit" class="submit" name="action"
value="Remit" />
<input type="submit" class="submit" name="action"
value="Edit" />
<input type="submit" class="submit" name="action"
value="Delete" />
<?php
 }
 else 
 {
 ?>

<input type="submit" class="submit" name="action"
value="Remit" />
</td>

			</tr>
<?php 
}
?>
<tr><td>
**************************************************************************************************************************************************************
<br>
<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#005B00">
 <?php
 @$limit      = 20;
 @$page=$_GET['page'];
 @$query_count    = "SELECT * FROM `revenue`";     
 @$result_count   = mysql_query($query_count);     
 @$totalrows  = mysql_num_rows($result_count);

 if(empty($page))
 {
        $page = 1;
 }

 $limitvalue = $page * $limit - ($limit);  


    echo "<TR bgcolor='#D2DD8F'><TH> <b>Date </b>&nbsp;</TH><TH><b>Command </b>&nbsp;</TH><TH><b>Revenue Amount </b>&nbsp;</TH>
      <TH><b>Remittance Bank </b>&nbsp;</TH><TH><b>Amount Remitted </b>&nbsp;</TH><TH><b>Confirmed? </b>&nbsp;</TH></TR>";

    $query="SELECT concat(`Dob_Year`,'/',`DoB_Month`,'/',`DoB_Day`) as date,Command,Amount,Bank,`Amount Remitted`,`ID`,`Confirmed` FROM `Revenue` order by `DoB_Day`,`DoB_Year` desc LIMIT $limitvalue, $limit";
    $result=mysql_query($query);

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($date,$cmd,$amt,$bank,$amtrem,$id,$confirm)=mysql_fetch_row($result))
    {
     $amt=number_format($amt,2);
     $amtrem=number_format($amtrem,2);
     if ($confirm==0){
      echo "<TR><TH>$date &nbsp;</TH><TH>$cmd &nbsp;</TH><TH>$amt &nbsp;</TH>
      <TH>$bank &nbsp;</TH><TH>$amtrem &nbsp;</TH><TH><a href ='banksort.php?id=$id&bank=$bank&page=$page&amount=$amt&dat=$date'>Confirm Now</a></TH></TR>";
     } else {
       echo "<TR><TH>$date &nbsp;</TH><TH>$cmd &nbsp;</TH><TH>$amt &nbsp;</TH>
      <TH>$bank &nbsp;</TH><TH>$amtrem &nbsp;</TH><TH><b>Confirmed</b></TH></TR>";
     }
    }
echo"</TABLE><table align='right'>";
    echo "<TR align='right'><TD>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?page=$pageprev\"> PREV<< </a>  ");
    }
    else 
       echo("PREV<<  ");  

    $numofpages = $totalrows / $limit;  
    for($i = 1; $i <= $numofpages; $i++)
    { 
        if($i == $page)
        { 
            echo($i."  "); 
        }else{ 
            echo("<a href=\"$PHP_SELF?page=$i\">$i</a>  ");  
        }
    } 
    if(($totalrows % $limit) != 0)
    { 
        if($i == $page)
        { 
            echo($i."  "); 
        }
        else
        { 
            echo("<a href=\"$PHP_SELF?page=$i\">$i</a>  "); 
       } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?page=$pagenext\">NEXT>></a>");  
            
    }          
    else
    { 
        echo("NEXT>>");  
    } 
    echo "</TD></TR>";
 ?>
						</td>
					</tr>

				</table>
<br>
**************************************************************************************************************************************************************
<?php 
require_once 'footr.php'; 
require_once 'footer.php'; 
?></td></tr>
		</table>
		</div>
</form>
