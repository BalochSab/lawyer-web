<div class="header">
    <!-- Page logo -->
    <div class="header-left">
        <a href="index.php" class="logo">
            <img src="assets/img/logo1.png" width="35" height="35" alt=""> 
            <span>Lawyerweb</span>
            <!-- <span class="ml-5">Home</span> -->

        </a>
        
    </div>
    

    <?php session_start(); 
    if (isset($_SESSION["userType"])) {
        $type = $_SESSION["userType"];
        ?>
        <!-- login and logout -->
        <ul class="nav user-menu float-right">
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                    <span class="user-img"><img class="rounded-circle" src="assets/img/user.jpg" width="40" alt="Admin">
                        <span class="status online"></span></span>
                    <span><?php echo $_SESSION["username"]?></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="Profile.php?userId=<?php echo $_SESSION["user_id"];?>">My Profile</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>

        <div class="dropdown mobile-user-menu float-right">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="Profile.php?userId=<?php echo $_SESSION["user_id"];?>">My Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
    <?php } else { ?>
        <!-- login and logout -->
        <ul class="nav user-menu float-right">
            <li class="nav-item ">
                <a href="login.php" class=" nav-link user-link">
                    <span class="user-img"><img class="rounded-circle" src="assets/img/user.jpg" width="40" alt="Admin">
                        <span class="status online"></span></span>
                    <span>Login</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="#" class=" nav-link user-link">
                    <span class="status online"></span></span>
                    <span href="#" data-toggle="modal" data-target="#delete_appointment"><i class="fa fa-sign-in m-r-5"></i> Sign Up</span>

                </a>
            </li>
        </ul>
        <div class="dropdown mobile-user-menu float-right">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="login.php">
                    <span class="user-img"><img class="rounded-circle" src="assets/img/user.jpg" width="40" alt="Admin">
                        <span class="status online"></span></span>
                    <span>Login</span>
                </a>
                <a class="dropdown-item" href=''>
                    <span class="user-img"><img class="rounded-circle" src="assets/img/user.jpg" width="40" alt="Admin">
                        <span class="status online"></span></span>
                    <span href="#" data-toggle="modal" data-target="#delete_appointment"><i class="fa fa-sign-in m-r-5"></i> Sign Up</span>

                </a>
            </div>
        </div>

</div>

<div id="delete_appointment" class="modal fade delete-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">

                <a href="lawyersignup.php" class="a">
                    <div class="col-md-6 col-sm-6 col-lg-12 col-xl-12">
                        <div class="dash-widget">
                            <span class="dash-widget-bg1"><i class="fa fa-cape" aria-hidden="true"></i></span>
                            <h2>As Lawyer</h2>
                            <div class="dash-widget-info text-right">
                                <span class="widget-title1">Lawyer <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="clientsignup.php" class="shadow">
                    <div class="col-md-6 col-sm-6 col-lg-12 col-xl-12">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2"><i class="fa fa-cape" aria-hidden="true"></i></span>
                            <h2>As Client</h2>
                            <div class="dash-widget-info text-right">
                                <span class="widget-title2">Client <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a></div>

            </div>
        </div>
    </div>
</div>

<?php } ?>