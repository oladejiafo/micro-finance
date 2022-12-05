<?php include "rptinc/ewcommon.php"; ?>
<?php include "rptinc/ewconfig.php"; ?>
<?php include "rptinc/phprptfn.php"; ?>
<?php include "rptinc/advsecu.php"; ?>
<?php

// PHP Report Maker 1.0 - Table level configuration (rptstock)
// Table Level Constants

define("EW_TABLE_VAR", "rptstock", TRUE);
define("EW_TABLE_GROUP_PER_PAGE", "grpperpage", TRUE);
define("EW_TABLE_SESSION_GROUP_PER_PAGE", "rptstock_grpperpage", TRUE);
define("EW_TABLE_START_GROUP", "start", TRUE);
define("EW_TABLE_SESSION_START_GROUP", "rptstock_start", TRUE);
define("EW_TABLE_SESSION_SEARCH", "rptstock_search", TRUE);
define("EW_TABLE_CHILD_USER_ID", "childuserid", TRUE);
define("EW_TABLE_SESSION_CHILD_USER_ID", "rptstock_childuserid", TRUE);

// Table Level SQL
define("EW_TABLE_REPORT_SUMMARY_TYPE", "SUM", TRUE);
define("EW_TABLE_REPORT_COLUMN_CAPTIONS", "", TRUE);
define("EW_TABLE_REPORT_COLUMN_NAMES", "", TRUE);
define("EW_TABLE_SQL_TRANSFORM", "", TRUE);
define("EW_TABLE_SQL_FROM", "`stock`", TRUE);
$EW_TABLE_SQL_SELECT = "SELECT `Stock Name` <DistinctColumnFields> FROM " . EW_TABLE_SQL_FROM;
$EW_TABLE_SQL_WHERE = "";
define("EW_TABLE_SQL_GROUPBY", "`Stock Name`", TRUE);
define("EW_TABLE_SQL_HAVING", "", TRUE);
define("EW_TABLE_SQL_ORDERBY", "`Stock Name` ASC", TRUE);
define("EW_TABLE_SQL_PIVOT", "", TRUE);
$EW_TABLE_DISTINCT_SQL_SELECT = "SELECT DISTINCT (`Category`) as Colour FROM `stock`";
$EW_TABLE_DISTINCT_SQL_WHERE = "";
$EW_TABLE_DISTINCT_SQL_ORDERBY = "`Category`";
define("EW_TABLE_SQL_USERID_FILTER", "", TRUE);
$af_ID = NULL; // Advanced filter for ID
$af_Stock_Code = NULL; // Advanced filter for Stock Code
$af_Category = NULL; // Advanced filter for Category
$af_Brand_Name = NULL; // Advanced filter for Brand Name
$af_Stock_Name = NULL; // Advanced filter for Stock Name
$af_Description = NULL; // Advanced filter for Description
$af_Manufacturer = NULL; // Advanced filter for Manufacturer
$af_Supplier = NULL; // Advanced filter for Supplier
$af_Unit_Cost = NULL; // Advanced filter for Unit Cost
$af_Expiry_Date = NULL; // Advanced filter for Expiry Date
$af_Reorder_Level = NULL; // Advanced filter for Reorder Level
$af_Units_in_Stock = NULL; // Advanced filter for Units in Stock
$af_Weight = NULL; // Advanced filter for Weight
$af_Location = NULL; // Advanced filter for Location
$af_Selling_Price = NULL; // Advanced filter for Selling Price
$af_lastrestock = NULL; // Advanced filter for lastrestock
$af_lastrecon = NULL; // Advanced filter for lastrecon
?>
<?php
$sExport = @$PHP_GET["export"]; // Load export request
if ($sExport == "html") {

	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_TABLE_VAR .'.doc');
}
?>
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record Count
$nStartGrp = 0; // Start Group
$nStopGrp = 0; // Stop Group
$nTotalGrps = 0; // Total Groups
$nGrpCount = 0; // Group Count
$nDisplayGrps = 30; // Groups per page
$nGrpRange = 10;

