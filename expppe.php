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

 $filename = "ppe_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>
<table width='450'>
<tr><td width='260'><font style='font-size: 14pt'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td colspan=1 width='260'><h2><left>PROPERTY, PLANT and EQUIPMENT REPORT</left></h2></td></tr>
</table>
<div align="left">

<table border="0" width="85%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr align='left'>
 <td>
     <h4><left>FROM: <font color='red'><?php echo date('d F, Y',strtotime($filter)); ?></font> TO <font color='red'><?php echo date('d F, Y',strtotime($filter2)); ?></font> </left></h4>
 </td>
</tr>

<tr><td align="right">
<TABLE width='99%' border='1' cellpadding='0' cellspacing='0' align='center' id="table3">
<?php
   $limit      = 50; 
   @$page=$_GET['page'];
   $query_count    = "SELECT * FROM `heads` where `Category` in ('PROPERTY AND EQUIPMENT')";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  
$yr1=date('Y', strtotime($filter));
$yr2=$yr1-1;
   echo " <tr><font face='Verdana' color='#000000' style='font-size: 11pt'><b> </b></font></tr>";
   echo "<TR bgcolor='#C0C0C0'><TH><b> </TH><TH colspan=1><b> Plant & Machinery</TH><TH colspan=1><b> Furniture & Fittings</TH><TH colspan=1><b> Computer Equipment</TH><TH colspan=1><b> Motor Vehicle</TH><TH colspan=1><b> Office Equipment</TH><TH colspan=1><b> Total</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT distinct `Category`,`Remarks` FROM `heads` where `Category` in ('PROPERTY AND EQUIPMENT') LIMIT $limitvalue, $limit"); 
 
   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

$ttt=0;
$ttt2=0;
$ttt3=0;
$ttt4=0;
$ttt5=0;

    while(list($cat,$rm)=mysqli_fetch_row($result)) 
    {	

      echo "<TR align='center' bgcolor='#dcdfdf' colspan=1><font face='Verdana' color='#ccffff' style='font-size: 12pt'><TH width='40%'>" . $rmm . strtoupper($cat) . "</TH></font><TH colspan=6 width='30%'></TH></TR>";

       $sqlt="SELECT sum(`Amount`) as amount1 FROM `cash` where `Classification` in ('Heavy Equipment', 'Plant and Machinery') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
       $amtt=$rowt['amount1'];
 
       $sqlt2="SELECT sum(`Amount`) as amount2 FROM `cash` where `Classification` in ('Furniture and Fixture','Furniture and Fittings') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt2 = mysqli_query($conn,$sqlt2) or die('Could not look up user data; ' . mysqli_error());
       $rowt2 = mysqli_fetch_array($resultt2);
       $amtt2=$rowt2['amount2'];

       $sqlt3="SELECT sum(`Amount`) as amount3 FROM `cash` where `Classification` in ('Computer and other Equipment','Computer Equipment') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt3 = mysqli_query($conn,$sqlt3) or die('Could not look up user data; ' . mysqli_error());
       $rowt3 = mysqli_fetch_array($resultt3);
       $amtt3=$rowt3['amount3'];

       $sqlt4="SELECT sum(`Amount`) as amount4 FROM `cash` where `Classification` in ('Vehicles','Motor Vehicle') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt4 = mysqli_query($conn,$sqlt4) or die('Could not look up user data; ' . mysqli_error());
       $rowt4 = mysqli_fetch_array($resultt4);
       $amtt4=$rowt4['amount4'];

       $sqlt5="SELECT sum(`Amount`) as amount5 FROM `cash` where `Classification` in ('Office Equipment') and `Date` between '$filter' and '$filter2' group by `Classification`";
       $resultt5 = mysqli_query($conn,$sqlt5) or die('Could not look up user data; ' . mysqli_error());
       $rowt5 = mysqli_fetch_array($resultt5);
       $amtt5=$rowt5['amount5'];

       $amount=$amtt1+$amtt2+$amtt3+$amtt4+$amtt5;

       $ttt=$ttt+$amtt1;
       $ttt2=$ttt2+$amtt2;
       $ttt3=$ttt3+$amtt3;
       $ttt4=$ttt4+$amtt4;
       $ttt5=$ttt5+$amtt5;
       $AMOUNT=$ttt+$ttt2+$ttt3+$ttt4+$ttt5;

       $amtt1=number_format($amtt1,2);
       $amtt2=number_format($amtt2,2);
       $amtt3=number_format($amtt3,2);
       $amtt4=number_format($amtt4,2);
       $amtt5=number_format($amtt5,2);
       $amount=number_format($amount,2);

       echo "<TR align='left'><TH>Balance at $filter </TH><TH align='right'>$amtt1</TH><TH align='right'>$amtt2</TH><TH align='right'>$amtt3</TH><TH align='right'>$amtt4</TH><TH align='right'>$amtt5</TH><TH align='right'>$amount</TH></TR>";
       echo "<TR align='left'><TH>Derecognition </TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH></TR>";
       echo "<TR align='left'><TH>Revaluation </TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH></TR>";
       echo "<TR align='left'><TH>Additions </TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH></TR>";
       echo "<TR align='left'><TH>Disposals </TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH><TH align='right'></TH></TR>";
     }
     echo "<TR><TH colspan='3'></TH></TR>";
 
   $tt=number_format($ttt,2);
   $tt2=number_format($ttt2,2);
   $tt3=number_format($ttt3,2);
   $tt4=number_format($ttt4,2);
   $tt5=number_format($ttt5,2);
   $AMOUNT=number_format($AMOUNT,2);

  echo "<TR><TH bgcolor='#C0C0C0' colspan='1' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tt</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tt2</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tt3</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tt4</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $tt5</b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $AMOUNT</b></font></TH></TR>";

 ?>
</TABLE>
</fieldset>
</td></tr>
	</table>


</div>

