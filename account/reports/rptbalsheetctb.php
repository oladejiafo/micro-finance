<?php
session_start();
ob_start();
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/rptewrcfg3.php"; ?>
<?php include "phprptinc/rptewmysql.php"; ?>
<?php include "phprptinc/rptewrfn3.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "balsheet", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "balsheet_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "balsheet_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "balsheet_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "balsheet_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "balsheet_orderby", TRUE);

// Table level SQL
define("EW_REPORT_TABLE_REPORT_COLUMN_FLD", "`Date`", TRUE); // Column field
define("EW_REPORT_TABLE_REPORT_COLUMN_DATE_TYPE", "q", TRUE); // Column date type
define("EW_REPORT_TABLE_REPORT_SUMMARY_FLD", "`Amount`", TRUE); // Summary field
define("EW_REPORT_TABLE_REPORT_SUMMARY_TYPE", "SUM", TRUE);
define("EW_REPORT_TABLE_REPORT_COLUMN_CAPTIONS", "1st Quarter,2nd Quarter,3rd Quarter,4th Quarter", TRUE);
define("EW_REPORT_TABLE_REPORT_COLUMN_NAMES", "Qtr1,Qtr2,Qtr3,Qtr4", TRUE);
define("EW_REPORT_TABLE_REPORT_COLUMN_VALUES", "1,2,3,4", TRUE); // Column values
$EW_REPORT_TABLE_SQL_TRANSFORM = "";
$EW_REPORT_TABLE_SQL_FROM = "`cash`";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT `Classification`, Year(`Date`) AS Year__Date, <DistinctColumnFields> FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "`Classification`, Year(`Date`)";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "`Classification` ASC, Year(`Date`)";
$EW_REPORT_TABLE_SQL_PIVOT = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "`Classification`", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `Classification` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT Year(`Date`) AS Year__Date, <DistinctColumnFields> FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_GROUPBY_AGG = "Year(`Date`)";
$af_ID = NULL; // Popup filter for ID
$af_Type = NULL; // Popup filter for Type
$af_Date = NULL; // Popup filter for Date
$af_Classification = NULL; // Popup filter for Classification
$af_Particulars = NULL; // Popup filter for Particulars
$af_Amount = NULL; // Popup filter for Amount
$af_Source = NULL; // Popup filter for Source
$af_Recipient = NULL; // Popup filter for Recipient
$af_Paid = NULL; // Popup filter for Paid
$af_Remark = NULL; // Popup filter for Remark
?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {

	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}
?>
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record count
$nStartGrp = 0; // Start group
$nStopGrp = 0; // Stop group
$nTotalGrps = 0; // Total groups
$nGrpCount = 0; // Group count
$nDisplayGrps = 30; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
define("EW_REPORT_TABLE_YEAR_SQL", "SELECT DISTINCT Year(`Date`) AS Year__Date FROM `cash` ORDER BY Year(`Date`)", TRUE);
?>
<?php

// Static group variables
$x_Classification = NULL;
$o_Classification = NULL;
$t_Classification = NULL;
$g_Classification = NULL;
$ft_Classification = 200;
$rf_Classification = NULL;
$rt_Classification = NULL;

// Column variables
$x_Date = NULL;
$ft_Date = 133;
$rf_Date = NULL;
$rt_Date = NULL;
$ft_Year__Date = 3;
$af_Year__Date = NULL;

// Summary variables
$x_Amount = NULL;
$rowsmry = NULL; // row summary
?>
<?php

// Filter
$sFilter = "";
$sButtonImage = "";
$sDivDisplay = FALSE;

// Get sort
$sSort = getSort();

// Set up groups per page dynamically
SetUpDisplayGrps();

// Popup values and selections
$sel_Year__Date = NULL;
$seld_Year__Date = NULL;
$val_Year__Date = NULL;

// Set up popup filter
SetupPopup();

// Load columns to array
GetColumns();

