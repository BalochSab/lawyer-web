<?php 
   

   if (isset($_SESSION['userType'])) {

       include("connection.php");
       $client_id = $_SESSION['user_id'];
       $sql_Appint = "";
// ------this is for client appointment list
    if ($_SESSION['userType']=='client') {

        $sql_Appint = "SELECT booking_id,user_name,date,time,status from appointment
        INNER JOIN user on lawyer_id=user_id where client_id=$client_id ";  

// ------this is for client appointment list
    }else if ($_SESSION['userType']=='lawyer') {

        $sql_Appint = "SELECT booking_id,user_name,date,time,status from appointment
        INNER JOIN user on client_id=user_id where lawyer_id=$client_id "; 
    }

    $runappoint = mysqli_query($con,$sql_Appint) or die(mysqli_error($con));

    include("header.php");
?>
<br><br><br>
<div class="content container">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Appointments</h4>
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
                                        <th>Lawyer Name</th>
                                        <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        <th>Status</th>
                                        <th>Action</th>  
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    
                                    if (mysqli_num_rows($runappoint) > 0) {
                                        while($fatchAp = mysqli_fetch_assoc($runappoint)){
                                    ?>
									<tr>
										<td><?php echo $fatchAp['booking_id']; ?></td>										
										<td><?php echo $fatchAp['user_name']; ?></td>
										<td><?php echo $fatchAp['date']; ?></td>
										<td><?php echo $fatchAp['time']; ?></td>

                                        <?php echo '<td>';
                                        //this is for client status only!
                                        if ($_SESSION['userType']=='client') {

                                            //if appointment date become past then automatically Canceled here
                                            $date_now = date("d/m/Y");
                                            
                                            if ($date_now > $fatchAp['date']) {
                                                
                                                $sql_cancel = "UPDATE appointment SET status = 'canceled' WHERE booking_id = {$fatchAp['booking_id']}";
                                                $run_cancle = mysqli_query($con,$sql_cancel);
                                            }
                                                
                                            if($fatchAp['status']=='pending'){echo "<p class='text-warning'>".$fatchAp['status']."</p>";}
                                            else if($fatchAp['status']=='accepted'){ echo "<p class='text-success'>".$fatchAp['status']."</p>";}
                                            else{ echo "<p class='text-danger'>".$fatchAp['status']."</p>";} 
                                            echo '</td>';
                                        }
                                        //this is for client update and cancel btn where status is pending or 
                                        if ($_SESSION['userType']=='client' &&  $fatchAp['status']=='pending')  {

                                            echo '<td class="text-right">
													<a class="btn btn-info" href="appointmentUpdate.php?app_id='.$fatchAp['booking_id'].'" ><i class="fa fa-trash-o m-r-5"></i> Update</a>
													<a class="btn btn-danger" href="deleteapp.php?app_id='.$fatchAp['booking_id'].'" ><i class="fa fa-trash-o m-r-5"></i> Cancel</a>
                                                    </td>';

                                            }
										
                                        echo "</tr>";
                                     } 
                                     ?>
									
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>

<?php }
}else {
    header("Location:login.php");
}
?>