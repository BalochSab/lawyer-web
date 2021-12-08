<?php 

session_start();
session_destroy();
unset($_SESSION['userType']);
unset($_SESSION['user_id']);
unset($_SESSION['username']);

header("location:login.php");
?>