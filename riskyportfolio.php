<?php
 require_once 'conn.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysql_query($sqr,$conn) or die('Could not look up user data; ' . mysql_error());
$rw = mysql_fetch_array($reslt);
$coy=$rw['Company Name'];

 @$idd=$_REQUEST["idd"];
 @$acctno=$_REQUEST["acctno"];
 @$trans=$_REQUEST["trans"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];

$cmbReport="Risky Portfolio";
?>
<div align="center">

 <div><b>
     <h3><center><u>PORTFOLIO AT RISK REPORT</u></center></h3></b>
 </div>

 <?php

   $limit      = 50; 
   @$page=$_GET['page'];
   $query_count    = "SELECT * FROM `loan` where `Balance` > 0 and `Loan Status`='Active'";
   $result_count   = mysqli_query($conn,$query_count);     
   $totalrows  = mysqli_num_rows($result_count);
   if(empty($page))
   {
     $page = 1;
   }
   $limitvalue = $page * $limit - ($limit);  
echo "<p><a href='report.php?cmbReport=Portfolio At Risk' title='View Details of all Loans'> <<< Return To Summary</a></p>";
 ?>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:12.5%; background-color:#cbd9d9'><b>Borrower Name</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Loan Amount</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Loan Type</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Disbursement Date</b></div>
    <div  class="cell"  style='width:12.5%; background-color:#cbd9d9'><b>Due Date</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Payback To-Date</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Balance Left</b></div>
    <div  class="cell" style='width:12.5%; background-color:#cbd9d9'><b>Portfolio At Risk</b></div>
  </div>
<?php
   $resultX = mysqli_query ($conn,"SELECT distinct `Loan Date`,`ID`, `Loan Duration` FROM `loan` where `Due Date` < '" . date('Y-m-d') . "' and `Balance` > 0 and `Loan Status`='Active' group by `Account Number`"); 

#   while(list($dateX,$idX,$durX)=mysqli_fetch_row($resultX)) 
   {	
   $valt="`Due Date` < '" . date('Y-m-d') . "'";
   $result = mysqli_query ($conn,"SELECT distinct `Account Number`,`ID`, `Loan Amount`, `Loan Date`, `Loan Duration`, `Payment todate`, `Balance`,`Loan Type`,`PBalance` FROM `loan` where `Balance` > 0 and `Loan Status`='Active' group by `ID`"); 

   $samtt=0;
   $sptdt=0;
   $sbalt=0;
   $spbal=0;
   while(list($acctno,$id,$lamount,$ldate,$lduration,$ptd,$bal,$ltype,$pbal)=mysqli_fetch_row($result)) 
   {
       $sqlt="SELECT `Surname`,`First Name`  FROM `customer` where `Account Number`='$acctno'";
       $resultt = mysqli_query($conn,$sqlt) or die('Could not look up user data; ' . mysqli_error());
       $rowt = mysqli_fetch_array($resultt);
     
       $sname=$rowt['Surname'];
       $fname=$rowt['First Name'];
       $name= $fname . ' ' . $sname;

       $samtt=$samtt+$lamount;
       $sptdt=$sptdt+$ptd;
       $sbalt=$sbalt+$bal;
       $spbal=$spbal+$pbal;

       $duedate=date('Y-m-d', strtotime('+' . $lduration . ' month',strtotime($ldate)));

       $pr=($pbal/$lamount)*100;
       $par=number_format($pr,2);

       $amtt=number_format($lamount,2);
       $ptdt=number_format($ptd,2);
       $balt=number_format($bal,2);

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">' .$name . '</div>
        <div  class="cell" style="width:12.5%">' .$amtt. '</div>
        <div  class="cell" style="width:12.5%">' .$ltype. '</div>
        <div  class="cell" style="width:12.5%">' .$ldate. '</div>

        <div  class="cell" style="width:12.5%">' .$duedate . '</div>
        <div  class="cell" style="width:12.5%">' .$ptdt. '</div>
        <div  class="cell" style="width:12.5%">' .$balt. '</div>
        <div  class="cell" style="width:12.5%">' .$par. '</div>
      </div>';
   }
}
 
   $samtt=number_format($samtt,2);
   $sptdt=number_format($sptdt,2);
   $sbalt=number_format($sbalt,2);

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">' .$samtt. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>

        <div  class="cell" style="width:12.5%">&nbsp;</div>
        <div  class="cell" style="width:12.5%">' .$sptdt. '</div>
        <div  class="cell" style="width:12.5%">' .$sbalt. '</div>
        <div  class="cell" style="width:12.5%">&nbsp;</div>
      </div>';
#}
?>
</div>
</fieldset>

</div>

