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
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">Loan Provisions</font></b>
</div>

<div>
   <form  action="provisions.php" method="post">
      Select Criteria to Search with: <select size="1" name="cmbFilter" style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
      <option selected></option>
      <option value="Date">Date</option>
      <option value="Type">Type</option>
      <option value="Classification">Classification</option>
      <option value="Source">Source</option>
     </select>
     &nbsp; 
     <input type="text" name="filter"  style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
     &nbsp; 
     <input type="submit" value="Search" name="submit"  style="height:35;width:120px; background-color:#E9FCFE; font-size: 12px">
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
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>S/NO</div>
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>Date</div>
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>Customer Name</div>
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>Performing Loan (N) <br> 1% (0 Day)</div>
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>Pass and Watch Loan (N) <br>5% (1-30 Days)</div>
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>Substandard Loan (N) <br>20% (31-60 Days)</div>
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>Doubtful Loan (N) <br>50% (61-90 Days)</div>
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>Lost Loan (N) <br>100% (Above 90 Days)</div>
    <div  class="cell" style='height:65px;width:11.1%;background-color:#c0c0c0'>Total</div>
  </div>
<?php

  if (!$cmbFilter=="")
  {  
   $query_count    = "SELECT * FROM `cash` WHERE `" . $cmbFilter . "` like '" . $filter . "%' and `Classification` in ('General Reserves','Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)','Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)')";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT `Date`,`Recipient`,`Classification`,`Amount`,`Particulars` FROM `cash` WHERE `" . $cmbFilter . "` like '" . $filter . "%' and `Classification` in ('General Reserves','Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)','Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)') group by `Recipient`,`Date` order by `Date` desc LIMIT $limitvalue, $limit";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

$i=0;
    while(list($date,$cust,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $i=$i+1;

     $sql1="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Performing Loans (0 day)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest1 = mysqli_query($conn,$sql1) or die('Could not look up user data; ' . mysqli_error());
     $row1 = mysqli_fetch_array($rest1);
     $amt1= $row1['Amount'];
     $did1= $row1['ID'];
     $class1= $row1['Classification'];

     $sql2="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Pass and Watch Loans (1-30 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest2 = mysqli_query($conn,$sql2) or die('Could not look up user data; ' . mysqli_error());
     $row2 = mysqli_fetch_array($rest2);
     $amt2= $row2['Amount'];
     $did2= $row2['ID'];
     $class2= $row2['Classification'];

     $sql3="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Substandard Loans (31-60 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest3 = mysqli_query($conn,$sql3) or die('Could not look up user data; ' . mysqli_error());
     $row3 = mysqli_fetch_array($rest3);
     $amt3= $row3['Amount'];
     $did3= $row3['ID'];
     $class3= $row3['Classification'];

     $sql4="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Doubtful Loans (61-90 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest4 = mysqli_query($conn,$sql4) or die('Could not look up user data; ' . mysqli_error());
     $row4 = mysqli_fetch_array($rest4);
     $amt4= $row4['Amount'];
     $did4= $row4['ID'];
     $class4= $row4['Classification'];

     $sql5="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Lost Loans (>91 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest5 = mysqli_query($conn,$sql5) or die('Could not look up user data; ' . mysqli_error());
     $row5 = mysqli_fetch_array($rest5);
     $amt5= $row5['Amount'];
     $did5= $row5['ID'];
     $class5= $row5['Classification'];
     $total=$amt1+$amt2+$amt3+$amt4+$amt5;

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:11.1%">' .$i. '</div>
        <div  class="cell" style="width:11.1%">' .$date. '</div>
        <div  class="cell" style="width:11.1%">' .$cust. '</div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class1. '&id=' .$did1. '">' .$amt1. '</a></div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class2. '&id=' .$did2. '">' .$amt2. '</a></div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class3. '&id=' .$did3. '">' .$amt3. '</a></div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class4. '&id=' .$did4. '">' .$amt4. '</a></div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class5. '&id=' .$did5. '">' .$amt5. '</a></div>
        <div  class="cell" style="width:11.1%">' .$total.  '</div>
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
   $query_count    = "SELECT * FROM `cash` WHERE `Classification` in ('General Reserves','Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)','Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)')";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);

   if(empty($page))
   {
         $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   $query="SELECT distinct `Date`,`Recipient`,`Classification`,`Amount`,`Particulars` FROM `cash` WHERE `Classification` in ('General Reserves','Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)','Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)') group by `Recipient`,`Date` order by `Date` desc LIMIT $limitvalue, $limit";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

$i=0;
    while(list($date,$cust,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $i=$i+1;

     $sql1="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Performing Loans (0 day)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest1 = mysqli_query($conn,$sql1) or die('Could not look up user data; ' . mysqli_error());
     $row1 = mysqli_fetch_array($rest1);
     $amt1= $row1['Amount'];
     $did1= $row1['ID'];
     $class1= $row1['Classification'];

     $sql2="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Pass and Watch Loans (1-30 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest2 = mysqli_query($conn,$sql2) or die('Could not look up user data; ' . mysqli_error());
     $row2 = mysqli_fetch_array($rest2);
     $amt2= $row2['Amount'];
     $did2= $row2['ID'];
     $class2= $row2['Classification'];

     $sql3="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Substandard Loans (31-60 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest3 = mysqli_query($conn,$sql3) or die('Could not look up user data; ' . mysqli_error());
     $row3 = mysqli_fetch_array($rest3);
     $amt3= $row3['Amount'];
     $did3= $row3['ID'];
     $class3= $row3['Classification'];

     $sql4="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Doubtful Loans (61-90 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest4 = mysqli_query($conn,$sql4) or die('Could not look up user data; ' . mysqli_error());
     $row4 = mysqli_fetch_array($rest4);
     $amt4= $row4['Amount'];
     $did4= $row4['ID'];
     $class4= $row4['Classification'];

     $sql5="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Lost Loans (>91 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest5 = mysqli_query($conn,$sql5) or die('Could not look up user data; ' . mysqli_error());
     $row5 = mysqli_fetch_array($rest5);
     $amt5= $row5['Amount'];
     $did5= $row5['ID'];
     $class5= $row5['Classification'];
     $total=$amt1+$amt2+$amt3+$amt4+$amt5;
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:11.1%">' .$i. '</div>
        <div  class="cell" style="width:11.1%">' .$date. '</div>
        <div  class="cell" style="width:11.1%">' .$cust. '</div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class1. '&id=' .$did1. '">' .$amt1. '</a></div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class2. '&id=' .$did2. '">' .$amt2. '</a></div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class3. '&id=' .$did3. '">' .$amt3. '</a></div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class4. '&id=' .$did4. '">' .$amt4. '</a></div>
        <div  class="cell" style="width:11.1%"><a href ="provision.php?date=' .$date. '&cust=' .$cust. '&class=' .$class5. '&id=' .$did5. '">' .$amt5. '</a></div>
        <div  class="cell" style="width:11.1%">' .$total.  '</div>
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
     echo "<a href ='provision.php'> Add New Loan Provision </a>&nbsp;||
               <a target='_blank' href ='rptproloan.php?cmbFilter=$cmbFilter&filter=$filter'> Print This </a>"; 
  ?>
</div>


<p align="right" style="margin-right:40px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
  &copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div>