// Static group variables
$x_Stock_Name = NULL;
$ox_Stock_Name = NULL;
$tx_Stock_Name = NULL;
$gx_Stock_Name = NULL;
$ftx_Stock_Name = 200;
$rf_Stock_Name = NULL;
$rt_Stock_Name = NULL;

// Column variables
$ftx_Category = 200;
$rf_Category = NULL;
$rt_Category = NULL;
?>
<?php

// Open connection to the database
$conn = php_connect(HOST, USER, PASS, DB, PORT);

// Filter
$sFilter = "";
$bFilterApplied = FALSE;

// Reset
ResetCmd();

// Set up groups per page dynamically
SetUpDisplayGrps();

// Popup selected values
// Setup selection

SetupSelection();

// Load columns to array
GetColumns();

// Default Filter, Sort
$defaultFilter = ""; // Default filter string
$defaultSort = ""; // default sort string
if ($defaultFilter <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= $defaultFilter;
}

// Build sql
$sSql = ew_BuildReportSql(EW_TABLE_SQL_TRANSFORM, $EW_TABLE_SQL_SELECT, $EW_TABLE_SQL_WHERE, EW_TABLE_SQL_GROUPBY, "", EW_TABLE_SQL_ORDERBY, EW_TABLE_SQL_PIVOT, $sFilter, @$sSort);

// Load recordset
$rs = ew_LoadRs($sSql);
$rscnt = count($rs);
$row = FALSE;
$rsidx = 0;

