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
<div class='row' style="background-color:#394247; width:100%" align="center"><b>
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Payments Summary</font></b>
</div>

<div>
   <form  action="paysumm.php" method="post">
      Select Criteria to Search with: <select size="1" name="cmbFilter" style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
      <option selected></option>
      <option value="Date">Date</option>
      <option value="Type">Type</option>
      <option value="Recipient">Recipient</option>
     </select>
     &nbsp; 
     <input type="text" name="filter" style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
     &nbsp; 
     <input type="submit" value="Search" name="submit" style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
     <br>
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
    <div  class="cell"  style='width:12.5%;background-color:#dcdfdf'>S/NO</div>
    <div  class="cell" style='width:12.5%;background-color:#dcdfdf'>Date</div>
    <div  class="cell" style='width:12.5%;background-color:#dcdfdf'>Pay Type/Reason</div>
    <div  class="cell" style='width:12.5%;background-color:#dcdfdf'>Recipient</div>
    <div  class="cell" style='width:12.5%;background-color:#dcdfdf'>Amount Pending</div>
    <div  class="cell" style='width:12.5%;background-color:#dcdfdf'>Amount Paid so Far</div>
    <div  class="cell" style='width:12.5%;background-color:#dcdfdf'>Remark</div>
    <div  class="cell" style='width:12.5%;background-color:#dcdfdf'>&nbsp;</div>
  </div>
