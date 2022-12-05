<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2))
{
 if ($_SESSION['access_lvl'] != 1){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
$cmbFilter="None";
$filter="";
}
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';
global $Tit;
$Tit=$_REQUEST['Tit'];
?>
<div align="center">
	<table border="0" width="927" bgcolor="#FFFFFF" id="table1">
		<tr align='center'>
 <td bgcolor="#008000"><b>
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Stock List</font></b>
 </td>
</tr>
		<tr>
			<td colspan="2">

   <form  action="stocklist.php" method="post">
    <body bgcolor="#D2DD8F">
      Select Criteria to Search with: <select size="1" name="cmbFilter">
      <option selected></option>
      <option value="Category">Category</option>
      <option value="Brand Name">Brand Name</option>
      <option value="Stock Name">Stock Name</option>
      <option value="Location">Location</option>
      <option value="Reorder">Reorder</option>
      <option value="Expired">Expired</option>
     </select>
     &nbsp; 
     <input type="text" name="filter">
     &nbsp; 
     <input type="submit" value="Go" name="submit">
     <br>
    </body>
   </form>

<form action="stock.php" method="post">
<font size="2px" face="Arial">
<TABLE width='90%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#005B00" id="table2">
 <?php
 $tval=$_GET['tval'];
 $limit      = 15;
 $page=$_GET['page'];

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];

if ($cmbFilter=="Reorder" or $cmbFilter=="Expired")
{
  $cmbFilter="";
}

 echo "<font color='#FF0000' style='font-size: 8pt'>" . $tval . "</font>";
 echo "<p><font style='font-size: 9pt'>";

    echo "<b>[STOCKS LIST]</b><br>";

    echo "<TR><TH><b><u>Stock Code</b></u>&nbsp;</TH><TH><b><u>Brand Name </b></u>&nbsp;</TH><TH><b><u>Stock Name </b></u>&nbsp;</TH>
      <TH><b><u>Units in Stock </b></u>&nbsp;</TH><TH><b><u>Location </b></u>&nbsp;</TH></TR>";

  if (!$cmbFilter=="")
  {  
   $query_count    = "SELECT * FROM `stock` WHERE `" . $cmbFilter . "` like '" . $filter . "%'"; 
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `Stock Code`,`Brand Name`,`Stock Name`,`Units in Stock`,`Location` FROM stock WHERE `" . $cmbFilter . "` like '" . $filter . "%' LIMIT $limitvalue, $limit";
   $result=mysql_query($query);

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

    while(list($code,$brand,$name,$units,$location)=mysql_fetch_row($result))
    {
     echo "<TR><TH> $code</TH><TH> $brand</TH><TH><a href = 'stock.php?code=" . $code . "'>$name </a> &nbsp;</TH><TH> $units &nbsp;</TH><TH>$location &nbsp;</TH></TR>";
    }

    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a>  ");
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
            echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$i\">$i</a>  ");  
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
            echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$i\">$i</a>  "); 
       } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pagenext\">NEXT PAGE</a>");  
            
    }          
    else
    { 
        echo("NEXT PAGE");  
    } 
  }
  else
  {
   $query_count    = "SELECT * FROM `stock`"; 
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `Stock Code`,`Brand Name`,`Stock Name`,`Units in Stock`,`Location` FROM stock LIMIT $limitvalue, $limit";
   $result=mysql_query($query);

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

    while(list($code,$brand,$name,$units,$location)=mysql_fetch_row($result))
    {
     echo "<TR><TH> $code</TH><TH> $brand</TH><TH><a href = 'stock.php?code=" . $code . "'>$name </a> &nbsp;</TH><TH> $units &nbsp;</TH><TH>$location &nbsp;</TH></TR>";
    }

    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a>  ");
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
            echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$i\">$i</a>  ");  
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
            echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$i\">$i</a>  "); 
       } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pagenext\">NEXT PAGE</a>");  
            
    }          
    else
    { 
        echo("NEXT PAGE");  
    } 

  }

 ?>
</TABLE>
<TABLE width='30%' border='1' cellpadding='1' cellspacing='0' align='center' bordercolor="#005B00" id="table6">

  <?php
     echo "<br><TR>
	       <TH><a href ='rptstockctb.php' target='blank'> Stock Report </a>&nbsp;</TH>
               <TH><a href ='stock.php'> Add New Stock </a>&nbsp;</TH><br>
           </TR>"; 
  ?>

</TABLE>
</font>
</TABLE>
</font>
</form>

			</td>
		</tr>
		<tr>
			<td colspan="2"><?php
 require_once 'footr.php';
 require_once 'footer.php';
?></td>
		</tr>
	</table>
</div>