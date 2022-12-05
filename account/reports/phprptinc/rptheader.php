<html>
<head>
	<title>Profit and Loss Report</title>
<?php if (@$sExport == "" || @$sExport == "html") { ?>
<link href="phprptcss/project1.css" rel="stylesheet" type="text/css">
<?php } ?>
<meta name="generator" content="PHP Report Maker v3.0.0.0" />
</head>
<body>
<?php if (@$sExport == "") { ?>
<script type="text/javascript">
var EW_REPORT_IMAGES_FOLDER = "phprptimages";
</script>
<script src="phprptjs/x.js" type="text/javascript"></script>
<div class="ewLayout">
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
	<div class="ewHeaderRow"><?php 

include 'connc.php';
$sqr="SELECT * FROM `company info`";
$reslt = mysql_query($sqr);
$rw = mysql_fetch_array($reslt);
$coy=$rw['Company Name'];
$ady=$rw['Address'];
$phn=$rw['Phone']; 
?>
<table>
<tr>
<td rowspan='4'>
<img src="logo.jpg" alt="" border="0" width="100" height="100" /> </td><td>
<font style='font-size: 22pt'><left> &nbsp;<b><?php echo $coy; ?></b>
</font></td></tr>
<tr><td>
<font style='font-size: 13pt'>
&nbsp;<?php echo $ady; ?>
</left></font></td></tr>
<tr><td>
<font style='font-size: 13pt'>
&nbsp;<?php echo $phn; ?>
</left></font>
</td></tr>
</table></div>
	<!-- header (end) -->
	<!-- content (begin) -->
	<!-- navigation -->
	<table cellspacing="0" class="ewContentTable">
		<tr>	

			<td class="ewContentColumn">
<?php } ?>
