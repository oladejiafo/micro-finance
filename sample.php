<?php
// include SMTP Email Validation Class
require_once('smtp_validateEmail.class.php');

// the email to validate
$email = 'dejiafolabi@outlook.com';
// an optional sender
$sender = 'dejigegs@gmail.com';
// instantiate the class
$SMTP_Validator = new SMTP_validateEmail();
// turn on debugging if you want to view the SMTP transaction
$SMTP_Validator->debug = false;
// do the validation
$results = $SMTP_Validator->validate(array($email), $sender);
// view results
echo $email.' '.($results[$email] ? 'Exists' : 'does not Exist')."\n";

// send email? 
if ($results[$email]) {
 # //mail($email, 'Confirm Email', 'Please reply to this email to confirm', 'From:'.$sender."\r\n"); // send email
 # echo '...The email addresses you entered is valid';
} else {
 # echo '...The email addresses you entered is not valid';
}

?>