
<?php 
include("navbar.php");
if (isset($_SESSION['userType'])) {

        include("connection.php");
        $client_id = $_SESSION["user_id"];
        $client_name = $_SESSION["username"];
        //there are error variables
        $errorDate = $errorTime = $errorfinal = $date_now ='';
        
        $date = $time = $app_id = $lawyer_id = $lawyer_name = $service = '';

        // -----This is for update appointment-----
        if (isset($_GET['app_id'])) {

            $app_id = $_GET['app_id'];
            $sql_update = "SELECT user_id, user_name,service_name, date ,time FROM user 
            inner join appointment on user.user_id=appointment.lawyer_id 
            inner join user_details on user.user_id=user_details.user_fk_id 
            INNER JOIN servicelist on user_details.service_id=servicelist.service_id 
            WHERE booking_id=$app_id;";

            $run_update = mysqli_query($con,$sql_update);

            $fatch_upd = mysqli_fetch_assoc($run_update);

            $lawyer_id = $fatch_upd["user_id"];
            $lawyer_name = $fatch_upd['user_name'];
            $service = $fatch_upd['service_name'];
            $oldDate = $fatch_upd['date'];
            $oldTime = $fatch_upd['time'];

        }
        // ----------End for update appointment------

        if (isset($_POST['submit'])) {
            $error = true;
            if (empty($_POST["time"])) {
                $errorTime =' <div class="text-danger">Time is not selected</div>';
                $error = false;
            }else {
                $time = $_POST["time"];
            }
            if (empty($_POST["date"])) {
                $errorDate = "<div class='text-danger'>Date is not selected</div>";
                $error = false;
            } else {
                $date_now = date("d/m/Y");
                if ($date_now < $_POST["date"]) {
                    $date  = $_POST["date"];
                }else{
                    $errorDate = "<div class='text-danger'>Date is not valide or
                    You can make an appointment the day before! {$_POST['date']} == {$date_now}</div>";
                    $error = false;
                }
                
            }

            if ($error==true) {

                $already= "SELECT count(booking_id) FROM appointment WHERE date='$date' and time = '$time' and lawyer_id= '$lawyer_id';";
                
                $run_already = mysqli_query($con,$already) or die("sql query error".mysqli_error($con));

                $rows = mysqli_fetch_array($run_already);

                if ($rows[0] > 0) {
                        
                    $errorfinal = "<div class='alert alert-danger'><p>Sorry! Appointment Already booked on this Date & time!
                                    Please change date or time.</div>";
                }else {
                   
                    $sql_upd = "UPDATE  appointment SET date = '$date' ,time = '$time' WHERE booking_id = $app_id";
                    $result = mysqli_query($con, $sql_upd) or die(mysqli_error($con)) ;

                    if ($result) {
                        header("Location:Profile.php");
                    } else {
                        
                        $errorfinal = "<div class='alert alert-danger'>Sorry Form not Updated Successfully! There is mistake with your Selection Try later Please!</div>";
                    }
                    
                }
            } 
        }
         include("header.php");
?>
<br>
<div class="content container ">
                <div class="row">
                    
                </div>
                <br><br>
                <div class="row jumbotron">
                    <div class="col-lg-12 offset-lg-2">
                        <h1 class="page-title ">Appointment</h1>
                    </div>
                <?php echo "<div class='col-lg-12 text-center'>".$errorfinal."</div>";?>
                    <div class="col-lg-8 offset-lg-2">

                        <form method="POST" action="">
                            <div class="row">
                            
                                <div class="col-md-6">
									<div class="form-group">
										<label>Client Id</label>
                                        
                                        <h3><?php echo $client_id;?></h3>
									</div>
                                </div>
                                <div class="col-md-6">
									<div class="form-group">
										<label>Client Name</label>
                                        
                                        <h3><?php echo $client_name;?></h3>
									</div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6">
									<div class="form-group">
										<label>Lawyer Name</label>
                                        
                                        <h3><?php echo $lawyer_name;?></h3>
									</div>
                                </div>
                                <div class="col-md-6">
									<div class="form-group">
										<label>Speciality</label>
                                        
                                        <h3><?php echo $service;?></h3>
									</div>
                                </div>
                            </div>
                            <div class="row border bg-dark text-white mb-1">
                                
                                <div class="col-md-6">
									<div class="form-group">
										<label class="text-red">Old Date</label>
                                        
                                        <h3><?php echo $oldDate;?></h3>
									</div>
                                </div>
                                <div class="col-md-6">
									<div class="form-group">
										<label class="text-red">Old Time</label>
                                        
                                        <h3><?php echo $oldTime;?></h3>
									</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <div class="cal-icon">
                                            <input type="text" name="date" class="form-control datetimepicker" >
                                        </div>
                                        <?php echo $errorDate;?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                        <label>Time</label>
                                        <select class="select select2-hidden-accessible" name="time" tabindex="-1" aria-hidden="true">
											<option value="">Select Time</option>
											<option value="9am-10am" >9am - 10am</option>
											<option value="10am-11am">10am - 11am</option>
											<option value="11am-12pm">11am - 12pm</option>
											<option value="1pm-2pm" >1pm - 2pm</option>
                                        </select>
                                        <?php echo $errorTime;?>
                                    </div>

                                    
                                </div>
                            </div>
                            
                            <div class="m-t-20 text-center">
                                <button type="update" name="submit" class="btn btn-warning submit-btn">Edit Appointment</button>
                                <a href="Profile.php" class="btn btn-danger submit-btn">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

<?php
include_once("footer.php");
 }else {
    header("Location:login.php");
}
?>