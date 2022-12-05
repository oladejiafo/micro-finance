<?php
session_start();

 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
$addy=$rw['Address'];
$phn=$rw['Phone'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

 $filename = "PnL_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>
<table width='450'>
<tr><td width='260'><font style='font-size: 14pt'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td colspan=1><h2><left>PROFIT & LOSS REPORT</left></h2></td></tr>
</table>
<div align="left">

<table border="0" width="85%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='left'>
 <td>
     <h4><left>FROM: <font color='red'><?php echo date('d F, Y',strtotime($filter)); ?></font> TO <font color='red'><?php echo date('d F, Y',strtotime($filter2)); ?></font> </left></h4>
 </td>
</tr>

<tr><td align="right">
<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#ccCCcc" id="table2">
 <?php
   $limit      = 50; 
   $page=$_GET['page'];
   $query_count    = "SELECT * FROM `heads` where `Category` not in ('Fixed Assets','Current Assets','Current Liabilities')";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  

   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> </b></font></tr>";
   echo "<TR bgcolor='#C0C0C0'><TH><b> Description</TH><TH><b> Amount</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT distinct `Category` FROM `heads` where `Category` not in ('Fixed Assets','Current Assets','Current Liabilities') LIMIT $limitvalue, $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$ttt=0;
    while(list($cat)=mysqli_fetch_row($result)) 
    {	
      echo "<TR align='center' bgcolor='#dcdfdf' colspan=2><font face='Verdana' color='#ccffff' style='font-size: 12pt'><TH width='50%'>" . strtoupper($cat) . "</TH></font><TH width='25%'></TH></TR>";
      $result2 = mysqli_query ($conn,"SELECT `Description`,`Category` FROM `heads` where `Category`= '$cat' LIMIT $limitvalue, $limit"); 
      while(list($descr,$cat1)=mysqli_fetch_row($result2)) 
      {	
       $sqlt="SELECT sum(`Amount`) as amount FROM `cash` where `Classification`='$descr' and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
     
       $amtt=$rowt['amount'];
       if ($amtt==0) { $amtt=0;}
       $ttt=$amtt+$ttt;
       $amtt=number_format($amtt,2);
       echo "<TR align='left'><TH>$descr </TH><TH align='right'>$amtt</TH></TR>";
      }
    }
   echo "<TR><TH colspan='2'></TH></TR>";
 
   $tt=number_format($ttt,2);
   echo "<TR><TH bgcolor='#C0C0C0' colspan='1' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tt</b></font></TH></TR>";

?>
</table>
</fieldset>
</td></tr>
	</table>


</div>

