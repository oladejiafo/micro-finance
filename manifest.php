<?php
define('SQL_HOST','localhost');
define('SQL_USER','root');
define('SQL_PASS','');
define('SQL_DB','pyramid');
$connection = mysql_connect(SQL_HOST,SQL_USER,SQL_PASS) or die('Could not connect to the database; ' . mysql_error());

$table_name='bol';

$db=mysql_select_db(SQL_DB,$connection) or die('Could not select database; ' . mysql_error());
$query="select * from " . $table_name;
$result=mysql_query($query, $connection) or die("coud not complete database query");
$num=mysql_num_rows($result);
$file="images/results.xml";
if($num !=0)
{
 $file=fopen($file,"w");
 $_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";
 $_xml .="<site>\r\n";

 while($row=mysql_fetch_array($result))
 {
  if ($row["Registry_number"])
  {
   $_xml .="\t<page title=\"" . $row["Registry_number"] . "\">\r\n";
   $_xml .="\t\t<file>" . $row["Bol_reference"] . "</file>\r\n";
   $_xml .="\t</page>\r\n";
  } else {
   $_xml .="\t<page title=\"Nothing Returned\">\r\n";
   $_xml .="\t\t<file>none</file>\r\n";
   $_xml .="\t</page>\r\n";
  }
 }
 $_xml .="</site>";   

 fwrite($file,$_xml);
 fclose($file);

 echo "XML has been written. <a href=\"images/results.xml\">View the XML</a>";
} else {
 echo "No record found";
}
?>