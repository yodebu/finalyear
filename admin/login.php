<?php
require_once "db/connection.php";

attempt_connection("nitd_recruitment_admin");

function text($data) {
	$data = trim($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($data);
	return $data;
}

function attempt_login($username,$password) {
		
		$username = text($username);
		$password = md5(SHA1(text($password)));
		$query = "SELECT * FROM admin WHERE username='".$username."' AND password='".$password."' ";
		$result = mysqli_query($conn4, $query) or die(mysqli_error($conn4));
		if(mysqli_num_rows($result))
			return 1;
		else
			return 0;
		
}
if(isset($_POST['a']) && isset($_POST['e'])) {

	if(attempt_login($_POST['a'],$_POST['e'])) {
		session_start();
		$_SESSION['nitd_rec_admin']='nitd_rec_admin';
		die("Login successful");
	}
	else
		die("Invalid Username and Password combination");

}
else
	die("Username or Password field is empty");
?>
