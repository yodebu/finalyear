<?php
session_start();
if(isset($_GET['rid']) && $_GET['rid']!='' && $_SESSION['nits_rec_admin']) {

$dir_c = $_SERVER['DOCUMENT_ROOT']."/certificates";
$file = $dir_c . "/" . $_GET['rid'];
echo "List of certificates uploaded by applicant on the server are as ( NON-FACULTY ) : &nbsp; &nbsp; <a href='logout.php'>Logout</a><br/><ul>";
$f = "../non_faculty/certificates/" . $_GET['rid'];
foreach (glob("$f*.*") as $filename) {
    echo "<li><a href='$filename'>$filename</a><br/></li>";
}
}
else
	header("location:index.php");
?>