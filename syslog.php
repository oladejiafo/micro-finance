<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & $_SESSION['access_lvl'] != 5) 
{
 if ($_SESSION['access_lvl'] != 1 & $_SESSION['access_lvl'] != 4 & $_SESSION['access_lvl'] != 44 & $_SESSION['access_lvl'] != 444) 
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
<!--
.wrapTableTech {
    display: table;
    width: 100%;
    height: 14rem;
    border: 1px solid;
    float: left;
    width: 100%;
  }
  .blocTech {
    display: table-header-group;
    background-color: #87B8D6;
    float: left;
    //width: 14%;	
  }
  .tech-cell {
    display: table-cell;
    text-align: justify;
    padding: 10px;
    border: 1px solid #f5f5f5;
    text-align:center;
    width: 16%;		
  }
  .blocCat {
    display: table-row-group;
    background-color: gray;
	text-align: center;
    width: 100%;
  }
  .tech-row {
    display: table-row;
    border: 1px solid #f5f5f5;
    //width: 20%;
  }

  .tech-RowTitle {
   display: table-cell;
    text-align: justify;
    padding: 10px;
    border: 1px solid #f5f5f5;
    text-align:center;
  }

  .tech-value {
    display: table-cell;
    text-align: justify;
    padding: 10px;
    border: 1px solid #e9e9e9;
   // text-align:center;
    background-color: #f5f5f5;
	width:16%;
  }
-->
</style>

<div class="services">
	<div class="container">
   <form  action="syslog.php" method="post">
    <body bgcolor="#D2DD8F">
     <h2><center>System Auto-Log</center></h2>
      Select Criteria to Filter/(Act) with: <select size="1" name="cmbFilter">
      <option Selected></option>
<?php
if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
?>
      <option>Admin Changes</option>
<?php
}
?>
      <option>User Category</option>
      <option>User Name</option>
      <option>Date Logged</option>
      <option>Show All (Desc)</option>
      <option>Show All (Asc)</option>
<?php
if ($_SESSION['access_lvl'] == 5) 
{
?>
      <option>Delete All</option>
      <option>Delete by Category</option>
<?php
}
?>
     </select>
     &nbsp; 
     <input type="text" name="filter">
     &nbsp; 
     <input type="submit" value="Go" name="submit">
     &nbsp;&nbsp;&nbsp;
    </body>
   </form>


<div class="wrapTableTech">
<?php

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];
 
 $limit      = 30;
 $page=$_GET['page'];
   echo "<font size='1'>";
   echo "Filtered using: " . $cmbFilter . "=" . $filter;
   echo "<br>";
?>

  <div style="width:100%" class="blocTech">
    <div class="tech-cell">User Category</div>
    <div class="tech-cell">User Name</div>
    <div class="tech-cell">Date Logged</div>
    <div class="tech-cell">Time Logged</div>
    <div class="tech-cell">File Used</div>
    <div class="tech-cell">Details</div>
    <div class="tech-cell">IP Address </div>
  </div>
  
<?php
  if (trim(empty($cmbFilter)))
  {

if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` where `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') order by `Date Logged on` desc, `Time Logged On` desc");
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` order by `Date Logged on` desc, `Time Logged On` desc");
}
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '">' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '">' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;
 

if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`,`ip` From `monitor` where `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') order by `Date Logged on` desc, `Time Logged On` desc $limit"); 
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`,`ip` From monitor order by `Date Logged on` desc, `Time Logged On` desc $limit"); 
}
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>
<div>
<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
</div>
<?php
  } 

  else if (trim($cmbFilter)=="Admin Changes")
  {
 $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` where `User Category`='Administrator' order by `Date Logged on` desc, `Time Logged On` desc");
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`,`ip` From `monitor` where `User Category`='Administrator' order by `Date Logged on` desc, `Time Logged On` desc $limit"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>

<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
<?php
  }
  else if (trim($cmbFilter)=="Show All (Asc)")
  {
if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
    $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` where `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') order by `Date Logged on` asc, `Time Logged On` asc");
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
    $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` order by `Date Logged on` asc, `Time Logged On` asc");
}
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;

if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`,`ip` From monitor  where `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') order by `Date Logged on` asc, `Time Logged On` asc $limit"); 
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`,`ip` From monitor order by `Date Logged on` asc, `Time Logged On` asc $limit"); 
} 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>
<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
<?php
  }
  else if (trim($cmbFilter)=="" or trim($cmbFilter)=="Show All (Desc)")
  {
if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
  $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` where `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') order by `Date Logged on` desc, `Time Logged On` desc");
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` order by `Date Logged on` desc, `Time Logged On` desc");
}
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;
if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`,`ip` From monitor  where `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory')order by `Date Logged on` desc, `Time Logged On` desc $limit"); 
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`,`ip` From monitor order by `Date Logged on` desc, `Time Logged On` desc $limit"); 
} 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>

<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
<?php

  }
  else if (trim($cmbFilter)=="User Category")
  {  
if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` WHERE `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') and `User Category` like '" . $filter . "%' order by `Date Logged On` Desc, `Time Logged On` desc");
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
  $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` WHERE `User Category` like '" . $filter . "%' order by `Date Logged On` Desc, `Time Logged On` desc");
}
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;

if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`, `ip` From `monitor` WHERE `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') and `User Category` like '" . $filter . "%' order by `Date Logged On` Desc, `Time Logged On` desc $limit");   
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`, `ip` From `monitor` WHERE `User Category` like '" . $filter . "%' order by `Date Logged On` Desc, `Time Logged On` desc $limit");   
} 
  
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>

