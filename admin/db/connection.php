<?php
include "config.php";



function attempt_connection($db_name) {
	connect_db($db_server, $db_username, $db_password, $db_name);
}



function connect_db($db_server,$db_username,$db_password,$db_name) {
	
	$database = mysqli_select_db($conn4, $db_name);
		if($database)
			return 1;
		else
			create_db($conn4, $db_name);
			return 1;
	
}

function create_db($conn4, $db_name) {
	$query = "CREATE DATABASE IF NOT EXISTS ".$db_name;
	$result = mysqli_query($conn4, $query) or die(mysqli_connect_error());
	$password = md5(SHA1('nitd_rec@123'));
	$query1 = "CREATE TABLE IF NOT EXISTS ".$db_name.".admin (id int(2) NOT NULL auto_increment, username varchar(40) NOT NULL DEFAULT 'admin', password varchar(255) NOT NULL DEFAULT '".mysqli_real_escape_string($conn4," ")."', PRIMARY KEY (id))";
	$result1 = mysqli_query($conn4, $query1) or die(mysqli_connect_error());
	mysqli_select_db($conn4, $db_name);
	$query2 = "INSERT INTO admin (id) VALUES('1')";
	$result2 = mysqli_query($conn4, $query2) or die(mysqli_connect_error());
}


create_db($conn4, 'Rahim');

?>
