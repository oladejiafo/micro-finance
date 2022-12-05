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
$cmbFilter="None";
$filter="";
}
}
 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';

?>
<div align="center">
	<table border="0" width="100%" bgcolor="#FFFFFF" id="table1">

		<tr align='center'>
 <td bgcolor="#008000"><b>
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Cheque Register</font></b>
 </td>
</tr>
		<tr>
			<td colspan="2">

<fieldset style="padding: 2">
<legend><b><i><font size="2" face="Tahoma" color="#008000"> <?php require_once 'acctheader.php'; ?>
</font></i></b></legend>
   <form  action="bankbook.php" method="post">
    <body bgcolor="#D2DD8F">
      Select Criteria to Search with: <select size="1" name="cmbFilter">
      <option selected></option>
      <option value="Date">Date</option>
      <option value="Type">Type</option>
      <option value="Bank">Bank</option>
      <option value="Cheque No">Cheque No</option>
     </select>
     &nbsp; 
     <input type="text" name="filter">
     &nbsp; 
     <input type="submit" value="Go" name="submit">
     <br>
    </body>
   </form>

<form action="bankbook.php" method="post">

<TABLE width='98%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#008000" id="table2">
 <?php
 @$tval=$_GET['tval'];
 $limit      = 15;
 @$page=$_GET['page'];

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];

 echo "<font color='#FF0000' style='font-size: 9pt'>" . $tval . "</font>";
 echo "<p>";

    echo "<b>[Cheque Register]</b><br>";

    echo "<TR><TH><b><u>S/No </b></u>&nbsp;</TH><TH><b><u>Date </b></u>&nbsp;</TH><TH><b><u>Type </b></u>&nbsp;</TH><TH><b><u>Bank</b></u>&nbsp;</TH>
      <TH><b><u>Cheque No </b></u>&nbsp;</TH><TH><b><u>Amount </b></u>&nbsp;</TH><TH><b><u>Particulars </b></u>&nbsp;</TH></TR>";

  if (!$cmbFilter=="")
  {  
   $query_count    = "SELECT * FROM `cheque` WHERE `" . $cmbFilter . "` like '" . $filter . "%'";
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `ID`,`Date`,Type,Bank,`Cheque No`,Amount,`Particulars` FROM `cheque` WHERE `" . $cmbFilter . "` like '" . $filter . "%' order by `Date` desc LIMIT $limitvalue, $limit";
   $result=mysql_query($query);

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$i=0;
    while(list($id,$date,$type,$bank,$chqno,$amount,$particulars)=mysql_fetch_row($result))
    {
     $i=$i+1;
     echo "<TR><TH>$i &nbsp;</TH><TH><a href = 'cheque.php?ID=$id'>$date </a> &nbsp;</TH><TH><a href = 'cheque.php?ID=$id'> $type </a> &nbsp;</TH><TH>$bank &nbsp;</TH>
      <TH>$chqno &nbsp;</TH><TH>$amount &nbsp;</TH><TH>$particulars &nbsp;</TH></TR>";
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
   $query_count    = "SELECT * FROM `cash`";
   $result_count   = mysql_query($query_count);     
   $totalrows  = mysql_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `ID`,`Date`,Type,Bank,`Cheque No`,Amount,`Particulars` FROM `cheque` order by `Date` desc LIMIT $limitvalue, $limit";
   $result=mysql_query($query);

   if(mysql_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$i=0;
    while(list($id,$date,$type,$bank,$chqno,$amount,$particulars)=mysql_fetch_row($result))
    {
     $i=$i+1;
     echo "<TR><TH>$i &nbsp;</TH><TH><a href = 'cheque.php?ID=$id'>$date </a> &nbsp;</TH><TH><a href = 'cheque.php?ID=$id'> $type </a> &nbsp;</TH><TH>$bank &nbsp;</TH>
      <TH>$chqno &nbsp;</TH><TH>$amount &nbsp;</TH><TH>$particulars &nbsp;</TH></TR>";
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
</fieldset>
<TABLE width='30%' border='1' cellpadding='1' cellspacing='0' align='center' bordercolor="#008000" id="table6">

  <?php
     echo "<TR>
               <TH><a href ='cheque.php'> Add New Record </a>&nbsp;</TH>
           </TR>"; 
  ?>
</TABLE>
<br>

</TABLE>
<?php
 require_once 'footr.php';
 require_once 'footer.php';
?>
</form>

			</td>
		</tr>
		
	</table>
</div>