<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
<?php

  }
  else if (trim($cmbFilter)=="User Name")
  {  
   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` WHERE `User Name` like '" . $filter . "%' order by `Date Logged On` Desc, `Time Logged On` desc");
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;

   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`, `ip` From `monitor` WHERE `User Name` like '" . $filter . "%' order by `Date Logged On` Desc, `Time Logged On` desc $limit");
  
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>

<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
<?php

  }
  else if (trim($cmbFilter)=="Date Logged")
  {  
if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` WHERE `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') and `Date Logged On`='" . $filter . "' order by `Date Logged On` Desc, `Time Logged On` desc");
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` WHERE `Date Logged On`='" . $filter . "' order by `Date Logged On` Desc, `Time Logged On` desc");
}
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;

if ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 44 or $_SESSION['access_lvl'] == 444) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`, `ip` From `monitor` WHERE `User Category` not in ('HMO Head','Account Head','HR Head','HMO Supervisory') and `Date Logged On`='" . $filter . "' order by `Date Logged On` Desc, `Time Logged On` desc $limit");
}
else if ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1) 
{
   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`, `ip` From `monitor` WHERE `Date Logged On`='" . $filter . "' order by `Date Logged On` Desc, `Time Logged On` desc $limit");
}  
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>

<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
<?php

  }
  else if (trim($cmbFilter)=="Delete All")
  {  
   $query_d = "Delete From `monitor`";
   $result_d= mysqli_query($conn,$query_d);

   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` order by `Date Logged on` desc, `Time Logged On` desc");
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;

   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`, `ip` From monitor order by `Date Logged on` desc, `Time Logged On` desc $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>
<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
<?php

#######
require_once 'time.php';

$sql_log = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
$result_log = mysqli_query($conn,$sql_log) or die('Could not fetch data; ' . mysqli_error());
$row_log = mysqli_fetch_array($result_log);

$query_insert_Log = "Insert into `monitor` (`ip`,`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
VALUES ('" . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "/" . gethostbyname($_SERVER['REMOTE_ADDR']) . "','" . $row_log['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . $gmdatex . "','System Log','Logs deleted for category: $filter')";

$result_insert_Log = mysqli_query($conn,$query_insert_Log) or die(mysqli_error());
###### 
  }
  else if (trim($cmbFilter)=="Delete by Category")
  {  
   $query_d = "Delete From `monitor` WHERE `User Category`='" . $filter . "'";
   $result_d= mysqli_query($conn,$query_d);

   $query_count    = mysqli_query($conn,"SELECT * FROM `monitor` order by `Date Logged on` desc, `Time Logged On` desc");
 $nr  = mysqli_num_rows($query_count);

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}

//This is where we set how many database items to show on each page
$itemsPerPage = 35;

// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}

// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '">' . $add1 . '</a> &nbsp;';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;

   $result = mysqli_query ($conn,"SELECT `User Category`, `User Name` , `Date Logged On`, `Time Logged On`,`File Used`,`Details`, `ip` From monitor order by `Date Logged on` desc, `Time Logged On` desc $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&filter=' . $filter . '&cmbFilter=' . $cmbFilter . '"> Next</a> ';
    }
}

echo '<div class="blocCat">';
  while(list($cat, $name,$datel, $timel, $fileu, $det, $ip)=mysqli_fetch_row($result)) 
   {
     echo '	
        <div class="tech-row"> 
        <div class="tech-value">' .$cat. '</div>
        <div class="tech-value">' .$name. '</div>
        <div class="tech-value">' .$datel. '</div>
        <div class="tech-value">' .$timel. '</div>
        <div class="tech-value">' .$fileu. '</div>
        <div class="tech-value">' .$det. '</div>
        <div class="tech-value">' .$ip. '</div>
      </div>';
   }
    echo "</div>";
?>

<style type="text/css">
<!--
.pagNumActive {
    color: #000;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>

      <div style="margin-left:1px; margin-right:1px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div>
<?php

#######
require_once 'time.php';

$sql_log = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
$result_log = mysqli_query($conn,$sql_log) or die('Could not fetch data; ' . mysqli_error());
$row_log = mysqli_fetch_array($result_log);

$query_insert_Log = "Insert into `monitor` (`ip`,`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
VALUES ('" . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "/" . gethostbyname($_SERVER['REMOTE_ADDR']) . "','" . $row_log['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . $gmdatex . "','System Log','Logs deleted for category: $filter')";

$result_insert_Log = mysqli_query($conn,$query_insert_Log) or die(mysqli_error());
###### 
  }
?>
</div>

<p align="center">
<?php
 echo "<a target='blank' href='rptsyslog.php?cmbFilter=$cmbFilter&filter=$filter'> Print this List</a> &nbsp;";
# echo " || <a href='expretirement.php'> Export this List</a> &nbsp; ";
?>
</p>

<p align="right" style="margin-right:20px; margin-top:30px">
 <span class="style2"><font face="Arial" color="#666666">
&copy 2011-<?php echo date('Y'); ?> <a target="_blank" href="http://www.waltergates.com">
    <font color="#666666">Waltergates</font></a></font></span></p>

	</div>
</div>
