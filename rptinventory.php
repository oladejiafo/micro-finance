<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
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
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
?>
   <div align="center">
	<table border="0" width="990" id="table1" bgcolor="#FFFFFF">

		<tr>
			<td>
			<div align="center">
				<table border="0" width="990" id="table2">
					<tr>
						<td>
     <h1><b><center><?php echo $coy; ?> </center></b></h1>
     <h3><center><u>Inventory List</u></center></h3>

<TABLE width='990' border='1' cellpadding='1' cellspacing='1' align='center' id="table3">
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
      echo "<TR bgcolor='#999999'><TH><b>S/No </b>&nbsp;</TH><TH><b> Stock Code </b>&nbsp;</TH><TH><b> Stock Name </b>&nbsp;</TH><TH><b> Stock Category </b>&nbsp;</TH><TH><b> Location </b>&nbsp;</TH> <TH><b> Re-Order Level </b>&nbsp;</TH><TH><b> Unit Cost </b>&nbsp;&nbsp;</TH>
      <TH><b> Units In Stock </b>&nbsp;&nbsp;</TH><TH><b> Correct </b>&nbsp;&nbsp;</TH></TR>";
  if (trim(empty($cmbFilter)))
  {
   $result = mysqli_query ($conn,"SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` order by `Location`,`Category`,`Stock Code`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 
   $i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysqli_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }
  }
  else if (trim($cmbFilter)=="None")
  {
   $result = mysqli_query ($conn,"SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` order by `Location`,`Category`,`Stock Code`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 
   $i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysqli_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }
  }
  else if (trim($cmbFilter)=="Location")
  {  
   $result = mysqli_query ($conn,"SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Location`='" . $filter . "' order by `Location`,`Category`,`Stock Code`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 
   $i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysqli_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }
  }
  else if (trim($cmbFilter)=="Stock")
  {     
   $result = mysqli_query ($conn,"SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Stock Name`='" . $filter . "' order by `Location`,`Category`,`Stock Code`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 
   $i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysqli_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }
  }
  else if (trim($cmbFilter)=="Stock Category")
  {  
   $result = mysqli_query ($conn,"SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Category`='" . $filter . "' order by `Location`,`Category`,`Stock Code`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 
   $i=0;
   while(list($stockcode, $stockname,$scat, $loc, $rorder,$cost,$units)=mysqli_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $stockcode &nbsp;</TH><TH> $stockname </a> &nbsp;</TH><TH> $scat </a> &nbsp;</TH> <TH> $loc &nbsp;</TH> <TH> $rorder &nbsp;</TH><TH> $cost &nbsp;</TH>
      <TH> $units &nbsp;</TH><TH> <input type='checkbox' name='correct' width='1'> &nbsp;</TH></TR>";
   }
  }
  else if (trim($cmbFilter)=="Staff Number")
  {  
   $result = mysqli_query ($conn,"SELECT `Staff Number`,  `Firstname` , `Surname`, `Sex`,`Present Rank`,`Barrdate`,`DoB`,`First Appt`,`Present Appt`,`State`,`LGA`,`Qualification`, `Present Location`, `Position` From `Staff`  WHERE `Staff Number` like '" . $filter . "%' order by `Level` desc,`Present Appt` desc,`staff number`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 
   $i=0;
   while(list($serviceno, $fname,$sname, $sex, $rank,$bdate,$dob, $firstappt, $presentappt, $state, $lga, $qualification, $location, $pos)=mysqli_fetch_row($result)) 
   {	
      $i=$i+1;
      echo "<TR><TH>$i &nbsp;</TH><TH> $serviceno &nbsp;</TH><TH> $sname </a> &nbsp;</TH><TH> $fname </a> &nbsp;</TH> <TH> $sex &nbsp;</TH> <TH> $rank &nbsp;</TH><TH> $pos &nbsp;</TH>
      <TH> $location &nbsp;</TH><TH> $presentappt &nbsp;</TH></TR>";
   }
  } 
?>
<br>

</td>
					</tr>

				</table>
			</div>
			</td>
		</tr>

	</table>
</div>
