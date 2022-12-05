<?php
 require_once 'conn.php';
// require_once 'style.php';

?>
<script type="text/javascript" src="js/jquery-1.3.2.js">
	
 function display()
 {
        var msg="You have no ACCESS PRIVILEDGE to this \n";
        msg+="OR you need to LOGIN.";
        alert(msg);
 } 
 </script>

<link rel="stylesheet" type="text/css" href="main.css" />
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {font-size: 11px}
.style3 {color: #CCCCCC}
.chart {
  width: 100%; 
  min-height: 150px;
    -moz-border-radius: 30px 30px 30px 30px;
    -webkit-border-radius: 30px 30px 30px 30px;
    border-radius: 15px;
}
 .rounded-corners {
    -moz-border-radius: 30px 30px 30px 30px;
    -webkit-border-radius: 30px 30px 30px 30px;
    border-radius: 15px;
}	
 @media only screen and (max-width: 460px) {
.chart {
  width: 100%; 
  height: 50%;
}
}
-->
</style>
<div align="center">
<?php
     $sql_hmo="SELECT count(distinct `Code`) as cnt FROM `hregister`";
     $result_hmo = mysqli_query($conn,$sql_hmo) or die('Could not look up user data; ' . mysqli_error());
     $rowt = mysqli_fetch_array($result_hmo);
     $hcp=$rowt['cnt'];
     if(mysqli_num_rows($result_hmo) == 0)
     { 
      $hcp=0;
     } 
	 
     $sql_pat="SELECT count(distinct `Code`) as cnt FROM `eregister` where `Status` ='Active'";
     $result_pat = mysqli_query($conn,$sql_pat) or die('Could not look up user data; ' . mysqli_error());
     $rowp = mysqli_fetch_array($result_pat);
     $pat=$rowp['cnt'];
     if(mysqli_num_rows($result_pat) == 0)
     { 
      $pat=0;
     } 	 

     $sql_pati="SELECT count(distinct `Code`) as cnt FROM `eregister` where `Status`='Suspended'";
     $result_pati = mysqli_query($conn,$sql_pati) or die('Could not look up user data; ' . mysqli_error());
     $rowi = mysqli_fetch_array($result_pati);
     $inact=$rowi['cnt'];
     if(mysqli_num_rows($result_pati) == 0)
     { 
      $inact=0;
     } 	 	 

    $duedate=date('Y-m-d', strtotime('+1 month',strtotime(date('Y-m-d'))));
     $sql_cl="SELECT count(distinct `Code`) as cntCL FROM `client` where `Date Exited` <= '" . $duedate . "' and `Status`='Active' and `Name` not like 'Individual%'";
     $result_cl = mysqli_query($conn,$sql_cl) or die('Could not look up user data; ' . mysqli_error());
     $rowcl = mysqli_fetch_array($result_cl);
     $cl=$rowcl['cntCL'];
     if(mysqli_num_rows($result_cl) == 0)
     { 
      $cl=0;
     } 	 	 
?>
	<div class="services">
		<div class="container">
<font style="font-size:22px; font-weight:bolder; font-family:Arial, Helvetica, sans-serif; color: #CC0000">DASHBOARD</font>

				<div class="w3ls_address_mail_footer_grids">
				<div class="col-md-4 w3ls_footer_grid_left con" style="background-color:00ccff">
					<div class="wthree_footer_grid_left">
						<i><?php echo $hcp; ?></i>
					</div>
					<p><font color="#000000"  style="font-size:14px;">Hospitals Registered</font></p>
				</div>
				<div class="col-md-4 w3ls_footer_grid_left con" style="background-color:ccff99">
					<div class="wthree_footer_grid_left">
						<i><?php echo $pat; ?></i>
					</div>
					<p><font color="#000000"  style="font-size:14px;">Active Enrollees Registered</font></p>
				</div>
				<div class="col-md-4 w3ls_footer_grid_left con"  style="background-color:ff3300">
					<div class="wthree_footer_grid_left">
						<i><?php echo $inact; ?></i>
					</div>
					<p><font color="#000000"  style="font-size:14px;">Inactive Enrollees</font></p>
				</div>
				<div class="col-md-4 w3ls_footer_grid_left con" style="background-color:ffffcc">
					<div class="wthree_footer_grid_left">
						<i><?php echo $cl; ?></i>
					</div>
					<p><?php if($cl>0) { ?> <a href="clientsax.php"><font color="#FF0000"  style="font-size:14px;"> <?php } ?><font style="font-size:14px;"> Clients About To Expire!</font></a></p>
				</div>
				<div class="clearfix"> </div>
		  </div>
		</div>
<div height="25px">&nbsp;</div>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Yes or No", "Value", { role: "style" }, { role: "annotation" } ],
<?php
#   $queryY="SELECT distinct(`Code`),  `Name`,`Lives` FROM hregister order by `Status`,`Code`";
   $queryY="SELECT `Location` , count( `Code` )  FROM hregister group by `Location`";
   $resultY=mysqli_query($conn,$queryY);
$RR=0;
$dd=0;
    while(list($name,$code)=mysqli_fetch_row($resultY))
    {
      $RR=$RR+1;
      if ($RR==1 or $RR==6 or $RR==11 or $RR==16 or $RR==21 or $RR==26 or $RR==31) {$rr="Green";};
      if ($RR==2 or $RR==7 or $RR==12 or $RR==17 or $RR==22 or $RR==27 or $RR==32) {$rr="Red";};
      if ($RR==3 or $RR==8 or $RR==13 or $RR==18 or $RR==23 or $RR==28 or $RR==33) {$rr="Purple";};
      if ($RR==4 or $RR==9 or $RR==14 or $RR==19 or $RR==24 or $RR==29 or $RR==34) {$rr="Yellow";};
      if ($RR==5 or $RR==10 or $RR==15 or $RR==20 or $RR==25 or $RR==30 or $RR==35) {$rr="Blue";};

/*
     #########Principal
     $sql_p="SELECT count(distinct `Code`) as cntp FROM `eregister` WHERE `HCP Code`='" . $code . "' and `Relationship` like 'Principal' group by `HCP Code`";
     $result_p = mysqli_query($conn,$sql_p) or die('Could not look up user data; ' . mysqli_error());
     $rowp = mysqli_fetch_array($result_p);
     $principal=$rowp['cntp'];
     if(mysqli_num_rows($result_p) == 0)
     { 
      $principal=0;
     } 

     #########Enrollee
     $sql_d="SELECT count(distinct `Code`) as cntd FROM `eregister` WHERE `HCP Code`='" . $code . "' and `Relationship` not in ('Principal') group by `HCP Code`";
     $result_d = mysqli_query($conn,$sql_d) or die('Could not look up user data; ' . mysqli_error());
     $rowd = mysqli_fetch_array($result_d);
     $deps=$rowd['cntd'];
     if(mysqli_num_rows($result_d) == 0)
     { 
      $deps=0;
     } 
     $tot=$principal+$deps;
*/
$dd=$dd+$code;
if($name=="")
{
   $name="Others";
}
?>
        ["<?php echo $name; ?>", <?php echo $code; ?>, "stroke-color: #C5A5CF; stroke-width: 2; fill-color: <?php echo $rr; ?>","<?php echo $code; ?>"],
<?php
} 
?>

      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Number of HCP per STATE... Total: <?php echo $dd; ?>",
	subtitle: "<?php echo $dd; ?>",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
	chart: { subtitle: "" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);

  }
  </script>

<div class="chart" id="columnchart_values" style=" background-color:#EFEFEF; width: 95%; height: 56%;">

</div>


</div>
</div>