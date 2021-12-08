<?php
session_start();
if ($_SESSION["userType"]!="lawyer") {
    header("Location:login.php");
}else{
    
include("header.php");
    include("connection.php");
    $user_Id = $_SESSION['user_id'];
        $sql = "SELECT user_id, user_name,userType,email,mobile,first_name,last_name,gender,dob,qualification,Biography,img,service_name,country_name,city_name FROM user 
        LEFT JOIN user_details ON user.user_id = user_details.user_fk_id 
        LEFT JOIN servicelist ON user_details.service_id = servicelist.service_id
        LEFT JOIN country ON user_details.country_id = country.country_id
        LEFT JOIN city ON  user_details.city_id = city.city_id WHERE user_id = $user_Id";

    $sql_date = mysqli_query($con, $sql) or die("query field" . mysqli_error($con));
    $find = mysqli_num_rows($sql_date);

    $show = mysqli_fetch_assoc($sql_date) or die("Fatch :" . mysqli_error($con));

    if (mysqli_num_rows($sql_date) > 0) {
        ?>

<div class="main-wrapper">
    <div class="header">
        <div class="header-left">
            <a href="index-2.html" class="logo">
                <img src="assets/img/logo1.png" width="35" height="35" alt=""> <span>Lawyer_Web</span>
            </a>
        </div>
        <ul class="nav user-menu float-right">
            <li class="nav-item ">
                <a href="logout.php" class="nav-link btn-danger user-link">
                    <span>Logout</span>
                </a>
            </li>
        </ul>

    </div>

    <div class="sidebar" id="sidebar">

        <div id="sidebar-menu " class="sidebar-menu">
            <ul class="mt-3">
                <li class="menu-title text-center">
                    <div class="profile-img ">
                        <img class="avatar" src="./assets/img/upload/<?php echo $show['img'];?>" alt="">
                        <span ><?php echo $show['service_name'];?></span>
                    </div>
                </li>
                <hr>
                <li class="menu-title">Main</li>
                <li>
                    <a href="lawyerpanel.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="lawyerpanel.php?app=new"> <span>New Appionments</span></a>
                </li>
                <li>
                    <a href="lawyerpanel.php?app=acc"> <span>Accepted Appointments</span></a>
                </li>
                <li>
                    <a href="lawyerpanel.php?app=can"><span>Canciled Appointments</span></a>
                </li>

            </ul>
        </div>
        
    </div>
    <div class="page-wrapper p-5" style="min-height: 357px;">
    <?php
        if (isset($_GET['app']) && $_GET['app']=='new') {
            
            include('appointmentnew.php');
        }else if (isset($_GET['app']) && $_GET['app']=='acc') {
            
            include("appointmentAccepted.php");
        }else if ( isset($_GET['app']) && $_GET['app']=='can') {
            include("appointmentcanceled.php");

        }else if (isset($_GET['app']) && $_GET['app']=='edit') {
            include("lawyerupdate.php");
        }else {
        ?>
        <!-- here we show Profile of Lawyer -->
        
        <div class="content">
                <div class="row">
                    <div class="col-sm-7 col-6">
                        <h4 class="page-title">Profile</h4>
                    </div>

               <div class="col-sm-5 col-6 text-right m-b-30">
                    <a href="lawyerpanel.php?app=edit" class="btn btn-primary btn-rounded">
                    <i class="fa fa-plus"></i> Edit Profile
                    </a>
                </div>
        </div>
        <div class="card-box profile-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        
                        
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                <img class="avatar" src="assets/img/upload/<?php echo $show['img']; ?>" alt="">
                            </div>        
                        </div>
                        

                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0"><?php echo $show['user_name']; ?></h3>
                                            <small class="text-muted bolder "><?php echo $show['service_name'];?></small>
                                            <div class="staff-id">Employee ID : DR-<?php echo $show['user_id'];?></div><br>
                                            <div class="staff-id">Location :<?php echo $show['country_name']." ".$show['city_name'];?></div>

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
                                        <li>
                                            <span class="title">First Name:</span>
                                            <span class="text"><?php echo $show['first_name']?></span>
                                        </li>
                                        <li>
                                            <span class="title">Last Name:</span>
                                            <span class="text"><?php echo $show['last_name']?></span>
                                        </li>
                                        <li>
                                            <span class="title">Birthday:</span>
                                            <span class="text"><?php echo $show['dob']?></span>
                                        </li>
                                        <li>
                                            <span class="title">Gender:</span>
                                            <span class="text"><?php echo $show['gender']?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
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
<?php

   echo "</div>";
    
        }
    include("footer.php");
}
    
}
    ?>