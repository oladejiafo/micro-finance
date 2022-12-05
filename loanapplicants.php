<?php
session_start();
//check to see if user has logged in with a valid password

if (!isset($_SESSION['USER_ID']) & $_SESSION['access_lvl'] != 5) 
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 0; URL=index.php?redirect=$redirect");
}

 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';
?>
<link rel="stylesheet" href="css/refreshform.css" />
   <div align="center">

	<table border="0" width="100%" id="table1" bgcolor="#FFFFFF">
		<tr>
			<td>
			<div align="center">
				<table border="0" width="100%" id="table2">
					<tr>
						<td>

<TABLE width='100%' border='1' cellpadding='1' cellspacing='1' align='center' bordercolor="#005B00">
 <?php
 @$limit      = 25;
 @$page=$_GET['page'];
 @$query_count    = "SELECT * FROM `loan application` where `Status` not in ('Approved','Disapproved')";     
 @$result_count   = mysqli_query($conn,$query_count);     
 @$totalrows  = mysqli_num_rows($result_count);

 if(empty($page))
 {
        $page = 1;
 }

 $limitvalue = $page * $limit - ($limit);  

    echo "<H3><b>[LOAN APPLICANTS]</b></H3>";

    echo "<TR bgcolor='#D2DD8F'><TH> <b>Application Date </b>&nbsp;</TH><TH><b>Applicant Name </b>&nbsp;</TH><TH><b>Work Place </b>&nbsp;</TH>
      <TH><b>Loan Amount </b>&nbsp;</TH><TH><b>Loan Tenor </b>&nbsp;</TH><TH><b>Monthly Income </b>&nbsp;</TH><TH>&nbsp;</TH></TR>";

    $query="SELECT `ID`,`Application Date`,`Surname`,`First Name`,`Current Employer`,`Loan Amount`,`Tenor`,`Income` FROM `loan application` where `Status` not in ('Approved','Disapproved') order by `Application Date`,`ID` LIMIT $limitvalue, $limit";
    $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!"); 
   } 

    while(list($id,$date,$sname,$fname,$emp,$amount,$tenor,$income)=mysqli_fetch_row($result))
    {
     $name=$fname . " " . $sname;
     echo "<TR><TH>$date &nbsp;</TH><TH> $name &nbsp;</TH><TH>$emp &nbsp;</TH>
      <TH align='Left'> <p style='margin-left: 10'>$amount &nbsp;</TH><TH align='Left'> <p style='margin-left: 10'>$tenor &nbsp;</TH><TH>$income &nbsp;</TH><TH><a href='manageloan.php?id=$id'>Details</a> </TH></TR>";
    }
echo"</TABLE><table align='right'>";
    echo "<TR align='right'><TD>";
    if($page != 1)
    {  
       $pageprev = $page-1;
       echo("<a href=\"$PHP_SELF?page=$pageprev\"> PREV<< </a>  ");
    }
    else 
       echo("PREV<<  ");  

    $numofpages = $totalrows / $limit;  
    for($i = 1; $i <= $numofpages; $i++)
    { 
        if($i == $page)
        { 
            echo($i."  "); 
        }else{ 
            echo("<a href=\"$PHP_SELF?page=$i\">$i</a>  ");  
        }
    } 
    if(($totalrows % $limit) != 0)
    { 
        if($i == $page)
        { 
            echo($i."  "); 
        }
        else
        { 
            echo("<a href=\"$PHP_SELF?page=$i\">$i</a>  "); 
       } 
    }
    if(($totalrows - ($limit * $page)) > 0)
    { 
        $pagenext = $page+1;

        echo("<a href=\"$PHP_SELF?page=$pagenext\">NEXT>></a>");  
            
    }          
    else
    { 
        echo("NEXT>>");  
    } 
    echo "</TD></TR>";
 ?>

						<p>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>

<?php
 require_once 'footr.php';
 require_once 'footer.php';
?>