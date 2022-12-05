<?php
###########INFOBID###########
$phon="2348122932455";
$coy="WG";
$name="Ola";
$trax="Credited";
$dacct=500;
$msalt="ALERT: " . $name . ", Your account " . $dacct . " has been " . $trax . " with N" . $amount . ". Descr: By " . $byy . ", for " . $remark . ". Your account balance is N" . $bal . ". Date: " . $date;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.infobip.com/sms/1/text/single",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{ \"from\":\"InfoSMS\", \"to\":\" .$phon. \", \"text\":\"Test SMS.\" }",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Basic V2FsdGVyZ2F0ZXM6b2xhZ2Vncw==",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}


?>