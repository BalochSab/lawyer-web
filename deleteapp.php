<?php
   include("navbar.php");
   
   if (isset($_SESSION['userType'])) {
    include("../connection.php");

        $app_id = $_GET['app_id'];
        $sql_delete = "DELETE FROM appointment WHERE booking_id = $app_id";
        $rundelete = mysqli_query($con,$sql_delete);
        if ($rundelete) {
            header("Location:index.php?app=appoint");
        } 
    }
    
    
    ?>