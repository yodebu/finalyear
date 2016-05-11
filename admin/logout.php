<?php
session_start();
unset($_SESSION['nitd_rec_admin']);
session_destroy();
header("location:index.php");
?>
