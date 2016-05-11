<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'admin';
$dbname = 'nitd_recruitment';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(mysqli_select_db($conn , $dbname))
{
}
else
{
	$q = "CREATE DATABASE nitd_recruitment" or die(mysql_error());
	$r = mysqli_query($conn, $q) or die(mysqli_error());
	echo "Database nitd_recruitment created successfully<br/>";
}
?>
