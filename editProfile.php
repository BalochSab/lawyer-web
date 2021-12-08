<?php 

    session_start();
    if (isset($_SESSION["userType"])) {

        if ($_SESSION["userType"] =='client') {

            header("location:clientupdate.php");
        }

        if ($_SESSION["userType"] =='lawyer') {

            header("location:lawyerupdate.php");
        }
        
    }else{
        header("location:login.php");
    }


?>