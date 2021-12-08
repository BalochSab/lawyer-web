<?php

if ($_SESSION["userType"]=="admin") {

    include("../connection.php");
    
    $sql_client = "SELECT user_id,user_name,mobile,email FROM user WHERE userType = 'client'";

    $run_client = mysqli_query($con, $sql_client) or die("query field" . mysqli_error($con));
    

    include("header.php");
?>
    <br><br><br>
    <div class="content container">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">All Clinets</h4>
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
                                <th>Client ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // if (mysqli_num_rows($run_client) > 0) {
                                while ($fatchAp = mysqli_fetch_assoc($run_client)) {
                            ?>
                                    <tr>
                                        <td><?php echo $fatchAp['user_id']; ?></td>
                                        <td><?php echo $fatchAp['user_name']; ?></td>
                                        <td><?php echo $fatchAp['email']; ?></td>
                                        <td><?php echo $fatchAp['mobile']; ?></td>
                                        <td>
                                            <a class="btn btn-danger" href="deleteappoint.php?client_id=<?php echo $fatchAp['user_id'];?>" >
                                                <i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </td>
                                        
                                    </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php 
} else {
    header("Location:login.php");
}
?>