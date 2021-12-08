<?php


if ($_SESSION["userType"]=="lawyer") {

    include("connection.php");
    $lawyer_id = $_SESSION['user_id'];
    
    $success_msg = "";
    $sql_Appint = "SELECT booking_id,user_name,date,time,status from appointment
        INNER JOIN user on client_id=user_id where lawyer_id=$lawyer_id And status = 'accepted' ";


    $runappoint = mysqli_query($con, $sql_Appint) or die(mysqli_error($con));

    if (isset($_POST['submit'])) {
        $stat = $_POST['stat'];
        $app_id = $_POST['app_id'];

        $sql_status_update = "UPDATE appointment SET status='$stat' WHERE booking_id = $app_id;";
        $run_status = mysqli_query($con,$sql_status_update);

        if ($run_status) {
            $success_msg = "<div class='alert alter-success'>Status Update Successfully</div>";
        }else{
            $success_msg = "<div class='alert alter-denger'>Status Update Faild!</div>";
        }
    }
    include("header.php");
?>
    <br><br><br>
    <div class="content container">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Accepted Appointments</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Client Name</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (mysqli_num_rows($runappoint) > 0) {
                                while ($fatchAp = mysqli_fetch_assoc($runappoint)) {
                            ?>
                                    <tr>
                                        <td><?php echo $fatchAp['booking_id']; ?></td>
                                        <td><?php echo $fatchAp['user_name']; ?></td>
                                        <td><?php echo $fatchAp['date']; ?></td>
                                        <td><?php echo $fatchAp['time']; ?></td>

                                        <?php echo '<td>';

                                        //if appointment date become past then automatically Canceled here
                                        $date_now = date("d/m/Y");

                                        if ($date_now > $fatchAp['date']) {

                                            $sql_cancel = "UPDATE appointment SET status = 'canceled' WHERE booking_id = {$fatchAp['booking_id']}";
                                            $run_cancle = mysqli_query($con, $sql_cancel);
                                        }

                                        //here select drowpdown for cancel or accept 

                                        if ($fatchAp['status'] == 'pending') {
                                            echo "<p class='text-warning'>" . $fatchAp['status'] . "</p>";
                                        } else if ($fatchAp['status'] == 'accepted') {
                                            echo "<p class='text-success'>" . $fatchAp['status'] . "</p>";
                                        } else {
                                            echo "<p class='text-danger'>" . $fatchAp['status'] . "</p>";
                                        }
                                        echo '</td>'; ?>
                                        
                                    </tr>
                                <?php }
                                ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

<?php }
                        } else {
                            header("Location:login.php");
                        }
?>