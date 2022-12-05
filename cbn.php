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

$sql="SELECT `ID`,`Bank`,`DoB_Day`,`DoB_Month`,`DoB_Year`,`Amount`,`Command`,`Location`,`Amount Remitted` FROM `Revenue` WHERE `ID`='$ID'";
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
$ttt=0;
echo "<form method=\"post\" action=\"transact-user.php\">\n";

echo "<h2>CBN Interface</h2>\n";

echo "<font color='#FF0000' style='font-size: 12pt'>" . $tval . "</font>";
echo "<p>";
?>
<div align="left">
**************************************************************************************************************************************************************
<br>
<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#005B00">
 <?php
 @$limit      = 20;
 @$page=$_GET['page'];
 @$query_count    = "SELECT * FROM `remitance`";     
 @$result_count   = mysql_query($query_count);     
 @$totalrows  = mysql_num_rows($result_count);

 if(empty($page))
 {
        $page = 1;
 }

 $limitvalue = $page * $limit - ($limit);  

    echo "<b>[REVENUE LISTING]</b><br>";

    echo "<TR bgcolor='#D2DD8F'><TH> <b>Date </b>&nbsp;</TH><TH><b>Bank </b>&nbsp;</TH><TH><b>Amount Remitted </b>&nbsp;</TH><TH><b>Bank Confirmed? </b>&nbsp;</TH><TH><b>CBN Confirmed? </b>&nbsp;</TH></TR>";

    $query="SELECT `Bank Date`,Bank,`Bank Remitance`,`ID`,`Bank Confirm`,`CBN Confirm` FROM `remitance` order by `Bank` LIMIT $limitvalue, $limit";
    $result=mysql_query($query);

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($date,$bank,$amt,$id,$confirm,$conf)=mysql_fetch_row($result))
    {
     #$amt=number_format($amt,2);
     #$amtrem=number_format($amtrem,2);
     if ($confirm==0)
     { 
       $confirm='No';
     } else {
       $confirm='Yes';
     }
     if ($conf==0){
      echo "<TR><TH>$date &nbsp;</TH><TH>$bank &nbsp;</TH><TH>$amt &nbsp;</TH><TH>$confirm &nbsp;</TH><TH><a href ='cbnsort.php?id=$id&bank=$bank&page=$page&amount=$amt&dat=$date'>Confirm Now</a></TR>";
     } else { 
       echo "<TR><TH>$date &nbsp;</TH><TH>$bank &nbsp;</TH><TH>$amt &nbsp;</TH><TH><b>$confirm</b></TH><TH>Confirmed</TH></TR>";
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
