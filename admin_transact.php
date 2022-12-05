<?php
 require('conn.php');

 if (isset($_POST['action']))
 {
   switch ($_POST['action'])
   {
     case 'Send Message':
      if ((isset($_POST['msg'])) and (isset($_POST['ml_id'])))
      {
       if ($_POST['ml_id'] != 'All')
       {
         $sql = "SELECT `email` FROM `login` WHERE `email`='" . $_POST['ml_id'] . "'";
         $result = mysql_query($sql,$conn) or die(mysql_error());
         $row = mysql_fetch_array($result);
         $headers = "From: info@fruitfultrust.com\r\n";
         $email = $row['email'];
         mail($email, stripslashes($_POST['subject']),$_POST['msg'],$headers) or die('Could not send e-mail.');
       }
       else
       {
         $sql = "SELECT `email` FROM `login`";
         $result = mysql_query($sql,$conn) or die(mysql_error());
         $headers = "From: info@fruitfultrust.com\r\n";
         while(list($email)=mysql_fetch_row($result))
         {
           mail($email, stripslashes($_POST['subject']),$_POST['msg'],$headers) or die('Could not send e-mail.');
         }
       }

      }
      break;
  }
 }
 header("location:admin.php?redirect=$redirect");
?>