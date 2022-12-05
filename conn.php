<?php
define('SQL_HOST','localhost');
define('SQL_USER','mydb');
define('SQL_PASS','mydb');
define('SQL_DB','mfb');
$conn = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASS) or die('Could not connect to the database; ' . mysql_error());
mysqli_select_db($conn,SQL_DB) or die('Could not select database; ' . mysql_error());
