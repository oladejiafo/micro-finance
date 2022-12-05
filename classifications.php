<?php
#session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2) & ($_SESSION['access_lvl'] != 1) & ($_SESSION['access_lvl'] != 4) & ($_SESSION['access_lvl'] != 3))
{
 if ($_SESSION['access_lvl'] != 5){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 1; URL=index.php?redirect=$redirect");
}
}

 require_once 'conn.php';

@$acctno=$_REQUEST['acctno'];
@$id=$_REQUEST['id'];
@$tval=$_REQUEST['tval'];
?>
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<!-- 	
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.css" />
   <link rel="shortcut icon" href="favicon.ico">
-->
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%Y-%m-%d"

		});
		new JsDatePick({
			useMode:2,
			target:"inputFieldB",
			dateFormat:"%Y-%m-%d"

		});
	};
</script>


<div align="center">

<form  action="report.php" method="POST">
<span>
  <select name="cmbFilter" placeholder="Select Classification to filter">  
          <option selected>- Select Classification to Filter -</option>
          <?php  
#           echo '<option selected>' . $cmbFilter . '</option>';
           $sql = "SELECT * FROM `heads` where `Description` not like '%Cash%'";
           $result_hd = mysqli_query($conn,$sql) or die('Could not list value; ' . mysqli_error());
           while ($rows = mysqli_fetch_array($result_hd)) 
           {
             echo '<option>' . $rows['Description'] . '</option>';
           }
          ?> 
         </select>
   <input type="hidden" name="cmbReport" size="12" value="Classifications Reports">
 </span>
 <span>
  <input type="text" name="filter" id="inputField" placeholder="Date range 1">
 </span>
 <span>
  <input type="text" name="filter2" id="inputFieldB" placeholder="Date range 2">
 </span>
 <span> 
     <input type="submit" value="Generate" name="submit">
 </span>

</form>
</div>

 <div> 
<h2><font face='Verdana' color='#000000' style='font-size: 13pt'><b>Classifications Reports</b></left></font></h2>
</div>

 <?php
 @$tval=$_GET['tval'];
 $limit      = 50;
 @$page=$_GET['page'];

 @$cmbFilter=$_REQUEST["cmbFilter"];
 @$filter=$_REQUEST["filter"];
 @$filter2=$_REQUEST["filter2"];
 if ($filter=="" or $filter2=="" or empty($filter) or empty($filter2))
 {
   $filter='2010-01-01';
   $filter2='2020-12-31';
 }
 
  if ($cmbFilter=="" or $cmbFilter=="- Select Classification to Filter -" or empty($cmbFilter))
  {  
   $query_count = "SELECT * FROM `cash`";
  } else { 

   $query_count = "SELECT * FROM `cash` WHERE `Classification` = '" . $cmbFilter . "' and `Date` between '$filter' and '$filter2'";
  }
  $result_count   = mysqli_query($conn,$query_count);     
  $totalrows  = mysqli_num_rows($conn,$result_count);

  if ($cmbFilter=="" or $cmbFilter=="- Select Classification to Filter -" or empty($cmbFilter))
  {
  
  } else {  
   echo "<div align='center'><b><font color='#FF0000' style='font-size: 10pt'>" . $cmbFilter . " between " . $filter . " and " . $filter2 . "</font></b></div>";
  }
 ?>
  <div class="tab-row" style="font-weight:bold">
    <div  class="cell"  style='width:25%; background-color:#cbd9d9'><b>Date </b></div>
    <div  class="cell" style='width:25%; background-color:#cbd9d9'><b>Particulars</b></div>
    <div  class="cell" style='width:25%; background-color:#cbd9d9'><b>Amount </b></div>
    <div  class="cell" style='width:25%; background-color:#cbd9d9'><b>Type</b></div>
  </div>
<?php
  if ($cmbFilter=="" or $cmbFilter=="- Select Classification to Filter -" or empty($cmbFilter))
  {  
   $query = "SELECT `ID`,`Date`,`Particulars`,`Classification`,`Amount`,`Type` FROM `cash` order by `ID` desc";
  }
  else
  {  
   if ($filter=="" or $filter2=="" or empty($filter) or empty($filter2))
   {
     $filter='2010-01-01';
     $filter2='2020-12-31';
   }
   $query = "SELECT `ID`,`Date`,`Particulars`,`Classification`,`Amount`,`Type` FROM `cash` WHERE `Classification` = '" . $cmbFilter . "' and `Date` between '$filter' and '$filter2'";
  }
   $resultp=mysqli_query($conn,$query);

$samt =0; 
$i=0;
    while(list($id,$date,$part,$clas,$amt,$typ)=mysqli_fetch_row($resultp))
    {
      $i=$i+1;
      $samt=$samt+$amt;
      $amount=number_format($amt,2);
     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:25%">' .$date . '</div>
        <div  class="cell" style="width:25%">' .$part. '</div>
        <div  class="cell" style="width:25%">' .$amount. '</div>
        <div  class="cell" style="width:25%">' .$typ. '</div>
      </div>';
    }
    @$samount=number_format($samt,2);

     echo '	
        <div class="tab-row"> 
        <div  class="cell" style="width:50%">TOTAL</div>
        <div  class="cell" style="width:25%">' .$samount. '</div>
        <div  class="cell" style="width:25%">&nbsp;</div>
      </div>';
?>
</div>

<div align="center">
<?php
echo "<a target='blank' href='rptclassifications.php?cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2'> Print this Report</a> &nbsp;";
echo "| <a target='blank' href='expclassifications.php?cmbFilter=$cmbFilter&filter=$filter&filter2=$filter2'> Export this Report</a> &nbsp; ";
?>
</div>
</div>
