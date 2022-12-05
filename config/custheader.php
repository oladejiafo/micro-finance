<?php 
echo '<font size="2" face="Tahoma">';
            if (isset($_SESSION['user_id']) && ($_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 1 or $_SESSION['access_lvl'] == 2 or $_SESSION['access_lvl'] ==5 or $_SESSION['access_lvl'] ==3)) 
             {
              if ($_SESSION['access_lvl'] != 1 and $_SESSION['access_lvl'] != 3)
              { 
               echo " <a href='customer.php?acctno=" . @$acctno . "'> Customer Account</a>";
               echo " | <a href='register.php?acctno=" . @$acctno . "'>Customer Record</a>";
               echo " | <a href='closure.php?acctno=" . @$acctno . "'>Account Closure</a>";
              }
              if ($_SESSION['access_lvl'] == 3 or $_SESSION['access_lvl'] == 1 or $_SESSION['access_lvl'] == 5 or $_SESSION['access_lvl'] == 4 or $_SESSION['access_lvl'] == 7)
              {
               echo " | <a href='contribution.php?acctno=" . @$acctno . "'>Contributions</a>";
               echo " | <a href='transactions.php?acctno=" . @$acctno . "'>Account Transactions</a>"; 
               #echo " | <a href='treasury.php?acctno=" . @$acctno . "'>Treasury</a>";
              }
              if ($_SESSION['access_lvl'] != 2)
              { 
               echo " | <a href='sundry.php?acctno=" . @$acctno . "'>Sundry</a>";
               #echo " | <a href='interbank.php?acctno=" . @$acctno . "'>Inter-Bank</a>";
               echo " | <a href='dailytrans.php?acctno=" . @$acctno . "'>My Daily Report</a>";
              }
             }
 ?>
</font>