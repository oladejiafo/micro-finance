<?php
 $name = $_POST["name"];
 $phone = $_POST["phone"];
 $email = $_POST["email"];
 $comment = $_POST["comment"];
 
if (Trim($email) != "")
{
   $headers = "From: " . trim($email) . "\r\n";
   $headers .= "X-Mailer: BELLonline.co.uk PHP mailer \r\n";
   $message =$comment;
   $to="segunshokunbi@yahoo.com";
   imap_mail($to, 'Pyramid Feedback', $message, $headers);

/*
   $header = "From: info@thedevelopersdelight.com\r\n";
   $header .= "X-Mailer: BELLonline.co.uk PHP mailer \r\n";
   $message ="Thanks " . $name . ", for Contacting us. We will attend to your message as necessary shortly.\n";
   $tos=$email;
   mail($tos, 'Waltergates Feedback', $message, $header);*/
   header("location:index.php?redirect=$redirect");
}
?>