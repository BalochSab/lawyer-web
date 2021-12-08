<?php
include("navbar.php");

   
if (isset($_SESSION['userType'])) {

    include_once("header.php");

    include("connection.php");

    if (isset($_GET["userId"])) {
        $user_Id = $_GET["userId"];
    }else{
        $user_Id = $_SESSION['user_id'];
    }
    
    $sql = "SELECT user_id, user_name,userType,email,mobile,first_name,last_name,gender,dob,qualification,Biography,img,service_name,country_name,city_name FROM user 
        LEFT JOIN user_details ON user.user_id = user_details.user_fk_id 
        LEFT JOIN servicelist ON user_details.service_id = servicelist.service_id
        LEFT JOIN country ON user_details.country_id = country.country_id
        LEFT JOIN city ON  user_details.city_id = city.city_id WHERE user_id = $user_Id";

    $sql_date = mysqli_query($con, $sql) or die("query field" . mysqli_error($con));
    $find = mysqli_num_rows($sql_date);

    $show = mysqli_fetch_assoc($sql_date) or die("Fatch :" . mysqli_error($con));

    if (mysqli_num_rows($sql_date) > 0) {
        echo  '<br><br><br>
        
        <div class="content container">
                <div class="row">
                    <div class="col-sm-7 col-6">
                        <h4 class="page-title">Profile</h4>
                    </div>';
        if ($_SESSION['user_id'] == $show['user_id']) {

            if ($show['userType'] == 'client') {
                echo '<div class="col-sm-5 col-6 text-right m-b-30">
                    <a href="clientupdate.php" class="btn btn-primary btn-rounded">
                    <i class="fa fa-plus"></i> Edit Profile
                    </a>
                </div>';
            }else {
                echo '<div class="col-sm-5 col-6 text-right m-b-30">
                    <a href="editProfile.php" class="btn btn-primary btn-rounded">
                    <i class="fa fa-plus"></i> Edit Profile
                    </a>
                </div>';
            }
            
        } ?>

        </div>
        <div class="card-box profile-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        
                        <?php if ($show['userType'] == 'lawyer') { ?>
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                <img class="avatar" src="assets/img/upload/<?php echo $show['img']; ?>" alt="">
                            </div>        
                        </div>
                        <?php } ?>

                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0"><?php echo $show['user_name']; ?></h3>
                                        <?php 
                                        if ($show['userType'] == 'lawyer') {
                                            echo  '<small class="text-muted">Specialist : '. $show['service_name'].'</small>';
                                        }
                                            if ($_SESSION['user_id'] != $show['user_id']) { 
                                                echo '<p>
                                                <div class="staff-msg btn btn-primary"><a href="getAppointment.php?lawyer_id='.$show['user_id'].'&lawyer_name='.$show['user_name'].'&service='.$show['service_name'].'" class="btn btn-primary">Get Appointment</a></div>
                                            </p>';
                                         }?>

                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <span class="title">Email:</span>
                                            <span class="text"><?php echo $show['email']; ?></span>
                                        </li>
                                        <li>
                                            <span class="title">Phone:</span>
                                            <span class="text"><?php echo $show['mobile']; ?></span>
                                        </li>
                                        
                                        <?php 
                                        if ($show['userType'] == 'lawyer') {
                                        echo '
                                        <li>
                                            <span class="title">First Name:</span>
                                            <span class="text">'.$show['first_name'].'</span>
                                        </li>
                                        <li>
                                            <span class="title">Last Name:</span>
                                            <span class="text">'.$show['last_name'].'</span>
                                        </li>
                                        <li>
                                            <span class="title">Birthday:</span>
                                            <span class="text">'.$show['dob'].'</span>
                                        </li>
                                        <li>
                                            <span class="title">Gender:</span>
                                            <span class="text">'.$show['gender'].'</span>
                                        </li>';
                                        } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php if ($show['userType'] == 'lawyer') { ?>
        <div class="profile-tabs">
            <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#about-cont" data-toggle="tab">About</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="about-cont">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <h3 class="card-title">Short Biography</h3>
                                <div class="experience-box">
                                    <ul class="experience-list">
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content">
                                                <div class="timeline-content">

                                                    <?php echo $show['Biography']; ?>

                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php }else{ 
    //    echo  "<div>";
        include("appointmentlist.php");
    //    echo "</div>
           echo  "</div>";
    
    

}

    }
    include("footer.php");
} else {

    header("location:login.php");
}
?>