<?php 
# session_start(); 
?>
<html>
  
<body bgcolor="#FFFFDF">
<?php
           
  if (isset($_SESSION['user_id']) && ($_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 3)) 
  {
     echo " <a href='account.php'>Entry Journal</a>";
     echo " | <a href='suspense.php'>Suspense Account</a>";
     echo " | <a href='provisions.php'>Loans Provisions</a>";
     #echo " | <a href='bankbook.php'>Cheque Register</a>";
     echo " | <a href='fassets.php'>Fixed Assets</a>";
     echo " | <a href='contract.php'>Contractors</a>";
     echo " | <a href='paysumm.php'>Payment Summary</a>";
    # echo " | <a href='acctreports.php'>Reports</a>";
  }
?>
