<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 1))
{
 if ($_SESSION['access_lvl'] != 2){
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
   <form  action="inventory.php" method="post">
    <body bgcolor="#D2DD8F">
     <h2><center>Inventory List</center></h2>
      Select Criteria to Filter with: <select size="1" name="cmbFilter">
      <option value="None">None</option>
      <option value="Location">Location</option>
      <option value="Stock">Stock</option>
      <option value="Stock Category">Stock Category</option>
     </select>
     &nbsp; 
     <input type="text" name="filter">
     &nbsp; 
     <input type="submit" value="Go" name="submit">
     <br>
    </body>
   </form>

<TABLE width='927' border='1' cellpadding='1' cellspacing='1' align='center' id="table3">
<?php
   $limit      = 20;
   $page=$_GET['page'];   

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];
 if ($filter=="None" or $filter=="")
 {
   $filter="All Stock";
 }
  echo " <tr><b>INVENTORY FOR: " . ucfirst($filter) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AS AT: " . date('d-M-Y') . "</b><br></tr>";
      echo "<TR bgcolor='#008000'><TH><b>S/No </b>&nbsp;</TH><TH><b> Stock Code </b>&nbsp;</TH><TH><b> Stock Name </b>&nbsp;</TH><TH><b> Stock Category </b>&nbsp;</TH><TH><b> Location </b>&nbsp;</TH> <TH><b> Re-Order Level </b>&nbsp;</TH><TH><b> Unit Cost </b>&nbsp;&nbsp;</TH>
      <TH><b> Units In Stock </b>&nbsp;&nbsp;</TH><TH><b> Correct </b>&nbsp;&nbsp;</TH></TR>";
  if (trim(empty($cmbFilter)))
  {
   $query_count    = "SELECT * FROM `Stock`"; 
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` order by `Location`,`Category`,`Stock Code` LIMIT $limitvalue, $limit"); 

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 


$i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysql_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }

    echo"</TABLE>";
    echo "<TR align='right'><TD>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a> &nbsp;|| ");
    }
    else 
       echo("PREV PAGE  &nbsp;||");  


    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pagenext\">&nbsp; NEXT PAGE</a>");  
            
    }          
    else
    { 
        echo("&nbsp; NEXT PAGE");  
    } 
    echo "</TD></TR>";
  }
  else if (trim($cmbFilter)=="None")
  {
   $query_count    = "SELECT * FROM `Stock`"; 
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` order by `Location`,`Category`,`Stock Code` LIMIT $limitvalue, $limit"); 

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 


$i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysql_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }

    echo"</TABLE>";
    echo "<TR align='right'><TD>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a> &nbsp;|| ");
    }
    else 
       echo("PREV PAGE  &nbsp;||");  


    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pagenext\">&nbsp; NEXT PAGE</a>");  
            
    }          
    else
    { 
        echo("&nbsp; NEXT PAGE");  
    } 
    echo "</TD></TR>";
  }

  else if (trim($cmbFilter)=="Location")
  {  
   $query_count    = "SELECT * FROM `Stock` WHERE `Location`='" . $filter . "' "; 
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Location`='" . $filter . "' order by `Location`,`Category`,`Stock Code` LIMIT $limitvalue, $limit"); 

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysql_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }

    echo"</TABLE>";
    echo "<TR align='right'><TD>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a> &nbsp;|| ");
    }
    else 
       echo("PREV PAGE  &nbsp;||");  


    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pagenext\">&nbsp; NEXT PAGE</a>");  
            
    }          
    else
    { 
        echo("&nbsp; NEXT PAGE");  
    } 
    echo "</TD></TR>";
  }
  else if (trim($cmbFilter)=="Stock")
  {     
   $query_count    = "SELECT * FROM `Stock` WHERE `Stock Name`='" . $filter . "' "; 
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Stock Name`='" . $filter . "' order by `Location`,`Category`,`Stock Code` LIMIT $limitvalue, $limit"); 

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysql_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }

    echo"</TABLE>";
    echo "<TR align='right'><TD>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a> &nbsp;|| ");
    }
    else 
       echo("PREV PAGE  &nbsp;||");  


    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pagenext\">&nbsp; NEXT PAGE</a>");  
            
    }          
    else
    { 
        echo("&nbsp; NEXT PAGE");  
    } 
    echo "</TD></TR>";
  }
  else if (trim($cmbFilter)=="Stock Category")
  {  
   $query_count    = "SELECT * FROM `Stock` WHERE `Category`='" . $filter . "' "; 
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Category`='" . $filter . "' order by `Location`,`Category`,`Stock Code` LIMIT $limitvalue, $limit"); 

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysql_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }

    echo"</TABLE>";
    echo "<TR align='right'><TD>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a> &nbsp;|| ");
    }
    else 
       echo("PREV PAGE  &nbsp;||");  


    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pagenext\">&nbsp; NEXT PAGE</a>");  
            
    }          
    else
    { 
        echo("&nbsp; NEXT PAGE");  
    } 
    echo "</TD></TR>";
  }

  else if (trim($cmbFilter)=="Staff Number")
  {  
   $query_count    = "SELECT * FROM `Staff` WHERE `Staff Number` like '" . $filter . "%'"; 
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $result = mysql_query ("SELECT `Staff Number`,  `Firstname` , `Surname`, `Sex`,`Present Rank`,`Barrdate`,`DoB`,`First Appt`,`Present Appt`,`State`,`LGA`,`Qualification`, `Present Location`, `Position` From `Staff`  WHERE `Staff Number` like '" . $filter . "%' order by `Level` desc,`Present Appt` desc,`staff number` LIMIT $limitvalue, $limit"); 

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$i=0;
   while(list($serviceno, $fname,$sname, $sex, $rank,$bdate,$dob, $firstappt, $presentappt, $state, $lga, $qualification, $location, $pos)=mysql_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $serviceno &nbsp;</TH><TH> $sname </a> &nbsp;</TH><TH> $fname </a> &nbsp;</TH> <TH> $sex &nbsp;</TH> <TH> $rank &nbsp;</TH><TH> $pos &nbsp;</TH>
      <TH> $location &nbsp;</TH><TH> $presentappt &nbsp;</TH></TR>";
   }

    echo"</TABLE>";
    echo "<TR align='right'><TD>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a> &nbsp;|| ");
    }
    else 
       echo("PREV PAGE  &nbsp;||");  


    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pagenext\">&nbsp; NEXT PAGE</a>");  
            
    }          
    else
    { 
        echo("&nbsp; NEXT PAGE");  
    } 
    echo "</TD></TR>";
  }
 
?>
<br>
<form>
<Table>
<tr>
<td>

<?php
 echo "<a target='blank' href='rptinventory.php?cmbFilter=$cmbFilter&filter=$filter'> Print this Inventory</a> &nbsp; |";
 echo "| <a target='blank' href='expinv.php?cmbFilter=$cmbFilter&filter=$filter'> Export this Inventory</a> &nbsp; ";
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
