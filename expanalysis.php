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

 $filename = "analysis_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
?>
<table width='450'>
<tr><td width='260'><font style='font-size: 15pt; color: red'><b><?php echo $coy; ?></b></font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $addy; ?></b>
</font></td></tr>
<tr><td width='260'><font style='font-size: 13pt'><b><?php echo $phn; ?></b>
</font></td></tr>
<tr><td  width='400' colspan=2><h2><left>ANALYSIS REPORT</left></h2></td></tr>
</table>

<div align="left">
<table border="0" width="85%" cellspacing="1" bgcolor="#FFFFFF" id="table1">
<tr>
	<td>

<?php
 @$filter = $_REQUEST["filter"];
 @$filter2 = $_REQUEST["filter2"];

#############
   $query_delete ="delete from `analysis`";
   $result_delete = mysqli_query($conn,$query_delete) or die(mysqli_error());
##
   $query_insert_i ="insert into `analysis` (`iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount`) 
                     select `Source`,`Note`, `Date`,`Amount`,'-','-','-','-' from `sundry` where `Type`='Income'";
   $result_insert_i = mysqli_query($conn,$query_insert_i) or die(mysqli_error());

   $query_insert_e ="insert into `analysis` (`iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount`) 
                     select '-','-','-','-',`Source`,`Note`, `Date`,`Amount` from `sundry` where `Type`='Expenditure'";
   $result_insert_e = mysqli_query($conn,$query_insert_e) or die(mysqli_error());
###############

   echo "<TR bgcolor='#c0c0c0'><TH colspan='4'><b> INCOME </b>&nbsp;</TH><TH colspan='4'><b> EXPENDITURE</TH></TR>";
   echo "<TR bgcolor='#ccffff'><TH><b> Category </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH><TH><b> Category </b>&nbsp;</TH><TH><b> Details </b>&nbsp;</TH><TH><b> Date </b>&nbsp;</TH><TH><b> Amount </b>&nbsp;</TH></TR>";
 
   $result = mysqli_query ($conn,"SELECT `iclass`,`idetails`, `idate`, `iamount`,`eclass`,`edetails`, `edate`, `eamount` FROM `analysis`"); 

   if(mysqli_num_rows($result) == 0)
   { 
        echo("<br>Nothing to Display!<br>"); 
   } 

    while(list($iclass,$idetails,$idate,$iamount,$eclass,$edetails,$edate,$eamount)=mysqli_fetch_row($result)) 
    {	
      echo "<TR><TH>$iclass </TH><TH>$idetails</TH><TH>$idate</TH><TH align='right'>$iamount</TH><TH>$eclass </TH><TH>$edetails</TH><TH>$edate</TH><TH align='right'>$eamount</TH></TR>";
    }
   echo "<TR><TH colspan='8'></TH></TR>";

   $res = mysqli_query ($conn,"SELECT sum(`iamount`) as iamt,sum(`eamount`) as eamt From `analysis`"); 
   $rowsum = mysqli_fetch_array($res);
   $iamt=$rowsum['iamt'];
   $iamt=number_format($iamt,2);
   $eamt=$rowsum['eamt'];
   $eamt=number_format($eamt,2);
   echo "<TR><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $iamt</b></font></TH><TH colspan='3' bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b>Total </b></font></TH><TH bgcolor='#C0C0C0' align='right'><font style='font-size: 9pt'><b> $eamt</b></font></TH></TR>";

?>
</table>
</fieldset>
</td></tr>
	</table>

</div>

