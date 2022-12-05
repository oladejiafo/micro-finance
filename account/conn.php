<?php
define('SQL_HOST','localhost');
define('SQL_USER','root');
define('SQL_PASS','');
define('SQL_DB','mfb');
$conn = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASS) or die('Could not connect to the database; ' . mysqli_error());
mysqli_select_db($conn,SQL_DB) or die('Could not select database; ' . mysqli_error());
?>