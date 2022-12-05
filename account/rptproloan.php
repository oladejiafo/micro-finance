<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 3)  & ($_SESSION['access_lvl'] != 6) & ($_SESSION['access_lvl'] != 5))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
 require_once 'conn.php';

$sqr="SELECT * FROM `company info`";
$reslt = mysqli_query($conn,$sqr) or die('Could not look up user data; ' . mysqli_error());
$rw = mysqli_fetch_array($reslt);
$coy=$rw['Company Name'];
?>

     <h1><b><center><?php echo $coy; ?></center></b></h1>
     <h3><center><u>PROVISION FOR LOAN</u></center></h3>

<TABLE width='99%' border='1' cellpadding='0' cellspacing='0' align='center' id="table3">
<?php

 $cmbFilter=$_REQUEST["cmbFilter"];
 $filter=$_REQUEST["filter"];

 echo "Filtered using: " . $cmbFilter . "=" . $filter;
 echo "<br>";
    echo "<TR bgcolor='#c0c0c0'><TH valign='top'><b>Date </b></TH><TH valign='top'><b>Customer Name </b></TH><TH valign='top'><b>Performing Loan (N) <br> 1% (0 Day) </b></TH><TH valign='top'><b>Pass and Watch Loan (N) <br>5% (1-30 Days)</b></TH>
      <TH valign='top'><b>Substandard Loan (N) <br>20% (31-60 Days) </b></TH><TH valign='top'><b>Doubtful Loan (N) <br>50% (61-90 Days) </b></TH><TH valign='top'><b>Lost Loan (N) <br>100% (Above 90 Days) </b></TH><TH valign='top'>Total</TH></TR>";

  if (!$cmbFilter=="")
  {  
   $query="SELECT `Date`,`Recipient`,`Classification`,`Amount`,`Particulars` FROM `cash` WHERE `" . $cmbFilter . "` like '" . $filter . "%' and `Classification` in ('General Reserves','Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)','Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)') group by `Recipient`,`Date` order by `Date` desc";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($date,$cust,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $sql1="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Performing Loans (0 day)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest1 = mysqli_query($conn,$sql1) or die('Could not look up user data; ' . mysqli_error());
     $row1 = mysqli_fetch_array($rest1);
     $amt1= $row1['Amount'];
     $did1= $row1['ID'];
     $class1= $row1['Classification'];

     $sql2="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Pass and Watch Loans (1-30 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest2 = mysqli_query($conn,$sql2) or die('Could not look up user data; ' . mysqli_error());
     $row2 = mysqli_fetch_array($rest2);
     $amt2= $row2['Amount'];
     $did2= $row2['ID'];
     $class2= $row2['Classification'];

     $sql3="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Substandard Loans (31-60 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest3 = mysqli_query($conn,$sql3) or die('Could not look up user data; ' . mysqli_error());
     $row3 = mysqli_fetch_array($rest3);
     $amt3= $row3['Amount'];
     $did3= $row3['ID'];
     $class3= $row3['Classification'];

     $sql4="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Doubtful Loans (61-90 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest4 = mysqli_query($conn,$sql4) or die('Could not look up user data; ' . mysqli_error());
     $row4 = mysqli_fetch_array($rest4);
     $amt4= $row4['Amount'];
     $did4= $row4['ID'];
     $class4= $row4['Classification'];

     $sql5="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Lost Loans (>91 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest5 = mysqli_query($conn,$sql5) or die('Could not look up user data; ' . mysqli_error());
     $row5 = mysqli_fetch_array($rest5);
     $amt5= $row5['Amount'];
     $did5= $row5['ID'];
     $class5= $row5['Classification'];
     $total=$amt1+$amt2+$amt3+$amt4+$amt5;
     echo "<TR><TH>$date &nbsp;</TH><TH>$cust &nbsp;</TH><TH>$amt1 &nbsp;</TH>
      <TH>$amt2 &nbsp;</TH><TH>$amt3 &nbsp;</TH><TH>$amt4 &nbsp;</TH><TH>$amt5 &nbsp;</TH><TH>$total</TH></TR>"; 
   }

  }
  else
  {
   $query="SELECT `Date`,`Recipient`,`Classification`,`Amount`,`Particulars` FROM `cash` WHERE `Classification` in ('General Reserves','Specific Reserve for Performing Loans (0 day)', 'Specific Reserve for Pass and Watch Loans (1-30 days)','Specific Reserve for Substandard Loans (31-60 days)','Specific Reserve for Doubtful Loans (61-90 days)','Specific Reserve for Lost Loans (>91 days)') group by `Recipient`,`Date` order by `Date` desc";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0)
   { 
        echo("Nothing to Display!<br>"); 
   } 

    while(list($date,$cust,$classification,$amount,$particulars)=mysqli_fetch_row($result))
    {
     $sql1="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Performing Loans (0 day)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest1 = mysqli_query($conn,$sql1) or die('Could not look up user data; ' . mysqli_error());
     $row1 = mysqli_fetch_array($rest1);
     $amt1= $row1['Amount'];
     $did1= $row1['ID'];
     $class1= $row1['Classification'];

     $sql2="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Pass and Watch Loans (1-30 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest2 = mysqli_query($conn,$sql2) or die('Could not look up user data; ' . mysqli_error());
     $row2 = mysqli_fetch_array($rest2);
     $amt2= $row2['Amount'];
     $did2= $row2['ID'];
     $class2= $row2['Classification'];

     $sql3="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Substandard Loans (31-60 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest3 = mysqli_query($conn,$sql3) or die('Could not look up user data; ' . mysqli_error());
     $row3 = mysqli_fetch_array($rest3);
     $amt3= $row3['Amount'];
     $did3= $row3['ID'];
     $class3= $row3['Classification'];

     $sql4="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Doubtful Loans (61-90 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest4 = mysqli_query($conn,$sql4) or die('Could not look up user data; ' . mysqli_error());
     $row4 = mysqli_fetch_array($rest4);
     $amt4= $row4['Amount'];
     $did4= $row4['ID'];
     $class4= $row4['Classification'];

     $sql5="SELECT `Amount`,`ID`,`Classification` FROM `cash` WHERE `Classification` in ('Specific Reserve for Lost Loans (>91 days)') and `Recipient`='$cust' and `Date`='$date' order by `Date` desc";
     $rest5 = mysqli_query($conn,$sql5) or die('Could not look up user data; ' . mysqli_error());
     $row5 = mysqli_fetch_array($rest5);
     $amt5= $row5['Amount'];
     $did5= $row5['ID'];
     $class5= $row5['Classification'];
     $total=$amt1+$amt2+$amt3+$amt4+$amt5;
     echo "<TR><TH>$date &nbsp;</TH><TH>$cust &nbsp;</TH><TH>$amt1 &nbsp;</TH>
      <TH>$amt2 &nbsp;</TH><TH>$amt3 &nbsp;</TH><TH>$amt4 &nbsp;</TH><TH>$amt5 &nbsp;</TH><TH>$total</TH></TR>"; 
   }

  }

 ?>
</TABLE>
<br>