// Set up total group count and distinct values
InitReportData($rs);
if ($nDisplayGrps <= 0) { // Display All Records
	$nDisplayGrps = $nTotalGrps;
}
$nStartGrp = 1;
SetUpStartGroup(); // Set Up Start Group Position
?>
<?php include "rptinc/header.php"; ?>
<?php if (@$sExport == "") { ?>
<script language="JavaScript" src="rptjs/x/x_core.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/x/x_event.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/x/x_drag.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/popup.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/ewrptpop.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/swfobject.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
var EW_POPUP_ALL = "(All)";
var EW_POPUP_OK = "  OK  ";
var EW_POPUP_CANCEL = "Cancel";
var EW_POPUP_FROM = "From";
var EW_POPUP_TO = "To";
var EW_POPUP_PLEASE_SELECT = "Please Select";
var EW_POPUP_NO_VALUE = "No value selected!";
var EW_POPUP_CLASSNAME = "phpreportmaker";

// popup fields
//-->

</script>
<!-- Table container (begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top container (begin) -->
<tr><td align="center" colspan="3" class="ewPadding"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="rptstockctb.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="rptstockctb.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="rptstockctb.php?export=word">Export to Word</a>
<?php } ?>
<br><br>
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top container (end) -->
<tr>
	<!-- Left container (begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- left slot -->
	</div></td>
	<!-- Left container (end) -->
	<!-- Center container (report) (begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- crosstab report starts -->
<div id="report_crosstab">
<!-- Report grid (begin) -->
<table id="ewReport" class="ewTable">
	<!-- Table header -->
	<tr class="ewTableRow">
		<td colspan="1" nowrap><div class="phpreportmaker">&nbsp;</div></td>
		<td class="ewRptColHeader" colspan="<?php echo @$ncolspan; ?>" nowrap>
			COLOUR
		</td>
	</tr>
	<tr>
		<td class="ewRptGrpHeader1">
			Stock Name
		</td>
<!-- Dynamic columns begin -->
	<?php
	for ($iy = 1; $iy < count($val); $iy++) {
		if ($col[$iy][2]) {
			$x_Category = $col[$iy][1];
	?>
		<td class="ewTableHeader" valign="top">
<?php echo $x_Category ?>
</td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
		<?php $x_Category = "Total"; ?>
		<td class="ewTableHeader" valign="top">
<?php echo $x_Category ?>
</td>
	</tr>
<?php
if ($nTotalGrps > 0) {

// Start group <= total number of groups
if (intval($nStartGrp) > intval($nTotalGrps)) {
	$nStartGrp = $nTotalGrps;
}

// Set the last group to display
$nStopGrp = $nStartGrp + $nDisplayGrps - 1;

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps)) {
	$nStopGrp = $nTotalGrps;
}

// navigate
$grpvalue = "";
$nRecCount = 0;

// Get first row
if ($rscnt > 0) {
	GetRow(1);
	$nGrpCount = 1;
}
while ($row) {

	// Process groups
	if (intval($nGrpCount) >= intval($nStartGrp) && $nGrpCount <= $nStopGrp) {
		$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1) {
			$sItemRowClass = " class=\"ewTableAltRow\"";
		}

		// Show group values
		$gx_Stock_Name = $x_Stock_Name;
		if ($x_Stock_Name <> "" && $ox_Stock_Name == $x_Stock_Name && !ChkLvlBreak(1)) {
			$gx_Stock_Name = "";
		} elseif ($x_Stock_Name == NULL) {
			$gx_Stock_Name = EW_NULL_LABEL;
		} elseif ($x_Stock_Name == "") {
			$gx_Stock_Name = EW_EMPTY_LABEL;
		}
?>
	<!-- Data -->
	<tr<?php echo $sItemRowClass; ?>>
		<!-- Stock Name -->
		<td class="ewRptGrpField1"><?php $tx_Stock_Name = $x_Stock_Name; $x_Stock_Name = $gx_Stock_Name; ?>
<?php echo $x_Stock_Name ?>
<?php $x_Stock_Name = $tx_Stock_Name; ?></td>
<!-- Dynamic columns begin -->
	<?php
	$rowsmry = 0;
	for ($iy = 1; $iy < count($val); $iy++) {
		if ($col[$iy][2]) {
			$rowval = $val[$iy];
			$rowsmry = ew_SummaryValue($rowsmry, $rowval, EW_TABLE_REPORT_SUMMARY_TYPE);
			$x_Units_in_Stock = $val[$iy];
	?>
		<!-- <?php echo $col[$iy][1]; ?> -->
		<td>
<?php echo $x_Units_in_Stock ?>
</td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	<?php $x_Units_in_Stock = $rowsmry; ?>
		<td>
<?php echo $x_Units_in_Stock ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();
	}

	// Accumulate grand summary
	AccumulateGrandSummary();

	// Save old group values
	$ox_Stock_Name = $x_Stock_Name;

	// Get next record
	GetRow(2);
	if (intval($nGrpCount) >= intval($nStartGrp) && $nGrpCount <= $nStopGrp) {
?>
<?php
	}

	// Increment group count
	if (ChkLvlBreak(1)) $nGrpCount++;
}
?>
	<!-- Grand Total -->
	<tr class="ewRptGrandSummary">
	<td colspan="1">Grand Total</td>
<!-- Dynamic columns begin -->
	<?php 
	$rowsmry = 0;
	for ($iy = 1; $iy <= $ncol; $iy++) {
		if ($col[$iy][2]) {
			$rowval = $grandsmry[$iy];
			$rowsmry = ew_SummaryValue($rowsmry, $rowval, EW_TABLE_REPORT_SUMMARY_TYPE);
			$x_Units_in_Stock = $grandsmry[$iy];
	?>
		<!-- <?php echo $col[$iy][1]; ?> -->
		<td>
<?php echo $x_Units_in_Stock ?>
</td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	<?php $x_Units_in_Stock = $rowsmry; ?>
		<td>
<?php echo $x_Units_in_Stock ?>
</td>
	</tr>
<?php } ?>
</table>
<br>
<?php if (@$sExport == "") { ?>
<form action="rptstockctb.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php
if ($nTotalGrps > 0) {
	$rsEof = ($nTotalGrps < ($nStartGrp + $nDisplayGrps));
	$PrevStart = $nStartGrp - $nDisplayGrps;
	if ($PrevStart < 1) { $PrevStart = 1; }
	$NextStart = $nStartGrp + $nDisplayGrps;
	if ($NextStart > $nTotalGrps) { $NextStart = $nStartGrp ; }
	$LastStart = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
	?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($nStartGrp == 1) { ?>
	<td><img src="rptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="rptstockctb.php?start=1"><img src="rptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($PrevStart == $nStartGrp) { ?>
	<td><img src="rptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="rptstockctb.php?start=<?php echo $PrevStart; ?>"><img src="rptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" value="<?php echo intval(($nStartGrp-1)/$nDisplayGrps+1); ?>" size="4"></td>
<!--next page button-->
	<?php if ($NextStart == $nStartGrp) { ?>
	<td><img src="rptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="rptstockctb.php?start=<?php echo $NextStart; ?>"><img src="rptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>
	<?php  } ?>
<!--last page button-->
	<?php if ($LastStart == $nStartGrp) { ?>
	<td><img src="rptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="rptstockctb.php?start=<?php echo $LastStart; ?>"><img src="rptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo intval(($nTotalGrps-1)/$nDisplayGrps+1);?></span></td>
	</tr></table>
	<?php if ($nStartGrp > $nTotalGrps) { $nStartGrp = $nTotalGrps; }
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
	$nGrpCount = $nTotalGrps - 1;
	if ($rsEof) { $nGrpCount = $nTotalGrps; }
	if ($nStopGrp > $nGrpCount) { $nStopGrp = $nGrpCount; } ?>
	<span class="phpreportmaker"> <?php echo $nStartGrp; ?> to <?php echo $nStopGrp; ?> of <?php echo $nTotalGrps; ?></span>
<?php } else { ?>
	<span class="phpreportmaker"></span>	
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
<select name="<?php echo EW_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="1"<?php if ($nDisplayGrps == 1) echo " selected" ?>>1</option>
<option value="2"<?php if ($nDisplayGrps == 2) echo " selected" ?>>2</option>
<option value="3"<?php if ($nDisplayGrps == 3) echo " selected" ?>>3</option>
<option value="4"<?php if ($nDisplayGrps == 4) echo " selected" ?>>4</option>
<option value="5"<?php if ($nDisplayGrps == 5) echo " selected" ?>>5</option>
<option value="10"<?php if ($nDisplayGrps == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($nDisplayGrps == 20) echo " selected" ?>>20</option>
<option value="30"<?php if ($nDisplayGrps == 30) echo " selected" ?>>30</option>
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
<option value="ALL"<?php if (@$PHP_SESSION[EW_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All Records</option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
</div>
<!-- Crosstab report ends -->
<?php if (@$sExport == "") { ?>
	</div><br></td>
	<!-- Center container (report) (end) -->
	<!-- Right container (begin) -->
	<td valign="top"><div id="ewRight" class="phpreportmaker">
	<!-- right slot -->
	</div></td>
	<!-- Right container (end) -->
</tr>
<!-- Bottom container (begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- bottom slot -->
	</div><br></td></tr>
<!-- Bottom container (end) -->
</table>
<!-- Table container (end) -->
<?php } ?>
<?php

// Close recordset and connection
php_free_result($rs);
php_close($conn);
?>
<?php include "rptinc/footer.php"; ?>
<?php

// Get column values
function GetColumns() {
	global $EW_TABLE_SQL_SELECT, $EW_TABLE_DISTINCT_SQL_SELECT;
	global $EW_TABLE_DISTINCT_SQL_WHERE, $EW_TABLE_DISTINCT_SQL_ORDERBY;
	global $sFilter, $sSort;
	global $sel_Category;	
	global $row, $ncol, $col, $val, $oval, $cnt, $smry, $grandsmry;
	global $ncolspan;

	// Build sql
	$sSql = ew_BuildReportSql("", $EW_TABLE_DISTINCT_SQL_SELECT, $EW_TABLE_DISTINCT_SQL_WHERE, "", "", $EW_TABLE_DISTINCT_SQL_ORDERBY, "", $sFilter, $sSort);

	// Load recordset
	$rscol = ew_LoadRs($sSql);

	// Get distinct column count
	$ncol = count($rscol);
	if ($ncol == 0) {
		php_free_result($rscol);
		echo "No distinct column values for sql: " . $sSql . "<br>";
		exit();
	}

	// 1st dimension = no of groups (level 0 used for grand total)
	// 2nd dimension = no of distinct values

	$nGrps = 1;
	$col = ew_Init2DArray($ncol+1, 2, NULL);
	$val = ew_InitArray($ncol+1, NULL);
	$oval = ew_InitArray($ncol+1, NULL);
	$cnt = ew_Init2DArray($ncol+1, $nGrps+1, NULL);
	$smry = ew_Init2DArray($ncol+1, $nGrps+1, NULL);
	$grandsmry = ew_InitArray($ncol+1, NULL);

	// Reset summary values
	ResetLevelSummary(0);
	$colcnt = 0;
	foreach ($rscol as $row) {
		if ($row[0] == NULL) {
			$wrkValue = "##null";
			$wrkCaption = EW_NULL_LABEL;
		} elseif ($row[0] == "") {
			$wrkValue = "##empty";
			$wrkCaption = EW_EMPTY_LABEL;
		} else {
			$wrkValue = $row[0];
			$wrkCaption = $row[0];
		}
		$colcnt++;
		$col[$colcnt][0] = $wrkValue; // value
		$col[$colcnt][1] = $wrkCaption; // caption
		$col[$colcnt][2] = TRUE; // column visible
	}
	php_free_result($rscol);

	// Rebuild SQL
	$sSqlFlds = "";
	for ($colcnt = 1; $colcnt <= $ncol; $colcnt++) {
		$sFld = ew_CrossTabField("SUM", "`Units in Stock`", "`Category`", "", $col[$colcnt][0], "'", $colcnt);
		$sSqlFlds .= ", " . $sFld;
	}
	$EW_TABLE_SQL_SELECT = str_replace("<DistinctColumnFields>", $sSqlFlds, $EW_TABLE_SQL_SELECT);

	// Get active columns
	if (!is_array($sel_Category)) {
		$ncolspan = $ncol;
	} else {
		$ncolspan = 0;
		for ($i = 0; $i < count($col); $i++) {
			$bSelected = FALSE;
			for ($j = 0; $j < count($sel_Category); $j++) {
				if (trim($sel_Category[$j]) == trim($col[$i][0])) {
					$ncolspan++;
					$bSelected = TRUE;
					break;
				}
			}
			$col[$i][2] = $bSelected;
			if (!$bSelected) $bFilterApplied = TRUE;
		}
	}
	$ncolspan++; // Add summary column
}

// Get row values
function GetRow($opt) {
	global $rs, $rsidx, $row, $val, $ncol, $rscnt;
	if ($rscnt == 0) return;
	if ($opt == 1) { // Get first row
		$row = $rs[0];
	} else { // Get next row
		$rsidx++;
		$row = ($rsidx < $rscnt) ? $rs[$rsidx] : FALSE;
	}
	while ($row) {
		if (ValidRow($row)) {
			$GLOBALS["x_Stock_Name"] = $row["Stock Name"];
			for ($ix = 1; $ix <= $ncol; $ix++) {
				$val[$ix] = $row[$ix+1-1];
			}
			break;
		} else {
			$rsidx++;
			$row = ($rsidx < $rscnt) ? $rs[$rsidx] : FALSE;
		}
	}
	if (!$row) {
		$GLOBALS["x_Stock_Name"] = "";
	}
}

// Check level break
function ChkLvlBreak($lvl) {
	switch ($lvl) {
		case 1:
			return ($GLOBALS["x_Stock_Name"] == NULL && $GLOBALS["ox_Stock_Name"] != NULL) ||
			($GLOBALS["x_Stock_Name"] != NULL && $GLOBALS["ox_Stock_Name"] == NULL) ||
			($GLOBALS["x_Stock_Name"] <> $GLOBALS["ox_Stock_Name"]);
	}
}

// Accummulate summary
function AccumulateSummary() {
	global $val, $cnt, $smry;
	for ($ix = 1; $ix < count($smry); $ix++) {
		for ($iy = 0; $iy < count($smry[$ix]); $iy++) {
			$valwrk = $val[$ix];
			$cnt[$ix][$iy]++;
			$smry[$ix][$iy] = ew_SummaryValue($smry[$ix][$iy], $valwrk, EW_TABLE_REPORT_SUMMARY_TYPE);
		}
	}
}

// Reset level summary
function ResetLevelSummary($lvl) {

	// Clear summary values
	global $nRecCount, $cnt, $smry, $grandsmry;
	for ($ix = 1; $ix < count($smry); $ix++) {
		for ($iy = $lvl; $iy < count($smry[$ix]); $iy++) {
			$cnt[$ix][$iy] = 0;
			$smry[$ix][$iy] = 0;
		}
	}

	// Clear grand summary
	if ($lvl == 0) {
		for ($iy = 1; $iy < count($grandsmry); $iy++)
			$grandsmry[$iy] = 0;
	}

	// Reset record count
	$nRecCount = 0;
}

// Accummulate grand summary
function AccumulateGrandSummary() {
	global $val, $grandsmry;
	for ($iy = 1; $iy < count($grandsmry); $iy++) {
		$valwrk = $val[$iy];
		$grandsmry[$iy] = ew_SummaryValue($grandsmry[$iy], $valwrk, EW_TABLE_REPORT_SUMMARY_TYPE);
	}
}

//-------------------------------------------------------------------------------
// Function SetUpStartGroup
// - Set up Starting Record parameters based on Pager Navigation
// - Variables setup: nStartGrp

function SetUpStartGroup() {
	global $PHP_GET, $PHP_SESSION;
	global $nStartGrp, $nTotalGrps, $nDisplayGrps;

	// Check for a START parameter
	if (@$PHP_GET[EW_TABLE_START_GROUP] != "") {
		$nStartGrp = $PHP_GET[EW_TABLE_START_GROUP];
		$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (@$PHP_GET["pageno"] != "") {
		$nPageNo = $PHP_GET["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartGrp = ($nPageNo-1)*$nDisplayGrps+1;
			if ($nStartGrp <= 0) {
				$nStartGrp = 1;
			} elseif ($nStartGrp >= intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1) {
				$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
			}
			$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
		} else {
			$nStartGrp = @$PHP_SESSION[EW_TABLE_SESSION_START_GROUP];
			if (!is_numeric($nStartGrp) || $nStartGrp == "") {
				$nStartGrp = 1; // Reset start record counter
				$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
			}
		}
	} else {
		$nStartGrp = @$PHP_SESSION[EW_TABLE_SESSION_START_GROUP];
		if (!is_numeric($nStartGrp) || $nStartGrp == "") {
			$nStartGrp = 1; // Reset start record counter
			$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
		}
	}
}

//-------------------------------------------------------------------------------
// Function ResetCmd
// - RESET: reset search parameters

function ResetCmd() {
	global $PHP_GET, $PHP_POST, $PHP_SESSION;

	// Skip if post back
	if (count($PHP_POST) > 0) return;

	// Get Reset Cmd
	if (@$PHP_GET["cmd"] != "") {
		$sCmd = $PHP_GET["cmd"];
		if (strtolower($sCmd) == "reset") {
			ResetPager();
		}
	}
}
function ResetPager() {
	global $PHP_SESSION, $nStartGrp;

	// Reset Start Position (Reset Command)
	$nStartGrp = 1;
	$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
}

// Set up selection
function SetupSelection() {
	global $PHP_POST, $PHP_SESSION, $PHP_GET;

	// Process post back form
	$sName = @$PHP_POST["popup"]; // Get popup form name
	$sName = (get_magic_quotes_gpc()) ? stripslashes($sName) : $sName;
	if ($sName <> "") {
		$arValues = @$PHP_POST["sel_" . $sName];
		if (is_array($arValues)) {
			if (get_magic_quotes_gpc()) array_walk($arValues, 'ew_StripSlashes');
			if (trim($arValues[0]) == "") { // select all
				@$PHP_POST["all_" . $sName] = TRUE;
				array_shift($arValues); // remove first entry
			} else {
				$PHP_SESSION["all_" . $sName] = FALSE;
			}
			$PHP_SESSION["sel_" . $sName] = $arValues;
			$PHP_SESSION["rf_" . $sName] = (get_magic_quotes_gpc()) ? stripslashes(@$PHP_POST["from_" . $sName]) : @$PHP_POST["from_" . $sName];
			$PHP_SESSION["rt_" . $sName] = (get_magic_quotes_gpc()) ? stripslashes(@$PHP_POST["to_" . $sName]) : @$PHP_POST["to_" . $sName];
			ResetPager();
		}
	}

	// Load selection criteria to array
}

// Initialize group data - total number of groups + grouping field arrays
function InitReportData(&$rs) {
	global $conn, $nTotalGrps, $bFilterApplied, $sFilter, $EW_TABLE_SQL_WHERE;

	// Initialize group count
	$grpcnt = 0;
	$grpvalue = "";
	foreach ($rs as $row) {
		$bValidRow = ValidRow($row);
		if (!$bValidRow) $bFilterApplied = TRUE;
		if ($bValidRow) {
			$bNewGroup = ($grpcnt == 0) ||
				($grpvalue == NULL && $row[0] != NULL) ||
				($grpvalue != NULL && $row[0] == NULL) ||
				($grpvalue <> $row[0]);
			if ($bNewGroup) {
				$grpvalue = $row[0];
				$grpcnt++;
			}
		}
	}

	// Set up total number of groups
	$nTotalGrps = $grpcnt;
}

// Check if row is valid
function ValidRow($row) {
	$ValidRow = TRUE;
	if ($ValidRow) $ValidRow = HasColumnValues($row); // Rows with values
	return $ValidRow;
}

// Check if any column values is present
function HasColumnValues($row) {
	global $col;
	for ($i = 1; $i < count($col); $i++) {
		if ($col[$i][2]) {
			if ($row[1+$i-1] <> 0) return TRUE;
		}
	}
	return FALSE;
}
?>
<?php

//-------------------------------------------------------------------------------
// Function SetUpDisplayGrps
// - Set up Number of Groups displayed per page based on Form element GrpPerPage
// - Variables setup: nDisplayGrps

function SetUpDisplayGrps() {
	global $PHP_GET;
	global $PHP_SESSION;
	global $nDisplayGrps;
	global $nStartGrp;
	$sWrk = @$PHP_GET[EW_TABLE_GROUP_PER_PAGE];
	if ($sWrk <> "") {
		if (is_numeric($sWrk)) {
			$nDisplayGrps = intval($sWrk);
		} else {
			if (strtoupper($sWrk) == "ALL") { // Display All Records
				$nDisplayGrps = -1;
			} else {
				$nDisplayGrps = 30; // Non-numeric, Load Default
			}
		}
		$PHP_SESSION[EW_TABLE_SESSION_GROUP_PER_PAGE] = $nDisplayGrps; // Save to Session

		// Reset Start Position (Reset Command)
		$nStartGrp = 1;
		$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} else {
		if (@$PHP_SESSION[EW_TABLE_SESSION_GROUP_PER_PAGE] <> "") {
			$nDisplayGrps = $PHP_SESSION[EW_TABLE_SESSION_GROUP_PER_PAGE]; // Restore from Session
		} else {
			$nDisplayGrps = 30; // Load Default
		}
	}
}
?>