// Extended filter
$sExtendedFilter = "";

// Add year filter
if ($sel_Year__Date <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "Year(`Date`) = " . $sel_Year__Date;
}

// Build popup filter
$sPopupFilter = GetPopupFilter();

//echo "popup filter: " . $sPopupFilter . "<br>";
if ($sPopupFilter <> "") {
	if ($sFilter <> "")
  		$sFilter = "($sFilter) AND ($sPopupFilter)";
	else
		$sFilter = $sPopupFilter;
}

// No filter
$bFilterApplied = FALSE;

// Get total group count
$sSql = ewrpt_BuildReportSql("", $EW_REPORT_TABLE_SQL_SELECT_GROUP, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, "", $EW_REPORT_TABLE_SQL_ORDERBY, "", $sFilter, @$sSort);
$nTotalGrps = GetGrpCnt($sSql);
if ($nDisplayGrps <= 0) // Display all groups
	$nDisplayGrps = $nTotalGrps;
$nStartGrp = 1;

// Show header
$bShowFirstHeader = ($nTotalGrps > 0);

//$bShowFirstHeader = TRUE; // Uncomment to always show header
// Set up start position if not export all

if (EW_REPORT_EXPORT_ALL && @$sExport <> "")
    $nDisplayGrps = $nTotalGrps;
else
    SetUpStartGroup(); 

// Get total groups
$rsgrp = GetGrpRs($sSql, $nStartGrp, $nDisplayGrps);

