<?php
session_start();

 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

$cmbReport="Loans Report";

 $filename = "Expenditure_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>
<div align="left">

<table border="0" width="95%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='center'>
 <td colspan="1" bgcolor="#ffffff"> 
     <h2><center><u><?php echo $coy; ?></u></center></h2>
     <h3><center><u>EXPENDITURE REPORT</u></center></h3>
</td>
</tr>

<tr><td align="right">
<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#ccCCcc" id="table2">
 <?php
 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

   $limit      = 50; 
   @$page=$_GET['page'];
  if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $query_count    = "SELECT * FROM `sundry` where `Date` = '" . date('Y-m-d') . "' and `Type`='Expenditure'";
  }
  else if ($cmbFilter=="All")
  {  
   $query_count    = "SELECT * FROM `sundry` where `Type`='Expenditure'";
  }
  else if ($cmbFilter=="Date Range")
  {  
   $query_count    = "SELECT * FROM `sundry` where (`Date` between '" . $filter . "' and '" . $filter2 . "') and `Type`='Expenditure'"; 
  }
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> For: $cmbFilter</b></font></tr>";
   echo "<TR bgcolor='#ccffff'><TH><b> Category </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH></TR>";

  if ($cmbFilter=="" or $cmbFilter=="Today" or empty($cmbFilter))
  {  
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Source`, `Date`,`Amount` FROM `sundry` where `Date` = '" . date('Y-m-d') . "' and `Type`='Expenditure' order by `Date` desc"); 
  }
  else if ($cmbFilter=="All")
  {
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Source`, `Date`,`Amount` FROM `sundry` where `Type`='Expenditure' order by `Date` desc");   
  }
  else if ($cmbFilter=="Date Range")
  {  
   $result = mysqli_query ($conn,"SELECT `ID`,`Type`,`Source`, `Date`,`Amount` FROM `sundry` where (`Date` between '" . $filter . "' and '" . $filter2 . "') and `Type`='Expenditure' order by `Date` desc"); 
  }

 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

   $amtt=0;
   while(list($id,$cat,$det,$date,$amt)=mysqli_fetch_row($result)) 
   {	
       $amtt=$amtt+$amt;

       $lamtt=number_format($amt,2);
       echo "<TR align='left'><TH>$cat </TH><TH>$det </TH><TH>$date </TH><TH align='right'>$lamtt </TH></TR>";
   }
   echo "<TR><TH colspan='4'></TH></TR>";
 
   $samtt=number_format($amtt,2);
   echo "<TR align='left'><TH colspan='3' bgcolor='#C0C0C0'> </TH><TH align='right' bgcolor='#C0C0C0'><font color='red'; size='3'>$samtt </font></TH></TR>";
?>
</table>
</td></tr>
	</table>

</div>

