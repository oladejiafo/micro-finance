<?php
require_once 'conn.php'; 

$yqry = "SELECT `Month`,`Done`,`Date` FROM `mtracker` Where `Month`='" . date('F') ."' and `Done`=1";
$yresult = mysqli_query($conn,$yqry);
#$yrow = mysqli_fetch_array($yresult);
$totyrows  = mysqli_num_rows($yresult);

if (date('d')==01 and $totyrows==0)
{
 $query = "SELECT `ID`,`Account Type`,`Account Number`,`Date Registered` FROM `customer`";
 $result=mysqli_query($conn,$query);
   
 while(list($id,$acct,$acctn,$rdate)=mysqli_fetch_row($result))
 {
   $query_ch = "SELECT `Type`,`Interest Rate`,`Effect` FROM `account type` Where `Type`='" . $acct ."'";
   $result_ch = mysqli_query($conn,$query_ch);
   $rowch = mysqli_fetch_array($result_ch);
   $irate=$rowch['Interest Rate'];
   $eff=$rowch['Effect'];
   $typ=$rowch['Type'];
   $acctnum=$acctn;
   if(!empty($irate) and $irate !=0)
   {
     $query_tr = "SELECT `Balance` FROM `transactions` Where `Balance` > 0 and `Account Number`='$acctnum' order by `ID` Desc";
     $result_tr = mysqli_query($conn,$query_tr);
     $row_tr = mysqli_fetch_array($result_tr);
     $ball=$row_tr['Balance'];

     if($eff=='Addition')
     {
       $intr=($ball*$irate)/100;
       $bal=$ball+$intr;

       $query_ins = "Insert into `transactions` (`Account Number`,`Deposit`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctnum','" . $intr . "','" . date('Y-m-d') . "','Interest','','$bal')";
       $result_ins = mysqli_query($conn,$query_ins);

       $query_chs = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Expenditure','Interest Paid','" . date('Y-m-d') . "','Interest paid on $typ account','$intr','to $acctnum')";
       $result_chs = mysqli_query($conn,$query_chs);

     } else if($eff=='Deduction') {
       if ($acct=='Diamond')
       {
         $dat=date('Y-m-d') - $rdate;
        if ($dat>1) 
        {
          $intr=1;
        }
       } else {
        $intr=($ball*$irate)/100;
       }
       $bal=$ball-$intr;

       $query_ins = "Insert into `transactions` (`Account Number`,`Withdrawal`,`Date`,`Transaction Type`,`Remark`,`Balance`) 
                  VALUES ('$acctn','$intr','" . date('Y-m-d') . "','Monthly Charges','','$bal')";
       $result_ins = mysqli_query($conn,$query_ins);

       $query_chs = "Insert into `cash` (`Type`,`Classification`,`Date`,`Particulars`,`Amount`,`Remark`) 
                  VALUES ('Income','Charges','" . date('Y-m-d') . "','Monthly Charges Deducted on $acct account','$intr','from $acctnum')";
       $result_chs = mysqli_query($conn,$query_chs);
     }
   }
 }
 #$mt=date('d F, Y',strtotime(date('Y-m-d')));
 $mt=date('F');
 $qry = "Insert into `mtracker` (`Month`,`Done`,`Date`) 
                  VALUES ('$mt',1,'" . date('Y-m-d') . "')";
 $res = mysqli_query($conn,$qry);
}
#header("location:index.php?tval=$tval&redirect=$redirect");
?>