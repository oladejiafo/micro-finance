<?php
session_start();
//check to see if user has logged in with a valid password
if (!isset($_SESSION['USER_ID']) & ($_SESSION['access_lvl'] != 2))
{
$redirect = $_SERVER['PHP_SELF'];
header("Refresh: 5; URL=login.php?redirect=$redirect");
echo "Sorry, but you don’t have permission to view this page! You are being redirected to the login page!<br>";
echo "(If your browser doesn’t support this, " .
"<a href=\"login.php?redirect=$redirect\">click here</a>)";
die();
}
 require_once 'conn.php';
 require_once 'header.php';
 require_once 'style.php';
?>
	<body>
	<form method="post" action="admin_transact.php">
        <b><u>
	   <font face="Verdana" size="4" color="#008000" align="center">Mailing</font></u></b>
	<p>
	<strong>Choose Mailing List:</strong><br />
	<select name="ml_id">
	<option selected>All</option>
	<?php
	$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS)
	or die('Could not connect to MySQL database. ' . mysql_error());
	mysql_select_db(SQL_DB,$conn);
	$sql = "SELECT `email` FROM `login` ORDER BY email;";
	$result = mysql_query($sql)
	or die('Invalid query: ' . mysql_error());
	while ($row = mysql_fetch_array($result))
	{
	  echo " <option>" . $row['email']
	  . "</option>\n";
	}
	?>
	</select>
	</p>
	<p>
	<strong>Subject:</strong><br />
	<input type="text" name="subject" size=30 value="<Type Subject>" />
	</p>
	<p><strong>Message:</strong><br />
      <textarea name="msg" rows="5" cols="60" ></textarea>
</p>
	<p>
	  <input type="submit" name="action" value="Send Message" />
	</p>
	</form>
	<p>
	<a href="admin.php">Back to admin page</a>
	</p>
	</body>
	</html>