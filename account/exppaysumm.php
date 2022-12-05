<?php
 require_once 'conn.php';

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];

 function cleanData(&$str) 
 {
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\n/", "\\n", $str);
 } 

 $filename = "pyments_" . date('Ymd') . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
 $flag = false; 

$query="SELECT `Contract Date`,`Contractor`,`Contract Title`,(`Amount`-`Amount Paid`) as PendingAmt,`Amount Paid`,`Paid`,`Bank`,(`Account`) as AccountNumber,`Remark` FROM `contract` WHERE `Paid`='Unpaid' union SELECT `Date`,`Type`,`Recipient`,`Amount`,0,`Paid`,`Bank`,(`Account`) as AccountNumber,`Remark` FROM `cash` WHERE `Paid`='Unpaid'";
$result=mysqli_query($conn,$query);

#$query2="SELECT `ID`,`Date`,`Type`,`Recipient`,`Amount`,`Paid`,`Remark` FROM `cash` WHERE `Paid`='Unpaid' order by `Date` desc";


 while(false !== ($row = mysqli_fetch_assoc($result))) 
  { 
   if(!$flag) 
   { 
    # display field/column names as first row 
    echo implode("\t", array_keys($row)) . "\n"; 
    $flag = true; 
   } 
   array_walk($row, 'cleanData'); 
   echo implode("\t", array_values($row)) . "\n"; 
  }

?>