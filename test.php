<?php
$url = 'http://localhost/bank/call.php';
$http = new HttpRequest($url, HttpRequest::METH_POST);

$http->setOptions(array(
    'timeout' => 10,
    'redirect' => 4
));
$http->addPostFields(array(
    'firstData' => 'myData',
    'secondData' => 'myDataTwo'
));
$http->addPostFields(array(
    'thirdData' => 'myData',
    'nextData' => 'myDataTwo'
));
$response = $http->send();
echo $response->getBody();
?>