// Init detail recordset
$rs = NULL;
?>
<?php include "phprptinc/rptheader.php"; ?>
<?php if (@$sExport == "") { ?>
<script type="text/javascript">
var EW_REPORT_DATE_SEPARATOR = "/";
if (EW_REPORT_DATE_SEPARATOR == "") EW_REPORT_DATE_SEPARATOR = "/"; // Default date separator
</script>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<script type="text/javascript">

function ewrpt_ValidateExtFilter(form_obj) {
	return true;
}
</script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<script type="text/javascript">
var EW_REPORT_POPUP_ALL = "(All)";
var EW_REPORT_POPUP_OK = "  OK  ";
var EW_REPORT_POPUP_CANCEL = "Cancel";
var EW_REPORT_POPUP_FROM = "From";
var EW_REPORT_POPUP_TO = "To";
var EW_REPORT_POPUP_PLEASE_SELECT = "Please Select";
var EW_REPORT_POPUP_NO_VALUE = "No value selected!";

// popup fields
</script>
<!-- Table container (begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top container (begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<h1>Balance Sheet</h1>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="rptbalsheetctb.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="rptbalsheetctb.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="rptbalsheetctb.php?export=word">Export to Word</a>
<?php } ?>
<br /><br />
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
<?php if (@$sExport == "") { ?>
<?php
if (EW_REPORT_FILTER_PANEL_OPTION == 2 || (EW_REPORT_FILTER_PANEL_OPTION == 3 && $bFilterApplied) || $sFilter == "0=101") {
	$sButtonImage = "phprptimages/collapse.gif";
	$sDivDisplay = "";
} else {
	$sButtonImage = "phprptimages/expand.gif";
	$sDivDisplay = " style=\"display: none;\"";
}
?>
<a href="javascript:ewrpt_ToggleFilterPanel();" style="text-decoration: none;"><img id="ewrptToggleFilterImg" src="<?php echo $sButtonImage ?>" alt="" width="9" height="9" border="0"></a><span class="phpreportmaker">&nbsp;Filters</span><br /><br />
<div id="ewrptExtFilterPanel"<?php echo $sDivDisplay ?>>
<!-- Search form (begin) -->
<form name="fbalsheetcrosstabfilter" id="fbalsheetcrosstabfilter" action="rptbalsheetctb.php" class="ewForm" onSubmit="return ewrpt_ValidateExtFilter(this);">
<table class="ewRptExtFilter">
<!-- Year selection -->
<tr><td><span class="phpreportmaker">Year</span></td><td></td><td colspan="4"><span class="phpreportmaker">
<select name="Year__Date" onchange="this.form.submit();">
<?php

// Set up array
if (is_array($val_Year__Date)) {
	$cntyr = count($val_Year__Date);
	for ($yearIdx = 0; $yearIdx < $cntyr; $yearIdx++) {
		$yearValue = $val_Year__Date[$yearIdx];
		$yearSelected = (strval($yearValue) == strval($sel_Year__Date)) ? " selected" : "";
?>
<option value="<?php echo $yearValue ?>"<?php echo $yearSelected ?>><?php echo $yearValue ?></option>
<?php
	}
}
?>
</select>
</span></td></tr>
</table>
</form>
<!-- Search form (end) -->
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report grid (begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php if ($bShowFirstHeader) { // Show header ?>
	<thead>
	<!-- Table header -->
	<tr class="ewTableRow">
		<td colspan="1" nowrap><div class="phpreportmaker">&nbsp;</div></td>
		<td class="ewRptColHeader" colspan="<?php echo @$ncolspan; ?>" nowrap>
			Date
		</td>
	</tr>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td class="ewRptGrpHeader1">
		Classification
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Classification</td>
			</tr></table>
		</td>
<?php } ?>
<!-- Dynamic columns begin -->
	<?php
	$cntval = count($val);
	for ($iy = 1; $iy < $cntval; $iy++) {
		if ($col[$iy][2]) {
			$x_Date = $col[$iy][1];
	?>
		<td class="ewTableHeader" valign="top">
<?php echo ewrpt_ViewValue($x_Date) ?>
</td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	</tr>
	</thead>
<?php } // End show header ?>
	<tbody>
<?php
if ($nTotalGrps > 0) {

// Set the last group to display if not export all
if (EW_REPORT_EXPORT_ALL && @$sExport <> "") {
	$nStopGrp = $nTotalGrps;
} else {
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps)) {
	$nStopGrp = $nTotalGrps;
}

// Navigate
$grpvalue = "";
$nRecCount = 0;

// Get first row
if ($nTotalGrps > 0) {
	GetGrpRow(1);
	$nGrpCount = 1;
}
while ($rsgrp && !$rsgrp->EOF) {

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_Classification, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_Classification, EW_REPORT_DATATYPE_STRING);
	if ($sFilter != "")
		$sWhere = "($sFilter) AND ($sWhere)";
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_TRANSFORM, $EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, "", $EW_REPORT_TABLE_SQL_ORDERBY, $EW_REPORT_TABLE_SQL_PIVOT, $sWhere, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		GetRow(1);
	while ($rs && !$rs->EOF) {
		$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";

		// Show group values
		$g_Classification = $x_Classification;
		if ($x_Classification <> "" && $o_Classification == $x_Classification && !ChkLvlBreak(1)) {
			$g_Classification = "&nbsp;";
		} elseif (is_null($x_Classification)) {
			$g_Classification = EW_REPORT_NULL_LABEL;
		} elseif ($x_Classification == "") {
			$g_Classification = EW_REPORT_EMPTY_LABEL;
		}
?>
	<!-- Data -->
	<tr>
		<!-- Classification -->
		<td class="ewRptGrpField1"><?php $t_Classification = $x_Classification; $x_Classification = $g_Classification; ?>
<?php echo ewrpt_ViewValue($x_Classification) ?>
<?php $x_Classification = $t_Classification; ?></td>
<!-- Dynamic columns begin -->
	<?php
		$rowsmry = 0;
		$cntval = count($val);
		for ($iy = 1; $iy < $cntval; $iy++) {
			if ($col[$iy][2]) {
				$rowval = $val[$iy];
				$rowsmry = ewrpt_SummaryValue($rowsmry, $rowval, EW_REPORT_TABLE_REPORT_SUMMARY_TYPE);
				$x_Amount = $val[$iy];
	?>
		<!-- <?php echo $col[$iy][1]; ?> -->
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_Amount) ?>
</td>
	<?php
			}
		}
	?>
<!-- Dynamic columns end -->
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_Classification = $x_Classification;

		// Get next record
		GetRow(2);
?>
<?php
	} // End detail records loop

	// Save old group values
	$o_Remark = $x_Classification; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
?>
<?php
}
?>
	</tbody>
	<tfoot>
	<!-- Grand Total -->
	<tr class="ewRptGrandSummary">
	<td colspan="1">Grand Total</td>
<!-- Dynamic columns begin -->
	<?php 

	// aggregate sql
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_TRANSFORM, $EW_REPORT_TABLE_SQL_SELECT_AGG, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY_AGG, "", "", $EW_REPORT_TABLE_SQL_PIVOT, $sFilter, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rsagg = $conn->Execute($sSql);
	if ($rsagg && !$rsagg->EOF) $rsagg->MoveFirst();

//	echo "record count: " . $rsagg->RecordCount() . "<br>";
	$rowsmry = 0;

	// Use data from recordset directly
	for ($iy = 1; $iy <= $ncol; $iy++) {
		if ($col[$iy][2]) {
			$rowval = ($rsagg && !$rsagg->EOF) ? $rsagg->fields[$iy+1-1] : 0;

//echo "rowval: $rowval<br>";
			$rowsmry = ewrpt_SummaryValue($rowsmry, $rowval, EW_REPORT_TABLE_REPORT_SUMMARY_TYPE);
			$x_Amount = $rowval;
	?>
		<!-- <?php echo $col[$iy][1]; ?> -->
		<td>
<?php echo ewrpt_ViewValue($x_Amount) ?>
</td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="rptbalsheetctb.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="rptbalsheetctb.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="rptbalsheetctb.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="rptbalsheetctb.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="rptbalsheetctb.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"> <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpreportmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="10"<?php if ($nDisplayGrps == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($nDisplayGrps == 20) echo " selected" ?>>20</option>
<option value="30"<?php if ($nDisplayGrps == 30) echo " selected" ?>>30</option>
<option value="40"<?php if ($nDisplayGrps == 40) echo " selected" ?>>40</option>
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
<option value="100"<?php if ($nDisplayGrps == 100) echo " selected" ?>>100</option>
<option value="200"<?php if ($nDisplayGrps == 200) echo " selected" ?>>200</option>
<option value="ALL"<?php if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All</option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
</td></tr></table>
</div>
<!-- Crosstab report ends -->
<?php if (@$sExport == "") { ?>
	</div><br /></td>
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
	</div><br /></td></tr>
<!-- Bottom container (end) -->
</table>
<!-- Table container (end) -->
<?php } ?>
<?php

// Close recordset and connection
if ($rs)
	$rs->Close();
$conn->Close();

// Display elapsed time
if (defined("EW_REPORT_DEBUG_ENABLED"))
	echo ewrpt_calcElapsedTime($starttime);
?>
<?php include "phprptinc/rptfooter.php"; ?>
<?php

// Get column values
function GetColumns() {
	global $conn;
	global $EW_REPORT_TABLE_SQL_SELECT;
	global $EW_REPORT_TABLE_SQL_SELECT_AGG;
	global $EW_REPORT_TABLE_DISTINCT_SQL_SELECT;
	global $EW_REPORT_TABLE_DISTINCT_SQL_WHERE;
	global $EW_REPORT_TABLE_DISTINCT_SQL_ORDERBY;
	global $sFilter, $sSort;
	global $ncol, $col, $val, $valcnt, $cnt, $smry, $smrycnt, $ncolspan;
	global $sel_Date;
	global $val_Year__Date;
	global $sel_Year__Date;

	// Get distinct year
	$rsyear = $conn->Execute(EW_REPORT_TABLE_YEAR_SQL);
	if ($rsyear) {
		while (!$rsyear->EOF) {
			if (!is_null($rsyear->fields[0]))
				$val_Year__Date[] = $rsyear->fields[0];
			$rsyear->MoveNext();
		}
		$rsyear->Close();
	}
	if (is_array($val_Year__Date)) {
		if (strval($sel_Year__Date) == "") {
			$sel_Year__Date = $val_Year__Date[0];
		}
	}
	$arColumnCaptions = explode(",", EW_REPORT_TABLE_REPORT_COLUMN_CAPTIONS);
	$arColumnNames = explode(",", EW_REPORT_TABLE_REPORT_COLUMN_NAMES);
	$arColumnValues = explode(",", EW_REPORT_TABLE_REPORT_COLUMN_VALUES);

	// Get distinct column count
	$ncol = count($arColumnNames);

	// 1st dimension = no of groups (level 0 used for grand total)
	// 2nd dimension = no of distinct values

	$nGrps = 1;
	$col = ewrpt_Init2DArray($ncol+1, 2, NULL);
	$val = ewrpt_InitArray($ncol+1, NULL);
	$valcnt = ewrpt_InitArray($ncol+1, NULL);
	$cnt = ewrpt_Init2DArray($ncol+1, $nGrps+1, NULL);
	$smry = ewrpt_Init2DArray($ncol+1, $nGrps+1, NULL);
	$smrycnt = ewrpt_Init2DArray($ncol+1, $nGrps+1, NULL);

	// Reset summary values
	ResetLevelSummary(0);
	$colcnt = 0;
	for ($colcnt = 1; $colcnt <= $ncol; $colcnt++) {
		$col[$colcnt][0] = $arColumnValues[$colcnt-1]; // Value
		$col[$colcnt][1] = $arColumnCaptions[$colcnt-1]; // Caption
		$col[$colcnt][2] = TRUE; // Visible
	}

	// Get active columns
	if (!is_array($sel_Date)) {
		$ncolspan = $ncol;
	} else {
		$ncolspan = 0;
		$cntcol = count($col);
		for ($i = 0; $i < $cntcol; $i++) {
			$bSelected = FALSE;
			$cntsel = count($sel_Date);
			for ($j = 0; $j < $cntsel; $j++) {
				if (trim($sel_Date[$j]) == trim($col[$i][0])) {
					$ncolspan++;
					$bSelected = TRUE;
					break;
				}
			}
			$col[$i][2] = $bSelected;
		}
	}

	// Update crosstab sql
	$sSqlFlds = "";
	for ($i = 0; $i < $ncol; $i++) {
		$sFld = ewrpt_CrossTabField(EW_REPORT_TABLE_REPORT_SUMMARY_TYPE, EW_REPORT_TABLE_REPORT_SUMMARY_FLD,
			EW_REPORT_TABLE_REPORT_COLUMN_FLD, EW_REPORT_TABLE_REPORT_COLUMN_DATE_TYPE, $arColumnValues[$i], "", $arColumnNames[$i]);
		if ($sSqlFlds <> "")
			$sSqlFlds .= ", ";
		$sSqlFlds .= $sFld;
	}
	$EW_REPORT_TABLE_SQL_SELECT = str_replace("<DistinctColumnFields>", $sSqlFlds, $EW_REPORT_TABLE_SQL_SELECT);
	$EW_REPORT_TABLE_SQL_SELECT_AGG = str_replace("<DistinctColumnFields>", $sSqlFlds, $EW_REPORT_TABLE_SQL_SELECT_AGG);

	// Update chart sql if Y Axis = Column Field
	$sSqlChtFld = "";
	for ($i = 0; $i < $ncol; $i++) {
		if ($col[$i+1][2]) {
			$sChtFld = ewrpt_CrossTabField("SUM", EW_REPORT_TABLE_REPORT_SUMMARY_FLD, EW_REPORT_TABLE_REPORT_COLUMN_FLD, EW_REPORT_TABLE_REPORT_COLUMN_DATE_TYPE, $arColumnValues[$i], "");
			if ($sSqlChtFld != "") $sSqlChtFld .= "+";
			$sSqlChtFld .= $sChtFld;
		}
	}
}

// Get group count
function GetGrpCnt($sql) {
	global $conn;

	//echo "sql (GetGrpCnt): " . $sql . "<br>";
	$rsgrpcnt = $conn->Execute($sql);
	$grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
	return $grpcnt;
}

// Get group rs
function GetGrpRs($sql, $start, $grps) {
	global $conn;
	$wrksql = $sql . " LIMIT " . ($start-1) . ", " . ($grps);

	//echo "wrksql: (rsgrp)" . $sSql . "<br>";
	$rswrk = $conn->Execute($wrksql);
	return $rswrk;
}

// Get group row values
function GetGrpRow($opt) {
	global $rsgrp;
	if (!$rsgrp)
		return;
	if ($opt == 1) { // Get first group
		$rsgrp->MoveFirst();
	} else { // Get next group
		$rsgrp->MoveNext();
	}
	if ($rsgrp->EOF) {
		$GLOBALS['x_Classification'] = "";
	} else {
		$GLOBALS['x_Classification'] = $rsgrp->fields('Classification');
	}
}

// Get row values
function GetRow($opt) {
	global $rs, $val;
	if (!$rs)
		return;
	if ($opt == 1) { // Get first row
		$rs->MoveFirst();
	} else { // Get next row
		$rs->MoveNext();
	}
	if (!$rs->EOF) {
		$cntval = count($val);
		for ($ix = 1; $ix < $cntval; $ix++)
			$val[$ix] = $rs->fields[$ix+2-1];
	} else {
	}
}

// Check level break
function ChkLvlBreak($lvl) {
	switch ($lvl) {
		case 1:
			return (is_null($GLOBALS["x_Classification"]) && !is_null($GLOBALS["o_Classification"])) ||
			(!is_null($GLOBALS["x_Classification"]) && is_null($GLOBALS["o_Classification"])) ||
			($GLOBALS["x_Classification"] <> $GLOBALS["o_Classification"]);
	}
}

// Accummulate summary
function AccumulateSummary() {
	global $val, $cnt, $smry;
	$cntx = count($smry);
	for ($ix = 1; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = 0; $iy < $cnty; $iy++) {
			$valwrk = $val[$ix];
			$cnt[$ix][$iy]++;
			$smry[$ix][$iy] = ewrpt_SummaryValue($smry[$ix][$iy], $valwrk, EW_REPORT_TABLE_REPORT_SUMMARY_TYPE);
		}
	}
}

// Reset level summary
function ResetLevelSummary($lvl) {

	// Clear summary values
	global $nRecCount, $cnt, $smry, $smrycnt;
	$cntx = count($smry);
	for ($ix = 1; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = $lvl; $iy < $cnty; $iy++) {
			$cnt[$ix][$iy] = 0;
			$smry[$ix][$iy] = 0;
		}
	}

	// Reset record count
	$nRecCount = 0;
}

// Set up starting group
function SetUpStartGroup() {
	global $nStartGrp, $nTotalGrps, $nDisplayGrps;

	// Exit if no groups
	if ($nDisplayGrps == 0)
		return;

	// Check for a 'start' parameter
	if (@$_GET[EW_REPORT_TABLE_START_GROUP] != "") {
		$nStartGrp = $_GET[EW_REPORT_TABLE_START_GROUP];
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (@$_GET["pageno"] != "") {
		$nPageNo = $_GET["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartGrp = ($nPageNo-1)*$nDisplayGrps+1;
			if ($nStartGrp <= 0) {
				$nStartGrp = 1;
			} elseif ($nStartGrp >= intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1) {
				$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
			}
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
		} else {
			$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];	
		}
	} else {
		$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];
	}

	// Check if correct start group counter
	if (!is_numeric($nStartGrp) || $nStartGrp == "") { // Avoid invalid start group counter
		$nStartGrp = 1; // Reset start group counter
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (intval($nStartGrp) > intval($nTotalGrps)) { // Avoid starting group > total groups
		$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to last page first group
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (($nStartGrp-1) % $nDisplayGrps <> 0) {
		$nStartGrp = intval(($nStartGrp-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to page boundary
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	}
}

// Set up popup
function SetupPopup() {
	global $conn, $sFilter;

	// Process post back form
	if (count($_POST) > 0) {
		$sName = @$_POST["popup"]; // Get popup form name
		if ($sName <> "") {
			$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
			if ($cntValues > 0) {
				$arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
				if (trim($arValues[0]) == "") // Select all
					$arValues = EW_REPORT_INIT_VALUE;
				$_SESSION["sel_$sName"] = $arValues;
				$_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
				$_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
				ResetPager();
			}
		}

	// Get 'reset' command
	} elseif (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];
		if (strtolower($sCmd) == "reset") {
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Process query string

	if (@$_GET["Year__Date"] <> "") {
		$GLOBALS["x_Year__Date"] = $_GET["Year__Date"];
		if (is_numeric($GLOBALS["x_Year__Date"])) {
			$_SESSION["sel_balsheet_Year__Date"] = $GLOBALS["x_Year__Date"];
			ResetPager();
		}
	}
	$GLOBALS["sel_Year__Date"] = @$_SESSION["sel_balsheet_Year__Date"];
}

// Reset pager
function ResetPager() {
	global $nStartGrp;

	// Reset start position (reset command)
	$nStartGrp = 1;
	$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
}

// Check if any column values is present
function HasColumnValues(&$rs) {
	global $col;
	$cntcol = count($col);
	for ($i = 1; $i < $cntcol; $i++) {
		if ($col[$i][2]) {
			if ($rs->fields[2+$i-1] <> 0) return TRUE;
		}
	}
	return FALSE;
}
?>
<?php

// Set up number of groups displayed per page
function SetUpDisplayGrps() {
	global $nDisplayGrps, $nStartGrp;
	$sWrk = @$_GET[EW_REPORT_TABLE_GROUP_PER_PAGE];
	if ($sWrk <> "") {
		if (is_numeric($sWrk)) {
			$nDisplayGrps = intval($sWrk);
		} else {
			if (strtoupper($sWrk) == "ALL") { // display all groups
				$nDisplayGrps = -1;
			} else {
				$nDisplayGrps = 30; // Non-numeric, load default
			}
		}
		$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] = $nDisplayGrps; // Save to session

		// Reset start position (reset command)
		$nStartGrp = 1;
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} else {
		if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] <> "") {
			$nDisplayGrps = $_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE]; // Restore from session
		} else {
			$nDisplayGrps = 30; // Load default
		}
	}
}
?>
<?php

// Return poup filter
function GetPopupFilter() {
	$sWrk = "";
	return $sWrk;
}
?>
<?php

//-------------------------------------------------------------------------------
// Function getSort
// - Return Sort parameters based on Sort Links clicked
// - Variables setup: Session[EW_REPORT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
function getSort()
{

	// Check for a resetsort command
	if (strlen(@$_GET["cmd"]) > 0) {
		$sCmd = @$_GET["cmd"];
		if ($sCmd == "resetsort") {
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "";
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
			$_SESSION["sort_balsheet_Classification"] = "";
		}

	// Check for an Order parameter
	} elseif (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY]) > 0) {
		$sSortSql = "";
		$sSortField = "";
		$sOrder = @$_GET[EW_REPORT_TABLE_ORDER_BY];
		if (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE]) > 0) {
			$sOrderType = @$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE];
		} else {
			$sOrderType = "";
		}
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
