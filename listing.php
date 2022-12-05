<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & $_SESSION['access_lvl'] != 5) 
{
 if ($_SESSION['access_lvl'] != 3 & $_SESSION['access_lvl'] != 4) 
 {
   $redirect = $_SERVER['PHP_SELF'];
   header("Refresh: 0; URL=index.php?redirect=$redirect");
 }
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';
?>
<style type="text/css">
.div-table {
    width: 100%;
    border: 1px solid;
    float: left;
    width: 100%;
	padding:30px;
}

.tab-row {
	background-color: #EEEEEE;
	float: left;
	width: 100%;
	height:5em;
}

.cell {
    padding: 5px;
    border: 1px solid #e9e9e9;
   // text-align:center;
    float: left;
    padding: 5px; 
    background-color: #f5f5f5;
    width: 10%;
    height:4.7em;
    max-height: auto;
    font-size:12px;
    word-wrap: break-word;
}

@media (max-width: 480px){
.tab-row {
	background-color: #EEEEEE;
	float: left;
	width: 100%;
	height:5.5em;
}

.cell {
    padding: 1px;
    border: 1px solid #e9e9e9;
    float: left;
    padding: 5px; 
    background-color: #f5f5f5;
    width: 10%;
    height:5.3em;
    font-size:9px;
   // word-wrap: break-word;
}
}
</style>
<div class="services">
	<div class="container"  style="width:100%">

 <h4 style="background-color:#87B8D6;text-align:center"><b>
<font face="Verdana" color="#FFFFFF" style="font-size: 16pt">MANAGE USER LOGINS</font></b>
 </h4>
<div class="div-table">

 <?php
 @$limit      = 25;
 @$page=$_GET['page'];
 @$query_count    = "SELECT * FROM `login`";     
 @$result_count   = mysqli_query($conn,$query_count);     
 @$totalrows  = mysqli_num_rows($result_count);

 if(empty($page))
 {
        $page = 1;
 }

 $limitvalue = $page * $limit - ($limit);  
?>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:25%;background-color:#cbd9d9'>UserName</div>
    <div  class="cell" style='width:25%;background-color:#cbd9d9'>Category</div>
    <div  class="cell" style='width:25%;background-color:#cbd9d9'>e-mail</div>
    <div  class="cell" style='width:25%;background-color:#cbd9d9'>Access Level</div>
  </div>
<?php

    $query="SELECT login.user_id,login.username,login.access_lvl,cms_access_levels.access_name,login.email FROM login inner join cms_access_levels on login.access_lvl=cms_access_levels.access_lvl where `username` not like 'control%' order by login.access_lvl desc LIMIT $limitvalue, $limit";
    $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<p>Nothing to Display!</p>"); 
   } 

    while(list($user_id,$username,$access_lvl,$access_name,$email)=mysqli_fetch_row($result))
    {
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:25%"><a href = "useraccount.php?UID=' . $user_id . '">' .$username. '</a></div>
        <div  class="cell" style="width:25%">' .$access_name. '</div>
        <div  class="cell" style="width:25%">' .$email. '</div>
        <div  class="cell" style="width:25%">' .$access_lvl. '</div>
      </div>';
    }
    echo "<p>";
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
    echo "</p>";
 ?>
</div>
<p align="right" style="margin-right:20px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
&copy 2011- <?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>
</div></div>