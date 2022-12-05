<?php
require_once 'conn.php';
$sql="SELECT * FROM `customer` WHERE `Account Number`='01212345680'";
$result = mysqli_query($conn,$sql) or die('Could not look up user data; ' . mysqli_error());
$row = mysqli_fetch_array($result);
$phon=$row['Contact Number'];
$fname=$row['First Name'];
$sname=$row['Surname'];

$name= $fname . " " . $sname;

$request = new HttpRequest();
$request->setUrl('https://api.infobip.com/sms/1/text/single');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'accept' => 'application/json',
  'content-type' => 'application/json',
  'authorization' => 'Basic Q3VzaGl0ZTpXaXNkb20hMjAxNQ=='
));

$request->setBody('{
   "from":"WG",
   "to":"' . $phon . '",
   "text":"' . $name . ', Your account has been credited with N' . $amt . ' by ' . $byy . '"
}');

try {
  $response = $request->send();
  
  echo $response->getBody();
} catch (HttpException $ex) {
  #echo $ex;
}
?>