<?php
session_start();
if (isset($_SESSION['userType'])) {
    
    if ($_SESSION['userType']=='lawyer') {
        header("location:lawyerpanel.php");
    }else if($_SESSION['userType']=='client'){
        header("location:index.php");
    }else if($_SESSION['userType']=='admin'){
        header("location:index.php");
    }
    
}else{
include_once("header.php");
include("connection.php");
$err = array('username' => '', 'pass' => '', 'wrong' => '');
$user = $pass ='';

if (isset($_POST['login'])) {

    $check = true;
    if (empty($_POST["user_name"])) {
        $err['username'] = "User Name is required!";
        $check = false;
    } else {
        $user = htmlspecialchars($_POST["user_name"]);
    }
    if (empty($_POST["user_pass"])) {
        $err["pass"] = "Password is required!";
        $check = false;
    } else {
        $pass = htmlspecialchars($_POST["user_pass"]);
    }
    if ($check) {
        $sql_check = "SELECT user_id, user_name, userType FROM user WHERE password = '{$pass}' AND user_name = '{$user}' OR email = '{$user}'";
        $result = mysqli_query($con, $sql_check) or die(mysqli_error($con));
        if (mysqli_num_rows($result) > 0) {

            echo mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);

            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["user_name"];
            $_SESSION["userType"] = $row["userType"];

            if ($_SESSION['userType'] == 'admin') {

                header("Location:admin/index.php");

            } else if ($_SESSION['userType'] == 'client') {

                header("Location:index.php");

            } else if ($_SESSION['userType'] == 'lawyer') {
                $user='';
                $pass = '';//form get empty fields
                header("Location:lawyerpanel.php");

            } else {
                $err['wrong'] = "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i>Username or Password is incorrect!</div>";
            }
        } else {
            $user = $pass = '';
            $err['wrong'] = "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i>Username or Password is incorrect!</div>";
        }
    }
}

?>

<div class="main-wrapper account-wrapper">
    <div class="account-page">
        <div class="account-center">
            <div class="account-box">
                <form action="" method="POST" class="form-signin">
                <?php echo $err['wrong'];?>
                    <div class="account-logo">
                        <a href="index.php"><img src="assets/img/logo1.png" alt=""></a>
                        <h3>Lawyer Web</h3>
                    </div>
                    <div class="form-group">
                        <label>Username or Email</label>
                        <input type="text" autofocus="" name="user_name" class="form-control">
                        <div class="text-danger"><?php echo $err['username']; ?></div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="user_pass" class="form-control">
                        <div class="text-danger"><?php echo $err['pass']; ?></div>
                    </div>
                    
                    <div class="form-group text-center">
                        <button type="submit" name="login" class="btn btn-primary account-btn">Login</button>
                    </div>
                    <div class="text-center register-link">
                        Don’t have an account? <a href="" data-toggle="modal" data-target="#delete_appointment">Register Now</a>
                    </div>
                </form>
            </div>
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

<?php include_once("footer.php"); }?>