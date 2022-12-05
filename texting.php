<?php
########SMSLIVE247#######
/* Variables with the values to be sent. */

$owneremail="dauda.bashorun@gmail.com";
$subacct="IBBDS CONSULTING"; /*IBBDs Consulting*/
$subacctpwd="07053737888"; /*07039220512 */
$sendto="08023868198"; /* destination number */
$sender="IBBDS"; /* sender id */
$message="testing";
/* message to be sent */

$url = "http://www.smslive247.com/http/index.aspx?"
. "cmd=sendquickmsg"
. "&owneremail=" . UrlEncode($owneremail)
. "&subacct=" . UrlEncode($subacct)
. "&subacctpwd=" . UrlEncode($subacctpwd)
. "&sendto=" . UrlEncode($sendto)
. "&message=" . UrlEncode($message)
. "&sender=" . UrlEncode($sender);
/* call the URL */
$time_start = microtime(true);
if ($f = @fopen($url, "r"))
{
$answer = fgets($f, 255);
#echo "[$answer]";
}
else
{
#echo "Error: URL could not be opened.";
}
#   echo "<br>"  ;
$time_end = microtime(true);
$time = $time_end - $time_start;

#echo "Finished in $time seconds\n";
##########################
?>