<?php

  if ($cmbFilter !="")
  {  
   $query_count    = "SELECT `ID` FROM `cash` WHERE `" . $cmbFilter . "` like '" . $filter . "%' union Select `ID` from `Contract` WHERE `" . $cmbFilter . "` like '" . $filter . "%'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `ID`,`Contract Date`,`Contractor`,`Contract Title`,`Contract Category`,(`Amount`-`Amount Paid`) as pending,`Amount Paid`,`Paid`,`Remark` FROM `contract` WHERE `Paid`='Unpaid' and `" . $cmbFilter . "` like '" . $filter . "%' order by `Contract Date` desc LIMIT $limitvalue, $limit";
   $result=mysqli_query($conn,$query);

   $query2="SELECT `ID`,`Date`,`Type`,`Recipient`,`Amount`,`Paid`,`Remark` FROM `cash` WHERE `Paid`='Unpaid' and `" . $cmbFilter . "` like '" . $filter . "%' order by `Date` desc LIMIT $limitvalue, $limit";
   $result2=mysqli_query($conn,$query2);

   if(mysqli_num_rows($result) == 0 and mysqli_num_rows($result2) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

$i=0;
     echo "<div align='center' style='width:100%'>CONTRACTORS</div>";
    while(list($id,$date,$recipient,$title,$category,$pending,$pamount,$paid,$remark)=mysqli_fetch_row($result))
    {
     $i=$i+1;
     if ($remark !='Approved')
     {
      $remark ='Unapproved';
     }

     $date=date('d M, Y',strtotime($date));
     $pending=number_format($pending,2);
     $pamount=number_format($pamount,2);
     $type='Contract';

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">' .$i. '</div>
        <div  class="cell" style="width:12.5%">' .$date. '</div>
        <div  class="cell" style="width:12.5%">' .$title. '</div>
        <div  class="cell" style="width:12.5%">' .$recipient. '</div>
        <div  class="cell" style="width:12.5%">' .$pending.  '</div>
        <div  class="cell" style="width:12.5%">' .$pamount.  '</div>
        <div  class="cell" style="width:12.5%">' .$remark.  '</div>
        <div  class="cell" style="width:12.5%"><font color="#FF0000" style="font-size: 12px"><a href ="paysummcalc.php?id=' .$id. '&type=' .$type. '&filter=' .$filter. '&page=' .$page. '&cmbFilter=' .$cmbFilter. '">Approve Now</a></font></div>
      </div>';
    }

     echo "<div align='center' style='width:100%'>EXPENDITURES</div>";
    while(list($id,$date,$type,$recipient,$amount,$paid,$remark)=mysqli_fetch_row($result2))
    {
     $i=$i+1;
     if ($remark !='Approved')
     {
      $remark ='Unapproved';
     }
     $date=date('d M, Y',strtotime($date));
     $amount=number_format($amount,2);
     $type='Expense';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">' .$i. '</div>
        <div  class="cell" style="width:12.5%">' .$date. '</div>
        <div  class="cell" style="width:12.5%">' .$title. '</div>
        <div  class="cell" style="width:12.5%">' .$recipient. '</div>
        <div  class="cell" style="width:12.5%">' .$amount.  '</div>
        <div  class="cell" style="width:12.5%">0</div>
        <div  class="cell" style="width:12.5%">' .$remark.  '</div>
        <div  class="cell" style="width:12.5%"><font color="#FF0000" style="font-size: 12px"><a href ="paysummcalc.php?id=' .$id. '&type=' .$type. '&filter=' .$filter. '&page=' .$page. '&cmbFilter=' .$cmbFilter. '">Approve Now</a></font></div>
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
   $query_count    = "SELECT `ID` FROM `cash` union Select `ID` from `Contract`";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `ID`,`Contract Date`,`Contractor`,`Contract Title`,`Contract Category`,(`Amount`-`Amount Paid`) as pending,`Amount Paid`,`Paid`,`Remark` FROM `contract` WHERE `Paid`='Unpaid' order by `Contract Date` desc LIMIT $limitvalue, $limit";
   $result=mysqli_query($conn,$query);

   $query2="SELECT `ID`,`Date`,`Type`,`Recipient`,`Amount`,`Paid`,`Remark` FROM `cash` WHERE `Paid`='Unpaid' order by `Date` desc LIMIT $limitvalue, $limit";
   $result2=mysqli_query($conn,$query2);

   if(mysqli_num_rows($result) == 0 and mysqli_num_rows($result2) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

$i=0;
     echo "<div align='center' style='width:100%'>CONTRACTORS</div>";
    while(list($id,$date,$recipient,$title,$category,$pending,$pamount,$paid,$remark)=mysqli_fetch_row($result))
    {
     $i=$i+1;
     if ($remark !='Approved')
     {
      $remark ='Unapproved';
     }

     $date=date('d M, Y',strtotime($date));
     $pending=number_format($pending,2);
     $pamount=number_format($pamount,2);
     $type='Contract';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">' .$i. '</div>
        <div  class="cell" style="width:12.5%">' .$date. '</div>
        <div  class="cell" style="width:12.5%">' .$title. '</div>
        <div  class="cell" style="width:12.5%">' .$recipient. '</div>
        <div  class="cell" style="width:12.5%">' .$pending.  '</div>
        <div  class="cell" style="width:12.5%">' .$pamount.  '</div>
        <div  class="cell" style="width:12.5%">' .$remark.  '</div>
        <div  class="cell" style="width:12.5%"><font color="#FF0000" style="font-size: 12px"><a href ="paysummcalc.php?id=' .$id. '&type=' .$type. '&filter=' .$filter. '&page=' .$page. '&cmbFilter=' .$cmbFilter. '">Approve Now</a></font></div>
      </div>';
    }

     echo "<div align='center' style='width:100%'>EXPENDITURES</div>";
    while(list($id,$date,$type,$recipient,$amount,$paid,$remark)=mysqli_fetch_row($result2))
    {
     $i=$i+1;
     if ($remark !='Approved')
     {
      $remark ='Unapproved';
     }
     $date=date('d M, Y',strtotime($date));
     $amount=number_format($amount,2);
     $type='Expense';
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">' .$i. '</div>
        <div  class="cell" style="width:12.5%">' .$date. '</div>
        <div  class="cell" style="width:12.5%">' .$title. '</div>
        <div  class="cell" style="width:12.5%">' .$recipient. '</div>
        <div  class="cell" style="width:12.5%">' .$amount.  '</div>
        <div  class="cell" style="width:12.5%">0</div>
        <div  class="cell" style="width:12.5%">' .$remark.  '</div>
        <div  class="cell" style="width:12.5%"><font color="#FF0000" style="font-size: 12px"><a href ="paysummcalc.php?id=' .$id. '&type=' .$type. '&filter=' .$filter. '&page=' .$page. '&cmbFilter=' .$cmbFilter. '">Approve Now</a></font></div>
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
#            echo($i."  "); 
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
     echo "<a href ='exppaysumm.php?cmbFilter=$cmbFilter&filter=$filter'> Export </a>"; 
  ?>
</div>
<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>