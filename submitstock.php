<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2))
{
 if ($_SESSION['access_lvl'] != 1){
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
}

 $id = $_POST["id"];
 $code = $_POST["code"];
 $category = $_POST["category"];
 $brandname = $_POST["brandname"];
 $stockname = $_POST["stockname"];
 $description = $_POST["description"];
 $manufacturer = $_POST["manufacturer"];
 $supplier = $_POST["supplier"];
 $location = $_POST["location"];
 $unitcost = $_POST["unitcost"];
 $sellingprice = $_POST["sellingprice"];
 $expirydate = $_POST["expirydate"];
 $reorderlevel = $_POST["reorderlevel"];
 $stockunit = $_POST["stockunit"];
 $weight = $_POST["weight"];

 require_once 'conn.php';
 
 if (isset($_POST['submit']))
 {
   switch ($_POST['submit'])
   {
     case 'Update':
      if (Trim($code) != "")
      {
        $query_update = "UPDATE stock SET `Stock Code` = '$code',`Category`='$category', `Brand Name`='$brandname',`Stock Name`='$stockname',
          `Description`='$description', `Manufacturer`='$manufacturer',`Supplier`='$supplier',`Location`='$location',`Weight`='$weight'
          ,`Unit Cost`='$unitcost',`Expiry Date`='$expirydate',`Reorder Level`='$reorderlevel',`Units in Stock`='$stockunit'
          ,`Selling Price`='$sellingprice' WHERE `ID` = '$id'";

        $result_update = mysql_query($query_update);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_update_Log = "Insert into `Monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Stock Record','Modified Stock Record for Stock: " . $code . ", " . $stockname . "')";

            $result_update_Log = mysql_query($query_update_Log);
            ###### 

        $tval="Your record has been updated.";
        header("location:stocklist.php?code=$code&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Stock Code before updating.";
        header("location:stock.php?code=$code&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Save':
      if (Trim($code) != "")
      { 
        $query_insert = "Insert into stock (`Stock Code`,`Category`, `Brand Name`,`Stock Name`,`Description`, `Manufacturer`,`Supplier`,`Location`,
                `Weight`,`Unit Cost`,`Expiry Date`,`Reorder Level`,`Units in Stock`,`Selling Price`) 
               VALUES ('$code','$category', '$brandname','$stockname','$description', '$manufacturer','$supplier','$location','$weight'
                 , '$unitcost','$expirydate','$reorderlevel','$stockunit','$sellingprice')";

        $result_insert = mysql_query($query_insert);

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_insert_Log = "Insert into `Monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Stock Record','Added Stock Record for Stock: " . $code . ", " . $stockname . "')";

            $result_insert_Log = mysql_query($query_insert_Log);
            ###### 

        $tval="Your record has been saved.";
        header("location:stocklist.php?code=$code&tval=$tval&redirect=$redirect");
      }
      else
      {
        $tval="Please enter Stock Code before saving.";
        header("location:stock.php?code=$code&tval=$tval&redirect=$redirect");
      }
      break;
     case 'Delete':
      {
       $query_delete = "DELETE FROM stock WHERE `ID` = '$id';";

       $result_delete = mysql_query($query_delete);          

            #######
            $sql = "SELECT * FROM cms_access_levels Where access_lvl='" . $_SESSION['access_lvl'] ."'";
            $result = mysql_query($sql,$conn);
            $rows = mysql_fetch_array($result);

            $query_delete_Log = "Insert into `Monitor` (`User Category`, `User Name`,`Date Logged on`, `Time Logged on`,`File Used`,`Details`) 
                  VALUES ('" . $rows['access_name'] . "','" . ucfirst($_SESSION['name']) . "', '" . date('Y/m/d') . "', '" . date('h:i A') . "','Stock Record','Deleted Stock Record for Stock: " . $code . ", " . $stockname . "')";

            $result_delete_Log = mysql_query($query_delete_Log);
            ###### 

        $tval="Your record has been deleted.";
        header("location:stocklist.php?code=$code&tval=$tval&redirect=$redirect");
      }
      break;     
     case 'Issue Book':
      {

        header("location:stock.php?code=$code&tval=$tval&redirect=$redirect");
      }
      break;     
   }
 }
?>