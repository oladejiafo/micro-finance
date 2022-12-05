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
<fieldset style="padding: 2">
<p><legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'acctheader.php'; ?>
</p></font></i></b></legend>

   <form  action="monthlycash.php" method="post">
    <body bgcolor="#D2DD8F">
      <font style='font-size: 8pt'>Enter Month Number[Format: 04==>april]: 
      <input type="text" name="filter" size="15"></font>
      &nbsp;
      <input type="submit" value="Go" name="submit">
     <br>
    </body>
   </form>

<TABLE width='795' border='1' cellpadding='1' cellspacing='1' align='center' id="table3">
<?php
 $cmbReport=$_REQUEST["cmbReport"];
 $filter=$_REQUEST["filter"];

#   $val="date(`Date`)>'" . date('Y-m-d', strtotime('-1 month')) . "' and date(`Date`)<'" . date('Y-m-d', strtotime('+1 day')) . "'";
   $val="month(`Date`) like '" . $filter . "%' and year(`Date`) like '" . date('Y') . "%'";
#   $val="date(`Sales Date`)=" . date('Y');


   $limit      = 25; 
   $page=$_GET['page'];
   $query_count    = "SELECT * FROM `cash` where " . $val;
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><b> [Monthly Cash Report]</b><br></tr>";
   echo "<TR bgcolor='#008000'><TH><b> Type </b>&nbsp;</TH><TH><b> Category </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH></TR>";
 
   $result = mysql_query ("SELECT `Type`,`Classification`,`Particulars`, `Date`, `Amount` FROM `cash` where " . $val . " LIMIT $limitvalue, $limit"); 
 
   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($type,$class,$details,$date,$amount)=mysql_fetch_row($result)) 
    {	      $amount=number_format($amount,2);
      echo "<TR><TH>$type </TH><TH>$class </TH><TH>$details</TH><TH>$date</TH><TH align='right'>$amount</TH></TR>";
    }
   echo "<TR><TH colspan='5'></TH></TR>";

   $res = mysql_query ("SELECT sum(`Amount`) as amt From `cash` where " . $val); 
   $rowsum = mysql_fetch_array($res);
   $amt=$rowsum['amt'];
   $amt=number_format($amt,2);
   echo "<TR><TH colspan='4' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $amt</b></font></TH></TR>";

    $val='Monthly Cash Summary';

    if($page != 1)
    {  
       $pageprev = $page-1;       
       echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$pageprev\">PREV PAGE</a>  ");
    }
    else 
       echo("PREV PAGE  ");  

    $numofpages = $totalrows / $limit;  
    for($i = 1; $i <= $numofpages; $i++)
    { 
        if($i == $page)
        { 
            echo($i."  "); 
        }else{ 
            echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$i\">$i</a>  ");  
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
            echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$i\">$i</a>  "); 
        } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1; 
          
        echo("<a href=\"$PHP_SELF?cmbReport=$val&page=$pagenext\">NEXT PAGE</a>");  
    }
    else
    { 
        echo("NEXT PAGE");  
    } 
  
    mysql_free_result($result);
?>
<br>
</table>
<form>
<Table align="center">
<tr>
<td>

<?php
 echo "<a target='blank' href='rptreport.php?cmbReport=$cmbReport&cmbTable=$cmbTable&filter=$filter'> Print this Report</a> &nbsp;";
?>
</td>
</tr>
</Table
</form>
