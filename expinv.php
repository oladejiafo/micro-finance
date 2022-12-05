<?php
 require_once 'conn.php';

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];

 function cleanData(&$str) 
 {
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\n/", "\\n", $str);
 } 

 $filename = "Inventory_" . date('Ymd') . $filter . ".xls";
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel"); 
 $flag = false; 

  if (trim(empty($cmbFilter)))
  {
   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` order by `Location`,`Category`,`Stock Code`"); 
  }
  else if (trim($cmbFilter)=="None")
  {
   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` order by `Location`,`Category`,`Stock Code`"); 
  }
  else if (trim($cmbFilter)=="Location")
  {  
   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Location`='" . $filter . "' order by `Location`,`Category`,`Stock Code`"); 
  }
  else if (trim($cmbFilter)=="Stock")
  {     
   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Stock Name`='" . $filter . "' order by `Location`,`Category`,`Stock Code`"); 
  }
  else if (trim($cmbFilter)=="Stock Category")
  {  
   $result = mysql_query ("SELECT `Stock Code`, `Stock Name` , `Category`, `Location`,`Reorder Level`,`Unit Cost`,`Units in Stock`  From `Stock` WHERE `Category`='" . $filter . "' order by `Location`,`Category`,`Stock Code`"); 
  }
  else if (trim($cmbFilter)=="Staff Number")
  {  
   $result = mysql_query ("SELECT `Staff Number`,  `Firstname` , `Surname`, `Sex`,`Present Rank`,`Barrdate`,`DoB`,`First Appt`,`Present Appt`,`State`,`LGA`,`Qualification`, `Present Location`, `Position` From `Staff`  WHERE `Staff Number` like '" . $filter . "%' order by `Level` desc,`Present Appt` desc,`staff number`"); 
  } 

 while(false !== ($row = mysql_fetch_assoc($result))) 
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