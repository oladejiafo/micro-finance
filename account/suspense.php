<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3))
{
  if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=../index.php?redirect=$redirect");
}
}
 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';
?>
<!-- load jquery ui css-->
<link href="../js/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<!-- load jquery library -->
<script src="../js/jquery-1.9.1.js"></script>
<!-- load jquery ui js file -->
<script src="../js/jquery-ui.min.js"></script>

<style type="text/css">
.div-table {
    width: 100%;
//    border: 1px dashed #ff0000;
    float: left;
    padding:10px;
}

.tab-row {
	background-color: #EEEEEE;
	float: left;
	width: 100%;
	height:45px;
}

.cell {
    padding: 1px;
    border: 1px solid #e9e9e9;
    float: left;
    padding: 5px; 
    background-color: #f5f5f5;
    width: 50%;
    height:45px;
    font-size:12px;
}
</style>

<div align="center">
<div class='row' style="background-color:#394247; width:100%" align="center">
<b><font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Suspense Account</font></b>
</div>

<div>
<form  action="suspense.php" method="post">
      Select Criteria to Search with: 
<select size="1" name="cmbFilter" style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
      <option selected></option>
      <option value="Date">Date</option>
      <option value="Type">Type</option>
      <option value="Classification">Classification</option>
      <option value="Source">Source</option>
     </select>
     &nbsp; 
     <input type="text" name="filter"  style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
     &nbsp; 
     <input type="submit" value="Search" name="submit" style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
   </form>
</div>

<div class="div-table">
 <?php
 @$tval=$_GET['tval'];
 $limit      = 25;
 @$page=$_GET['page'];

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];

 echo "<p><font color='#FF0000' style='font-size: 9pt'>" . $tval . "</font></p>";

?>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:14.2%;background-color:#c0c0c0'>S/NO</div>
    <div  class="cell" style='width:14.2%;background-color:#c0c0c0'>Date</div>
    <div  class="cell" style='width:14.2%;background-color:#c0c0c0'>Cashier Name</div>
    <div  class="cell" style='width:14.2%;background-color:#c0c0c0'>Classification</div>
    <div  class="cell" style='width:14.2%;background-color:#c0c0c0'>Amount</div>
    <div  class="cell" style='width:14.2%;background-color:#c0c0c0'>Details</div>
    <div  class="cell" style='width:14.2%;background-color:#c0c0c0'>&nbsp;</div>
  </div>
<?php
  if (!$cmbFilter=="")
  {  
   $query_count    = "SELECT * FROM `cash` WHERE `" . $cmbFilter . "` like '" . $filter . "%' and `Classification` in ('Suspense Items (unidentified)')";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT distinct `Date`, `ID`,`Recipient`,`Classification`,`Amount`,`Particulars` FROM `cash` WHERE `" . $cmbFilter . "` like '" . $filter . "%' and `Classification` in ('Suspense Items (unidentified)') group by `Recipient`,`Date` order by `Date` desc LIMIT $limitvalue, $limit";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

$i=0;
    while(list($date,$id,$cust,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $i=$i+1;
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:14.2%">' .$i. '</div>
        <div  class="cell" style="width:14.2%"><a href ="suspenses.php?date=' .$date. '&cust=' .$cust. '&id=' .$id. '">' .$date. '</a></div>
        <div  class="cell" style="width:14.2%">' .$cust. '</div>
        <div  class="cell" style="width:14.2%">' .$classification. '</div>
        <div  class="cell" style="width:14.2%">' .$amount. '</div>
        <div  class="cell" style="width:14.2%">' .$particulars.  '</div>
        <div  class="cell" style="width:14.2%">&nbsp;</div>
      </div>';
    }
echo "<div>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a>  ");
    }
    else 
#       echo("PREV PAGE  ");

    $numofpages = $totalrows / $limit;  
    for($i = 1; $i <= $numofpages; $i++)
    { 
        if($i == $page)
        { 
#            echo($i."  "); 
        }else{ 
            echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$i\">$i</a>  ");  
        }
    } 
    if(($totalrows % $limit) != 0)
    { 
        if($i == $page)
        { 
  #          echo($i."  "); 
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
#        echo("NEXT PAGE");  
    } 
echo "</div>";
  }
  else
  {
   $query_count    = "SELECT * FROM `cash` WHERE `Classification` in ('Suspense Items (unidentified)')";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT distinct `Date`,`ID`,`Recipient`,`Classification`,`Amount`,`Particulars` FROM `cash` WHERE `Classification` in ('Suspense Items (unidentified)') group by `Recipient`,`Date` order by `Date` desc LIMIT $limitvalue, $limit";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

$i=0;
    while(list($date,$id,$cust,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $i=$i+1;
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:14.2%">' .$i. '</div>
        <div  class="cell" style="width:14.2%"><a href ="suspenses.php?date=' .$date. '&cust=' .$cust. '&id=' .$id. '">' .$date. '</a></div>
        <div  class="cell" style="width:14.2%">' .$cust. '</div>
        <div  class="cell" style="width:14.2%">' .$classification. '</div>
        <div  class="cell" style="width:14.2%">' .$amount. '</div>
        <div  class="cell" style="width:14.2%">' .$particulars.  '</div>
        <div  class="cell" style="width:14.2%">&nbsp;</div>
      </div>';
    }
echo "<div>";

    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$pageprev\">PREV PAGE</a>  ");
    }
    else 
#       echo("PREV PAGE  ");  

    $numofpages = $totalrows / $limit;  
    for($i = 1; $i <= $numofpages; $i++)
    { 
        if($i == $page)
        { 
#            echo($i."  "); 
        }else{ 
            echo("<a href=\"$PHP_SELF?cmbFilter=$cmbFilter&filter=$filter&page=$i\">$i</a>  ");  
        }
    } 
    if(($totalrows % $limit) != 0)
    { 
        if($i == $page)
        { 
  #          echo($i."  "); 
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
#        echo("NEXT PAGE");  
    } 
echo "</div>";
  }
 ?>
</div>

<div align="center">
  <?php
     echo "<a href ='suspenses.php'> Add New Suspense Item </a>&nbsp;||
              <a target='_blank' href ='rptsuspense.php'> Print This </a>"; 
  ?>
</div>
<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>